<?php

declare(strict_types=1);

require_once(__DIR__ . '/Range.php');

class RangeLine
{
    public Range $source_range;
    public Range $destination_range;

    public function __construct(Range $source_range, Range $destination_range)
    {
        $this->source_range = $source_range;
        $this->destination_range = $destination_range;
    }

    public function getSourceRange(): Range
    {
        return $this->source_range;
    }

    public function getDestinationRange(): Range
    {
        return $this->destination_range;
    }

    public function getMappedValue(int $source_value): int
    {
        if (!$this->source_range->containsValue($source_value)) {
            throw new Exception("Source value {$source_value} is not contained in this range mapper");
        }
        $offset = $source_value - $this->source_range->getStartingValue();
        $value = $this->destination_range->getValueAtOffset($offset);
        return $value;
    }

    public static function fromInput(string $input): self
    {
        $parts = array_map('intval', explode(' ', $input));
        $source_range_start = $parts[1];
        $destination_range_start = $parts[0];
        $range_length = $parts[2];

        return new self(
            new Range($source_range_start, $range_length), 
            new Range($destination_range_start, $range_length)
        );
    }
}
