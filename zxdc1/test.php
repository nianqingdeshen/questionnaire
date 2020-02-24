
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
$xctj ='姜';
//预处理查询语句
$sql = "delete from noteinfo where NoteID= ? ";
	$stmt=$conn->prepare($sql);		
//设置参数并执行 
$Note = 18;

$stmt->bind_param("s",$Note);
$stmt->execute();
if($stmt){
	echo "删除成功";
}
 


//关闭结果集
$stmt->free_result();
$stmt->close();
$conn->close();
 
?>