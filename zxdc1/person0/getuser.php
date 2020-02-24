<?php require_once('../Connections/connjxkh.php');
require_once('../Connections/conn.php');//连接数据库 ?>
<?php
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


if (!isset($_SESSION)) {
    session_start();
}
//获取部门管理员ID
$Account = $_SESSION["Admin_Account"];

//echo $Account;

//获取输入内容
if(isset($_GET['xctj']))
	$xctj=$_GET['xctj'];
//获取选择内容
if(isset($_GET['xctype']))
	$xctype=$_GET['xctype'];	
	
$page=$_GET['page'];
$limit=$_GET['limit'];	

$start = ($page-1)*$limit;	

//echo $page;
//echo $limit;

//预处理查询语句
$stmt01 = $conn->prepare("select DeptID from userinfo where Account = ? ");

//设置参数并执行
$stmt01->bind_param("s",$_SESSION["Admin_Account"]);
$stmt01->execute();
$result01 = $stmt01->get_result();
$row = $result01->fetch_assoc();
//echo $row['DeptID'];


switch ($xctype){
	case 1:{
		/*-----------------------------根据用户工号查询用户信息---------------------------------*/
		$query1=" SELECT u.Account,u.UserID, u.UserName, u.Photo, 
				 d.DeptName,l.LevelName
				 FROM deptinfo d, levelinfo l, userinfo u
				 WHERE u.DeptID=d.DeptID 
				 AND l.LevelID=u.LevelID
				 AND u.DeptID = ? AND u.Account = ? ";
		$query="SELECT u.Account,u.UserID, u.UserName, u.Photo, 
				 d.DeptName,l.LevelName
				 FROM deptinfo d, levelinfo l, userinfo u
				 WHERE u.DeptID=d.DeptID 
				 AND l.LevelID=u.LevelID
				 AND u.DeptID = ? AND u.Account = ? limit ?,?";
		$stmt1 = $conn->prepare($query1);
		$stmt = $conn->prepare($query);
		$stmt1->bind_param("ss",$row['DeptID'],$xctj);		 
		$stmt->bind_param("ssss",$row['DeptID'],$xctj,$start,$limit);
		break;
		}
	case 2:{
		/*-----------------------------根据用户名查询用户信息---------------------------------*/
		$query1=" SELECT u.Account,u.UserID, u.UserName, u.Photo, 
				 d.DeptName,l.LevelName
				 FROM deptinfo d, levelinfo l, userinfo u
				 WHERE u.DeptID=d.DeptID 
				 AND l.LevelID=u.LevelID
				 AND u.DeptID = ? AND u.UserName like ?";
		$query=" SELECT u.Account,u.UserID, u.UserName, u.Photo, 
				 d.DeptName,l.LevelName
				 FROM deptinfo d, levelinfo l, userinfo u
				 WHERE u.DeptID=d.DeptID 
				 AND l.LevelID=u.LevelID
				 AND u.DeptID = ? AND u.UserName LIKE '%".$xctj."%' limit ?,? ";
		$stmt1 = $conn->prepare($query1);
		$stmt = $conn->prepare($query);
		$stmt1->bind_param("ss",$row['DeptID'],$xctj);		 
		$stmt->bind_param("sss",$row['DeptID'],$start,$limit);
		break;
		}
	case 3:{
		/*-----------------------------根据用户职级查询用户信息---------------------------------*/
		$query1=" SELECT u.Account,u.UserID, u.UserName, u.Photo, 
				 d.DeptName,l.LevelName
				 FROM deptinfo d, levelinfo l, userinfo u
				 WHERE u.DeptID=d.DeptID 
				 AND l.LevelID=u.LevelID
				 AND u.DeptID = ? AND l.LevelName like ?";
		$query=" SELECT u.Account,u.UserID, u.UserName, u.Photo, 
				 d.DeptName,l.LevelName
				 FROM deptinfo d, levelinfo l, userinfo u
				 WHERE u.DeptID=d.DeptID 
				 AND l.LevelID=u.LevelID
				 AND u.DeptID = ? AND l.LevelName like '%".$xctj."%' limit ?,? ";
		$stmt1 = $conn->prepare($query1);
		$stmt = $conn->prepare($query);
		$stmt1->bind_param("ss",$row['DeptID'],$xctj);		 
		$stmt->bind_param("sss",$row['DeptID'],$start,$limit);
		break;
		}
	}
$stmt1->execute();
$stmt1->store_result();
//返回查询结果个数
$count=$stmt1->num_rows;
 
//echo "查询个数：".$count;
//设置参数并执行

$stmt->execute();
// 取回全部查询结果
$result = $stmt->get_result();
$arr=array();
while ($row01 = $result->fetch_assoc()) {
	$arr[] = $row01;
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
$stmt1->free_result();
$stmt1->close();
$stmt01->free_result();
$stmt01->close();
//关闭数据库连接
$conn->close();
?>
