<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Notification;

use Creatuity\AdminActionNotification\Model\Resolver\LogTableResolverInterface;
use Exception;
use Magento\Framework\App\ResourceConnection;

class GetLogsForNotificationByEntity
{
    public function __construct(
        private readonly LogTableResolverInterface $logTableResolver,
        private readonly ResourceConnection $resourceConnection
    )
    {
    }

    /**
     * @param string $entity
     * @param string $startFromDateTime
     * @return \Generator
     * @throws \Zend_Db_Statement_Exception|Exception
     */
    public function execute(string $entity, string $startFromDateTime): \Generator
    {
        if (!$startFromDateTime || strtotime($startFromDateTime) <= 0) {
            throw new Exception('Cannot generate notification data for ' . $entity . '. Wrong start date time provided.');
        }

        $startFromDateTime = date('Y-m-d H:i:s', strtotime($startFromDateTime));
        $loggingTable = $this->logTableResolver->resolveLoggingTable();
        $changesTable = $this->logTableResolver->resolveChangesTable();
        $conn = $this->resourceConnection->getConnection();
        $select = $conn
            ->select()
            ->from(
                ['changes' => $changesTable],
                [
                    'logging_id' => 'changes.id',
                    'time' => 'logging.time',
                    'user' => 'logging.user',
                    'source_id' => 'changes.source_id',
                    'source_name' => 'changes.source_name',
                    'original_data' => 'changes.original_data',
                    'result_data' => 'changes.result_data',
                ]
            )
            ->join(['logging' => $loggingTable], 'logging.log_id = changes.event_id')
            ->where('logging.event_code = ?', $entity)
            ->where('logging.action != "view"')
            ->where('logging.time >= ?', $startFromDateTime)
            ->order('logging.time ASC');

        $stmt = $conn->query($select);
        while ($row = $stmt->fetch()) {
            yield $row;
        }
    }
}