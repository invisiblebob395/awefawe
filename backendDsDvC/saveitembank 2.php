<?php
header_remove();
function set_content_length($output)
{
  header("Content-Length: ".strlen($output));
  return $output;
}
ob_start("set_content_length");
require("pwnameserver/private/config.php");

$guid = $_GET["guid"];
$item1 = $_GET["i1"];
$item2 = $_GET["i2"];
$item3 = $_GET["i3"];
$item4 = $_GET["i4"];
$item5 = $_GET["i5"];
$item6 = $_GET["i6"];
$item7 = $_GET["i7"];
$item8 = $_GET["i8"];
$item9 = $_GET["i9"];
$item10 = $_GET["i10"];
// $item11 = $_GET["i11"];
// $item12 = $_GET["i12"];
// $item13 = $_GET["i13"];
// $item14 = $_GET["i14"];
// $item15 = $_GET["i15"];
// $item16 = $_GET["i16"];
// $item17 = $_GET["i17"];
// $item18 = $_GET["i18"];
// $item19 = $_GET["i19"];
// $item20 = $_GET["i20"];
// $item21 = $_GET["i21"];
// $item22 = $_GET["i22"];
// $item23 = $_GET["i23"];
// $item24 = $_GET["i24"];
// $item25 = $_GET["i25"];
// $item26 = $_GET["i26"];
// $item27 = $_GET["i27"];
// $item28 = $_GET["i28"];
// $item29 = $_GET["i29"];
// $item30 = $_GET["i30"];

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

//Passt, equipment mit auslesen
//Anfügen:

// if($item1 <= "0") {
// 	$item1 = "0";
// }elseif ($tiem2 <='0') {
// 	$item2 = '0';
// }elseif($item3 <= "0") {
// 	$item3 = "0";
// }elseif($item4 <= "0") {
// 	$item4 = "0";
// }elseif($item5 <= "0") {
// 	$item5 = "0";
// }elseif($item6 <= "0") {
// 	$item6 = "0";
// }elseif($item7 <= "0") {
// 	$item7 = "0";
// }elseif($item8 <= "0") {
// 	$item8 = "0";
// }elseif($item9 <= "0") {
// 	$item9 = "0";
// }elseif($item10 <= "0") {
// 	$item10 = "0";
// }elseif($item11 <= "0") {
// 	$item11 = "0";
// }elseif($item12 <= "0") {
// 	$item12 = "0";
// }elseif($item13 <= "0") {
// 	$item13 = "0";
// }elseif($item14 <= "0") {
// 	$item14 = "0";
// }elseif($item15 <= "0") {
// 	$item15 = "0";
// }elseif($item16 <= "0") {
// 	$item16 = "0";
// }elseif($item17 <= "0") {
// 	$item17 = "0";
// }elseif($item18 <= "0") {
// 	$item18 = "0";
// }elseif($item19 <= "0") {
// 	$item19 = "0";
// }elseif($item20 <= "0") {
// 	$item20 = "0";
// }elseif($item21 <= "0") {
// 	$item21 = "0";
// }elseif($item22 <= "0") {
// 	$item22 = "0";
// }elseif($item23 <= "0") {
// 	$item23 = "0";
// }elseif($item24 <= "0") {
// 	$item24 = "0";
// }
if($item1 > 0) {

} 
else {
$item1 = "0";
}

if($item2 > 0) {

} 
else {
$item2 = "0";
}

// $timesave = "$item1|$item2|$item3|$item4|$item5|$item6|$item7|$item8|$item9|$item10|$item11|$item12|$item13|$item14|$item15|$item16|$item17|$item18|$item19|$item20|$item21|$item22|$item23|$item24|";
$timesave = "$item1|$item2|$item3|$item4|$item5|$item6|$item7|$item8|$item9|$item10|0|0|0|0|0|0|0|0|0|0|0|0|0|0|";
$result = mysql_query("UPDATE chestarray SET item = '$itemsave' WHERE guid = '$guid';");

echo "90";

exit;

?>