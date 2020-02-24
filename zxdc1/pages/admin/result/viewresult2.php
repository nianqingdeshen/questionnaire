<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="../../../lib/layui245/css/layui.css">
<script type="text/javascript" src="../../../lib/layui245/layui.js"></script>
</head>

<body>
<table class="layui-hide" id="test"  lay-filter="test"></table>
<script>
layui.use(['table', 'layer', 'form'], function(){
   var form = layui.form;
   var table = layui.table;
    var layer = layui.layer;
   var $ = layui.jquery;

  
  //第一个实例
   table.render({
    elem: '#test'
    ,height: 800
	,toolbar:true
    ,url: 'getkhresult2.php' //数据接口
    ,page: false
    ,cols: [[ //表头
       {field: 'Account', title: '工号', width:100, sort: true, fixed: 'left'}
      ,{field: 'UserName', title: '姓名', width:100, align:'center'} 
	  ,{field: 'DeptName', title: '部门', width:200}      
      ,{field: 'xld', title: '学校领导测评',  width:120, align:'center'}      
      ,{field: 'bmm', title: '单位职工测评', width:120, align:'center'}
      ,{field: 'zc', title: '处级干部互评', width:120, align:'center'}
      ,{field: 'bzf', title: '班子考核得分', width:120, align:'center'}
      ,{field: 'result', title: '综合考核结果', width:120, align:'center'}  
	     
    ]]
  });
});

</script>	
</body>
</html>
