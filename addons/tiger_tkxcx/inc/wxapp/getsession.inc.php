<?php  
	require_once IA_ROOT.'/addons/tiger_tkxcx/inc/sdk/wxBizDataCrypt.php';
global $_W,$_GPC;
		$weid=$this->wid;//绑定公众号的ID
		$cfg=$this->cfg;//绑定公众号的配置数据
		$xcxcfg=$this->xcxcfg;//小程序配置数据
		$wxapp = pdo_fetch("select * from ".tablename("account_wxapp")." where uniacid='{$_W['uniacid']}'");
		$code = $_GPC['code'];	
		$helpid = $_GPC['helpid'];	
		$iv=$_GPC['iv'];	
		$encryptedData=$_GPC['encryptedData'];
		$fans=$_W['fans'];
		
		//user={"nickName":"胡跃结","gender":1,"language":"zh_CN","city":"Jinhua","province":"Zhejiang","country":"China","avatarUrl":"https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83erW1nyiavocyun8lCu1mCEGhrTC2DwaAb5z7jj2cxTY8hAiaRlp4vQWGk0NxXNiatVN3uQH20moOicPqQ/0"}
		$url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$wxapp['key'].'&secret='.$wxapp['secret'].'&js_code='.$code.'&grant_type=authorization_code';
        $ret = ihttp_request($url);
        $res=json_decode($ret['content'],true);//"{"session_key":"1CGPN8XI6xCpIGPp23Y4zQ==","openid":"oJn7q4qlxVJ72k7UsbFdWsQvj-k0","unionid":"oQIJFt1iZEnG7gyslZbtohD2RJN4"}"
        
        if(empty($fans['unionid'])){
        	if(empty($res['unionid'])){
	        	$appid=$wxapp['key'];
				$sessionKey=$res['session_key'];
				$pc = new WXBizDataCrypt($appid, $sessionKey);
				$errCode = $pc->decryptData($encryptedData, $iv, $data );
				file_put_contents(IA_ROOT."/addons/tiger_tkxcx/newuser_log.txt","\nerror:".json_encode($errCode).$data,FILE_APPEND);
				$newdata=json_decode($data,true);
				file_put_contents(IA_ROOT."/addons/tiger_tkxcx/newuser_log.txt","\njiexi-uni:".$iv.'----'.$encryptedData."---".$appid."----".$sessionKey."----".$data."----".json_encode($udata),FILE_APPEND);
				$unionid=$newdata['unionId'];
	        }else{
	        	$unionid=$res['unionid'];
	        }
        }else{
        	$unionid=$fans['unionid'];
        }
        
					
        $udata=array(
			'nickname'=>$_GPC['nickName'],
			'gender'=>$_GPC['gender'],
			'language'=>$_GPC['language'],
			'city'=>$_GPC['city'],
			'province'=>$_GPC['province'],
			'country'=>$_GPC['country'],
			'avatar'=>$_GPC['avatarUrl'],
			'openid'=>$res['openid'],
			'unionid'=>$unionid,
		);
		//$this->result(0, 'OK', array('data' =>$ret)); 

		$helpid=$_GPC['helpid'];//上级ID
		file_put_contents(IA_ROOT."/addons/tiger_tkxcx/newuser_log.txt","\nupdata:".json_encode($udata),FILE_APPEND);
		$share=$this->getmember($udata,'',$helpid,$weid);
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
			$this->result(1, 'NO', array('data' =>array('dlptpid'=>$cfg['dlptpid']))); 
		}else{
			$this->result(0, 'OK'.$_W['uniacid'], array('data' =>$share)); 
		}	
?>