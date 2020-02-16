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
$player_id = $_GET["playerid"];

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);


$result = mysql_query("SELECT * FROM account WHERE guid = '$playerruid';");
$anzahl = @mysql_num_rows($result);

if($anzahl > 0)
{
	for($i=0;$i<$anzahl;$i++)
	{
	$row = mysql_fetch_array($result);
		echo "2|$player_id|";
		echo $row["head"];
		echo "|";
		echo $row["body"]; 
		echo "|";
		echo $row["hand"];
		echo "|";
		echo $row["foot"];
		echo "|";
		echo $row["slot1"];
		echo "|";
		echo $row["slot2"]; 
		echo "|";
		echo $row["slot3"]; 
		echo "|";
		echo $row["slot4"]; 
		echo "|";
		echo $row["health"];
		echo "|";
		echo $row["faction"]; 
		echo "|";
		echo $row["troop"]; 
		echo "|";
		echo $row["position_x"];
		echo "|";
		echo $row["position_y"];
		echo "|";
		echo $row["position_z"];
		echo "|";
		echo $row["food"];
		echo "|";
		$horse = $row["horse"];
		if($horse > "340") {
		echo $horse;
		}
		else
		{
		echo "0";
		}
		echo "|";		
		echo $row["water"];
		echo "|";		
		echo $row["outlaw"];
}
}
else
{
echo "1|$player_id|$playerruid|server|-1";
}

exit;

?>