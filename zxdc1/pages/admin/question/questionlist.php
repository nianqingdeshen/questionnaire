<?php require_once('../../../Connections/connjxkh.php'); ?>
<?php
$colname_rsQue = "-1";
if (isset($_GET['wjregID'])) {
  $colname_rsQue = (get_magic_quotes_gpc()) ? $_GET['wjregID'] : addslashes($_GET['wjregID']);
}
mysql_select_db($database_connjxkh, $connjxkh);
$query_rsQue = sprintf("SELECT * FROM question WHERE parent_qid=0 and wjregID = %s ", $colname_rsQue);
$rsQue = mysql_query($query_rsQue, $connjxkh) or die(mysql_error());
$row_rsQue = mysql_fetch_assoc($rsQue);
$totalRows_rsQue = mysql_num_rows($rsQue);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../../../lib/layui230/css/layui.css">
<title>问卷题目信息</title>

</head>

<body>

<table class="layui-table" width="1000" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="5%" height="34" align="center" valign="middle"><div align="center">序号</div></td>
    <td width="5%" align="center" valign="middle"><div align="center">父ID</div></td>
    <td width="5%" align="center" valign="middle"><div align="center">类型</div></td>
    <td width="5%" align="center" valign="middle"><div align="center">题目标记</div></td>
    <td width="45%" align="center" valign="middle"><div align="center">题目内容</div></td>
	<td width="3%" align="center" valign="middle"><div align="center">禁用</div></td>
    <td width="8%" align="center" valign="middle">修改题目</td>
	<td width="8%" align="center" valign="middle">禁用题目</td>
	<td width="8%" align="center" valign="middle">启用题目</td>
    <td width="8%" align="center" valign="middle">修改选项</td>
	
  </tr>
  <?php do { ?>
    <tr>
      <td height="30" align="center" valign="middle"><div align="center"><?php echo $row_rsQue['questionID']; ?></div></td>
      <td align="center" valign="middle"><div align="center"><?php echo $row_rsQue['parent_qid']; ?></div></td>
      <td align="center" valign="middle"><div align="center"><?php echo $row_rsQue['type']; ?></div></td>
      <td align="center" valign="middle"><div align="center"><?php echo $row_rsQue['title']; ?></div></td>
      <td align="center" valign="middle"><div align="left"><?php echo $row_rsQue['question']; ?></div></td>
	   <td align="center" valign="middle"><div align="left"><?php echo $row_rsQue['isdeleted']; ?></div></td>
      <td align="center" valign="middle"><p><a href="updatequestionitem.php?questionID=<?php echo $row_rsQue['questionID']; ?>&wjregID=<?php echo $_GET['wjregID']; ?>">修改题目</a></p>      </td>
	   <td align="center" valign="middle"><p><a href="delquestion.php?questionID=<?php echo $row_rsQue['questionID']; ?>&wjregID=<?php echo $_GET['wjregID']; ?>">禁用题目</a></p>      </td>
	   <td align="center" valign="middle"><p><a href="enablequestion.php?questionID=<?php echo $row_rsQue['questionID']; ?>&wjregID=<?php echo $_GET['wjregID']; ?>">启用题目</a></p>      </td>
      <td align="center" valign="middle"><a href="updateitem.php?questionID=<?php echo $row_rsQue['questionID']; ?>&wjregID=<?php echo $_GET['wjregID']; ?>">修改选项</a></td>
	  
    </tr>
    <?php } while ($row_rsQue = mysql_fetch_assoc($rsQue)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsQue);
?>