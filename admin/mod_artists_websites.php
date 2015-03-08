<?php

include ('connect_to_database.php');

$id = $_GET['id'];
$action = $_GET['action'];

if ($action == 'accept') {
    $status = 1;
	}
else if ($action == 'reject') {
    $status = 9;
	}
else header ( 'Location: admin.php?s=urlhack');



$sql = 'UPDATE artists_websites SET status="' . $status . '" WHERE id="' . $id . '"';
$result = mysql_query($sql);

header ( 'Location: index.php');


	
?>