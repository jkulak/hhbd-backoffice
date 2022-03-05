<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2005 
 **/
 
 
$sqlc = @mysqli_connect('localhost', 'sql_hhbd', 'selekta100');
if (!$sqlc) {
	$smarty->assign('errormsg', 'Nie mo�na po��czy� si� z baz�!');
	}

$database = 'sql_hhbd_katalog';  
if (!@mysqli_select_db($database) ) {
	$smarty->assign('errormsg', 'Nie mo�na odnale�� bazy!');
	}
 
 
$sql_query = 'SELECT id, name FROM artists ORDER BY name';
$result = mysqli_query($sql, $sql_query);

print ('<strong>LISTA WYKONAWCOW:</strong><ul class="smallindent">');
while ($row = mysqli_fetch_array($result)) {
	print ('<li><strong>' . $row['id'] . '</strong>' . ' - ' . $row['name']);
	}
print ('</ul>');
?>