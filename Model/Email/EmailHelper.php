<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Model\Email;

use Magento\Framework\App\Area;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\State;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\Store;
use Psr\Log\LoggerInterface;

class EmailHelper extends AbstractHelper
{
    private array $data = [];
    private string $template = '';
    /** @var string[] */
    private array $sender = [];

    public function __construct(
        Context $context,
        private readonly StateInterface $inlineTranslation,
        private readonly TransportBuilder $transportBuilder,
        private readonly LoggerInterface $logger,
        private readonly State $state
    )
    {
        parent::__construct($context);
    }

    public function setSender(string $name, string $email): void
    {
        $this->sender = [
            'name' => $name,
            'email' => $email
        ];
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    public function sendEmail(string $recieverEmail): bool
    {
        $result = false;
        $this->state->emulateAreaCode(Area::AREA_FRONTEND, function () use ($recieverEmail, &$result) {
            $result = $this->send($recieverEmail);
        });

        return $result;
    }

    private function send(string $recieverEmail): bool
    {
        try {
            $this->inlineTranslation->suspend();
            $sender = $this->sender ?: [
                'name' => $this->scopeConfig->getValue('trans_email/ident_general/name'),
                'email' => $this->scopeConfig->getValue('trans_email/ident_general/email'),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($this->template)
                ->setTemplateOptions([
                    'area' => Area::AREA_FRONTEND,
                    'store' => Store::DEFAULT_STORE_ID,
                ])
                ->setTemplateVars($this->data)
                ->setFromByScope($sender)
                ->addTo($recieverEmail)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());

            return false;
        }

        return true;
    }
}