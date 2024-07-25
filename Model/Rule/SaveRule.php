<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule;

use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Creatuity\AdminActionNotification\Api\RuleRepositoryRepositoryInterface;
use Creatuity\AdminActionNotification\Model\Rule\Validator\RuleValidatorInterface;
use Magento\Framework\Validation\ValidationException;

class SaveRule implements SaveRuleActionInterface
{
    /**
     * @param SaveRuleActionInterface[] $saveActions
     */
    public function __construct(
        private readonly RuleRepositoryRepositoryInterface $ruleRepository,
        private readonly RuleValidatorInterface $ruleValidator,
        private readonly array $saveActions = []
    ) {
    }

    /**
     * @param RuleInterface $rule
     * @return void
     * @throws ValidationException
     */
    public function execute(RuleInterface $rule): void
    {
        $valiationResult = $this->ruleValidator->validate($rule);

        if (!$valiationResult->isValid()) {
            throw new ValidationException(__('Validaton failes', valiationResult: $valiationResult));
        }

        $this->ruleRepository->save($rule);

        foreach ($this->saveActions as $action) {
            $action->execute($rule);
        }
    }
}