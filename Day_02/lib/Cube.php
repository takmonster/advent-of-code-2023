<?php

declare(strict_types = 1);

class Cube
{
    private int $number;
    private string $color;

    public function __construct(int $number, string $color)
    {
        $this->number = $number;
        $this->color = $color;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getColor(): string
    {
        return $this->color;
    }
}
