<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule\Validator;

use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Creatuity\AdminActionNotification\Model\ResourceModel\Channel\CollectionFactory;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

class RuleValidatorComposite implements RuleValidatorInterface
{
    /**
     * @param ValidationResultFactory $validationResultFactory
     * @param RuleValidatorInterface[] $validators
     */
    public function __construct(
        private readonly ValidationResultFactory $validationResultFactory,
        private readonly array $validators = []
    ) {
    }

    public function validate(RuleInterface $rule): ValidationResult
    {
        $errors = [];

       foreach ($this->validators as $validator) {
           $errors[] = $validator->validate($rule)->getErrors();
       }

        return $this->validationResultFactory->create(['errors' => array_merge([], ...$errors)]);
    }
}