<?php require_once('../../../Connections/connjxkh.php'); 

mysql_query('SET NAMES UTF8');

mysql_select_db($database_connjxkh, $connjxkh);

$A = array();
for($i = 1 ; $i <= 8; $i ++){
	$A[$i]="87654321";
}

$B = array();
for($i = 1 ; $i <= 8; $i ++){
	$B[$i]="'mim'";
}

$sql = "UPDATE userinfotest SET Account = CASE UserID ";
for($i = 1 ; $i <= 8; $i ++){
	$sql .= " when ".$i." then ".$A[$i];
}
$sql .= " END,Passwd = CASE UserID ";

for($i = 1 ; $i <= 8; $i ++){
	$sql .= " when ".$i." then ".$B[$i];
}
$sql .= " END where UserID IN (";

for($i = 1 ; $i <= 8; $i ++){
	if($i==8){
		$sql .= $i.")";break;
	}
	$sql .= $i.",";
}
echo $sql." and Rank = 0"."<br />";
echo $sql." and Rank = 1"."<br />";
echo $sql." and Rank = 2"."<br />";
echo $sql." and Rank = 3"."<br />";

?>

