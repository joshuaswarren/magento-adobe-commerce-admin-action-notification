<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\ResourceModel\Channel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Creatuity\AdminActionNotification\Model\Channel;
use Creatuity\AdminActionNotification\Model\ResourceModel\ChannelResource;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(Channel::class, ChannelResource::class);
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }

    public function toOptionArray()
    {
        return $this->_toOptionArray(labelField: Channel::UNIQUE_NAME);
    }
}
