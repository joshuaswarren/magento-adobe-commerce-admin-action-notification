<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Api\Data;

interface ChannelInterface extends ObservableEntityInterface
{
    public const CHANNEL_ID = 'channel_id';
    public const UNIQUE_NAME = 'unique_name';
    public const CHANNEL_TYPE = 'channel_type';
    public const CHANNEL_VALUE = 'channel_value';

    /**
     * @return int
     */
    public function getChannelId(): int;

    /**
     * @return string
     */
    public function getUniqueName(): string;

    /**
     * @return string
     */
    public function getChannelType(): string;

    /**
     * @return string
     */
    public function getChannelValue(): string;

    /**
     * @param int $channelId
     * @return void
     */
    public function setChannelId(int $channelId): void;

    /**
     * @param string $name
     * @return void
     */
    public function setUniqueName(string $name): void;

    /**
     * @param string $channel
     * @return void
     */
    public function setChannelType(string $channel): void;

    /**
     * @param string $channelValue
     * @return void
     */
    public function setChannelValue(string $channelValue): void;
}
