<?php

if (!isset($_SESSION['adminusername'])) {
    header('Location: /');
	exit();
    }

$artist = $_POST['artist'];

$sql = 'INSERT INTO artists_everyweek (aid, addedby) VALUES ("' . $artist . '", "' . $_SESSION['adminuserid'] . '")';

$result = mysql_query($sql);
if ($result) {
    $smarty->assign('info', 'Nowa posta� tygodnia zosta�a dodany do bazy.');
	}
else {
   	$smarty->assign('info', '<font color=red>Nowa posta� tygodnia NIE zosta�a dodana do bazy.</font> (' . mysql_error() . ')');
   	}

//*****************************************************************	
$smarty->assign('ctitle', 'DODAWANIE POSTACI TYGODNIA');
$smarty->assign('mainsection', '<font color="#6f91ac">POSTA� TYGODNIA</font>');
$smarty->assign('body_template', 'site/final-info.tpl');
//*****************************************************************
?>