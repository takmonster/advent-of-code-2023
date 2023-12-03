<?php

declare(strict_types = 1);

require_once(__DIR__ . '/../lib/Game.php');
require_once(__DIR__ . '/../lib/Requirement/MaxNumberOfCubes.php');

$lines = file(__DIR__ . '/../input.txt');
$games = array_map(
    fn (string $game_string) => new Game($game_string),
    $lines,
);

$games_that_are_possible = array_filter(
    $games,
    fn (Game $game) => $game->meetsRequirement((new MaxNumOfCubesRequirement())),
);

var_dump(
    array_sum(
        array_map(
            fn (Game $game) => $game->getGameID(),
            $games_that_are_possible,
        ),
    )
);
