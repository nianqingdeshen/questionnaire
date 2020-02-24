<?php require_once('../Connections/connjxkh.php'); ?>
<?php
if (!isset($_SESSION)) {
    session_start();
}
$Account = $_POST['Account'];
mysql_select_db($database_connjxkh, $connjxkh);
//执行更新语句
$sql01="update userinfo set isBanned=0 where Account='".$Account."'";
//echo $sql01;
		$result01= mysql_query($sql01);
	if(!$result01) {
		$json_obj= json_encode(array('code'=>400));	
 	}
	else{
		$json_obj= json_encode(array('code'=>200));
	}	
	
	echo $json_obj;
	mysql_close($connjxkh);	

?>