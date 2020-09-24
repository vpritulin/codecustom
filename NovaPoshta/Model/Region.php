<?php

namespace Perspective\NovaPoshta\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Perspective\NovaPoshta\Api\Data\SynchronizeRegionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Stdlib\DateTime\DateTimeFactory;

/**
 * Class Region
 *
 * @package Perspective\NovaPoshta\Model
 */
class Region extends AbstractModel implements SynchronizeRegionInterface
{
    /**
     * Nova Poshta NP_API_URL
     */
    const NP_API_URL = 'https://api.novaposhta.ua/v2.0/json/';

    /**
     * @var ZendClientFactory
     */
    private $zendClientFactory;

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var DateTimeFactory
     */
    private $dateFactory;

    /**
     * Region constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param ZendClientFactory $zendClientFactory
     * @param JsonFactory $jsonFactory
     * @param DateTimeFactory $dateFactory
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ZendClientFactory $zendClientFactory,
        JsonFactory $jsonFactory,
        DateTimeFactory $dateFactory,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
        $this->dateFactory = $dateFactory;
        $this->jsonFactory = $jsonFactory;
        $this->zendClientFactory = $zendClientFactory;
    }

    protected function _construct()
    {
        $this->_init('Perspective\NovaPoshta\Model\ResourceModel\Region');
    }

    public function getRegionsFromApiNP()
    {
        $requestData = [
                'modelName' => 'Address',
                'calledMethod' => 'getCities',
                'methodProperties' => [
                    'Ref' => ''
                ],
                'apiKey' => '436f2bc8c592eb2d924da5544daf1b92'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::NP_API_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));

        $result = json_decode(curl_exec($ch),true);
        curl_close($ch);

        if ($result === false) {
            return false;
        } else {
            return $result['data'];
        }
    }

    /**
     * @param string $areaDescription
     */
    public function setAreaDescription(string $areaDescription): void
    {
        $this->setData(self::AREA_DESCRIPTION, $areaDescription);
    }

    /**
     * @return string|null
     */
    public function getAreaDescription(): ?string
    {
        return $this->getData(self::AREA_DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(?string $date): void
    {
        $this->setData(self::CREATED_AT, $date);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt(?string $date): void
    {
        $this->setData(self::UPDATED_AT, $date);
    }

    /**
     * @inheritDoc
     */
    public function beforeSave(): Region
    {
        parent::beforeSave();

        $currentDate = $this->dateFactory->create()->gmtDate();
        if (!$this->getCreatedAt()) {
            $this->setCreatedAt($currentDate);
        }

        return $this;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @param string $ref
     */
    public function setRef(string $ref): void
    {
        $this->setData(self::REF, $ref);
    }

    /**
     * @return string|null
     */
    public function getRef(): ?string
    {
        return $this->getData(self::REF);
    }

    /**
     * @param string $area
     */
    public function setArea(string $area): void
    {
        $this->setData(self::AREA, $area);
    }

    /**
     * @return string
     */
    public function getArea(): string
    {
        return $this->getData(self::AREA);
    }

    /**
     * @param string $type
     */
    public function setSettlementType(string $type): void
    {
        $this->setData(self::SETTLEMENT_TYPE, $type);
    }

    /**
     * @return string
     */
    public function getSettlementType(): string
    {
        return $this->getData(self::SETTLEMENT_TYPE);
    }

    /**
     * @param string $isBranch
     */
    public function setIsBranch(string $isBranch): void
    {
        $this->setData(self::IS_BRANCH, $isBranch);
    }

    /**
     * @return string
     */
    public function getIsBranch(): string
    {
        return $this->getData(self::IS_BRANCH);
    }

    /**
     * @param $entry
     */
    public function setPreventEntryNewStreetsUser($entry): void
    {
        $this->setData(self::PREVENT_ENTITY_NEW_STREETS_USER, $entry);
    }

    /**
     * @return null|string
     */
    public function getPreventEntryNewStreetsUser():?string
    {
        return $this->getData(self::PREVENT_ENTITY_NEW_STREETS_USER);
    }

    /**
     * @param $conglomerates
     */
    public function setConglomerates($conglomerates): void
    {
        $this->setData(self::CONGLOMERATION, $conglomerates);
    }

    /**
     * @return string
     */
    public function getConglomerates(): string
    {
        return $this->getData(self::CONGLOMERATION);
    }

    /**
     * @param $cityId
     */
    public function setCityId($cityId): void
    {
        $this->setData(self::CITY_ID, $cityId);
    }

    /**
     * @return string|null
     */
    public function getCityId(): ?string
    {
        return $this->getData(self::CITY_ID);
    }

    /**
     * @param string $settlementTypeDescription
     */
    public function setSettlementTypeDescription(string $settlementTypeDescription): void
    {
        $this->setData(self::SETTLEMENT_TYPE_DESCRIPTION, $settlementTypeDescription);
    }

    /**
     * @return string
     */
    public function getSettlementTypeDescription(): string
    {
        return $this->getData(self::SETTLEMENT_TYPE_DESCRIPTION);
    }
}
