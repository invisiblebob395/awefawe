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

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

//Passt, equipment mit auslesen
//Anfügen:
$result = mysql_query("SELECT * FROM chest_system WHERE instance_id = '$instance';");
$row = mysql_fetch_array($result);
$anzahl = @mysql_num_rows($result);

if($anzahl == 0) { //2 3 4 5 6 7 8 9101112131415161718192021222324252627282930313233343536373839404142434445464748
echo "88|$instance|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0";
exit;
}

echo "88|$instance|";
echo $row["item_id_list"];
exit;

?>
