<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule\Converter;

interface RuleDataConverterInterface
{
    /**
     * @param int[]|string[]|string $values
     * @return string[]
     */
    public function format(array|string $values): array;

    /**
     * @param string $column
     * @return bool
     */
    public function isApplicable(string $column): bool;
}