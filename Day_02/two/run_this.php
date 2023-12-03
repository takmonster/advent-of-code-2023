<?php

declare(strict_types = 1);

require_once(__DIR__ . '/../lib/Game.php');

$lines = file(__DIR__ . '/../input.txt');
$games = array_map(
    fn (string $game_string) => new Game($game_string),
    $lines,
);
$powers_of_games = array_map(
    fn (Game $game) => $game->getPowerOfCubes(),
    $games,
);

var_dump(array_sum($powers_of_games));
