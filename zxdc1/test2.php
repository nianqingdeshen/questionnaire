
<?php 
require_once('Connections/connjxkh.php'); 
header("Content-Type:text/html;charset=UTF-8");//设置编码格式
 
// 连接数据库
$conn = new mysqli($hostname_connjxkh, $username_connjxkh, $password_connjxkh, $database_connjxkh);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
//设置编码格式
$program_char = "utf8" ;
mysqli_set_charset( $conn , $program_char );

$colname_rsdept='90000001';
//预处理查询语句-根据用户的DeptID查询部门类型
$stmt = $conn->prepare("select DeptID from userinfo where Account = ? ");
//设置参数并执行
$stmt->bind_param("s",$colname_rsdept);
$stmt->execute();

//绑定结果集
//$stmt->bind_result($DeptID);
// 取回全部查询结果
$result01 = $stmt->get_result();

//返回结果集的关联数组
$row_rsdept = $result01->fetch_assoc();
echo $row_rsdept['DeptID'];
//取出部门类型
$deptMemo = $row_rsdept['DeptID'];


//预处理查询语句
$stmt01 = $conn->prepare("select UserID,UserName,Passwd,LevelID from userinfo where Account= ?");
$Account = 10040003;
//设置参数并执行
$stmt01->bind_param("s",$Account);
$stmt01->execute();
//绑定结果集
$stmt01->bind_result($UserID,$UserName,$Passwd,$LevelID);

// 取回全部查询结果
$result = $stmt01->get_result();

$count =0;
while ($row = $result->fetch_assoc()) {
	$count++;
	
	echo "<br>";
}	echo "结果个数：".$count."<br>";
$row = $result->fetch_assoc();
echo $row['UserName']."mingzi";
//关闭结果集
$stmt->free_result();
$stmt->close();
$conn->close();
 
?>