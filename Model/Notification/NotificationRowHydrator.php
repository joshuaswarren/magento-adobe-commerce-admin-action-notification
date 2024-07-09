<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Notification;

use Creatuity\AdminActionNotification\Api\Data\NotificationRowInterface;
use Creatuity\AdminActionNotification\Api\Data\NotificationRowInterfaceFactory;
use Creatuity\AdminActionNotification\Api\LogEntitiesProviderInterface;
use Creatuity\AdminActionNotification\Model\Preview\GenerateNotificationRowPreviewLink;
use Magento\Framework\Api\DataObjectHelper;

class NotificationRowHydrator
{
    public function __construct(
        private readonly DataObjectHelper $dataObjectHelper,
        private readonly NotificationRowInterfaceFactory $notificationRowFactory,
        private readonly GenerateNotificationRowPreviewLink $generateNotificationRowPreviewLink,
        private readonly LogEntitiesProviderInterface $logEntitiesProvider
    )
    {
    }

    public function hydrate(array $data): NotificationRowInterface
    {
        $data[NotificationRowInterface::RESULT_LINK] = '';
        $data[NotificationRowInterface::ENTITY_LABEL] = $this->logEntitiesProvider->get()[$data[NotificationRowInterface::ENTITY]];
        /** @var NotificationRowInterface $object */
        $object = $this->notificationRowFactory->create();
        $this->dataObjectHelper->populateWithArray($object, $data, NotificationRowInterface::class);
        $this->generateNotificationRowPreviewLink->generate($object);

        return $object;
    }
}