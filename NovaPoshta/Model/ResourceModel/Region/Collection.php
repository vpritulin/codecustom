<?php

namespace Perspective\NovaPoshta\Model\ResourceModel\Region;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * @package Perspective\NovaPoshta\Model\ResourceModel\Region
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Perspective\NovaPoshta\Model\Region', 'Perspective\NovaPoshta\Model\ResourceModel\Region');
    }

}
