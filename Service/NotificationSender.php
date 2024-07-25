<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Service;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Creatuity\AdminActionNotification\Api\Service\NotificationSendInterface;

class NotificationSender implements NotificationSendInterface
{
    /**
     * @param NotificationSendInterface[] $senders
     */
    public function __construct(
        private readonly array $senders = []
    ) {
    }

    public function send(array $notifications, ChannelInterface $channel): bool
    {
        $channelType = $channel->getChannelType();

        if (!isset($this->senders[$channelType])
            || !$this->senders[$channelType] instanceof NotificationSendInterface) {
            throw new \Exception('Cannot send notifications. Unsupported channel type ' . $channelType);
        }

        return $this->senders[$channelType]->send($notifications, $channel);
    }

    public function sendCustom(string $header, array $texts, ChannelInterface $channel): bool
    {
        $channelType = $channel->getChannelType();

        if (!isset($this->senders[$channelType])
            || !$this->senders[$channelType] instanceof NotificationSendInterface) {
            throw new \Exception('Cannot send notifications. Unsupported channel type ' . $channelType);
        }

        return $this->senders[$channelType]->sendCustom($header, $texts, $channel);
    }
}