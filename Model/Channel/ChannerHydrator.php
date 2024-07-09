<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Channel;

use Creatuity\AdminActionNotification\Api\ChannelRepositoryRepositoryInterface;
use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Creatuity\AdminActionNotification\Api\Data\ChannelInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\DataObject;

class ChannerHydrator
{
    public function __construct(
        private readonly DataObjectHelper $dataObjectHelper,
        private readonly ChannelInterfaceFactory $channelFactory,
        private readonly ChannelRepositoryRepositoryInterface $channelRepository
    ) {
    }

    /**
     * @param mixed[] $data
     * @return ChannelInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function hydrate(array $data): ChannelInterface
    {
        if (!empty($data[ChannelInterface::CHANNEL_ID])) {
            $channel = $this->channelRepository->getById((int) $data[ChannelInterface::CHANNEL_ID]);
        } else {
            /** @var ChannelInterface|DataObject $channel */
            $channel = $this->channelFactory->create();
        }

        $this->dataObjectHelper->populateWithArray($channel, $data, ChannelInterface::class);

        return $channel;
    }
}