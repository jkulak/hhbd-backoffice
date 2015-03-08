<?php

$sqlc = mysql_connect('localhost', 'sql_hhbd', 'selekta100');

$database = 'sql_hhbd_katalog';  
mysql_select_db($database);	
	
function create_urlname($oldname, $cut40, $lower) {
	$toreplace = array(' ', '?', ':', '*', '|', '/', '\\', '"', '<', '>', '&', '!', '-', '+', '%', '^', '(', ')', '#', ';', '~', '`', '[', ']', '{', '}', ',', '=') ;
	$name = str_replace($toreplace, '_', $oldname);

	// ZMIANA POLSKICH LITEREK!
	$toreplace = array('@', '$', '±', 'æ', 'ê', '³', 'ñ', 'ó', '¶', '¼', '¿', '¦', '£', '¯', 'Ñ', 'Ê', 'Æ', '¡', 'Ó', '¬');
	$replaceto = array('a', 's', 'a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z', 'S', 'L', 'Z', 'N', 'E', 'C', 'A', 'O', 'Z');  
	$name = str_replace($toreplace, $replaceto, $name);
	
	$name = str_replace('___', '_', $name);
	$name = str_replace('__', '_', $name);
	
	$name = str_replace(array('\'', '.'), '', $name);
	
	while ($name[strlen($name) - 1] == '_') {$name = substr($name, 0, strlen($name) - 1);
		}
	
	if ($name == '') $name = '_';
	
	if ($cut40) {
		$name = substr($name, 0, 40);
		}
		
	if ($lower) {
		$name = strtolower($name);
		}
		
	return $name;
	}
	
	

$sql = 'SELECT id, title FROM songs WHERE (urlname="") LIMIT 100';
$result = mysql_query($sql);
print (mysql_error());
while ($row = mysql_fetch_array($result)) {
	//print ('Oryginalny: <strong>' . $row['title'] . '</strong><BR>');

	$newname = create_urlname($row['title'], 1, 1);
	//print ('URLNAME: <strong>' . $newname . '</strong><BR>');
	$basename = $newname;
	
	$inum = 1;		
	
	$sql = 'SELECT title, urlname FROM songs WHERE urlname="' . $newname . '"';
	$res = mysql_query($sql);
	
	while (mysql_num_rows($res)) {		
		$inum++;
		$newname = $basename . '_' . $inum;		
		$sql = 'SELECT title, urlname FROM songs WHERE urlname="' . $newname . '"';
		$res = mysql_query($sql);
		}
	
	print ('URLNAME-2: <strong>' . $newname . '</strong><BR>');
	$sql = 'UPDATE songs SET urlname="' . $newname . '" WHERE id="' . $row['id'] . '"';
	mysql_query($sql);
		
	}

?>