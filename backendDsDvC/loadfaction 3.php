<?php
//Copyright by Illuminati
//Version: 0.1

//Standart Nameserver PHP
header_remove();
function set_content_length($output)
{
  header("Content-Length: ".strlen($output));
  return $output;
}
ob_start("set_content_length");

require("pwnameserver/private/config.php");


$faction = $_GET["faction"];

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

//Anfügen:
$result = mysql_query("SELECT * FROM faction_system WHERE faction_id = '$faction';");
$row = mysql_fetch_array($result);

$banner = $row["faction_banner"];
if($banner == "") {
	exit;
}		

echo "101|$faction|";
echo $row["faction_banner"];
echo "|";
echo $row["faction_name"];
echo "|";
echo $row["military"];
exit;

?>