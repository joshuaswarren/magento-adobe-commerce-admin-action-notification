<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model;

use Creatuity\AdminActionNotification\Api\Data\NotificationRowInterface;
use Magento\Framework\DataObject;

class NotificationRow extends DataObject implements NotificationRowInterface
{
    public function getId(): int
    {
        return (int) $this->getData(self::ID);
    }

    public function setId(int $id): void
    {
        $this->setData(self::ID, $id);
    }

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

    public function getTime(): string
    {
        return (string) $this->getData(self::TIME);
    }

    public function setTime(string $dateTime): void
    {
        $this->setData(self::TIME, $dateTime);
    }

    public function getUser(): string
    {
        return (string) $this->getData(self::USER);
    }

    public function setUser(string $user): void
    {
        $this->setData(self::USER, $user);
    }

    public function getSourceId(): int
    {
        return (int) $this->getData(self::SOURCE_ID);
    }

    public function setSourceId(int $id): void
    {
        $this->setData(self::SOURCE_ID, $id);
    }

    public function getOriginalData(): string
    {
        return (string) $this->getData(self::ORIGINAL_DATA);
    }

    public function setOriginalData(string $data): void
    {
        $this->setData(self::ORIGINAL_DATA, $data);
    }

    public function getResultData(): string
    {
        return (string) $this->getData(self::RESULT_DATA);
    }

    public function setResultData(string $data): void
    {
        $this->setData(self::RESULT_DATA, $data);
    }

    public function getResultLink(): string
    {
        return (string) $this->getData(self::RESULT_LINK);
    }

    public function setResultLink(string $link): void
    {
        $this->setData(self::RESULT_LINK, $link);
    }

    public function getSourceName(): string
    {
        return (string)$this->getData(self::SOURCE_NAME);
    }

    public function setSourceName(?string $name): void
    {
        $this->setData(self::SOURCE_NAME, $name);
    }
}