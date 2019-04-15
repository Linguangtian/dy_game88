<?php
global $_W,$_GPC;
		$pid = $_GPC['pid'];
		$uid = $_GPC['uid'];
        $weid =$_W['uniacid'];
		$level = $_GPC['level'];
        $dluid=$_GPC['dluid'];//share id
        $cfg=$this->module['config']; 
        
        //统计我的积分和我的团队
        //echo $uid;
//        $userAgent = $_SERVER['HTTP_USER_AGENT'];
//		if (!strpos($userAgent, 'MicroMessenger')) {
//			message('请使用微信浏览器打开！');
//		}else{
//			load()->model('mc');
//			//$info = mc_oauth_userinfo();
//			$fans = $_W['fans'];
//			//$mc = mc_fetch($fans['uid'],array('nickname','avatar'));
//			$fans['avatar'] = $fans['tag']['avatar'];
//			$fans['nickname'] =$fans['tag']['nickname'];
//		}
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	echo "请在微信端打开!";
	        	exit;
	        }	        
        }

		$member = pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        $uid=$member['id'];
		$pid = $_GPC['pid'];

		$fans1=pdo_fetchall("select * from ".tablename($this->modulename."_share")." where weid='{$weid}' and helpid='{$uid}'",array(),'id');
		
		 
		
		$ids = array();
		foreach ($fans1 as $value) {
			$ids[] = $value['id'];
		}
		//echo '<pre>';
		//print_r($ids);
			
		if ($ids && $level == 1){
			//$fans2 = pdo_fetchall("select m.{$credittype} as credit,m.nickname,m.avatar,m.createtime from ".tablename($this->modulename."_share")." s join ".tablename('mc_members')." m on s.openid=m.uid join ".tablename('mc_mapping_fans')." f on s.openid=f.uid where s.weid='{$weid}' and s.helpid in (".implode(',',$ids).") and f.follow=1 order by m.{$credittype} desc");
			$fans2 = pdo_fetchall("select * from ".tablename($this->modulename."_share")." where weid='{$weid}' and helpid in (".implode(',',$ids).")  order by id desc");
		}
        $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
        include $this->template ('user/mfan2' );