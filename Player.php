<?php

class Player
{
    public $name;
    public $hand = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function drawCard(Deck $deck)
    {
        $this->hand[] = $deck->draw();
    }
}