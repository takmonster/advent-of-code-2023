<?php

declare(strict_types=1);

require_once(__DIR__ . '/lib/RangeLine.php');
require_once(__DIR__ . '/lib/RangeFinder.php');
require_once(__DIR__ . '/lib/SeedNumberConverter.php');

$seed_starting_value = $argv[1];
$seed_range_length = $argv[2];

$seed_number_converter = new SeedNumberConverter(
    new RangeFinder(array_map(
        'RangeLine::fromInput',
        file(__DIR__ . '/../inputs/seeds-to-soil.txt', FILE_IGNORE_NEW_LINES)
    )),
    new RangeFinder(array_map(
        'RangeLine::fromInput',
        file(__DIR__ . '/../inputs/soil-to-fertilizer.txt', FILE_IGNORE_NEW_LINES)
    )),
    new RangeFinder(array_map(
        'RangeLine::fromInput',
        file(__DIR__ . '/../inputs/fertilizer-to-water.txt', FILE_IGNORE_NEW_LINES)
    )),
    new RangeFinder(array_map(
        'RangeLine::fromInput',
        file(__DIR__ . '/../inputs/water-to-light.txt', FILE_IGNORE_NEW_LINES)
    )),
    new RangeFinder(array_map(
        'RangeLine::fromInput',
        file(__DIR__ . '/../inputs/light-to-temperature.txt', FILE_IGNORE_NEW_LINES)
    )),
    new RangeFinder(array_map(
        'RangeLine::fromInput',
        file(__DIR__ . '/../inputs/temperature-to-humidity.txt', FILE_IGNORE_NEW_LINES)
    )),
    new RangeFinder(array_map(
        'RangeLine::fromInput',
        file(__DIR__ . '/../inputs/humidity-to-location.txt', FILE_IGNORE_NEW_LINES)
    )),
);

$minimum_location = 0;

for ($i = 0; $i < $seed_range_length; $i++) {
    $seed_number = $seed_starting_value + $i;
    echo "Seed number: $seed_number\n";
    $location = $seed_number_converter->getValue($seed_number);
    if ($location < $minimum_location || ($minimum_location === 0 && $location !== 0)) {
        $minimum_location = $location;
    }
}

var_dump($minimum_location);
