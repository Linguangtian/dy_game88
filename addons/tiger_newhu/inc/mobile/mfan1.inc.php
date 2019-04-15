<?php
global $_W,$_GPC;
		$pid = $_GPC['pid'];
		$uid = $_GPC['uid'];
		$level = $_GPC['level'];
        $dluid=$_GPC['dluid'];//share id
        $cfg=$this->module['config']; 
        
        //echo 'aaaa';
        //echo $uid;
        //exit;

        //统计我的积分和我的团队
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
        }
		$pid = $_GPC['pid'];
        $weid =$_W['uniacid'];
        $member = pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
        $uid=$member['id'];

		$credit = 0;
		$creditname = '积分';
		$credittype = 'credit1';
		if ($poster['credit']){
			$creditname = '余额';
			$credittype = 'credit2';
		}
		if ($fans){
			$mc = mc_credit_fetch($fans['uid'],array($credittype));
			$credit = $mc[$credittype];
		}

        //结束
        $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单



		$credittype = 'credit1';
		if ($poster['credit']){
			$credittype = 'credit2';
		}
		//$fans1 = pdo_fetchall("select m.{$credittype} as credit,m.nickname,m.avatar,s.openid,m.createtime from ".tablename($this->modulename."_share")." s join ".tablename('mc_members')." m on s.openid=m.uid join ".tablename('mc_mapping_fans')." f on s.openid=f.uid where s.weid='{$weid}' and s.helpid='{$uid}' and f.follow=1 order by m.{$credittype} desc");
		$fans1=pdo_fetchall("select * from ".tablename($this->modulename."_share")." where weid='{$weid}' and helpid='{$uid}' order by id desc limit 100");

        include $this->template ( 'user/mfan1' );