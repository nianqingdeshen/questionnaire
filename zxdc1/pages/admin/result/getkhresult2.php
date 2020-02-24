<?php require_once('../../../Connections/connjxkh.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

//echo $_SESSION["issuecode"];
//echo $_SESSION["issueitem"];
$tablename="zczz_result_".$_SESSION["issuecode"];
mysql_query('SET NAMES UTF8');
mysql_select_db($database_connjxkh, $connjxkh);
$query_rskhresult = "SELECT userinformation.Account, userinformation.UserName, userinformation.DeptName, ROUND(zczz_xld_result,2 )  AS xld,ROUND(zczz_bmm_result,2 )  AS bmm, ROUND(zczz_bzf,2 )  AS bzf, ROUND(zczz_zc_result,2 )  AS zc,ROUND(zczz_fr,2 ) AS result FROM  ".$tablename.",userinformation WHERE ".$tablename.".Account=userinformation.Account";

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
