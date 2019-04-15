<?php
/**
 * 微信淘宝客模块微站定义
 *
 * @author 老虎
 * @url http://bbs.we7.cc/
 */
defined ( 'IN_IA' ) or exit ( 'Access Denied' );
require_once IA_ROOT.'/addons/tiger_newhu/lib/excel.php';
require_once IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/TopSdk.php";

class tiger_newhuModuleSite extends WeModuleSite {
    public $table_request = "tiger_newhu_request";
    public $table_goods = "tiger_newhu_goods";
    public $table_ad = "tiger_newhu_ad";
    private static $t_sys_member = 'mc_members';
    

   public function __construct() {
   	  session_start();
   	   global $_W, $_GPC;
   	   $c=$_GPC['c'];
   	   $do=$_GPC['do'];
   	   $cfg = $this->module['config'];
   	   if($c=='site'){     	   
	       $host=$_SERVER['HTTP_HOST'];
	       $host=strtolower($host);
	       $tbuid=$cfg['tbuid'];	
	       $tkurl1=urlencode($host);
	       $tkurl2=urlencode($_W['setting']['site']['url']);
	       //echo $this->get_server_ip();
           $tkip=$this->get_server_ip();	
	       $url="http://api1.laohucms.com/sq.php?tbuid=".$tbuid."&tkurl=".$tkurl1."&tkurl2=".$tkurl2."&tkip=".$tkip;
	       $aa=$this->curl_request($url);
	       $arr= @json_decode($aa, true);
	       if($arr['error']==2){
	       	  echo $arr['msg'];
	       	  exit;
	       }
   	   }

	   $cfg = $this->module['config'];
	   if(!empty($cfg['tknewurl'])){
	   	  if($c=='entry'){
	   	  	$_W['siteroot']=$cfg['tknewurl'];
	   	  }
       }
//     session_unset();
//		session_destroy();
//       echo "<pre>";
//       print_r($_SESSION);
//       exit;
//     
       if($c=='entry'){
       	  if($cfg['logintype']==1){//开启强制登录
       	  	  if(empty($_SESSION['tkuid'])){      	  	  	
       	  	  	 $tktzurl=$_W['siteurl']; 
       	  	  	 $loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
       	  	  	 if($do!='login' and $do!='bdlogin' and $do!='tupian' and $do!='postorder' and $do!='tk'){
       	  	  	 	
       	  	  	 	header("Location: ".$loginurl); 
					//确保重定向后，后续代码不会被执行 
					exit;				
       	  	  	 }
       	  	  }
       	  }
       	
       }
       
       
       
       
   }
   
   public function get_server_ip() { 
	    if (isset($_SERVER)) { 
	        if($_SERVER['SERVER_ADDR']) {
	            $server_ip = $_SERVER['SERVER_ADDR']; 
	        } else { 
	            $server_ip = $_SERVER['LOCAL_ADDR']; 
	        } 
	    } else { 
	        $server_ip = getenv('SERVER_ADDR');
	    } 
	    return $server_ip; 
	}
   

   public function doMobileCs2() {
       global $_W, $_GPC;
       
//     echo $this->get_server_ip();
//     echo "<pre>";
//     	print_r($_SERVER);
//     	exit;

       $cfg = $this->module['config'];
       $appkey=$cfg['tkAppKey'];
        $secret=$cfg['tksecretKey'];
		$c = new TopClient;		        
        $c->appkey = $appkey;
		$c->secretKey = $secret;
		$req = new WirelessShareTpwdCreateRequest;
		$tpwd_param = new GenPwdIsvParamDto;
		$tpwd_param->ext="{\"\":\"\"}";
		$tpwd_param->logo="http://m.taobao.com/xxx.jpg";
		$tpwd_param->url="https://mos.m.taobao.com/activity_newer?from=pub&pid=mm_0_0_0";
		$tpwd_param->text="超值活动，惊喜活动多多";
		$tpwd_param->user_id="24234234234";
		$req->setTpwdParam(json_encode($tpwd_param));
		$resp = $c->execute($req);


		echo "<pre>";
			print_r($resp);
			exit;
		      
   }

   //结束



   
    //测试
    
    
    
    //订单自动跟单
    public function getzdorder($member,$cfg){
    //public function doMobileCs3(){
    	global $_W;
    	
//  	//测试
//  	$fans = mc_oauth_userinfo(); 
//      $member=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
//  	//测试
    	
    	if(empty($member['tbsbuid6'])){//没有绑定订单后6位就不执行
    		return "";
    	}
    	$tbsbuid6=$member['tbsbuid6'];
    	$ztime=mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-20,date("Y"));//上7天时间蹉
    	//echo $ztime."<br>";
    	$tkorlist = pdo_fetchall('select * from '.tablename($this->modulename."_tkorder")." where weid='{$_W['uniacid']}' and tbsbuid6='{$tbsbuid6}' and addtime>'{$ztime}' and orderzt<>'订单失效' and zdgd<>1 order by id desc"); 
    	//return $tkorlist;
    	//echo $tbsbuid6;
//  	print_r($tkorlist);
    	foreach($tkorlist as $k=>$tkorder){
    		//return $tkorder;
    		$order=pdo_fetch("select * from ".tablename($this->modulename."_order")." where weid='{$_W['uniacid']}' and orderid='{$tkorder['orderid']}' and itemid='{$tkorder['numid']}'");
    		if(empty($order['id'])){
    			if($cfg['fxtype']==1){//积分
                	$jltype=0;
                }elseif($cfg['fxtype']==2){//余额
                    $jltype=1;
                }
                $sh=3;//自动跟单的全都   审核状态
                //插入自购订单
                if($cfg['fxtype']==1){//积分
                	$jltype=0;
                }elseif($cfg['fxtype']==2){//余额
                    $jltype=1;
                }
                
                if($cfg['fxtype']==1){//自购积分                	
                	if($cfg['gdfxtype']==1){
                		$jl=$cfg['zgf'];
                	}else{
                		$jl=intval($tkorder['xgyg']*$cfg['zgf']/100*$cfg['jfbl']);
                	} 
                }elseif($cfg['fxtype']==2){//自购余额
                    if($cfg['gdfxtype']==1){
                		 $jl=$cfg['zgf'];
                	}else{
                		 $jl=$tkorder['xgyg']*$cfg['zgf']/100;  
                   		 $jl=number_format($jl, 2, '.', '');
                	}  
                }      
                
                $orderid=$tkorder['orderid'];
//              echo $orderid."<br>";
                $data=array(
                    'weid'=>$_W['uniacid'],
                    'openid'=>$member['from_user'],
                    'memberid'=>$member['openid'],
                    'uid'=>$member['id'],
                    'nickname'=>$member['nickname'],
                    'avatar'=>$member['avatar'],
                    'orderid'=>$orderid,
                    'itemid'=>$tkorder['numid'],
                    'jl'=>$jl,
                    'jltype'=>$jltype,
                    'sh'=>$sh,
                    'yongjin'=>$tkorder['xgyg'],//佣金
                    'type'=>0,
                    'createtime'=>TIMESTAMP
                );
                $resorder=pdo_insert ( $this->modulename . "_order", $data );
                //自购订单结束
               if($resorder!=false){
                	pdo_update($this->modulename . "_tkorder", array('zdgd'=>1), array('weid'=>$_W['uniacid'],'orderid' =>$orderid));
                }
                
                
                
                if(!empty($member['helpid'])){//一级
                	//插入一级订单
                           if(!empty($cfg['yjf'])){
                               //$credit2_yj=$tkorder['xgyg']*$cfg['yjf']/100;
                               //$ejprice=$cfg['yjf']*$credit2_yj/100;
                                    if($cfg['fxtype']==1){//自购积分
					                	if($cfg['gdfxtype']==1){
					                		 $jl=$cfg['yjf'];
					                	}else{
					                		$jl=intval($tkorder['xgyg']*$cfg['yjf']/100*$cfg['jfbl']);
					                	}
					                }elseif($cfg['fxtype']==2){//自购余额
                                        if($cfg['gdfxtype']==1){
					                		 $jl=$cfg['yjf'];
					                	}else{
					                		$jl=$tkorder['xgyg']*$cfg['yjf']/100;  
                                        	$jl=number_format($jl, 2, '.', '');
					                	}
					                }
					               $yjmember=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and id='{$member['helpid']}' order by id desc");
			                       $yjtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['yjtxmsg']);
			                       $yjtxmsg=str_replace('#订单号#',$orderid, $yjtxmsg);
			                       $yjtxmsg=str_replace('#金额#',$jl, $yjtxmsg);
			                       $this->postText($yjmember['from_user'],$yjtxmsg);//一级提示
                                   $data2=array(
                                        'weid'=>$_W['uniacid'],
                                        'openid'=>$yjmember['from_user'],
                                        'memberid'=>$yjmember['openid'],//用户UID
                                        'uid'=>$yjmember['id'],
                                        'nickname'=>$yjmember['nickname'],
                                        'jl'=>$jl,
                                        'jltype'=>$jltype,
                                        'avatar'=>$yjmember['avatar'],
                                            'jlnickname'=>$member['nickname'],
                                            'jlavatar'=>$member['avatar'],
                                        'orderid'=>$orderid,
                                        'yongjin'=>$tkorder['xgyg'],
                                        'itemid'=>$tkorder['numid'],
                                        'type'=>1,
                                        'sh'=>$sh,
                                        'createtime'=>TIMESTAMP
                                    );
                                    $order = pdo_fetchall("select * from ".tablename($this->modulename."_order")." where weid='{$_W['uniacid']}' and type=1 and orderid={$orderid} and itemid='{$tkorder['numid']}'");
                                    if(empty($order)){
                                        pdo_insert ( $this->modulename . "_order", $data2 );//添加一级订单
                                    }
                                   
                             }
                       //一级订单结束
                    
                    if(!empty($yjmember['helpid'])){//二级
                           //二级订单添加
                                 if(!empty($cfg['ejf'])){
                                     //$ejfprice=$tkorder['xgyg']*$cfg['ejf']/100;
                                     if($cfg['fxtype']==1){//自购积分
					                	if($cfg['gdfxtype']==1){
					                		 $jl=$cfg['ejf'];
					                	}else{
					                		$jl=intval($tkorder['xgyg']*$cfg['ejf']/100*$cfg['jfbl']);
					                	}
					                }elseif($cfg['fxtype']==2){//自购余额
					                	if($cfg['gdfxtype']==1){
					                		 $jl=$cfg['ejf'];
					                	}else{
					                		 $jl=$tkorder['xgyg']*$cfg['ejf']/100;  
                                       		 $jl=number_format($jl, 2, '.', '');
					                	}
					                }
					               $rjmember=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and id='{$yjmember['helpid']}' order by id desc");
		                           $ejtxmsg=str_replace('#昵称#',$member['nickname'], $cfg['ejtxmsg']);
		                           $ejtxmsg=str_replace('#订单号#',$orderid, $ejtxmsg);
		                           $ejtxmsg=str_replace('#金额#',$jl, $ejtxmsg);
		                           $this->postText($rjmember['from_user'],$ejtxmsg);//二级提示
                                     $data3=array(
                                        'weid'=>$_W['uniacid'],
                                        'openid'=>$rjmember['from_user'],
                                        'memberid'=>$rjmember['openid'],//用户openid
                                        'uid'=>$rjmember['id'],//用户openid                                        
                                        'nickname'=>$rjmember['nickname'],
                                        'jl'=>$jl,
                                        'jltype'=>$jltype,
                                        'avatar'=>$rjmember['avatar'],
                                            'jlnickname'=>$member['nickname'],
                                            'jlavatar'=>$member['avatar'],
                                        'orderid'=>$orderid,
                                        'yongjin'=>$tkorder['xgyg'],
                                        'itemid'=>$tkorder['numid'],
                                        'type'=>2,
                                         'sh'=>$sh,
                                        'createtime'=>TIMESTAMP
                                    );
                                    $order = pdo_fetchall("select * from ".tablename($this->modulename."_order")." where weid='{$_W['uniacid']}' and type=2 and orderid={$orderid}  and itemid='{$tkorder['numid']}'");
                                    if(empty($order)){
                                        pdo_insert ( $this->modulename . "_order", $data3 );//添加二级订单
                                    }
                                 }             
                       }//二级订单结束
                }
                
    		}
    		
    	}
    	
    }
    
    
    
    //检测会员入库和更新OPENID 返回会员信息
    public function getmember($fans,$wqid,$helpid){
    	global $_W;
    	if(empty($fans['openid'])){
    		return '';
    	}
    	//unionid开始
    	if(!empty($fans['unionid'])){//先看unionid
    		$share = pdo_fetch('select * from '.tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and unionid='{$fans['unionid']}'"); 
    		if(!empty($share['id'])){//如果unionid有这个数据，就更新一下OPENID和公众号一至
    			$updata=array(
    				'from_user'=>$fans['openid'],
    				'openid'=>$wqid,			
    				'nickname'=>$fans['nickname'],
					'avatar'=>$fans['avatar'],
    			);
    			pdo_update("tiger_newhu_share", $updata, array('weid'=>$_W['uniacid'],'unionid' =>$fans['unionid']));
    			$share = pdo_fetch('select * from '.tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and unionid='{$fans['unionid']}'");
			   return $share;
    		}else{//没有UNIIOD
    		    $share = pdo_fetch('select * from '.tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
    			if(!empty($share['id'])){
    				$updata=array(
	    				'unionid'=>$fans['unionid'],
	    				'openid'=>$wqid, 	
	    				'nickname'=>$fans['nickname'],
						'avatar'=>$fans['avatar'],		
	    			);
	    			pdo_update("tiger_newhu_share", $updata, array('weid'=>$_W['uniacid'],'from_user' =>$fans['openid']));
	    			$share = pdo_fetch('select * from '.tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
				   return $share;
    			}else{
    				pdo_insert("tiger_newhu_share",array(
							'openid'=>$wqid,
							'nickname'=>$fans['nickname'],
							'avatar'=>$fans['avatar'],
                            'unionid'=>$fans['unionid'],
							'pid'=>'',
                            'updatetime'=>time(),
							'createtime'=>time(),
							'parentid'=>0,
							'weid'=>$_W['uniacid'],
							'helpid'=>$helpid,
							'score'=>'',
							'cscore'=>'',
							'pscore'=>'',
                            'from_user'=>$fans['openid'],
                            'follow'=>1
					));					
				   $share['id'] = pdo_insertid();	
				   $share = pdo_fetch('select * from '.tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and id='{$share['id']}'");
				   return $share;
    			}
    		}
    	}else{
    		$share = pdo_fetch('select * from '.tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
    		
    		if(!empty($share['id'])){
    			if(!empty($fans['unionid'])){
    				$updata=array(
	    				'unionid'=>$fans['unionid'],
	    				'openid'=>$wqid,	
	    				'nickname'=>$fans['nickname'],
						'avatar'=>$fans['avatar'],	
	    			);
	    			pdo_update("tiger_newhu_share", $updata, array('weid'=>$_W['uniacid'],'from_user' =>$fans['openid']));
	    			$share = pdo_fetch('select * from '.tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
				    return $share;
    			}else{
    				return $share;
    			}    			
    		}else{
    			if(!empty($fans['openid'])){
    				pdo_insert("tiger_newhu_share",array(
							'openid'=>$wqid,
							'nickname'=>$fans['nickname'],
							'avatar'=>$fans['avatar'],
                            'unionid'=>$fans['unionid'],
							'pid'=>'',
                            'updatetime'=>time(),
							'createtime'=>time(),
							'parentid'=>0,
							'weid'=>$_W['uniacid'],
							'helpid'=>$helpid,
							'score'=>'',
							'cscore'=>'',
							'pscore'=>'',
                            'from_user'=>$fans['openid'],
                            'follow'=>1
					));					
				   $share['id'] = pdo_insertid();	
				   $share = pdo_fetch('select * from '.tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
				   return $share;
    			}else{
    				return '';
    			}
    		}
    	}
    	//unionid结束    	
    }
    
    
    /*
      本人订单
      $share 一级粉丝信息
      $begin_time 订单开始时间
      $end_time 订单结束时间 不传结束时间到当天
      $zt  1结算 2付款未结束 3结算和付款
      $set 比率
     */
    public function bryj($share,$begin_time,$end_time,$zt,$bl,$cfg){//本人订单//代理抽成比例
      global $_W;
      if(!empty($share['dlbl'])){//开启代理自定义模式
        $bl['dlbl1']=$share['dlbl'];
      }
      $send_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//上个月结束时间
      
      if($cfg['jsms']==1){
          if($send_time==$end_time){
            $addtime='jstime';
          }else{
            $addtime='addtime';
          }
          if($zt==2){
            $addtime='addtime';
          }
      }else{
        $addtime='addtime';
      }
     // file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log-1.txt","\n".json_encode($addtime),FILE_APPEND);
      

      if(empty($end_time)){
         if(!empty($begin_time)){
           $dwhere="and addtime>={$begin_time}";
         }   
      }else{
        if(!empty($begin_time)){
          $dwhere="and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
        }        
      }
      if($zt==1){
        $ddzt=" and orderzt='订单结算'";
      }elseif($zt==2){
        $ddzt=" and orderzt='订单付款'";
      }elseif($zt==3){
        $ddzt=" and orderzt<>'订单失效'";
      }
      
      //本人推广位PID
        $tgwarr=explode('|',$share['tgwid']);
        $where='';
        if(!empty($share['tgwid'])){
           $where .="and (";
           foreach($tgwarr as $k=>$v){
               $where .=" tgwid=".$v." or ";
           }
           $where .="tgwid=".$tgwarr[0].")";
        }else{
          $where .=" and tgwid=111111";
        }
      //本人结束
      $byygsum = pdo_fetchcolumn("SELECT sum(xgyg) FROM " . tablename('tiger_newhu_tkorder')." where weid='{$_W['uniacid']}'  {$ddzt} {$dwhere} {$where}");//本月本人预估实际佣金
      //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log.txt","\n".json_encode($byygsum),FILE_APPEND);
      if(!empty($bl['dlkcbl'])){
        $byygsum=$byygsum*(100-$bl['dlkcbl'])/100;
      }
      if(empty($byygsum)){
          $byygsum="0.00";
      }else{
        $sj=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$share['helpid']}'");
        
        if(!empty($sj)){
            if($bl['dltype']==2){//开启二级代理模式
              $dj=1;
            }
            $sj2=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$sj['helpid']}'");            
            if($bl['dltype']==3){//开启三级代理模式
                if(!empty($sj2)){
                  $dj=2;
                }else{
                  $dj=1;
                }
                
            }              
           
        }
      }
      

      if($bl['fxtype']==1){//普通模式
          $byygsum=$byygsum*$bl['dlbl1']/100;
      }else{//抽成模式         
         if($dj==1){
             $yj2=$byygsum*$bl['dlbl2']/100;//自身所得佣金
             $yj1=$yj2*$bl['dlbl1t2']/100;//被上级提取
             $byygsum=$yj2-$yj1;
             //return $dj;
          }elseif($dj==2){
             $yj3=$byygsum*$bl['dlbl3']/100;//自身所得佣金
             $yj2=$yj3*$bl['dlbl2t3']/100;//被上级提取
             $yj1=$yj3*$bl['dlbl1t3']/100;//被上上级提取
             $byygsum=$yj3-$yj2-$yj1;
          }else{
             $byygsum=$byygsum*$bl['dlbl1']/100;
          }        
      }
      
      return $byygsum;
    }
    
    public function jcbl($share,$bl){//单个会员佣金比例 
         global $_W;
         $sj=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$share['helpid']}'");//上级
         if($bl['dltype']==3){//开三级   
             if(!empty($sj)){
               $sj2=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$sj['helpid']}'");//上上级
               if(!empty($sj2)){
                 $djbl=$bl['dlbl3'];
                 $tname=$bl['dlname3'];
                 $cj=3;
               }else{
                 $djbl=$bl['dlbl2'];
                 $tname=$bl['dlname2'];
                 $cj=2;
               }           
             }else{
               $djbl=$bl['dlbl1'];
               $tname=$bl['dlname1'];
               $cj=1;
             }
         }elseif($bl['dltype']==2){//开二级
             if(!empty($sj)){
                $djbl=$bl['dlbl2'];
                $tname=$bl['dlname2'];
                $cj=2;
             }else{
                $djbl=$bl['dlbl1'];
                $tname=$bl['dlname1'];
                $cj=1;
             }           
         }else{
            $djbl=$bl['dlbl1'];
            $tname=$bl['dlname1'];
            $cj=1;
         }
         if(!empty($share['dlbl'])){//如果开了代理独立的，就用独立的
            $djbl=$share['dlbl'];
            $tname=$bl['dlname1'];
         }
         $arr=array(
             'bl'=>$djbl,
             'tname'=>$tname,
             'cj'=>$cj,
         );

         return $arr;         
     }
     
     
      /*
            二级 三级订单
      $share 一级粉丝信息
      $begin_time 订单开始时间
      $end_time 订单结束时间 不传结束时间到当天
      $zt  1结算 2付款未结束 3结算和付款
     */
     public function bydlyj($share,$begin_time,$end_time='',$zt,$bl,$cfg){//本人二级，三级订单 订单结算//代理抽成比例
          global $_W;
          if(!empty($share['dlbl'])){//开启代理一级自定义模式
            $bl['dlbl1']=$share['dlbl'];
          }
          $send_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));//上个月结束时间
          if($cfg['jsms']==1){
              if($send_time==$end_time){
                $addtime='jstime';
              }else{
                $addtime='addtime';
              }
              if($zt==2){
                $addtime='addtime';
              }
          }else{
            $addtime='addtime';
          }
          
          
          //echo $begin_time.'--'.$send_time;

          if(empty($end_time)){
            if(!empty($begin_time)){
                $where="and addtime>={$begin_time}";
            }            
          }else{            
            if(!empty($begin_time)){
              $where="and {$addtime}>={$begin_time} and {$addtime}<{$end_time}";
            }
          }
          //echo $where;
          //exit;
          if($zt==1){
            $ddzt=" and orderzt='订单结算'";
          }elseif($zt==2){
            $ddzt=" and orderzt='订单付款'";
          }elseif($zt==3){
            $ddzt=" and orderzt<>'订单失效'";
          }
          //return $where;
          // 本月起始时间:
          $bbegin_time = strtotime(date("Y-m-d H:i:s", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" ))));
          //$rjrs = pdo_fetchcolumn("SELECT sum(t.xgyg) FROM " . tablename("tiger_newhu_share")." s left join ".tablename("tiger_newhu_tkorder")." t ON s.tgwid=t.tgwid where s.weid='{$_W['uniacid']}' and s.helpid='{$share['openid']}' {$ddzt} and s.dltype=1 {$where}");//二级订单预估佣金合

          //20170506修改
          $rjshare=pdo_fetchall("SELECT id,helpid,tgwid FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and helpid='{$share['id']}' and dltype=1");//二级粉丝
          $r='';
          foreach($rjshare as $k=>$v){
             $a=pdo_fetchcolumn("SELECT sum(xgyg) FROM ".tablename("tiger_newhu_tkorder")."  where weid='{$_W['uniacid']}' and tgwid='{$v['tgwid']}' {$ddzt} {$where}");//二级订单预估佣金合
             $r=$r+$a;
          }
          $rjrs=$r;
          //结束
           


          if(!empty($bl['dlkcbl'])){
            $rjrs=$rjrs*(100-$bl['dlkcbl'])/100;
          }
          if(empty($rjrs)){
            $rjrs="0.00";
          }
          
          if($bl['dltype']==3){//三级代理模式
             $fans1=pdo_fetchall("select id from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and dltype=1 and helpid='{$share['id']}'",array(),'id');//二级人数
              if(!empty($fans1)){
                $sjrs = pdo_fetchcolumn("SELECT sum(t.xgyg) FROM " . tablename("tiger_newhu_share")." s left join ".tablename("tiger_newhu_tkorder")." t ON s.tgwid=t.tgwid where s.weid='{$_W['uniacid']}'   and s.dltype=1  {$ddzt} and s.helpid in (".implode(',',array_keys($fans1)).") {$where}");//三级订单统计
                //20170506修改
                 // $sjshare=pdo_fetchall("SELECT id,helpid,tgwid FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and dltype=1 and helpid in (".implode(',',array_keys($fans1)).") {$where}");//二级粉丝
                //  $b='';
                //  foreach($sjshare as $k=>$v){
                //     $c=pdo_fetchcolumn("SELECT sum(xgyg) FROM ".tablename("tiger_newhu_tkorder")."  where weid='{$_W['uniacid']}' and tgwid='{$v['tgwid']}' {$ddzt} {$where}");//二级订单预估佣金合
                //     $b=$r+$c;
                //  }
                //  $sjrs=$b;
                //结束
              }
              if(!empty($bl['dlkcbl'])){
                $sjrs=$sjrs*(100-$bl['dlkcbl'])/100;
              }
              if(empty($sjrs)){
                $sjrs="0.00";
              }
          }else{
            $sjrs="0.00";
          }
          if($bl['dltype']==1){//只开一级代理模式，二三级都不计算
              $rjrs="0.00";
              $sjrs="0.00";            
          }

         //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log.txt","\n".json_encode($rjrs."----".$bl['dlbl2']."---".$rjrs*$bl['dlbl2']/100),FILE_APPEND);
          
          
          $array=array(
             'yj2'=>$rjrs*$bl['dlbl2']/100,//二级订单求和  
             'yj3'=>$sjrs*$bl['dlbl3']/100 //三级订单求和  
          );
          return $array;
     }
     
    //代理计算单个商品的代理佣金
    public function dljiangli($endprice,$tkrate,$bl,$share){
    	global $_W;
    	//产品佣金
    	$dlyj=$endprice*$tkrate/100;//商品佣金
    	if(!empty($bl['dlkcbl'])){//代理扣除比例
          $dlyj=$dlyj*(100-$bl['dlkcbl'])/100;//代理扣除后的佣金
        }
        $fs=$this->jcbl($share,$bl);
        if(empty($share['dlbl'])){
          $dlbl=$bl['dlbl1'];//没有开代理独立比例
        }else{
          $dlbl=$fs['bl'];//开了代理独立比例，要看一下开了几级代理
        }
        if($bl['fxtype']==1){//大众模式
        	$dlrate=number_format($dlyj*$dlbl/100,2);//普通大众模式 代理佣金
        }else{//==0 抽成模式
        	$yj=number_format($dlyj*$dlbl/100,2);//不抽成所得佣金
        	if($bl['dltype']==2){//二级模式抽成
        		if(empty($share['helpid'])){
        			$jryj=0;
        		}else{        			
         			$jryj=$yj*$bl['dlbl1t2']/100;//二级代理提取佣金
        		}        		
         	}elseif($bl['dltype']==3){//三级抽成模式
         		if(empty($share['helpid'])){//如果没有二级，二级不抽成
         			$jryj=0;
         		}else{
         			$sjshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$share['weid']}'and dltype=1 and id='{$share['helpid']}'");
         			$jryj=$yj*$bl['dlbl2t3']/100;//二级代理提取佣金
         			if(empty($sjshare['helpid'])){//如果没有三级，三级不抽成
         				$jrsjyj=0;
         			}else{
         				$jrsjyj=$yj*$bl['dlbl1t3']/100;//三级代理提取佣金
         			}
         		}
         		
         	}
         	
           $jrzyj=$yj-$jryj-$jrsjyj;//所得佣金-二级提取-三级提取
           file_put_contents(IA_ROOT."/addons/tiger_tkxcx/yj_log.txt","\n"."uid:".$share['id']."------".$yj."-".$jryj."-".$jrsjyj."=".$jrzyj,FILE_APPEND);
           $dlrate=number_format($jrzyj,2);
        }
        return $dlrate;
        
    }
    
    
    //普通会员单个商品奖励
    public function ptyjjl($endprice,$tkrate,$cfg){
    	global $_W;
    	//产品佣金
    	$yj=$endprice*$tkrate/100;//商品佣金    	
    	$yongj=$yj*$cfg['zgf']/100;    	
    	if(empty($yongj)){
    		$yongj='0.00';
    	}    	
    	if($cfg['fxtype']==1){//积分
    		$yj1=$yongj*$cfg['jfbl'];//佣金乘以积分兑换比例
    		$yj1=intval($yj1);
    	}elseif($cfg['fxtype']==2){//余额
    		//$yj1=$yongj;
    		$yj1=number_format($yongj,2);
    	}    	
    	return $yj1;
    }
    
    //实际到用的
    public function sharejl($endprice,$tkrate,$bl,$share,$cfg){
    	if($share['dltype']==1){
    		$yj=$this->dljiangli($endprice,$tkrate,$bl,$share);
    	}else{
    		$yj=$this->ptyjjl($endprice,$tkrate,$cfg);
    	}
    	return $yj;
    }
   
    
    //淘口令解析
    public function tkljx($msg){
    	 global $_W, $_GPC;
        $cfg = $this->module['config'];
        $appkey=$cfg['tkAppKey'];
        $secret=$cfg['tksecretKey'];
         $c = new TopClient;
		$c->appkey = $appkey;
		$c->secretKey = $secret;
		$req = new WirelessShareTpwdQueryRequest;
		$req->setPasswordContent($msg);
		$resp = $c->execute($req);
		$jsonStr = json_encode($resp);
		$jsonArray = json_decode($jsonStr,true);
//		$url=$jsonArray['url'];		
//		
//		$title=$this->tklresp($jsonArray['content'],$cfg);
//
//		$data=array(
//			'url'=>$jsonArray['url'],
//			'content'=>$title,
//		);
		return $jsonArray;
//		echo $url;
//		echo "<pre>";
//      print_r($jsonArray);
//      exit;
    }
    
    //增加余额 增加积分
    //mc_credit_update($share['openid'],'credit1',$poster['score'],array($share['openid'],'关注送积分'))
    //$uid 用户ID
    //$type 0 积分  1 余额
    //$typelx  1签到    2邀请奖励    3取消关注   4订单奖励  5关注奖励  6后台管理员增加余额积分 7提现 8 晒单奖励 9积分商城兑换  10 代理支付奖励
    //createtime 添加时间
    public function mc_jl($uid,$type,$typelx,$num,$remark,$orderid){
        global $_W;
        if(empty($uid)){
            return;
        }
        $data=array(
            'uid'=>$uid,
            'weid'=>$_W['uniacid'],
            'type'=>$type,
            'typelx'=>$typelx,
            'num'=>$num,
            'remark'=>$remark,
            'orderid'=>$orderid,
            'createtime'=>time(),
        );
        $share= pdo_fetch("SELECT credit1,credit2 FROM " . tablename($this->modulename."_share") . " WHERE id='{$uid}' and weid='{$_W['uniacid']}' ");
        if($type==1){
            $credit2=$share['credit2']+$num;
            if($credit2<0){
              return array('error'=>0,'data'=>'余额不足');
            }
            $res=pdo_update($this->modulename."_share",array('credit2'=>$credit2),array('id'=>$uid));
            if($res===false){
               return array('error'=>0,'data'=>'余额更新失败');
            }else{
               //die(json_encode(array('error'=>1,'data'=>'余额更新成功!','uid'=>$uid)));//返回JSON数据
                $inst=pdo_insert($this->modulename."_jl",$data);
                if($inst=== false){
                    return array('error'=>0,'data'=>'余额更新失败');
                }else{
                    return array('error'=>1,'data'=>'余额更新成功');
                }
            }
        }elseif($type==0){
            $credit1=$share['credit1']+$num;
            if($credit1<0){
              return array('error'=>0,'data'=>'积分不足');
            }
            $res=pdo_update($this->modulename."_share",array('credit1'=>$credit1),array('id'=>$uid));
            if($res===false){
               return array('error'=>0,'data'=>'积分更新失败');
            }else{
               $inst=pdo_insert($this->modulename."_jl",$data);
                if($inst=== false){
                    return array('error'=>0,'data'=>'积分更新失败');
                }else{
                    return array('error'=>1,'data'=>'积分更新成功');
                }
            }
        }   
    
    }
    
    
    //检测登录
    public function islogin(){
    	global $_W;
       if(!empty($_SESSION["openid"])){
       	 $fans['openid']=$_SESSION["openid"]; 
       	 $share=pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and id='{$_SESSION['tkuid']}'");       	  
       }
       $mc=mc_fetch($fans['openid']);
       $fans=array(
           'id'=>$_SESSION['tkuid'],
           'tkuid'=>$_SESSION['tkuid'],
           'wquid'=>$mc['uid'],
	       'credit1'=>$share['credit1'],
	       'credit2'=>$share['credit2'],
	       'nickname'=>$share['nickname'],
	       'avatar'=>$share['avatar'],
	       'helpid'=>$share['helpid'],
	       'dlptpid'=>$share['dlptpid'],
	       'unionid'=>$share['unionid'],
	       'from_user'=>$share['from_user'],
	       'openid'=>$share['from_user'],
	       'createtime'=>$share['createtime'],
	       'tgwid'=>$share['tgwid'],//推广位
	       'cqtype'=>$share['cqtype'],//查券是否开启 1开启
	       'dltype'=>$share['dltype'],//1代理审核通过   2审核中  0不是代理
	       'status'=>$share['status'],//1为拉黑
       );
       return $fans;
    }
    
    
    
    //登录
    public function doMobileLogin(){
    	global $_GPC,$_W;
		$cfg = $this->module['config'];
		$pid=$_GPC['pid'];
		$tzurl=$_GPC['tzurl'];
		$fans = mc_oauth_userinfo();
		
		
		if ($_W['isajax']){
            $username=trim($_GPC['username']);
            $password=trim($_GPC['password']);

            $share= pdo_fetch("SELECT * FROM " . tablename($this->modulename."_share") . " WHERE pcuser='{$username}' and weid='{$_W['uniacid']}' ");

            if($username==$share['pcuser'] && $password==$share['pcpasswords']){
                $_SESSION["username"]=$share['pcuser'];
                $_SESSION["tkuid"]=$share['id'];
                $_SESSION["openid"]=$share['from_user'];
                $_SESSION["unionid"]=$share['unionid'];
                $_SESSION["pid"]=$share['dlptpid'];
                 exit(json_encode(array('status' =>1, 'msg'=>'登录成功','tzurl'=>urldecode($tzurl))));
              }else{
                 exit(json_encode(array('status' =>0, 'msg'=>'帐号密码错误','tzurl'=>urldecode($tzurl))));
              }
         }
		include $this->template ( 'login' );  
    }
    
    //退出登录
    public function doMobileLoginout(){
		session_unset();
		session_destroy();       
        exit(json_encode(array('status' =>1, 'msg'=>'退出登录成功')));		
	}
	
	
	//绑定手机号
    public function doMobilebdLogin(){
    	global $_GPC,$_W;
		$cfg = $this->module['config'];
		$fans = mc_oauth_userinfo();
		$openid=$_GPC['openid'];
		$unionid=$_GPC['unionid'];
		$username=trim($_GPC['username']);
        $password=trim($_GPC['password']);
        $usdata=array(
        	'pcuser'=>$username,
        	'pcpasswords'=>$password
        );
        
        
        

		
		if ($_W['isajax']){
			if(empty($openid)){
				exit(json_encode(array('status' =>0, 'msg'=>'请在微信端绑定')));
			}
			
			$sharepcuser= pdo_fetch("SELECT * FROM " . tablename($this->modulename."_share") . " WHERE pcuser='{$username}' and weid='{$_W['uniacid']}' ");  
			if(!empty($sharepcuser['id'])){
				exit(json_encode(array('status' =>0, 'msg'=>'手机号已经存在！')));
			} 
			
			$share= pdo_fetch("SELECT * FROM " . tablename($this->modulename."_share") . " WHERE from_user='{$openid}' and weid='{$_W['uniacid']}' ");         
           
            if(empty($share['id'])){
            	$share= pdo_fetch("SELECT * FROM " . tablename($this->modulename."_share") . " WHERE unionid='{$unionid}' and weid='{$_W['uniacid']}' ");        		 if(!empty($share['id'])){
            		pdo_update($this->modulename."_share", $usdata, array('weid'=>$_W['uniacid'],'id' =>$share['id']));
            	}else{
            		exit(json_encode(array('status' =>0, 'msg'=>'用户不存在，请先关注公众号')));
            	}
            }else{
            	$aaa=pdo_update($this->modulename."_share", $usdata, array('weid'=>$_W['uniacid'],'id' =>$share['id']));
            	if($aaa!=='false'){
            		exit(json_encode(array('status' =>1, 'msg'=>'绑定成功！')));
            	}
            	exit(json_encode(array('status' =>0, 'msg'=>$aaa)));
            	
            }
            if(empty($share['id'])){
            	exit(json_encode(array('status' =>0, 'msg'=>'用户不存在，请先关注公众号')));
            }

            
         }
		include $this->template ( 'bdlogin' );  
    }


    public function sjrd44($length = 4){ 
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
            $str = ''; 
            for ($i = 0; $i<$length;$i++ ) 
            {  
                $str .= $chars[mt_rand(0, strlen($chars)-1)]; 
            } 
            return $str; 
        } 

    public function getimg($url,$path='',$_W){//二维码保存到指定分日期保存目录
            empty($path)&&($path = IA_ROOT."/addons/tiger_newhu/goodsimg/".date("Ymd"));
            !file_exists($path)&&mkdir ($path, 0777, true );
            if($url == "")return false;
            $sctime=date("YmdHis").$this->sjrd44(6);
            $filename = $path.'/'.$sctime.".png";
            ob_start();
            readfile($url);
            $img = ob_get_contents();
            ob_end_clean();
            $fp = fopen($filename, "a");
            fwrite($fp, $img);
            fclose($fp);
            //return $filename.'-----'."/addons/tiger_newhu/goodsimg/".$sctime.".jpg";//返回文件名
            return $_W['siteroot']."addons/tiger_newhu/goodsimg/".date("Ymd").'/'.$sctime.".png";//返回文件名
        }
    
    
    public  function doMobileTupian(){
    	global $_GPC,$_W;
        $cfg = $this->module['config'];

        $title =urldecode($_GPC['title']);//标题
        $price=$_GPC['price'];//券后价
        $yhj=$_GPC['yhj'];//优惠券
        $orprice=$_GPC['orprice'];//原价
		$xiaol=$_GPC['xiaol'];//销量
        $jrprice=$_GPC['jrprice'];//券后价
        $taoimage=$_GPC['taoimage'];
        $url=urldecode($_GPC['url']);

        include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
        $urlarr=$this->dwzw($url);
        $url=$urlarr;
        
        //exit;
        $ewm=$this->getimg('http://pan.baidu.com/share/qrcode?w=150&h=150&url='.$url,'',$_W);
        //echo $ewm;
        //exit;

        //echo $_W['siteroot'];
        //echo IA_ROOT;
        //exit;

        picjialidun($_W,$title,$price,$yhj,$orprice,$xiaol,$jrprice,$taoimage,$ewm);
    }

    public function getfc ($string, $len=2) {
      $string=str_replace(' ','',$string);
      $start = 0;
      $strlen = mb_strlen($string);
      while ($strlen) {
        $array[] = mb_substr($string,$start,$len,"utf8");
        $string = mb_substr($string, $len, $strlen,"utf8");
        $strlen = mb_strlen($string);
      }
      return $array;
   }

    public function curl_request($url,$post='',$cookie='', $returnCookie=0){
        //参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$Cookies,参数4：是否返回$cookies
            $curl = curl_init();//初始化curl会话
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; 	Trident/6.0)');
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
            curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
            if($post) {
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
            }
            if($cookie) {
                curl_setopt($curl, CURLOPT_COOKIE, $cookie);
            }
            curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($curl);//执行curl会话
            if (curl_errno($curl)) {
                return curl_error($curl);
            }
            curl_close($curl);//关闭curl会话
            if($returnCookie){
                list($header, $body) = explode("\r\n\r\n", $data, 2);
                preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
                $info['cookie']  = substr($matches[1][0], 1);
                $info['content'] = $body;
                return $info;
            }else{
                return $data;
            }
        }


    public function strurl($coupons_url) {//获取优惠券ID
        //$a="http://shop.m.taobao.com/shop/coupon.htm?activity_id=b20277f095a940f99db74b36123e4870&seller_id=1761644935";
        //http:\/\/shop.m.taobao.com\/shop\/coupon.htm?seller_id=2267264737&activity_id=11254459ce974f879d27968fc463c2d4
        //http:\/\/shop.m.taobao.com\/shop\/coupon.htm?sellerId=839765554&activityId=9a27c2aa95b1471c8ff219b18c6592ee
        $url=strtolower($coupons_url);//转小写
        //Return $url;
        $activity_id="activity_id=";
        $wz=strpos($url,$activity_id);
        
        if(empty($wz)){
          $activity_id="activityid=";
          $wz=strpos($url,$activity_id);
           Return  substr($url,$wz+11,32);
        }else{
           Return  substr($url,$wz+12,32);
        }
        
    }
    
    public function tkl($url,$img,$tjcontent) {//淘口令转换
        global $_W, $_GPC;
        
        $cfg = $this->module['config'];
        $appkey=$cfg['tkAppKey'];
        $secret=$cfg['tksecretKey'];
        
        $c = new TopClient;
		$c->appkey = $appkey;
        $c->secretKey = $secret;
		$req = new TbkTpwdCreateRequest;
		//$req->setUserId("123");
		$req->setText($tjcontent);
		$req->setUrl($url);
		$req->setLogo($img);
		$req->setExt("{}");
		$resp = $c->execute($req);	
		$jsonStr = json_encode($resp);
		$jsonArray = json_decode($jsonStr,true);
		$taokou=$jsonArray['data']['model'];
		
	    if($cfg['tklnewtype']==1){
	      	$taokou=str_replace("《","￥",$taokou);//KuQU02tsN9Z《 ￥VFM402tN1ui￥《SFol02tuPOU《
	    }
	    file_put_contents(IA_ROOT."/addons/tiger_newhu/tkl_log.txt","\n".json_encode($jsonArray),FILE_APPEND);
        Return $taokou;
    }



  public function doMobileSq88888888(){
		global $_W,$_GPC;				
		if(/*//这时柘城asdfsdf阿斯蒂芬561561斯蒂芬基本原理起算才埋或多或少丰11561@￥@#%￥@……@%@￥%@*/$_GPC['my']!=/*//这时柘城asdfsdf阿斯蒂芬561561斯蒂芬基本原理起算才埋或多或少丰11561@￥@#%￥@……@%@￥%@*/'tigernewhu'/*//这时柘城asdfsdf阿斯蒂芬561561斯蒂芬基本原理起算才埋或多或少丰11561@￥@#%￥@……@%@￥%@*/){
			echo 'cs';
			exit;
		}
		//这时柘城苦阿斯蒂芬基本原理蒂芬基本原理起算才埋或多或少丰11561@￥@#%￥@……@%@￥%@
		$cfg = /*//这时柘城asdfsdf阿斯蒂芬561561斯埋或多或少丰11561@￥@#%￥@……@%@￥%@*/$this->module['config'];
		//这时柘城苦阿斯蒂……#￥%#￥@！#@#%@#￥@##本原理起算才埋或多或少丰11561@￥@#%￥@……@%@￥%@
		$host=$_SERVER['HTTP_HOST'];		
        $host=/*//这时柘城asdfsdf阿斯蒂芬561561斯蒂芬基本原理起算才埋或多或少丰11561@￥@#%￥@……@%@￥%@*/strtolower($host);   
        $tbuid=/*//这时柘城asdfsdf阿斯蒂芬561561斯蒂芬基本原理起算才埋或多或少丰11561@￥@#%￥@……@%@￥%@*/$cfg['tbuid'];	
        $tkurl1=/*//这时柘城asdfsdf阿斯埋或多或少丰11561@￥@#%￥@……@%@￥%@*/$host;
        $tkurl2=/*//这时柘城asdfsdf阿斯蒂芬561561或少丰11561@￥@#%￥@……@%@￥%@*/$_W['setting']['site']['url'];
        $tkip=/*//这时柘城asdfsdf阿斯蒂芬561561斯蒂丰11561@￥@#%￥@……@%@￥%@*/$this->get_server_ip();;		
        echo "使用域名:".$host."<br>";
        echo "淘ID:".$tbuid."<br>";
        echo "域名:".$tkurl2."<br>";
        echo "tkip:".$tkip."<br>";        	
        $s=pdo_fetchall("select settings from ".tablename('uni_account_modules')." where module='tiger_newhu'");
    	foreach($s as $k=>$v){
    		/*//这时柘城asdfsdf阿斯蒂芬56156（……&￥%#￥理起算才埋或多或少丰11561@￥@#%￥@……@%@￥%@*/
    		$b=unserialize($v['settings']);
    		/*//这时柘城asdfsdf阿斯蒂芬561561斯蒂芬基多或少丰11561@￥@#%￥@……@%@￥%@*/
    		echo ",".$b['tbuid'];
    	}
        	
	}
    
    public function oldtkl($url,$img,$tjcontent) {//淘口令转换 付费淘口令
        global $_W, $_GPC;
        
        $cfg = $this->module['config'];
        $appkey=$cfg['tkAppKey'];
        $secret=$cfg['tksecretKey'];
        $c = new TopClient;
        $c->appkey = $appkey;
        $c->secretKey = $secret;
        $req = new WirelessShareTpwdCreateRequest;
        $tpwd_param = new GenPwdIsvParamDto;
        $tpwd_param->ext="{\"\":\"\"}";
        $tpwd_param->logo=$img;
        $tpwd_param->text=$tjcontent;
        $tpwd_param->url=$url;
        //$tpwd_param->user_id=$cfg['tbid'];
        $req->setTpwdParam(json_encode($tpwd_param));        
        $resp = $c->execute($req);  
        $taokou=$resp->model;
	    settype($taokou, 'string');   
	      if($cfg['tklnewtype']==1){
	      	$taokou=str_replace("《","￥",$taokou);//KuQU02tsN9Z《 ￥VFM402tN1ui￥《SFol02tuPOU《
	      }
        file_put_contents(IA_ROOT."/addons/tiger_newhu/oldtkl_log.txt","\n".json_encode($resp),FILE_APPEND);
        Return $taokou;
    }
    

    
    
    
    public function hlinorder($userInfo,$_W) {
        global $_W, $_GPC;
        
        $cfg = $this->module['config'];
        foreach($userInfo as $v){
        	$fztype=pdo_fetch("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}' and hlcid='{$v['fqcat']}' order by px desc");
        	$Quan_id=$this->strurl($v['couponurl']);
        	$item = array(
                        'weid' => $_W['uniacid'],
                        'fqcat'=>$fztype['id'],
                        'zy'=>2,
                        'quan_id'=>$Quan_id,
                        'itemid'=>$v['itemid'],
						'itemtitle'=>$v['itemtitle'],
						'itemshorttitle'=>$v['itemshorttitle'],
						'itemdesc'=>$v['itemdesc'],
						'itemprice'=>$v['itemprice'],
						'itemsale'=>$v['itemsale'],
						'itemsale2'=>$v['itemsale2'],
						'conversion_ratio'=>$v['conversion_ratio'],
						'itempic'=>$v['itempic'],
						'itemendprice'=>$v['itemendprice'],
						'shoptype'=>$v['shoptype'],
						'userid'=>$v['userid'],
						'sellernick'=>$v['sellernick'],
						'tktype'=>$v['tktype'],
						'tkrates'=>$v['tkrates'],
						'ctrates'=>$v['ctrates'],
						'cuntao'=>$v['cuntao'],
						'tkmoney'=>$v['tkmoney'],
						'tkurl'=>$v['tkurl'],
						'couponurl'=>$v['couponurl'],
						'planlink'=>$v['planlink'],
						'couponmoney'=>$v['couponmoney'],
						'couponsurplus'=>$v['couponsurplus'],
						'couponreceive'=>$v['couponreceive'],
						'couponreceive2'=>$v['couponreceive2'],
						'couponnum'=>$v['couponnum'],
						'couponexplain'=>$v['couponexplain'],
						'couponstarttime'=>$v['couponstarttime'],
						'couponendtime'=>$v['couponendtime'],
						'starttime'=>$v['starttime'],
						'isquality'=>$v['isquality'], 
						'item_status'=>$v['item_status'],
						'report_status'=>$v['report_status'],
						'is_brand'=>$v['is_brand'],
						'is_live'=>$v['is_live'],
						'videoid'=>$v['videoid'],
						'activity_type'=>$v['activity_type'],
						//'general_index'=>$v['general_index'],
                        'createtime'=>TIMESTAMP,
                    );
               $go = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid='{$_W['uniacid']}' and itemid='{$v['itemid']}' ORDER BY id desc");
                if(empty($go)){
                  pdo_insert($this->modulename."_newtbgoods",$item);
                }else{                          
                  pdo_update($this->modulename."_newtbgoods", $item, array('weid'=>$_W['uniacid'],'itemid' => $v['itemid']));
                }  
                       
            }
        
    }



   


    public function indtkgoods($dtklist) {//大淘客入库
        global $_W, $_GPC;
        $page=$_GPC['page'];
        $cfg = $this->module['config'];
        foreach($dtklist as $v){
                $fztype=pdo_fetch("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}' and dtkcid='{$v['Cid']}' order by px desc");
                //file_put_contents(IA_ROOT."/addons/tiger_newhu/log-type.txt","\n old:".json_encode($fztype),FILE_APPEND);
                if($v['Commission_queqiao']!='0.00'){//鹊桥
                   $lxtype='鹊桥活动';
                   $yjbl=$v['Commission_queqiao'];
                }elseif($v['Commission_jihua']!='0.00'){//定向
                  $lxtype='营销计划';
                  $yjbl=$v['Commission_jihua'];
                }else{
                  $lxtype='通用计划';
                  $yjbl=$v['Commission_jihua'];
                }
                if($v['IsTmall']==1){
                	$shoptype='B';
                }else{
                	$shoptype='C';
                }

                $item = array(
                         'weid' => $_W['uniacid'],
                         'fqcat'=>$fztype['id'],
                         'zy'=>1,
                         'tktype'=>$lxtype,
                         'itemid'=>$v['GoodsID'],//商品ID
                         'itemtitle'=>$v['Title'],//商品名称
                         'itemdesc'=>$v['Introduce'],//推荐内容
                         'itempic'=>$v['Pic'],//主图地址
                         'itemendprice'=>$v['Price'],//商品价格,券后价
                         'itemsale'=>$v['Sales_num'],//月销售
                         'tkrates'=>$yjbl,//通用佣金比例
                          'couponreceive'=>$v['Quan_receive'],//优惠券总量已领取数量
                          'couponsurplus'=>$v['Quan_surplus'],//优惠券剩余
                          'couponmoney'=>$v['Quan_price'],//优惠券面额
                          'couponendtime'=>strtotime($v['Quan_time']),//优惠券结束
                          'couponurl'=>$v['Quan_link'],//优惠券链接
                          'shoptype'=>$shoptype,//'0不是  1是天猫',
                          'quan_id'=>$v['Quan_id'],//'优惠券ID',  
                          'couponexplain'=>$v['Quan_condition'],//'优惠券使用条件',  
                          'itemprice'=>$v['Org_Price'],//'商品原价', 
                          'tkurl'=>$v['Jihua_link'],
                          'createtime'=>TIMESTAMP,
                        );
                       $go = pdo_fetch("SELECT itemid FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$_W['uniacid']}' and  itemid={$v['GoodsID']} ");
                        if(empty($go)){
                          pdo_insert($this->modulename."_newtbgoods",$item);
                        }else{
                           // file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode("up02:".$go['num_iid']),FILE_APPEND);
                          pdo_update($this->modulename."_newtbgoods", $item, array('weid'=>$_W['uniacid'],'itemid' => $v['GoodsID']));
                        }  
                       
            }
        
    }


    public function apUpload($media_id){
        global $_W,$_GPC;
		load()->classs('weixin.account');
        $accObj= WeixinAccount::create($_W['uniacid']);
        $access_token = $accObj->fetch_token();

        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;
        file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($access_token),FILE_APPEND);
        file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($media_id),FILE_APPEND);

        $newfolder= ATTACHMENT_ROOT . 'images' . '/tiger_newhu_photos'."/";//文件夹名称
        if (!is_dir($newfolder)) {
            mkdir($newfolder, 7777);
        } 
        $picurl = 'images'.'/tiger_newhu_photos'."/".date('YmdHis').rand(1000,9999).'.jpg';
        $targetName = ATTACHMENT_ROOT.$picurl;
        $ch = curl_init($url); // 初始化
        $fp = fopen($targetName, 'wb'); // 打开写入
        curl_setopt($ch, CURLOPT_FILE, $fp); // 设置输出文件的位置，值是一个资源类型
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);       
        return $picurl;
    } 

    public function dwz($url) {//短网址API
        global $_W;
        $cfg = $this->module['config'];
        $url=urlencode($url);
        $turl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('openlink',array('link'=>$url)));
        if($cfg['dwzlj']==0){//sina
        	$url=$this->sinadwz($turl);
        }elseif($cfg['dwzlj']==1){//w.url
        	$url=$this->wxdwz($turl);
        }else{
        	$urlarr=$this->zydwz($turl);
        }
    }
    
    

    public function dwzw($turl) {//短网址API--用这个
        global $_W;
        $cfg = $this->module['config'];
        if($cfg['dwzlj']==0){//sina
        	$url=$this->sinadwz($turl);
        }elseif($cfg['dwzlj']==1){//w.url
        	$url=$this->wxdwz($turl);
        }else{
        	$url=$this->zydwz($turl);
        }
        Return $url;
    }
    
    public function zydwz($turl){//自有短网址
    	global $_W;
        $cfg = $this->module['config'];
        $data=array(
                'weid'=>$_W['uniacid'],
                'url'=>$turl,
                'createtime'=>TIMESTAMP,
                );
        pdo_insert("tiger_newhu_dwz",$data);
        $id = pdo_insertid();        
        $url=$cfg['zydwz']."t.php?d=".$id;
        return $url;
    }
    


    public function wxdwz($url){//微信短网址
    	$result='{"action":"long2short","long_url":"'.$url.'"}';
        $access_token=$this->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token={$access_token}";
        $ret = ihttp_request($url, $result);        
        $content = @json_decode($ret['content'], true);
        Return $content['short_url'];
    }


    public function sinadwz($url) {//sina t.n短网址API
        global $_W;
        $cfg = $this->module['config'];
        if(empty($cfg['sinkey'])){
        	$key='1549359964';
        }else{
        	$key=trim($cfg['sinkey']);
        }
        //$url=urlencode($url);
        //$turl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('openlink',array('link'=>$url)));
        $turl2=urlencode($url);      
        $sinaurl="http://api.t.sina.com.cn/short_url/shorten.json?source={$key}&url_long={$turl2}";
        load()->func('communication');
        $json = ihttp_get($sinaurl);
        file_put_contents(IA_ROOT."/addons/tiger_newhu/log--sina.txt","\n--3".$url,FILE_APPEND);
        file_put_contents(IA_ROOT."/addons/tiger_newhu/log--sina.txt","\n--3".json_encode($json),FILE_APPEND);
        $result = @json_decode($json['content'], true);
        return $result[0]['url_short'];  
    }


    public function addtbgoods($data) {
         $cfg = $this->module['config']; 
        if($cfg['cxrk']==1){//选择入库才会入数据库
           if(empty($data['num_iid'])){
              Return '';
            }
            $go = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_tbgoods") . " WHERE weid = '{$data['weid']}' and  num_iid='{$data['num_iid']}'");
            if(empty($go)){
              pdo_insert($this->modulename."_tbgoods",$data);
            }else{
              pdo_update($this->modulename."_tbgoods", $data, array('weid'=>$data['weid'],'num_iid' => $data['num_iid']));
            }
        }
                
    }

    public function mygetID($url) {//获取链接商品ID
       if (preg_match("/[\?&]id=(\d+)/",$url,$match)) {
          return $match[1];
       } else {
          return '';
       }
    }

    public function getyouhui2($str){
        preg_match_all('|(￥[^￥]+￥)|ism', $str, $matches);
        return $matches[1][0];
    }

    public function geturl($str) {//获取链接
        $exp = explode('http', $str);
        //$url = 'http' . trim($exp[1]) . '中国';
        $url = 'http' . trim($exp[1]) . ' ';
        //preg_match('/[\x{4e00}-\x{9fa5}]/u', $url, $matches, PREG_OFFSET_CAPTURE);
        preg_match('/[\s]/u', $url, $matches, PREG_OFFSET_CAPTURE); 
        $url = substr($url, 0, $matches[0][1]);
        if($url=='http'){
          Return '';
        }else{
          return $url;
        }        
    }


    public function myisexists($url) {//判断是不是淘宝的地址
//       if (stripos($url,'mashort.cn')!==false) {
//          return 1;
//       }
//       if (stripos($url,'e22a.com')!==false) {
//          return 1;
//       }
//       if (stripos($url,'sjtm.me')!==false) {
//          return 1;
//       }
//       if (stripos($url,'laiwang.com')!==false) {
//          return 1;
//       }
       if (stripos($url,'taobao.com')!==false) {
          return 2;
       }elseif(stripos($url,'tmall.com')!==false) {
          return 2;
       }elseif(stripos($url,'tmall.hk')!==false) {
          return 2;
       }else{
          return 1;
       }
       return 0;
    }

    public function hqgoodsid($url) {//e22a获取ID
        //http://item.taobao.com/item.htm?id=540728402188&from=tbkfenxiangyoushang&fromScene=100&publishUserId
        //'http://item.taobao.com/item.htm?ut_sk=1.V5/73bfSri4DABBUs3mInifZ_21380790_1482201165164.Copy.1&id=23246340317&sourceType=item&
        //如果是e22a的域名就用这个获取商品ID
        //$str = $this->utf8_gbk(file_get_contents($url));
        $str = file_get_contents($url);        
		$str=str_replace("\"", "", $str);
        file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n".$str,FILE_APPEND);
		$goodsid=$this->Text_qzj($str,"?id=","&");
        if(empty($goodsid)){
          $goodsid=$this->Text_qzj($str,"&id=","&");
        }
        if(empty($goodsid)){
           $goodsid=$this->Text_qzj($str,"itemId:",",");
        }
        if(empty($goodsid)){
            $url=$this->Text_qzj($str,"url = '","';");
            $goodsid=$this->Text_qzj($str,"com/i",".htm");
            file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n".json_encode($goodsid),FILE_APPEND);
        }
        
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n goodsid:".json_encode("--------------"),FILE_APPEND);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n goodsid:".json_encode($goodsid),FILE_APPEND);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n goodsid:".json_encode("--------------"),FILE_APPEND);
        Return $goodsid;
    }

    public function Text_qzj($Text,$Front,$behind) {
				//语法：strpos(string,find,start)
				//函数返回字符串在另一个字符串中第一次出现的位置，如果没有找到该字符串，则返回 false。
				//参数描述：
				//string 必需。规定被搜索的字符串。
				//find   必需。规定要查找的字符。
				//start  可选。规定开始搜索的位置。
				
				//语法：string mb_substr($str,$start,$length,$encoding)
				//参数描述：
				//str      被截取的母字符串。
				//start    开始位置。
				//length   返回的字符串的最大长度,如果省略，则截取到str末尾。
				//encoding 参数为字符编码。如果省略，则使用内部字符编码。
					
					$t1 = mb_strpos(".".$Text,$Front);
					if($t1==FALSE){
						return "";
					}else{
						$t1 = $t1-1+strlen($Front);
					}
					$temp = mb_substr($Text,$t1,strlen($Text)-$t1);
					$t2 = mb_strpos($temp,$behind);
					if($t2==FALSE){
						return "";
					}
					return mb_substr($temp,0,$t2);
				}


    function gstr($str)
    {   
    $encode = mb_detect_encoding( $str, array('ASCII','UTF-8','GB2312','GBK'));
    if ( !$encode =='UTF-8' ){
    $str = iconv('UTF-8',$encode,$str);
    }
    return $str;
    }


    public function ewm($url){
        include "phpqrcode.php";
        $value=$url;
        $errorCorrectionLevel = "L";
        $matrixPointSize = "4";
        QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize);
        exit;  

    }


    public function sendNews($openid,$text) {
        global $_W, $_GPC;
       $url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('index'));
        $custom = array(
                'touser' => $openid,
				'msgtype' => 'news',
				'news' => array(
                              'articles'=>array(
                                              array(
                                               'title' => urlencode('晒单奖励提醒'),
                                               'description' => urlencode($text),
                                               'url' => $url,
                                               'picurl' => '',
                                              )
                                          )
                               ),
				
			);
        $result =urldecode(json_encode($custom));
        //$result='{"touser":"'.$openid.'","msgtype":"news","news":{"articles":[{"title":"'.$news['title'].'","description":"'.$news['description'].'","url":"'.$news['url'].'","picurl":"'.$news['picurl'].'"}]}}';
        $access_token=$this->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
        $ret = ihttp_request($url, $result);
		return $ret;
	}





    public function postText($openid, $text) {
        //$text1=addslashes($text);
		$post = '{"touser":"' . $openid . '","msgtype":"text","text":{"content":"' . $text . '"}}';
		$ret = $this->postRes($this->getAccessToken(), $post);
		return $ret;
	}

    private function postRes($access_token, $data) {
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
		load()->func('communication');
		$ret = ihttp_request($url, $data);
		$content = @json_decode($ret['content'], true);
		return $content['errcode'];
	}

    private function getAccessToken() {
		global $_W;
		load()->model('account');
		$acid = $_W['acid'];
		if (empty($acid)) {
			$acid = $_W['uniacid'];
		}
		$account = WeAccount::create($acid);
		//$token = $account->fetch_available_token();
        $token = $account->getAccessToken();
		return $token;
	}

    public function createRule($kword,$pid){
		global $_W;
		$rule = array(
				'uniacid' => $_W['uniacid'],
				'name' => $this->modulename,
				'module' => $this->modulename,
				'status' => 1,
				'displayorder' => 254,
		);
		pdo_insert('rule',$rule);
		unset($rule['name']);
		$rule['type'] = 1;
		$rule['rid'] = pdo_insertid();
		$rule['content'] = $kword;
		pdo_insert('rule_keyword',$rule);
        file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($pid.'----'.$rule['rid']),FILE_APPEND);
		pdo_update($this->modulename."_poster",array('rid'=>$rule['rid']),array('id'=>$pid));
	}

    public function get_device_type(){//判断手机类型 
		 //全部变成小写字母
		 $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		 $type = 'android';//其它浏览器 也默热为安桌
		 //分别进行判断
		 if(strpos($agent, 'iphone') || strpos($agent, 'ipad')){
		   $type = 'ios';
		 } 
		  
		 if(strpos($agent, 'android')){
		   $type = 'android';
		 }
		 return $type;
	}

    public function gettaogoods($numid,$api){
         $c = new TopClient;
         $c->appkey = $api['appkey'];
         $c->secretKey =$api['secretKey'];
         $req = new TbkItemInfoGetRequest;
         $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick");
         $req->setPlatform("1");
         $req->setNumIids($numid);
         $resp = $c->execute($req);
         $resp=json_decode(json_encode($resp),TRUE);
         $arr=$resp['results']['n_tbk_item'];  
         return $arr;
    }

    public function goodlist($key,$pid,$page){
       require_once IA_ROOT . "/addons/tiger_newhu/inc/sdk/getpic.php";
       $api=taobaopp($tiger);
       $c = new TopClient;
       $c->appkey = $api['appkey'];
       $c->secretKey =$api['secretKey'];
       $req = new TbkItemCouponGetRequest;
       $req->setPlatform("2");
       //$req->setCat("16,18");
       $req->setPageSize("20");//每页几条
       $req->setQ($key);
       $req->setPageNo($page);//第几页
       $req->setPid($pid);
       $resp = $c->execute($req);
       $resp=json_decode(json_encode($resp),TRUE);
       $goods=$resp['results']['tbk_coupon'];
       foreach($goods as $k=>$v){
//          $tkyj=intval($v['commission_rate']);
//          if($tkyj<10){
//            continue;
//          }
         
         $list[$k]['title']=$v['title'];
         $list[$k]['istmall']=$v['user_type'];
         $list[$k]['num_iid']=$v['num_iid'];
         $list[$k]['url']=$v['coupon_click_url'];
         $list[$k]['coupons_end']=$v['coupon_end_time'];
         preg_match_all('|满([\d\.]+).*元减([\d\.]+).*元|ism',$v['coupon_info'], $matches);
         $list[$k]['coupons_price']=$matches[2][0];
         $list[$k]['goods_sale']=$v['volume'];
         $list[$k]['price']=$v['zk_final_price']-$matches[2][0];
         $list[$k]['org_price']=$v['zk_final_price'];
         $list[$k]['pic_url']=$v['pict_url'];
         $list[$k]['shop_title']=$v['shop_title'];
         $list[$k]['tk_rate']=$v['commission_rate'];//佣金比例
         $list[$k]['nick']=$v['nick'];
         $list[$k]['coupons_take']=$v['coupon_remain_count'];
         $list[$k]['coupons_total']=$v['coupon_total_count'];
         $list[$k]['item_url']=$v['item_url'];
         $list[$k]['small_images']=$v['small_images']['string'];
         $list[$k]['pic_url']=$v['pict_url'];
       }
       return $list;
   }

    public function rhy($quan_id,$num_iid,$pid) {//二合一 鹊桥
        //$url="https://uland.taobao.com/coupon/edetail?activityId=".$quan_id."&itemId=".$num_iid."&src=tiger_tiger&pid=".$pid."&tj1=1";
        $url="https://uland.taobao.com/coupon/edetail?activityId=".$quan_id."&itemId=".$num_iid."&src=tiger_tiger&pid=".$pid."";
        Return $url;        
    }
    public function rhydx($quan_id,$num_iid,$pid) {//二合一 定向
        //$url="https://uland.taobao.com/coupon/edetail?activityId=".$quan_id."&itemId=".$num_iid."&src=tiger_tiger&pid=".$pid."&dx=1&tj1=1";
        $url="https://uland.taobao.com/coupon/edetail?activityId=".$quan_id."&itemId=".$num_iid."&src=tiger_tiger&pid=".$pid."&dx=1";
        Return $url;        
    }


   /**
	* 获取客户资料
	* $access_token= account_weixin_token($_W['account']);
	* 当用户接到到一条模板消息，会给公共平台api发送一个xml文件【待处理】
	*/	
    private function sendtext($txt,$openid){
		global $_W;
		$acid=$_W['account']['acid'];
		if(!$acid){
			$acid=pdo_fetchcolumn("SELECT acid FROM ".tablename('account')." WHERE uniacid=:uniacid ",array(':uniacid'=>$_W['uniacid']));
		}
		$acc = WeAccount::create($acid);
		$data = $acc->sendCustomNotice(array('touser'=>$openid,'msgtype'=>'text','text'=>array('content'=>urlencode($txt))));
		return $data;
	}

    //根据IP获取城市名
    function GetIpLookup($ip = ''){  
        if(empty($ip)){  
            $ip = GetIp();  
        }  
        $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);  
        if(empty($res)){ return false; }  
        $jsonMatches = array();  
        preg_match('#\{.+?\}#', $res, $jsonMatches);  
        if(!isset($jsonMatches[0])){ return false; }  
        $json = json_decode($jsonMatches[0], true);  
        if(isset($json['ret']) && $json['ret'] == 1){  
            $json['ip'] = $ip;  
            unset($json['ret']);  
        }else{  
            return false;  
        }  
        return $json;  
    }

    function getIp(){ 
		$onlineip=''; 
		if(getenv('HTTP_CLIENT_IP')&&strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown')){ 
			$onlineip=getenv('HTTP_CLIENT_IP'); 
		} elseif(getenv('HTTP_X_FORWARDED_FOR')&&strcasecmp(getenv('HTTP_X_FORWARDED_FOR'),'unknown')){ 
			$onlineip=getenv('HTTP_X_FORWARDED_FOR'); 
		} elseif(getenv('REMOTE_ADDR')&&strcasecmp(getenv('REMOTE_ADDR'),'unknown')){ 
			$onlineip=getenv('REMOTE_ADDR'); 
		} elseif(isset($_SERVER['REMOTE_ADDR'])&&$_SERVER['REMOTE_ADDR']&&strcasecmp($_SERVER['REMOTE_ADDR'],'unknown')){ 
			$onlineip=$_SERVER['REMOTE_ADDR']; 
		} 
		return $onlineip; 
	}

    public function postjiangli($scene_id,$from_user){
       global $_W, $_GPC;
       load()->model('mc');
       $fans = mc_fetch($from_user);
       $poster = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_poster')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
       if (empty($fans['nickname']) || empty($fans['avatar'])){
                        $openid = $this->message['from'];
                        $ACCESS_TOKEN = $this->getAccessToken();
                        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$ACCESS_TOKEN}&openid={$openid}&lang=zh_CN";
                        load()->func('communication');
                        $json = ihttp_get($url);
                        $userInfo = @json_decode($json['content'], true);
                        $fans['nickname'] = $userInfo['nickname'];
                        $fans['avatar'] = $userInfo['headimgurl'];
                        $fans['province'] = $userInfo['province'];
                        $fans['city'] = $userInfo['city'];
                        $fans['unionid']=$userInfo['unionid'];
                        mc_update($this->message['from'],array('nickname'=>$mc['nickname'],'avatar'=>$mc['avatar']));
                    }
       $hmember=pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_share')." WHERE weid = :weid and sceneid=:sceneid", array(':weid' => $_W['uniacid'],':sceneid'=>$scene_id));//事件所有者
              $member=pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_share')." WHERE weid = :weid and from_user=:from_user", array(':weid' => $_W['uniacid'],':from_user'=>$from_user));//当前用户信息
              //if(empty($member)){
               // exit;//用户不存在退出
             // }

              if (empty($member)){
                    pdo_insert($this->modulename."_share",
                            array(
                                    'openid'=>$fans['uid'],
                                    'nickname'=>$fans['nickname'],
                                    'avatar'=>$fans['avatar'],
                                    'pid'=>$poster['id'],
                                    'createtime'=>time(),
                                    'helpid'=>$hmember['openid'],
                                    'weid'=>$_W['uniacid'],
                                    'score'=>$poster['score'],
                                    'cscore'=>$poster['cscore'],
                                    'pscore'=>$poster['pscore'],
                                    'from_user'=>$this->message['from'],
                                    'follow'=>1
                            ));
                    $share['id'] = pdo_insertid();
                    $share = pdo_fetch('select * from '.tablename($this->modulename."_share")." where id='{$share['id']}'");

                    if($poster['kdtype']==1){//开启肯定好友
                       if(!empty($hmember['from_user'])){
                         $mcsj = mc_fetch($hmember['from_user']);
                         $msgsj="您已通过「".$mcsj['nickname']."」，成功关注，点击下方\n\n「菜单-领取奖励」\n\n为好友加分";
                       }else{
                         $msgsj='您需要点击「领取奖励」才能得到积分哦!';
                       }
                       $this->sendtext($msgsj,$from_user);
                       //$this->postText($this->message['from'],$msgsj);
                       exit;
                    }
                    //得积分开始
                    if($poster['score']>0 || $poster['scorehb']>0){
                      $info1=str_replace('#昵称#',$fans['nickname'], $poster['ftips']);
                      $info1=str_replace('#积分#',$poster['score'], $info1);
                      $info1=str_replace('#元#',$poster['scorehb'], $info1);
                      if($poster['score']){mc_credit_update($share['openid'],'credit1',$poster['score'],array($share['openid'],'关注送积分'));}
                      if($poster['scorehb']){mc_credit_update($share['openid'],'credit2',$poster['scorehb'],array($share['openid'],'关注送余额'));}                      
                      $this->sendtext($info1,$from_user);
                      //$this->postText($this->message['from'],$info1);
                    }
                    
                    if($poster['cscore']>0 || $poster['cscorehb']>0){
                      if($hmember['status']==1){
                        exit;
                      }
                      $info2=str_replace('#昵称#',$fans['nickname'], $poster['utips']);
                      $info2=str_replace('#积分#',$poster['cscore'], $info2);
                      $info2=str_replace('#元#',$poster['cscorehb'], $info2);
                      if($poster['cscore']){mc_credit_update($hmember['openid'],'credit1',$poster['cscore'],array($hmember['openid'],'2级推广奖励'));}
                      if($poster['cscorehb']){mc_credit_update($hmember['openid'],'credit2',$poster['cscorehb'],array($hmember['openid'],'2级推广奖励'));}      
                      $this->sendtext($info2,$hmember['from_user']);
                      //$this->postText($hmember['from_user'],$info2);
                    }
                    if($poster['pscore']>0 || $poster['pscorehb']>0){
                      $fmember=pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_share')." WHERE weid = :weid and openid=:openid", array(':weid' => $_W['uniacid'],':openid'=>$hmember['helpid']));
                      if($fmember['status']==1){
                        exit;
                      }
                        if($fmember){
                            $info3=str_replace('#昵称#',$fans['nickname'], $poster['utips2']);
                            $info3=str_replace('#积分#',$poster['pscore'], $info3);
                            $info3=str_replace('#元#',$poster['pscorehb'], $info3);
                            if($poster['pscore']){mc_credit_update($fmember['openid'],'credit1',$poster['pscore'],array($hmember['openid'],'3级推广奖励'));}
                            if($poster['pscorehb']){mc_credit_update($fmember['openid'],'credit2',$poster['pscorehb'],array($hmember['openid'],'3级推广奖励'));}        
                            $this->sendtext($info3,$fmember['from_user']);
                            //$this->postText($fmember['from_user'],$info3);   
                        }
                    }
                   
                }else{
                  $this->sendtext('亲，您已经是粉丝了，快去生成海报赚取奖励吧',$from_user);
                  //$this->postText($this->message['from'],'亲，您已经是会员了，快去生成海报赚取奖励吧');  
                }
               
              //return $this->PostNews($poster,$fans['nickname']);//关注推送图文
    }

    /**
	 * @name 	单发模式
	 * @param 	openid 		粉丝编号
	 * @param 	tplmsgid	模版消息id
	 * @param 	data 		数据包
     * @param 	data1 		客服消息信息
	 * @param 	url 		跳转地址
	 */
	public function sendMsg($openid, $tplmsgid, $data = array(),$data1,$url ="") {
		global $_W;
        $cfg = $this->module['config'];
		if (!empty($data)) {
			//记录存在 | 发送接口
			$account = WeAccount::create($_W['account']['acid']);
			//公号类型
			if (empty($tplmsgid)) {
				//订阅号 | 客服消息
				$this->postText($this->message['from'],$data1);
			} elseif ($_W['account']['level'] == 4) {
				//服务号 | 模板消息
                return $account->sendTplNotice($openid, $tplmsgid, $data, $url);
			}
		}
	}

    /**
        $openid 通知OPENID
        $mb 模版消息信息
        $mbid  模版ID
        $url  模版消息链接
        $fans  粉丝信息
        $orderid 订单号
        $cfg 配置信息

    **/
    public function mbmsg($openid,$mb,$mbid,$url='',$fans,$orderid,$cfg='',$valuedata=''){//发送模版消息
       global $_W;   
//       $valuedata=array(
//           'rmb'=>'12',
//           'txzhanghao'=>'qqqq@qq.com',//提现支付帐帐号
//           'msg'=>'这是自定义的内容',
//           'tel'=>'13878777777',
//           'weixin'=>'xiaohu-111',
//           'shenhe'=>'审核通过|审核不通过|资料有误请重新提交审核',
//           'goodstitle'=>'积分商城，商品名称'
//       );
       $tp_value1 = unserialize($mb['zjvalue']);
       $tp_value1=str_replace('#时间#',date('Y-m-d H:i:s',time()),$tp_value1);
       $tp_value1=str_replace('#昵称#',$fans['nickname'],$tp_value1);
       $tp_value1=str_replace('#订单号#',$orderid,$tp_value1);
       if(!empty($valuedata)){
           $tp_value1=str_replace('#提现金额#',$valuedata['rmb'],$tp_value1);
           $tp_value1=str_replace('#提现账号#',$valuedata['txzhanghao'],$tp_value1);
           $tp_value1=str_replace('#微信号#',$valuedata['weixin'],$tp_value1);
           $tp_value1=str_replace('#手机号#',$valuedata['tel'],$tp_value1);
       }       
       $tp_color1 = unserialize($mb['zjcolor']);
       //file_put_contents(IA_ROOT."/addons/tiger_renwubao/log.txt","\n 2old:".json_encode($orderid),FILE_APPEND);
       $mb['first']=str_replace('#时间#',date('Y-m-d H:i:s',time()),$mb['first']);
       $mb['first']=str_replace('#昵称#',$fans['nickname'],$mb['first']);
       $mb['first']=str_replace('#订单号#',$orderid,$mb['first']);

       $tplist1=array(
            'first' => array(
            'value' => $mb['first'],
            "color" => $mb['firstcolor']
          )
        );
       foreach ($tp_value1 as $key => $value) {  
            if(empty($value)){
              continue;
            }
            $tplist1['keyword'.$key] = array('value'=>$value,'color'=>$tp_color1[$key]);
        }
        $mb['remark']=str_replace('#时间#',date('Y-m-d H:i:s',time()),$mb['remark']);
        $mb['remark']=str_replace('#昵称#',$fans['nickname'],$mb['remark']);
        $mb['remark']=str_replace('#订单号#',$orderid,$mb['remark']);

        $tplist1['remark']=array(
            'value' => $mb['remark'],
            "color" => $mb['remarkcolor']
        );
       $msg=$this->sendMsg($openid,$mbid,$tplist1,'',$url);
       return $msg;
   }



    public function doMobileReg() {//注册
        global $_W,$_GPC;
        $cfg = $this->module['config'];        
        $helpid=$_GPC['hid'];
        $fans=mc_oauth_userinfo();
        if(empty($fans['openid'])){
          echo '只能在微信浏览器中打开！';
        }

        $fans = mc_fetch($_W['fans']['from_user']);
        $share=pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_share')." WHERE weid = :weid and openid=:openid", array(':weid' => $_W['uniacid'],':openid'=>$fans['uid']));

        if(!empty($share['tel'])){
            $url=$this->createMobileurl('goods');
            header("location:".$url);
            exit;
        }


        if (checksubmit('submit')){
            $config = $this->module['config'];
            $openid = $_W['openid'];
            $mobile = trim($_GPC['mobile']);
            $verify = trim($_GPC['smsCode']);
            //$realname = $_GPC['realname'];
            //$password = random(6);
            load()->model('utility');
            if(!code_verify($_W['uniacid'], $mobile, $verify)) {
                //exit('验证码错误.');
                message('验证码错误', referer(), 'error');
            }
            $user = pdo_fetch("SELECT * FROM ".tablename($this->modulename."_share")." WHERE tel=:tel AND id<>:id",array(':tel'=>$mobile,':id'=>$share['id']));
            if (!empty($user)) {
                //exit('该手机号已注册其他微信，请先解绑后重试.');
                message('该手机号已注册其他微信，请先解绑后重试', referer(), 'error');
            }
            //echo $mobile;
            //exit;
            $result = pdo_update($this->modulename."_share", array('tel' => $mobile), array('id' =>$share['id'], 'weid' => $_W['uniacid']));
            if($result){              
               message('验证成功', $this -> createMobileurl('goods'), 'success');
            }else{
              message('异常错误', referer(), 'error');
            }

        }
        
		include $this -> template('reg');
	}


    //现金红包接口
   function post_txhb($cfg,$openid,$dtotal_amount,$desc,$dmch_billno) {
       global $_W;
       load()->model('mc');
       

       //提现金额限制开始
       if(!empty($desc)){
         $fans = mc_fetch($_W['openid']);
         $dtotal=$dtotal_amount/100;
         //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($dtotal."||||".$desc."||||".$fans['credit2']),FILE_APPEND);
         
         if($dtotal>$fans['credit2']){
            $ret['code']=-1;
            $ret['dissuccess']=0;
            $ret['message']='余额不足';
            return $ret; 
            exit;
         }
       }
       if(empty($dmch_billno)){
         $dmch_billno=random(10). date('Ymd') . random(3);
       }
       
       //提现金额限制结束
       $root=IA_ROOT . '/attachment/tiger_newhu/cert/'.$_W['uniacid'].'/';
   	   $ret=array();
       $ret['code']=0;
       $ret['message']="success";     
   //  return $ret;  	
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        $pars = array();
        $pars['nonce_str'] = random(32);
        $pars['mch_billno'] =$dmch_billno;
        $pars['mch_id'] = $cfg['mchid'];
        $pars['wxappid'] = $cfg['appid'];
        $pars['nick_name'] =   $_W['account']['name'];
        $pars['send_name'] = $_W['account']['name'];
        $pars['re_openid'] = $openid;
        $pars['total_amount'] = $dtotal_amount;
        $pars['min_value'] = $dtotal_amount;
        $pars['max_value'] = $dtotal_amount;
        $pars['total_num'] = 1;
        $pars['wishing'] = '提现红包成功!';
        $pars['client_ip'] = $cfg['client_ip'];
        $pars['act_name'] =  '兑换红包';
        $pars['remark'] = "来自".$_W['account']['name']."的红包";

        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key={$cfg['apikey']}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();
        //$cert=json_decode($cfg['nbfwxpaypath']);

        $extras['CURLOPT_CAINFO']= $root.'rootca.pem';
        $extras['CURLOPT_SSLCERT'] =$root.'apiclient_cert.pem';
        $extras['CURLOPT_SSLKEY'] =$root.'apiclient_key.pem';
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($extras['CURLOPT_CAINFO']),FILE_APPEND);

        load()->func('communication');
        $procResult = null; 
        $resp = ihttp_request($url, $xml, $extras);
        if(is_error($resp)) {
            $procResult = $resp["message"];
            $ret['code']=-1;
            $ret['dissuccess']=0;
            $ret['message']=$procResult;
            return $ret;     
        } else {
            $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
            $dom = new DOMDocument();
             if($dom->loadXML($xml)) {
                $xpath = new DOMXPath($dom);
                $code = $xpath->evaluate('string(//xml/return_code)');
                $result = $xpath->evaluate('string(//xml/result_code)');
                if(strtolower($code) == 'success' && strtolower($result) == 'success') {
                    $ret['code']=0;
                    $ret['dissuccess']=1;
                    $ret['message']="success";
                    return $ret;
                  
                } else {
                    $error = $xpath->evaluate('string(//xml/err_code_des)');
                    $ret['code']=-2;
                    $ret['dissuccess']=0;
                    $ret['message']=$error;
                    return $ret;
                 }
            } else {
                $ret['code']=-3;
                $ret['dissuccess']=0;
                $ret['message']="3error3";
                return $ret;
            }
            
        }     
    }


    //企业零钱付款接口
  public function post_qyfk($cfg,$openid,$amount,$desc,$dmch_billno){
    global $_W;
    load()->model('mc');
    //提现金额限制开始
       if(!empty($desc)){
         $fans = mc_fetch($_W['openid']);
         $dtotal=$amount/100;
         //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($dtotal."||||".$desc."||||".$fans['credit2']),FILE_APPEND);         
         if($dtotal>$fans['credit2']){
            $ret['code']=-1;
            $ret['dissuccess']=0;
            $ret['message']='余额不足';
            return $ret; 
            exit;
         }
       }
      if(empty($dmch_billno)){
         $dmch_billno=random(10). date('Ymd') . random(3);
       }
       //提现金额限制结束
    $root=IA_ROOT . '/attachment/tiger_newhu/cert/'.$_W['uniacid'].'/';
    $ret=array();
  	$ret['code']=0;
    $ret['message']="success";     
  
    $ret['amount']=$amount;
    $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
    $pars = array();
    $pars['mch_appid'] =$cfg['appid'];
    $pars['mchid'] = $cfg['mchid'];
    $pars['nonce_str'] = random(32);
    $pars['partner_trade_no'] =$dmch_billno;
    $pars['openid'] =$openid;
    $pars['check_name'] = "NO_CHECK";
    $pars['amount'] =$amount;
    $pars['desc'] = "来自".$_W['account']['name']."的提现";
    $pars['spbill_create_ip'] =$cfg['client_ip']; 
    ksort($pars, SORT_STRING);
        $string1 = '';
        foreach($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key={$cfg['apikey']}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        //$cert=json_decode($cfg['nbfwxpaypath']);
        $extras = array();
        $extras['CURLOPT_CAINFO']= $root.'rootca.pem';
        $extras['CURLOPT_SSLCERT'] =$root.'apiclient_cert.pem';
        $extras['CURLOPT_SSLKEY'] =$root.'apiclient_key.pem';
 
     
        load()->func('communication');
        $procResult = null; 
        $resp = ihttp_request($url, $xml, $extras);
        if(is_error($resp)) {
            $procResult = $resp['message'];
            $ret['code']=-1;
            $ret['dissuccess']=0;
            $ret['message']="-1:".$procResult;
            return $ret;            
         } else {        	
            $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
            $dom = new DOMDocument();
            if($dom->loadXML($xml)) {
                $xpath = new DOMXPath($dom);
                $code = $xpath->evaluate('string(//xml/return_code)');
                $result = $xpath->evaluate('string(//xml/result_code)');
                if(strtolower($code) == 'success' && strtolower($result) == 'success') {
                    $ret['code']=0;
                    $ret['dissuccess']=1;
                    $ret['message']="success";
                    return $ret;
                  
                } else {
                    $error = $xpath->evaluate('string(//xml/err_code_des)');
                    $ret['code']=-2;
                    $ret['dissuccess']=0;
                    $ret['message']="-2:".$error;
                    return $ret;
                 }
            } else {
                $ret['code']=-3;
                $ret['dissuccess']=0;
                $ret['message']="error response";
                return $ret;
            }
        }
    
   }

	
	public function getAccountLevel(){
		global $_W;
		load()->classs('weixin.account');
		$accObj = WeixinAccount::create($_W['uniacid']);
		$account = $accObj->account;
		return $account['level'];
	}

    
     /*************************短信验证*****************************/

/*
    public function doMobileSendsms() {
        global $_W,$_GPC;
        file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode('asss'),FILE_APPEND);
        if(!$_W['isajax'])die(json_encode(array('success'=>false,'msg'=>'非法提交,只能通过网站提交')));

        die(json_encode(array('success'=>true,'info'=>"22222")));
        
	}
    */
	private function SendSMS($mobile,$content) {
		$config = $this->module['config'];
        
		load()->func('communication');
		if ($config['smstype'] == 'juhesj') {
			$jhappkey = $config['jhappkey'];
            $jhcode = $config['jhcode'];
            //http://v.juhe.cn/sms/send?mobile=手机号码&tpl_id=短信模板ID&tpl_value=%23code%23%3D654654&key=
			//$result = ihttp_get("http://api.smsbao.com/sms?u={$user}&p={$pass}&m=".$mobile."&c=".urlencode($content));
            $json = ihttp_get("http://v.juhe.cn/sms/send?mobile={$mobile}&tpl_id={$jhcode}&tpl_value={$content}&key={$jhappkey}");
            $result = @json_decode($json['content'], true);
            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($result),FILE_APPEND);
			if ($json['code'] == 200) {
                if($result['error_code']==0){
                  $content=0;
                }else{
                  $content=$result['error_code'].$result['reason'];
                }
			}else{
				$content = '接口调用错误.';
			}
			return $content;
		}else {
			if (empty($config['dyAppKey']) || empty($config['dyAppSecret']) || empty($config['dysms_free_sign_name']) || empty($config['dysms_template_code'])) {
				return '短信参数配置不正确，请联系管理员';
			}else{
				include IA_ROOT . "/addons/tiger_newhu/inc/sdk/dayu/TopSdk.php";
				$c = new TopClient;
				$c->appkey = $config['dyAppKey'];
				$c->secretKey = $config['dyAppSecret'];
				$req = new AlibabaAliqinFcSmsNumSendRequest;
				$req->setSmsType("normal");
				$req->setSmsFreeSignName($config['dysms_free_sign_name']);
				$req->setSmsParam($content);
				$req->setRecNum($mobile);
				$req->setSmsTemplateCode($config['dysms_template_code']);
				$resp = $c->execute($req);
                file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($resp),FILE_APPEND);
				if ($resp->result->err_code == 0) {
					return 0;
				}else{
					return $resp->sub_msg;
				}
			}
		}
		
	}
    /*************************短信结束****************************/


    public function doMobileDuibaxf(){
      global $_W, $_GPC;
        include 'duiba.php';
        $cfg=$this->module['config'];
        $settings = $this->module['config'];
        $request_array = $_GPC;
        $uid = $request_array['uid'];
        foreach ($request_array as $key => $val) {
            //$unsetkeyarr = array('i', 'do', 'm', 'c');
            $unsetkeyarr = array('i', 'do', 'm', 'c','module_status:1','module_status:tiger_shouquan','module_status:tiger_newhu','notice','state');
            if (in_array($key, $unsetkeyarr) || strstr($key, '__')) {
                unset($request_array[$key]);
            }
        }
        file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/log.txt","\n old:".json_encode($request_array),FILE_APPEND);
        $ret = parseCreditConsume($settings['AppKey'], $settings['appSecret'], $request_array);
        //$res=  parseCreditConsume($cfg['AppKey'],$cfg['appSecret'],$request_array);
         //file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/log.txt","\n old2:".json_encode($ret),FILE_APPEND);
        

        if (is_array($ret)) {
            $insert = array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'bizId' => date('YmdHi') . random(8, 1), 'orderNum' => $request_array["orderNum"], 'credits' => $request_array["credits"], 'params' => $request_array["params"], 'type' => $request_array["type"], 'ip' => $request_array["ip"], 'starttimestamp' => $request_array["timestamp"], 'waitAudit' => $request_array["waitAudit"], 'actualPrice' => $request_array["actualPrice"], 'description' => $request_array["description"], 'facePrice' => $request_array["facePrice"], 'Audituser' => $request_array["Audituser"], 'itemCode' => $request_array["itemCode"], 'status' => 0, 'createtime' => time());
            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($insert),FILE_APPEND);
            pdo_insert($this->modulename."_dborder", $insert);
            if (pdo_insertid()) {
                //load()->model('mc');
                //$usercredits = mc_credit_fetch($uid, $types = array('credit1'));
                $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");                
                $yue = intval($share['credit1']) - $request_array["credits"];
                if ($yue > 0) {
                    //$updatecredit = mc_credit_update($uid, 'credit1', -abs($request_array["credits"]), array("积分宝", "兑吧兑换" . $request_array["description"], 'tiger_newhu'));
                    $updatecredit=$this->mc_jl($uid,0,9,-abs($request_array["credits"]),'兑吧兑换'.$request_array["description"],'');
                    if ($updatecredit['error']==1) {
                        exit(json_encode(array('status' => 'ok', 'errorMessage' => "", 'bizId' => $insert['bizId'], 'credits' => $yue)));
                    } else {
                        exit(json_encode(array('status' => 'fail', 'errorMessage' => "扣除{$cfg['hztype']}错误", 'credits' => $request_array["credits"])));
                    }
                } else {
                    exit(json_encode(array('status' => 'fail', 'errorMessage' => "积分不足", 'credits' => $request_array["credits"])));
                }
            } else {
                exit(json_encode(array('status' => 'fail', 'errorMessage' => "系统错误，请重试！", 'credits' => $request_array["credits"])));
            }
        } else {
            exit(json_encode(array('status' => 'fail', 'errorMessage' => $ret, 'credits' => $request_array["credits"])));
        }
    }


    public function postgoods($goods,$openid){//发送图文消息
        global $_W;
        
        foreach ($goods as $key => $value) {
            $viewurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('view',array('itemid'=>$value['itemid'])));
            $response[] = array(
                'title' => urlencode("【券后价:".$value['itemendprice']."】".$value['itemtitle']),
                'description' => urlencode($value['itemtitle']),
                'picurl' => tomedia($value['itemtitle']."_100x100.jpg"),
                'url' =>$viewurl
            );
        }

        $message = array(
            'touser' => trim($openid),
            'msgtype' => 'news',
            'news' => array('articles'=>$response)
        );

       
       $acid = $_W['acid'];
		if (empty($acid)) {
			$acid = $_W['uniacid'];
		}
       $account_api = WeAccount::create($acid);
       $status = $account_api->sendCustomNotice($message);
       return $status;
	}
	
	
	
	
}