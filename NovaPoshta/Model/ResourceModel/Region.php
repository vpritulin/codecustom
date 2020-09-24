<?php

namespace Perspective\NovaPoshta\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class Region
 *
 * @package Perspective\NovaPoshta\Model\ResourceModel
 */
class Region extends AbstractDb
{
    /**
     * Region constructor.
     *
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('np_city', 'entity_id');
    }
}
