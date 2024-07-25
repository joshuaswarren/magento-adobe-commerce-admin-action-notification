<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Api;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;

interface ChannelRepositoryRepositoryInterface extends ObservableRepositoryInterface
{
    /**
     * @param ChannelInterface $channel
     * @return ChannelInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(ChannelInterface $channel): ChannelInterface;

    /**
     * @param int $id
     * @return ChannelInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $id): ChannelInterface;

    /**
     * @param ChannelInterface $channel
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(ChannelInterface $channel): void;

    /**
     * @param int $channelId
     * @return void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(int $channelId): void;
}
