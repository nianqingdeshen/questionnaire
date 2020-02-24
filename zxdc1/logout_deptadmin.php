<?php
// *** Logout the current user.
$logoutGoTo = "index.php";
$cookiename = "PHPSESSID";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['Admin_Account'] = NULL;	
$_SESSION['Admin_DeptID'] = NULL;
//$_SESSION['MM_UserGroup'] = NULL;
unset($_SESSION['Admin_Account']);
session_destroy(); 
//unset($_SESSION['MM_UserGroup']);

setcookie($cookiename, NULL);
if ($logoutGoTo != "") {

	header("Location: $logoutGoTo");
exit;
}
?>