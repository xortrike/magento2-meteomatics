<?php
declare(strict_types=1);

namespace Meteomatics\Weather\Model\ResourceModel\Weather;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Meteomatics\Weather\Model\Weather as WeatherModel;
use Meteomatics\Weather\Model\ResourceModel\Weather as WeatherResourceModel;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            WeatherModel::class,
            WeatherResourceModel::class
        );
    }
}
