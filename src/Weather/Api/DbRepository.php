<?php

namespace Weather\Api;

use Weather\Model\NullWeather;
use Weather\Model\Weather;

class DbRepository extends AbstractFileRepository implements DataProvider
{
    /**
     * @return Weather[]
     */
    protected function selectAll(): array
    {
        $result = [];
        $data = $this->selectDataFile('Data.json');
        foreach ($data as $item) {
            $record = new Weather();
            $record->setDate(new \DateTime($item['date']));
            $record->setDayTemp($item['dayTemp']);
            $record->setNightTemp($item['nightTemp']);
            $record->setSky($item['sky']);
            $result[] = $record;
        }
        return $result;
    }
}
