<?php  
        global $_W,$_GPC;
		$weid=$this->wid;//绑定公众号的ID
		$cfg=$this->cfg;//绑定公众号的配置数据
		$xcxcfg=$this->xcxcfg;//小程序配置数据
		$wxapp = pdo_fetch("select * from ".tablename("account_wxapp")." where uniacid='{$_W['uniacid']}'");
		$yaoqingma = $_GPC['yaoqingma'];	
		$jctype = $_GPC['jctype'];//2 查找会员存不存在，如果不存在，必须要传邀请码
		if($jctype==2){
			$shshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$weid}' and uniacid='{$_GPC['unionid']}'");
			if(empty($shshare)){
				$this->result(2, '请填写邀请码！', array('data' =>'')); 
			}
		}
		
	
        $udata=array(
			'nickname'=>$_GPC['nickname'],
			'gender'=>$_GPC['sex'],
			'language'=>$_GPC['language'],
			'city'=>$_GPC['city'],
			'province'=>$_GPC['province'],
			'country'=>$_GPC['country'],
			'avatar'=>$_GPC['avatar'],
			'openid'=>$_GPC['openid'],
			'unionid'=>$_GPC['unionid'],
		);


		$helpid=$_GPC['helpid'];//上级ID
		file_put_contents(IA_ROOT."/addons/tiger_tkxcx/anewuser_log.txt","\nupdata:".json_encode($_GPC),FILE_APPEND);
		$share=$this->appgetmember($udata,'',$yaoqingma,$weid);
		if($share['dltype']==1){//是代理
			if(empty($share['dlptpid'])){//如果是代理，PID没填写就默认公众号PID
				$s=pdo_fetch("select settings from ".tablename('uni_account_modules')." where module='tiger_newhu' and uniacid='{$weid}'");
	    		$cfg=unserialize($s['settings']);
				$share['dlptpid']=$cfg['ptpid'];
			}
		}else{//不是代理
			if(!empty($share['helpid'])){//查看有没有上级
				$shshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$weid}' and id='{$share['helpid']}'");
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
		
		if(empty($share['dlptpid'])){//保险一下，在判断一下有没有PID，没有就直接用公众号的PID
			$s=pdo_fetch("select settings from ".tablename('uni_account_modules')." where module='tiger_newhu' and uniacid='{$weid}'");
    		$cfg=unserialize($s['settings']);
			$share['dlptpid']=$cfg['ptpid'];
		}
		
		$share['lm']=$cfg['mmtype'];
		$share['sharetitle']=$xcxcfg['sharetitle'];
		$share['cjsimg']=$xcxcfg['cjsimg'];
		$share['credit1']=intval($share['credit1']);
		
		

		if(empty($share['id'])){
			$this->result(1, 'NO', array('data' =>'')); 
		}else{
			$this->result(0, 'OK', array('data' =>$share)); 
		}	
?>