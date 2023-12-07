<?php

declare(strict_types=1);

$lines = file(__DIR__ . '/../input.txt', FILE_IGNORE_NEW_LINES);
$toy_boat_races = array_map(
    fn (string $toy_boat_race_line_str) => new ToyRace(intval(explode(' ', $toy_boat_race_line_str)[0]), intval(explode(' ', $toy_boat_race_line_str)[1])),
    $lines,
);

$counts_of_winning_combinations_of_button_presses = array_map(
    fn (ToyRace $toy_race) => count($toy_race->findWinningButtonPresses()),
    $toy_boat_races
);

$x = 1;
foreach ($counts_of_winning_combinations_of_button_presses as $count_of_winning_combinations_of_button_presses) {
    $x *= $count_of_winning_combinations_of_button_presses;
}

var_dump($x);

class ToyRace
{
    private int $milliseconds_length;
    private int $millimeter_record;

    public function __construct(int $milliseconds_length, int $millimeter_record)
    {
        $this->milliseconds_length = $milliseconds_length;
        $this->millimeter_record = $millimeter_record;
    }

    public function findWinningButtonPresses(): array
    {
        $winning_button_presses = [];
        for ($i = 0; $i < $this->milliseconds_length; $i++) {
            $button_press_length = $i;
            $millimeters_per_second = $button_press_length;
            $milliseconds_left = $this->milliseconds_length - $button_press_length;
            $length = $millimeters_per_second * $milliseconds_left;
            if ($length > $this->millimeter_record) {
                $winning_button_presses[] = $button_press_length;
            }
        }

        return $winning_button_presses;
    }
}