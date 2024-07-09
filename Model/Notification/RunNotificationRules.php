<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Notification;

use Psr\Log\LoggerInterface;

class RunNotificationRules
{
    public function __construct(
        private readonly GetAwaitingNotificationRules $awaitingNotificationRules,
        private readonly RunNotificationRule $runNotificationRule,
        private readonly LoggerInterface $logger
    )
    {
    }

    public function execute(): void
    {
        $rules = $this->awaitingNotificationRules->exeucte();

        foreach ($rules as $rule) {
            try {
                $this->runNotificationRule->execute($rule);
            } catch (\Throwable $e) {
                $this->logger->error(
                    'Error while generating notfication data for rule ' . $rule->getRuleId(),
                    ['exception' => $e]
                );
            }
        }
    }
}