
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>调查问卷信息</title>
<link rel="stylesheet" type="text/css" href="../../../lib/layui245/css/layui.css"/>
<script type="text/javascript" src="../../../lib/layui245/layui.js"></script>
</head>

<body>
<div class="my-btn-box">    
    <span class="fr">
        <div class="demoTable">
            <span class="layui-form-label">搜索条件：</span>
            <!--// 搜索ID：-->
        <div class="layui-inline">
         <input class="layui-input" name="id" id="demoReload" autocomplete="off" placeholder="请输入搜索条件">
        </div>
        <button class="layui-btn" data-type="reload">查询</button>
		<span class="fl">        
        		<a class="layui-btn btn-add btn-default" id="btn-add">添加新问卷</a>
        
    		</span>
        </div>
    </span>
</div>
<table class="layui-hide" id="test" lay-filter="test"></table>
<script type="text/html" id="barDemo">
	
	<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="modi">修改问卷题目</a>
	<a class="layui-btn layui-btn-xs" lay-event="preview">预览问卷</a>
   <a class="layui-btn layui-btn-xs" lay-event="generate">生成静态问卷</a>
  
  <a class="layui-btn layui-btn-xs" lay-event="editreg">修改问卷登记信息</a>  
</script>
<script>
layui.use(['table', 'layer', 'form'], function(){
   var form = layui.form
            , table = layui.table
            , layer = layui.layer
            , $ = layui.jquery

  
  //第一个实例
   var tableIns =table.render({
    elem: '#test'
    ,height: 542
    ,url: 'wjdata.php' //数据接口
    ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
      layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
      //,curr: 5 //设定初始在第 5 页
      ,groups: 1 //只显示 1 个连续页码
      ,first: false //不显示首页
      ,last: false //不显示尾页
      
    }
    ,cols: [[ //表头
       {field: 'wjregID', title: '序号', width:100, sort: true, fixed: 'left'}
      ,{field: 'wjName', title: '问卷名称', width:200}      
      ,{field: 'wjField', title: '用途', width:200} 
	      
	  ,{fixed: 'right', title:'操作', toolbar: '#barDemo', width:500}     
    ]]
  });
  
  
   //搜索功能的实现
        $('.demoTable .layui-btn').on('click', function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });

        var $ = layui.$, active = {
            reload: function () {
                var demoReload = $('#demoReload').val();
				//layer.msg(demoReload);

                //执行重载
                table.reload('test',
                          {
							   page:
                                  {
                                      curr: 1 //重新从第 1 页开始
                                  }
                        
                        , url: 'getwj.php?wjName='+demoReload //后台做模糊搜索接口路径
                        
                          });
            }
        };
        

        // 刷新表格
        $('#btn-refresh').on('click', function () {
            tableIns.reload()
        });

  
  
     //监听行工具事件
  table.on('tool(test)', function(obj){
   			var data = obj.data;
    		//console.log(obj)
    		if(obj.event === 'modi'){
    			  var wjregID=data.wjregID;
					//alert(wjregID);
					/*var wjregID=2;*/
      				var index=layer.open({
        			type: 2,
        			title: false,
        			shade: [0.5],
        			title: '问卷题目',
        			shadeClose: true,
        			shade: 0.5,
					skin: 'demo-class',
       				maxmin: true, //开启最大化最小化按钮
        			area: ['1300px', '890px'],
        			shift: 2,
        			content: 'questionlist.php?wjregID='+wjregID //iframe的url
      			});    
				layer.full(index);
				} 
				else if(obj.event === 'preview'){
					var wjregID=data.wjregID;
					//alert(wjregID);
					/*var wjregID=2;*/
      				var index1=layer.open({
        			type: 2,
        			title: false,
        			shade: [0.5],
        			title: '问卷详情',
        			shadeClose: true,
        			shade: 0.5,
					skin: 'demo-class',
       				maxmin: true, //开启最大化最小化按钮
        			area: ['1100px', '890px'],
        			shift: 2,
        			content: 'questionView.php?wjregID='+wjregID //iframe的url
     			 });
				 layer.full(index1);
    		 }
			 
			else if(obj.event === 'generate'){
					layer.confirm('启动生成吗', function(index){
        			//obj.del();
        			console.log(obj);
        	 		console.log(data);
        			//layer.close(index);
         			$.ajax({
                		url: "generatewj.php",
                		type: "POST",
                		data:{'wjregID':data.wjregID},
                		dataType: "json",
               			success: function(data){            
                    		if(data.code==400){
                     			layer.msg("生成问卷失败", {icon: 5});                        
                    		}else{                      
                       			//删除这一行
                        		obj.del();
                       			//关闭弹框
                        		layer.close(index);
                        		layer.msg("生成问卷成功", {icon: 6});
                        		  layer.closeAll();
			                    parent.location.reload();
                        		Load(); //删除完需要加载数据
                   			 }
                		},
                		error:function(){
                			alert('error');
                		},
 
            		});
      			});   
    		 }
			 else if(obj.event === 'editreg'){
   
      				var wjregID=data.wjregID;
					//alert(wjregID);
					/*var wjregID=2;*/
      				layer.open({
        			type: 2,
        			title: false,
        			shade: [0.5],
        			title: '修改问卷登记',
        			shadeClose: true,
        			shade: 0.5,
					skin: 'demo-class',
       				maxmin: true, //开启最大化最小化按钮
        			area: ['400px', '300px'],
        			shift: 2,
        			content: 'updatewj.php?wjregID='+wjregID //iframe的url
      			});   
   			 } 
	
  });
  
  //添加问卷
        $('#btn-add').on('click', function () {
            layer.open({
                type: 2,
                title: '添加新问卷',
                maxmin: true,
                area: ['440px', '300px'],
                shadeClose: false, //点击遮罩不会关闭
                content: 'addwj.php',//添加设备的from表单是在另一个html中，这是弹出方式的第三种方式
            });
        });
  
});
</script>e
</body>
</html>
