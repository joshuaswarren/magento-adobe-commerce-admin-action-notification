<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Ui\Listing\Component;

use Creatuity\AdminActionNotification\Model\Rule\Converter\RuleDataConverterInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns;

class RuleColumns extends Columns
{
    /**
     * @param ContextInterface $context
     * @param RuleDataConverterInterface[] $converters
     * @param mixed[] $components
     * @param mixed[] $data
     */
    public function __construct(
        ContextInterface $context,
        private readonly array $converters = [],
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as & $item) {
            foreach ($item as $key => $value) {
                if (isset($this->converters[$key])) {
                    $item[$key] = implode(', ', $this->converters[$key]->format($value));
                }
            }
        }

        return $dataSource;
    }
}