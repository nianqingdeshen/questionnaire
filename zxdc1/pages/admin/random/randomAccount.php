<?php

$xiaoji = 0;	//校领导
$zhongzheng = 1;//中层正职领导
$zhongfu = 2;	//中层副职领导
$keji = 3;		//科级干部
$jiaogong = 4;	//教职工

//每个部门各个职级的人数
$xiaojiNum = 0;
$zhongzhengNum = 2;
$zhongfuNum = 3;
$kejiNum = 15;
$jiaogongNum = 40;

//生成密码
 function random_str($length) {
        // 密码字符集，可任意添加你需要的字符
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for($i = 0; $i < $length; $i++)
        {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
	
//生成账号
function shengcheng($level,$i,$num){
	for($j=0;$j<$num;$j++){
		if($i<10){
			$id = $level."0".$i.rand(100000,999999);
		}
		else{
			$id = $level.$i.rand(100000,999999);
		}
		$passwd=random_str(8);
		echo "账号：".$id."  密码：".$passwd."<br />";
	}	
}

for($i = 1;$i<=57;$i++){
	echo "部门".$i."<br />";
	
	echo " 正职领导<br />";
	shengcheng($zhongzheng,$i,$zhongzhengNum);

	echo "副职领导<br />";
		shengcheng($zhongfu,$i,$zhongfuNum);
	
	echo "科级领导<br />";
		shengcheng($keji,$i,$kejiNum);
	
	echo "教工<br />";
		shengcheng($jiaogong,$i,$jiaogongNum);
}


?>