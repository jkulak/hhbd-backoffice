<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
	exit();
    }

include ('template_top.php');
include ('connect_to_database.php'); 


$sql = 'SELECT name, website, email, addres FROM labels WHERE id=' . $_GET['id'];
$result = mysql_query($sql);
$labelrow = mysql_fetch_array($result);

$sql = 'SELECT cityid FROM city_label_lookup WHERE labelid=' . $_GET['id'];
$result = mysql_query($sql);
$cityrow = mysql_fetch_array($result);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="15">&nbsp;</td>
  </tr>
  <tr>
    <td><font size="3"><b>EDYTUJ WYTW&Oacute;RNIE</b></font></td>
  </tr>
  <tr>
    <td height="15">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"> 
      <form action="edit_label.php" method="get" name="add_album" target="_self" enctype="multipart/form-data">
        <table width="540" border="0" cellspacing="0" cellpadding="0">
          <tr align="left"> 
            <td width="180" height="90" valign="top"> 
              <p>nazwa wytw&oacute;rni:
<input name="name" type="text" size="20" maxlength="255" value="<?php print($labelrow['name']); ?>" >
              </p>
            </td>
            <td height="90" valign="top" width="180"> 
              <p>strona internetowa wytw&oacute;rni:
<input name="website" type="text" size="20" maxlength="255" value="<?php print($labelrow['website']); ?>" >
              </p>
            </td>
            <td height="90" valign="top" width="180">email wytw&oacute;rni: <br>
              <input name="email" type="text" size="20" maxlength="255" value="<?php print($labelrow['email']); ?>" >
            </td>
          </tr>
          <tr align="left"> 
            <td width="180" height="90" valign="top">adres wytw&oacute;rni: <br>
              <input name="addres" type="text" size="20" maxlength="255" value="<?php print($labelrow['addres']); ?>" >
            </td>
            <td height="90" valign="top" width="180">miasto pochodzenia:<br>
              <input name="city" type="text" size="20" maxlength="255">
              <br>
              <select name="cityid">
                <option> </option>
                <?php	
	$result = mysql_query("SELECT id, name FROM cities ORDER BY name");
    if (!$result) {
      echo("<P>Error performing query: " . mysql_error() . "</P>");
	  exit();
  	  }
	    
    while ( $row = mysql_fetch_array($result) ) {
 
	  print ("<option value=\"" . $row['id'] . "\"" . ($cityrow['cityid'] == $row['id'] ? 'selected' : '') . ">" . $row["name"] . "</option>");
  	  }
  ?>
              </select>
            </td>
            <td height="90" valign="top" width="180">&nbsp;</td>
          </tr>
          <tr align="left"> 
            <td width="180" valign="top"> 
              <input type="submit" value="EDYTUJ WYTWORNIE">
            </td>
            <td valign="top" width="180">
              <input type="hidden" name="id" value="<?php print($_GET[id]); ?>">
            </td>
            <td valign="top" width="180"></td>
          </tr>
        </table>
        </form>
    </td>
  </tr>
</table>
<?php include ('template_bottom.php'); ?>
