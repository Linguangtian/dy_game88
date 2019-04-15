<?php
	//小程序 数据列表
global $_W, $_GPC;
		$weid=$this->wid;//绑定公众号的ID
		$cfg=$this->cfg;//绑定公众号的配置数据
		$xcxcfg=$this->xcxcfg;//小程序配置
		$httpsurl=$cfg['tknewurl'];
		
		//$_GPC['key']='华礼  门电子  烟大  烟雾正品';
		//$_GPC['key']=str_replace(' ','',$_GPC['key']);
		
		include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
		$arr=getfc($_GPC['key'],'');
        foreach($arr as $v){
             if (empty($v)) continue;
            $aaa.=$v;
        }
        $_GPC['key']=$aaa;

		$px=$_GPC['px'];
		$zt=$_GPC['zt'];//专题
		$type=$_GPC['type'];
		$tm=$_GPC['tm'];
		$price1=$_GPC['price1'];
		$price2=$_GPC['price2'];
		$hd=$_GPC['hd'];
		$page=$_GPC['page'];
		$key=$_GPC['key'];
		$dlyj=$_GPC['dlyj'];
		$pid=$_GPC['pid'];
		$dluid=$_GPC['dluid'];
        $rate=$_GPC['rate'];
        $uid=$_GPC['uid'];
        
        
        
        
		file_put_contents(IA_ROOT."/addons/tiger_tkxcx/key_log.txt","\n old0:".$aaa,FILE_APPEND);
//    
//     file_put_contents(IA_ROOT."/addons/tiger_tkxcx/key_log.txt","\n1".json_encode($arr),FILE_APPEND);
        $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$weid}'");
        
        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$weid}' and id='{$uid}'");
        if($share['status']==1){
			$this->shtype=0;
		}
//		echo "<pre>";
//		print_r($share);
//		exit;	
        
        $fs=$this->jcbl($share,$bl);
        if(empty($share['dlbl'])){
          $dlbl=$bl['dlbl1'];
        }else{
          $dlbl=$fs['bl'];
        }
        
        $key=preg_replace('# #','',$key);
        
        $arr=strstr($key,"￥");
        if($arr!==false){
            $jxtitle=$this->tkljx($key,$cfg);
			$key=$jxtitle['content'];	
			$key=$this->tklresp($key);
        }
        file_put_contents(IA_ROOT."/addons/tiger_tkxcx/key_log.txt","\n old:".$key,FILE_APPEND);
		
		
        
        if($cfg['mmtype']==2){//云商品库
			include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
		    $list=getcatlist($type,$px,$tm,$price1,$price2,$hd,$page,$key,$dlyj,$pid,$cfg,$rate);
		 
		    if(empty($list['data'])){
				$status=2;
			}else{
				$status=1;//有数据
			}
            $list1=array();
            foreach($list['data'] as $k=>$v){
            	if(empty($v['couponmoney'])){
            		continue;
            	}
            	
            				$arr=strstr($v['itempic'],"http");
            	            if($arr!==false){
            	            	$itempic=str_replace("http:","https:",$v['itempic'])."_250x250.jpg";
            	            	$itempic1=str_replace("http:","https:",$v['itempic'])."";
            	            }else{
            	            	$itempic="https:".$v['itempic']."_250x250.jpg";
            	            	$itempic1="https:".$v['itempic']."";
            	            }
            	            if(!empty($xcxcfg['shareimg'])){
            	            	$shareimg=$_W['attachurl'].$xcxcfg['shareimg'];
            	            }else{
            	            	$shareimg='';
            	            }
            	            
            	            //代理佣金显示
//          	            if($share['dltype']==1){
//          	            	if($xcxcfg['dlxsyj']==1){//代理显示佣金 1显示
//	            	            	$dlyj=($v['tkrates']*$v['itemendprice']/100);
//	            	            	
//					                if(!empty($bl['dlkcbl'])){
//					                  $dlyj=$dlyj*(100-$bl['dlkcbl'])/100;
//					                }				                
//				                    $yj=number_format($dlyj*$dlbl/100,2);//代理佣金
//					                $yj="奖".$yj;	
//	            	            }else{
//	            	            	$yj='';
//	            	            }  
//          	            }else{
//          	            	$yj='';
//          	            }
							if($xcxcfg['dlxsyj']==1){
								$yj="奖".$this->sharejl($v['itemendprice'],$v['tkrates'],$bl,$share,$cfg); 
							}elseif($xcxcfg['dlxsyj']==2){
								if($share['dltype']==1){//只显示代理的
									$yj="奖".$this->sharejl($v['itemendprice'],$v['tkrates'],$bl,$share,$cfg); 
								}else{
									$yj='';
								}
							}else{
								$yj='';
							} 	            
		                    //代理佣金显示结束
                    
                            $list1[$k]['itemtitle']=$v['itemtitle'];               			
                            $ratea=($v['itemendprice']*$v['tkrates']/100)*$rate/100;             			
                            $list1[$k]['rate']=$ratea;
                            $list1[$k]['weid']=$v['weid'];
                            $list1[$k]['fqcat']=$v['fqcat'];
                            $list1[$k]['zy']=$v['zy'];
                            $list1[$k]['quan_id']=$v['quan_id'];
                            $list1[$k]['itemid']=$v['itemid'];
                            $list1[$k]['itemtitle']=$v['itemtitle'];
                            $list1[$k]['itemshorttitle']=$v['itemshorttitle'];
                            $list1[$k]['itemdesc']=$v['itemdesc'];
                            $list1[$k]['itemprice']=$v['itemprice'];
                            $list1[$k]['itemsale']=$v['itemsale'];
                            $list1[$k]['itemsale2']=$v['itemsale2'];
                            $list1[$k]['conversion_ratio']=$v['conversion_ratio'];
                            $list1[$k]['itempic']=$itempic;
                            $list1[$k]['itempic1']=$itempic1;
                            $list1[$k]['itemendprice']=$v['itemendprice'];
                            $list1[$k]['shoptype']=$v['shoptype'];
                            $list1[$k]['userid']=$v['userid'];
                            $list1[$k]['sellernick']=$v['sellernick'];
                            $list1[$k]['tktype']=$v['tktype'];
                            $list1[$k]['tkrates']=$v['tkrates'];
                            $list1[$k]['ctrates']=$v['ctrates'];
                            $list1[$k]['cuntao']=$v['cuntao'];
                            $list1[$k]['tkmoney']=$v['tkmoney'];
                            $list1[$k]['tkurl']=$v['tkurl'];
                            $list1[$k]['couponurl']=$v['couponurl'];
                            $list1[$k]['planlink']=$v['planlink'];
                            $list1[$k]['couponmoney']=$v['couponmoney'];
                            $list1[$k]['couponsurplus']=$v['couponsurplus'];
                            $list1[$k]['couponreceive']=$v['couponreceive'];
                            $list1[$k]['couponreceive2']=$v['couponreceive2'];
                            $list1[$k]['couponnum']=$v['couponnum'];
                            $list1[$k]['couponexplain']=$v['couponexplain'];
                            $list1[$k]['couponstarttime']=$v['couponstarttime'];
                            $list1[$k]['couponendtime']=$v['couponendtime'];
                            $list1[$k]['starttime']=$v['starttime'];
                            $list1[$k]['isquality']=$v['isquality']; 
                            $list1[$k]['item_status']=$v['item_status'];
                            $list1[$k]['report_status']=$v['report_status'];
                            $list1[$k]['is_brand']=$v['is_brand'];
                            $list1[$k]['is_live']=$v['is_live'];
                            $list1[$k]['videoid']=$v['videoid'];
                            $list1[$k]['activity_type']=$v['activity_type'];
                            $list1[$k]['createtime']=$v['createtime'];
                            $list1[$k]['lm']=2;//2云商品库    0自己采集   1联盟商品
                            $list1[$k]['shtype']=$this->shtype;
                            $list1[$k]['shversion']=$this->shversion;
                            $list1[$k]['shareimg']=$shareimg;
                            $list1[$k]['yj']=$yj;//代理佣金奖励：22
                
           }
          
			//exit(json_encode(array('pages' =>ceil(1000/20), 'data' =>$list1,'lm'=>2)));
			//$this->result(0, 'OK', array('lm'=>2,'data'=>$list1));
		}else{//自己采集
			//分词搜索
			if(!empty($_GPC['key'])){	             
	             $arr=getfc($_GPC['key'],$_W);
	            	foreach($arr as $v){
		                 if (empty($v)) continue;
		                $where.=" and itemtitle like '%{$v}%'";
		            }
	        }
	        
	     

            if(!empty($cfg['gyspsj'])){
               $weid=$cfg['gyspsj'];
             }
	
	        
	        if(empty($_GPC['px'])){
	          $orde='createtime desc';
	        }elseif($_GPC['px']==1){
	          $orde='itemsale desc';
	        }elseif($_GPC['px']==2){
	          $orde='itemendprice asc';
	        }elseif($_GPC['px']==3){
	          $orde='tkrates desc';
	        }elseif($_GPC['px']==4){
	          $orde='couponmoney desc';
	        }
	        if(!empty($_GPC['tm'])){
	          $where.=" and shoptype='B'";
	        }
	        if(!empty($_GPC['hd'])){//1聚划算  2淘抢购
	           if($_GPC['hd']==1){
	             $where.=" and activity_type='聚划算'";
	           }elseif($_GPC['hd']==2){
	             $where.=" and activity_type='淘抢购'";
	           }elseif($_GPC['hd']==3){//秒杀
	             $where.=" and tj=1";
	           }elseif($_GPC['hd']==4){//叮咚抢
	             $where.=" and tj=2";
	           }elseif($_GPC['hd']==5){//视频单
	             $where.=" and videoid <>0";
	           }elseif($hd==10){
			   	  $where.=" and couponmoney>50";
			   }elseif($hd==11){
			   	 	$where.=" and itemendprice<10";
			   }elseif($hd==12){
			   	 	$where.=" and itemendprice<=30 and itemendprice>=10";
			   }
	        }
	        if(!empty($_GPC['price1'])){
	           $where.=" and itemendprice>".$_GPC['price1'];
	        }
	        if(!empty($_GPC['price2']) and !empty($_GPC['price1'])){
	           $where.=" and itemendprice<".$_GPC['price2'];
	        }
	        if(!empty($_GPC['price2']) and empty($_GPC['price1'])){
	           	$where.=" and itemendprice<".$_GPC['price2'];
	        }
	        if(!empty($zt)){
	        	$where.=" and zt='{$zt}'";
	        }
	        if(!empty($type)){
	        	$where.=" and fqcat='{$type}'";
	        }
	        
	        $day=date("Y/m/d",time());
            $dtime=strtotime($day);
	        
	        $page=$page;
            $pindex = max(1, intval($page));
		    $psize = 20;

            $list = pdo_fetchall("select * from ".tablename("tiger_newhu_newtbgoods")." where weid='{$weid}' and couponendtime>={$dtime} {$where} order by {$orde} LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
                  
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_newtbgoods')." where couponendtime>={$dtime} and  weid='{$weid}' {$where}");
            if(empty($list)){
				$status=2;
			}else{
				$status=1;//有数据
			}
            $list1=array();
            foreach($list as $k=>$v){
            	if(empty($v['couponmoney'])){
		    		continue;
		    	}
		            		//代理佣金显示	
//		            		if($share['dltype']==1){
//		            			if($xcxcfg['dlxsyj']==1){//代理显示佣金 1显示
//			                    	$dlyj=($v['tkrates']*$v['itemendprice']/100);
//					                if(!empty($bl['dlkcbl'])){
//					                  $dlyj=$dlyj*(100-$bl['dlkcbl'])/100;
//					                }
//				                    $yj=number_format($dlyj*$dlbl/100,2);//代理佣金
//				                    $yj="奖".$yj;	
//			                    }else{
//			                    	$yj='';
//			                    }
//		            		}else{
//		            			$yj='';
//		            		}	                    
							if($xcxcfg['dlxsyj']==1){
								$yj="奖".$this->sharejl($v['itemendprice'],$v['tkrates'],$bl,$share,$cfg); 
							}elseif($xcxcfg['dlxsyj']==2){
								if($share['dltype']==1){//只显示代理的
									$yj="奖".$this->sharejl($v['itemendprice'],$v['tkrates'],$bl,$share,$cfg); 
								}else{
									$yj='';
								}
							}else{
								$yj='';
							} 	
		                    
		                    //代理佣金显示结束
                    
            				$arr=strstr($v['itempic'],"http");
            	            if($arr!==false){
            	            	$itempic=str_replace("http:","https:",$v['itempic'])."_250x250.jpg";
            	            	$itempic1=str_replace("http:","https:",$v['itempic'])."";
            	            }else{
            	            	$itempic="https:".$v['itempic']."_250x250.jpg";
            	            	$itempic1="https:".$v['itempic']."";
            	            }
            	            if(!empty($xcxcfg['shareimg'])){
            	            	$shareimg=$_W['attachurl'].$xcxcfg['shareimg'];
            	            }else{
            	            	$shareimg='';
            	            }
                            $list1[$k]['itemtitle']=$v['itemtitle'];               			
                            $ratea=($v['itemendprice']*$v['tkrates']/100)*$rate/100;             			
                            $list1[$k]['rate']=number_format($ratea,2,".","");
                            $list1[$k]['weid']=$v['weid'];
                            $list1[$k]['fqcat']=$v['fqcat'];
                            $list1[$k]['zy']=$v['zy'];
                            $list1[$k]['quan_id']=$v['quan_id'];
                            $list1[$k]['itemid']=$v['itemid'];
                            $list1[$k]['itemtitle']=$v['itemtitle'];
                            $list1[$k]['itemshorttitle']=$v['itemshorttitle'];
                            $list1[$k]['itemdesc']=$v['itemdesc'];
                            $list1[$k]['itemprice']=$v['itemprice'];
                            $list1[$k]['itemsale']=$v['itemsale'];
                            $list1[$k]['itemsale2']=$v['itemsale2'];
                            $list1[$k]['conversion_ratio']=$v['conversion_ratio'];
                            $list1[$k]['itempic']=$itempic;
                            $list1[$k]['itempic1']=$itempic1;
                            $list1[$k]['itemendprice']=$v['itemendprice'];
                            $list1[$k]['shoptype']=$v['shoptype'];
                            $list1[$k]['userid']=$v['userid'];
                            $list1[$k]['sellernick']=$v['sellernick'];
                            $list1[$k]['tktype']=$v['tktype'];
                            $list1[$k]['tkrates']=$v['tkrates'];
                            $list1[$k]['ctrates']=$v['ctrates'];
                            $list1[$k]['cuntao']=$v['cuntao'];
                            $list1[$k]['tkmoney']=$v['tkmoney'];
                            $list1[$k]['tkurl']=$v['tkurl'];
                            $list1[$k]['couponurl']=$v['couponurl'];
                            $list1[$k]['planlink']=$v['planlink'];
                            $list1[$k]['couponmoney']=$v['couponmoney'];
                            $list1[$k]['couponsurplus']=$v['couponsurplus'];
                            $list1[$k]['couponreceive']=$v['couponreceive'];
                            $list1[$k]['couponreceive2']=$v['couponreceive2'];
                            $list1[$k]['couponnum']=$v['couponnum'];
                            $list1[$k]['couponexplain']=$v['couponexplain'];
                            $list1[$k]['couponstarttime']=$v['couponstarttime'];
                            $list1[$k]['couponendtime']=$v['couponendtime'];
                            $list1[$k]['starttime']=$v['starttime'];
                            $list1[$k]['isquality']=$v['isquality']; 
                            $list1[$k]['item_status']=$v['item_status'];
                            $list1[$k]['report_status']=$v['report_status'];
                            $list1[$k]['is_brand']=$v['is_brand'];
                            $list1[$k]['is_live']=$v['is_live'];
                            $list1[$k]['videoid']=$v['videoid'];
                            $list1[$k]['activity_type']=$v['activity_type'];
                            $list1[$k]['createtime']=$v['createtime'];
                            $list1[$k]['lm']=0;//2云商品库    0自己采集   1联盟商品
                            $list1[$k]['shtype']=$this->shtype;
                            $list1[$k]['shversion']=$this->shversion;
                            $list1[$k]['shareimg']=$shareimg;
                            $list1[$k]['yj']=$yj;//代理佣金奖励：22
                
           }
			//exit(json_encode(array('pages' =>ceil(1000/20), 'data' =>$list1,'lm'=>0)));
			//$this->result(0, 'OK', array('lm'=>0,'data'=>$list1));
		}
		//自己采集结束
	
		
		$this->result(0, 'OK', array('lm'=>'','data'=>$list1));
?>