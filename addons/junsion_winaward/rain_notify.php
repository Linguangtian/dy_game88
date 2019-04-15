<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
define('IN_MOBILE', true);
if ($_REQUEST['p4_zfstate'] != 1) return 'success';
require '../../framework/bootstrap.inc.php';
$param = $_REQUEST['p12_remark'];
$param = explode(':', $param);
$_W['uniacid'] = $_W['weid'] = $param[0];
$table = $param[1];

$cfg = pdo_fetch('select settings from '.tablename('uni_account_modules')." where uniacid='{$_W['uniacid']}' and module='junsion_winaward'");
if (empty($cfg['settings'])) exit('success');
$cfg = unserialize($cfg['settings']);
$rainpay_key = $cfg['rainpay']['key'];

$sign = $_REQUEST['p1_yingyongnum']."&".$_REQUEST['p2_ordernumber']."&".$_REQUEST['p3_money']."&".$_REQUEST['p4_zfstate']."&".$_REQUEST['p5_orderid']."&".$_REQUEST['p6_productcode']."&"
		.$_REQUEST['p7_bank_card_code']."&".$_REQUEST['p8_charset']."&".$_REQUEST['p9_signtype']."&".$_REQUEST['p11_pdesc']."&".$_REQUEST['p13_zfmoney']."&".$rainpay_key;

file_put_contents(IA_ROOT."/addons/junsion_winaward/rain_log", date('Y-m-d H:i:s')."： get:".json_encode($_REQUEST)." sign:".md5($sign)." rsign:".$_REQUEST['p10_sign']."\n",FILE_APPEND);

if (!$_REQUEST['p2_ordernumber'] || strtoupper(md5($sign)) != $_REQUEST['p10_sign']) { //不合法的数据
	exit('fail');  //返回失败 继续补单
} else { //合法的数据
	echo 'success';
	$site = WeUtility::createModuleSite('junsion_winaward');
	if(!is_error($site)) {
		$method = 'payResult';
		if (method_exists($site, $method)) {
			$ret = array();
			$ret['weid'] = $_W['weid'];
			$ret['uniacid'] = $_W['uniacid'];
			$ret['result'] = 'success';
			$ret['type'] = 'rain';
			$ret['from'] = 'notify';
			$ret['tid'] = $_REQUEST['p2_ordernumber'];
			$ret['table'] = $table;
			$ret['isapp'] = $param[2];
			$ret['user'] = $_REQUEST['openid'];
			$ret['fee'] = $_REQUEST['money'];
			$ret['tag'] = array('transaction_id'=>$_REQUEST['p5_orderid']);
			$site->$method($ret);
		}
	}
	exit('success'); //返回成功 不要删除哦
}
