<?php require_once('../../../Connections/connjxkh.php'); ?>

<?php
	header("Content-type:text/html;charset=utf-8");
	mysql_query('SET NAMES UTF8');
	
	//接收数据
	if(isset($_POST['type']))
		$type = $_POST['type'];
	if(isset($_POST['title']))	
	    $title = $_POST['title'];
	if(isset($_POST['question']))	
	    $question = $_POST['question'];
	mysql_select_db($database_connjxkh, $connjxkh);
	
	/**取wjregID*/
	$sql = "SELECT MAX(wjregID) FROM wjreg";
	$res = mysql_fetch_array(mysql_query($sql,$connjxkh));
	$wjregID = $res["MAX(wjregID)"];
	$parent_qid =0 ;
	//存入问题
	$sql="INSERT INTO question(parent_qid,wjregID,type,title,question) VALUES ($parent_qid,$wjregID,'$type','$title','$question')";	
	//echo $sql;
	if (!mysql_query($sql,$connjxkh)) {
		 $json_obj= json_encode(array('code'=>400));	
 	 }
	 else{
		 $json_obj= json_encode(array('code'=>200));
		 }			
	echo $json_obj;
	mysql_close($connjxkh);
?>
<?php 
	session_start();
	$_SESSION['wjregID']=$wjregID;
	$_SESSION['type']=$type;
?>