<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Magento\Framework\Model\AbstractModel;

class SendSelfNotification
{
    public function __construct(
        private readonly GetSelfNotificationSender $getSelfNotificationSender,
        private readonly GetSelfNotificationChannel $getSelfNotificationChannel
    )
    {
    }

    public function send(AbstractModel $after, ?AbstractModel $before = null): bool
    {
        $sender = $this->getSelfNotificationSender->get();
        $channel = $this->getSelfNotificationChannel->get();

        if ($after->isDeleted()) {
            return $sender->sendCustom($this->getMsg($after), [], $channel);
        }

        $msg = $this->getMsg($before ?: $after, (bool) $before);

        $blocks = [];
        foreach ($after->getData() as $key => $value) {
            $valueAfter = $this->formatValue($value);

            if (!$before) {
                $blocks[] = $key . ': ' . $valueAfter;
                continue;
            }

            $valueBefore = $this->formatValue($before->getData($key));

            if ($valueBefore !== $valueAfter) {
                $blocks[] = $key . ': ' . $valueBefore . ' => ' . $valueAfter;
            }
        }

        if (!$blocks) {
            return false;
        }

        return $sender->sendCustom($msg, $blocks, $channel);
    }


    private function formatValue(mixed $value): string
    {
        if (is_array($value)) {
            return implode(',', $value);
        }

        if (!$value || is_scalar($value)) {
            return (string)$value;
        }

        return '';
    }

    private function getMsg(AbstractModel $model, bool $modified = false): string
    {
        $msg = match (true) {
            $model instanceof ChannelInterface => 'Notification Channel ',
            $model instanceof RuleInterface => 'Notification Rule ',
            default => get_class($model),
        };

        if ($model->isDeleted()) {
            return $msg . $model->getUniqueName() . ' has been deleted!';
        }

        if ($modified) {
            return $msg . $model->getUniqueName() . ' operation has been detected!';
        }

        return $msg . ' has been created';
    }
}