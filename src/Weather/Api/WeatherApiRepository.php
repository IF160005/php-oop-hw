<?php
/**
 * Created by PhpStorm.
 * User: sigita
 * Date: 18.11.10
 * Time: 12.03
 */

namespace Weather\Api;


use Weather\Model\Weather;

class WeatherApiRepository extends AbstractFileRepository implements DataProvider
{
    /**
     * @return Weather[]
     */
    protected function selectAll(): array
    {
        $result = [];
        $data = $this->selectDataFile('Weather.json');
        foreach ($data as $item) {
            $record = new Weather();
            $record->setDate(new \DateTime($item['date']));
            $record->setDayTemp($item['high']);
            $record->setNightTemp($item['low']);
            $record->setSky($this->getSky($item['text']));
            $result[] = $record;
        }
        return $result;
    }
    /**
     * @return int
     */
    private function getSky($text) :int
    {
        switch ($text) {
            case 'Cloudy':
            case 'Mostly Cloudy':
            case 'Partly Cloudy':
                return 1;
            case 'Scattered Showers':
                return 2;
            case 'Breezy':
                return 4;
            default:
                return 3;
        }
    }
}