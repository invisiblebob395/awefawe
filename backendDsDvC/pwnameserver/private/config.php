<?php
#Only change server_name, username and password
class pw_name_server_config
{
  const database_server_name = "rm-bp11289rskm2aqj18no.mysql.rds.aliyuncs.com";
  const database_username = "cedr14x";
  const database_password = "2BlJgeZX\$mWJpcG9AcSapG2&XYZ@2F";
  const database_name = "mb_x";
  const max_names_per_player = 1;#玩家最大游戏ID数
  const admin_permissions_first_field_no = 3;
  const valid_separators = "-_ '";
  const player_names_per_page = 100;

  const password_error = -3;
  const database_error = -2;
  const input_error = -1; 
  const success = 0;
  const name_used_error = 1;
  const clan_tag_error = 2; #armor
  const name_invalid_error = 3;
  const register_success = -4;
  const not_registered_erro = -5;
  const wrong_key = -7;
  const too_many_name = -8;
  const change_success = -9;

  public $connection;

  function connect_database()
  {
    $this->connection = mysql_connect(self::database_server_name, self::database_username, self::database_password);
    return ($this->connection && mysql_select_db(self::database_name, $this->connection));
  }

  function __destruct()
  {
    if ($this->connection) @mysql_close($this->connection);
  }
}

function pw_database_error()
{
  error_log("PW database error: " . mysql_error());
  return pw_name_server_config::database_error;
}

function echo_database_error()
{
  echo('<div class="database_error">Database error: '.mysql_error().'</div>');
  return;
}
?>
