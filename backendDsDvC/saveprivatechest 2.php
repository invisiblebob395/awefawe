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
$items = $_GET["item"];

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);
//echo "86";
$resultcheck = mysql_query("SELECT * FROM chest_private_system WHERE guid = '$guid';");
$anzahl = @mysql_num_rows($resultcheck);

if($anzahl == 0) {
	//echo "86";
	$result = mysql_query("INSERT INTO chest_private_system (guid, item_id_list) VALUES ('$guid', '$items');");
    echo "3";
} else {
	$result = mysql_query("UPDATE chest_private_system SET item_id_list = '$items' WHERE guid = '$guid';");
    echo "3";
}

exit;

?>
