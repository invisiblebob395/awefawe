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
$item1 = $_GET["item1"];
$item2 = $_GET["item2"];
$item3 = $_GET["item3"];
$item4 = $_GET["item4"];
$health = $_GET["health"];
$carriedgold = $_GET["carriedgold"];
$troop = $_GET["troop"];
$faction = $_GET["faction"];
$posx = $_GET["posx"];
$posy = $_GET["posy"];
$posz = $_GET["posz"];
$food = $_GET["food"];
$horse = $_GET["horse"];
$water = $_GET["water"];
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

if($horse > 340) {

}
else
{
$horse = "0";
}


$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

if($body < 0) {
$body = "0";
}

if($faction > 9){

 $faction = null;
}

if($posz < 0) {
$posz="1";
}

$result = mysql_query("UPDATE account SET head = '$head', body = '$body', hand = '$gloves', foot = '$foot', slot1 = '$item1', slot2 = '$item2', slot3 = '$item3', slot4 = '$item4', health = '$health', troop = '$troop', faction = '$faction', gold = '$carriedgold', onlinestatus = '0', position_x = '$posx', position_y = '$posy', position_z = '$posz', food = '$food', horse = '$horse', water = '$water', outlaw = '$outlaw' WHERE guid = '$playerruid';");

echo "3";
exit;

?>