<?php

$msg2 ="Message"; $_POST['data'];
echo $msg2;

$key = md5($msg2);  //key�ĳ��ȱ���16��32λ,����ֱ��MD5һ������Ϊ32λ��key
$iv='1234567812345678';
$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $text, MCRYPT_MODE_CBC, $iv);
$decode = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $crypttext, MCRYPT_MODE_CBC, $iv);
echo base64_encode($crypttext);
echo "<br/>";
echo $decode;
echo "<br/>";


$result = [

    'questions' => $decode,

    'key' => $iv

];

echo json_encode($result);	




?>