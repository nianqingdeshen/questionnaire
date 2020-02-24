<?php  require_once('Connections/connjxkh.php'); ?>
<?php
header("Content-type:text/html;charset=utf-8");
	mysql_query('SET NAMES UTF8');
	
if (!isset($_SESSION)) {
    session_start();
}

//获取选项title
$title=$_POST['title'];
//echo $title."<br>";
$title= json_decode($title,true);



//$length=count($title);
//echo $length."<br>";
 //获取投票值
$value=$_POST['value'];
//echo $value."<br>";
$values = json_decode($value,true);
//echo count($value);


 //获取用户账号
date_default_timezone_set('PRC'); 
$submittime=date("Y-m-d H:i", time());			
$userid=$_SESSION['MM_UserID'];
$deptid=$_SESSION['MM_DeptID'];
//$voteissue=$_SESSION['MM_VoteIssue'];

//echo $length;
//连接数据库
	mysql_select_db($database_connjxkh, $connjxkh);
	$VoteTableName="pswjdc_".$_SESSION['MM_VoteIssue'];
	$sql="INSERT INTO  ".$VoteTableName."( UserID, DeptID, voteTime, ";
	$tl="";
	foreach($title as $key=>$value){

    	$tl= $value.",";
		$sql=$sql.$tl;

	}
	$sql= substr($sql,0,strlen($sql)-1)." ) values ( ".$userid." ,".$deptid." ,'".$submittime."', "; 
	$vl="";
	foreach($values as $key=>$value){

    	$vl="'".$value."'".",";
		$sql=$sql.$vl;

	}
	$sql= substr($sql,0,strlen($sql)-1)." ) "; 
	//echo $sql;
    //$sql=$sql.$title." ) values (";
	//$sql=$sql.$value." )";
	//$vl="";
	//for ($i=0;$i<$length;$i=$i+1)
	//	$vl=$value[$i];
	//	$values=$values.$vl.",";
	//	$tl="";	
	//$sql=$sql.$values." )";			
	
	
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