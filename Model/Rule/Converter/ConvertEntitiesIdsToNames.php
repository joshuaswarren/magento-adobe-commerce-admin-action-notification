<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule\Converter;

use Creatuity\AdminActionNotification\Api\LogEntitiesProviderInterface;

class ConvertEntitiesIdsToNames implements RuleDataConverterInterface
{
    /** @var string[]|null  */
    private ?array $entities = null;

    public const APPLICABLE_COLUMN = 'entities';

    public function __construct(
        private readonly LogEntitiesProviderInterface $logEntitiesProvider
    ) {
    }

    private function getEntities(): array
    {
        if ($this->entities !== null) {
            return $this->entities;
        }

        return $this->entities = $this->logEntitiesProvider->get();
    }

    public function format(array|string $values): array
    {
        $entities = $this->getEntities();

        $result = [];

        foreach ($values as $value) {
            $result[$value] = $entities[$value] ?? null;
        }

        return array_filter($result);
    }

    public function isApplicable(string $column): bool
    {
        return self::APPLICABLE_COLUMN === $column;
    }
}