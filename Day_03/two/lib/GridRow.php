<?php

declare(strict_types = 1);

require_once(__DIR__ . '/GridRowColumn.php');
require_once(__DIR__ . '/GridNumber.php');

class GridRow
{
    /** @var GridRowColumn[] */
    private array $grid_row_columns = [];

    public function __construct(array $grid_row_columns)
    {
        $this->grid_row_columns = $grid_row_columns;
    }

    public function getColumns(): array
    {
        return $this->grid_row_columns;
    }

    public static function fromInputLine(string $input_line, int $y_axis_val): self
    {
        $columns = [];
        $x_axis_val = 0;
        foreach (mb_str_split($input_line) as $input_line_character) {
            $columns[] = new GridRowColumn($x_axis_val, $y_axis_val, $input_line_character);
            $x_axis_val++;
        }

        return new self($columns);
    }

    public function getNumbers(): array
    {
        $numbers = [];
        $number_being_built = null;
        $column_counter = 1;
        foreach ($this->grid_row_columns as $column) {
            if ($column->isNumericValue()) {
                if ($number_being_built === null) {
                    $number_being_built = new GridNumber();
                }
                $number_being_built->associateWithRowColumn($column);
            }
            
            if (! $column->isNumericValue() || $column_counter === count($this->grid_row_columns)) {
                if ($number_being_built) {
                    $numbers[] = $number_being_built;
                    $number_being_built = null;
                }
            }

            $column_counter++;
        }

        return $numbers;
    }
}
