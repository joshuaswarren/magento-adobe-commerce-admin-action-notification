<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule\Validator;

use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Creatuity\AdminActionNotification\Api\LogEntitiesProviderInterface;
use Creatuity\AdminActionNotification\Model\ResourceModel\Channel\CollectionFactory;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

class RuleEntitiesValidator implements RuleValidatorInterface
{
    public function __construct(
        private readonly LogEntitiesProviderInterface $logEntitiesProvider,
        private readonly ValidationResultFactory $validationResultFactory
    ) {
    }

    public function validate(RuleInterface $rule): ValidationResult
    {
        $entities = $rule->getEntities();
        $errors = [];
        if (empty($entities)) {
            $errors[] = (string)__('At least one tracked entity must be selected');

            return $this->validationResultFactory->create(['errors' => $errors]);
        }

        $availableEntities = $this->logEntitiesProvider->get();

        foreach ($entities as $entity) {
            if (!isset($availableEntities[$entity])) {
                $errors[] = (string)__('Cannot assign entity %1. Such entity does not exist', $entity);
            }
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}