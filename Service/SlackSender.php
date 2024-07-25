<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Service;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Creatuity\AdminActionNotification\Api\Service\NotificationSendInterface;
use Creatuity\AdminActionNotification\Model\Slack\GenerateMessageBlocks;
use Creatuity\AdminActionNotification\Model\Slack\PostMessage;
use Magento\Framework\Serialize\Serializer\Json;
use Psr\Log\LoggerInterface;

class SlackSender implements NotificationSendInterface
{
    public function __construct(
        private readonly GenerateMessageBlocks $generateMessage,
        private readonly PostMessage $postMessage,
        private readonly Json $json,
        private readonly LoggerInterface $logger
    ) {
    }

    public function send(array $notifications, ChannelInterface $channel): bool
    {
        $msgs = $this->generateMessage->fromNotificationsData($notifications);

        foreach ($msgs as $msg) {
            if (!$this->call($msg, $channel)) {
                return false;
            }
        }

        return true;
    }

    public function sendCustom(string $header, array $texts, ChannelInterface $channel): bool
    {
        $msg = $this->generateMessage->fromArray($header, $texts);

        return $this->call($msg, $channel);
    }

    private function call(array $blocks, ChannelInterface $channel): bool
    {
        $response = $this->postMessage->execute($channel->getChannelValue(), $blocks);
        $budy = $this->json->unserialize($response->getBody());

        $result = (bool) ($budy['ok'] ?? false);

        if (!$result) {
            $this->logger->error('Slack Admin Notification failed', ['response' => $budy]);
        }

        return $result;
    }
}