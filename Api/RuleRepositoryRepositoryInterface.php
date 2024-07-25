<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Api;

use Creatuity\AdminActionNotification\Api\Data\RuleSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface RuleRepositoryRepositoryInterface extends ObservableRepositoryInterface
{
    /**
     * Save Rule
     *
     * @param \Creatuity\AdminActionNotification\Api\Data\RuleInterface $rule
     * @return \Creatuity\AdminActionNotification\Api\Data\RuleInterface
     */
    public function save(Data\RuleInterface $rule): Data\RuleInterface;

    /**
     * @param int $id
     * @return \Creatuity\AdminActionNotification\Api\Data\RuleInterface
     */
    public function getById(int $id): Data\RuleInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return RuleSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): RuleSearchResultsInterface;

    /**
     * @param \Creatuity\AdminActionNotification\Api\Data\RuleInterface $rule
     * @return void
     */
    public function delete(Data\RuleInterface $rule): void;

    /**
     * @param int $ruleId
     * @return void
     */
    public function deleteById(int $ruleId): void;
}
