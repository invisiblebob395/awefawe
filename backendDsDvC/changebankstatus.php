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


$guid = $_GET["value"];

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

if($guid == "") {
echo "100";
exit;
}

if($guid == "/enablebank") {
echo "101";
exit;
} 
else
{
if($guid == "/disablebank") {
echo "102";
exit;
}
else
{
echo "100";
exit;
}
}
//100 = fail
//101 = enable
//102 = disable

?>