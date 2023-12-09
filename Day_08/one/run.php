<?php

declare(strict_types=1);

$instructions = str_split('LLRLRRLLRLRRLLRLRRLRRRLRLRLRRRLLRLRRRLRLRRRLRLRLLLRRLRLRLLRLRRLRRRLRRRLLRRLRLRRRLRRLRRRLRLLRRLRRRLRRRLRRLRLRRLLLRLRLLRRRLRRLLRLRLRRLLRLRRLLRLRRLRRLLRRRLRLRLRRRLLRRRLRRLRRRLRRRLRLRRRLRRLLLRRRLRLLLRRRLRLLRLLRRRLLRRLRRRLRRRLRLLRLRLRRRLLRRLRRRLRRLRLLRRRLRRLRRRLRRRLRRRLRLRRRLRRRLRLRRRR');

$lines = file(__DIR__ . '/../input.txt', FILE_IGNORE_NEW_LINES);
$mappers = [];
foreach ($lines as $line) {
    $parts = explode(' = ', $line);
    $key = $parts[0];
    $mappings = explode(' ', str_replace(['(', ',', ')'], '', $parts[1]));
    $mappers[$key] = new Mapper($mappings[0], $mappings[1]);
}

$current_key = 'AAA';
$instruction_count = 0;

$steps = 0;
while ($current_key !== 'ZZZ') {
    $steps++;
    $current_mapper = $mappers[$current_key];
    $current_instruction = $instructions[$instruction_count];
    if ($current_instruction === 'L') {
        $current_key = $current_mapper->getLeft();
    } else {
        $current_key = $current_mapper->getRight();
    }
    if ($instruction_count === count($instructions) - 1) {
        $instruction_count = 0;
    } else {
        $instruction_count++;
    }
}

var_dump($steps);

class Mapper
{
    private string $left;
    private string $right;

    public function __construct(string $left, string $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    public function getLeft(): string
    {
        return $this->left;
    }

    public function getRight(): string
    {
        return $this->right;
    }
}