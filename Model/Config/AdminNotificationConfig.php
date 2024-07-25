<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class AdminNotificationConfig
{
    public const XML_PATH_ADMIN_NOTIFICATION_ENABLED = 'creatuity_admin_action_notification/general/enabled';
    public const XML_PATH_ADMIN_NOTIFICATION_SELF_NOTIFICATION_CHANNEL_TYPE = 'creatuity_admin_action_notification/self_notification/channel';
    public const XML_PATH_ADMIN_NOTIFICATION_SELF_NOTIFICATION_CHANNEL_VALUE = 'creatuity_admin_action_notification/self_notification/chennel_value';
    public const XML_PATH_ADMIN_NOTIFICATION_SLACK_API_KEY = 'creatuity_admin_action_notification/slack_config/api_key';

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    )
    {
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ADMIN_NOTIFICATION_ENABLED);
    }

    public function getNotificationChannelType(): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_ADMIN_NOTIFICATION_SELF_NOTIFICATION_CHANNEL_TYPE);
    }

    public function getNotificationChannelValue(): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_ADMIN_NOTIFICATION_SELF_NOTIFICATION_CHANNEL_VALUE);
    }

    public function getSlackApiKey(): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_ADMIN_NOTIFICATION_SLACK_API_KEY);
    }
}