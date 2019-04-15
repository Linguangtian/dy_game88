<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
define('IN_MOBILE', true);
if ($_REQUEST['p4_zfstate'] != 1) return 'success';
require '../../framework/bootstrap.inc.php';

$order = pdo_fetch('select weid,status from ' . tablename('junsion_winaward_recharge') . " where orderno = '{$_REQUEST['p2_ordernumber']}'");
if (!empty($order)){
	if ($order['status']){
		$url = 'http://'.$_SERVER['HTTP_HOST']."/app/index.php?i={$order['weid']}&c=entry&do=index&m=junsion_winaward&isRecharge=true";
		header('location:'.$url);
		exit;
	}
}else{
	$url = 'http://'.$_SERVER['HTTP_HOST']."/app/index.php?i={$order['weid']}&c=entry&do=rouge&m=junsion_winaward";
	header('location:'.$url);
	exit;
}
