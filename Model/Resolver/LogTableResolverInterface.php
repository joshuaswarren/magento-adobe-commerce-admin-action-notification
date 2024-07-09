<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Resolver;

interface LogTableResolverInterface
{
    public function resolveLoggingTable(): string;

    public function resolveChangesTable(): string;
}