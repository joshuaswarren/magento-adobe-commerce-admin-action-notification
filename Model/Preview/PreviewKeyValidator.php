<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Preview;

use Creatuity\AdminActionNotification\Model\Notification\GenerateNotificationRowByLogId;

class PreviewKeyValidator
{
    public function __construct(
        private readonly GenerateNotificationRowByLogId $generateNotificationRowByLogId,
        private readonly GenerateNotificationRowPreviewLink $generateNotificationRowPreviewLink
    ) {
    }

    public function check(int $logId, string $key): bool
    {
        $object = $this->generateNotificationRowByLogId->execute($logId);
        $poperKey = $this->generateNotificationRowPreviewLink->getHash($object);

        return $key === $poperKey;
    }
}