<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule;

use Creatuity\AdminActionNotification\Api\Data\RuleInterface;

class RuleSaveProcessor
{
    public function __construct(
        private readonly RuleHydrator $ruleHydrator,
        private readonly SaveRule $saveRule
    ) {
    }

    /**
     * @param array $params
     * @return RuleInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Validation\ValidationException
     */
    public function process(array $params): RuleInterface
    {
        $id = $params['id'] ?? $params['rule_id'] ?? null;
        $rule = $this->ruleHydrator->hydrate([
            RuleInterface::RULE_ID => $id ?: null,
            RuleInterface::RULE_NAME => $params['rule_name'],
            RuleInterface::ENTITIES => array_unique($params['entities']),
            RuleInterface::CHANNELS => array_unique($params['channels']),
            RuleInterface::NOTIFICATION_FREQUENCY => $params['notification_frequency']
        ]);

        $this->saveRule->execute($rule);

        return $rule;
    }
}