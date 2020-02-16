<?php
header_remove();
function set_content_length($output)
{
  header("Content-Length: ".strlen($output));
  return $output;
}
ob_start("set_content_length");

require("pwnameserver/private/config.php");

$playerruid = $_GET["playeruid"];
$head = "0";
$body = "0";
$foot = "0";
$gloves = "0";
$item1 = "-1";
$item2 = "-1";
$item3 = "-1";
$item4 = "-1";


$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

$result = mysql_query("UPDATE account SET head = '$head', body = '$body', hand = '$gloves', foot = '$foot', slot1 = '$item1', slot2 = '$item2', slot3 = '$item3', slot4 = '$item4', health = 30, position_x = 0, position_y = 0, position_z = 0, food = 0, horse = 0 WHERE guid = '$playerruid'");
//health：玩家满血下线时，根据当时职业进行血量削减， 最大削减到25HP
echo "3";
exit;

?>