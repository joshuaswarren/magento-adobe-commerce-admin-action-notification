<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Api;

use Creatuity\AdminActionNotification\Api\Data\ObservableEntityInterface;

interface ObservableRepositoryInterface
{
    public function getById(int $id): ObservableEntityInterface;
}