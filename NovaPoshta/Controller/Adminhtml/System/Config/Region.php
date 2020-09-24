<?php
declare(strict_types=1);

namespace Perspective\NovaPoshta\Controller\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Perspective\NovaPoshta\Api\Data\SynchronizeRegionInterface;
use Perspective\NovaPoshta\Api\RegionFactoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * Class Region
 *
 * @package Perspective\NovaPoshta\Controller\Adminhtml\System\Config
 */
class Region extends Action
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var SynchronizeRegionInterface
     */
    private $region;

    /**
     * @var RegionFactoryInterface
     */
    private $regionFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param SynchronizeRegionInterface $synchronizeRegion
     * @param RegionFactoryInterface $regionFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        SynchronizeRegionInterface $synchronizeRegion,
        RegionFactoryInterface $regionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->region = $synchronizeRegion;
        $this->regionFactory = $regionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context);
    }

    /**
     * Collect relations data
     *
     * @return Json
     */
    public function execute()
    {
        try {
            $regions = $this->region->getRegionsFromApiNP();
            foreach ($regions as $region){
                $id = $this->regionFactory->getById((int)$region['CityID']);
                if ($id === null){
                    $this->region->setDescription($region['DescriptionRu']);
                    $this->region->setRef($region['Ref']);
                    $this->region->setArea($region['Area']);
                    $this->region->setAreaDescription($region['AreaDescriptionRu']);
                    if (array_key_exists('SettlementTypeDescriptionRu',$region) && array_key_exists('SettlementType',$region)){
                        $this->region->setSettlementTypeDescription($region['SettlementTypeDescriptionRu']);
                        $this->region->setSettlementType($region['SettlementType']);
                    }
                    $this->region->setIsBranch($region['IsBranch']);
                    $this->region->setPreventEntryNewStreetsUser($region['PreventEntryNewStreetsUser']);
                    if (array_key_exists('SettlementType',$region) && array_key_exists('SettlementTypeDescriptionRu',$region)){
                        $this->region->setSettlementTypeDescription($region['SettlementTypeDescriptionRu']);
                        $this->region->setSettlementType($region['SettlementType']);
                    }
                    $this->region->setCityId($region['CityID']);
                    $this->region->save();
                    $this->region->unsetData();
                }
            }

        } catch (\Exception $e) {
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
        }

        $result = $this->resultJsonFactory->create();

        return $result->setData(['success' => true]);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Perspective_NovaPoshta::config');
    }
}
