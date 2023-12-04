<?php

declare(strict_types = 1);

require_once(__DIR__ . '/lib/Grid.php');

$lines = file(__DIR__ . '/../input.txt', FILE_IGNORE_NEW_LINES);

$grid = Grid::fromInputLines($lines);

$part_numbers = [];
foreach ($grid->getRows() as $row) {
    foreach ($row->getNumbers() as $number) {
        if ($grid->checkGridNumberIsPart($number)) {
            $part_numbers[] = $number->getNumber();
        }
    }
}

var_dump(array_sum($part_numbers));
