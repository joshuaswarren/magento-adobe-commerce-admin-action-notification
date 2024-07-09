<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\ResourceModel\Rule\CollectionProcessor;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection\AbstractDb;

class AddChannelsProcessor implements CollectionProcessorInterface
{

    public function process(SearchCriteriaInterface $searchCriteria, AbstractDb $collection)
    {
        $collection->getSelect()
            ->joinLeft(
                ['rule_channel' => $collection->getTable('creatuity_admin_notification_rule_channel')],
                'rule_channel.rule_id = main_table.rule_id',
                []
            )
            ->joinLeft(
                ['channel' => $collection->getTable('creatuity_admin_notification_channel')],
                'channel.channel_id = rule_channel.channel_id',
                []
            );
    }
}