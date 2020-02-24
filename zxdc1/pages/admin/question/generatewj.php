<?php require_once('../../../Connections/connjxkh.php'); ?>
<?php
header("content-type:text/html;charset=utf-8");
mysql_query('SET NAMES UTF8');

if (isset($_POST['wjregID'])) {
  $wjregID = $_POST['wjregID'];
}
mysql_select_db($database_connjxkh, $connjxkh);
$query_rsvote = sprintf("SELECT * FROM wjreg WHERE wjregID = %s ", $wjregID);
$rsvote = mysql_query($query_rsvote, $connjxkh) or die(mysql_error());
$row_rsvote = mysql_fetch_assoc($rsvote);
$totalRows_rsvote = mysql_num_rows($rsvote);
$wjName=$row_rsvote['wjName']; 

$sql = "SELECT * FROM question where wjregID =" . $wjregID." and parent_qid=0 and isdeleted=0 order by questionID";
//echo $sql;
$result = mysql_query($sql, $connjxkh);




?>
<?php
ob_start();// 


echo '<!DOCTYPE html>';
echo '<head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">';
echo '<title>'.$wjName.'</title>';
echo '<link rel="stylesheet" href="lib/layui245/css/layui.css"  media="all">';
echo '</head>';
echo '<body>';
echo "<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$wjName."</h1>"; // 


?>

<?php 
echo '<form  method="post" action="savevote.php"> ';
$cnt = 1;
while ($res = mysql_fetch_assoc($result)) {//ȡstudy_sqlен
	$qid=$res["questionID"];
    $parent_qid = $res["parent_qid"];
	$title=$res["title"];
	$question=$res["question"];
	if($parent_qid==0){
		echo '<table class="layui-table" >';		
		echo "<tr><td><h3>Q".$cnt.". ".$question."</h3></td></tr>";
		echo "</table>";

			}
			$sqlitem="SELECT * FROM question where wjregID =" . $wjregID."  and parent_qid=".$qid ." and parent_qid!=0 ";
			//echo $sqlitem;
			
			$resultitem = mysql_query($sqlitem, $connjxkh);
			echo '<table class="layui-table" >';		
			echo "<tr>";
			while($resitem=mysql_fetch_assoc($resultitem)){			
				$questionID=$resitem["questionID"];
	            $type = $resitem["type"];
				$parent_qid_item = $resitem["parent_qid"];
				//echo $type;
	            $titleitem = $resitem["title"];
	            $question = $resitem["question"];
			//ʾ
				if($type==2&&$parent_qid_item!=0) 
					echo "<td><input type='text' name='".$title."' style='width:540px;' value='".$question."'/></td>";
			//ı
				//if($type =="T") echo "<td><input type='text' name='<h3>".$title."</h3>' placeholder=''></td>";
			//ѡ
				if($type==1&&$parent_qid_item!=0)  
				echo "<td><input type='radio' name='".$title."' value='".$titleitem."' /> ".$titleitem.". ".$question."</td>"; 		
			//ѡ	
				if($type==0&&$parent_qid_item!=0) 
				echo "<td><input name='".$title."' type='checkbox' value='".$titleitem."' /> ".$titleitem.". ".$question."</td>";
           
        	} 
			echo "</tr>";
			echo "</table>";
			$cnt+=1;
			}
			
echo '<table class="layui-table" >';		
		echo '<tr><td><div class="layui-form-item layui-col-xs-offset6"> <input class="layui-btn" type="button" onclick="test()" value="立即提交"/></div></td></tr>';
		echo "</table>";
	
echo "</form>";
?>
<?php
echo '<script src="lib/jquery-3.2.1.js" charset="utf-8"></script>';

$javascript=<<<string
function test(){
    var radioName = new Array();
	var raName = new Array();
	var chkName = new Array();
	var flag=0;
	var title= new Array();
	var value= new Array();
	var j=0;
	var i=0;
	
    $(":radio").each(function(){
        radioName.push($(this).attr("name"));
		raName.push($(this).attr("name"));
    });
    $(":checkbox").each(function(){
        radioName.push($(this).attr("name"));
    });
    radioName.sort();
    $.unique(radioName);
	$.unique(raName);
	
	
    $(":checkbox").each(function(){
        chkName.push($(this).attr("name"));
    });		
	$.unique(chkName);
	
    $.each(radioName,function(i,val){
		//alert(radioName[i]);
        if(!checkRadio(val)){
		    
            alert("您还有未选项，请继续");
			//$('input[name=radioName[i]]').eq(0).focus();	
			flag=0;		
            return false;
			
        }
		else
		   flag=1;	
		
    });
	if (flag){
		alert("ok");		
		$("input[type='text']").each(function () {

                    if($(this).val()==""){
						alert("您还有未填写的项目，请继续");
						flag=0;		
			            return false;
					}
					else
						flag=1;

                });
	}
    if(flag){
		 
		  $("input[type='text']").each(function () {
				title[i]=$(this).attr("name");
                    //alert($(this).val());
				value[i]=$(this).val();
				i=i+1;
           });
          for( j=0;j<raName.length;j++) {
			var tl=raName[j]; 
			title[i] =tl;
			var item = $("input[name="+tl+"]:checked").val(); 						
			value[i]=item;
			//alert(value[i]);
			i=i+1;   
		};		
		for(j=0;j<chkName.length;j++) {
			var ctname=chkName[j]; 
			title[i] =ctname;
			var vl=getCheckBoxValueOne(ctname);						
			value[i]=vl;
			//alert(value[i]);
			i=i+1;	
		};		 
		$.ajax({
	      type:"POST",
	      url:"save_wj.php",
	      data:'title='+JSON.stringify(title)+'&value='+JSON.stringify(value),
	      dataType:"json",
	      success:function(data){
	        if(data.code==200){
	          	alert("保存成功！");
				//window.location.href="checkvote1.php";
	        }else{
				alert("保存失败！");
	        }
	      },
			error:function(data){alert("error");},
	    });	
	}
}
 
function checkRadio(radioName){
    return $("input[name="+radioName+"]:checked").val() == null ? false : true;
}

function  getCheckBoxValueOne(ctname) {
            //获取name="box"选中的checkBox的元素
            var  ids = $('input:checkbox[name='+ctname+']:checked');
             var data = '';
             //alert(ids);
             for (var i = 0; i < ids.length; i ++) {
                 //利用三元运算符去点
                 data += ids[i].value + (i == ids.length - 1 ? '':',');
             }
             //弹出结果
			//alert(data);
             return data;
}
string;
echo "<script>";
echo $javascript;
echo "</script>";
$tail="</body></html>";
echo $tail;
//$content=ob_get_contents();
//$fp=fopen('psdcwj_'.$voteRecord.'.html',"w");

//fwrite($fp, mb_convert_encoding( $content, 'UTF-8', mb_detect_encoding($content) ) );
//fclose($fp);

if(file_put_contents('../../../psdcwj_'.$wjregID.'.html', chr(0xEF).chr(0xBB).chr(0xBF).ob_get_clean() )){

	echo json_encode(array('code'=>200));
}else{
	echo json_encode(array('code'=>400));
};//index.htmlļ

?>
<?php
mysql_free_result($rsvote);

mysql_close($connjxkh);
?>