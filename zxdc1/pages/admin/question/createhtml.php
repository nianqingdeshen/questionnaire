<?php
header("Content-type:text/html,charset=utf-8");
/******php��̬��*******/
    class textHtml{
        public function fwriteHtml($r){
            /*phpҳ�澲̬������
             *$r [array];
             *route=>�����ļ����Ƽ�·��
             *html=>��Ҫ��ȡ�ľ�̬��Դ
             *stsyem=>Ҫ�滻�ı�ǩ
             *content=>��ǩ�滻������
             * */
             
            $cfill = fopen($r["html"],"r");//��ȡ���ļ���
            $cfillnew = fopen($r["route"],"wb");
            while(!feof($cfill)){
                $row = fgets($cfill);
 
 
                $res = str_replace($r["stsyem"],$r["content"],$row);    //�滻����
                
����������������fwrite($cfillnew,$res);//д��html�ļ�
            }
            /*�ر��ļ�*/
            fclose($cfill);
            fclose($cfillnew);
        }
    }
     
     
    $f = new textHtml;
    $fillname = microtime().".html";
    $content = "����һ��ҳ�澲̬������";
    $r["route"] = $fillname;
    $r["html"] = "test.html";
    $r["stsyem"] = "%demo%";
    $r["content"] = $content;
     
    $f->fwriteHtml($r);
?>