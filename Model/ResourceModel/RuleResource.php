<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\ResourceModel;

use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class RuleResource extends AbstractDb
{
    public const TABLE_NAME = 'creatuity_admin_notification_rule';

    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, RuleInterface::RULE_ID);
    }
}
