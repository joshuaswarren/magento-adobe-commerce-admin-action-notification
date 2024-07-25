<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface RuleSearchResultsInterface
 */
interface RuleSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get items
     *
     * @return \Creatuity\AdminActionNotification\Api\Data\RuleInterface[]
     */
    public function getItems();

    /**
     * Set items
     *
     * @param \Creatuity\AdminActionNotification\Api\Data\RuleInterface[] $items
     */
    public function setItems(array $items);
}
