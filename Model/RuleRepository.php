<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model;

use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Creatuity\AdminActionNotification\Api\Data\RuleSearchResultsInterface;
use Creatuity\AdminActionNotification\Api\RuleRepositoryRepositoryInterface;
use Creatuity\AdminActionNotification\Model\ResourceModel\RuleResource;
use Creatuity\AdminActionNotification\Model\Rule\GetRuleList;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class RuleRepository implements RuleRepositoryRepositoryInterface
{

    public function __construct(
        private readonly RuleResource $resource,
        private readonly GetRuleList $getRuleList,
        private readonly SearchCriteriaBuilderFactory $criteriaBuilderFactory
    ) {
    }

    public function save(RuleInterface $rule): RuleInterface
    {
        try {
            $this->resource->save($rule);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $rule;
    }

    public function getById(int $id): RuleInterface
    {
        $searchCriteria = $this->criteriaBuilderFactory->create()->addFilter(RuleInterface::RULE_ID, $id)->create();

        $rules = $this->getRuleList->execute($searchCriteria)->getItems();

        if (!$rules) {
            throw new NoSuchEntityException(__('Rule with id "%1" does not exist.', $id));
        }

        return reset($rules);
    }

    public function getList(SearchCriteriaInterface $searchCriteria): RuleSearchResultsInterface
    {
        return $this->getRuleList->execute($searchCriteria);
    }

    public function delete(RuleInterface $rule): void
    {
        try {
            $this->resource->delete($rule);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    public function deleteById(int $ruleId): void
    {
        $rule = $this->getById($ruleId);
        $this->delete($rule);
    }
}
