<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Ui\Listing\Component;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class ChannelColumnActions extends Column
{
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        private readonly UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }
        foreach ($dataSource['data']['items'] as & $item) {
            $name = $this->getData('name');
            $item[$name]['edit'] = [
                'href' => $this->urlBuilder->getUrl(
                    'creatuity_admin_notification/channel/form',
                    ['id' => $item[ChannelInterface::CHANNEL_ID]]
                ),
                'label' => __('Edit')
            ];
            $item[$name]['delete'] = [
                'href' => $this->urlBuilder->getUrl(
                    'creatuity_admin_notification/channel/delete',
                    ['id' => $item[ChannelInterface::CHANNEL_ID]]
                ),
                'label' => __('Delete'),
                'post' => true,
                'confirm' => [
                    'title' => __('Delete Channel %1', $item[ChannelInterface::CHANNEL_ID]),
                    'message' => __(
                        'Are you sure you wan\'t to delete the channel?'
                    )
                ]
            ];
        }

        return $dataSource;
    }
}