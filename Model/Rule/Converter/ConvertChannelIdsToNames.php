<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule\Converter;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Creatuity\AdminActionNotification\Model\ResourceModel\Channel\CollectionFactory;

class ConvertChannelIdsToNames implements RuleDataConverterInterface
{
    /** @var string[]|null  */
    private ?array $channels = null;

    public const APPLICABLE_COLUMN = 'channels';

    public function __construct(
        private readonly CollectionFactory $collectionFactory
    ) {
    }

    private function getChannles(): array
    {
        if ($this->channels !== null) {
            return $this->channels;
        }

        $channels = $this->collectionFactory->create();
        /** @var ChannelInterface $channel */
        foreach ($channels as $channel) {
            $this->channels[$channel->getId()] = $channel->getUniqueName();
        }

        return $this->channels;
    }

    public function format(array|string $values): array
    {
        $channels = $this->getChannles();

        $result = [];

        foreach ($values as $value) {
            $result[$value] = $channels[$value] ?? null;
        }

        return array_filter($result);
    }

    public function isApplicable(string $column): bool
    {
        return self::APPLICABLE_COLUMN === $column;
    }
}