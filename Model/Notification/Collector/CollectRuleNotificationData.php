<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Notification\Collector;

use Creatuity\AdminActionNotification\Api\Data\NotificationDataInterface;
use Creatuity\AdminActionNotification\Api\Data\RuleInterface;

class CollectRuleNotificationData
{
    public function __construct(
        private readonly GenerateNotificationData $generateNotificationData
    )
    {
    }

    /**
     * @param RuleInterface $rule
     * @return NotificationDataInterface[]
     * @throws \Zend_Db_Statement_Exception|\Exception
     */
    public function collect(RuleInterface $rule): array
    {
        $entities = $rule->getEntities();
        $startDateTime = $rule->getLastNotification() ?:
            date('Y-m-d H:i:s', strtotime('-' . $rule->getNotificationFrequency() . ' minutes'));

        $data = [];
        foreach ($entities as $entity) {
            $data[] = $this->generateNotificationData->execute($entity, $startDateTime);
        }

        return array_filter($data);
    }
}