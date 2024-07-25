<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Resolver;

use Magento\Framework\App\ResourceConnection;

class DefaultLogTableResolver implements LogTableResolverInterface
{
    public function __construct(
        private readonly ResourceConnection $resourceConnection,
        private readonly string $mainTable,
        private readonly string $changesTable,
    ) {
    }

    public function resolveLoggingTable(): string
    {
        return $this->resourceConnection->getTableName($this->mainTable);
    }

    public function resolveChangesTable(): string
    {
        return $this->resourceConnection->getTableName($this->changesTable);
    }
}