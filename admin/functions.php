<?php

  function GetArtistID($artistname){
    $sql = "SELECT id FROM artists WHERE name='$artistname'";
	$result = mysql_query($sql);
    if (!$resutl) {
	  print (mysql_error());
	  }
	$row = mysql_fetch_array($result);
	$id = $row["id"];
	if ($id == "") {
	  $id = -1;
	  }
	return $id	;
	}
	
  function GetLabelID($labelname){
    $sql = "SELECT id FROM labels WHERE name='$labelname'";
	$result = mysql_query($sql);
	if (!$resutl) {
	  print (mysql_error());
	  }
	$row = mysql_fetch_array($result);
	$id = $row["id"];
	if ($id == "") {
	  $id = -1;
	  }
	return $id	;
	}


  function GetFeattypeID($artistname){
    $sql = "SELECT id FROM feattypes WHERE feattype='$artistname'";
	$result = mysql_query($sql);
    if (!$resutl) {
	  print (mysql_error());
	  }
	$row = mysql_fetch_array($result);
	$id = $row["id"];
	if ($id == "") {
	  $id = -1;
	  }
	return $id	;
	}


	
		
  function GetArtistName($id){
    $sql = "SELECT name FROM artists WHERE id='$id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$name = $row["name"];
	return $name;
	}	
	
  function GetLabelName($id){
    $sql = "SELECT name FROM labels WHERE id='$id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$name = $row["name"];
	return $name;
	}	

  function GetCityName($id){
    $sql = "SELECT name FROM cities WHERE id='$id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$name = $row["name"];
	return $name;
	}	
	
  function GetCityID($cityname){
    $sql = "SELECT id FROM cities WHERE name='$cityname'";
	$result = mysql_query($sql);
    if (!$resutl) {
	  print (mysql_error());
	  }
	$row = mysql_fetch_array($result);
	$id = $row["id"];
	if ($id == "") {
	  $id = -1;
	  }
	return $id	;
	}	// zwraca -1 jezeli nie ma takiego miasta w bazie lub id jezeli znalazl;		


?>