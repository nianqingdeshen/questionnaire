<?php require_once('../../../Connections/connjxkh.php'); ?>
<?php
//echo $_POST['id'];
if(isset($_POST['wjregID']))
	$wjregID=$_POST['wjregID'];
//echo $wjregID;
$query_rsDept=" Delete From wjreg  where wjregID=".$wjregID;
//echo $query_rsDept;
mysql_query('SET NAMES UTF8');
mysql_select_db($database_connjxkh, $connjxkh);
$result = mysql_query($query_rsDept, $connjxkh) or die(mysql_error());
if($result)
	echo json_encode(array('code'=>200));
else
	echo json_encode(array('code'=>400));
mysql_close($connjxkh);
?>