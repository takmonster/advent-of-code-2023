<?php

declare(strict_types = 1);

class GridRowColumn
{
    private int $x;
    private int $y;
    private string $value;

    public function __construct(int $x_axis_val, int $y_axis_val, string $value)
    {
        $this->x = $x_axis_val;
        $this->y = $y_axis_val;
        $this->value = $value;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isNumericValue(): bool
    {
        return is_numeric($this->value);
    }

    public function isSymbol(): bool
    {
        return !$this->isNumericValue() && $this->value !== '.';
    }

    public function isSameAs(GridRowColumn $row_column)
    {
        return $this->getX() === $row_column->getX() && $this->getY() === $row_column->getY();    
    }
}
