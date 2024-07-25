<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Notification\Collector;

use Creatuity\AdminActionNotification\Api\Data\NotificationDataInterface;
use Creatuity\AdminActionNotification\Api\Data\NotificationRowInterface;
use Creatuity\AdminActionNotification\Api\Data\NotificationRowInterfaceFactory;
use Creatuity\AdminActionNotification\Model\Notification\GetLogsForNotificationByEntity;
use Creatuity\AdminActionNotification\Model\Notification\NotificationDataHydrator;
use Creatuity\AdminActionNotification\Model\Notification\NotificationRowHydrator;

class GenerateNotificationData
{
    public function __construct(
        private readonly NotificationRowHydrator $notificationRowHydrator,
        private readonly NotificationDataHydrator $notificationDataHydrator,
        private readonly GetLogsForNotificationByEntity $getLogsForNotificationByEntity
    )
    {
    }

    /**
     * @param string $entity
     * @param string $startFromDateTime
     * @return NotificationDataInterface|null
     * @throws \Zend_Db_Statement_Exception|\Exception
     */
    public function execute(string $entity, string $startFromDateTime): ?NotificationDataInterface
    {
        $rows = [];
        foreach ($this->getLogsForNotificationByEntity->execute($entity, $startFromDateTime) as $row) {
            $rows[] = $this->notificationRowHydrator->hydrate([
                NotificationRowInterface::ENTITY => $entity,
                NotificationRowInterface::SOURCE_ID => (int)$row['source_id'],
                NotificationRowInterface::SOURCE_NAME => $row['source_name'],
                NotificationRowInterface::ID => (int)$row['logging_id'],
                NotificationRowInterface::TIME => $row['time'],
                NotificationRowInterface::USER => $row['user'],
                NotificationRowInterface::ORIGINAL_DATA => $row['original_data'],
                NotificationRowInterface::RESULT_DATA => $row['result_data'],
            ]);
        }

        if (!$rows) {
            return null;
        }

        return $this->notificationDataHydrator->hydrate([
            NotificationDataInterface::ENTITY => $entity,
            NotificationDataInterface::ROWS => $rows
        ]);
    }
}