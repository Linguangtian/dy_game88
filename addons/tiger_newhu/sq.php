<?php
    $tbuid=$_GET['tbuid'];
    $tkurl=$_GET['tkurl'];//浏览器获取域名
    $tkurl2=$_GET['tkurl2'];//微擎授权域名
    $tkip=$_GET['tkip'];

    //file_put_contents("sq.txt","\ntbuid:".$tbuid."----->>-tkurl:".$tkurl.'-------->>-tkurl2:'.$tkurl2.'---------->>-tkip:'.$tkip,FILE_APPEND);
    
    //weixin.mnsbbs.com 1元购买的，要封掉
    function getdbid($tbid){//盗版程序淘宝ID
       //$arr=array('178625078','852631297','74379094');
       $arr=array('17862507www8','852ww631297','74379www094');
       if(in_array($tbid,$arr)){
          return 2;// '盗版域名';
       }
     }
     
     

     $tb=getdbid($tbuid);
     
     if($tb==2){
        die(json_encode(array('error'=>'2','msg'=>'请联系老虎授权：QQ号1640226229')));
     }else{
        die(json_encode(array('error'=>'1','msg'=>'1')));
     }
    
    //error 1 通过  2盗版
?>