<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\OptionSource;

use Creatuity\AdminActionNotification\Api\LogEntitiesProviderInterface;
use Magento\Framework\Data\OptionSourceInterface;

class LogEntityOptionSource implements OptionSourceInterface
{
    public function __construct(
        private readonly LogEntitiesProviderInterface $logEntitiesProvider
    ) {
    }

    public function toOptionArray(): array
    {
        $options = [];

        foreach ($this->logEntitiesProvider->get() as $id => $label) {
            $options[] = ['label' => $label, 'value' => $id];
        }

        return $options;
    }
}