<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Notification;

use Creatuity\AdminActionNotification\Api\Data\NotificationDataInterface;
use Creatuity\AdminActionNotification\Api\Data\NotificationDataInterfaceFactory;
use Creatuity\AdminActionNotification\Api\Data\NotificationRowInterface;
use Creatuity\AdminActionNotification\Api\LogEntitiesProviderInterface;
use Magento\Framework\Api\DataObjectHelper;

class NotificationDataHydrator
{
    public function __construct(
        private readonly NotificationDataInterfaceFactory $notificationDataFactory,
        private readonly DataObjectHelper $dataObjectHelper,
        private readonly LogEntitiesProviderInterface $logEntitiesProvider
    ) {
    }

    public function hydrate(array $data): NotificationDataInterface
    {
        /** @var NotificationDataInterface $object */
        $object = $this->notificationDataFactory->create();
        $data[NotificationDataInterface::ENTITY_LABEL] = $this->logEntitiesProvider->get()[$data[NotificationDataInterface::ENTITY]];
        $rows = array_map(function (NotificationRowInterface $row) {
            return $row->getData();
        }, $data[NotificationDataInterface::ROWS]);
        $data[NotificationDataInterface::ROWS] = $rows;
        $this->dataObjectHelper->populateWithArray($object, $data, NotificationDataInterface::class);

        return $object;
    }
}