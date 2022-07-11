<?php
declare(strict_types=1);

namespace Meteomatics\Weather\Cron;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Meteomatics\Weather\Api\Data\WeatherInterfaceFactory;
use Magento\Framework\Encryption\EncryptorInterface;
use Meteomatics\Weather\Api\ConfigInterface;

class Weather
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    /**
     * @var Curl
     */
    private $curl;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var WeatherInterfaceFactory
     */
    private $weatherFactory;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param EncryptorInterface $encryptor
     * @param Curl $curl
     * @param DateTime $date
     * @param WeatherInterfaceFactory $weatherFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        EncryptorInterface $encryptor,
        Curl $curl,
        DateTime $date,
        WeatherInterfaceFactory $weatherFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->encryptor = $encryptor;
        $this->curl = $curl;
        $this->date = $date;
        $this->weatherFactory = $weatherFactory;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        if ($this->scopeConfig->getValue(ConfigInterface::ACTIVE, ScopeInterface::SCOPE_STORE)) {
            $format = $this->scopeConfig->getValue(ConfigInterface::FORMAT, ScopeInterface::SCOPE_STORE);
            $apiData = $this->getMeteoData($format);

            $weatherModel = $this->weatherFactory->create();
            $weatherModel->addData([
                'format' => $format,
                'data' => $apiData
            ]);
            $weatherModel->save();
        }
    }

    /**
     * Get weather data via API
     * @param string $format
     * @return string
     */
    private function getMeteoData(string $format): string
    {
        // Set Basic Authorization in Curl
        $username = $this->scopeConfig->getValue(ConfigInterface::LOGIN, ScopeInterface::SCOPE_STORE);
        $password = $this->scopeConfig->getValue(ConfigInterface::PASSWORD, ScopeInterface::SCOPE_STORE);
        $password = $this->encryptor->decrypt($password);
        $this->curl->setCredentials($username, $password);

        // Merge URL and get data
        $url = implode('/', [
            'https://' . $this->scopeConfig->getValue(ConfigInterface::SERVER, ScopeInterface::SCOPE_STORE),
            $this->date->gmtDate('Y-m-d\TH:i:s\Z'),
            implode(',', ['t_2m:C', 'precip_1h:mm', 'wind_speed_10m:ms']),
            implode(',', [
                $this->scopeConfig->getValue(ConfigInterface::LATITUDE, ScopeInterface::SCOPE_STORE),
                $this->scopeConfig->getValue(ConfigInterface::LONGITUDE, ScopeInterface::SCOPE_STORE)
            ]),
            $format
        ]);
        $this->curl->get($url);

        // Output of curl request
        return $this->curl->getBody();
    }
}
