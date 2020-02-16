<?php
//
//	Persistent World Tools
//	最后修改日期：2015-11-10
//	修改时间戳：1447129063
//
//启动名字服务器
header_remove();
function set_content_length($output)
{
  header("Content-Length: ".strlen($output));
  return $output;
}
ob_start("set_content_length");


require("pwnameserver/private/config.php");
$name = $_GET["name"];
$guid = $_GET["guid"];
$admin = $_GET["admin"];
$type = $_GET["type"];

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);
// 新增一名被封禁的玩家的记录到banhistory(封禁历史)表
$result = mysql_query("INSERT INTO banhistory (GUID, Playername, Admin, Type, Reason, Amount) VALUES ('$guid', '$name', '$admin', '$type', '-', '0');");

if($type == "PermBan") 
{
// 同时向Banlist(封禁列表)插入、Account(账户)更新数据
/*
$checkexist = mysql_query("SELECT * FROM ban_stat WHERE GUID = '$guid';");
$checkresult = @mysql_num_rows($checkexist);

if(($checkresult > 0) AND ($checkresult2 + $checkresult3 > 0))
*/
$checkexist = mysql_query("SELECT * FROM ban_stat WHERE GUID = '$guid';");
$checkresult = @mysql_num_rows($checkexist);
$checkexist2 = mysql_query("SELECT * FROM ban_stat WHERE Playername = '$name';");
$checkresult2 = @mysql_num_rows($checkexist2);
$checkexist3 = mysql_query("SELECT * FROM ban_stat WHERE Playername2 = '$name';");
$checkresult3 = @mysql_num_rows($checkexist3);
if($checkresult > 0)
{
$result3 = mysql_query("INSERT INTO banlist (GUID, Playername, Reason, Unbanat, Admin) VALUES ('$guid', '$name', 'IG Ban', '-', '$admin');"); 
// 更新用户表数据
$result4 = mysql_query("UPDATE ban_stat SET Banned = '1' WHERE GUID = '$guid';"); 
$result5 = mysql_query("UPDATE account SET Realname = '0' WHERE guid = '$guid';"); 
//rseult6 = mysql_query("DELETE FROM rnlist WHERE guid='$guid';");
}
else
{
$result7 = mysql_query("INSERT INTO banlist (GUID, Playername, Reason, Unbanat, Admin) VALUES ('$guid', '$name', 'IG Ban', '-', '$admin');"); 
$result8 = mysql_query("INSERT INTO ban_stat (GUID, Playername, PrimaryID, Playername2, PrimaryID2, Banned) VALUES ('$guid', 'NO NAME', 'NO NAME', 'NO NAME', 'NO NAME', '1');"); 

}
}
echo "9";
exit;
?>