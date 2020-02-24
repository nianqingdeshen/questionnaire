<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>aes加密</title>
<script src="js/lib/aes.js"></script>
<script src="js/lib/md5.js"></script>
<script src="js/lib/pad-zeropadding-min.js"></script>
<script src="js/lib/jquery.min.js"></script>	
</head>

<body>   

    <form id="form1" name="form1" method="post" action="">
      <table width="400" border="1" align="center">
        <tr>
          <td>ID</td>
          <td><label>
            <input name="username" type="text" id="username" />
          </label></td>
        </tr>
        <tr>
          <td>PWD</td>
          <td><label>
            <input name="password" type="password" id="password" />
          </label></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
        </tr>
      </table>
</form>
<button class="ajax">请求解密</button>
</body>



<script>


    

    $('.ajax').on('click',function(e){

        // 加密
		var data = $("#password").val(); 
		console.log('JS加密前：'+data);
		//var key_hash = CryptoJS.MD5("Message");
    	//var key = CryptoJS.enc.Utf8.parse(key_hash);
    	//var iv  = CryptoJS.enc.Utf8.parse('1234567812345678');
   	 	//var encrypted = CryptoJS.AES.encrypt(data, key, { iv: iv,mode:CryptoJS.mode.CBC,padding:CryptoJS.pad.ZeroPadding});
    	//document.write("encode:"+encrypted);
		 
        

       var iv="1234567812345678";

        var key = CryptoJS.enc.Utf8.parse('1234567887654321');

        var  ivv= CryptoJS.enc.Utf8.parse(iv);
		
		alert(ivv);

        var encrypted = CryptoJS.AES.encrypt(data, key, { iv: ivv, mode: CryptoJS.mode.CBC, padding: CryptoJS.pad.ZeroPadding });

        data = encrypted.toString();
		console.log('JS加密后：'+data);	

        //var msg = {'data':data,'iv':iv};

        //
        $.ajax({
      	url:'aes_decode.php',
      	type:'post',
	  	data:{'data':encrypted,'iv':iv},
      	dataType:'json',      
      	success:function(res){
			var res = JSON.parse(res);
        	console.log('服务器返回加密数据：'+res.questions);
    	}
  	});
	
	

 });

</script>

</html>