<?php
//danyele: get input from the user here.
//$playerruid = $_GET["guid"];
$playerid = $_GET["playerid"];
//$carriedgold = $_GET["carried"];
//date_default_timezone_set("Asia/Shanghai");
//$time = date("Y-m-d", time()); 

$message = "请 按 Q或 者 Backspace输 入 一 个 想 从 银 行 取 出 的 金 额 。";

//2 integer. 1 string. set the player so he's gonna need to enter the amount as a next message.
echo "98|$playerid|$message";
exit;

?>