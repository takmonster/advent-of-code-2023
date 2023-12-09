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

$ends_with_a = array_filter(
    array_keys($mappers),
    fn (string $key) => strrpos($key, 'A') === 2,
);

$ends_with_a = array_values($ends_with_a);

$movers = [];
foreach ($ends_with_a as $key) {
    $movers[] = new Mover($key, $mappers);
}

$moves = 0;
$instructions_count = 0;
while (true) {
    $moves++;

    $counting_done = 0;
    $direction = $instructions[$instructions_count];

    foreach ($movers as $mover) {
        $mover->advance($direction);
        if ($mover->isDone()) {
            $counting_done++;
        }
    }

    if ($counting_done > 3) {
        var_dump('what');
        foreach ($movers as $mover) {
            var_dump($mover->getKeyValue());
        }
    }

    if ($instructions_count < count($instructions) - 1) {
        $instructions_count++;
    } else {
        $instructions_count = 0;
    }

    if ($counting_done === count($movers)) {
        break;
    }
}

var_dump($moves);

// $instructions_count = 0;
// foreach ($movers as $mover) {
//     $direction = $instructions[$instructions_count];
//     $mover->advance($direction);
// }

// $movers = array_map(
//     fn (string $key): Mover => new Mover($key, $instructions, $mappers),
//     $starts_with_a,
// );

// $moves = 0;

// while (true) {
//     $is_done = true;

//     foreach ($movers as $mover) {
//         $mover->advance();
//         $moves++;
//         if (!$mover->isDone()) {
//             $is_done = false;
//             break;
//         }
//     }

//     if ($is_done) {
//         break;
//     }
// }

// var_dump($moves);

class Mover
{
    private string $key;

    /**
     * @var Mapper[]
     */
    private array $mappers;

    public function __construct(string $key, array $mappers)
    {
        $this->key = $key;
        $this->mappers = $mappers;
    }

    public function getKeyValue(): string
    {
        return $this->key;
    }

    public function advance(string $direction): void
    {
        if ($direction === 'L') {
            $this->key = $this->mappers[$this->key]->getLeft();
        } else {
            $this->key = $this->mappers[$this->key]->getRight();
        }
    }

    public function isDone(): bool
    {
        return strrpos($this->key, 'Z') === 2;
    }
}

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