<?php
header_remove();
//Custom function
function set_content_length($output)
{
  header("Content-Length: ".strlen($output));
  return $output;
}
ob_start("set_content_length");

require("pwnameserver/private/config.php");
//all of the files are the same

$verison = $_GET["verison"]; //super global, collect the data sent by URL
                           //value record player input s0
$guid = $_GET["guid"];

$config = new pw_name_server_config();
if (!$config->connect_database())
{
	exit_code(pw_name_server_config::database_error)
;}

$result = mysql_query("SELECT * FROM ban_stat WHERE GUID = '$guid';");
$anzahl = @mysql_num_rows($result);
if($anzahl > 0)
{
	for($i=0;$i<$anzahl;$i++)
	{
	$row = mysql_fetch_array($result);
	if($veriosn = "4546") {
	echo "9";
	exit;
	}
	else
	{
	echo "-2|$player_id";
	exit;
	}	
	}
}
}

exit;
?>