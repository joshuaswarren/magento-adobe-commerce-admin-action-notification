<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model;

use Creatuity\AdminActionNotification\Api\Data\ChannelSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class ChannelSearchResults extends SearchResults implements ChannelSearchResultsInterface
{
}
