<?php 
// 连接数据库
$conn = new mysqli($hostname_connjxkh, $username_connjxkh, $password_connjxkh, $database_connjxkh);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
//设置编码格式
$program_char = "utf8" ;
mysqli_set_charset( $conn , $program_char );
?>