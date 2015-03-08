<?php
  
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
	exit();
    }

  include('template_top.php');

  include ("connect_to_database.php");	  
	   
  function goback(){ 
   print ("<a href=\"add_artist_to_band_form.php?artist1=$_GET[artist]&artist1id=$_GET[artist1id]&" . 
   "artist2=$_GET[artist2]&artist2id=$_GET[artist2id]&artist3=$_GET[artist3]&artist3id=$_GET[artist3id]&" . 
   "artist4=$_GET[artist4]&artist4id=$_GET[artist4id]&band1=$_GET[band1]&band1id=$_GET[band1id]" .
   "\">Popraw</a>");
   } 
   
  function GetArtistID($ArtistName){
    $sql = "SELECT id FROM artists WHERE name='$ArtistName'";
	$result = mysql_query($sql);
    if (!$resutl) {
	  print (mysql_error());
	  }
	$row = mysql_fetch_array($result);
	$id = $row["id"];
	return $id	;
	}
	
 
  function GetArtistName($id){
    $sql = "SELECT name FROM artists WHERE id='$id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$name = $row["name"];
	return $name;
	}	
	
	

  // wykonawca
  $artist1id = $_GET[artist1id]; 
  $artist2id = $_GET[artist2id]; 
  $artist3id = $_GET[artist3id];   
  $artist4id = $_GET[artist4id]; 
  $band1id = $_GET[band1id];
  
  if (($artist1id == "") && ($artist2id == "") && ($artist3id == "") && ($artist4id == "")) {
    if (($_GET[artist1] == "") && ($_GET[artist2] == "") && ($_GET[artist3] == "") && ($_GET[artist4] == "")) {
      print ("<b>Brak wykonawcy! Wybierz chociaz jednego!</b><br>");
	  goback();
      include('template_bottom.php');
	  exit(); 
      }
	else {
	  $artist1id = GetArtistID($_GET[artist1]);
	  $artist2id = GetArtistID($_GET[artist2]);
	  $artist3id = GetArtistID($_GET[artist3]);
	  $artist4id = GetArtistID($_GET[artist4]);
	  }
	}
	
  if ($band1id == "") {
    if ($_GET[band1] == "") {
	  printf ("<b>Brak zespolu (pseudonimu)!</b><br>");
	  goback();
	  include('template_bottom.php');
	  exit();        
    }
    else {
	  $band1id = GetArtistID($_GET[band1]);
	  }      
  }
	

 $data_dodania = date("YmdHis"); 	
  
  //jezeli tutaj doszlimy, to znaczy ze wszystkie dane w porzadku
  
  if (($artist1id == "") && ($_GET[artist1] != "")) {
    $sql = "INSERT INTO artists (name, added, addedby) VALUES ('$_GET[artist1]', '$data_dodania', '" . $_SESSION['userid'] . "')";
    $result = mysql_query($sql);
	if ($result) {
	  print ("Dodano do bazy nowego wykonawcê: '$_GET[artist1]'<BR><BR>");
      $artist1id = mysql_insert_id();
      }
	else {
      print ("Nie dodano wykonawcy: '$_GET[artist1]' (" . mysql_error() . ")<BR>");
	  }
	}
	
  if (($artist2id == "") && ($_GET[artist2] != "")) {
    $sql = "INSERT INTO artists (name, added, addedby) VALUES ('$_GET[artist2]', '$data_dodania', '" . $_SESSION['userid'] . "')";
    $result = mysql_query($sql);
	if ($result) {
	  print ("Dodano do bazy nowego wykonawcê: '$_GET[artist2]'<BR><BR>");
      $artist2id = mysql_insert_id();
      }
	else {
      print ("Nie dodano wykonawcy: '$_GET[artist2]' (" . mysql_error() . ")<BR>");
	  }
	}
	
  if (($artist3id == "") && ($_GET[artist3] != "")) {
    $sql = "INSERT INTO artists (name, added, addedby) VALUES ('$_GET[artist3]', '$data_dodania', '" . $_SESSION['userid'] . "')";
    $result = mysql_query($sql);
	if ($result) {
	  print ("Dodano do bazy nowego wykonawcê: '$_GET[artist3]'<BR><BR>");
      $artist3id = mysql_insert_id();
      }
	else {
      print ("Nie dodano wykonawcy: '$_GET[artist3]' (" . mysql_error() . ")<BR>");
	  }
	}		
	
  if (($artist4id == "") && ($_GET[artist4] != "")) {
    $sql = "INSERT INTO artists (name, added, addedby) VALUES ('$_GET[artist4]', '$data_dodania', '" . $_SESSION['userid'] . "')";
    $result = mysql_query($sql);
	if ($result) {
	  print ("Dodano do bazy nowego wykonawcê: '$_GET[artist4]'<BR><BR>");
      $artist4id = mysql_insert_id();
      }
	else {
      print ("Nie dodano wykonawcy: '$_GET[artist4]' (" . mysql_error() . ")<BR>");
	  }
	}		
	
  if (($band1id == "") && ($_GET[band1] != "")) {
    $sql = "INSERT INTO artists (name, added, addedby) VALUES ('$_GET[band1]', '$data_dodania', '" . $_SESSION['userid'] . "')";
    $result = mysql_query($sql);
	if ($result) {
	  print ("Dodano do bazy nowego wykonawcê: '$_GET[band1]'<BR><BR>");
      $band1id = mysql_insert_id();
      }
	else {
      print ("Nie dodano wykonawcy: '$_GET[band1]' (" . mysql_error() . ")<BR>");
	  }
	}		
	
  $artist1 = GetArtistName($artist1id); 
  print ("Wykonawca1: '$artist1' (ID: $artist1id)<BR>");
  $artist2 = GetArtistName($artist2id); 
  print ("Wykonawca2: '$artist2' (ID: $artist2id)<BR>");
  $artist3 = GetArtistName($artist3id); 
  print ("Wykonawca3: '$artist3' (ID: $artist3id)<BR>");
  $artist4 = GetArtistName($artist4id); 
  print ("Wykonawca4: '$artist4' (ID: $artist4id)<BR><br>");
  
  $band1 = GetArtistName($band1id); 
  print ("Jako: '$band1' (ID: $band1id)<BR>");

  

  // dodanie powiazania album - artist 1
  if ($artist1id != "") {
    $sql = "INSERT INTO band_lookup (artistid, bandid, insince, awaysince) VALUES (" .
          "'$artist1id', '$band1id', '" . $_GET["since1"] . "', '" . $_GET["till1"] . "')";
    if (mysql_query($sql)) {
        print ("Dodane powiazanie: artist1: $artist1id, bandid: $band1id<br>");		
      } else {
        echo("<P>Nie dodano powiazania!' (" . mysql_error() . ")<br>");
      }			  
	}	

  // dodanie powiazania album - artist 2
  if ($artist2id != "") {
    $sql = "INSERT INTO band_lookup (artistid, bandid, insince, awaysince) VALUES (" .
          "'$artist2id', '$band1id', '" . $_GET[since2] . "', '" . $_GET[till2] . "')";
    if (mysql_query($sql)) {
        print ("Dodane powiazanie: artist2: $artist2id, bandid: $band1id<br>");		
      } else {
        echo("<P>Nie dodano powiazania!' (" . mysql_error() . ")<br>");
      }			  
	}	
  
  // dodanie powiazania album - artist 3
  if ($artist3id != "") {
    $sql = "INSERT INTO band_lookup (artistid, bandid, insince, awaysince) VALUES (" .
          "'$artist3id', '$band1id', '" . $_GET[since3] . "', '" . $_GET[till3] . "')";
    if (mysql_query($sql)) {
        print ("Dodane powiazanie: artist3: $artist3id, bandid: $band1id<br>");		
      } else {
        echo("<P>Nie dodano powiazania!' (" . mysql_error() . ")<br>");
      }			  
	}	
	
 // dodanie powiazania album - artist 4
  if ($artist4id != "") {
    $sql = "INSERT INTO band_lookup (artistid, bandid, insince, awaysince) VALUES (" .
          "'$artist4id', '$band1id', '" . $_GET[since4] . "', '" . $_GET[till4] . "')";
    if (mysql_query($sql)) {
        print ("Dodane powiazanie: artist4: $artist4id, bandid: $band1id<br>");		
      } else {
        echo("<P>Nie dodano powiazania!' (" . mysql_error() . ")<br>");
      }			  
	}	


  
  include('template_bottom.php');	  
?>