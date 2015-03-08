<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
	exit();
    }

include ('functions.php');
include ('template_top.php');
include ('connect_to_database.php');	
include ('include/database-functions.php');  
  

function nl2p($text) {
  return "<p>" . str_replace("\n", "</p>\n<p>", $text) . "</p>";
}




  function goback(){ 
   print ("<a href=\"add_artist_form.php?name=$_POST[name]&website=$_POST[website]&" .
   "nameid=$_POST[nameid]&altname1=$_POST[altname1]&altname2=$_POST[altname2]&altname3=$_POST[altname3]" .
   "\">Popraw</a>");
   }
$profil = nl2p(mysql_escape_string($_POST['profil']));

// die($_POST['profil']);

$concertinfo = $_POST['concertinfo'];
 
  //sprawdzanie poprawnosci danych

$name = $_POST['name'];

$oldid = $_POST['id'];
$newid = get_artist_id($name);


if ((!$name) OR ($newid)) {
	if ($oldid<>$newid) {
		print ("<b>Brak wykonawcy, lub wykonawca istnieje w bazie!</b><br>");
		goback();
		include('template_bottom.php');
		exit(); 
		}
	}
	
	
 $cityid = $_POST['cityid'];
 printf ("cityid = $cityid<br>") ;
  if ($cityid == "") {
    if ($_POST[city] == "") {
      print ("<b>Miasto nie wpisane!</b><br>");
      }
	else {
	  $cityid = GetCityid($_POST['city']);
	  }
	}
	
 printf ("cityid = $cityid<br>") ;	
  
  //band
   if ($_POST['band'] == 1) {
     $band = 1;
	 }
   else {
     $band = 0;
	 }  
  
  $data_dodania = date("YmdHis"); 	
  
  //jezeli tutaj doszlimy, to znaczy ze wszystkie dane w porzadku

  print ("Wykonawca: $_POST[name]<BR>");
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
  
      
  $sql = "UPDATE artists SET website='$_POST[website]', name='$_POST[name]', realname='$_POST[realname]', since='$_POST[date]', " .
         "till='$_POST[till]', type='$_POST[nametype]', updated='$data_dodania', updatedby='$_SESSION[userid]', profile='$profil', concertinfo='$concertinfo' " .
		 "WHERE id=$_POST[id]";
		 
		 

      if (mysql_query($sql)) {
	    $nameid = $_POST['id'];
        print ("<BR><BR><B>Wykonawca '$_POST[name]' zostal aktualizowany, id: $nameid </B><br><br>");		
      } else {
        echo("<P>Nie aktualizowano wykonawcy '$_POST[name]' (" . mysql_error() . ")<br>");
      }

	  

	
	  
// kasowanie wszystkich ksywek
  $sql = "DELETE FROM altnames_lookup WHERE artistid=$_POST[id]";
  mysql_query($sql);	
	
    
  // dodanie pierwszego nicku
  if ($_POST['altname1'] != "") {
    $sql = "INSERT INTO altnames_lookup (artistid, altname) " .
      "VALUES ('$nameid', '$_POST[altname1]')";
	
	if (mysql_query($sql)) {
	  $insertid = mysql_insert_id();
      print ("Dodano ksywe '$_POST[altname1]' dla wykonawcy: " . GetArtistName($nameid) . "<br>");		
      }
	else {
      echo("<P>Nie dodano ksywy '$_POST[altname1]' (" . mysql_error() . ")<br>");
	  }
	}

  // dodanie drugiego nicku
  if ($_POST['altname2'] != "") {
    $sql = "INSERT INTO altnames_lookup (artistid, altname) " .
      "VALUES ('$nameid', '$_POST[altname2]')";
	
	if (mysql_query($sql)) {
	  $insertid = mysql_insert_id();
      print ("Dodano ksywe '$_POST[altname2]' dla wykonawcy: " . GetArtistName($nameid) . "<br>");		
      }
	else {
      echo("<P>Nie dodano ksywy '$_POST[altname2]' (" . mysql_error() . ")<br>");
	  }
	}  	
	
  // dodanie trzeciego nicku
  if ($_POST['altname3'] != "") {
    $sql = "INSERT INTO altnames_lookup (artistid, altname) " .
      "VALUES ('$nameid', '$_POST[altname3]')";
	
	if (mysql_query($sql)) {
	  $insertid = mysql_insert_id();
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
	
// WYKASOWANIE DOTYCHCZASOWYCH POWIAZAN WYKONAWCOW I MIAST
$sql = 'DELETE FROM artist_city_lookup WHERE (artistid=' . $_POST['id'] . ')';
$result = mysql_query($sql);
	

// kasowanie miast z powiazan z wykonawca
  $sql = "DELETE FROM artist_city_lookup WHERE artistid=$_POST[id]";
  mysql_query($sql);

  if ($cityid != '') {
    $sql = "INSERT INTO city_artist_lookup (cityid, artistid) " .
      "VALUES ('$cityid', '$nameid')";
	
	if (mysql_query($sql)) {
      print ('Dodano miasto \'' . GetCityName($cityid) . '\' dla wykonawcy: ' . GetArtistName($nameid) . '<br>');		
      }
	else {
      echo("<P>Nie dodano miasta $cityid (" . mysql_error() . ")<br>");
	  }
	}  		
 
  include('template_bottom.php');	  
?>