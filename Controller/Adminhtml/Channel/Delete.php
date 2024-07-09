<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Controller\Adminhtml\Channel;

use Creatuity\AdminActionNotification\Api\ChannelRepositoryRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpDeleteActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;

class Delete extends Action implements HttpDeleteActionInterface, HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Creatuity_AdminActionNotification::admin_action_notification_channels';

    public function __construct(
        Context $context,
        private readonly RequestInterface $request,
        private readonly ChannelRepositoryRepositoryInterface $channelRepository,
        private readonly RedirectFactory $redirectFactory,
        private readonly ManagerInterface $messanger,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $id = (int)$this->request->getParam('id');
        try {
            $this->channelRepository->deleteById($id);
            $this->messanger->addSuccessMessage(__('Channel has been removed'));
        } catch (LocalizedException $e) {
            $this->messanger->addExceptionMessage($e);
        } catch (\Throwable $e) {
            $this->messanger->addErrorMessage(__('Unknown error has occured!'));
            $this->logger->error('Error while removing channel ' . $id, ['exception' => $e, 'params' => $this->request->getParams()]);
        }

        return $this->redirectFactory->create()->setPath('*/*/index');
    }
}