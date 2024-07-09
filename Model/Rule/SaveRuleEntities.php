<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule;

use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Magento\Framework\App\ResourceConnection;

class SaveRuleEntities implements SaveRuleActionInterface
{
    public function __construct(
        private readonly ResourceConnection $resourceConnection
    ) {
    }

    public function execute(RuleInterface $rule): void
    {
        $conn = $this->resourceConnection->getConnection();
        $table = $conn->getTableName('creatuity_admin_notification_rule_entity');
        $conn->delete($table, $conn->quoteInto('rule_id = ?', $rule->getRuleId()));
        $insertData = [];
        foreach ($rule->getEntities() as $entity) {
            $insertData[] = ['rule_id' => $rule->getRuleId(), 'entity' => $entity];
        }
        $conn->insertMultiple($table, $insertData);
    }
}