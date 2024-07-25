<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Api\Data;

interface NotificationDataInterface
{
    public const ENTITY = 'entity';
    public const ENTITY_LABEL = 'entity_label';
    public const ROWS = 'rows';

    /**
     * @return string
     */
    public function getEntity(): string;

    /**
     * @param string $entity
     * @return void
     */
    public function setEntity(string $entity): void;

    /**
     * @return string
     */
    public function getEntityLabel(): string;

    /**
     * @param string $label
     * @return void
     */
    public function setEntityLabel(string $label): void;

    /**
     * @return \Creatuity\AdminActionNotification\Api\Data\NotificationRowInterface[]
     */
    public function getRows(): array;

    /**
     * @param \Creatuity\AdminActionNotification\Api\Data\NotificationRowInterface[] $rows
     * @return void
     */
    public function setRows(array $rows): void;
}