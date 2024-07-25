<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule;

use Creatuity\AdminActionNotification\Api\Data\RuleInterface;

interface SaveRuleActionInterface
{
    public function execute(RuleInterface $rule): void;
}