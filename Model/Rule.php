<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model;

use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Magento\Framework\Model\AbstractModel;

class Rule extends AbstractModel implements RuleInterface
{
    private bool $skipNotification = false;

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel\RuleResource::class);
    }

    public function getRuleId(): int
    {
        return (int) $this->getData(self::RULE_ID);
    }

    public function getNotificationFrequency(): int
    {
        return (int) $this->getData(self::NOTIFICATION_FREQUENCY);
    }

    public function getLastNotification(): ?string
    {
        return $this->getData(self::LAST_NOTIFICATION);
    }

    public function setRuleId(int $ruleId): void
    {
        $this->setData(self::RULE_ID, $ruleId);
    }

    public function setNotificationFrequency(int $notificationFrequency): void
    {
        $this->setData(self::NOTIFICATION_FREQUENCY, $notificationFrequency);
    }

    public function setLastNotification(?string $lastNotification): void
    {
        $this->setData(self::LAST_NOTIFICATION, $lastNotification);
    }

    public function getRuleName(): string
    {
        return (string) $this->getData(self::RULE_NAME);
    }

    public function setRuleName(string $name): void
    {
        $this->setData(self::RULE_NAME, $name);
    }

    public function getChannels(): array
    {
        $channels = $this->getData(self::CHANNELS);

        if (is_array($channels)) {
            return $channels;
        }

        return array_filter(array_map('trim', explode(',', $channels ?: '')));
    }

    public function getEntities(): array
    {
        $entities = $this->getData(self::ENTITIES);

        if (is_array($entities)) {
            return $entities;
        }

        return array_filter(array_map('trim', explode(',', $entities ?: '')));
    }

    public function setChannels(array $channels): void
    {
        $this->setData(self::CHANNELS, $channels);
    }

    public function setEntities(array $entities): void
    {
        $this->setData(self::ENTITIES, $entities);
    }

    public function setSkipNotification(bool $flag): void
    {
        $this->skipNotification = $flag;
    }

    public function getSkipNotification(): bool
    {
        return $this->skipNotification;
    }
}
