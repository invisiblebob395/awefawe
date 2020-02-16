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


$playerruid = $_GET["playeruid"];
$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

if($playerruid == "ALL") {
$result = mysql_query("UPDATE account SET onlinestatus = 0");
}
else {
$result = mysql_query("UPDATE account SET onlinestatus = 0 WHERE guid = '$playerruid'");
}

echo "3";
exit;

?>