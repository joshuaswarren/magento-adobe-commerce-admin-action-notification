<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule;

use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Magento\Framework\App\ResourceConnection;

class SaveRuleChannels implements SaveRuleActionInterface
{
    public function __construct(
        private readonly ResourceConnection $resourceConnection
    ) {
    }

    public function execute(RuleInterface $rule): void
    {
        $conn = $this->resourceConnection->getConnection();
        $table = $conn->getTableName('creatuity_admin_notification_rule_channel');
        $conn->delete($table, $conn->quoteInto('rule_id = ?', $rule->getRuleId()));
        $insertData = [];
        foreach ($rule->getChannels() as $channelId) {
            $insertData[] = ['rule_id' => $rule->getRuleId(), 'channel_id' => $channelId];
        }
        $conn->insertMultiple($table, $insertData);
    }
}