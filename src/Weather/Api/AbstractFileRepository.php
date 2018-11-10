<?php
/**
 * Created by PhpStorm.
 * User: sigita
 * Date: 18.11.10
 * Time: 12.08
 */

namespace Weather\Api;


use Weather\Model\NullWeather;
use Weather\Model\Weather;

abstract class AbstractFileRepository
{
    /**
     * @param \DateTime $date
     * @return Weather
     */
    public function selectByDate(\DateTime $date): Weather
    {
        $items = $this->selectAll();
        $result = new NullWeather();

        foreach ($items as $item) {
            if ($item->getDate()->format('Y-m-d') === $date->format('Y-m-d')) {
                $result = $item;
            }
        }

        return $result;
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @return array
     */

    public function selectByRange(\DateTime $from, \DateTime $to): array
    {
        $items = $this->selectAll();
        $result = [];

        foreach ($items as $item) {
            if ($item->getDate() >= $from && $item->getDate() <= $to) {
                $result[] = $item;
            }
        }

        return $result;
    }

    public function selectDataFile($fileName)
    {
        return json_decode(
            file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Db' . DIRECTORY_SEPARATOR . $fileName),
            true
        );
    }

    /**
     * @return Weather[]
     */
    abstract protected function selectAll(): array;

}