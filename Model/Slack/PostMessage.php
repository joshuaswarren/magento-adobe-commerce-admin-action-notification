<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Slack;

use Creatuity\AdminActionNotification\Model\Config\AdminNotificationConfig;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\HTTP\Client\CurlFactory;
use Magento\Framework\Serialize\Serializer\Json;

class PostMessage
{
    public function __construct(
        private readonly CurlFactory $curlFactory,
        private readonly AdminNotificationConfig $adminNotificationConfig,
        private readonly Json $json,
        private readonly string $url = 'https://slack.com/api/chat.postMessage'
    ) {
    }

    public function execute(string $channeld, array $messageBlocks): Curl
    {
        $curl = $this->curlFactory->create();
        $postData = [
            'channel' => $channeld,
            'blocks' => $messageBlocks
        ];
        $curl->addHeader('Content-type', 'application/json');
        $curl->addHeader('Authorization', 'Bearer ' . $this->adminNotificationConfig->getSlackApiKey());
        $curl->post($this->url, $this->json->serialize($postData));

        return $curl;
    }
}