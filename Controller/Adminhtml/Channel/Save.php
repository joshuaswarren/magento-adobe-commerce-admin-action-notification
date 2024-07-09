<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Controller\Adminhtml\Channel;

use Creatuity\AdminActionNotification\Model\Channel\ChannelSaveProcessor;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Validation\ValidationException;
use Psr\Log\LoggerInterface;

class Save extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Creatuity_AdminActionNotification::admin_action_notification_channels';

    public function __construct(
        Context $context,
        private readonly RequestInterface $request,
        private readonly ChannelSaveProcessor $saveProcessor,
        private readonly RedirectFactory $redirectFactory,
        private readonly LoggerInterface $logger,
        private readonly ManagerInterface $messanger
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        try {
            $chnnel = $this->saveProcessor->process($this->request->getParams());
            $this->messanger->addSuccessMessage(__('Channel "%1" has been saved', $chnnel->getUniqueName()));
        } catch (ValidationException $e) {
            foreach ($e->getErrors() as $error) {
                $this->messanger->addExceptionMessage($error);
            }
        } catch (LocalizedException $e) {
            $this->messanger->addExceptionMessage($e);
        } catch (\Throwable $e) {
            $this->messanger->addErrorMessage(__('Unknown error has occured!'));
            $this->logger->error('Channel saving error', ['exception' => $e]);
        }

        $result = $this->redirectFactory->create();
        $result->setPath('*/*');

        return $result;
    }
}