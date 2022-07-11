<?php
declare(strict_types=1);

namespace Meteomatics\Weather\Model;

use Magento\Framework\Model\AbstractModel;
use Meteomatics\Weather\Api\Data\WeatherInterface;
use Meteomatics\Weather\Model\ResourceModel\Weather as WeatherResourceModel;

class Weather extends AbstractModel implements WeatherInterface
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(WeatherResourceModel::class);
    }
}
