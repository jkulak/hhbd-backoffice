<?php

// Read configuration file
$config = parse_ini_file('../config/db.ini');

// Connect to the database server
  $sql = mysql_connect($config['host'] . (isset($config['port'])?':'.$config['port']:''), $config['user'], $config['pass']);
    if (!$sql) {
    print ("Nie mozna sie polaczyc z baza: " . mysql_error() . "<br>");
      exit();
      }

  mysql_set_charset('utf8');
  $db_name = $config['database'];

  if (! @mysql_select_db($db_name) ) {
      print ("Nie mozna odnalezc bazy: $db_name (" . mysql_error() . ")<br>");
      exit();
    }

?>
