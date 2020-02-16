<?php
function show_addban()
{
	
	$guid = "";
	$playername = "";
	$amount = "";
	$reason = "";
	$unbandate ="";
	
  foreach ($_POST as $key => $value)
  {
	if($key == "guid") {
		$guid = $value;
	}
		if($key == "playername") {
		$playername = $value;
	}
		if($key == "amount") {
		$amount = $value;
		$date = date('Y-m-d');
$days = $amount + "1";
$unbandate = date('Y-m-d', strtotime($date. ' + '.$days.' days'));
	}
		if($key == "reason") {
		$reason = $value;
	}
	
  }
  
  if(strlen($guid) > 0) {
  	$query3 = "INSERT INTO banlist (GUID, Playername, Reason, Unbanat, Admin) VALUES ('$guid', '$playername', '$reason', '$unbandate', 'System');";
$result3 = mysql_query($query3); 

$query5 = "UPDATE account SET banned = '1' WHERE guid = '$guid'";
$result5 = mysql_query($query5);

echo "<center>Banned <b>$guid</b>!</center><br>";
}
  
  
	$current_uri = htmlspecialchars($_SERVER["REQUEST_URI"]);
  echo "<center><br><br><form action='$current_uri' method='post'>
  GUID: <input type='text' name='guid' value=''>
  <br>Playername: <input type='text' name='playername' value=''>
  <br>Amount of days: <input type='text' name='amount' value=''>
  <br>Reason: <input type='text' name='reason' value=''></p><input type='submit' value='Add ban'></form>";
}
?>
