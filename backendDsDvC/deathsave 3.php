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
$head = $_GET["head"];
$body = $_GET["body"];
$foot = $_GET["foot"];
$gloves = $_GET["gloves"];
//$item1 = $_GET["item1"];
//$item2 = $_GET["item2"];
//$item3 = $_GET["item3"];
//$item4 = $_GET["item4"];
$carriedgold = $_GET["carriedgold"];
$troop = $_GET["troop"];
$faction = $_GET["faction"];
/*
$health = $_GET["health"];
$posx = $_GET["posx"];
$posy = $_GET["posy"];
$posz = $_GET["posz"];
$food = $_GET["food"];
$water = $_GET["water"];
$horse = $_GET["horse"];
*/
$outlaw = $_GET["outlaw"];

if($head <= "0") {
$head = "-1";
}
if($body <= "0") {
$body = "-1";
}
if($foot <= "0") {
$foot = "-1";
}
if($gloves <= "0") {
$gloves = "-1";
}

/*
if($item1 <= "0") {
$item1 = "-1";
}
if($item2 <= "0") {
$item2 = "-1";
}
if($item3 <= "0") {
$item3 = "-1";
}
if($item4 <= "0") {
$item4 = "-1";
}
*/

/*
if($horse > 340) {

}
else
{
$horse = "0";
}
*/

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

if($body < 0) {
$body = "0";
}

/*
if($posz < 0) {
$posz="1";
}
*/

$result = mysql_query("UPDATE account SET head = '$head', body = '$body', hand = '$gloves', foot = '$foot', troop = '$troop', faction = '$faction', gold = '$carriedgold', onlinestatus = '0', outlaw = '$outlaw' WHERE guid = '$playerruid';");

echo "3";
exit;

?>