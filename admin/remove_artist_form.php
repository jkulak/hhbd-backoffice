<?php include ('template_top.php');
	include ('connect_to_database.php');?>
<form action="remove_artist.php" method="get" name="add_album" target="_self" enctype="multipart/form-data">
  <font size="5"><b>USUWANIE WYKONAWCY!!!</b></font> 
  <table width="90%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td height="60" valign="top"> 
        <p>Wybierz wykonawce do usiniecia:<br>
          <br>
          <select name="nameid">
            <option> </option>
            <?php	
	$result = mysql_query("SELECT id, name FROM artists ORDER BY name");
    if (!$result) {
      echo("<P>Error performing query: " . mysql_error() . "</P>");
	  exit();
  	  }
	    
    while ( $row = mysql_fetch_array($result) ) {
 
	  print ("<option value=\"" . $row["id"] . "\"" . ($_GET['nameid'] == $row["id"] ? 'selected' : '') . ">" . $row["name"] . "</option>");
  	  }
  ?>
          </select>
        </p>
        
      </td>
    </tr>
  </table>
  <p>
    <input type="submit" value="Usun wykonawce" name="submit">
  </p>
</form>
<?php include ('template_bottom.php'); ?>