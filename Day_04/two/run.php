<?php

declare(strict_types = 1);

require_once(__DIR__ . '/lib/CardOverlord.php');
require_once(__DIR__ . '/lib/Card.php');

$lines = file(__DIR__ . '/../input.txt', FILE_IGNORE_NEW_LINES);
$cards = array_map(fn(string $line) => Card::fromInputLine($line), $lines);
$card_overlord = new CardOverlord($cards);

$points = array_map(
    fn(Card $card) => $card_overlord->traverseCardWins($card),
    $cards,
);

var_dump(array_sum($points));
