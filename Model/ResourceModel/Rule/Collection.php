<?php
declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\ResourceModel\Rule;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Creatuity\AdminActionNotification\Model\Rule;
use Creatuity\AdminActionNotification\Model\ResourceModel\RuleResource;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(Rule::class, RuleResource::class);
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
        $this->addFilterToMap('rule_id', 'main_table.rule_id');
    }

    public function toOptionArray()
    {
        return $this->_toOptionArray(labelField: Rule::RULE_NAME);
    }
}
