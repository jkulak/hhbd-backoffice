<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
	exit();
    }
include ('connect_to_database.php');	


include ('template_top.php');
echo '<h2>Dodaj okładkę</h2>';


function createthumbnail($dstfilename, $srcfilename, $dstsize, $srcsize, $frmcolor){
	$image_p = imagecreatetruecolor($dstsize, $dstsize);
	imagefilledrectangle($image_p, 0, 0, $dstsize, $dstsize, $frmcolor);
	$image = imagecreatefromjpeg($srcfilename);
	list($width, $height) = getimagesize($srcfilename);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $dstsize, $dstsize, $width, $height);
	imagejpeg($image_p, $dstfilename);
	}

$id = $_POST['albumid'];
$filename = $_FILES['coverfile']['tmp_name'];
$sql = 'SELECT title, year, singiel FROM albums WHERE id=' . $id;
$result = mysql_query($sql);
$album = mysql_fetch_array($result);
  
$sql = 'SELECT t1.name FROM artists AS t1, album_artist_lookup AS t2 WHERE (t1.id=t2.artistid AND t2.albumid=' . $id . ')';
$result = mysql_query($sql);
$artist = mysql_fetch_array($result);  
  

$newfilename = strtolower(trim($artist[0]) . '-' . trim($album[0]));
$toreplace = array(' ', '?', ':', '*', '|', '/', '\\', '"', '<', '>', '\'', '.', ',', '%', '@', '#') ;
$newfilename = str_replace($toreplace, '-', $newfilename);

// print_r($newfilename);

// 2010-12-14 stara zmiana literek, wyłączona, bo nie jest potrzebna, i tak jest błędne kodowanie
// ZMIANA POLSKICH LITEREK!
// $toreplace = array('±', 'æ', 'ê', '³', 'ñ', 'ó', '¶', '¼', '¿', '¦', '£', '¯');
// $replaceto = array('a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z', 's', 'l', 'z');  
// $newfilename = str_replace($toreplace, $replaceto, $newfilename);

// $path = '/home/hhbd/domains/hhbd.pl/public_html/';
$path = '/home/hhbd/www/php/app/s.hhbd.pl/hhbdcontent/a/';
$newname = $path . $newfilename . '-hhbdpl.jpg';
$thumb75 = $path . 'th/' . $newfilename . '-hhbdpl-th.jpg';

$newcover = $newfilename . '-hhbdpl.jpg';
  
// DODANIE NAZWY OKLADKI DO TABELI ALBUMÓW
$sql = 'UPDATE albums SET cover="' . $newcover . '" WHERE id=' . $id;

if (mysql_query($sql))
	{
    $albumid = mysql_insert_id();
	  if ( move_uploaded_file($filename, $newname) )
	  {
   		chmod($newname, 0644);
			createthumbnail($thumb75, $newname, 75, 250, 0);
			chmod($thumb75, 0644);
			echo '<div class="message good">Okładka dodana, i powinieneś widzieć ją niżej :)</div>';
			echo '<img src="http://www.hhbd.pl/imgs/database/albums/' . $newcover . '">';
		}
		else
		{
		  echo '<div class="message bad">Wygląda na to, że nie udało się skopiować pliku tam gdzie planowaliśmy :(</div>';
		  echo '<p>$filename:<pre>' . $filename . "</pre></p>";
		  echo '<p>$newaname:<pre>' . $newname . "</pre></p>";
		}	
	
	}
else {
	echo('<P>Nie dodano okladki do bazy! (' . mysql_error() . ')<br>');
	}
include('template_bottom.php');	
?>