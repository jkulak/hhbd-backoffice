<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2005 
 **/
 
include ('include/urlname-functions.php');

// **************************************************************************************************
// * FUNKCJE POBIERAJ¥CE Z BAZY                                                                     *
// **************************************************************************************************
function get_artist_id($name){
	$sql = 'SELECT id FROM artists WHERE name="' . $name . '"';
	$result = @mysql_query($sql);
	$row = @mysql_fetch_array($result);
	$id = $row['id'];
	if (!isset($id)) $id = 0;
	return $id;
	}

function get_artist_name($artistid){
	$sql = 'SELECT name FROM artists WHERE id="' . $artistid . '"';
	$result = @mysql_query($sql);
	$row = @mysql_fetch_array($result);
	$name = $row['name'];
	return $name;
	}
	
function get_label_name($labelid){
	$sql = 'SELECT name FROM labels WHERE id="' . $labelid . '"';
	$result = @mysql_query($sql);
	$row = @mysql_fetch_array($result);
	$name = $row['name'];
	return $name;
	}
	

	
// **************************************************************************************************
// * FUNKCJE DODAJ¥CE DO BAZY                                                                       *
// **************************************************************************************************
 
function add_artist($name, $addedby) {
	$urlname = create_urlname($name);
	$basename = $urlname;
	$inum = 1;		

	$sql = 'SELECT name FROM artists WHERE urlname="' . $urlname . '"';
	$res = mysql_query($sql);	
	while (mysql_num_rows($res)) {		
		$inum++;
		$urlname = $basename . '_' . $inum;		
		$sql = 'SELECT name FROM artists WHERE urlname="' . $urlname . '"';
		$res = mysql_query($sql);
		}
	$sql = 'INSERT INTO artists (name, urlname, added, addedby) VALUES ("' . $name . '", "' . $urlname . '", "' . date('YmdHis') . '", "' . $addedby . '")';
    $result = mysql_query($sql);
	$return = mysql_insert_id();
	return($return);
	}		
	
function add_artist_ex() {
	
	}
?>