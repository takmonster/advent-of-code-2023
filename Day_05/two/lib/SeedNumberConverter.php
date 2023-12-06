<?php

declare(strict_types=1);

require_once(__DIR__ . '/RangeFinder.php');

class SeedNumberConverter
{
    private RangeFinder $soil_range_finder;
    private RangeFinder $fertilizer_range_finder;
    private RangeFinder $water_range_finder;
    private RangeFinder $light_range_finder;
    private RangeFinder $temperature_range_finder;
    private RangeFinder $humidity_range_finder;
    private RangeFinder $location_range_finder;

    public function __construct(
        RangeFinder $soil_range_finder,
        RangeFinder $fertilizer_range_finder,
        RangeFinder $water_range_finder,
        RangeFinder $light_range_finder,
        RangeFinder $temperature_range_finder,
        RangeFinder $humidity_range_finder,
        RangeFinder $location_range_finder,
    ) {
        $this->soil_range_finder = $soil_range_finder;
        $this->fertilizer_range_finder = $fertilizer_range_finder;
        $this->water_range_finder = $water_range_finder;
        $this->light_range_finder = $light_range_finder;
        $this->temperature_range_finder = $temperature_range_finder;
        $this->humidity_range_finder = $humidity_range_finder;
        $this->location_range_finder = $location_range_finder;
    }

    public function getValue(int $seed_number): int
    {
        $soil = $this->soil_range_finder->getMappedValue($seed_number);
        $fertilizer = $this->fertilizer_range_finder->getMappedValue($soil);
        $water = $this->water_range_finder->getMappedValue($fertilizer);
        $light = $this->light_range_finder->getMappedValue($water);
        $temperature = $this->temperature_range_finder->getMappedValue($light);
        $humidity = $this->humidity_range_finder->getMappedValue($temperature);
        $location = $this->location_range_finder->getMappedValue($humidity);
        return $location;
    }
}
