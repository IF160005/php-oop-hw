<?php

namespace Weather\Controller;

use Weather\Manager;
use Weather\Model\NullWeather;

class StartPage
{
    public function getTodayWeather($type): array
    {
        try {
            $service = new Manager($type);
            $weather = $service->getTodayInfo();
        } catch (\Exception $exp) {
            $weather = new NullWeather();
        }

        return ['template' => 'today-weather.twig', 'context' => ['weather' => $weather]];
    }

    public function getWeekWeather($type): array
    {
        try {
            $service = new Manager($type);
            $weathers = $service->getWeekInfo();
        } catch (\Exception $exp) {
            $weathers = [];
        }

        return ['template' => 'range-weather.twig', 'context' => ['weathers' => $weathers]];
    }
}
