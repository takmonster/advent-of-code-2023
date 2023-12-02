<?php

declare(strict_types = 1);

$lines = file('./input.txt');
$line_parser = new LineParser();
$numbers = array_map(
    fn (string $input_line_string) => $line_parser->parse($input_line_string)->getValue(),
    $lines,
);

var_dump(array_sum($numbers));

class Line
{
    private array $occurrences = [];

    public function markOccurrence(int $number, int $position): void
    {
        $this->occurrences[] = new NumberOccurrence($number, $position);
    }

    public function getValue(): int
    {
        $occurrences = $this->occurrences;
        usort(
            $occurrences,
            fn (NumberOccurrence $a, NumberOccurrence $b) => ($a->getPosition() < $b->getPosition()) ? -1 : 1
        );
        $first_occurence = reset($occurrences);
        $latest_ocurrence = end($occurrences);
        return intval(
            sprintf(
                '%d%d',
                $first_occurence->getNumber(),
                $latest_ocurrence->getNumber(),
            ),
        );
    }
}

class NumberOccurrence
{
    private int $number;
    private int $position;

    public function __construct(int $number, int $position)
    {
        $this->number = $number;
        $this->position = $position;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getPosition(): int
    {
        return $this->position;
    }
}

class LineParser
{
    const NUMBER_MAP = [
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8,
        'nine' => 9,
    ];

    public function parse(string $input_line): Line
    {
        $line = new Line();
        foreach (self::NUMBER_MAP as $str => $int) {
            $integer_occurrences = self::findOccurrences($input_line, strval($int));
            $string_occurrences = self::findOccurrences($input_line, $str);
            foreach ($integer_occurrences as $index) {
                $line->markOccurrence($int, $index);
            }
            foreach ($string_occurrences as $index) {
                $line->markOccurrence($int, $index);
            }
        }
        return $line;
    }

    private static function findOccurrences(string $line_str, string $num_str): array
    {
        $occurrences = [];
        $position_offset = 0;
        while (true) {
            $string_position = stripos($line_str, $num_str, $position_offset);
            if ($string_position === false) {
                break;
            }
            $occurrences[] = $string_position;
            $position_offset = $string_position + 1;
        }
        return $occurrences;
    }
}

