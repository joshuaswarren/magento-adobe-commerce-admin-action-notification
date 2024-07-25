<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Creatuity\AdminActionNotification\Api\Data\ChannelInterfaceFactory;;
use Creatuity\AdminActionNotification\Model\Config\AdminNotificationConfig;

class GetSelfNotificationChannel
{
    public function __construct(
        private readonly AdminNotificationConfig $adminNotificationConfig,
        private readonly ChannelInterfaceFactory $channelFactory
    ) {
    }

    public function get(): ChannelInterface
    {
        return $this->channelFactory->create(['data' => [
            ChannelInterface::CHANNEL_ID => 0,
            ChannelInterface::CHANNEL_TYPE => $this->adminNotificationConfig->getNotificationChannelType(),
            ChannelInterface::CHANNEL_VALUE => $this->adminNotificationConfig->getNotificationChannelValue(),
            ChannelInterface::UNIQUE_NAME => 'system-' . time(),
        ]]);
    }
}