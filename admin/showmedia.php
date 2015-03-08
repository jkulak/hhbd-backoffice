<?php
  
   // Connect to the database server
  print ("test");
  $dbcnx = @mysql_pconnect("localhost", "fee", "f33del");
    if (!$dbcnx) {
      print ("Nie mozna sie polaczyc z baza: " . mysql_error() . "<br>");
      exit();
      }
	else {
	  print ('Polaczono z baza danych.<br>');
	  }

  $nazwa_bazy = 'katalog';
  
  
  if (! @mysql_select_db($nazwa_bazy) ) {
      print ("Nie mozna odnalezc bazy: $nazwa_bazy (" . mysql_error() . ")<br>");
      exit();
	  }
	else {
	  print ("Otworzono baze: '$nazwa_bazy' do edycji<br>");
	  }
  
  
  
  // Request the text of all the jokes
  $result = mysql_query(
            "SELECT name FROM media ORDER BY name DESC");
  if (!$result) {
    echo("<P>Error performing query: " .
         mysql_error() . "</P>");
    exit();
  }

  
  print ('          <select name="select2">');
  while ( $row = mysql_fetch_array($result) ) {
    echo("<option>" . $row["name"] . "</option>");
  }
  
  print ('</select>');


?>
