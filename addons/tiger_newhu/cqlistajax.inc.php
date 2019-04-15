<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];
       include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
       $page=$_GPC['limit'];
       $lm=$_GPC['lm'];
       $lx=$_GPC['lx'];
       $pid=$_GPC['pid'];
       if(empty($pid)){
         $pid=$cfg['ptpid'];
       }

       $_GPC['key']=str_replace("[emoji=EFBFBC]","",$_GPC['key']);
       

       $goods=getgoodslist($_GPC['key'],'',$_W,$page,$cfg,$lx);
       $key=$_GPC['key'];
      if(empty($goods)){
         $status=2;
      }else{
            foreach($goods as $k=>$v){
                $title=str_replace("<span class=H>","",$v->title);
                $title=str_replace("</span>","",$title);
                 $list[$k]['title']=$title;  
                 $list[$k]['istmall']=$v->userType;  
                 $list[$k]['num_iid']=$v->auctionId;
                 $list[$k]['org_price']=$v->zkPrice;
                 $list[$k]['price']=$v->zkPrice-$v->couponAmount;
                 $list[$k]['coupons_price']=$v->couponAmount;
                 $list[$k]['goods_sale']=$v->biz30day;
                 $list[$k]['url']=$v->auctionUrl;
                 $list[$k]['pic_url']='http:'.$v->pictUrl;
                 $list[$k]['pid']=$pid;
           }
           $status=1;
      }

       //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--aaa.txt","\n".$goods,FILE_APPEND);
       //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--aaa.txt","\n".json_encode($status),FILE_APPEND);


       exit(json_encode(array('status' => $status, 'content' => $list,'lm'=>1)));
?>