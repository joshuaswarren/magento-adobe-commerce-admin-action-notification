<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Slack;

use Creatuity\AdminActionNotification\Api\Data\NotificationDataInterface;
use Generator;

class GenerateMessageBlocks
{
    public const MESSAGE_LENGTH_LIMIT = 100;

    /**
     * @param NotificationDataInterface[] $notifications
     * @return Generator
     */
    public function fromNotificationsData(array $notifications): Generator
    {
        foreach ($notifications as $notificationData) {
            $rows = $notificationData->getRows();
            $entity = $notificationData->getEntityLabel();
            foreach ($rows as $row) {
                $before = $row->getOriginalData();
                $after = $row->getResultData();
                $entityName = $row->getSourceName() . ($row->getSourceId() ? (' [ID: ' . $row->getSourceId() . ']') : '');
                $blocks = [];
                $blocks[] = ['type' => 'header', 'text' => ['type' => 'plain_text', 'text' => $entity . ' operation has been detected!']];
                $blocks[] = ['type' => 'section', 'text' => ['type' => 'plain_text', 'text' => 'Entity: ' . $entityName]];
                $blocks[] = ['type' => 'section', 'text' => ['type' => 'plain_text', 'text' => 'User: ' . $row->getUser()]];
                $blocks[] = ['type' => 'section', 'text' => ['type' => 'plain_text', 'text' => 'Time: ' . $row->getTime()]];
                if (mb_strlen($before) <= self::MESSAGE_LENGTH_LIMIT && mb_strlen($after) <= self::MESSAGE_LENGTH_LIMIT) {
                    $blocks[] = ['type' => 'section', 'text' => ['type' => 'plain_text', 'text' => 'Before: ' . $before]];
                    $blocks[] = ['type' => 'section', 'text' => ['type' => 'plain_text', 'text' => 'After: ' . $after]];
                }
                $blocks[] = ['type' => 'section', 'text' => ['type' => 'mrkdwn', 'text' => '[See Details](' . $row->getResultLink() . ')']];

                yield $blocks;
            }
        }
    }

    public function fromArray(string $header, array $texts): array
    {
        $texts = array_filter($texts);

        $blocks = [['type' => 'header', 'text' => ['type' => 'plain_text', 'text' => $header]]];
        foreach ($texts as $text) {
            $blocks[] = ['type' => 'section', 'text' => ['type' => 'plain_text', 'text' => $text]];
        }

        return $blocks;
    }
}