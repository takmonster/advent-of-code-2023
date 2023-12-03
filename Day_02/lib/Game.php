<?php

declare(strict_types = 1);

require_once(__DIR__ . '/Requirement.php');
require_once(__DIR__ . '/Set.php');

class Game
{
    private int $game_id;

    /** @var Set[] */
    private array $sets = [];

    private int $max_red_cubes_count = 0;
    private int $max_green_cubes_count = 0;
    private int $max_blue_cubes_count = 0;

    public function __construct(string $game_str)
    {
        // starting with: "Game 1: 1 green, 6 red, 4 blue; 2 blue, 6 green, 7 red"
        
        $parts = explode(':', $game_str);
        $game_identifier = $parts[0];
        $game_sets_str = $parts[1];

        // get the interger game id
        $this->game_id = intval(explode(' ', $parts[0])[1]);
        
        // from "1 green, 6 red, 4 blue; 2 blue, 6 green, 7 red" get Sets
        $set_strings = array_map('trim', explode(';', $game_sets_str));
        $this->sets = array_map(
            fn (string $set_string) => new Set($set_string),
            $set_strings,
        );

        foreach ($this->sets as $set) {
            if ($set->getNumOfRedCubes() > $this->max_red_cubes_count || $this->max_red_cubes_count === 0) {
                $this->max_red_cubes_count = $set->getNumOfRedCubes();
            }
            if ($set->getNumOfGreenCubes() > $this->max_green_cubes_count || $this->max_green_cubes_count === 0) {
                $this->max_green_cubes_count = $set->getNumOfGreenCubes();
            }
            if ($set->getNumOfBlueCubes() > $this->max_blue_cubes_count || $this->max_blue_cubes_count === 0) {
                $this->max_blue_cubes_count = $set->getNumOfBlueCubes();
            }
        }
    }

    public function getGameID(): int
    {
        return $this->game_id;
    }

    public function getSets(): array
    {
        return $this->sets;
    }

    public function meetsRequirement(Requirement $requirement): bool
    {
        return $requirement->checkGame($this);
    }

    public function getPowerOfCubes(): int
    {
        return $this->max_red_cubes_count * $this->max_green_cubes_count * $this->max_blue_cubes_count;
    }
}