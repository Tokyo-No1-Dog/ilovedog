<?php
$count = 0;
for($i=1896; $i<=2020; $i=$i+4) {
  $count = $count + 1;
  if($i==1916 || $i==1940 || $i==1944) {
    continue;
  }
  echo "第".$count."回";
  echo $i."年";
  echo "\n";
}
