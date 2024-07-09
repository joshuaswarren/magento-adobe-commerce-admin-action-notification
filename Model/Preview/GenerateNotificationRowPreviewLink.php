<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Preview;

use Creatuity\AdminActionNotification\Api\Data\NotificationRowInterface;
use Magento\Framework\Url\ScopeInterface;
use Magento\Framework\UrlFactory;

class GenerateNotificationRowPreviewLink
{
    public function __construct(
        private readonly UrlFactory $urlFactory
    ) {
    }

    public function generate(NotificationRowInterface $notificationRow)
    {
        $hash = $this->getHash($notificationRow);

        $link = $this->urlFactory->create()
            ->setScope(ScopeInterface::SCOPE_DEFAULT)
            ->getUrl('creatuity_admin_notification/preview/index', ['key' => $hash, 'id' => $notificationRow->getId()]);

        $notificationRow->setResultLink($link);

        return $link;
    }

    public function getHash(NotificationRowInterface $notificationRow): string
    {
        return hash(
            'sha256',
            $notificationRow->getId() .
            $notificationRow->getResultData() .
            $notificationRow->getSourceId()
        );
    }
}