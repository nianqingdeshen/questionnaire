<?php require_once('../../../Connections/connjxkh.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

//echo $_SESSION["issuecode"];
//echo $_SESSION["issueitem"];
$tablename="zcbz_result_".$_SESSION["issuecode"];
mysql_query('SET NAMES UTF8');
mysql_select_db($database_connjxkh, $connjxkh);
$query_rskhresult = "SELECT deptinfo.DeptID, deptinfo.DeptName, ROUND(zcbz_xld_result,2 )  AS xld,ROUND(zcbz_bmm_result,2 )  AS bmm, ROUND(zcbz_qz_result,2 )  AS qz, ROUND(zcbz_zc_result,2 )  AS zc,ROUND(zcbz_result,2 ) AS result FROM  ".$tablename.",deptinfo WHERE deptinfo.DeptID=".$tablename.".DeptID";

$rskhresult = mysql_query($query_rskhresult, $connjxkh) or die(mysql_error());
//$row_rskhresult = mysql_fetch_assoc($rskhresult);
$totalRows_rskhresult = mysql_num_rows($rskhresult);



$arr=array();

while($res=mysql_fetch_assoc($rskhresult)){
	$arr[]=$res;
	}
$data=array(
		'code'=>0,
		'msg'=>'',
		'count'=>$totalRows_rskhresult,
		'data'=>$arr
	);
echo json_encode($data);

?>

<?php
mysql_free_result($rskhresult);
?>
