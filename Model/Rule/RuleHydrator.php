<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule;

use Creatuity\AdminActionNotification\Api\RuleRepositoryRepositoryInterface;
use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Creatuity\AdminActionNotification\Api\Data\RuleInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\DataObject;

class RuleHydrator
{
    public function __construct(
        private readonly DataObjectHelper $dataObjectHelper,
        private readonly RuleInterfaceFactory $ruleFactory,
        private readonly RuleRepositoryRepositoryInterface $ruleRepository
    ) {
    }

    /**
     * @param mixed[] $data
     * @return RuleInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function hydrate(array $data): RuleInterface
    {
        if (!empty($data[RuleInterface::RULE_ID])) {
            $rule = $this->ruleRepository->getById((int) $data[RuleInterface::RULE_ID]);
        } else {
            /** @var RuleInterface|DataObject $rule */
            $rule = $this->ruleFactory->create();
        }

        $this->dataObjectHelper->populateWithArray($rule, $data, RuleInterface::class);

        return $rule;
    }
}