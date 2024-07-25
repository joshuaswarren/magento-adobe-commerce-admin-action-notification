<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Notification;

use Creatuity\AdminActionNotification\Api\Data\NotificationRowInterface;
use Creatuity\AdminActionNotification\Model\Resolver\LogTableResolverInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\NotFoundException;

class GenerateNotificationRowByLogId
{
    public function __construct(
        private readonly NotificationRowHydrator $notificationRowHydrator,
        private readonly LogTableResolverInterface $logTableResolver,
        private readonly ResourceConnection $resourceConnection
    ) {
    }
    
    public function execute(int $logId): NotificationRowInterface
    {
        $loggingTable = $this->logTableResolver->resolveLoggingTable();
        $changesTable = $this->logTableResolver->resolveChangesTable();
        $conn = $this->resourceConnection->getConnection();
        $select = $conn
            ->select()
            ->from(
                ['changes' => $changesTable],
                [
                    'logging_id' => 'changes.id',
                    'entity' => 'logging.event_code',
                    'time' => 'logging.time',
                    'user' => 'logging.user',
                    'source_id' => 'changes.source_id',
                    'source_name' => 'changes.source_name',
                    'original_data' => 'changes.original_data',
                    'result_data' => 'changes.result_data',
                ]
            )
            ->join(['logging' => $loggingTable], 'logging.log_id = changes.event_id')
            ->where('changes.id = ?', $logId);
        $row = $conn->fetchRow($select);
        
        if (!$row) {
            throw new NotFoundException(__('Log ID %1 not found', $logId));
        }

        return $this->notificationRowHydrator->hydrate([
            NotificationRowInterface::ENTITY => $row['entity'],
            NotificationRowInterface::SOURCE_ID => (int)$row['source_id'],
            NotificationRowInterface::ID => (int)$row['logging_id'],
            NotificationRowInterface::TIME => $row['time'],
            NotificationRowInterface::SOURCE_NAME => $row['source_name'],
            NotificationRowInterface::USER => $row['user'],
            NotificationRowInterface::ORIGINAL_DATA => $row['original_data'],
            NotificationRowInterface::RESULT_DATA => $row['result_data'],
        ]);
    }
}