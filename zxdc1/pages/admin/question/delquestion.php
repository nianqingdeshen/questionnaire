<?php require_once('../../../Connections/connjxkh.php'); ?>
<?php
//echo $_POST['id'];
if(isset($_GET['questionID']))
	$questionID=$_GET['questionID'];
//echo $UserID;
if(isset($_GET['wjregID']))
	$wjregID=$_GET['wjregID'];
$query_rsUser="update question set isdeleted=1 where questionID=".$questionID."";
//echo $query_rsUser;
mysql_query('SET NAMES UTF8');
mysql_select_db($database_connjxkh, $connjxkh);
$result = mysql_query($query_rsUser, $connjxkh) or die(mysql_error());
if($result)
	header("location:questionlist.php?wjregID="+$wjregID);
else
	echo "É¾³ýÊ§°Ü";
mysql_close($connjxkh);
?>