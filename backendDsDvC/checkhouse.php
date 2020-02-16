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

$guid = $_GET["guid"];
$house_id = $_GET["house"];
$player_id = $_GET["playerid"];

$guid = "|" . $guid . "|;";

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

//Passt, equipment mit auslesen
//附加:
$result = mysql_query("SELECT * FROM house_system WHERE house_id = '$house_id';");
$anzahl = @mysql_num_rows($result);
$arrayitems = "";

if($anzahl > 0)
{
	for($i=0;$i<$anzahl;$i++)
	{
	$row = mysql_fetch_array($result);
	$array_key_owners = $row["key_guids"];
	
	if (strpos($array_key_owners,$guid) !== false) {
    echo "103|$player_id|$house_id";
	} else {
		echo "104|$player_id|$house_id";
	}
}
}
else
{
echo "104|$player_id|$house_id";
}

exit;

?>