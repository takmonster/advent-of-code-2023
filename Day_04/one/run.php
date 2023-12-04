<?php

declare(strict_types = 1);

require_once(__DIR__ . '/lib/Card.php');

$lines = file(__DIR__ . '/../input.txt', FILE_IGNORE_NEW_LINES);

$cards = array_map(
    fn (string $line) => Card::fromInputLine($line),
    $lines,
);
$winning_points = array_map(
    fn (Card $card) => $card->getPoints(),
    $cards,
);

var_dump(
    array_sum($winning_points),
);
