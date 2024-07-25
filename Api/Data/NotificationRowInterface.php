<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Api\Data;

interface NotificationRowInterface
{
    public const ID = 'id';
    public const ENTITY = 'entity';
    public const ENTITY_LABEL = 'entity_label';
    public const USER = 'user';
    public const TIME = 'time';
    public const SOURCE_ID = 'source_id';
    public const SOURCE_NAME = 'source_name';
    public const ORIGINAL_DATA = 'original_data';
    public const RESULT_DATA = 'result_data';
    public const RESULT_LINK = 'result_link';

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id): void;

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
     * @return string
     */
    public function getTime(): string;

    /**
     * @param string $dateTime
     * @return void
     */
    public function setTime(string $dateTime): void;

    /**
     * @return string
     */
    public function getUser(): string;

    /**
     * @param string $user
     * @return void
     */
    public function setUser(string $user): void;

    /**
     * @return int
     */
    public function getSourceId(): int;

    /**
     * @param int $id
     * @return void
     */
    public function setSourceId(int $id): void;

    /**
     * @return string
     */
    public function getOriginalData(): string;

    /**
     * @param string $data
     * @return void
     */
    public function setOriginalData(string $data): void;

    /**
     * @return string
     */
    public function getResultData(): string;

    /**
     * @param string $data
     * @return void
     */
    public function setResultData(string $data): void;

    /**
     * @return string
     */
    public function getResultLink(): string;

    /**
     * @param string $link
     * @return void
     */
    public function setResultLink(string $link): void;

    /**
     * @return string
     */
    public function getSourceName(): string;

    /**
     * @param string|null $name
     * @return void
     */
    public function setSourceName(?string $name): void;
}