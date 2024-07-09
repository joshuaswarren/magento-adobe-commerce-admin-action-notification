<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Plugin;

use Creatuity\AdminActionNotification\Api\Data\ObservableEntityInterface;
use Creatuity\AdminActionNotification\Api\ObservableRepositoryInterface;
use Creatuity\AdminActionNotification\Model\SendSelfNotification;
use Magento\Framework\Model\AbstractModel;
use Psr\Log\LoggerInterface;

class NotifyObservableChangePlugin
{
    public function __construct(
        private readonly SendSelfNotification $sendSelfNotification,
        private readonly LoggerInterface $logger
    ) {
    }

    public function aroundDelete(
        ObservableRepositoryInterface $subject,
        callable $proceed,
        AbstractModel $entity
    ) {
        if (!$entity instanceof ObservableEntityInterface || $entity->getSkipNotification()) {
            return $proceed($entity);
        }

        return $this->process($subject, $proceed, $entity);
    }

    public function aroundSave(
        ObservableRepositoryInterface $subject,
        callable $proceed,
        AbstractModel $entity
    ): AbstractModel
    {
        if (!$entity instanceof ObservableEntityInterface || $entity->getSkipNotification()) {
            return $proceed($entity);
        }

        return $this->process($subject, $proceed, $entity);
    }

    /**
     * @param ObservableRepositoryInterface $subject
     * @param callable $proceed
     * @param AbstractModel $entity
     */
    private function process(
        ObservableRepositoryInterface $subject,
        callable $proceed,
        ObservableEntityInterface $entity
    )
    {
        try {
            $before = null;

            if ($entity->getId()) {
                $before = $subject->getById((int)$entity->getId());
            }
        } catch (\Throwable $t) {
            $this->logger->error(NotifyObservableChangePlugin::class . ' error before', ['exception' => $t]);
        }

        $result = $proceed($entity);

        try {
            $this->sendSelfNotification->send($entity, $before);
        } catch (\Throwable $t) {
            $this->logger->error(NotifyObservableChangePlugin::class . ' error after', ['exception' => $t]);
        }

        return $result;
    }
}