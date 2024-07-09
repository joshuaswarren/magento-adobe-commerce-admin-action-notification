<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Notification;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Creatuity\AdminActionNotification\Api\Data\RuleInterface;
use Creatuity\AdminActionNotification\Api\RuleRepositoryRepositoryInterface;
use Creatuity\AdminActionNotification\Api\Service\NotificationSendInterface;
use Creatuity\AdminActionNotification\Model\Notification\Collector\CollectRuleNotificationData;
use Creatuity\AdminActionNotification\Model\ResourceModel\Channel\CollectionFactory;
use Psr\Log\LoggerInterface;
use Zend_Db_Statement_Exception;

class RunNotificationRule
{
    public function __construct(
        private readonly CollectRuleNotificationData $collectRuleNotificationData,
        private readonly CollectionFactory $collectionFactory,
        private readonly NotificationSendInterface $notificationSender,
        private readonly RuleRepositoryRepositoryInterface $ruleRepository,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @param RuleInterface $rule
     * @return void
     * @throws Zend_Db_Statement_Exception|\Exception
     */
    public function execute(RuleInterface $rule): void
    {
        $channels = $this->collectionFactory->create();
        $channels->addFieldToFilter(ChannelInterface::CHANNEL_ID, ['in' => $rule->getChannels()]);

        $notificationData = $this->collectRuleNotificationData->collect($rule);

        if (!$notificationData) {
            return;
        }

        $notified = false;
        /** @var \Creatuity\AdminActionNotification\Model\Channel $channel */
        foreach ($channels as $channel) {
            if (!$this->notificationSender->send($notificationData, $channel)) {
                $this->logger->error(
                    'Failed to send notification',
                    ['chaneel' => $channel->getData(), 'rule' => $rule->getData()]
                );
                continue;
            }
            $notified = true;
        }

        if ($notified) {
            $rule->setSkipNotification(true);
            $rule->setLastNotification(date('Y-m-d H:i:s'));
            $this->ruleRepository->save($rule);
        }
    }
}