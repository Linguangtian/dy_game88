<?php
/**
 *
 * @author junsion
 * @url http://s.we7.cc/index.php?c=store&a=author&uid=74516
 */
defined('IN_IA') or exit('Access Denied');
define('OD_ROOT', IA_ROOT . '/addons/junsion_winaward/cert/');
require_once IA_ROOT.'/addons/junsion_winaward/func.php';
class junsion_winawardModule extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		$poster = unserialize($settings['poster']);
		$serve_wechat = pdo_fetchall('select `name`,uniacid from ' .tablename('account_wechats'). " where level=4");
		if(!empty($settings['mids'])){
			$settings['mids'] = str_replace(',,', ',', $settings['mids']);
			$mems = pdo_fetchall('select id,nickname from ' . tablename('junsion_winaward_mem') . " where id in ({$settings['mids']})");
		}
		if(!empty($settings['invite']['gid'])){
			$good = get('select id,title,sub_title from ' .tb('good'). " where id='{$settings['invite']['gid']}'");
		}
		if (checksubmit('submit')){
			
			if ($_GPC['commission']['status']==1 || !empty($_GPC['agent']['status'])){
				$total_rate1 = $_GPC['commission']['rate'] + $_GPC['commission']['redRate'];
				if($_GPC['agent']['status']==1){
					$total_rate2 = $_GPC['agent']['rate1'] + $_GPC['agent']['redRate1'];
				}
				if($total_rate1 > 100 || $total_rate2){
					message('分销佣金或代理佣金比例总和不能大于100', referer(), 'error');
				}
			}
			if ($_GPC['commission']['status']==2 || !empty($_GPC['agent']['status'])){
				$total_rate1 = $_GPC['commission']['rate'] + $_GPC['commission']['redRate'] + $_GPC['commission']['rate2'] + $_GPC['commission']['redRate2'];
				if($_GPC['agent']['status']==1){
					$total_rate2 = $_GPC['commission']['rate2'] + $_GPC['commission']['redRate2'] + $_GPC['agent']['rate1'] + $_GPC['agent']['redRate1'];
				}
				if($_GPC['agent']['status']==2){
					$total_rate3 = $_GPC['agent']['rate1'] + $_GPC['agent']['redRate1'] + $_GPC['agent']['rate2'] + $_GPC['agent']['redRate2'];
						
				}
				if($total_rate1 > 100 || $total_rate2>100 || $total_rate3>100){
					message('分销佣金或代理佣金比例总和不能大于100', referer(), 'error');
				}
			}
			if ($_GPC['commission']['status']==3 || !empty($_GPC['agent']['status'])){
				$total_rate1 = $_GPC['commission']['rate'] + $_GPC['commission']['redRate'] + $_GPC['commission']['rate2'] + $_GPC['commission']['redRate2'] + $_GPC['commission']['rate3'] + $_GPC['commission']['redRate3'];
				if($_GPC['agent']['status']==1){
					$total_rate2 = $_GPC['commission']['rate3'] + $_GPC['commission']['redRate3'] + $_GPC['commission']['rate2'] + $_GPC['commission']['redRate2'] + $_GPC['agent']['rate1'] + $_GPC['agent']['redRate1'];
				}
				if($_GPC['agent']['status']==2){
					$total_rate3 = $_GPC['commission']['rate3'] + $_GPC['commission']['redRate3'] + $_GPC['agent']['rate2'] + $_GPC['agent']['redRate2'] + $_GPC['agent']['rate1'] + $_GPC['agent']['redRate1'];
				}
				if($_GPC['agent']['status']==3){
					$total_rate4 = $_GPC['agent']['rate3'] + $_GPC['agent']['redRate3'] + $_GPC['agent']['rate2'] + $_GPC['agent']['redRate2'] + $_GPC['agent']['rate1'] + $_GPC['agent']['redRate1'];
				}
				if($total_rate1 > 100 || $total_rate2>100 || $total_rate3>100 || $total_rate3>100){
					message('分销佣金或代理佣金比例总和不能大于100', referer(), 'error');
				}
			}
			
			$recharge = array();
			$recharge_money = $_GPC['money'];
			if(!empty($recharge_money)){
				foreach ($recharge_money as $k => $v){
					if(!empty($v)){
						$recharge[] = array(
								'money' => $v,
						);
					}
				}
			}
			$notice = array();
			$notice_txt = $_GPC['notice_txt'];
			if(!empty($notice_txt)){
				foreach ($notice_txt as $k => $v){
					if(!empty($v)){
						$notice[] = array(
								'txt' => $v,
								'appid' => $_GPC['notice_appid'][$k],
								'url' => $_GPC['notice_url'][$k]
						);
					}
				}
			}
			$home_adv = array();
			$home_picurl = $_GPC['home_picurl'];
			if (!empty($home_picurl)){
				foreach ($home_picurl as $key => $value) {
					if (!empty($value)){
						$home_adv[] = array(
								'pic'=>$value,
								'appid'=>trim($_GPC['home_appid'][$key]),
								'link'=>trim($_GPC['home_link'][$key]),
								'sort'=>$_GPC['home_sort'][$key],
						);
					}
				}
				array_multisort($_GPC['home_sort'],SORT_DESC,$home_adv);
			}
			
			$footer = array();
			$footer_img = $_GPC['footer_img'];
			if(!empty($footer_img)){
				foreach ($footer_img as $k => $v){
					if(!empty($v)){
						$footer[] = array(
								'img' => $v,
								'title' => $_GPC['footer_title'][$k],
								'url' => $_GPC['footer_url'][$k]
						);
					}
				}
			}
			
			$_GPC['poster']['data'] = json_decode(htmlspecialchars_decode($_GPC['poster']['data']),true);
			$dat = array(
					'limit' => $_GPC['limit'],
					'eespay' => $_GPC['eespay'],
					'codepay' => $_GPC['codepay'],
					'rainpay' => isSelfHost(3)?$_GPC['rainpay']:'',
					'APPKEY1' => $_GPC['APPKEY1'],
					'mchid1' => $_GPC['mchid1'],
					'ip1' => $_GPC['ip1'],
					'appid1' => $_GPC['appid1'],
					'APPKEY' => $_GPC['APPKEY'],
					'mchid' => $_GPC['mchid'],
					'ip' => $_GPC['ip'],
					'appid' => $_GPC['appid'],
					'appversion' => $_GPC['appversion'],
					'wxapp_pic' => $_GPC['wxapp_pic'],
					'wxapp_title' => $_GPC['wxapp_title'],
					'title' => $_GPC['title'],
					'copyright' => $_GPC['copyright'],
					'wxNo' => $_GPC['wxNo'],
					'wxTip' => $_GPC['wxTip'],
					'isTip' => $_GPC['isTip'],
					'mids' => $_GPC['mids'],
					'maxMoney' => $_GPC['maxMoney'],
					'isIos' => intval($_GPC['isIos']),
					'share' => $_GPC['share'],
					'music' => $_GPC['music'],
					'video' => $_GPC['video'],
					'color' => $_GPC['color'],
					'color1' => $_GPC['color1'],
					'color2' => $_GPC['color2'],
					'fcolor' => $_GPC['fcolor'],
					'fcolor1' => $_GPC['fcolor1'],
					'face' => $_GPC['face'],
					'font' => $_GPC['font'],
					'commission' => $_GPC['commission'],
					'agent' => $_GPC['agent'],
					'game' => $_GPC['game'],
					'recharge' => $recharge,
					'nTip' => $_GPC['nTip'],
					'notice' => $notice,
					'home_adv' => $home_adv,
					'poster' => serialize($_GPC['poster']),
					'agreement' => htmlspecialchars_decode($_GPC['agreement']),
					'agreement1' => $_GPC['agreement1'],
					'level_des' => $_GPC['level_des'],
					'isdouble' => $_GPC['isdouble'],
					'islevel' => $_GPC['islevel'],
					'invite' => isSelfHost(4)?$_GPC['invite']:'',
					'footer' => $footer,
			);
			//微信支付商户功能参数设置
			load()->func('file');
			mkdirs(OD_ROOT);
			$r = true;
			if(!empty($_GPC['cert'])) {
				$ret = file_put_contents(OD_ROOT .md5("apiclient_{$_W['uniacid']}cert").".pem", trim($_GPC['cert']));
				$r = $r && $ret;
			}
			if(!empty($_GPC['key'])) {
				$ret = file_put_contents(OD_ROOT .md5("apiclient_{$_W['uniacid']}key").".pem", trim($_GPC['key']));
				$r = $r && $ret;
			}
			if(!empty($_GPC['cert1'])) {
				$ret = file_put_contents(OD_ROOT .md5("apiclient_{$_W['uniacid']}cert1").".pem", trim($_GPC['cert1']));
				$r = $r && $ret;
			}
			if(!empty($_GPC['key1'])) {
				$ret = file_put_contents(OD_ROOT .md5("apiclient_{$_W['uniacid']}key1").".pem", trim($_GPC['key1']));
				$r = $r && $ret;
			}
			if(!$r) {
				message('证书保存失败, 请保证 '.OD_ROOT.' 目录可写');
			}
			if ($this->saveSettings($dat)) {
				message ( '保存成功', 'refresh' );
			}
		}
		
		include $this->template('setting');
	}

}
