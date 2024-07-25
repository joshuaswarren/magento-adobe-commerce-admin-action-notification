<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\OptionSource;

use Magento\Framework\Data\OptionSourceInterface;

class ChannelTypeOptionSource implements OptionSourceInterface
{
    /**
     * @return string[][]
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'slack', 'label' => 'Slack'],
            ['value' => 'email', 'label' => 'E-mail']
        ];
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        $arr = [];
        foreach ($this->toOptionArray() as $value) {
            $arr[$value['value']] = $value['label'];
        }

        return $arr;
    }
}