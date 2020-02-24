<?php 
require_once('../Connections/connjxkh.php');
require_once('../Connections/conn.php');//连接数据库
 ?>
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
$start = ($page-1)*$limit;

/*-----------------------------查询本部门的所有用户信息（处级领导、职工代表、普通职工）---------------------------------*/
$stmt = $conn->prepare("SELECT u.UserID,Account,UserName,DeptName,l.LevelName, u.IsDB
				FROM userinformation u,levelinfo l WHERE u.LevelID=l.LevelID 
				AND DeptID = ? order by u.UserID limit ?,?");
//设置参数并执行
$stmt->bind_param("sii",$_SESSION['Admin_DeptID'],$start,$limit);
$stmt->execute();
$a = array();
// 取回全部查询结果
$result01 = $stmt->get_result();

/*-----------------------查询部门人数-----------------------*/
$stmt01 = $conn->prepare("SELECT  Account,UserName,DeptName,l.LevelName
				FROM userinformation u,levelinfo l WHERE u.LevelID=l.LevelID 
				AND DeptID = ?");
//设置参数并执行
$stmt01->bind_param("s",$_SESSION['Admin_DeptID']);
$stmt01->execute();
// 执行SQL语句
$stmt01->store_result();
 
// 查询结果条数
//echo "记录个数：".$stmt01->num_rows."行<br />";

$count=$stmt01->num_rows;
$arr=array();

while ($row = $result01->fetch_assoc()) {
	$arr[] = $row;
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
//关闭结果集
$stmt->free_result();
$stmt->close();
$stmt01->free_result();
$stmt01->close();
//关闭数据库连接
$conn->close();
?>
