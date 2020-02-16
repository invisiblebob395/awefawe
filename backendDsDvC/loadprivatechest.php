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


$guid = $_GET["guid"];
$player_id = $_GET["playerid"];

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

//Passt, equipment mit auslesen
//Anfügen:
$result = mysql_query("SELECT * FROM chest_private_system WHERE guid = '$guid';");
$row = mysql_fetch_array($result);
$anzahl = @mysql_num_rows($result);

if($anzahl == 0) { //2 3 4 5 6 7 8 91011121314151617181920212223242526272829303132
echo "89|$player_id|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0";
exit;
}

echo "89|$player_id|";
echo $row["item_id_list"];
exit;

?>
