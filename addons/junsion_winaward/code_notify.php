<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
define('IN_MOBILE', true);
$input = file_get_contents('php://input');
if (!empty($input) && empty($_GET['out_trade_no'])) {
	if (preg_match('/(\<\!DOCTYPE|\<\!ENTITY)/i', $input)) {
		exit('fail');
	}
	libxml_disable_entity_loader(true);
	$obj = simplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
	$data = json_decode(json_encode($obj), true);
	if (empty($data)) {
		exit('fail');
	}
	if ($data['result_code'] != 'SUCCESS' || $data['return_code'] != 'SUCCESS') {
				exit('fail');
	}
	$get = $data;
} else {
	$get = $_GET;
}
require '../../framework/bootstrap.inc.php';
$param = $get['param'];
$param = explode(':', $param);
$_W['uniacid'] = $_W['weid'] = $param[0];
$table = $param[1];

ksort($get); //排序post参数
reset($get); //内部指针指向数组中的第一个元素
$sign = '';//初始化
foreach ($get AS $key => $val) { //遍历POST参数
	if ($val == '' || $key == 'sign') continue; //跳过这些不签名
	if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
	$sign .= "$key=$val"; //拼接为url参数形式
}
$cfg = pdo_fetch('select settings from '.tablename('uni_account_modules')." where uniacid='{$_W['uniacid']}' and module='junsion_winaward'");
if (empty($cfg['settings'])) exit('success');
$cfg = unserialize($cfg['settings']);
$codepay_key = $cfg['codepay']['key'];

file_put_contents(IA_ROOT."/addons/junsion_winaward/code_log", date('Y-m-d H:i:s')."： get:".json_encode($get)."： sign:".md5($sign . $codepay_key)." rsign:".$get['sign']."\n",FILE_APPEND);

if (!$get['pay_no'] || md5($sign . $codepay_key) != $get['sign']) { //不合法的数据
	exit('fail');  //返回失败 继续补单
} else { //合法的数据
	//业务处理
// 	$pay_id = $_POST['pay_id']; //需要充值的ID 或订单号 或用户名
// 	$money = (float)$_POST['money']; //实际付款金额
// 	$price = (float)$_POST['price']; //订单的原价
// 	$param = $_POST['param']; //自定义参数
// 	$pay_no = $_POST['pay_no']; //流水号
	
	echo 'success';
	$site = WeUtility::createModuleSite('junsion_winaward');
	if(!is_error($site)) {
		$method = 'payResult';
		if (method_exists($site, $method)) {
			$ret = array();
			$ret['weid'] = $_W['weid'];
			$ret['uniacid'] = $_W['uniacid'];
			$ret['result'] = 'success';
			$ret['type'] = 'code';
			$ret['from'] = 'notify';
			$ret['tid'] = $get['pay_id'];
			$ret['table'] = $table;
			$ret['isapp'] = $param[2];
			$ret['user'] = $get['openid'];
			$ret['fee'] = $get['money'];
			$ret['tag'] = array('transaction_id'=>$get['pay_no']);
			$site->$method($ret);
		}
	}
	exit('success'); //返回成功 不要删除哦
}







