<?php
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
$gold = $_GET["gold"]; //custom amount. Nicht immer 5000
$bankgold = "";
$returngold = "";
$carriedgold = $_GET["carried"];
date_default_timezone_set("Asia/Shanghai");
$time = date("Y-m-d H:i:s", time()); 

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);


//danyele begin

//first of all, validate input. if the user entered a string instead, just leave script.
if($gold < 0)
{
	echo "12|$playerid|$gold|$carriedgold|0";
	exit;
}

if(!ctype_digit($gold))
{
	echo "13|$playerid|0|0|0";
	exit;
}


//GOOD! We now know the user entered a number!
//now check if the user does have in his bank account the amount he specified.
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

//the user entered a too big amount he doesn't have in his bank account.
if($gold > $bankgold)
{
	//he entered a too big amount. gold is the gold he wanted to withdraw. carried gold iw what he has.
	echo "10|$playerid|$gold|$bankgold|0";
	exit;
}

//none of the above conditions was met, go ahead and actually withdraw.


//again, gold is the amount entered by the user.
if($bankgold >= $gold)
{
	//第纳尔计算
	$new_bankgold = $bankgold - $gold;
	$returngold = $gold;
	$new_carriedgold = $carriedgold + $returngold;
	$deposite_num = "0";
    $withdraw_num = $bankgold - $new_bankgold;
} 
else 
{
	//not enough gold in bank? already a check above for this.
	if($bankgold < $gold) 
	{
		$returngold = $bankgold;
		$bankgold = "0";
		$new_carriedgold = $carriedgold + $returngold;
	}
}

//返回的数值就是我们要保存到数据库的
//Bankgold ist das was wir noch auf der Bank haben.
//CArriedgold ist das was wir nun haben auf der Hand.

//保存
//附加：

// 记录银行流水
//$logresult = mysql_query("INSERT INTO banklogs (guid,gold,bank,datetime) VALUES ('$playerruid', '$new_carriedgold', '$new_bankgold', '$time')");
$logresult = mysql_query("INSERT INTO banklogs (guid,gold,bank,deposite_num,withdraw_num,now_gold,now_bank,datetime) VALUES ('$playerruid', '$carriedgold', '$bankgold', '$deposite_num', '$withdraw_num', '$new_carriedgold', '$new_bankgold', '$time')");


// 更新玩家的现金与存款
$result = mysql_query("UPDATE account SET gold = '$new_carriedgold', bank = '$new_bankgold' WHERE guid = '$playerruid'");

//4 ist für Gold Withdraw
echo "4|$playerid|$returngold|$new_bankgold|$new_carriedgold";
exit;

?>