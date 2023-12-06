<?php

declare(strict_types=1);

require_once(__DIR__ . '/RangeLine.php');

class RangeFinder
{
    /**
     * @var RangeLine[]
     */
    private array $range_lines;

    public function __construct(array $range_lines)
    {
        $this->range_lines = $range_lines;
    }

    public function getMappedValue(int $source_value): int
    {
        foreach ($this->range_lines as $range_line) {
            if ($range_line->getSourceRange()->containsValue($source_value)) {
                return $range_line->getMappedValue($source_value);
            }
        }
        return $source_value;
    }
}