<?php

declare(strict_types = 1);

class Card
{
    private int $card_number;

    /** @var int[] */
    private array $winning_numbers = [];

    /** @var int[] */
    private array $scratch_numbers = [];

    public function __construct(int $card_number, array $winning_numbers, array $scratch_numbers)
    {
        $this->card_number = $card_number;
        $this->winning_numbers = $winning_numbers;
        $this->scratch_numbers = $scratch_numbers;
    }

    public function getCardNumber(): int
    {
        return $this->card_number;
    }

    public function getPoints(): int
    {
        $winning_number_count = count(array_intersect($this->winning_numbers, $this->scratch_numbers));
        switch ($winning_number_count) {
            case 0:
                return 0;
            case 1:
                return 1;
            default:
                return pow(2, $winning_number_count - 1);
        }
    }

    public static function fromInputLine(string $input_line): Card
    {
        $input_line = trim($input_line);
        $parts = explode(':', $input_line);
        $card_number = intval(str_replace('Card ', '', $parts[0]));
        $numbers = explode('|', $parts[1]);
        $winning_numbers = array_map('intval', array_filter(array_map('trim', explode(' ', trim($numbers[0])))));
        $scratch_numbers = array_map('intval', array_filter(array_map('trim', explode(' ', trim($numbers[1])))));
        return new self($card_number, $winning_numbers, $scratch_numbers);
    }
}