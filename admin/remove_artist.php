<?php
  
  include ('template_top.php');
  include ('connect_to_database.php');
  include ('functions.php');	  
  
  function goback(){ 
   print ("<a href=\"remove_artist_form.php?nameid=$_GET[nameid]&removealbums=$_GET[removealbums]" .
   "\">Popraw</a>");
   }
 
  //sprawdzanie poprawnosci danych
  if ($_GET[nameid] == "") {
    print ('Nie wybrales wykonawcy do usuniecia!<br>');
	goback();
	exit;      
    }
  
  
  
  // WYSWIETLANIE DANYCH
  print ('Wykonawca do usuniecia: ' . GetArtistName($_GET[nameid]) . '<BR>');
  if ($_GET[removealbums] == 1) {
      
  }
  print ('Usunac albumy wykonawcy: ' . ($_GET['removealbums'] == '1' ? 'Tak' : 'Nie'));
  print ('<br><br>');
  
  
  $artistname = GetArtistName($_GET[nameid]);

  // USUWANIE Z BAZY artists
  $sql = 'DELETE FROM artists WHERE id=' . $_GET[nameid];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Wykonawca: $artistname (ID: $_GET[nameid]) zostal usuniety.</b>");
    }
  print ('<br>'); 		

  // USUWANIE NICKOW
  $sql = 'DELETE FROM altnames_lookup WHERE artistid=' . $_GET[nameid];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ('<b>Usunieto ' . mysql_affected_rows() . " alternatywne nazwy dla: $artistname (ID: $_GET[nameid])</b>");
    }
  print ('<br>'); 		
	
  // USUWANIE Z ZESPOLOW
  $sql = 'DELETE FROM band_lookup WHERE artistid=' . $_GET[nameid];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto wykonawce: $artistname (ID: $_GET[nameid]) z " . mysql_affected_rows() . ' zespolow.</b>');
    }
  print ('<br>'); 	
	
  // USUWANIE CZLONKOW Z ZESPOLU
  $sql = 'DELETE FROM band_lookup WHERE bandid=' . $_GET[nameid];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ('<b>Usunieto ' . mysql_affected_rows() . " wykonawcow z zespolu: $artistname (ID: $_GET[nameid])</b>");
    }
  print ('<br>'); 		
	
  // USUWANIE Z LISTY REMIXOWCOW
  $sql = 'DELETE FROM remix_lookup WHERE artistid=' . $_GET[nameid];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto wykonawce: $artistname (ID: $_GET[nameid]) z " . mysql_affected_rows() . ' remixow.</b>');
    }
  print ('<br>'); 			
	
  if ($_GET[removealbums]) {
    $sql = 'SELECT albumid FROM album_artist_lookup WHERE artistid=' . $_GET[nameid];
    $result = mysql_query($sql);
    while ( $row = mysql_fetch_array($result) ) { 
      $ids = $ids . $row[albumid] . ',';
	  }
    $ids = substr($ids, 0, strlen($ids) - 1);
  
    $sql = "DELETE FROM albums WHERE id IN ($ids)";
	$result = mysql_query($sql);
	if (!$result) {
      print (mysql_error());
	  }
    else {
      print ('<b>Usunieto: ' . mysql_affected_rows() . " albumow autorstwa wykonawcy: $artistname .</b>");
      }	
    print ('<br>'); 
	}

	


  // USUWANIE Z LISTY ALBUMOW
  $sql = 'DELETE FROM album_artist_lookup WHERE artistid=' . $_GET[nameid];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto wykonawce: $artistname (ID: $_GET[nameid]) z " . mysql_affected_rows() . ' albumow.</b>');
    }
  print ('<br>'); 		
	
  // USUWANIE Z LISTY SKRECZOW
  $sql = 'DELETE FROM scratch_lookup WHERE artistid=' . $_GET[nameid];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto wykonawce: $artistname (ID: $_GET[nameid]) z " . mysql_affected_rows() . ' skreczow.</b>');
    }
  print ('<br>'); 	
	
  // USUWANIE Z LISTY MUZYKI
  $sql = 'DELETE FROM music_lookup WHERE artistid=' . $_GET[nameid];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto wykonawce: $artistname (ID: $_GET[nameid]) jako autora muzyki w " . mysql_affected_rows() . ' utworach.</b>');
    }
  print ('<br>'); 		
	
  // USUWANIE Z LISTY WOKALISTOW
  $sql = 'DELETE FROM artist_lookup WHERE artistid=' . $_GET[nameid];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto wykonawce: $artistname (ID: $_GET[nameid]) jako wokaliste w " . mysql_affected_rows() . ' utworach.</b>');
    }
  print ('<br>'); 			
	
  // USUWANIE Z LISTY FEATURINGOW
  $sql = 'DELETE FROM feature_lookup WHERE artistid=' . $_GET[nameid];
  $result = mysql_query($sql);
  if (!$result) {
    print (mysql_error());
	}
  else {
    print ("<b>Usunieto wykonawce: $artistname (ID: $_GET[nameid]) z " . mysql_affected_rows() . ' featuringow.</b>');
    }
  print ('<br>'); 	
 	
  print ('<br><br>');  	

  print ('<a href="remove_artist_form.php?">Usun nastepnego wykonawce.</a><br>');  
  include('template_bottom.php');	  
?>