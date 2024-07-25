<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Api\Data;

interface ObservableEntityInterface
{
    /**
     * @param bool $flag
     * @return void
     */
    public function setSkipNotification(bool $flag): void;

    /**
     * @return bool
     */
    public function getSkipNotification(): bool;
}