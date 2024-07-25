<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule\Validator;

use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Magento\Framework\Validation\ValidationResult;

interface RuleValidatorInterface
{
    public function validate(RuleInterface $rule): ValidationResult;
}