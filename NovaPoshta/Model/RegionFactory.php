<?php

namespace Perspective\NovaPoshta\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\TemporaryState\CouldNotSaveException;
use Perspective\NovaPoshta\Api\Data\SynchronizeRegionInterface;
use Perspective\NovaPoshta\Api\Data\SynchronizeRegionInterfaceFactory;
use Perspective\NovaPoshta\Api\RegionFactoryInterface;
use Perspective\NovaPoshta\Api\RegionFactoryInterfaceFactory;
use Perspective\NovaPoshta\Model\ResourceModel\Region as ResourceModel;
use Perspective\NovaPoshta\Model\ResourceModel\Region\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

/**
 * Class RegionFactory
 *
 * @package Perspective\NovaPoshta\Model
 */
class RegionFactory implements RegionFactoryInterface
{
    /**
     * @var ResourceModel
     */
    private $_resourceRegion;

    /**
     * @var SynchronizeRegionInterfaceFactory
     */
    private $_synchronizeRegionInterfaceFactory;

    /**
     * @var SynchronizeRegionInterface
     */
    private $synchronizeRegionInterface;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var RegionFactoryInterfaceFactory
     */
    private $regionFactoryInterface;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsInterfaceFactory;

    /**
     * RegionFactory constructor.
     *
     * @param ResourceModel $resourceRegion
     * @param SynchronizeRegionInterfaceFactory $synchronizeRegionInterfaceFactory
     * @param SynchronizeRegionInterface $synchronizeRegion
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param RegionFactoryInterfaceFactory $regionFactoryInterfaceFactory
     * @param SearchResultsInterfaceFactory $searchResultsInterfaceFactory
     */
    public function __construct(
        ResourceModel $resourceRegion,
        SynchronizeRegionInterfaceFactory $synchronizeRegionInterfaceFactory,
        SynchronizeRegionInterface $synchronizeRegion,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        RegionFactoryInterfaceFactory $regionFactoryInterfaceFactory,
        SearchResultsInterfaceFactory $searchResultsInterfaceFactory
    ) {
        $this->_resourceRegion = $resourceRegion;
        $this->_synchronizeRegionInterfaceFactory = $synchronizeRegionInterfaceFactory;
        $this->synchronizeRegionInterface = $synchronizeRegion;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->regionFactoryInterface = $regionFactoryInterfaceFactory;
        $this->searchResultsInterfaceFactory = $searchResultsInterfaceFactory;
    }


    /**
     * @param $cityId
     *
     * @return SynchronizeRegionInterface|null
     */
    public function getById($cityId): ? SynchronizeRegionInterface
    {
        $city = $this->_synchronizeRegionInterfaceFactory->create();
        $this->_resourceRegion->load($city, $cityId,'city_id');
        if (!$city->getCityId()) {
           return null;
        }

        return $city;
    }

    /**
     * @param SynchronizeRegionInterface $synchronizeRegion
     *
     * @return SynchronizeRegionInterface
     *
     * @throws CouldNotSaveException
     */
    public function save(SynchronizeRegionInterface $synchronizeRegion): SynchronizeRegionInterface
    {
        try {
            $this->_resourceRegion->save($synchronizeRegion);
        } catch (\Throwable $throwable) {
            throw new CouldNotSaveException(
                __('Could not save the object: %1', $throwable->getMessage()),
                $throwable
            );
        }
        return $synchronizeRegion;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $region = $this->searchResultsInterfaceFactory->create();
        $region->setSearchCriteria($searchCriteria);

        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $region->setItems($collection->getItems());
        $region->setTotalCount($collection->getSize());
        return $region;
    }

    /**
     * @param $cityId
     *
     * @return SynchronizeRegionInterface
     *
     * @throws CouldNotDeleteException
     */
    public function deleteById($cityId): SynchronizeRegionInterface
    {
        try {
            $city = $this->getById($cityId);
            $this->_resourceRegion->delete($cityId);
        } catch (\Throwable $throwable) {
            throw new CouldNotDeleteException(
                __('Could not delete the object: %1', $throwable->getMessage()),
                $throwable
            );
        }
        return $city;
    }
}
