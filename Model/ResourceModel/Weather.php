<?php
declare(strict_types=1);

namespace Meteomatics\Weather\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Weather extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('meteomatics', 'entity_id');
    }
}
