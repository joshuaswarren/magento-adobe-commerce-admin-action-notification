<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Ui\Form;

use Creatuity\AdminActionNotification\Api\Data\ChannelInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;

class ChannelFormDataProvider extends DataProvider
{
    /**
     * @throws LocalizedException
     */
    protected function searchResultToOutput(SearchResultInterface $searchResult): array
    {
        $requestFieldName = $this->getRequestFieldName();
        $id = (int)$this->request->getParam($requestFieldName);

        $data = parent::searchResultToOutput($searchResult);

        $item = reset($data['items']);

        if (!$item) {
            return [];
        }

        if ((int)$item[ChannelInterface::CHANNEL_ID] !== $id) {
            throw new LocalizedException(__('Something went wrong. Channel %1 data cannot be determined', $id));
        }

        return [$item[ChannelInterface::CHANNEL_ID] ?? '' => $item];
    }
}