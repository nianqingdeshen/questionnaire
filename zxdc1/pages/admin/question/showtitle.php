<?php require_once('../../../Connections/connjxkh.php'); ?>
<?php
$colname_rswj = "1";
if (isset($_GET['wjregID'])) {
  $colname_rswj = (get_magic_quotes_gpc()) ? $_GET['wjregID'] : addslashes($_GET['wjregID']);
}
mysql_select_db($database_connjxkh, $connjxkh);
$query_rswj = sprintf("SELECT * FROM question WHERE wjregID = %s AND question.parent_qid=0", $colname_rswj);
$rswj = mysql_query($query_rswj, $connjxkh) or die(mysql_error());

$totalRows_rswj = mysql_num_rows($rswj);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php 
	while($row_rswj = mysql_fetch_assoc($rswj)){
		
		echo $row_rswj["title"]."<br>";
	}
?>



</body>
</html>
<?php
mysql_free_result($rswj);
?>
