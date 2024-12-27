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

// カードの比較関数
function compareCards($card1, $card2)
{
    $numbers = ['A' => 14, 'K' => 13, 'Q' => 12, 'J' => 11, '10' => 10, '9' => 9, '8' => 8, '7' => 7, '6' => 6, '5' => 5, '4' => 4, '3' => 3, '2' => 2];
    return $numbers[$card1->number] <=> $numbers[$card2->number];
}

// ゲーム開始
echo "戦争を開始します。\n";

// プレイヤーの作成
$player1 = new Player('プレイヤー1');
$player2 = new Player('プレイヤー2');
$players = [$player1, $player2];

// デッキの作成とシャッフル
$deck = new Deck();
$deck->shuffle();

// カードの配分
// カードの配分
while ($deck->count() > 0) { 
    $player1->drawCard($deck);
    $player2->drawCard($deck);
}


// 場にカードを積み上げる変数
$warPile = [];

while (count($player1->hand) > 0 && count($player2->hand) > 0) {
    $card1 = array_pop($player1->hand);
    $card2 = array_pop($player2->hand);
    echo "プレイヤー1のカードは{$card1->suit}の{$card1->number}です。\n";
    echo "プレイヤー2のカードは{$card2->suit}の{$card2->number}です。\n";

    $result = compareCards($card1, $card2);

    if ($result > 0) {
        echo "プレイヤー1が勝ちました。プレイヤー1はカードをもらいました。\n";
        array_push($player1->hand, $card1, $card2, ...$warPile); // 場のカードも獲得
        $warPile = []; // 場をリセット
    } elseif ($result < 0) {
        echo "プレイヤー2が勝ちました。プレイヤー2はカードをもらいました。\n";
        array_push($player2->hand, $card1, $card2, ...$warPile); // 場のカードも獲得
        $warPile = []; // 場をリセット
    } else {
        echo "引き分けです。\n";
        array_push($warPile, $card1, $card2); // 場にカードを積む

        // 引き分け解決用のカードを追加
        if (count($player1->hand) > 0 && count($player2->hand) > 0) {
            //何もしない
        } else {
            echo "どちらかのプレイヤーの手札が不足しています。ゲームを終了します。\n";
            break;
        }
    }
}


// 勝者を判定する処理
// プレイヤーの順位を決定
// usort($players, function($a, $b) {
//   return count($b->hand) <=> count($a->hand);
// });

// 順位を表示
foreach ($players as $rank => $player) {
    echo ($rank + 1) . "位: {$player->name} (カード枚数: " . count($player->hand) . ")\n";
}

echo "戦争を終了します。\n";