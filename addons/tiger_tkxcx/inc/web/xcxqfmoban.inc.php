<?php
global $_W, $_GPC;
        $page=$_GPC['page'];
        $s=pdo_fetch("select * from ".tablename('tiger_tkxcx_set')." where weid='{$_W['uniacid']}'");
		$weid=$s['gzwid'];
        if(empty($page)){
          $page=1;
        }
        $op=$_GPC['op'];
        $mb=pdo_fetchall("select * from ".tablename("tiger_newhu_xcxmobanmsg")." where weid='{$weid}' order by id desc");
//      echo "<pre>";
//      print_r($mb);
//      exit;


        
        if($op=='qf'){
        	if(!empty($_GPC['id'])){//管理员订单提交提醒
        		$id=$_GPC['id'];
	            $mb=pdo_fetch("select * from ".tablename("tiger_newhu_xcxmobanmsg")." where weid='{$weid}' and id='{$id}'");
	        }else{
	           message('请先选择模版消息ID');
	        }
        	$pindex = max(1, intval($_GPC['page']));
		    $psize = 100;           
	        $list = pdo_fetchall("select formid,xcxopenid,nickname from ".tablename("tiger_newhu_qiandao")." where weid='{$weid}' and xcxopenid<>'0' and formid<>'' and formid<>'0' order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
//	        	echo "<pre>";
//	        print_r($list);
//	        exit;
	        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_qiandao')."where weid='{$weid}' and xcxopenid<>'0' and formid<>'' and formid<>'0'");
	        
			$pager = pagination($total, $pindex, $psize);
	        $pagesum=ceil($total/100);  //总页数
            if(!empty($list)){
                foreach($list as $k=>$v){
                	$msg=$this->postxcxsend($v['xcxopenid'],$mb['mbid'],$mb['page'],$v['formid'],$mb,"#ff0000",$mb['emphasis_keyword'],$v);
                 	//$msg=$this->mbmsg($v['openid'],$mb,$mb['mbid'],$mb['turl'],$fans,'');
                }
//              print_r($msg);
//              exit;
                if ($page < $pagesum) {
					message('温馨提示：请不要关闭页面，群发正在进行中！（群发第' . $page . '页）', $this->createWebUrl('xcxqfmoban', array('op' => 'qf','page' => $page + 1)), 'success');
                } elseif ($page == $pagesum) {
                    //step6.最后一页 | 修改任务状态
                    message('温馨提示：群发任务已完成！（群发第' . $page . '页）', $this->createWebUrl('xcxqfmoban'), 'success');
                } else {
                    message('温馨提示：该群发任务已完成！', $this->createWebUrl('xcxqfmoban'), 'error');
                }       
            }else{
               message('温馨提示：该群发任务已完成！', $this->createWebUrl('xcxqfmoban'), 'success');
            }
        }
        

include $this -> template('xcxqfmoban');