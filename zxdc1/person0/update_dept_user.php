<?php require_once('../Connections/connjxkh.php'); 
require_once('../Connections/conn.php');//连接数据库?>
<?php
mysql_query('SET NAMES UTF8');
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
$Account=$_GET['Account'];
$login = $_SESSION['Admin_DeptID'];
/* -----------------------查询用户信息-------------------------- */
$stmt01 = $conn->prepare("select UserID,UserName,Passwd,LevelID,DeptID from userinfo where Account= ?");
//设置参数并执行
$stmt01->bind_param("s",$Account);
$stmt01->execute();

// 取回全部查询结果
$result01 = $stmt01->get_result();
$count =0 ;
$LevelID = -1;
while ($row01 = $result01->fetch_assoc()) {
	$count++;
	$UserID= $row01['UserID'];
	$LevelID = $row01['LevelID'];
	$UserName = $row01['UserName'];
	$Passwd = $row01['Passwd'];
	$DeptID = $row01['DeptID'];
}
if($count==0 || $login != $DeptID ){
	header("Location://localhost/");
}

/* -----------------------查找用户所属部门-------------------------- */
$stmt02 = $conn->prepare("SELECT d.DeptID,d.DeptName FROM deptinfo d,userinfo u 
					WHERE u.DeptID=d.deptID AND u.Account= ?");
//设置参数并执行
$stmt02->bind_param("s",$Account);
$stmt02->execute();
// 取回全部查询结果
$result02 = $stmt02->get_result();
$row02 = $result02->fetch_assoc();

/* -----------------------查询所有部门（除了用户自己的部门）-------------------------- */
$stmt03 = $conn->prepare("SELECT DeptID,DeptName FROM deptinfo WHERE DeptID != ? ORDER BY DeptID ASC");
//设置参数并执行
$stmt03->bind_param("s",$row02['DeptID']);
$stmt03->execute();
// 取回全部查询结果
$result03 = $stmt03->get_result();

/* -----------------------查询用户职级-------------------------- */
$stmt04 = $conn->prepare("select LevelName from levelinfo where LevelID= ?");
//设置参数并执行
$stmt04->bind_param("s",$LevelID);
$stmt04->execute();
// 取回全部查询结果
$result04 = $stmt04->get_result();
$row04 = $result04->fetch_assoc();

/* -----------------------查询所有职级（除了用户职级和校领导职级）-------------------------- */
$stmt05 = $conn->prepare("select LevelID, LevelName from levelinfo where LevelID != 1 and LevelID != ? ");
//设置参数并执行
$stmt05->bind_param("s",$LevelID);
$stmt05->execute();
// 取回全部查询结果
$result05 = $stmt05->get_result();

if(!$stmt01){
	echo "页面错误";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改用户信息</title>
<link rel="stylesheet" type="text/css" href="../lib/layui245/css/layui.css"/>
<script src="../lib/layui230/layui.js" charset="utf-8"></script>
<script type="text/javascript" src="../lib/jquery-3.2.1.js"></script>
</head>

<body class="layui-body layui-bg-gray" align="center">
<form class="layui-form" action="">
 <div class="layui-form-item">
    <label class="layui-form-label">用户ID</label>
	<div class="layui-input-inline">
    <input type="text" id="UserID" required lay-verify="required" value="<?php echo $UserID;?>" readonly="true" autocomplete="off" class="layui-input">   
	</div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">用户名称</label>
	<div class="layui-input-inline">
    <input type="text" id="UserName" required lay-verify="required" value="<?php echo $UserName;?>" autocomplete="off" class="layui-input">   
	</div>
  </div>
  
  <div class="layui-form-item">
    <label class="layui-form-label">用户密码</label>
    <div class="layui-input-inline">
      <input type="text" id="Passwd" required lay-verify="required" value="<?php echo $Passwd;?>" autocomplete="off" class="layui-input">
    </div>
  </div>
  
  <div class="layui-form-item">
    <label class="layui-form-label">职&ensp;&ensp;&ensp;&ensp;级</label>
    <div class="layui-input-inline">
      <select name="city"  id = "LevelID" lay-verify="required">
        <option value="<?php echo $LevelID?>"><?php echo $row04['LevelName']?></option>
		<?php 
			while($row05 = $result05->fetch_assoc()){
				echo "<option value='".$row05['LevelID']."'>".$row05['LevelName']."</option>";
			}
		?>
      </select>
    </div>
  </div>
  
  <div class="layui-form-item">
    <label class="layui-form-label">所在部门</label>
    <div class="layui-input-inline">
      <select name="city"  id = "DeptID" lay-verify="required">
        <option value="<?php echo $row02['DeptID']?>"><?php echo $row02['DeptName']?></option>
		<?php 
			while($row03=$result03->fetch_assoc()){
				echo "<option value='".$row03['DeptID']."'>".$row03['DeptName']."</option>";
			}
		?>
      </select>
    </div>
  </div>
  <div class="layui-form-item" >
    <div class="layui-input-block">
      <input  class="layui-btn" type="button" onclick="test()" value="更新用户"/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    </div>
  </div>
</form>
 <script>
 function test(){
	 //获取修改后的用户名
	 var UserName = document.getElementById('UserName').value;
	 //获取修改后的用户密码
	 var Passwd = document.getElementById('Passwd').value;
	 //获取修改后的用户职级
	 var LevelID = document.getElementById('LevelID').value;
	 //获取修改后的用户职级
	 var DeptID = document.getElementById('DeptID').value;
	 //获取用户ID
	 var UserID=document.getElementById('UserID').value;
	 //alert(UserID);
	 //alert(UserName);
	// alert(Passwd);
	 //alert(LevelID);
	 $.ajax({
	      type:"POST",
	      url:"update_user_data.php",
	      data:'UserName='+UserName+'&Passwd='+Passwd+'&UserID='+UserID+'&LevelID='+LevelID+'&DeptID='+DeptID,
	      dataType:"json",
	      success:function(data){
	        if(data.code==200){
	          	alert("保存成功！");
				parent.location.href="view_user.php";
	        }else{
				alert("修改失败！");
	        }
	      },
			error:function(data){alert("修改成功！");parent.location.href="view_user.php";},
	    });
 }
</script>
<script>
//Demo
layui.use('form', function(){
  var form = layui.form;
  
  //监听提交
  form.on('submit(formDemo)', function(data){
    layer.msg(JSON.stringify(data.field));
    return false;
  });
});
</script>
</form>
</body>
</html>