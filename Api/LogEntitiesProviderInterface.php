<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Api;

interface LogEntitiesProviderInterface
{
    public function get(): array;
}