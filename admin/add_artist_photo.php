<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
	exit();
    }

  include ('template_top.php');
  include ('connect_to_database.php');	  
  include ('functions.php');  
  
$id = $_POST['id'];
$setmain = $_POST['main'];
if ($setmain == 1) $setmain = 'y';
else $setmain = 'n';

  
  function goback(){ 
   print ("<a href=\"add_album_form.php?artist=$_GET[artist]&artist1id=$_GET[artist_list]&" . 
   "label=$_GET[label]&labelid=$_GET[label_list]&title=$_GET[title]&songcount=$_GET[songcount]&" .
   "date=$_GET[date]&addedby=$_GET[addedby]&artist2=$_GET[artist2]&artist2id=$_GET[artist_list2]&" . 
   "ep=$_GET[ep]&lp=$_GET[lp]&mc=$_GET[mc]&cd=$_GET[cd]&artist3=$_GET[artist3]&artist3id=$_GET[artist_list3]" .
   "\">Popraw</a>");
   }  
 
  
  //sprawdzanie poprawnosci danych
  if ($id == '') {
    print ('<b>Wybierz jakiegos wykonawce!</b><br>');
	goback();
    include('template_bottom.php');
	exit();
	}
	
$artist_photo = $_FILES['artist_photo']['tmp_name'];
	
	
$sql = 'SELECT count(id) FROM artists_photos WHERE artistid=' . $id;
$result = mysql_query($sql);
$numphotos = mysql_fetch_array($result);
print ('w bazie jest juz ' . $numphotos[0] . ' zdjec tego wykonawcy.<BR><BR>');

$sql = 'SELECT name FROM artists WHERE id=' . $id;
$result = mysql_query($sql);
$artistname = mysql_fetch_array($result);

$numphotos = $numphotos[0];
$numphotos++;
$newfilename = $artistname[0] . '-' . $numphotos;

$toreplace = array(' ', '?', ':', '*', '|', '/', '\\', '"', '<', '>', '\'', '.', ',') ;
$newfilename = str_replace($toreplace, '-', $newfilename);

// ZMIANA POLSKICH LITEREK!
// $toreplace = array('±', 'æ', 'ê', '³', 'ñ', 'ó', '¶', '¼', '¿', '¦', '£', '¯');
// $replaceto = array('a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z', 's', 'l', 'z');  
// $newfilename = str_replace($toreplace, $replaceto, $newfilename);
  	
// $path = dirname( $_SERVER['PATH_TRANSLATED'] );
// $path = substr($path, 0, -5);

$path = '/home/hhbd/www/php/app/s.hhbd.pl/hhbdcontent/p/';
$newname = $path . $newfilename . '-hhbdpl.jpg';

$newphoto = $newfilename . '-hhbdpl.jpg';

if ($setmain) {
   $sql = 'UPDATE artists_photos SET main="n" WHERE (main="y" AND artistid="' . $id . '")';
   $result = mysql_query($sql);
}
  
// DODANIE ZDJECIA DO BAZY
$sql = 'INSERT INTO artists_photos (artistid, main, filename, description, source, sourceurl, addedby) ' .
       'VALUES (' . $id . ', "' . $setmain . '", "' . $newphoto . '", "' . $_POST['description'] . '", "' . $_POST['source'] .
	   '", "' . $_POST['sourceurl'] . '", ' . $_SESSION['userid'] . ')';
	   
//print ('<B>sql: ' . $sql . '</b><BR>');
if ($result = mysql_query($sql)) {
  // print ('newname: ' . $newname . '<br>');
  // print ('photo: ' . $artist_photo . '<br><br>');
	print ('<B>Zdjecie zostalo dodane do bazy...</b><BR>');
	if (move_uploaded_file($artist_photo,$newname)) {
		print ('skopiowano plik na serwer!<BR><BR><BR>');
		print ('<img src="http://www.hhbd.pl/' . 'imgs/database/artists/' . $newphoto . '"><BR><BR>');
		}
	else {
		print ('Nie skopiowano pliku tam gdzie trzeba...<BR><BR>');
		}
	} else {
		print ('Nie dodano zdjecia: (' . mysql_error() . ')<br>');
	}


 include('template_bottom.php');	  
?>