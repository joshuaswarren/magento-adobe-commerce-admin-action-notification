<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model;

use Creatuity\AdminActionNotification\Api\LogEntitiesProviderInterface;

class DefaultLogEntitiesProvider implements LogEntitiesProviderInterface
{
    public function __construct(
        private readonly array $entities = []
    ) {
    }

    public function get(): array
    {
        return $this->entities;
    }
}