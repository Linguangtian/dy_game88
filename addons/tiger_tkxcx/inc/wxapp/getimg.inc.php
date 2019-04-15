<?php
		global $_W, $_GPC;
		$xcxcfg=$this->xcxcfg;
    	$httpsurl=$xcxcfg['zdyurl'];
		$base64_image_content=$_GPC['img'];
		$path=IA_ROOT."/attachment/images";
		$url=$this->base64_image_content($base64_image_content,$path);
		file_put_contents(IA_ROOT."/addons/tiger_tkxcx/img_log.txt",$url.$base64_image_content,FILE_APPEND);
		$turl=$httpsurl.$url;
//		echo $turl;
//		exit;
		$this->result(0, '', array('url' =>$turl)); 
?>