<?php

require_once('Card.php');
require_once('Deck.php');
require_once('Player.php');
require_once('Game.php');


// ゲームの開始
$game = new Game(['プレイヤー1', 'プレイヤー2']);
$game->distributeCards();
$game->play();
$game->showRanks();

echo "戦争を終了します。\n";