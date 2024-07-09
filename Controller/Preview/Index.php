<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Controller\Preview;

use Creatuity\AdminActionNotification\Model\Preview\PreviewKeyValidator;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    public function __construct(
        private readonly RequestInterface $request,
        private readonly PreviewKeyValidator $previewKeyValidator,
        private readonly PageFactory $pageFactory
    ) {
    }

    public function execute(): ResultInterface
    {
        $id = (int)$this->request->getParam('id');
        $key = (string)$this->request->getParam('key');

        if (!$this->previewKeyValidator->check($id, $key)) {
            throw new \Exception('Forbidden', code: 403);
        }

        return $this->pageFactory->create();
    }
}