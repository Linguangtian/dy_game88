<?php
global $_W, $_GPC;
    	$weid=$this->wid;//绑定公众号的ID
		$cfg=$this->cfg;//绑定公众号的配置数据
		$httpsurl=$cfg['tknewurl'];
		
		if(!empty($cfg['serackkey'])){
       	  $keyarr=explode("|",$cfg['serackkey']);
       	  $this->result(0, 'OK', array('data'=>$keyarr));	
		}else{
		  $this->result(0, 'OK', array('data'=>''));	
		}
?>