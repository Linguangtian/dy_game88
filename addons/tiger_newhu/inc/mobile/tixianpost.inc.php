<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];
//       $fans = mc_oauth_userinfo();
//	   $fans = $_W['fans'];
//       
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	echo "请在微信端打开!";
	        	exit;
	        }	        
        }
        $mc=mc_fetch($fans['openid']);
        $share = pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");


       
       
       if($share['credit2']>=$cfg['yjtype']){
           $pice=intval($share['credit2']);
           if(empty($pice)){
             die(json_encode(array("statusCode"=>2000,"message"=>"佣金提现最少".$cfg['yjtype']."元起")));
           }
            //mc_credit_update($mc['uid'],'credit2',-$pice,array($mc['uid'],'淘客佣金提现'));  
            $this->mc_jl($share['id'],1,7,-$pice,'奖励提现','');
            //当前用户
            

            $data=array(
                'weid'=>$_W['uniacid'],
                'uid'=>$share['id'],
                'nickname'=>$fans['nickname'],
                'openid'=>$fans['openid'],
                'avatar'=>$fans['avatar'],
                'createtime'=>TIMESTAMP,
                'credit2'=>$pice,
                'zfbuid'=>$_GPC['zfbuid'],
                'sh'=>0,
                'dmch_billno'=>$fans['dmch_billno']          
            );
            if (pdo_insert ( $this->modulename . "_txlog", $data ) === false) {
                die(json_encode(array("statusCode"=>100,'msg'=>'系统繁忙！')));  
            } else{
                if(!empty($cfg['khgettx'])){//管理员提现提醒
                    $mbid=$cfg['khgettx'];
                    $mb=pdo_fetch("select * from ".tablename($this->modulename."_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
                     $valuedata=array(
			             'rmb'=>$pice,
			             'txzhanghao'=>$share['zfbuid'],//提现支付帐帐号
			             'msg'=>'',
			             'tel'=>$share['tel'],
			             'weixin'=>$share['weixin'],
			             'shenhe'=>'',//'审核通过|审核不通过|资料有误请重新提交审核',
			             'goodstitle'=>''//'积分商城，商品名称'
			         );
                    $msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,'',$cfg,$valuedata);                  
                }             

                die(json_encode(array("statusCode"=>200,'msg'=>'')));  
            }
       }else{
          die(json_encode(array("statusCode"=>2000,"message"=>"佣金提现最少".$cfg['yjtype']."元起")));
       }