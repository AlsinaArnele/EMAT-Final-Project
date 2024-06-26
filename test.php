<?php
$time = "11:00";
$date = date('Y-m-d H:i:s', strtotime('today '.$time.':00'));
echo $date;
?>