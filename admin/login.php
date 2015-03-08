<?php

session_start();

if (isset($_SESSION['username'])) {
    header("Location: main.php");
	exit();
    }

  include ('connect_to_database.php');

if(($_POST['login'] == "") OR ($_POST['password']) == "") {
  header("Location: index.php?er=1");
  exit;
  }

$sql = "SELECT id, login, name, added, timesloggedin, lastlogin FROM users WHERE (login='" . $_POST['login'] . "' AND pass=('" . md5($_POST['password']) . "'))";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$num = mysql_num_rows($result);

if($num == 1) {

  $timeslogedin = $row['timesloggedin'];

  $_SESSION['username'] = $row['login'];
  $_SESSION['userid'] = $row['id'];
  $_SESSION['lastlogin'] = $row['lastlogin'];
  $_SESSION['timesloggedin'] = $timesloggedin;

  $data_logowania = date("YmdHis");
  $timeslogedin ++ ;

  $sql = "UPDATE users SET lastlogin=$data_logowania, timesloggedin=$timesloggedin WHERE id=$row[id]";
  $result = mysql_query($sql);
  header("Location: main.php");
  exit();
  }
else if($num == 0) {
  header("Location: index.php?er=2");
  exit;
  }
?>
