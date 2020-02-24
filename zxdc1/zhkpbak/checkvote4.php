<?php require_once('../Connections/connjxkh.php');require('logincheck.php'); require('knik.php');?>

<?php
if (!isset($_SESSION)) {
  session_start();
}


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


mysql_query('SET NAMES UTF8');
mysql_select_db($database_connjxkh, $connjxkh);
$query_rsVoteTime="select * from voterecord where khtype=1 and status='running'";
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

function isVoted($database_connjxkh, $connjxkh,$tableName,$LevelID){
  //Levelid=4  表示院部中层干部为教师代表
  //Levelid=6  表示院部普通教师为教师代表
	mysql_select_db($database_connjxkh, $connjxkh);
	if ($LevelID==2 or $LevelID==3 )
		$sql = "select count(*) from ".$tableName." where LevelID=4 and UserID = '".$_SESSION['MM_UserID']."'";
	if ($LevelID==6)
		$sql = "select count(*) from ".$tableName." where LevelID=6 and UserID = '".$_SESSION['MM_UserID']."'";
	echo $sql;
	$rsVoteTime = mysql_query($sql, $connjxkh) or die(mysql_error());
	$row_rsVoteTime = mysql_fetch_assoc($rsVoteTime);
	$count = $row_rsVoteTime['count(*)'];
	print_r($row_rsVoteTime);
	if($count>0){
		$Result=true;
		//header("location:getvote0.php");
	}
	else 
		 $Result=false;	
	return $Result;	
	
	
	//header("location:zhkpsxhpa.php");
}
$startTime="";
$endTime="";
if ($totalRows_rsVoteTime>0){

	$startTime=strtotime($row_rsVoteTime["starttime"]);
	$endTime=strtotime($row_rsVoteTime["endtime"]);
	if(isset($row_rsVoteTime["RecordCode"]))	
		$tableName="zc_ldbzkhinfo_".$row_rsVoteTime["RecordCode"];	
		
	//$tableName="zc_ldbzkhinfo_".$rs['RecordCode'];
		
	 mysql_free_result($rsVoteTime);	
	
	
	$LevelID=$_SESSION["MM_RoleID"];

	if (isVoted( $database_connjxkh, $connjxkh, $tableName,$LevelID)){
		
		echo "<script type='text/javascript'>layer.alert('您已经参与调查，正在跳转投票详情！', {icon: 2});</script>";
		if ($LevelID==6)
			header("location:getvote0.php");
		else
		    header("location:getvote10.php");
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
			header("location:zhkpsxhpa.php");
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

