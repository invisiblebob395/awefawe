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

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

/*
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
$skill_point = $_GET["skill_point"];
*/

//@Guid {reg1} save skill: strength: {reg2}|agility: {reg3}|ironflesh: {reg4}|power_strike: {reg5}|power_draw: {reg6}|power_throw: {reg7}|shield: {reg8}|athletics: {reg9}|riding: {reg10}|engineer: {reg11}|wound_treatment: {reg12}|labouring: {reg13}|looting: {reg14}|sailing: {reg15}|tailoring: {reg16}|herding: {reg17}|one_handed: {reg18}|two_handed: {reg19}|polearm: {reg20}|archery: {reg21}|crossbow: {reg22}|throwing: {reg23}|skills: {reg24}|unused: {reg25}"),
$playeruid = $_GET["playeruid"];
$skill = $_GET["skills"];
//$skills = explode("|","$skill");
//$skills[]


$resultcheck = mysql_query("SELECT * FROM accskill WHERE GUID = '$playeruid';");
$check = @mysql_num_rows($resultcheck);
if($check == 0)
{
	//$result = mysql_query("INSERT INTO accountskill (GUID, strength, agility, ironflesh, power_strike, power_draw, power_throw, shield, athletics, riding, engineer, wound_treatment, labouring, looting, sailing, tailoring, herding, one_handed, two_handed, polearm, archery, crossbow, throwing, skill_point, unused) VALUES ('$playeruid','$skills[0]','$skills[1]','$skills[2]','$skills[3]','$skills[4]','$skills[5]','$skills[6]','$skills[7]','$skills[8]','$skills[9]','$skills[10]','$skills[11]','$skills[12]','$skills[13]','$skills[14]','$skills[15]','$skills[16]','$skills[17]','$skills[18]','$skills[19]','$skills[20]','$skills[21]','$skills[22]','$skills[23]');");
   $result = mysql_query("INSERT INTO accskill (GUID, SKILL)   VALUES ('$playeruid','$skill');");
   echo "3";

}
else
{	
    //$result = mysql_query("UPDATE accountskill SET strength = '$skills[0]', agility = '$skills[1]', ironflesh = '$skills[2]', power_strike = '$skills[3]', power_draw = '$skills[4]', power_throw = '$skills[5]' , shield = '$skills[6]', athletics = '$skills[7]', riding = '$skills[8]', engineer = '$skills[9]', wound_treatment = '$skills[10]', labouring = '$skills[11]', looting = '$skills[12]', sailing = '$skills[13]', tailoring = '$skills[14]', herding = '$skills[15]', one_handed = '$$skills[16]', two_handed = '$skills[17]', polearm = '$skills[18]', archery = '$skills[19]', crossbow = '$skills[20]', throwing = '$skills[21]', skill_point = '$skills[22]', unused = '$skills[23]' WHERE GUID = '$playeruid'");
     $result = mysql_query("UPDATE accskill SET SKILL = '$skill' WHERE GUID = '$playeruid'");

    echo "3";
	}

exit;


?>