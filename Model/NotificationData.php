<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model;

use Creatuity\AdminActionNotification\Api\Data\NotificationDataInterface;
use Creatuity\AdminActionNotification\Api\Data\NotificationRowInterface;
use Magento\Framework\DataObject;

class NotificationData extends DataObject implements NotificationDataInterface
{

    public function getEntity(): string
    {
        return (string) $this->getData(self::ENTITY);
    }

    public function setEntity(string $entity): void
    {
        $this->setData(self::ENTITY, $entity);
    }

    public function getEntityLabel(): string
    {
        return (string) $this->getData(self::ENTITY_LABEL);
    }

    public function setEntityLabel(string $label): void
    {
        $this->setData(self::ENTITY_LABEL, $label);
    }

    public function getRows(): array
    {
        return $this->getData(self::ROWS) ?: [];
    }

    public function setRows(array $rows): void
    {
        foreach ($rows as $row) {
            if (!$row instanceof NotificationRowInterface) {
                throw new \Exception('Row must implement ' . NotificationRowInterface::class);
            }
        }

        $this->setData(self::ROWS, $rows);
    }
}