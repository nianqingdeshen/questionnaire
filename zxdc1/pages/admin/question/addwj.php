
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>新问卷登记</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="keywords" content="lyc2688">
  <meta name="description" content="lyc2688">
 
<link rel="stylesheet" type="text/css" href="../../../lib/layui245/css/layui.css">

<script type="text/javascript" src="../../../lib/jquery-3.2.1.js"></script>
<script type="text/javascript" src="../../../lib/layui245/lay/modules/layer.js"></script>
<script type="text/javascript">
 $(function(){
   $("#send").click(function(){
	var wjname=$("#wjName").val();
	var wjfield=$("#wjField").val();	
	
	if (wjname.length<4){
		layer.msg("问卷名称不能少于4个字符");
		return false;
		}
		
	if(wjfield.length<=4){
		layer.msg("问卷用途不能少于4个字符");
		return false;
		}
		
	
							
    var cont = $("input").serialize();
	//alert(cont);
    $.ajax({
      url:'savewj.php',
      type:'post',
      dataType:'json',
      data:cont,
      success:function(data){
		   var str = "ok";
		  if(data.code==200)
		       str = "添加问卷成功。";	
		  else 
			  str = "添加问卷失败。";
       $("#result").val(str);
      
    }
  });
 }); 
 });
</script>
</head>
<body>
<div>
<form class="layui-form" action=""  method="post">
<div class="layui-row">
	<div class="layui-col-md1"> &nbsp;</div>
	
		<div class="layui-form-item" >
        	<div class="layui-inline">
      	    	 <label class="layui-form-label" >返回结果：</label>             
	            <div class="layui-input-inline">    	  
	            	<input type="text" name="result"  id="result" autocomplete="off" placeholder="" class="layui-input" />
      	     	</div>
             </div>
        </div>
	<div class="layui-col-md7">&nbsp;</div>
</div>
   <div class="layui-row layui-col-space1">
      <div class="layui-form-item">
        <label class="layui-form-label">问卷名称：</label>
        <div class="layui-input-inline">
          <input type="text" name="wjName" id="wjName"  autocomplete="off" placeholder="请输入问卷名称" class="layui-input">
        </div>
      </div>
    
    
  </div>
  <div class="layui-row layui-col-space1">
      <div class="layui-form-item">
        <label class="layui-form-label">问卷用途：</label>
        <div class="layui-input-inline">
          <input type="text" name="wjField"  id="wjField"  autocomplete="off" placeholder="请输入问卷用途" class="layui-input">

        </div>
      </div>
   
    
  </div>
  
</form>
</div>
<div class="layui-row">
	<div class="layui-col-md1"> &nbsp;</div>
		<div class="layui-form-item">
 			<div class="layui-input-block">
				<button class="layui-btn " id="send">登记新问卷</button>
    		</div>
		</div>
	<div class="layui-col-md7">&nbsp;</div>
</div>



</body>
</html>