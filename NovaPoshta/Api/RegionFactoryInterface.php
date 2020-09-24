<?php

namespace Perspective\NovaPoshta\Api;

use Perspective\NovaPoshta\Api\Data\SynchronizeRegionInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface RegionFactoryInterface
 *
 * @package Perspective\NovaPoshta\Api
 */
interface RegionFactoryInterface
{
    /**
     * @param $cityId
     *
     * @return SynchronizeRegionInterface|null
     */
    public function getById($cityId): ?SynchronizeRegionInterface;

    /**
     * @param SynchronizeRegionInterface $synchronizeRegion
     *
     * @return SynchronizeRegionInterface
     */
    public function save(SynchronizeRegionInterface $synchronizeRegion):SynchronizeRegionInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * @param $studyPoolId
     *
     * @return SynchronizeRegionInterface
     */
    public function deleteById($studyPoolId): SynchronizeRegionInterface;
}
