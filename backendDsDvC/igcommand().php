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

$command = $_GET["value"]; //super global, collect the data sent by URL
                           //value record player input s0
$player_id = $_GET["playerid"];
$guid = $_GET["guid"];

$config = new pw_name_server_config();
if (!$config->connect_database())
{
	exit_code(pw_name_server_config::database_error)
;}

$result = mysql_query("SELECT * FROM account WHERE guid = '$guid';");
$anzahl = @mysql_num_rows($result);
if($anzahl > 0)
{
	for($i=0;$i<$anzahl;$i++)
	{
	//start unactive 
	$row = mysql_fetch_array($result);
	if($command == "/unactive") {
	echo "22|$player_id|";
	echo $row["Realname"]; 
	exit;
	}
	else
	{
	//query bank
	if($command == "/bank") {
	echo "23|$player_id|";
	echo $row["bank"]; 	
	exit;
	}
	}
	
	//fail for bug
	if($command == "") {
	echo "6";
	exit;
	}

    //query guid
	if($command == "/guid") {
	echo "20|$player_id";
	exit;
	} 
	else
	{
	//query water volume
	if($command == "/water") {
	echo "21|$player_id";
	exit;
	}
	else
	{
	echo "9";
	exit;
	}	
	}
}
}

exit;
?>