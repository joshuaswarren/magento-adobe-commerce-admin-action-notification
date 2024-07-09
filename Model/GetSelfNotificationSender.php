<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model;

use Creatuity\AdminActionNotification\Api\Service\NotificationSendInterface;
use Creatuity\AdminActionNotification\Model\Config\AdminNotificationConfig;

class GetSelfNotificationSender
{
    /**
     * @param AdminNotificationConfig $adminNotificationConfig
     * @param NotificationSendInterface[] $senders
     */
    public function __construct(
        private readonly AdminNotificationConfig $adminNotificationConfig,
        private readonly array $senders = []
    ) {
    }

    public function get(): NotificationSendInterface
    {
        $channleType = $this->adminNotificationConfig->getNotificationChannelType();
        if (!isset($this->senders[$channleType])) {
            throw new \Exception('Unsupported channel type ' . $channleType);
        }

        return $this->senders[$channleType];
    }
}