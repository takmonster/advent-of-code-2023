<?php

declare(strict_types = 1);

require_once(__DIR__ . '/Cube.php');

class Set
{
    private array $cubes = [];

    private int $num_of_red_cubes = 0;
    private int $num_of_green_cubes = 0;
    private int $num_of_blue_cubes = 0;

    public function __construct(string $set_str)
    {
        // starting with "1 green, 6 red, 4 blue"
        $this->cubes = array_map(
            function (string $cube_string): Cube {
                $parts = explode(' ', $cube_string);
                return new Cube(intval($parts[0]), $parts[1]);
            },
            array_map('trim', explode(',', $set_str)),
        );

        // this assumes there's only one cube of each color in a set!
        foreach ($this->cubes as $cube) {
            switch ($cube->getColor()) {
                case 'red':
                    $this->num_of_red_cubes = $cube->getNumber();
                    break;
                case 'green':
                    $this->num_of_green_cubes = $cube->getNumber();
                    break;
                case 'blue':
                    $this->num_of_blue_cubes = $cube->getNumber();
                    break;
            }
        }
    }

    public function getCubes(): array
    {
        return $this->cubes;
    }

    public function getNumOfRedCubes(): int
    {
        return $this->num_of_red_cubes;
    }

    public function getNumOfGreenCubes(): int
    {
        return $this->num_of_green_cubes;
    }

    public function getNumOfBlueCubes(): int
    {
        return $this->num_of_blue_cubes;
    }
}
