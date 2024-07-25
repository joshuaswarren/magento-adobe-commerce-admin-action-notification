<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Channel;

use Creatuity\AdminActionNotification\Api\ChannelRepositoryRepositoryInterface;
use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Creatuity\AdminActionNotification\Model\Channel\Validator\ChannelValidator;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validation\ValidationException;

class ChannelSaveProcessor
{
    public function __construct(
        private readonly ChannerHydrator $channerHydrator,
        private readonly ChannelRepositoryRepositoryInterface $channelRepository,
        private readonly ChannelValidator $channelValidator
    ) {
    }

    /**
     * @throws ValidationException
     * @throws LocalizedException
     */
    public function process(array $params): ChannelInterface
    {
        $channel = $this->channerHydrator->hydrate([
            ChannelInterface::CHANNEL_ID => !empty($params['channel_id']) ? $params['channel_id'] : null,
            ChannelInterface::CHANNEL_TYPE => mb_strtolower(trim($params['channel_type'] ?? '')),
            ChannelInterface::CHANNEL_VALUE => trim($params['channel_value'] ?? ''),
            ChannelInterface::UNIQUE_NAME => trim($params['unique_name'] ?? '')
        ]);

        $validationResult = $this->channelValidator->validate($channel);
        if (!$validationResult->isValid()) {
            throw new ValidationException(__('Validation failed'), validationResult: $validationResult);
        }

        $this->channelRepository->save($channel);

        return $channel;
    }
}