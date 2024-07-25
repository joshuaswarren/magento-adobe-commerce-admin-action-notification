<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Ui\Listing;

use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Creatuity\AdminActionNotification\Api\RuleRepositoryRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Ui\DataProvider\SearchResultFactory;

class RuleListingDataProvider extends DataProvider
{
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        private readonly RuleRepositoryRepositoryInterface $ruleRepository,
        private readonly SearchResultFactory $searchResultFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
    }

    /** @noinspection PhpMissingParentCallCommonInspection */
    public function getSearchResult(): SearchResultInterface
    {
        $searchCriteria = $this->getSearchCriteria();
        $result = $this->ruleRepository->getList($searchCriteria);

        return $this->searchResultFactory->create(
            $result->getItems(),
            $result->getTotalCount(),
            $searchCriteria,
            RuleInterface::RULE_ID
        );
    }
}