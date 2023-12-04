<?php

declare(strict_types = 1);

require_once(__DIR__ . '/GridRowColumn.php');

class GridNumber
{
    /** @var GridRowColumn[] */
    private array $grid_row_columns = [];

    public function __construct() {}

    public function associateWithRowColumn(GridRowColumn $row_column): void
    {
        if (! $row_column->isNumericValue()) {
            throw new Exception('GridRowColumn value must be numeric');
        }
        $this->grid_row_columns[] = $row_column;
    }

    public function getNumber(): int
    {
        $number_digits = array_map(
            fn (GridRowColumn $grid_row_column) => $grid_row_column->getValue(),
            $this->grid_row_columns
        );
        return intval(implode('', $number_digits));
    }

    public function getGridRowColumns(): array
    {
        return $this->grid_row_columns;
    }
}
