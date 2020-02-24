<?php require_once('../Connections/connjxkh.php'); 
require_once('../Connections/conn.php');//连接数据库?>
<?php
if (!isset($_SESSION)) {
    session_start();
}
$Account = $_POST['Account'];
//执行更新语句
$sql01="delete from userinfo where Account= ? ";
$stmt=$conn->prepare($sql01);
//绑定参数并执行
$stmt->bind_param("s",$Account);
$stmt->execute();
if(!$stmt){
	$json_obj= json_encode(array('code'=>400));	
}else{
	$json_obj= json_encode(array('code'=>200));
}
	
echo $json_obj;
//关闭结果集
$stmt->free_result();
$stmt->close();
//关闭数据库连接
$conn->close();

?>
