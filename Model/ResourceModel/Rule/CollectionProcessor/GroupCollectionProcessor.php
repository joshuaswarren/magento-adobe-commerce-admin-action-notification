<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\ResourceModel\Rule\CollectionProcessor;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection\AbstractDb;

class GroupCollectionProcessor implements CollectionProcessorInterface
{

    public function process(SearchCriteriaInterface $searchCriteria, AbstractDb $collection)
    {
        $collection->getSelect()
            ->group(['main_table.rule_id']);
        $collection->getSelect()
            ->columns([
                'entities' => new \Zend_Db_Expr('GROUP_CONCAT(DISTINCT(rule_entity.entity))'),
                'channels' => new \Zend_Db_Expr('GROUP_CONCAT(DISTINCT(rule_channel.channel_id))'),
            ]);
    }
}