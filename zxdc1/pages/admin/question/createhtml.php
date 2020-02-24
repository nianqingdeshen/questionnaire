<?php
header("Content-type:text/html,charset=utf-8");
/******php静态化*******/
    class textHtml{
        public function fwriteHtml($r){
            /*php页面静态化技术
             *$r [array];
             *route=>生成文件名称及路径
             *html=>需要读取的静态资源
             *stsyem=>要替换的标签
             *content=>标签替换的内容
             * */
             
            $cfill = fopen($r["html"],"r");//读取的文件名
            $cfillnew = fopen($r["route"],"wb");
            while(!feof($cfill)){
                $row = fgets($cfill);
 
 
                $res = str_replace($r["stsyem"],$r["content"],$row);    //替换内容
                
　　　　　　　　fwrite($cfillnew,$res);//写入html文件
            }
            /*关闭文件*/
            fclose($cfill);
            fclose($cfillnew);
        }
    }
     
     
    $f = new textHtml;
    $fillname = microtime().".html";
    $content = "这是一个页面静态化技术";
    $r["route"] = $fillname;
    $r["html"] = "test.html";
    $r["stsyem"] = "%demo%";
    $r["content"] = $content;
     
    $f->fwriteHtml($r);
?>