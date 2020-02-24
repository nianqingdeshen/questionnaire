<?php require_once('../Connections/connjxkh.php'); require('logincheck.php');require('knik.php');?>


<?php
if (!isset($_SESSION)) {
  session_start();
}

mysql_query('SET NAMES UTF8');
mysql_select_db($database_connjxkh, $connjxkh);
$query_rsVoteTime="select * from voterecord where khtype=1 and status='Running'";
$rsVoteTime = mysql_query($query_rsVoteTime, $connjxkh) or die(mysql_error());
$row_rsVoteTime = mysql_fetch_assoc($rsVoteTime);
$totalRows_rsVoteTime = mysql_num_rows($rsVoteTime);

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="../lib/layer/theme/default/layer.css"/>
<script type="text/javascript" src="../lib/jquery-3.2.1.js"></script>
<script type="text/javascript" src="../lib/layer/layer.js"></script>
</head>

<body>
<?php
date_default_timezone_set('PRC');
mysql_query('SET NAMES UTF8');
function isVoted($database_connjxkh, $connjxkh,$tableName){
	mysql_select_db($database_connjxkh, $connjxkh);
	$sql = "select count(*) from ".$tableName." where UserID = '".$_SESSION['MM_UserID']."'";
	echo $sql;
	$rsVoteTime1 = mysql_query($sql, $connjxkh) or die(mysql_error());
	$row_rsVoteTime1 = mysql_fetch_assoc($rsVoteTime1);
	$count = $row_rsVoteTime1['count(*)'];
	print_r($row_rsVoteTime1);
	if($count>0){
		$Result=true;
		//header("location:getvote3.php");
	}
	else 
		 $Result=false;	
	return $Result;	
	
	//header("location:qzpbzyc.php");
}

$startTime="";
$endTime="";
if ($totalRows_rsVoteTime>0){

	$startTime=strtotime($row_rsVoteTime["starttime"]);
	$endTime=strtotime($row_rsVoteTime["endtime"]);
	if(isset($row_rsVoteTime["RecordCode"]))	
		$tableName="qz_ldbzkhinfo_".$row_rsVoteTime["RecordCode"];	
		
	 mysql_free_result($rsVoteTime);	
	
	
	

	if (isVoted( $database_connjxkh, $connjxkh, $tableName)){
		
		echo "<script type='text/javascript'>layer.alert('您已经参与调查，正在跳转投票详情！', {icon: 2});</script>";
		header("location:getvote3.php");
	}	
	else{

		//echo $endTime."<br>";
		$CurrentDate=date('Y-m-d'); 
		//echo $CurrentDate."<br>";
		$CurrentDate=strtotime($CurrentDate);
		//echo $CurrentDate."<br>";
		if ($startTime<=$CurrentDate and $CurrentDate <=$endTime){
			//echo "time is right";	
			sleep(1);
			header("location:qzpbzyc.php");
		}
		else
			echo "<script type='text/javascript'>layer.alert('时间过期，您不能参与问卷调查！', {icon: 2});</script>";	
	
	}
}

else
	echo "<script type='text/javascript'>layer.alert('无考核 ', {icon: 2});</script>";	

?>
</body>
</html>

