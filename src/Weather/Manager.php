<?php

namespace Weather;

use Weather\Api\DataProvider;
use Weather\Api\DbRepository;
use Weather\Api\GoogleApi;
use Weather\Api\WeatherApiRepository;
use Weather\Model\Weather;

class Manager
{
    /**
     * @var DataProvider
     */
    private $transporter;
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function getTodayInfo(): Weather
    {
        return $this->getTransporter()->selectByDate(new \DateTime());
    }

    public function getWeekInfo(): array
    {
        return $this->getTransporter()->selectByRange(new \DateTime(), new \DateTime('+7 days'));
    }

    private function getTransporter()
    {
        if (null === $this->transporter) {
            switch ($this->type) {
                case 'google':
                    $this->transporter = new GoogleApi();
                    break;
                case 'api':
                    $this->transporter= new WeatherApiRepository();
                    break;
                case 'db':
                default:
                    $this->transporter = new DbRepository();
                    break;
            }
        }

        return $this->transporter;
    }
}


