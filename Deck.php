<?php

class Deck
{
    private $cards = [];

    public function __construct()
    {
        $suits = ['ハート', 'ダイヤ', 'クラブ', 'スペード'];
        $numbers = ['A', 'K', 'Q', 'J', '10', '9', '8', '7', '6', '5', '4', '3', '2'];

        foreach ($suits as $suit) {
            foreach ($numbers as $number) {
                $this->cards[] = new Card($suit, $number);
            }
        }
    }

    public function shuffle()
    {
        shuffle($this->cards);
    }

    public function draw()
    {
        return array_pop($this->cards);
    }

    public function count()
    {
        return count($this->cards);
    }
}