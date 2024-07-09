<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model;

use Creatuity\AdminActionNotification\Api\Data\RuleSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class RuleSearchResults extends SearchResults implements RuleSearchResultsInterface
{
}
