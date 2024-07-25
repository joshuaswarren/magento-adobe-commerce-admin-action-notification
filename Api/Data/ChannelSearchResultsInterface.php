<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ChannelSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Creatuity\AdminActionNotification\Api\Data\ChannelInterface[]
     */
    public function getItems();

    /**
     * @param \Creatuity\AdminActionNotification\Api\Data\ChannelInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
