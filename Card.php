<?php

class Card
{
    public $suit;
    public $number;

    public function __construct($suit, $number)
    {
        $this->suit = $suit;
        $this->number = $number;
    }
}