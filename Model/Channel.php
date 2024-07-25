<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Magento\Framework\Model\AbstractModel;

class Channel extends AbstractModel implements ChannelInterface
{
    private bool $skipNotification = false;

    public function getChannelId(): int
    {
        return (int) $this->getData(self::CHANNEL_ID);
    }

    public function getUniqueName(): string
    {
        return (string) $this->getData(self::UNIQUE_NAME);
    }

    public function getChannelType(): string
    {
        return (string) $this->getData(self::CHANNEL_TYPE);
    }

    public function getChannelValue(): string
    {
        return (string) $this->getData(self::CHANNEL_VALUE);
    }

    public function setChannelId(int $channelId): void
    {
        $this->setData(self::CHANNEL_ID, $channelId);
    }

    public function setUniqueName(string $name): void
    {
        $this->setData(self::UNIQUE_NAME, $name);
    }

    public function setChannelType(string $channel): void
    {
        $this->setData(self::CHANNEL_TYPE, $channel);
    }

    public function setChannelValue(string $channelValue): void
    {
        $this->setData(self::CHANNEL_VALUE, $channelValue);
    }

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel\ChannelResource::class);
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
