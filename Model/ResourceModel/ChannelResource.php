<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\ResourceModel;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ChannelResource extends AbstractDb
{
    public const TABLE_NAME = 'creatuity_admin_notification_channel';

    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, ChannelInterface::CHANNEL_ID);
    }
}
