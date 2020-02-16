<?php
header_remove();
function set_content_length($output)
{
  header("Content-Length: ".strlen($output));
  return $output;
}
ob_start("set_content_length");

require("pwnameserver/private/config.php");

$faction = $_GET["faction"];
$name = $_GET["name"];
$banner = $_GET["banner"];
$military = $_GET["military"];

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

$resultcheck = mysql_query("SELECT * FROM faction_system WHERE faction_id = '$faction';");
$anzahl = @mysql_num_rows($resultcheck);

if($anzahl == 0) {
	$result = mysql_query("INSERT INTO faction_system (faction_id, faction_banner, military) VALUES ('$faction', '$banner', '$military');");
    echo "3";
} else {
	$result = mysql_query("UPDATE faction_system SET faction_banner = '$banner', military = '$military' WHERE faction_id = '$faction';");
    echo "3";
}

exit;

?>