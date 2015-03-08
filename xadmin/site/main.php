<?php
	if (isset($_SESSION['count'])) {
   $_SESSION['count']++;
  }
else {
  $_SESSION['count'] = 1;
  }


$smarty-> assign('ctitle', 'STRONA G£ÓWNA');  

$smarty->assign('who', $_SESSION['adminusername'] . ' (id: ' . $_SESSION['adminuserid'] . ')');

//*****************************************************************	
$smarty->assign('body_template', 'site/main.tpl');
//*****************************************************************
?>
