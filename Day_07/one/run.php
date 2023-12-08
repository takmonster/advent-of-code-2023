<?php

declare(strict_types=1);

$input_lines = file(__DIR__ . '/../input.txt', FILE_IGNORE_NEW_LINES);
$hands = array_map(
    function (string $input_line) {
        $parts = explode(' ', $input_line);
        $hand = str_split($parts[0]);
        $bid_value = intval($parts[1]);
        return new Hand(
            new Card(Card::convert($hand[0])),
            new Card(Card::convert($hand[1])),
            new Card(Card::convert($hand[2])),
            new Card(Card::convert($hand[3])),
            new Card(Card::convert($hand[4])),
            $bid_value,
        );
    },
    $input_lines
);

$five_of_a_kinds = array_values(array_filter($hands, fn (Hand $hand) => $hand->getHandType() === Hand::FIVE_OF_A_KIND));
$four_of_a_kinds = array_values(array_filter($hands, fn (Hand $hand) => $hand->getHandType() === Hand::FOUR_OF_A_KIND));
$full_houses = array_values(array_filter($hands, fn (Hand $hand) => $hand->getHandType() === Hand::FULL_HOUSE));
$three_of_a_kinds = array_values(array_filter($hands, fn (Hand $hand) => $hand->getHandType() === Hand::THREE_OF_A_KIND));
$two_pairs = array_values(array_filter($hands, fn (Hand $hand) => $hand->getHandType() === Hand::TWO_PAIR));
$one_pairs = array_values(array_filter($hands, fn (Hand $hand) => $hand->getHandType() === Hand::ONE_PAIR));
$high_cards = array_values(array_filter($hands, fn (Hand $hand) => $hand->getHandType() === Hand::HIGH_CARD));

var_dump(count($five_of_a_kinds));
var_dump(count($four_of_a_kinds));
var_dump(count($full_houses));
var_dump(count($three_of_a_kinds));
var_dump(count($two_pairs));
var_dump(count($one_pairs));
var_dump(count($high_cards));

$comparer = function (Hand $hand1, Hand $hand2) {
    $character_counter = 0;
    $hand_1_card_values = $hand1->getCardValues();
    $hand_2_card_values = $hand2->getCardValues();
    while ($character_counter < 5) {
        if ($hand_1_card_values[$character_counter] < $hand_2_card_values[$character_counter]) {
            return 1;
        }
        if ($hand_1_card_values[$character_counter] > $hand_2_card_values[$character_counter]) {
            return -1;
        }
        $character_counter++;
    }
};
usort($five_of_a_kinds, $comparer);
usort($four_of_a_kinds, $comparer);
usort($full_houses, $comparer);
usort($three_of_a_kinds, $comparer);
usort($two_pairs, $comparer);
usort($one_pairs, $comparer);
usort($high_cards, $comparer);

$ranked_by_highs = array_merge(
    $five_of_a_kinds, 
    $four_of_a_kinds,
    $full_houses,
    $three_of_a_kinds,
    $two_pairs,
    $one_pairs,
    $high_cards
);

$ranked_by_lows = array_reverse($ranked_by_highs);
$winnings = [];
for ($i = 0; $i < count($ranked_by_lows); $i++) {
    $rank = $i + 1;
    $winnings[] = $ranked_by_lows[$i]->getBidValue() * $rank;
}

var_dump(
    array_sum($winnings),
);

class Card
{
    const array ALLOWED_VALUES = [
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9,
        10,
        11, // Jack
        12, // Queen
        13, // King
        14, // Ace
    ];

    // card value
    private int $value;

    public function __construct(int $value)
    {
        if (!in_array($value, self::ALLOWED_VALUES)) {
            throw new \InvalidArgumentException('Invalid card value: ' . $value);
        }
        $this->value = $value;   
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public static function convert(string $character): int
    {
        switch ($character) {
            case 'T':
                return 10;
            case 'J':
                return 11;
            case 'Q':
                return 12;
            case 'K':
                return 13;
            case 'A':
                return 14;
            default:
                return (int) $character;
        }
    }
}

class Hand
{
    const FIVE_OF_A_KIND = 0;
    const FOUR_OF_A_KIND = 1;
    const FULL_HOUSE = 2;
    const THREE_OF_A_KIND = 3;
    const TWO_PAIR = 4;
    const ONE_PAIR = 5;
    const HIGH_CARD = 6;

    /**
     * @var Card[]
     */
    private array $cards;

    private int $bid_value;

    public function __construct(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5, int $bid_value)
    {
        $this->bid_value = $bid_value;
        $this->cards = [
            $card1,
            $card2,
            $card3,
            $card4,
            $card5,
        ];
    }

    public function getCardValues(): array
    {
        return array_map(fn (Card $card) => $card->getValue(), $this->cards);
    }

    public function getBidValue(): int
    {
        return $this->bid_value;
    }

    public function getHandType(): int
    {
        if ($this->isFiveOfAKind()) {
            return self::FIVE_OF_A_KIND;
        }

        if ($this->isFourOfAKind()) {
            return self::FOUR_OF_A_KIND;
        }

        if ($this->isFullHouse()) {
            return self::FULL_HOUSE;
        }

        if ($this->isThreeOfAKind()) {
            return self::THREE_OF_A_KIND;
        }

        if ($this->isTwoPair()) {
            return self::TWO_PAIR;
        }

        if ($this->isOnePair()) {
            return self::ONE_PAIR;
        }

        return self::HIGH_CARD;
    }

    private function isFiveOfAKind(): bool
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card->getValue();
        }
        $count_values = array_values(array_count_values($values));
        sort($count_values);
        return $count_values == [5];
    }

    private function isFourOfAKind(): bool
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card->getValue();
        }
        $count_values = array_values(array_count_values($values));
        rsort($count_values);
        return $count_values == [4, 1];
    }

    private function isFullHouse(): bool
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card->getValue();
        }
        $count_values = array_values(array_count_values($values));
        rsort($count_values);
        return $count_values == [3, 2];
    }

    private function isThreeOfAKind(): bool
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card->getValue();
        }
        $count_values = array_values(array_count_values($values));
        rsort($count_values);
        return $count_values == [3, 1, 1];
    }

    private function isTwoPair(): bool
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card->getValue();
        }
        $count_values = array_values(array_count_values($values));
        rsort($count_values);
        return $count_values == [2, 2, 1];
    }

    private function isOnePair(): bool
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card->getValue();
        }
        $count_values = array_values(array_count_values($values));
        rsort($count_values);
        return $count_values == [2, 1, 1, 1];
    }
}
