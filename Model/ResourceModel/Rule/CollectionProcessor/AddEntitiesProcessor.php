<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\ResourceModel\Rule\CollectionProcessor;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection\AbstractDb;

class AddEntitiesProcessor implements CollectionProcessorInterface
{

    public function process(SearchCriteriaInterface $searchCriteria, AbstractDb $collection)
    {
        $collection->getSelect()
            ->joinLeft(
                ['rule_entity' => $collection->getTable('creatuity_admin_notification_rule_entity')],
                'rule_entity.rule_id = main_table.rule_id',
                []
            );
    }
}