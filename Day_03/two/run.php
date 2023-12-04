<?php

declare(strict_types = 1);

require_once(__DIR__ . '/lib/Grid.php');

$lines = file(__DIR__ . '/../input.txt', FILE_IGNORE_NEW_LINES);
$grid = Grid::fromInputLines($lines);

// foreach ($grid->getRows() as $row) {
//     foreach ($row->getColumns() as $column) {
//         echo '| ' . $column->getValue() . ' |';
//     }
//     echo PHP_EOL;
// }

$calculated_ratios = [];
foreach ($grid->getSymbolAssociations() as $coordinates_str => $number_values) {
    if (count($number_values) === 2) {
        $calculated_ratios[] = $number_values[0] * $number_values[1];
    }
}

var_dump(array_sum($calculated_ratios));
