<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
	exit();
    }

  include ('template_top.php');
  include ('connect_to_database.php');	  
  include ('functions.php');  
   

$name = $_POST['name'];
$website = $_POST['website'];
$enable = $_POST['enable'];
if ($enable != 'y') $enable = 'n';
$added = date('Y-m-d H:i:s');
$addedby = $_SESSION['userid'];

print ('nazwa: ' . $name . '<BR>');
print ('strona: ' . $website . '<BR>');
print ('enabled: ' . $enable . '<BR>');
print ('dodany: ' . $added . '<BR>');
print ('dodany przez: ' . $addedby . '<BR>');
	
$sql = 'INSERT INTO eshops (name, website, display, added, addedby) ' .
		'VALUES ("' . $name . '", "' . $website . '", "' . $enable . '", "' . $added . '", "' . $addedby . '")';
if (mysql_query($sql)) {
	print ("<BR><BR><B>Skle dodany!</B><br><br>");		
	}
else {
	echo("<P>Nie dodano ceny  bo:  ' (" . mysql_error() . ")<br>");
	}
include('template_bottom.php');	  
?>