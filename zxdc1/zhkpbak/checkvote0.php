<?php require_once('../Connections/connjxkh.php'); require('logincheck.php'); require('knik.php');?>

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

function isVoted($database_connjxkh, $connjxkh,$tableName){
	mysql_select_db($database_connjxkh, $connjxkh);
	$sql = "select count(*) from ".$tableName." where LevelID=".$_SESSION["MM_RoleID"]." and UserID = '".$_SESSION['MM_UserID']."'";
	echo $sql;
	echo $_SESSION['MM_UserID'];
	$rsVoteTime = mysql_query($sql, $connjxkh) or die(mysql_error());
	$row_rsVoteTime = mysql_fetch_assoc($rsVoteTime);
	$count = $row_rsVoteTime['count(*)'];
	print_r($row_rsVoteTime);
	$cc = intval(floor($count/30))+1;
	//echo '<script language="JavaScript">alert("'.$cc.'");
	if($count>0){
		echo '<script language="JavaScript">alert("已投票，正在跳转投票详情")</script>';
		header("location:getvote0zc.php");
	}
	else header("location:zcldhp_bz.php");
}

if ($totalRows_rsVoteTime>0){
	$tableName="zc_ldbzkhinfo_".$row_rsVoteTime['RecordCode'];
	isVoted($database_connjxkh, $connjxkh,$tableName);
	}
else
	echo "<script type='text/javascript'>layer.alert('无考核 ', {icon: 2});</script>";	
	
?>
</body>
</html>

