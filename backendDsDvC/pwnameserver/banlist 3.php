<?php
function show_banlist()
{
	
	
  foreach ($_POST as $key => $value)
  {
	  //Key ist die GUID
	$eintrag = "DELETE FROM banlist WHERE GUID='$key'"; 
	$eintragen = mysql_query($eintrag);
	
	$query5 = "UPDATE account SET banned = '0' WHERE guid = '$key'";
	$result5 = mysql_query($query5);
	
	echo "<center><b>Unbanned $key</b></center><br>";
  }
	
	

  $current_uri_no_start = htmlspecialchars(preg_replace('/&start=[^=&]*/', '', $_SERVER["REQUEST_URI"]));
  echo("<form action=\"$current_uri_no_start\" method=\"post\"><div class=\"database_actions\">");

echo '<table class="database_view"><thead><tr><th>Action</th><th>GUID</th><th>Playername</th><th>Reason</th><th>Unban at</th><th>Admin</th></tr></thead><tbody>';

$result = mysql_query("SELECT * FROM banlist;");
$anzahl = @mysql_num_rows($result);

if($anzahl > 0)
{
	for($i=0;$i<$anzahl;$i++)
	{
	$row = mysql_fetch_array($result);
											  echo "<br><tr>";
											  $guid = $row['GUID'];
											  $name = $row["Playername"];
											  $reason = $row["Reason"];
											  $unban = $row["Unbanat"];
											  if($unban == "-") {
											  $unban = "Permanently";
											  }
											  $admin = $row["Admin"];
											  echo "<td><input type='submit' name='$guid' value='Unban'></td>";
											  echo "<td>$guid</td>";
											  echo "<td>$name</td>";
											  echo "<td>$reason</td>";
											  echo "<td>$unban</td>";
											  echo "<td class='cell align-right'>$admin</td>";
											  echo "</tr>";
}
}
}
?>
