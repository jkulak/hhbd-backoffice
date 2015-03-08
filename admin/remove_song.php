<?php
  
  include ('template_top.php');
  include ('connect_to_database.php');
  include ('functions.php');	  
  
  function goback(){ 
   print ("<a href=\"remove_song_form.php?nameid=$_GET[id]" .
   "\">Popraw</a>");
   }
 
  //sprawdzanie poprawnosci danych
  if ($_GET['id'] == "") {
    print ('Nie wybrales utworu do usuniecia!<br>');
	goback();
	exit;      
    }
	
  $sql = 'SELECT title FROM songs WHERE id=' . $_GET['id'];
  $result = mysql_query($sql);
  $album = mysql_fetch_array($result);	
  
  
  
  // WYSWIETLANIE DANYCH
  print ('Utwor do usuniecia: ' . $album[0] . '<BR>');
 
  print ('<br><br>');
  
  
   // USUWANIE Z BAZY artists
  $sql = 'DELETE FROM songs WHERE id=' . $_GET['id'];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Utwor: $album[0] (ID: $_GET[id]) zostal usuniety.</b>");
    }
  print ('<br>'); 		

 	
  // USUWANIE Z albumow
  $sql = 'DELETE FROM album_lookup WHERE songid=' . $_GET['id'];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto powiazanie dla " . mysql_affected_rows() . ' albumow.</b>');
    }
  print ('<br>'); 	
  
  // USUWANIE Z feat
  $sql = 'DELETE FROM feature_lookup WHERE songid=' . $_GET['id'];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto powiazanie dla " . mysql_affected_rows() . ' featuringow.</b>');
    }
  print ('<br>'); 	 
  
  // USUWANIE Z msuic
  $sql = 'DELETE FROM music_lookup WHERE songid=' . $_GET['id'];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto powiazanie dla " . mysql_affected_rows() . ' music.</b>');
    }
  print ('<br>'); 	  
  
  // USUWANIE Z scratch
  $sql = 'DELETE FROM scratch_lookup WHERE songid=' . $_GET['id'];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto powiazanie dla " . mysql_affected_rows() . ' scratch.</b>');
    }
  print ('<br>'); 	    
  
  // USUWANIE Z artist
  $sql = 'DELETE FROM artist_lookup WHERE songid=' . $_GET['id'];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto powiazanie dla " . mysql_affected_rows() . ' artist.</b>');
    }
  print ('<br>'); 	  
  
  // USUWANIE Z remix
  $sql = 'DELETE FROM remix_lookup WHERE songid=' . $_GET['id'];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto powiazanie dla " . mysql_affected_rows() . ' remix.</b>');
    }
  print ('<br>'); 	  
  
  // USUWANIE Z scratch
  $sql = 'DELETE FROM video_lookup WHERE songid=' . $_GET['id'];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto powiazanie dla " . mysql_affected_rows() . ' video.</b>');
    }
  print ('<br>'); 	  
	
  

 	
  print ('<br><br>');  	

  print ('<a href="remove_artist_form.php?">Usun nastepnego wykonawce.</a><br>');  
  include('template_bottom.php');	  
?>