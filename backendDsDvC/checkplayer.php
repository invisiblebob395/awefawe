<?php
//Copyright by Illuminati
//Version: 0.1
/*
	Persistent World Tools
	最后修改日期：2015-11-10
	修改时间戳：1447129063
	汉化：2E
 */


/*检查玩家的GUID是否已经存在于数据库中，如果没有则向pw_player_names表中插入数据；

一个标准的玩家账户: 生命值(Health) = 100, 银行存款(Bank) = 15000, 现金(Gold) = 5000；

X服调整为：银行存款(Bank) = 5000, 现金(Gold) = 700；

 */
$time = date("Y-m-d H:i:s", time()); 
//启动名字服务器
header_remove();
function set_content_length($output)
{
  header("Content-Length: ".strlen($output));
  return $output;
}
ob_start("set_content_length");

require("pwnameserver/private/config.php");

//function player_check_clan_tag($player_uid, $escaped_name)
//{
  //$clan_tag = strtok($escaped_name, "\\".pw_name_server_config::valid_separators);
//  if ($clan_tag !== false)
//  {
//    $result = mysql_query("SELECT clan_id FROM clan_tags WHERE tag = '$clan_tag';");
//    if (!$result) return pw_database_error();
//    if ($row = mysql_fetch_assoc($result))
//    {
//      $result = mysql_query("SELECT id FROM clan_players WHERE clan_id = '$row[clan_id]' AND unique_id = '$player_uid';");
//      if (!$result) return pw_database_error();
//      if (mysql_num_rows($result) == 0)
//      {
//        return pw_name_server_config::clan_tag_error;
//      }
//    }
// }
//  return 0;
//}

//检查该账户GUID是否存在 - 一般来说：一切正常
function player_register_name($player_uid, $escaped_name, $warband_server_id, $player_id)
	{
		global $time;//调用全局时间函数
		//检查是否从服务器请求错误
		if($player_uid == "0") {
		return pw_name_server_config::success;
		}


		//2015-11-22日正式启用
		//检查玩家是否通过天眼验证
		//$rnresult = mysql_query("SELECT * FROM account WHERE guid = '$player_uid' AND Realname = '1';");
		//$checkrn = @mysql_num_rows($rnresult);
		//if($checkrn == 1){
			//echo "-7|$player_id";
			//exit;
		//}
		//signproject:
		$statcheck = mysql_query("SELECT * FROM ban_stat WHERE binary Playername ='$escaped_name' AND GUID = '$player_uid';");
		$statcheck2 = mysql_query("SELECT * FROM ban_stat WHERE binary Playername2 ='$escaped_name' AND GUID = '$player_uid';");
		$guidnumcheck = mysql_query("SELECT * FROM ban_stat WHERE GUID = '$player_uid';");
		$registername = explode("_",$escaped_name);
		$primaryid = end($registername);
		$signchecker1 = mysql_query("SELECT * FROM ban_stat WHERE PrimaryID = '$primaryid';");
		$signchecker2 = mysql_query("SELECT * FROM ban_stat WHERE PrimaryID2 = '$primaryid';");
		$guidnumber =  @mysql_num_rows($guidnumcheck);
		$signnamecheck1 = @mysql_num_rows($signchecker1);
		$signnamecheck2 = @mysql_num_rows($signchecker2);
		$emptyfind = mysql_fetch_array($guidnumcheck);
		$emptyfinderr1 = $emptyfind["PrimaryID"];
		$emptyfinderr2  = $emptyfind["PrimaryID2"];
		$anzahP = @mysql_num_rows($statcheck);
		$anzahP2 = @mysql_num_rows($statcheck2);
        if($anzahP > 0 OR $anzahP2 > 0 )//0
		{
		// 查询所有玩家表中GUID=进入服务器的GUID
	    $resultcheck = mysql_query("SELECT * FROM account WHERE guid = '$player_uid';");
		$anzahl = @mysql_num_rows($resultcheck);

		if($anzahl > 0)//1
		{
		checkname:
			//账号已存在？
			//检查游戏ID是否已存在
			$resultnames = mysql_query("SELECT * FROM player_names WHERE unique_id = '$player_uid';");
			$anzahlname = @mysql_num_rows($resultnames);
			if($anzahlname > 0) //2
			{
			//游戏ID存在, 检查GUID是否匹配，否则调用 name_used_error
			$resultnamesresult = mysql_query("SELECT * FROM player_names WHERE name = '$escaped_name' AND unique_id = '$player_uid';");
			$anzahlresultresult = @mysql_num_rows($resultnamesresult);
			if($anzahlresultresult > 0)
			{
			//根据GUID更新玩家在线(onlinestatus字段)状态
			$updater = mysql_query("UPDATE account SET onlinestatus = '1', lastname = '$escaped_name' WHERE guid = '$player_uid';");
			return pw_name_server_config::success;
			//立刻更新玩家的在线状态(实时)
			}
			else
			{
			//该游戏ID无法匹配GUID，T出玩家
			//return pw_name_server_config::name_used_error;
			$result = mysql_query("INSERT INTO player_names (unique_id, name, last_used_time, inserted_by_warband_server_id) VALUES ('$player_uid', '$escaped_name', '$time' ,'$warband_server_id');");
			$updater = mysql_query("UPDATE account SET onlinestatus = '1', lastname = '$escaped_name' WHERE guid = '$player_uid';");
			return pw_name_server_config::success;
			}
			}
			else//2
			{
			//账号不存在，创建新账号
			$result = mysql_query("INSERT INTO player_names (unique_id, name, last_used_time, inserted_by_warband_server_id) VALUES ('$player_uid', '$escaped_name', '$time' ,'$warband_server_id');");
			$updater = mysql_query("UPDATE account SET onlinestatus = '1', lastname = '$escaped_name' WHERE guid = '$player_uid';");
			return pw_name_server_config::success;
			//立刻更新玩家的在线状态(实时)
			}
			
		}
		else//1
		{
			//定义创建新账号的字符串数据
			$zero = "0"; // 定义默认装备数值
			$zerod = "-1"; // 定义默认装备数值
			$bankgold = "5000"; // 定义默认新账户的银行存款
			$carriedgold = "700"; // 定义默认新账户的现金(不包含服务端设置)
			$chestarrayv = "0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0";
			$resultnew = mysql_query("INSERT INTO account (guid, head, body, hand, foot, horse, slot1, slot2, slot3, slot4, health, faction, troop, gold, bank, onlinestatus, lastname, Realname, water) VALUES ('$player_uid', '$zero', '$zero','$zero','$zero','$zero','$zerod','$zerod','$zerod','$zerod', 100, '$zero', 4, '$carriedgold', '$bankgold', 1, '$escaped_name', '0', '0');");
			$resultnew2 = mysql_query("INSERT INTO player_names (unique_id, name, last_used_time, inserted_by_warband_server_id) VALUES ('$player_uid', '$escaped_name', '$time' ,'$warband_server_id');");
			$resultnew3 = mysql_query("INSERT INTO chestarray (guid,item) VALUES ('$player_uid', '$chestarrayv')");
			$passport = mysql_query("INSERT INTO passport VALUES ('$player_uid', 'OverWorld'， '1','-1','$time','System')");
			$credit = mysql_query("INSERT INTO credit (guid,name,credit,date) VALUES ('$player_uid' , '$escaped_name' , '0' , '$time')");
			goto checkname; //创建账户同时不检查游戏ID与GUID匹配，允许玩家登录游戏
		}
		}
		elseif((empty($emptyfinderr1) == false and empty($emptyfinderr2) == false) AND ($emptyfinderr1 != $primaryid AND $emptyfinderr2 != $primaryid))
		//($guidnumber > 0 AND ($signnamecheck1 + $signnamecheck2 == 0) AND (empty($emptyfinder) == false))
		{
		 return pw_name_server_config::name_used_error;
		}
		else//0
		{
		//return pw_name_server_config::name_used_error;\
		//CHECK REAPEAT ID
		
		/*$repeatid = mysql_query("SELECT * FROM ban_stat WHERE binary PrimaryID = '$primaryid';");
		$repeatid2 = mysql_query("SELECT * FROM ban_stat WHERE binary PrimaryID2 = '$primaryid';");
		$guidrow = mysql_fetch_array($repeatid);
		$guidrow2 = mysql_fetch_array($repeatid2);
		$repeatguid = $guidrow["GUID"];
		$repeatguid2 = $guidrow2["GUID"];
		$existguid = mysql_query("SELECT * FROM ban_stat WHERE GUID = '$repeatguid';");
		$existguid2 = mysql_query("SELECT * FROM ban_stat WHERE GUID = '$repeatguid2';");
		$realexistguid = @mysql_num_rows($existguid);
		$realexistguid2 = @mysql_num_rows($existguid2);
		$array = array();
       // If($realexistguid + $realexistguid2 > 0 AND $repeatguid != $player_uid AND $repeatguid2 != $player_uid)
		 If($realexistguid + $realexistguid2 > 0) AND ($repeatguid != $player_uid OR $repeatguid2 != $player_uid) AND (empty($emptyfinder) == false))
		{	
		return pw_name_server_config::not_registered_erro;
		}
		else
        {*/
			//$registername = explode("_",$escaped_name);
		//$primaryid = end($registername);
		
                $knowname = mysql_query("SELECT * FROM ban_stat WHERE PrimaryID = '$primaryid' AND GUID = '$player_uid';");
				$knowname2 = mysql_query("SELECT * FROM ban_stat WHERE PrimaryID2 = '$primaryid' AND GUID = '$player_uid';");
				$checknum = mysql_fetch_array($knowname);
                $knownname = @mysql_num_rows($knowname);
				$knownname2 = @mysql_num_rows($knowname2);
				$firstnumcheck = $checknum["PrimaryID"];
				$firstnumcheck2 = $checknum["PrimaryID2"];
				$detecempty = mysql_query("SELECT * FROM ban_stat WHERE GUID = '$player_uid';");
				$detecempty2 = mysql_fetch_array($detecempty);
				$emptyfinder1 = $detecempty2["PrimaryID"];
				$emptyfinder2 = $detecempty2["PrimaryID2"];
				$rowexist = mysql_query("SELECT * FROM ban_stat WHERE GUID = '$player_uid';");
				$rowcheck = @mysql_num_rows($rowexist);
                //$resultcheck = mysql_query("SELECT * FROM ban_stat WHERE GUID = '$player_uid';");
                //$anzahnl = @mysql_num_rows($resultcheck);
                 //if($knownname + $knownname2 == 0)
					 if($emptyfinder1 == $primaryid OR $emptyfinder2 == $primaryid)
				 {
			//	 if($emptyfinder1 == $primaryid OR $emptyfinder2 == $primaryid)
		    // {

				//$outputname = mysql_query("SELECT * FROM ban_stat WHERE PrimaryID = '$primaryid' AND GUID = '$player_uid';");
				//$namerow = mysql_fetch_array($outputname);
				//$primaryname = $namerow["Playername"];
				//if($primaryid == $primarynameid)
				//{
				if($primaryid == $firstnumcheck)
				{$primary_decide= 1 ;}
			    else
				{$primary_decide= 2 ;}
			    switch($primary_decide)
				{
					case 1:
					$rename = mysql_query("UPDATE ban_stat SET Playername = '$escaped_name' WHERE guid = '$player_uid';");
					goto register1;
					break;
					case 2:
					$rename2 = mysql_query("UPDATE ban_stat SET Playername2 = '$escaped_name' WHERE guid = '$player_uid';");
				    goto register1;
					break;
				}
					//return pw_name_server_config::change_success;
					//echo "0|$player_id|";
					//echo "-9|$player_id|";
					//$array[]=player_register_name($player_uid, $escaped_name, $warband_server_id, $player_id);
					//goto signproject;
	    register1:				
		$statcheck = mysql_query("SELECT * FROM ban_stat WHERE Playername ='$escaped_name' AND GUID = '$player_uid';");
		$statcheck2 = mysql_query("SELECT * FROM ban_stat WHERE Playername2 ='$escaped_name' AND GUID = '$player_uid';");
		$anzahP = @mysql_num_rows($statcheck);
		$anzahP2 = @mysql_num_rows($statcheck2);
        if($anzahP > 0 OR $anzahP2 > 0)//0
		{
	    $resultcheck = mysql_query("SELECT * FROM account WHERE guid = '$player_uid';");
		$anzahl = @mysql_num_rows($resultcheck);

		if($anzahl > 0)//1
		{
		checkname2:
			$resultnames = mysql_query("SELECT * FROM player_names WHERE unique_id = '$player_uid';");
			$anzahlname = @mysql_num_rows($resultnames);
			if($anzahlname > 0) //2
			{
			$resultnamesresult = mysql_query("SELECT * FROM player_names WHERE name = '$escaped_name' AND unique_id = '$player_uid';");
			$anzahlresultresult = @mysql_num_rows($resultnamesresult);
			if($anzahlresultresult > 0)
			{
			$updater = mysql_query("UPDATE account SET onlinestatus = '1', lastname = '$escaped_name' WHERE guid = '$player_uid';");
			return pw_name_server_config::change_success;
			}
			else
			{
			//return pw_name_server_config::name_used_error;
			$result = mysql_query("INSERT INTO player_names (unique_id, name, last_used_time, inserted_by_warband_server_id) VALUES ('$player_uid', '$escaped_name', '$time' ,'$warband_server_id');");
			$updater = mysql_query("UPDATE account SET onlinestatus = '1', lastname = '$escaped_name' WHERE guid = '$player_uid';");
			return pw_name_server_config::change_success;
			}
			}
			else//2
			{
			$result = mysql_query("INSERT INTO player_names (unique_id, name, last_used_time, inserted_by_warband_server_id) VALUES ('$player_uid', '$escaped_name', '$time' ,'$warband_server_id');");
			$updater = mysql_query("UPDATE account SET onlinestatus = '1', lastname = '$escaped_name' WHERE guid = '$player_uid';");
			return pw_name_server_config::change_success;
			}
			
		}
		else//1
		{
			//定义创建新账号的字符串数据
			$zero = "0"; // 定义默认装备数值
			$zerod = "-1"; // 定义默认装备数值
			$bankgold = "5000"; // 定义默认新账户的银行存款
			$carriedgold = "700"; // 定义默认新账户的现金(不包含服务端设置)
			$chestarrayv = "0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0";
			$resultnew = mysql_query("INSERT INTO account (guid, head, body, hand, foot, horse, slot1, slot2, slot3, slot4, health, faction, troop, gold, bank, onlinestatus, lastname, Realname, water) VALUES ('$player_uid', '$zero', '$zero','$zero','$zero','$zero','$zerod','$zerod','$zerod','$zerod', 100, '$zero', 4, '$carriedgold', '$bankgold', 1, '$escaped_name', '0', '0');");
			$resultnew2 = mysql_query("INSERT INTO player_names (unique_id, name, last_used_time, inserted_by_warband_server_id) VALUES ('$player_uid', '$escaped_name', '$time' ,'$warband_server_id');");
			$resultnew3 = mysql_query("INSERT INTO chestarray (guid,item) VALUES ('$player_uid', '$chestarrayv')");
			$passport = mysql_query("INSERT INTO passport VALUES ('$player_uid', 'OverWorld'， '1','-1','$time','System')");
			$credit = mysql_query("INSERT INTO credit (guid,name,credit,date) VALUES ('$player_uid' , '$escaped_name' , '0' , '$time')");
			goto checkname2; //创建账户同时不检查游戏ID与GUID匹配，允许玩家登录游戏
		}
		}
					
			/*	}
				else
				{
				return pw_name_server_config::wrong_key;
				}*/
		     }
		    elseif(($emptyfinder1 != $primaryid AND (empty($emptyfinder2)==true)) OR $rowcheck == 0)
			 {
			$checkstat1 = mysql_query("SELECT * FROM ban_stat WHERE binary PrimaryID = '$primaryid';");
			$checkstats1 = @mysql_num_rows($checkstat1);
			$checkstat2 = mysql_query("SELECT * FROM ban_stat WHERE binary PrimaryID2 = '$primaryid';");
			$checkstats2 = @mysql_num_rows($checkstat2);
			//return pw_name_server_config::name_used_error;
			if($rowcheck == 0 AND ($checkstats1 + $checkstats2 == 0))
			{$primary_decide2= 1 ;}
			elseif ($rowcheck == 1 AND ($checkstats1 + $checkstats2 == 0))
			{$primary_decide2= 2 ;}
			else
			{$primary_decide2= 3 ;}

			switch($primary_decide2)
				{
					case 1:
					$inseban1 = mysql_query("INSERT INTO ban_stat (GUID, Playername, PrimaryID, Banned) VALUES ('$player_uid', '$escaped_name', '$primaryid','0')");
					goto register2;
					break;
					case 2:
					$inseban2 = mysql_query("UPDATE ban_stat SET Playername2 = '$escaped_name', PrimaryID2 = '$primaryid'  WHERE guid = '$player_uid';");
				    goto register2;
					break;
					case 3:
					return pw_name_server_config::wrong_key;
					break;
				}
			//return pw_name_server_config::register_success;
			//echo "0|$player_id|";
			//echo "-4|$player_id|";
			//$array[]=player_register_name($player_uid, $escaped_name, $warband_server_id, $player_id);
			//goto signproject;
		register2:
		$statcheck = mysql_query("SELECT * FROM ban_stat WHERE Playername ='$escaped_name' AND GUID = '$player_uid';");
		$statcheck2 = mysql_query("SELECT * FROM ban_stat WHERE Playername2 ='$escaped_name' AND GUID = '$player_uid';");
		$anzahP = @mysql_num_rows($statcheck);
		$anzahP2 = @mysql_num_rows($statcheck2);
        if($anzahP > 0 or $anzahP2 > 0)//0
		{
	    $resultcheck = mysql_query("SELECT * FROM account WHERE guid = '$player_uid';");
		$anzahl = @mysql_num_rows($resultcheck);

		if($anzahl > 0)//1
		{
		checkname3:
			$resultnames = mysql_query("SELECT * FROM player_names WHERE unique_id = '$player_uid';");
			$anzahlname = @mysql_num_rows($resultnames);
			if($anzahlname > 0) //2
			{
			$resultnamesresult = mysql_query("SELECT * FROM player_names WHERE name = '$escaped_name' AND unique_id = '$player_uid';");
			$anzahlresultresult = @mysql_num_rows($resultnamesresult);
			if($anzahlresultresult > 0)
			{
			$updater = mysql_query("UPDATE account SET onlinestatus = '1', lastname = '$escaped_name' WHERE guid = '$player_uid';");
			return pw_name_server_config::register_success;
			}
			else
			{
			//return pw_name_server_config::name_used_error;
			$result = mysql_query("INSERT INTO player_names (unique_id, name, last_used_time, inserted_by_warband_server_id) VALUES ('$player_uid', '$escaped_name', '$time' ,'$warband_server_id');");
			$updater = mysql_query("UPDATE account SET onlinestatus = '1', lastname = '$escaped_name' WHERE guid = '$player_uid';");
			return pw_name_server_config::register_success;
			}
			}
			else//2
			{
			$result = mysql_query("INSERT INTO player_names (unique_id, name, last_used_time, inserted_by_warband_server_id) VALUES ('$player_uid', '$escaped_name', '$time' ,'$warband_server_id');");
			$updater = mysql_query("UPDATE account SET onlinestatus = '1', lastname = '$escaped_name' WHERE guid = '$player_uid';");
			return pw_name_server_config::register_success;
			}
			
		}
		else//1
		{
			//定义创建新账号的字符串数据
			$zero = "0"; // 定义默认装备数值
			$zerod = "-1"; // 定义默认装备数值
			$bankgold = "5000"; // 定义默认新账户的银行存款
			$carriedgold = "700"; // 定义默认新账户的现金(不包含服务端设置)
			$chestarrayv = "0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0";
			$resultnew = mysql_query("INSERT INTO account (guid, head, body, hand, foot, horse, slot1, slot2, slot3, slot4, health, faction, troop, gold, bank, onlinestatus, lastname, Realname, water) VALUES ('$player_uid', '$zero', '$zero','$zero','$zero','$zero','$zerod','$zerod','$zerod','$zerod', 100, '$zero', 4, '$carriedgold', '$bankgold', 1, '$escaped_name', '0', '0');");
			$resultnew2 = mysql_query("INSERT INTO player_names (unique_id, name, last_used_time, inserted_by_warband_server_id) VALUES ('$player_uid', '$escaped_name', '$time' ,'$warband_server_id');");
			$resultnew3 = mysql_query("INSERT INTO chestarray (guid,item) VALUES ('$player_uid', '$chestarrayv')");
			$passport = mysql_query("INSERT INTO passport VALUES ('$player_uid', 'OverWorld'， '1','-1','$time','System')");
			$credit = mysql_query("INSERT INTO credit (guid,name,credit,date) VALUES ('$player_uid' , '$escaped_name' , '0' , '$time')");
			goto checkname3; //创建账户同时不检查游戏ID与GUID匹配，允许玩家登录游戏
		}
		}
	        }
		else
		{
		return pw_name_server_config::too_many_name;	
		}
	//  }
		}
      return pw_name_server_config::success;
	}

// 检测管理后台登陆
function warband_server_id($server_password)
{
  $result = mysql_query("SELECT id FROM warband_servers WHERE password = '$server_password';");
  if (!$result)
  {
    pw_database_error();
  }
  elseif ($row = mysql_fetch_assoc($result))
  {
    return $row["id"];
  }
  return NULL;
}

function player_get_admin_permissions($player_uid)
{
  $permissions = 0;
  $result = mysql_query("SELECT * FROM admin_permissions WHERE unique_id = '$player_uid';");
  if (!$result)
  {
    pw_database_error();
    return $permissions;
  }
  while ($row = mysql_fetch_row($result))
  {
    $bit = 0;
    $count = count($row);
    for ($i = pw_name_server_config::admin_permissions_first_field_no; $i < $count; ++$i)
    {
      if ($row[$i] != 0)
      {
        $permissions += 1 << $bit;
      }
      ++$bit;
    }
  }
  return $permissions;
}

function exit_code($code)
{
  exit("$code");
}

$server_password = filter_input(INPUT_GET, "password", FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
if (!$server_password) exit_code(pw_name_server_config::input_error);

$config = new pw_name_server_config();
if (!$config->connect_database()) exit_code(pw_name_server_config::database_error);

$server_password = mysql_real_escape_string($server_password);
$server_password = md5($server_password);
$warband_server_id = warband_server_id($server_password);
if (is_null($warband_server_id)) exit_code(pw_name_server_config::password_error);

$idd = filter_input(INPUT_GET, "id");
$id_restrictions = array("options"=>array("min_range"=>0, "max_range"=>250));
$player_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT, $id_restrictions);
if ($player_id == 0) exit_code(pw_name_server_config::success);
$id_restrictions = array("options"=>array("min_range"=>1, "max_range"=>10000000));
$player_uid = filter_input(INPUT_GET, "uid", FILTER_VALIDATE_INT, $id_restrictions);
if (is_null($player_id) || is_null($player_uid) || !filter_has_var(INPUT_GET, "name")) exit_code(pw_name_server_config::input_error);

$return_code = pw_name_server_config::name_invalid_error;
$permissions = -1;
$resultban1 = mysql_query("SELECT * FROM ban_stat WHERE GUID = '$player_uid' AND Banned = '1';");
$resultban2 = mysql_query("SELECT * FROM ban_stat WHERE GUID = '$player_uid' AND Banned = '2';");
$resultban3 = mysql_query("SELECT * FROM ban_stat WHERE GUID = '$player_uid' AND Banned = '3';");
$checkban1 = @mysql_num_rows($resultban1);
$checkban2 = @mysql_num_rows($resultban2);
$checkban3 = @mysql_num_rows($resultban3);
	if($checkban1 == 1) 
	{
			echo "-6|$player_id";
			exit;
	}else if($checkban2 == 2){
			echo "-2|$player_id";
			exit;
	}else if($checkban3 == 3){
			echo "-1|$player_id";
			exit;
	}
	else
	{
$name_restrictions = array("options"=>array("regexp"=>"/^[a-z0-9]([".pw_name_server_config::valid_separators."]?[a-z0-9])*$/i"));
$player_name = filter_input(INPUT_GET, "name", FILTER_VALIDATE_REGEXP, $name_restrictions);
if ($player_name)
{
  $escaped_name = mysql_real_escape_string($player_name);
  $return_code = player_register_name($player_uid, $escaped_name, $warband_server_id, $player_id);

  if (filter_has_var(INPUT_GET, "admin"))
  {
    $permissions = player_get_admin_permissions($player_uid);
  }
}
else
{
  $player_name = preg_replace("/\|/", "/", $_GET["name"]);
  if (!$player_name) $player_name = "NULL";
}
	}
if (is_numeric($player_name)) $player_name = "_" . $player_name;

if($return_code == "0"||"-4"||"-9") 
{
//Passt, equipment mit auslesen
//附加：
$result = mysql_query("SELECT * FROM account WHERE guid = '$player_uid';");
$anzahl = @mysql_num_rows($result);

if($anzahl > 0)
{
	for($i=0;$i<$anzahl;$i++)
	{
	$row = mysql_fetch_array($result);
		echo "$return_code|$player_id|$player_uid|$player_name|";
		echo "|";
		echo $row["head"];
		echo "|";
		echo $row["body"]; //5
		echo "|";
		echo $row["hand"];
		echo "|";
		echo $row["foot"];
		echo "|";
		echo $row["slot1"]; //8
		echo "|";
		echo $row["slot2"]; 
		echo "|";
		echo $row["slot3"]; //10
		echo "|";
		echo $row["slot4"]; //11
		echo "|";
		echo $row["health"];
		echo "|";
		echo $row["faction"]; //13
		echo "|";
		echo $row["troop"]; //14
		echo "|";
		echo $row["gold"];  //15
		echo "|";
		echo $row["bank"]; //16
		echo "|";
		echo $row["title"]; //17
		echo "|";
		//echo "$player_id";
		//echo "|";
		echo "$permissions";
		//$updater = mysql_query("UPDATE account SET lastname = '$player_name' WHERE guid = '$player_uid';");
}
}
exit;
}
echo "$return_code|$player_id|$player_uid|$player_name|$permissions";

?>