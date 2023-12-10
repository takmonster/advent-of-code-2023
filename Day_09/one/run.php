<?php

declare(strict_types=1);

$lines = file(__DIR__ . '/../input.txt');

$histories = array_map(
    fn(string $input_line) => History::fromLine($input_line),
    $lines,
);
$prediction_values = array_map(
    fn(History $history) => $history->getPrediction(),
    $histories,
);

var_dump(
    array_sum($prediction_values),
);

class History
{
    private array $last_position_points = [];

    public function __construct(array $starting_history_points)
    {
        $sequence = new HistorySequence($starting_history_points);
        $this->last_position_points[] = $sequence->getLastPositionPoint();

        $current_sequence = $sequence;
        while (true) {
            $differences = $current_sequence->getDifferences();
            $this->last_position_points[] = end($differences);
            if (count(array_unique($differences)) === 1) {
                break;
            }
            $current_sequence = new HistorySequence($differences);
        }
    }

    public function getPrediction(): int
    {
        return array_sum($this->last_position_points);
    }

    public static function fromLine(string $line): self
    {
        $points = explode(' ', $line);
        return new self(
            array_map('intval', $points),
        );
    }
}

class HistorySequence
{
    private array $points;

    public function __construct(array $points)
    {
        $this->points = $points;
    }

    public function getDifferences(): array
    {
        $differences = [];
        for($i = 0; $i < count($this->points) - 1; $i++) {
            $differences[] = -($this->points[$i] - $this->points[$i+1]);
        }
        return $differences;
    }

    public function getLastPositionPoint(): int
    {
        return end($this->points);
    }
}