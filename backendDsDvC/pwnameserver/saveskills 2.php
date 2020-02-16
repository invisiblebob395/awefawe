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

$playeruid = $_GET["playeruid"];
$strength = $_GET["strength"];
$agility = $_GET["agility"];
$ironflesh = $_GET["ironflesh"];
$power_strike = $_GET["power_strike"];
$power_draw = $_GET["power_draw"];
$power_throw = $_GET["power_throw"];
$shield = $_GET["shield"];
$athletics = $_GET["athletics"];
$riding = $_GET["riding"];
$engineer = $_GET["engineer"];
$wound_treatment = $_GET["wound_treatment"];
$labouring = $_GET["labouring"];
$looting = $_GET["looting"];
$sailing = $_GET["sailing"];
$tailoring = $_GET["tailoring"];
$herding = $_GET["herding"];
$one_handed = $_GET["one_handed"];
$two_handed = $_GET["two_handed"];
$polearm = $_GET["polearm"];
$archery = $_GET["archery"];
$crossbow = $_GET["crossbow"];
$throwing = $_GET["throwing"];
$skills = $_GET["skills"];

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

$resultcheck = mysql_query("SELECT * FROM accountskill WHERE GUID = '$playeruid';");
$check = @mysql_num_rows($resultcheck);
if($check == 0)
{
	$result = mysql_query("INSERT INTO accountskill (GUID, strength, agility, ironflesh, power_strike, power_draw, power_throw, shield, athletics, riding, engineer, wound_treatment, labouring, looting, sailing, tailoring, herding, one_handed, two_handed, polearm, archery, crossbow, throwing, skill_point) VALUES ('$playeruid','$strength','$agility','$ironflesh','$power_strike','$power_draw','$power_throw','$shield','$athletics','$riding','$engineer','$wound_treatment','$labouring','$looting','$sailing','$tailoring','$herding','$one_handed','$two_handed','$polearm','$archery','$crossbow','$throwing','$skills');");
    echo "4";

}
else
{	
    $result = mysql_query("UPDATE accountskill SET strength = '$strength', agility = '$agility', ironflesh = '$ironflesh', power_strike = '$power_strike', power_draw = '$power_draw', shield = '$shield', athletics = '$athletics', riding = '$riding', engineer = '$engineer', wound_treatment = '$wound_treatment', labouring = '$labouring', looting = '$looting', sailing = '$sailing', tailoring = '$tailoring', herding = '$herding', one_handed = '$one_handed', two_handed = '$two_handed', polearm = '$polearm', archery = '$archery', crossbow = '$crossbow', throwing = '$throwing', skills = '$skills' WHERE GUID = '$playeruid'");
    echo "4";
	}

exit;


?>