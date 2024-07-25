<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\ViewModel;

use Creatuity\AdminActionNotification\Api\Data\NotificationRowInterface;
use Creatuity\AdminActionNotification\Model\Notification\GenerateNotificationRowByLogId;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class NotificationRowDetailsViewModel implements ArgumentInterface
{
    private ?NotificationRowInterface $notificationRow = null;

    public function __construct(
        private readonly GenerateNotificationRowByLogId $generateNotificationRowByLogId,
        private readonly RequestInterface $request,
        private readonly SerializerInterface $serializer
    ) {
    }

    public function getNotifcationRow(): NotificationRowInterface
    {
        if ($this->notificationRow) {
            return $this->notificationRow;
        }

        return $this->notificationRow = $this->generateNotificationRowByLogId->execute((int)$this->request->getParam('id'));
    }

    public function getBefore(): array
    {
        $object = $this->getNotifcationRow();

        return $this->serializer->unserialize($object->getOriginalData());
    }

    public function getAfter(): array
    {
        $object = $this->getNotifcationRow();

        return $this->serializer->unserialize($object->getResultData());
    }

    public function getAllAttributes(): array
    {
        return array_unique(array_merge(array_keys($this->getBefore()), array_keys($this->getAfter())));
    }

    public function printValue(mixed $value): string
    {
        if (!$value) {
            return '-';
        }

        if (is_array($value)) {
            return json_encode($value, JSON_PRETTY_PRINT);
        }

        return (string) $value;
    }
}