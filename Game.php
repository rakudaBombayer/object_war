<?php

class Game
{
    private $players;
    private $deck;

    public function __construct($playerNames)
    {
        $this->players = [];
        foreach ($playerNames as $name) {
            $this->players[] = new Player($name);
        }
        $this->deck = new Deck();
        $this->deck->shuffle();
    }

    public function distributeCards()
    {
        while ($this->deck->count() > 0) {
            foreach ($this->players as $player) {
                $player->drawCard($this->deck);
            }
        }
    }

    public function compareCards($card1, $card2)
    {
        $numbers = ['A' => 14, 'K' => 13, 'Q' => 12, 'J' => 11, '10' => 10, '9' => 9, '8' => 8, '7' => 7, '6' => 6, '5' => 5, '4' => 4, '3' => 3, '2' => 2];
        return $numbers[$card1->number] <=> $numbers[$card2->number];
    }

    public function play()
    {
      
        $warPile = [];
        
        while (count($this->players[0]->hand) > 0 && count($this->players[1]->hand) > 0) {
            echo "戦争\n";
            $card1 = array_pop($this->players[0]->hand);
            $card2 = array_pop($this->players[1]->hand);
            echo "プレイヤー1のカードは{$card1->suit}の{$card1->number}です。\n";
            echo "プレイヤー2のカードは{$card2->suit}の{$card2->number}です。\n";

            $result = $this->compareCards($card1, $card2);

            if ($result > 0) {
                echo "プレイヤー1が勝ちました。プレイヤー1はカードをもらいました。\n";
                array_push($this->players[0]->hand, $card1, $card2, ...$warPile); // 場のカードも獲得
                $warPile = []; // 場をリセット
            } elseif ($result < 0) {
                echo "プレイヤー2が勝ちました。プレイヤー2はカードをもらいました。\n";
                array_push($this->players[1]->hand, $card1, $card2, ...$warPile); // 場のカードも獲得
                $warPile = []; // 場をリセット
            } else {
                echo "引き分けです。\n";
                array_push($warPile, $card1, $card2); // 場にカードを積む

                if (count($this->players[0]->hand) > 0 && count($this->players[1]->hand) > 0) {
                    //何もしない
                } else {
                    echo "プレイヤーの手札が不足しています。ゲームを終了します。\n";
                    break;
                }
            }
        }
    }

    public function showRanks()
    {
        foreach ($this->players as $rank => $player) {
            echo ($rank + 1) . "位: {$player->name} (カード枚数: " . count($player->hand) . ")\n";
        }
    }
}