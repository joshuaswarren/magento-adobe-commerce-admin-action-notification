<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Channel\Validator;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Creatuity\AdminActionNotification\OptionSource\ChannelTypeOptionSource;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

class ChannelValidator
{
    public function __construct(
        private readonly ValidationResultFactory $validationResultFactory,
        private readonly ChannelTypeOptionSource $channelTypeOptionSource
    ) {
    }

    public function validate(ChannelInterface $channel): ValidationResult
    {
        $errors = [];

        if (empty($channel->getChannelValue())) {
            $errors[] = __('Channel Value is missing');
        }

        if (!in_array($channel->getChannelType(), array_keys($this->channelTypeOptionSource->toArray()), true)) {
            $errors[] = __('Channel type is missing or invalid');
        }

        if (empty($channel->getUniqueName())) {
            $errors[] = __('Channel name is missing');
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}