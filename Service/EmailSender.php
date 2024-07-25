<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Service;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Creatuity\AdminActionNotification\Api\Service\NotificationSendInterface;
use Creatuity\AdminActionNotification\Model\Email\EmailHelper;

class EmailSender implements NotificationSendInterface
{
    public function __construct(
        private readonly EmailHelper $emailHelper,
        private readonly string $notificationTemplate = 'admin_notification_email_template',
        private readonly string $selfNotificationTemplate = 'admin_self_notification_email_template',
    ) {
    }

    public function send(array $notifications, ChannelInterface $channel): bool
    {
        $this->emailHelper->setData(['notifications' => $notifications]);
        $this->emailHelper->setTemplate($this->notificationTemplate);

        return $this->emailHelper->sendEmail($channel->getChannelValue());
    }

    public function sendCustom(string $header, array $texts, ChannelInterface $channel): bool
    {
        $this->emailHelper->setData(['notifications' => $texts, 'header' => $header]);
        $this->emailHelper->setTemplate($this->selfNotificationTemplate);

        return $this->emailHelper->sendEmail($channel->getChannelValue());
    }
}