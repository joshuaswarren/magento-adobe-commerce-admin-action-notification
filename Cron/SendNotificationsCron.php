<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Cron;

use Creatuity\AdminActionNotification\Model\Notification\RunNotificationRules;

class SendNotificationsCron
{
    public function __construct(
        private readonly RunNotificationRules $runNotificationRules
    )
    {
    }

    public function execute(): void
    {
        $this->runNotificationRules->execute();
    }
}