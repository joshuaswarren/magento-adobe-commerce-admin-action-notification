<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Rule\Validator;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Creatuity\AdminActionNotification\Model\ResourceModel\Channel\Collection;
use Creatuity\AdminActionNotification\Model\ResourceModel\Channel\CollectionFactory;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

class RuleChannelsValidator implements RuleValidatorInterface
{
    public function __construct(
        private readonly CollectionFactory $collectionFactory,
        private readonly ValidationResultFactory $validationResultFactory
    ) {
    }

    public function validate(RuleInterface $rule): ValidationResult
    {
        $errors = [];
        $channelIds = $rule->getChannels();
        if (empty($channelIds)) {
            $errors[] = (string)__('At least one channel is required');

            return $this->validationResultFactory->create(['errors' => $errors]);
        }

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(ChannelInterface::CHANNEL_ID, ['in' => $channelIds]);

        foreach ($channelIds as $channelId) {
            if (!$collection->getItemById($channelId)) {
                $errors[] = (string)__('Cannot assign channel %1. Such channel does not exist', $channelId);
            }
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}