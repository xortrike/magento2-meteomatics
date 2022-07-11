<?php
declare(strict_types=1);

namespace Meteomatics\Weather\CustomerData;

use Magento\Framework\DataObject;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Store\Model\ScopeInterface;
use Meteomatics\Weather\Model\ResourceModel\Weather\CollectionFactory as WeatherCollectionFactory;
use Meteomatics\Weather\Api\ConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;

class Weather extends DataObject implements SectionSourceInterface
{
    /**
     * @var WeatherCollectionFactory
     */
    private $weatherFactory;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Json
     */
    private $serializer;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param WeatherCollectionFactory $weatherFactory
     * @param Json $serializer
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        WeatherCollectionFactory $weatherFactory,
        Json $serializer,
        array $data = []
    ) {
        parent::__construct($data);

        $this->weatherFactory = $weatherFactory;
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }

    /**
     * @return array
     */
    public function getSectionData(): array
    {
        if (!$this->scopeConfig->getValue(ConfigInterface::ACTIVE, ScopeInterface::SCOPE_STORE)) {
            return [];
        }

        $collection = $this->weatherFactory->create();
        $collection->getSelect()->order('updated_at DESC');
        $data = $collection->getFirstItem()->getData();

        return $this->prepareData($data);
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepareData(array $data): array
    {
        if ($data['format'] === 'json') {
            return $this->parseJsonData($data['data']);
        }

        return [];
    }

    /**
     * @param string $json
     * @return array
     */
    private function parseJsonData(string $json): array
    {
        $data = $this->serializer->unserialize($json);

        $result = [];

        foreach ($data['data'] as $parameter) {
            if (str_starts_with($parameter['parameter'], 't_')) {
                $result['temperature'] = $parameter['coordinates'][0]['dates'][0]['value'];
            } else if (str_starts_with($parameter['parameter'], 'precip_')) {
                $result['precipitation'] = $parameter['coordinates'][0]['dates'][0]['value'];
            } else if (str_starts_with($parameter['parameter'], 'wind_speed_')) {
                $result['wind_speed'] = $parameter['coordinates'][0]['dates'][0]['value'];
            }
        }

        return $result;
    }
}
