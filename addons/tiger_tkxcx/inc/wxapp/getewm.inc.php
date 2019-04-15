<?php
  global $_W, $_GPC;
  $weid=$this->wid;//绑定公众号的ID
	$cfg=$this->cfg;//绑定公众号的配置数据
	$tbuid=$this->tbuid;
	$xcxcfg=$this->xcxcfg;
	
	$itemid=$_GPC['itemid'];//商品ID           云商品库商品ID
  $uid=$_GPC['uid'];//用户接口返回的ID
  $itemtitle=$_GPC['itemtitle'];//商品名称
  $itempic=$_GPC['itempic'];//商品图片
  $quan_id=$_GPC['quan_id'];//优惠券ID
  if(empty($itemid)){  	
  	exit(json_encode(array('error'=>1,'msg'=>'商品ID不能为空','url'=>"")));
  }
  if(empty($itemtitle)){
  	exit(json_encode(array('error'=>1,'msg'=>'商品标题不能为空','url'=>"")));
  }
  if(empty($itempic)){
  	exit(json_encode(array('error'=>1,'msg'=>'商品图片不能为空','url'=>"")));
  }
  
	
	$share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$weid}' and id='{$uid}'");
        if($share['dltype']==1){//是代理
			if(empty($share['dlptpid'])){//如果是代理，PID没填写就默认公众号PID
				$s=pdo_fetch("select settings from ".tablename('uni_account_modules')." where module='tiger_newhu' and uniacid='{$weid}'");
	    		$cfg=unserialize($s['settings']);
				$share['dlptpid']=$cfg['ptpid'];
			}
		}else{//不是代理
			if(!empty($share['helpid'])){//查看有没有上级
				$shshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$weid}' and id='{$share['helpid']}'");
				file_put_contents(IA_ROOT."/addons/tiger_tkxcx/v_log.txt","\n helpid1:".$share['helpid']."--------".json_encode($shshare),FILE_APPEND);	
				if(empty($shshare['id'])){//没有上级代理，就用默认的公众号PID
					$s=pdo_fetch("select settings from ".tablename('uni_account_modules')." where module='tiger_newhu' and uniacid='{$weid}'");
		    		$cfg=unserialize($s['settings']);
					$share['dlptpid']=$cfg['ptpid'];
				}else{//有上级代理
					if($shshare['dltype']==1){//如果上级是代理，就用代理的PID
						$share['dlptpid']=$shshare['dlptpid'];
					}else{//上级不是代理就用默认的PID
						$s=pdo_fetch("select settings from ".tablename('uni_account_modules')." where module='tiger_newhu' and uniacid='{$weid}'");
			    		$cfg=unserialize($s['settings']);
						$share['dlptpid']=$cfg['ptpid'];
					}
				}
			}else{//没有上级就用默认公众号PID
				$s=pdo_fetch("select settings from ".tablename('uni_account_modules')." where module='tiger_newhu' and uniacid='{$weid}'");
	    		$cfg=unserialize($s['settings']);
				$share['dlptpid']=$cfg['ptpid'];
			}
			
		}
		$cfg['ptpid']=$share['dlptpid'];
		
		include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php";
		$tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  tbuid='{$tbuid}'");
		
		if(!empty($itemid)){
	  	$turl="https://item.taobao.com/item.htm?id=".$itemid;
	    $res=xcxhqyongjin($turl,$ck,$cfg,'tiger_newhu','','',$tksign['sign'],$tksign['tbuid'],$_W,1,$itemid); 
	  }
	  
	  if(empty($quan_id)){
	  	$rhyurl=$res['dclickUrl']."&activityId=tiger";
	  }else{
	  	$rhyurl=$res['dclickUrl']."&activityId=".$quan_id;
	  }
	  
	  if(!empty($rhyurl)){      	
      	$rhyurl=str_replace("http:","https:",$rhyurl);
        $taokouling=$this->tkl($rhyurl,$itempic,$itemtitle,$cfg);
   }
   
	  $ewmurl="https://tiger888.kuaizhan.com/?image=".urlencode($itempic)."&word=".$taokouling; 
	  
//	  echo $ewmurl;
//	  exit;
	
	
	
	
//$dwz=zydwz(urldecode($_GPC['url']),$_W,$cfg);
//
//function zydwz($turl,$_W,$cfg){//自有短网址        
//      $data=array(
//              'weid'=>$weid,
//              'url'=>$turl,
//              'createtime'=>TIMESTAMP,
//              );
//      pdo_insert("tiger_newhu_dwz",$data);
//      $id = pdo_insertid();        
//      $url=$cfg['zydwz']."t.php?d=".$id;
//      return $url;
//  }
  
  function getermg($url,$path='',$_W,$xcxcfg){//二维码保存到指定分日期保存目录
        empty($path)&&($path = IA_ROOT."/addons/tiger_tkxcx/goodsimg/".date("Ymd"));
        !file_exists($path)&&mkdir ($path, 0777, true );
        if($url == "")return false;
        $sctime=date("YmdHis").sjrd44(6);
        $filename = $path.'/'.$sctime.".png";
        ob_start();
        readfile($url);
        $img = ob_get_contents();
        ob_end_clean();
        $fp = fopen($filename, "a");
        fwrite($fp, $img);
        fclose($fp);
        //return $filename.'-----'."/addons/tiger_newhu/goodsimg/".$sctime.".jpg";//返回文件名
        return $xcxcfg['zdyurl']."addons/tiger_tkxcx/goodsimg/".date("Ymd").'/'.$sctime.".png";//返回文件名
    }
    
  function sjrd44($length = 4){ 
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
            $str = ''; 
            for ($i = 0; $i<$length;$i++ ) 
            {  
                $str .= $chars[mt_rand(0, strlen($chars)-1)]; 
            } 
            return $str; 
        } 
    $url="http://qr.liantu.com/api.php?m=10&w=200&text=".urlencode($ewmurl);
    
   $ewm=getermg($url,'',$_W,$xcxcfg);

     exit(json_encode(array('error'=>0,'msg'=>'OK','url'=>$ewm,'fxurl'=>$ewmurl)));
?>