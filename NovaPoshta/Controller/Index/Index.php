<?php

namespace Perspective\NovaPoshta\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Layout;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultFactory;
use Perspective\NovaPoshta\Api\RegionFactoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * Class Index
 *
 * @package Perspective\NovaPoshta\Controller\Index\Index
 */
class Index extends Action
{
    /**
     * @var RegionFactoryInterface
     */
    private $_regionFactory;

    /**
     * Index resultPageFactory
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Json Factory
     *
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $jsonFactory
     * @param RegionFactoryInterface $regionFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $jsonFactory,
        RegionFactoryInterface $regionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->resultJsonFactory = $jsonFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->_regionFactory = $regionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|Layout
     */
    public function execute()
    {
        $response = $this->_regionFactory->getList($this->searchCriteriaBuilder->create());
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $regions = [];
        foreach ($response->getItems() as $item){
            $regions[] = $item->getDescription();;
        }

        $result->setData($regions);
        return $result;
    }
}
