<?php

header_remove();
function set_content_length($output)
{
  header("Content-Length: ".strlen($output));
  return $output;
}
ob_start("set_content_length");

require("pwnameserver/private/config.php");


$guid = $_GET["guid"];
$player_id = $_GET["playerid"];

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);


$result = mysql_query("SELECT * FROM account WHERE guid = '$guid';");
$anzahl = @mysql_num_rows($result);
$arrayitems = "";

if($anzahl > 0)
{
	for($i=0;$i<$anzahl;$i++)
	{
	$row = mysql_fetch_array($result);
		echo "89|$player_id|"; //2,3,4,5,6,7,8,9,10,11
		echo $row["ChestArray"];
}
}
else
{
echo "6|$player_id|$playerruid|server|-1";
}

exit;

?>