<?php

declare(strict_types = 1);

require_once(__DIR__ . '/GridRow.php');
require_once(__DIR__ . '/GridRowColumn.php');
require_once(__DIR__ . '/GridNumber.php');

class Grid
{
    /** @var GridRow[] */
    private array $grid_rows = [];

    private $x_axis_length = 0;
    private $y_axis_length = 0;

    // keys are x-y coordinates of a symbol, values are an array of associated number values
    // e.g. [ '1,1' => [ 1, 2, 3 ] ]
    private array $symbol_associations = [];

    public function __construct(array $grid_rows)
    {
        if (! count($grid_rows)) {
            throw new Exception('Grid must have at least one row');
        }

        $this->grid_rows = $grid_rows;

        $first_row_column_count = count($grid_rows[0]->getColumns());
        foreach ($grid_rows as $grid_row) {
            if (count($grid_row->getColumns()) !== $first_row_column_count) {
                throw new Exception('Grid rows must have the same number of columns');
            }
        }
        
        $this->x_axis_length = $first_row_column_count;
        $this->y_axis_length = count($grid_rows);
        
        $this->generateSymbolAssociations();
    }

    public function getRows(): array
    {
        return $this->grid_rows;
    }

    public function getSymbolAssociations(): array
    {
        return $this->symbol_associations;
    }

    private function generateSymbolAssociations(): void
    {
        foreach ($this->getRows() as $row) {
            foreach ($row->getNumbers() as $number) {
                $surrounding_row_columns = $this->getSurroundingRowColumnsOfGridNumber($number);
                foreach ($surrounding_row_columns as $surrounding_row_column) {
                    if ($surrounding_row_column->isSymbol()) {
                        $coordinates_key = sprintf('%d,%d', $surrounding_row_column->getX(), $surrounding_row_column->getY());
                        if (! isset($this->symbol_associations[$coordinates_key])) {
                            $this->symbol_associations[$coordinates_key] = [];
                        }
                        $this->symbol_associations[$coordinates_key][] = $number->getNumber();
                    }
                }
            }
        }
    }

    private function getSurroundingRowColumnsOfGridNumber(GridNumber $grid_number): array
    {
        $y_axis = $grid_number->getGridRowColumns()[0]->getY();
        
        $min_x_value = $grid_number->getGridRowColumns()[0]->getX();
        $max_x_value = $grid_number->getGridRowColumns()[0]->getX();
        foreach ($grid_number->getGridRowColumns() as $grid_row_column) {
            if ($grid_row_column->getX() < $min_x_value) {
                $min_x_value = $grid_row_column->getX();
            }
            if ($grid_row_column->getX() > $max_x_value) {
                $max_x_value = $grid_row_column->getX();
            }
        }

        $row_columns = [];

        // top-left coordinate
        $top_left_x = $min_x_value - 1;
        $top_left_y = $y_axis - 1;

        if ($this->isOnTheGrid($top_left_x, $top_left_y)) {
            $row_columns[] = $this->getRowColumnByCoordinates($top_left_x, $top_left_y);
        }

        // top-right coordinate
        $top_right_x = $max_x_value + 1;
        $top_right_y = $y_axis - 1;

        if ($this->isOnTheGrid($top_right_x, $top_right_y)) {
            $row_columns[] = $this->getRowColumnByCoordinates($top_right_x, $top_right_y);
        }

        // middle-right coordinate
        $middle_right_x = $max_x_value + 1;
        $middle_right_y = $y_axis;

        if ($this->isOnTheGrid($middle_right_x, $middle_right_y)) {
            $row_columns[] = $this->getRowColumnByCoordinates($middle_right_x, $middle_right_y);
        }

        // bottom-right coordinate
        $bottom_right_x = $max_x_value + 1;
        $bottom_right_y = $y_axis + 1;

        if ($this->isOnTheGrid($bottom_right_x, $bottom_right_y)) {
            $row_columns[] = $this->getRowColumnByCoordinates($bottom_right_x, $bottom_right_y);
        }

        // bottom-left coordinate
        $bottom_left_x = $min_x_value - 1;
        $bottom_left_y = $y_axis + 1;

        if ($this->isOnTheGrid($bottom_left_x, $bottom_left_y)) {
            $row_columns[] = $this->getRowColumnByCoordinates($bottom_left_x, $bottom_left_y);
        }

        // middle-left coordinate
        $middle_left_x = $min_x_value - 1;
        $middle_left_y = $y_axis;

        if ($this->isOnTheGrid($middle_left_x, $middle_left_y)) {
            $row_columns[] = $this->getRowColumnByCoordinates($middle_left_x, $middle_left_y);
        }

        // for min x to max x, get top and bottom
        for ($x = $min_x_value; $x <= $max_x_value; $x++) {
            $top_y = $y_axis - 1;
            $bottom_y = $y_axis + 1;

            if ($this->isOnTheGrid($x, $top_y)) {
                $row_columns[] = $this->getRowColumnByCoordinates($x, $top_y);
            }

            if ($this->isOnTheGrid($x, $bottom_y)) {
                $row_columns[] = $this->getRowColumnByCoordinates($x, $bottom_y);
            }
        }

        return $row_columns;
    }

    private function isOnTheGrid(int $x, int $y): bool
    {
        return $x >= 0 && $x < $this->x_axis_length - 1 && $y >= 0 && $y < $this->y_axis_length - 1;
    }

    private function getRowColumnByCoordinates(int $x, int $y): GridRowColumn
    {
        if (! $this->isOnTheGrid($x, $y)) {
            throw new Exception('Coordinates are not on the grid');
        }

        $point = $this->grid_rows[$y]->getColumns()[$x];
        if (! $point) {
            throw new Exception('Point does not exist');
        }

        return $point;
    }

    public static function fromInputLines(array $input_lines): self
    {
        $rows = [];
        $y_axis_val = 0;
        foreach ($input_lines as $input_line) {
            $rows[] = GridRow::fromInputLine($input_line, $y_axis_val);
            $y_axis_val++;
        }

        return new self($rows);
    }
}
