<?php
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
	$get = $_REQUEST;
}

require '../../framework/bootstrap.inc.php';
require_once IA_ROOT.'/addons/junsion_winaward/eespay_inc.php';
$status=$get['status'];
$customerid=$get['customerid'];
$sdorderno=$get['sdorderno'];
$total_fee=$get['total_fee'];
$paytype=$get['paytype'];
$sdpayno=$get['sdpayno'];
$remark=$get['remark'];
$sign=$get['sign'];

$remark = explode(':', $remark);
$_W['uniacid'] = $_W['weid'] = $remark[0];
$table = $remark[1];

$cfg = pdo_fetch('select settings from '.tablename('uni_account_modules')." where uniacid='{$_W['uniacid']}' and module='junsion_winaward'");
if (empty($cfg['settings'])) exit('success');
$cfg = unserialize($cfg['settings']);
$userkey = $cfg['eespay']['key'];

$mysign=md5('customerid='.$customerid.'&status='.$status.'&sdpayno='.$sdpayno.'&sdorderno='.$sdorderno.'&total_fee='.$total_fee.'&paytype='.$paytype.'&'.$userkey);

file_put_contents(IA_ROOT."/addons/junsion_winaward/eespay_log", date('Y-m-d H:i:s')."： get:".json_encode($get)."： sign:".$sign." rsign:".$get['sign']."\n",FILE_APPEND);

if($sign==$mysign){
    if($status=='1'){
    	$site = WeUtility::createModuleSite('junsion_winaward');
    	if(!is_error($site)) {
    		$method = 'payResult';
    		if (method_exists($site, $method)) {
    			$ret = array();
    			$ret['weid'] = $_W['weid'];
    			$ret['uniacid'] = $_W['uniacid'];
    			$ret['result'] = 'success';
    			$ret['type'] = 'eespay';
    			$ret['from'] = 'notify';
    			$ret['tid'] = $get['sdorderno'];
    			$ret['table'] = $table;
    			$ret['isapp'] = $remark[2];
    			$ret['fee'] = $get['total_fee'];
    			$ret['tag'] = array('transaction_id'=>$get['sdpayno']);
    			$site->$method($ret);
    		}
    	}
		//这里写入数据库
        echo 'success';
        exit;
    } else {
        echo 'fail';
        exit;
    }
} else {
    echo 'signerr';
    exit;
}
?>
