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

// require("pwnameserver/private/config.php");

// $playerruid = $_GET["playeruid"];
// $guid = $playeruid;
$time = date("Y-m-d H:i:s", time()); 

// $config = new pw_name_server_config();
// if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

$conn = @ mysql_connect("fuckyou233.mysql.rds.aliyuncs.com","ucenter","Nz4jBQ7zIV3d1qfTdn108Q01dN62606h")or die("error");
mysql_select_db("xserver",$conn);
$credit_query = "SELECT bank FROM account WHERE guid='2818381';";
$credit_query_rl = mysql_query($credit_query,$conn);
$credit_query_row = mysql_fetch_row($credit_query_rl);
$credit = $credit_query_row[0];
$credit_percentage = 20;
$credit_percentage_row = $credit / $credit_percentage;
echo $credit.'<br>';
echo $credit_percentage_row;
if ($credit_query_row[0]<0) {
	# code...
}
?>