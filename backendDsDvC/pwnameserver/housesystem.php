<?php
function show_houses()
{
	
	$house = "";
	$guid = "";
	$add = "";
	
  foreach ($_POST as $key => $value)
  {
	  if($key == "house") {
		  $house = $value;
	  }
	  if($key == "guid") {
		  $guid = $value;
	  }
	  if($key == "addorremove") {
		  if(strlen($key) > 0) {
			  $add = 1;
		  }
	  }
  }
	
	if(strlen($house) > 0) {
		//form got sent so apply stuff now...
		if($add == 1) {
			$result = mysql_query("SELECT * FROM house_system WHERE house_id = '$house';");
			$row = mysql_fetch_array($result);
			$key_list = $row["key_guids"];
			$key_list = $key_list . "|" . $guid . "|;";
			$result2 = mysql_query("UPDATE house_system SET key_guids = '$key_list' WHERE house_id = '$house';");
		} else {
			$result = mysql_query("SELECT * FROM house_system WHERE house_id = '$house';");
			$row = mysql_fetch_array($result);
			$key_list = $row["key_guids"];
			$key_list = str_replace("|" . $guid . "|;","",$key_list);
			$result2 = mysql_query("UPDATE house_system SET key_guids = '$key_list' WHERE house_id = '$house';");
		}
	}
	
  $result = mysql_query("SELECT * FROM house_system;");
  if (!$result) return echo_database_error();
  echo('<table class="database_view"><thead><tr><th>House ID</th><th>GUIDs with keys</th></tr></thead><tbody>');
  while ($row = mysql_fetch_assoc($result))
  {
    $keys = $row["key_guids"];
	
	$keys_done = explode(";", $keys);
	
	$houseid = $row["house_id"];
    echo "<tr><td>$houseid</td><td>";
	
		for($i=0; $i < count($keys_done); $i++)
   {
   $current_key = $keys_done[$i].""; //now remove |
   $current_key = str_replace("|","",$current_key);
   $length = strlen(utf8_decode($current_key)); 
   if($length > 0) {
	   echo $current_key;
	      echo " & ";
   }
   }
	
	echo "</td></tr>";
  }
  echo("</tbody></table>\n");
  
   $current_uri = htmlspecialchars($_SERVER["REQUEST_URI"]);
  echo "<center><br><br><b>Remove a player from a house/Add a player to a house</b>";
  echo " <br><br><form action='$current_uri' method='post'>House ID: <input type='text' name='house' value=''><br>GUID: <input type='text' name='guid' value=''><br>Add/Remove key (leave it disabled to remove): <input type='checkbox' name='addorremove' value=''></p><input type='submit' value='Update'></form>";
}
?>
