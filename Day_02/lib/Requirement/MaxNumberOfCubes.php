<?php

declare(strict_types = 1);

require_once(__DIR__ . '/../Requirement.php');

class MaxNumOfCubesRequirement implements Requirement
{
    const MAX_RED_CUBES = 12;
    const MAX_GREEN_CUBES = 13;
    const MAX_BLUE_CUBES = 14;

    public function checkGame(Game $game): bool
    {
        foreach ($game->getSets() as $set) {
            foreach ($set->getCubes() as $cube) {
                switch ($cube->getColor()) {
                    case 'red':
                        if ($cube->getNumber() > self::MAX_RED_CUBES) {
                            return false;
                        }
                        break;
                    case 'green':
                        if ($cube->getNumber() > self::MAX_GREEN_CUBES) {
                            return false;
                        }
                        break;
                    case 'blue':
                        if ($cube->getNumber() > self::MAX_BLUE_CUBES) {
                            return false;
                        }
                        break;
                }
            }
        }

        return true;
    }
}
