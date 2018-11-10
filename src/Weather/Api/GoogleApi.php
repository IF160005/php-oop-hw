<?php

namespace Weather\Api;

use Weather\Model\NullWeather;
use Weather\Model\Weather;

class GoogleApi implements DataProvider
{
    /**
     * @param \DateTime $date
     * @return Weather
     * @throws \Exception
     */
    public function selectByDate(\DateTime $date): Weather
    {

        $today = $this->load(new NullWeather());
        $today->setDate($date);

        return $today;
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @return array
     * @throws \Exception
     */

    public function selectByRange(\DateTime $from, \DateTime $to): array
    {
        $week = array();
        for ($i = clone $from; $i < $to; $i->modify('+1 day')) {
            if ($i->format('Y-m-d') === $from->format('Y-m-d')) {
                continue;
            }
            $week[] = $this->selectByDate(clone $i);
        }
        return $week;
    }

    /**
     * @param Weather $before
     * @return Weather
     * @throws \Exception
     */
    private function load(Weather $before)
    {
        $now = new Weather();
        $base = $before->getDayTemp();
        $now->setDayTemp(random_int(5 - $base, 5 + $base));

        $base = $before->getNightTemp();
        $now->setNightTemp(random_int(-5 - abs($base), -5 + abs($base)));

        $now->setSky(random_int(1, 3));

        return $now;
    }
}
