<?php

declare(strict_types=1);

class Range
{
    public int $starting_value;
    public int $length;

    public function __construct(int $starting_value, int $length)
    {
        $this->starting_value = $starting_value;
        $this->length = $length;
    }

    public function containsValue(int $value): bool
    {
        return $value >= $this->starting_value && $value < $this->starting_value + $this->length;
    }

    public function getStartingValue(): int
    {
        return $this->starting_value;
    }

    public function getValueAtOffset(int $offset): int
    {
        return $this->starting_value + $offset;
    }
}
