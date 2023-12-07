<?php

declare(strict_types=1);

$toy_boat_race = new ToyRace(53837288, 333163512891532);

$count_of_winning_combinations = $toy_boat_race->countOfWinningPresses();

var_dump($count_of_winning_combinations);

class ToyRace
{
    private int $milliseconds_length;
    private int $millimeter_record;

    public function __construct(int $milliseconds_length, int $millimeter_record)
    {
        $this->milliseconds_length = $milliseconds_length;
        $this->millimeter_record = $millimeter_record;
    }

    public function countOfWinningPresses(): int
    {
        $the_count = 0;
        for ($i = 0; $i < $this->milliseconds_length; $i++) {
            $button_press_length = $i;
            $millimeters_per_second = $button_press_length;
            $milliseconds_left = $this->milliseconds_length - $button_press_length;
            $length = $millimeters_per_second * $milliseconds_left;
            if ($length > $this->millimeter_record) {
                $the_count++;
            }
        }

        return $the_count;
    }
}