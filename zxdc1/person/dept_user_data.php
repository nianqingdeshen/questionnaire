<?php require_once('../Connections/connjxkh.php'); ?>
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


$page=$_GET['page'];
$limit=$_GET['limit'];
mysql_select_db($database_connjxkh, $connjxkh);
//查询本部门的所有用户信息（处级领导、职工代表、普通职工）
if ($_SESSION['Admin_DeptID']==7)
{
	$query_rsrm = "SELECT u.UserID,Account,UserName,DeptName,l.LevelName, u.IsDB, u.isBanned
				FROM userinformation u,levelinfo l WHERE u.LevelID=l.LevelID 
				AND DeptID in (2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,40,41,42,44,53,56)" ;
	$sql2="SELECT  Account,UserName,DeptName,l.LevelName
				FROM userinformation u,levelinfo l WHERE u.LevelID=l.LevelID 
				AND DeptID in (2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,40,41,42,44,53,56) " ;				
}
	
				
else
{

$query_rsrm = "SELECT u.UserID,Account,UserName,DeptName,l.LevelName, u.IsDB, u.isBanned
				FROM userinformation u,levelinfo l WHERE u.LevelID=l.LevelID 
				AND DeptID = ".$_SESSION['Admin_DeptID'] ;
$sql2="SELECT  Account,UserName,DeptName,l.LevelName
				FROM userinformation u,levelinfo l WHERE u.LevelID=l.LevelID 
				AND DeptID = ".$_SESSION['Admin_DeptID'] ;				
}

	
$query_limit_rsrm = $query_rsrm." order by u.UserID limit ".($page-1)*$limit.",".$limit;
$rsrm = mysql_query($query_limit_rsrm, $connjxkh) or die(mysql_error());



$q_sql2=mysql_query($sql2);
$count=mysql_num_rows($q_sql2);
$arr=array();

while($res=mysql_fetch_assoc($rsrm)){
	$arr[]=$res;
}
$data=array(
		'code'=>0,
		'msg'=>'',
		'count'=>$count,
		'data'=>$arr
	);
echo json_encode($data);
	
?>
<?php
mysql_free_result($rsrm);
?>
