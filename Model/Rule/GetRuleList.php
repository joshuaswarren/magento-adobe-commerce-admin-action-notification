<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule;

use Creatuity\AdminActionNotification\Api\Data\RuleSearchResultsInterface;
use Creatuity\AdminActionNotification\Api\Data\RuleSearchResultsInterfaceFactory;
use Creatuity\AdminActionNotification\Model\ResourceModel\Rule\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class GetRuleList
{
    public function __construct(
        private readonly CollectionFactory $collectionFactory,
        private readonly CollectionProcessorInterface $collectionProcessor,
        private readonly RuleSearchResultsInterfaceFactory $searchResultsFactory,
    ) {
    }

    public function execute(SearchCriteriaInterface $searchCriteria): RuleSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}