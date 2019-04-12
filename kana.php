<?php
$kana = 'あ ぁ い ぃ う ぅ え お ぉ か き く け こ さ し す せ そ た ち つ て と な に ぬ ね の は ひ ふ へ ほ ま み む め も や ゃ ゆ ゅ よ ょ ら り る れ ろ わ を ん';
$kanaArray = mb_split("\s", $kana);
for ($i = 0; $i < 2; $i++){
    echo $kanaArray[rand(0, count($kanaArray) - 1)];
}
echo "\n";
