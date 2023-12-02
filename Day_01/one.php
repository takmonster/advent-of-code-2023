<?php

declare(strict_types = 1);

$lines = file('./input.txt');
$line_parser = new LineParser();
$numbers = array_map(
    fn (string $line) => $line_parser->getParsedCalibrationValue($line),
    $lines
);

var_dump(array_sum($numbers));

class LineParser
{
    public function getParsedCalibrationValue(string $line): int
    {
        return intval(
            sprintf(
                '%d%d',
                self::getFirstNumberOccurrence($line),
                self::getFirstNumberOccurrence(strrev($line)),
            ),
        );
    }

    private static function getFirstNumberOccurrence(string $line): int
    {
        foreach (mb_str_split($line) as $character) {
            if (is_numeric($character)) {
                return intval($character);
            }
        }
    }
}

