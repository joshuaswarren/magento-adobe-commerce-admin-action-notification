<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Notification;

use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Creatuity\AdminActionNotification\Model\ResourceModel\Rule\Collection;
use Creatuity\AdminActionNotification\Model\ResourceModel\Rule\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Api\SearchCriteriaFactory;

class GetAwaitingNotificationRules
{
    public function __construct(
        private readonly CollectionFactory $collectionFactory,
        private readonly CollectionProcessor $collectionProcessor,
        private readonly SearchCriteriaFactory $criteriaFactory
    ) {
    }

    /**
     * @return Collection|RuleInterface[]
     */
    public function exeucte(): Collection
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $collection->getSelect()
            ->where(
                RuleInterface::LAST_NOTIFICATION . ' IS NULL ' .
                'OR NOW() >= DATE_ADD(' . RuleInterface::LAST_NOTIFICATION . ', INTERVAL ' . RuleInterface::NOTIFICATION_FREQUENCY . ' MINUTE)'
            );

        $this->collectionProcessor->process($this->criteriaFactory->create(), $collection);

        return $collection;
    }
}