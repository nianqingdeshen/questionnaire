<?php require_once('../../../Connections/connjxkh.php'); ?>

<?php
	header("Content-type:text/html;charset=utf-8");
	mysql_query('SET NAMES UTF8');
	//echo $_POST['MenuName'];
	if(isset($_POST['wjName'])){
		$wjname=$_POST['wjName'];
		//echo $menuname;
	}
	
	if(isset($_POST['wjField']))  	
		$wjfield=$_POST['wjField']; 
    
	

	mysql_select_db($database_connjxkh, $connjxkh);
	$sql="INSERT INTO wjreg (wjName, wjField )VALUES ('$wjname','$wjfield')";

	//echo $sql;
	//mysql_query($sql,$connjxkh);
	//$json_obj= json_encode(array('code'=>200));	
	if (!mysql_query($sql,$connjxkh))
 		 {
		 $json_obj= json_encode(array('code'=>400));			
  
 	 }
	 else{
		 $json_obj= json_encode(array('code'=>200));	
		 }			
	echo $json_obj;
	mysql_close($connjxkh);
	
?>


