<?php
	global $_W, $_GPC;		
		$weid=$this->wid;//绑定公众号的ID
		$cfg=$this->cfg;//绑定公众号的配置数据
		$xcxcfg=$this->xcxcfg;
		
    	include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
        include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
        
		
		$lm=$_GPC['lm'];//列表页获取                            1 联盟  2 云商品库  
        $itemid=$_GPC['itemid'];//商品ID           云商品库商品ID
        $pid=$_GPC['pid'];//用户接口获取 dlptpid
        $uid=$_GPC['uid'];//用户接口返回的ID
        $yj=$_GPC['yj'];//代理佣金，如果没有传过来，就要在这里重新记算，分享的商品过来是没有佣金的传过来的，需要记录
        $tbuid=$this->tbuid;
        file_put_contents(IA_ROOT."/addons/tiger_tkxcx/v_log.txt","\nlm:".$lm."itemid:".$itemid."uid:".$uid,FILE_APPEND);
        
        $getviews=$this->getitemid($itemid,$cfg);
//      echo "<pre>";
//      print_r($getviews);
//      exit;
        
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
		if($share['status']==1){
			$this->shtype=0;
		}
		
		
		file_put_contents(IA_ROOT."/addons/tiger_tkxcx/v_log.txt","\n shareid:".$share['id']."--------".json_encode($share),FILE_APPEND);	
        
        $tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  tbuid='{$tbuid}'");
        $gtxcximg=$this->getxcxewm("tiger_tkxcx/pages/info/index",$itemid,$uid,'',2,0);//小程序二维码链接
        if($lm==2){//云商品库
        	  
        	  $views=getview($itemid);        	  
          	  if(!empty($itemid)){
          	  	$turl="https://item.taobao.com/item.htm?id=".$_GPC['$itemid'];
                $res=xcxhqyongjin($turl,$ck,$cfg,'tiger_newhu','','',$tksign['sign'],$tksign['tbuid'],$_W,1,$itemid); 
          	  }
          	   
          	  $rhyurl=$res['dclickUrl']."&activityId=".$views['quan_id'];
          	  
          	  if(empty($views['itemid'])){
          	  	$this->result(1, '商品不存在', array('data'=>''));     
          	  }else{
          	  	
          	  	if(!empty($rhyurl)){
			      	$tjcontent=$views['itemtitle'];
			      	$rhyurl=str_replace("http:","https:",$rhyurl);
			        $taokouling=$this->tkl($rhyurl,$views['itempic'],$tjcontent,$cfg);
			        $views['taokouling']=$taokouling;
			    }
			     
			        
			        //$views['ewmurl']=urlencode("https://m.baidu.com");
			        
			        $msg=str_replace('#换行#','', $cfg['tklmb']);
					$msg=str_replace('#名称#',"{$views['itemtitle']}", $msg);
					$msg=str_replace('#推荐理由#',"{$views['itemdesc']}", $msg);
					$msg=str_replace('#原价#',"{$views['itemprice']}", $msg);
					$msg=str_replace('#券后价#',"{$views['itemendprice']}", $msg);
					$msg=str_replace('#优惠券#',"{$views['couponmoney']}", $msg);
					$msg=str_replace('#淘口令#',"{$views['taokouling']}", $msg);
					$arr=strstr($views['itempic'],"http");
		            if($arr!==false){
		            	$viewspic=str_replace("http:","https:",$views['itempic']);
		            	$viewspic1=str_replace("http:","https:",$views['itempic']);
		            }else{
		            	$viewspic="https:".$views['itempic']."_250x250.jpg";
		            	$viewspic1="https:".$views['itempic'];
		            }
		            $views['itempic']=$viewspic."_250x250.jpg";
		            $views['itempic1']=$viewspic1;	
		            $views['itempic5']=$getviews['small_images'];
					
					if($xcxcfg['shtype']==1){
						$views['wenan']=$msg;						
					}else{
						$views['wenan']='sh';
					}
			        
			        $views['shtype']=$this->shtype;
			        $views['xcxewm']=$gtxcximg;
			        $views['shversion']=$this->shversion;
			        $views['viewhelpid']=urlencode($xcxcfg['viewhelpid']);
			        $views['yj']=$yj;//代理奖励佣金
			        $views['lm']=$lm;//传过来参数 
			        $views['rhyurl']=$rhyurl;
			        $views['ewmurl']=urlencode($xcxcfg['zdyurl']."app/index.php?i=3&c=entry&do=xcxbdview&m=tiger_newhu&itemid=".$views['itemid']."&itempic=".urlencode($views['itempic'])."&itemtitle=".urlencode($views['itemtitle'])."&tkl=".$views['taokouling']);
			        //$views['ewmurl']=urlencode("https://tiger888.kuaizhan.com/?image=".urlencode($views['itempic'])."&word=".$views['taokouling']);
		            	            
	                $views['pid']=$cfg['ptpid'];
          	  	    $this->result(0, 'OK', array('lm'=>2,'data'=>$views));     
          	  } 
        }elseif($lm==3 || $lm==1){//搜图列表
        	if(!empty($itemid)){
          	  	$turl="https://item.taobao.com/item.htm?id=".$_GPC['$itemid'];
                $res=xcxhqyongjin($turl,$ck,$cfg,'tiger_newhu','','',$tksign['sign'],$tksign['tbuid'],$_W,1,$itemid); 
          	}
          	//$getviews=$this->getitemid($itemid,$cfg);
          	if(empty($res['money'])){
          		$money='';
          	}else{
          		$money=$res['money'];
          	}
          	$views=array(
          		'itemid'=>$itemid,
          		'itemtitle'=>$getviews['title'],
          		'itempic'=>$getviews['pict_url'],
          		'itemprice'=>$getviews['zk_final_price'],
          		'itemendprice'=>$getviews['zk_final_price']-$res['money'],
          		'couponmoney'=>$money,
          		'itemdesc'=>$getviews['title'],
          		'itemsale'=>rand(1000,30000),
          		'videoid'=>'',
          		'itempic5'=>$getviews['small_images'],
          	);
          	if(empty($res['money'])){
          		//$rhyurl=$res['dclickUrl']."&activityId=tiger";
          		$rhyurl=$res['dclickUrl'];
          	}else{
          		$rhyurl=$res['dclickUrl'];
          	}
          	if(!empty($rhyurl)){
		      	$tjcontent=$views['itemtitle'];
		      	$rhyurl=str_replace("http:","https:",$rhyurl);
		        $taokouling=$this->tkl($rhyurl,$views['itempic'],$tjcontent,$cfg);
		        $views['taokouling']=$taokouling;
		    }
		    $msg=str_replace('#换行#','', $cfg['tklmb']);
			$msg=str_replace('#名称#',"{$views['itemtitle']}", $msg);
			$msg=str_replace('#推荐理由#',"{$views['itemdesc']}", $msg);
			$msg=str_replace('#原价#',"{$views['itemprice']}", $msg);
			$msg=str_replace('#券后价#',"{$views['itemendprice']}", $msg);
			$msg=str_replace('#优惠券#',"{$views['couponmoney']}", $msg);
			$msg=str_replace('#淘口令#',"{$views['taokouling']}", $msg);
			$arr=strstr($views['itempic'],"http");
            if($arr!==false){
            	$viewspic=str_replace("http:","https:",$views['itempic']);
            	$viewspic1=str_replace("http:","https:",$views['itempic']);
            }else{
            	$viewspic="https:".$views['itempic']."_250x250.jpg";
            	$viewspic1="https:".$views['itempic'];
            }
            $views['itempic']=$viewspic."_250x250.jpg";
            $views['itempic1']=$viewspic1;	
			if($xcxcfg['shtype']==1){
				$views['wenan']=$msg;						
			}else{
				$views['wenan']='sh';
			}
	        
	        $views['shtype']=$this->shtype;
	        $views['xcxewm']=$gtxcximg;
	        $views['shversion']=$this->shversion;
	        $views['viewhelpid']=urlencode($xcxcfg['viewhelpid']);
	        $views['yj']=$yj;//代理奖励佣金
	        $views['lm']=$lm;//传过来参数        
	        $views['itempic5']=$getviews['small_images'];   	
//        	echo "<pre>";
//        	print_r($res);
//        	print_r($views);
//        	exit;
$views['ewmurl']=urlencode($xcxcfg['zdyurl']."app/index.php?i=3&c=entry&do=xcxbdview&m=tiger_newhu&itemid=".$views['itemid']."&itempic=".urlencode($views['itempic'])."&itemtitle=".urlencode($views['itemtitle'])."&tkl=".$views['taokouling']);
			//$views['ewmurl2']="https://tiger888.kuaizhan.com/?image=".urlencode($views['itempic'])."&word=".$views['taokouling'];
			$views['rhyurl']=$rhyurl;
            $views['pid']=$cfg['ptpid'];
			$this->result(0, 'OK', array('lm'=>0,'data'=>$views));   	
        	
        }else{//自己采集
        	 if(!empty($cfg['gyspsj'])){
                $weid=$cfg['gyspsj'];
              }
              //echo 'aaaa';
               if(!empty($itemid)){
                   //$gtxcximg=$this->getxcxewm("tiger_tkxcx/pages/info/index",$itemid,$uid,'',0,0);
                   $views=pdo_fetch("select * from".tablename("tiger_newhu_newtbgoods")." where weid='{$weid}' and itemid='{$itemid}'");
                   if(!empty($itemid)){
	          	  	 $turl="https://item.taobao.com/item.htm?id=".$_GPC['$itemid'];
	                 $res=xcxhqyongjin($turl,$ck,$cfg,'tiger_newhu','','',$tksign['sign'],$tksign['tbuid'],$_W,1,$itemid); 
	          	   }
                   
                   $rhyurl=$res['dclickUrl']."&activityId=".$views['quan_id'];
                   if(!empty($rhyurl)){
				      	$tjcontent=$views['itemtitle'];
				      	$rhyurl=str_replace("http:","https:",$rhyurl);
				        $taokouling=$this->tkl($rhyurl,$views['itempic'],$tjcontent,$cfg);
				        $views['taokouling']=$taokouling;
				    }
  
			        
			        $msg=str_replace('#换行#','', $cfg['tklmb']);
					$msg=str_replace('#名称#',"{$views['itemtitle']}", $msg);
					$msg=str_replace('#推荐理由#',"{$views['itemdesc']}", $msg);
					$msg=str_replace('#原价#',"{$views['itemprice']}", $msg);
					$msg=str_replace('#券后价#',"{$views['itemendprice']}", $msg);
					$msg=str_replace('#优惠券#',"{$views['couponmoney']}", $msg);
					$msg=str_replace('#淘口令#',"{$views['taokouling']}", $msg);
					if($arr!==false){
		            	$viewspic=str_replace("http:","https:",$views['itempic']);
		            	$viewspic1=str_replace("http:","https:",$views['itempic']);
		            }else{
		            	$viewspic="https:".$views['itempic']."_250x250.jpg";
		            	$viewspic1="https:".$views['itempic'];
		            }
		            $views['itempic']=$viewspic."_250x250.jpg";
		            $views['itempic1']=$viewspic1;	
					if($xcxcfg['shtype']==1){
						$views['wenan']=$msg;						
					}else{
						$views['wenan']='sh';
					}
			        $views['itempic5']=$getviews['small_images'];
			        $views['shtype']=$this->shtype;
			        $views['xcxewm']=$gtxcximg;
			        $views['shversion']=$this->shversion;
			        $views['viewhelpid']=urlencode($xcxcfg['viewhelpid']);
			        $views['yj']=$yj;//代理奖励佣金
			        $views['lm']=$lm;//传过来参数 
			        $views['ewmurl']=urlencode($xcxcfg['zdyurl']."app/index.php?i=3&c=entry&do=xcxbdview&m=tiger_newhu&itemid=".$views['itemid']."&itempic=".urlencode($views['itempic'])."&itemtitle=".urlencode($views['itemtitle'])."&tkl=".$views['taokouling']);
			        //$views['ewmurl']=urlencode("https://tiger888.kuaizhan.com/?image=".urlencode($views['itempic'])."&word=".$views['taokouling']);
          	  	    
                }
                
                //$views['ewmurl']=urlencode($_W['siteroot'].str_replace('./','app/',$this->createMobileurl('tklview',array('itemid'=>$views['itemid'],'itemendprice'=>$views['itemendprice'],'couponmoney'=>$views['couponmoney'],'itempic'=>urlencode($views['itempic']),'tkl'=>$views['taokouling'],'itemprice'=>$views['itemprice'])))."&rhyurl=".$rhyurl."&itemtitle=".urlencode($views['itemtitle']));
                
                
                $views['pid']=$cfg['ptpid'];
                $views['rhyurl']=$rhyurl;
                $this->result(0, 'OK', array('lm'=>0,'data'=>$views));   
        }