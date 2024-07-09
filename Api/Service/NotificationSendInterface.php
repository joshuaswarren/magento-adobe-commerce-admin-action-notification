<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Api\Service;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Creatuity\AdminActionNotification\Api\Data\NotificationDataInterface;

interface NotificationSendInterface
{
    /**
     * @param NotificationDataInterface[] $notifications
     * @param ChannelInterface $channel
     * @return bool
     * @throws \Exception
     */
    public function send(array $notifications, ChannelInterface $channel): bool;

    /**
     * @param string $header
     * @param string[] $texts
     * @param ChannelInterface $channel
     * @return bool
     */
    public function sendCustom(string $header, array $texts, ChannelInterface $channel): bool;
}