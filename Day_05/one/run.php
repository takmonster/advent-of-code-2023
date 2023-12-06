<?php

declare(strict_types=1);

require_once(__DIR__ . '/lib/RangeLine.php');
require_once(__DIR__ . '/lib/RangeFinder.php');
require_once(__DIR__ . '/lib/SeedNumberConverter.php');

$seed_lines = file(__DIR__ . '/../inputs/seeds.txt', FILE_IGNORE_NEW_LINES);
$seeds = array_map('intval', explode(' ', $seed_lines[0]));

$locations = [];

foreach ($seeds as $seed) {
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
    $locations[] = $seed_number_converter->getValue($seed);
}

var_dump(min($locations));
