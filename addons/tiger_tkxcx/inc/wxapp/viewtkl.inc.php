<?php
	global $_W, $_GPC;		
		$weid=$this->wid;//绑定公众号的ID
		$cfg=$this->cfg;//绑定公众号的配置数据
		$xcxcfg=$this->xcxcfg;
		
    	include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
		
		$lm=$_GPC['lm'];//列表页获取                            1 联盟  2 云商品库   0自己
        $itemid=$_GPC['itemid'];//商品ID           云商品库商品ID
        $uid=$_GPC['uid'];//用户接口返回的ID
        $itempic=$_GPC['itempic'];//商品图片
        $itemtitle=$_GPC['itemtitle'];//商品标题
        $quan_id=$_GPC['quan_id'];//优惠券ID
        
        $tbuid=$this->tbuid;
        file_put_contents(IA_ROOT."/addons/tiger_tkxcx/v_log.txt","\nlm:".$lm."----itemid:".$itemid."----uid:".$uid."----itempic:".$itempic."----itemtitle:".$itemtitle."----quan_id:".$quan_id,FILE_APPEND);
        
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
		
		file_put_contents(IA_ROOT."/addons/tiger_tkxcx/v_log.txt","\n shareid:".$share['id']."--------".json_encode($share),FILE_APPEND);
		
	  	  if(!empty($itemid)){
	  	  	$tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  tbuid='{$tbuid}'");
	  	  	$turl="https://item.taobao.com/item.htm?id=".$_GPC['$itemid'];
	        $res=xcxhqyongjin($turl,$ck,$cfg,'tiger_newhu','','',$tksign['sign'],$tksign['tbuid'],$_W,1,$itemid); 
	        //$rhyurl=$res['dclickUrl']."&activityId=".$views['quan_id'];
	        $rhyurl=$res['dclickUrl'];	        
	        if(!empty($rhyurl)){
		      	$rhyurl=str_replace("http:","https:",$rhyurl);
		        $taokouling=$this->tkl($rhyurl,$itempic,$itemtitle,$cfg);
		        $tkl=$taokouling;
		    }else{
		    	$this->result(1, '生成口令错误2 rhy！', array('data'=>''));  
		    }
		    $data=array(
		    	'tkl'=>	$tkl,
		    	'viewhelpid'=>urlencode($xcxcfg['viewhelpid']),
		    );
		    $this->result(0, 'OK', array('data'=>$data)); 
	  	  }else{
	  	  		$this->result(1, '生成口令错误1 NOID！', array('data'=>''));  
	  	  }