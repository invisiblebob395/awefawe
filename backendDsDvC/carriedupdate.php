<?php
//Copyright by Illuminati
//Version: 0.1
/*
	Persistent World Tools
	最后修改日期：2015-11-10
	修改时间戳：1447129063
	汉化：2E
 */
//Standart Nameserver PHP
header_remove();
function set_content_length($output)
{
  header("Content-Length: ".strlen($output));
  return $output;
}
ob_start("set_content_length");

require("pwnameserver/private/config.php");

$playerruid = $_GET["playeruid"];
$gold = $_GET["gold"];
//$bank = $_GET["bank"];
$time = date("Y-m-d H:i:s", time()); 

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

//保存现金数据
//附加:

// 记录银行流水
$logresult = mysql_query("INSERT INTO banklogs (guid,gold,datetime) VALUES ('$playerruid', '$gold', '$time')");

// 更新玩家的现金与存款
$result = mysql_query("UPDATE account SET gold = '$gold' WHERE guid = '$playerruid'");
echo "3";
exit;

?>