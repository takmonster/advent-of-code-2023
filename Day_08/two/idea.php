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

$x = function (Mover $mover) use ($instructions): int {
    $instruction_count = 0;
    $moves = 0;
    while (true) {
        $moves++;
        $mover->advance($instructions[$instruction_count]);
        if ($mover->isDone()) {
            return $moves;
        }
        if ($instruction_count === count($instructions) - 1) {
            $instruction_count = 0;
        } else {
            $instruction_count++;
        }
    }
    return 0;
};

var_dump('one');
$mover = new Mover($ends_with_a[0], $mappers);
$one = $x($mover);
var_dump($one);

var_dump('two');
$mover = new Mover($ends_with_a[1], $mappers);
$two = $x($mover);
var_dump($two);

var_dump('three');
$mover = new Mover($ends_with_a[2], $mappers);
$three = $x($mover);
var_dump($three);

var_dump('four');
$mover = new Mover($ends_with_a[3], $mappers);
$four = $x($mover);
var_dump($four);

var_dump('five');
$mover = new Mover($ends_with_a[4], $mappers);
$five = $x($mover);
var_dump($five);

var_dump('six');
$mover = new Mover($ends_with_a[5], $mappers);
$six = $x($mover);
var_dump($six);

var_dump(
    gmp_lcm(
        $six,
        gmp_lcm(
            $five,
            gmp_lcm(
                $four,
                gmp_lcm(
                    $three,
                    gmp_lcm(
                        $two,
                        $one
                    ),
                ),
            ),
        ),
    ),
);

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