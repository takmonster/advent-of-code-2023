<?php

declare(strict_types = 1);

class CardOverlord
{
    /** @var Card[] */
    private array $cards;

    private array $search_array = [];

    public function __construct(array $cards)
    {
        $this->cards = $cards;

        foreach ($cards as $card) {
            $this->search_array[$card->getCardNumber()] = $card;
        }
    }

    public function traverseCardWins(Card $card, int $depth = 1): int
    {
        if ($depth === 1) {
            var_dump($card->getCardNumber());
        }

        if (! count($card->getMatchedNumbers())) {
            return 1;
        }

        $count = 1;
        $depth++;
        for ($i = 1; $i <= count($card->getMatchedNumbers()); $i++) {
            if (! isset($this->search_array[$card->getCardNumber() + $i])) {
                continue;
            }
            $count += $this->traverseCardWins(
                $this->search_array[$card->getCardNumber() + $i],
                $depth,
            );
        }

        return $count;
    }
}
