<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Api\Data;

interface RuleInterface extends ObservableEntityInterface
{
    public const RULE_ID = 'rule_id';
    public const RULE_NAME = 'rule_name';
    public const NOTIFICATION_FREQUENCY = 'notification_frequency';
    public const LAST_NOTIFICATION = 'last_notification';
    public const CHANNELS = 'channels';
    public const ENTITIES = 'entities';

    /**
     * @return int
     */
    public function getRuleId(): int;

    /**
     * @return int
     */
    public function getNotificationFrequency(): int;

    /**
     * @return ?string
     */
    public function getLastNotification(): ?string;

    /**
     * @param int $ruleId
     * @return void
     */
    public function setRuleId(int $ruleId): void;

    /**
     * @param int $notificationFrequency
     * @return void
     */
    public function setNotificationFrequency(int $notificationFrequency): void;

    /**
     * @param ?string $lastNotification
     * @return void
     */
    public function setLastNotification(?string $lastNotification): void;

    /**
     * @return string
     */
    public function getRuleName(): string;

    /**
     * @param string $name
     * @return void
     */
    public function setRuleName(string $name): void;

    /**
     * @return int[]
     */
    public function getChannels(): array;

    /**
     * @param int[] $channels
     * @return void
     */
    public function setChannels(array $channels): void;

    /**
     * @return string[]
     */
    public function getEntities(): array;

    /**
     * @param string[] $entities
     * @return void
     */
    public function setEntities(array $entities): void;
}
