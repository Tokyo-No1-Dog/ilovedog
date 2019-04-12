<?php
    date_default_timezone_set('Asia/Tokyo');

    $jikkan = array("甲", "乙", "丙", "丁", "戊", "己", "庚", "辛", "壬", "癸");
    $juunishi = array("子", "丑", "寅", "卯", "辰", "巳", "午", "未", "申", "酉", "戌", "亥");
    $thisYear = date("Y");
    $N = ($thisYear + 6) % 10;
    $Y = ($thisYear + 8) % 12;
    echo "今年の干支は".$jikkan[$N].$juunishi[$Y]."です。";
    echo "\n";
