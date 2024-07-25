<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\OptionSource;

use Creatuity\AdminActionNotification\Model\ResourceModel\Channel\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class ChannelOptionSource implements OptionSourceInterface
{
    public function __construct(
        private readonly CollectionFactory $collectionFactory
    ) {
    }

    public function toOptionArray(): array
    {
        /** @var \Creatuity\AdminActionNotification\Model\ResourceModel\Channel\Collection $collection */
        $collection = $this->collectionFactory->create();

        return $collection->toOptionArray();
    }
}