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


$instance = $_GET["instance"];
$items = $_GET["item"];

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

$resultcheck = mysql_query("SELECT * FROM chest_system WHERE instance_id = '$instance';");
$anzahl = @mysql_num_rows($resultcheck);

if($anzahl == 0) {
	$result = mysql_query("INSERT INTO chest_system (instance_id, item_id_list) VALUES ('$instance', '$items');");
    echo "3";
} else {
	$result = mysql_query("UPDATE chest_system SET item_id_list = '$items' WHERE instance_id = '$instance';");
    echo "3";
}

exit;

?>
