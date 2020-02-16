<?php

/*
	Persistent World Tools
	最后修改日期：2015-11-10
	修改时间戳：1447129063
	
	Updated by DanyEle on 2016-05-16
	to allow for custom amount depositing.
 */
//启动名字服务器
error_reporting(0);
header_remove();
function set_content_length($output)
{
  header("Content-Length: ".strlen($output));
  return $output;
}
ob_start("set_content_length");

require("pwnameserver/private/config.php");


$playerruid = $_GET["guid"];
$playerid = $_GET["playerid"];
$gold = $_GET["gold"];  //custom amount. it could also be a string. need to validate it. 默认为 5000 一次
$bankgold = "";
$returngold = "";
$carriedgold = $_GET["carried"];
date_default_timezone_set("Asia/Shanghai");
$time = date("Y-m-d H:i:s", time()); 

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

//danyele begin
//Now check if the user is trying to enter a negative amount
if($gold < 0)
{
	echo "11|$playerid|$gold|$carriedgold|0";
	exit;
}

//first of all, validate input. if the user entered a string instead, just leave script.
if(!ctype_digit($gold))
{
	echo "7|$playerid|0|0|0";
	exit;
}

//GOOD! We now know the user entered a number!
//now check if the user is carrying the amount he'd like to deposit or less. if he doesn't, just leave script.

if($gold > $carriedgold)
{
	#he entered a too big amount.
	echo "8|$playerid|$gold|$carriedgold|0";
	exit;
}

$result = mysql_query("SELECT * FROM account WHERE guid = '$playerruid';");
$anzahl = @mysql_num_rows($result);

if($anzahl > 0)
{
	for($i=0;$i<$anzahl;$i++)
	{
	$row = mysql_fetch_array($result);
	$bankgold = $row["bank"];
}
}

if($carriedgold == "0") {
echo "6|$playerid";
exit;
}

//$bankgold = $bankgold + $carriedgold;
//$returngold = $carriedgold;
//$carriedgold = "0";
//the gold the player should have back is the gold he was carrying - the amount he deposited.
//$returngold = $carriedgold - $gold;

$gold_deposited = $gold;
$gold_in_bank = $bankgold + $gold_deposited;
$new_carried_gold = $carriedgold - $gold_deposited;
$deposite_num = $gold_in_bank - $bankgold;
$withdraw_num = "0";
//danyele end.


//返回的现金数量就是我们要提交的数据

// 记录银行流水
//$logresult = mysql_query("INSERT INTO banklogs (guid,gold,bank,datetime) VALUES ('$playerruid', '$carriedgold', '$bankgold', '$time')");
//$logresult = mysql_query("INSERT INTO banklogs (guid,gold,bank,datetime) VALUES ('$playerruid', '$new_carried_gold', '$gold_in_bank', '$time')");
$logresult = mysql_query("INSERT INTO banklogs (guid,gold,bank,deposite_num,withdraw_num,now_gold,now_bank,datetime) VALUES ('$playerruid', '$carriedgold', '$bankgold', '$deposite_num', '$withdraw_num', '$new_carried_gold', '$gold_in_bank', '$time')");


// 更新玩家的现金与存款
$result = mysql_query("UPDATE account SET gold = '$new_carried_gold', bank = '$gold_in_bank' WHERE guid = '$playerruid'");
//5 ist für Gold Deposit
echo "5|$playerid|$gold_deposited|$gold_in_bank|$new_carried_gold";
exit;

?>