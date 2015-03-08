<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2005 
 **/
 
 
$sqlc = @mysql_connect('localhost', 'sql_hhbd', 'selekta100');
if (!$sqlc) {
	$smarty->assign('errormsg', 'Nie mo¿na po³±czyæ siê z baz±!');
	}

$database = 'sql_hhbd_katalog';  
if (!@mysql_select_db($database) ) {
	$smarty->assign('errormsg', 'Nie mo¿na odnale¼æ bazy!');
	}
 
 
$sql = 'SELECT id, name FROM artists ORDER BY name';
$result = mysql_query($sql);

print ('<strong>LISTA WYKONAWCOW:</strong><ul class="smallindent">');
while ($row = mysql_fetch_array($result)) {
	print ('<li><strong>' . $row['id'] . '</strong>' . ' - ' . $row['name']);
	}
print ('</ul>');
?>