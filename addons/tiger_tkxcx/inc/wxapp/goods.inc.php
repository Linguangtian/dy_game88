<?php
global $_W, $_GPC;
        $now=time();
        $weid=$this->wid;//绑定公众号的ID
		$cfg=$this->cfg;//绑定公众号的配置数据
		$xcxcfg=$this->xcxcfg;//小程序配置数据
		$uid=$_GPC['uid'];

        $goods_list = pdo_fetchall("SELECT * FROM " . tablename("tiger_newhu_goods") . " WHERE weid = '{$weid}' and $now < endtime and amount >= 0 {$where} order by px ASC");
        	
        	
        foreach($goods_list as $k=>$v){
            $requestsum = pdo_fetchcolumn("SELECT count(id) FROM " . tablename($this->modulename . "_request") . " WHERE weid = '{$_W['weid']}' and goods_id='{$v['goods_id']}'");
            $good[$k]=$v;
            $good[$k]['requestsum']=$requestsum;
            $good[$k]['logo']=$_W['attachurl'].$v['logo'];
            $good[$k]['endtime']=date("Y-m-d",$v['endtime']);
            $good[$k]['id']=$v['goods_id'];
        }
        $goods_list=$good;

      $this->result(0, 'OK', array('data' =>$goods_list));
       