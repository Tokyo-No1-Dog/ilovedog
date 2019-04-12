<?php

session_start();
 
$endGame = false;
$cards   = array();
$player  = array();
$opp     = array();

if(!isset($_GET['reset'])){
    if(isset($_SESSION['cards']))        $cards  = $_SESSION['cards'];
    if(isset($_SESSION['player']))       $player = $_SESSION['player'];
    if(isset($_SESSION['opponent']))     $opp    = $_SESSION['opponent'];
}
 
if(isset($_SESSION['cards']) && !isset($_GET['reset']))
{
    $cards = $_SESSION['cards'];
}
else
{
    $cards = init_cards();
    // ランダムに2枚ずつカードを配る
    $player[]    = array_shift($cards);
    $player[]    = array_shift($cards);
    $opp[]       = array_shift($cards);
    $opp[]       = array_shift($cards);
}

if(isset($_GET['hit'])) $player[] = array_shift($cards);

    // 対戦相手の思考と終局判定
if(isset($_GET['hit']) || isset($_GET['stand']))
{
    $threshold = 17;
    //CPUがHitする最大値(ここで強さが変わる)
    if( sum_up_hands($opp) < $threshold )
    {
        $opp[] = array_shift($cards);
    }
    elseif (isset($_GET['stand']) )
    {
        $endGame = true;
    }
}

    // 合計値
$player_total    = sum_up_hands($player);
$opp_total       = sum_up_hands($opp);

if($player_total > 21 || $opp_total > 21) $endGame = true;

$_SESSION['cards']       = $cards;
$_SESSION['player']      = $player;
$_SESSION['opponent']    = $opp;

function init_cards()
{
    // ランダムな山札を用意する
    $cards = array();
    $suits = array('spade', 'heart', 'diamond', 'club');
    foreach($suits as $suit)
    {
        for($i=1;$i<=13;$i++)
        {
            $cards[] = array(
            'num' => $i,
            'suit' => $suit
            );
        }
    }
    shuffle($cards);
    return $cards;
}

function sum_up_hands($hands)
{
    $ace = 0;
    $total = 0;
    foreach($hands as $card){
        $num = $card['num'];
        if($num > 10)
        {
            $total += 10;
        }
        elseif ($num === 1)
        {
            $ace++;
            $total += 1;
        }
        else
        {
            $total += $num;
        }
    }
    // Aの処理(手札の関係性を考慮する)
    if(!empty($ace))
    {
        $add = 10 * floor( (21 - $total) / 10 );
        if($add > 0) $total += $add;
    }
    return $total;
}
?><!DOCTYPE html>
<html lang="ja">

<head>
    <meta name="utf=8">
    <title>Black Jack - PHP</title>
</head>

<body>
    <h1>21</h1>
    <h2>基本的なルールとシステムについて</h2>
    <p>それぞれ二枚のランダムなカードを引いた状態でスタートし、手札の合計を考慮した上でカードを引く（Hit）か、そのまま（Stand）を選びます。
        <br>最終的に手札の合計が21に近いプレイヤーが勝ちなのですが、21を超えてしまうと負けとなります。（バースト）
        <br>ジャック・クイーン・キングはいずれも10として計算され、エース（A）は1か11か、手札に好ましい値で自動的にカウントされます。
        <br>今回のCPUは、手札の合計が17以上の際はヒットをしませんので注意してください。
    </p>
    <p>あなた:
        <?php
        foreach($player as $card)
        {
            echo $card['num'] . ' ';
        }
        ?>
        <br /> 合計:
        <?php
        echo $player_total;
        if($player_total > 21)
        {
            echo ' Burst';
        }
        elseif ($endGame === true && $player_total > $opp_total)
        {
            echo ' WIN!';
        }
        ?>
    </p>
    <p>CPU:
        <?php
        foreach($opp as $card)
        {
            echo $card['num'] . ' ';
        }
        ?>
        <br /> 合計:
        <?php
        echo $opp_total;
        if($opp_total > 21)
        {
            echo ' Burst';
        }
        elseif ($endGame === true && $opp_total > $player_total)
        {
            echo ' WIN!';
        }
        ?>
    </p>
    <ul>
        <?php if($endGame === false):?>
        <li><a href="?hit">Hit</a></li>
        <li><a href="?stand">Stand</a></li>
        <?php endif;?>
        <li><a href="?reset">Reset</a></li>
    </ul>
</body>

</html>
