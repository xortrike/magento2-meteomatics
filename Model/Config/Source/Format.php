<?php
declare(strict_types=1);

namespace Meteomatics\Weather\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Format implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'json', 'label' => __('JSON')],
            ['value' => 'xml',  'label' => __('XML')],
            ['value' => 'csv',  'label' => __('CSV')]
        ];
    }
}
