<?php

namespace Perspective\NovaPoshta\Api\Data;

/**
 * Interface SynchronizeRegionInterface
 *
 * @package Perspective\NovaPoshta\Api\Data
 */
interface SynchronizeRegionInterface
{
    public const ENTITY_ID = 'entity_id';
    public const DESCRIPTION = 'description';
    public const REF = 'ref';
    public const AREA = 'area';
    public const SETTLEMENT_TYPE = 'settlement_type';
    public const IS_BRANCH = 'is_branch';
    public const PREVENT_ENTITY_NEW_STREETS_USER = 'prevent_entry_new_streets_user';
    public const CONGLOMERATION = 'conglomerates';
    public const CITY_ID = 'city_id';
    public const SETTLEMENT_TYPE_DESCRIPTION = 'settlement_type_description';
    public const AREA_DESCRIPTION = 'area_description';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public function getRegionsFromApiNP();

    /**
     * Set Description
     *
     * @param string $description
     */
    public function setDescription(string $description):void;

    /**
     *  Get Description
     *
     * @return string|null
     */
    public function getDescription():?string;

    /**
     * Set Ref
     *
     * @param string $ref
     */
    public function setRef(string $ref):void;

    /**
     * Get Ref
     *
     * @return  string|null
     */
    public function getRef(): ? string;

    /**
     * Set Area
     *
     * @param string $area
     */
    public function setArea(string $area):void;

    /**
     * Get Area
     *
     * @return  string|null
     */
    public function getArea():string;

    /**
     * Set Settlement Type
     *
     * @param string $type
     */
    public function setSettlementType(string $type):void;

    /**
     * Get Settlement Type
     *
     * @return  string|null
     */
    public function getSettlementType():string;

    /**
     * Set Is Branch
     *
     * @param string $isBranch
     */
    public function setIsBranch(string $isBranch):void;

    /**
     * Fet Is Branch
     *
     * @return string|null
     */
    public function getIsBranch():string;

    /**
     * Set Prevent Entry New Streets User
     *
     * @param string $entry
     */
    public function setPreventEntryNewStreetsUser(string $entry):void;

    /**
     * Get Prevent Entry New Streets User
     *
     * @return  string|null
     */
    public function getPreventEntryNewStreetsUser():?string;

    /**
     * Set Conglomerates
     *
     * @param $conglomerates
     */
    public function setConglomerates($conglomerates):void;

    /**
     * Get Conglomerates
     *
     * @return  string|null
     */
    public function getConglomerates():string;

    /**
     * Set City Id
     *
     * @param $cityId
     */
    public function setCityId($cityId):void;

    /**
     * Get City Id
     *
     * @return  string|null
     */
    public function getCityId():?string;

    /**
     * Set Settlement Type Description
     *
     * @param string $settlementTypeDescription
     */
    public function setSettlementTypeDescription(string $settlementTypeDescription):void;

    /**
     * Get Settlement Type Description
     *
     * @return  string|null
     */
    public function getSettlementTypeDescription():string;

    /**
     * Set Area Description
     *
     * @param string $areaDescription
     */
    public function setAreaDescription(string $areaDescription):void;

    /**
     * Get Area Description
     *
     * @return  string|null
     */
    public function getAreaDescription():?string;

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Set created at
     *
     * @param string|null $date
     */
    public function setCreatedAt(?string $date): void;

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Set updated at
     *
     * @param string|null $date
     */
    public function setUpdatedAt(?string $date): void;
}
