<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model;

use Creatuity\AdminActionNotification\Api\ChannelRepositoryRepositoryInterface;
use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Creatuity\AdminActionNotification\Model\ResourceModel\ChannelResource;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class ChannelRepository implements ChannelRepositoryRepositoryInterface
{
    private ChannelResource $channelResource;
    private ChannelFactory $channelFactory;

    public function __construct(
        ChannelResource $channelResource,
        ChannelFactory $channelFactory
    ) {
        $this->channelResource = $channelResource;
        $this->channelFactory = $channelFactory;
    }

    public function save(ChannelInterface $channel): ChannelInterface
    {
        try {
            $this->channelResource->save($channel);
        } catch (\Exception $exception) {
            throw new LocalizedException(__($exception->getMessage()));
        }
        return $channel;
    }

    public function getById(int $id): ChannelInterface
    {
        $channel = $this->channelFactory->create();
        $this->channelResource->load($channel, $id);
        if (!$channel->getId()) {
            throw new NoSuchEntityException(__('The channel with the "%1" ID doesn\'t exist.', $id));
        }
        return $channel;
    }

    public function delete(ChannelInterface $channel): void
    {
        try {
            $this->channelResource->delete($channel);
        } catch (\Exception $exception) {
            throw new LocalizedException(__($exception->getMessage()));
        }
    }

    public function deleteById(int $channelId): void
    {
        $channel = $this->getById($channelId);
        $this->delete($channel);
    }
}
