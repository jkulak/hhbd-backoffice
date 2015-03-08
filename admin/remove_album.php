<?php
  
  include ('template_top.php');
  include ('connect_to_database.php');
  include ('functions.php');	  
  
  function goback(){ 
   print ("<a href=\"remove_artist_form.php?nameid=$_GET[nameid]&removealbums=$_GET[removealbums]" .
   "\">Popraw</a>");
   }
 
  //sprawdzanie poprawnosci danych
  if ($_GET['id'] == "") {
    print ('Nie wybrales albumu do usuniecia!<br>');
	goback();
	exit;      
    }
	
  $sql = 'SELECT title FROM albums WHERE id=' . $_GET['id'];
  $result = mysql_query($sql);
  $album = mysql_fetch_array($result);	
  
  
  
  // WYSWIETLANIE DANYCH
  print ('Album do usuniecia: ' . $album[0] . '<BR>');
 
  print ('<br><br>');
  
  
   // USUWANIE Z BAZY artists
  $sql = 'DELETE FROM albums WHERE id=' . $_GET['id'];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Album: $album[0] (ID: $_GET[id]) zostal usuniety.</b>");
    }
  print ('<br>'); 		

 	
  // USUWANIE Z ZESPOLOW
  $sql = 'DELETE FROM album_lookup WHERE albumid=' . $_GET['id'];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto powiazanie dla " . mysql_affected_rows() . ' piosenek.</b>');
    }
  print ('<br>'); 	
	
  // USUWANIE CZLONKOW Z ZESPOLU
  $sql = 'DELETE FROM album_artist_lookup WHERE albumid=' . $_GET['id'];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ('<b>Usunieto ' . mysql_affected_rows() . " powiazan wykonawcow z albumem.");
    }
  print ('<br>'); 		

 	
  print ('<br><br>');  	

  print ('<a href="remove_artist_form.php?">Usun nastepnego wykonawce.</a><br>');  
  include('template_bottom.php');	  
?>