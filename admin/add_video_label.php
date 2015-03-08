<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
	exit();
    }

include ('functions.php');
include ('template_top.php');
include ('connect_to_database.php');	  
  
  function goback(){ 
   print ("<a href=\"add_video_label_form.php?name=$_GET[name]&website=$_GET[website]&addedby=$_GET[addedby]" .
   "\">Popraw</a>");
   }   
 
  //sprawdzanie poprawnosci danych
  if ($_GET[name] == "") {
    print ("<b>Brak nazwy wytwórni video!</b><br>");
	goback();
    include('template_bottom.php');
	exit();
	}
	

  if ($_GET[website] == "") {
    print ("<b>Brak adresu http!</b><br>");
	goback();
    include('template_bottom.php');
	exit();
	}
	
$cityid = $_GET['cityid'];
  if ($cityid == '') {
    if ($_GET['city'] != '') {
      $cityid = GetCityID($_GET['city']);
      }  
    } // mamy albo '' - co znaczy, ze nie ma w ogole miasta, albo -1 jezeli dodac trzeba.
  	
	
  
    $data_dodania = date("YmdHis");  	
  
  //jezeli tutaj doszlimy, to znaczy ze wszystkie dane w porzadku

  print ("Wytwórnia: $_GET[name]<BR>");
  print ("Website: $_GET[website]<BR>");
  
  $sql = "INSERT INTO video_labels (name, website, email, addres, added, addedby) " .
	"VALUES ('$_GET[name]', '$_GET[website]', '$_GET[email]', '$_GET[addres]', '$data_dodania', '$_GET[addedby]')";
			 
      if (mysql_query($sql)) {
	    $insertID = mysql_insert_id();
        print ("<BR><BR><B>Wytwórnia '$_GET[name]' zostala dodana, ID: $insertID </B><br><br>");		
      } else {
        echo("<P>Nie dodano wytwórni '$_GET[name]' (" . mysql_error() . ")<br>");
      }
	  
// *****************
// dodawanie nowego miasta do bazy miast
// *****************
  if ($cityid == -1) {
    $sql = "INSERT INTO cities (name, added, addedby) " .
      "VALUES ('$_GET[city]', '$data_dodania', '" . $_SESSION['userid'] . "')";
	
	if (mysql_query($sql)) {
	  $cityinsertid = mysql_insert_id();
      print ("Dodano miasto '$_GET[city]' do bazy miast!<br>");		
      }
	else {
      echo("<P>Nie dodano miasta: '$_GET[city]'! (" . mysql_error() . ")<br>");
	  }
	}
	
	
  if ($cityinsertid != 0) {
    $sql = "INSERT INTO city_video_label_lookup (cityid, videolabelid) " .
      "VALUES ('$cityinsertid', '$nameid')";
	
	if (mysql_query($sql)) {
	  $insertID = mysql_insert_id();
      print ("Dodano miasto $cityinsertid dla wytworni video: " . GetArtistName($nameid) . "<br>");		
      }
	else {
      echo("<P>Nie dodano miasta $cityinsertid (" . mysql_error() . ")<br>");
	  }
	} 	  
	
		  
  print ("<a href=\"add_video_label_form.php?addedby=$_GET[addedby]\">Dodaj nastêpn¹ wytwórniê VIDEO.</a><br>");
  
  include('template_bottom.php');	  
?>