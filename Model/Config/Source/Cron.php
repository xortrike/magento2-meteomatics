<?php
declare(strict_types=1);

namespace Meteomatics\Weather\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Cron implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => '*/10 * * * *', 'label' => __('Every 10 min.')],
            ['value' => '0 * * * *',  'label' => __('Every hours')],
            ['value' => '0 0 * * *',  'label' => __('Every day')]
        ];
    }
}
