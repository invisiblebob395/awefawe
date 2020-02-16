<?php
header_remove();
//Custom function
function set_content_length($output)
{
  header("Content-Length: ".strlen($output));
  return $output;
}
ob_start("set_content_length");

require("pwnameserver/private/config.php");
//all of the files are the same

$command = $_GET["value"]; //super global, collect the data sent by URL
                           //value record player input s0
$player_id = $_GET["playerid"];
$guid = $_GET["guid"];

$config = new pw_name_server_config();
if (!$config->connect_database())
{
	exit_code(pw_name_server_config::database_error);
}

function getRealName($guid){
   $config = new pw_name_server_config();
   $config->connect_database();
   $code = rand(10000,99999);
   $result = mysql_query("SELECT COUNT(*) FROM account WHERE Realname = '$code'");
   if($row = mysql_fetch_row($result)){
      if($row[0]==0){
        mysql_query("UPDATE account SET Realname = $code WHERE guid =$guid");
        return $code;
      }else{
        return getRealName($guid); 
      }
   }
}

$result = mysql_query("SELECT * FROM account WHERE guid = '$guid';");
$anzahl = @mysql_num_rows($result);
if($anzahl > 0)
{
	for($i=0;$i<$anzahl;$i++)
	{
	//query guid
	$row = mysql_fetch_array($result);
	if($command == "/guid") {
		echo "20|$player_id";
		exit;
	}
	else
	{
	//query bank
	if($command == "/bank") {
		echo "22|$player_id|";
		echo $row["bank"]; 	
		exit;
		}
	}
	
	//fail for bug
	if($command == "") {
		echo "6";
		exit;
	}
	
	
	if($command =="/realname"){
	   if(!empty($row["Realname"])){
	   	echo "21|$player_id|".$row["Realname"];
		exit;
	   }
	   else
	   {
	   	echo "21|$player_id|".getRealName($guid);
		exit;
	   }
	}
    else
    {
		echo "9";
		exit;
    }

}
}
?>