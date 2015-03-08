<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
	exit();
    }

include ('include/functions.php');
include ('functions.php');
include ('template_top.php');
include ('connect_to_database.php');
include ('include/database-functions.php');	  
  
  function goback(){ 
   print ("<a href=\"add_artist_form.php?name=$_POST[name]&website=$_POST[website]&" .
   "nameid=$_POST[nameid]&altname1=$_POST[altname1]&altname2=$_POST[altname2]&altname3=$_POST[altname3]" .
   "\">Popraw</a>");
   }

function changename($oldname) {
	$toreplace = array(' ', '?', ':', '*', '|', '/', '\\', '"', '<', '>', '&', '!', '-', '+', '%', '^', '(', ')', '#', ';', '~', '`', '[', ']', '{', '}', ',') ;
	$name = str_replace($toreplace, '_', $oldname);
	// ZMIANA POLSKICH LITEREK!
	$toreplace = array('@', '$', '±', 'æ', 'ê', '³', 'ñ', 'ó', '¶', '¼', '¿', '¦', '£', '¯', 'Ñ', 'Ê', 'Æ', '¡', 'Ó', '¬');
	$replaceto = array('a', 's', 'a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z', 'S', 'L', 'Z', 'N', 'E', 'C', 'A', 'O', 'Z');    
	$name = str_replace($toreplace, $replaceto, $name);
	$name = str_replace('___', '_', $name);
	$name = str_replace('__', '_', $name);
	$name = str_replace(array('\'', '.'), '', $name);
	if (substr($name, strlen($name) - 1, 1) == '_') { $name = substr($name, 0, strlen($name) - 1);}
	return substr($name, 0, 40);
	}



$profil = $_POST['profil'];
$concertinfo = $_POST['concertinfo'];

  //sprawdzanie poprawnosci danych
  
  
  
$name = $_POST['name'];

get_artist_id($name);
  
if ((!$name) OR (get_artist_id($name))) {
	print ("<b>Brak wykonawcy, lub wykonawca istnieje w bazie!</b><br>");
	goback();
	include('template_bottom.php');
	exit(); 
	}

$cityid = $_POST['cityid'];

$data_dodania = date('YmdHis');

$addtype = $_POST['nametype'];
  
//jezeli tutaj doszlimy, to znaczy ze wszystkie dane w porzadku
  
  

  

  print ("Wykonawca: $name<BR>");
  if ($_POST[altname1] != "") {
    print ("znany tez jako: $_POST[altname1]<BR>");      
    }
  if ($_POST[altname2] != "") {
    print ("znany tez jako: $_POST[altname2]<BR>");      
    }
  if ($_POST[altname3] != "") {
    print ("znany tez jako: $_POST[altname3]<BR>");      
    }
	
	
  print ("Website: $_POST[website]<BR>");
  print ("Imie i nazwisko: $_POST[realname]<BR>");
  

  
 $newname = create_urlname($_POST['name'], 1, 1);
	$basename = $newname;
	$inum = 1;		
	$sql = 'SELECT name, urlname FROM artists WHERE urlname="' . $newname . '"';
	$res = mysql_query($sql);
	while (mysql_num_rows($res)) {		
		$inum++;
		$newname = $basename . '_' . $inum;		
		$sql = 'SELECT name, urlname FROM artists WHERE urlname="' . $newname . '"';
		$res = mysql_query($sql);
		}	
      
  $sql = "INSERT INTO artists (website, name, urlname, realname, since, till, type, added, addedby, profile, concertinfo) " .
	"VALUES ('$_POST[website]', '$name', '$newname', '$_POST[realname]', '$_POST[date]', '$_POST[till]', '$addtype', '$data_dodania', '" . $_SESSION['userid'] . "'" . ',"' . $profil . '","' . $concertinfo . '")';			 
      if (mysql_query($sql)) {
	    $nameid = mysql_insert_id();
        print ("<BR><BR><B>Wykonawca '$_POST[name]' zostal dodany, ID: $nameid </B><br><br>");		
      } else {
        echo("<P>Nie dodano wykonawcy '$_POST[name]' (" . mysql_error() . ")<br>");
      }

    
  // dodanie pierwszego nicku
  if ($_POST[altname1] != "") {
    $sql = "INSERT INTO altnames_lookup (artistid, altname) " .
      "VALUES ('$nameid', '$_POST[altname1]')";
	
	if (mysql_query($sql)) {
	  $insertID = mysql_insert_id();
      print ("Dodano ksywe '$_POST[altname1]' dla wykonawcy: " . GetArtistName($nameid) . "<br>");		
      }
	else {
      echo("<P>Nie dodano ksywy '$_POST[altname1]' (" . mysql_error() . ")<br>");
	  }
	}

  // dodanie drugiego nicku
  if ($_POST[altname2] != "") {
    $sql = "INSERT INTO altnames_lookup (artistid, altname) " .
      "VALUES ('$nameid', '$_POST[altname2]')";
	
	if (mysql_query($sql)) {
	  $insertID = mysql_insert_id();
      print ("Dodano ksywe '$_POST[altname2]' dla wykonawcy: " . GetArtistName($nameid) . "<br>");		
      }
	else {
      echo("<P>Nie dodano ksywy '$_POST[altname2]' (" . mysql_error() . ")<br>");
	  }
	}  	
	
  // dodanie trzeciego nicku
  if ($_POST[altname3] != "") {
    $sql = "INSERT INTO altnames_lookup (artistid, altname) " .
      "VALUES ('$nameid', '$_POST[altname3]')";
	
	if (mysql_query($sql)) {
	  $insertID = mysql_insert_id();
      print ("Dodano ksywe '$_POST[altname3]' dla wykonawcy: " . GetArtistName($nameid) . "<br>");		
      }
	else {
      echo("<P>Nie dodano ksywy '$_POST[altname3]' (" . mysql_error() . ")<br>");
	  }
	}  	


// *****************
// dodawanie nowego miasta do bazy miast
// *****************
  if ($cityid == -1) {
    $sql = "INSERT INTO cities (name, added, addedby) " .
      "VALUES ('$_POST[city]', '$data_dodania', '" . $_SESSION['userid'] . "')";
	
	if (mysql_query($sql)) {
	  $cityid = mysql_insert_id();
      print ("Dodano miasto '$_POST[city]' do bazy miast!<br>");		
      }
	else {
      echo("<P>Nie dodano miasta: '$_POST[city]'! (" . mysql_error() . ")<br>");
	  }
	}
	
	
  if ($cityid != '') {
    $sql = "INSERT INTO city_artist_lookup (cityid, artistid) " .
      "VALUES ('$cityid', '$nameid')";
	
	if (mysql_query($sql)) {
	  $insertID = mysql_insert_id();
      print ('Dodano miasto \'' . GetCityName($cityid) . '\'dla wykonawcy: ' . GetArtistName($nameid) . '<br>');		
      }
	else {
      echo('<P>Nie dodano miasta \'' . GetCityName($cityid) . '\' (' . mysql_error() . ')<br>');
	  }
	}  		

		  
  print ("<a href=\"add_artist_form.php?\">Dodaj nastêpnego wykonawcê.</a><br>");
  
  include('template_bottom.php');	  
?>