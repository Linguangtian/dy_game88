<?php defined('IN_IA') or exit('Access Denied');?><script src="https://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script type="text/javascript">
        var shareData = {
        			title: "<?php  echo $share['title'];?>",
      	      		link: "<?php  echo $share['url'];?>",
      	      		desc: "<?php  echo $share['des'];?>",
                	imgUrl: "<?php  echo toimage($share['pic']);?>"
        	   };
        jssdkconfig = <?php  echo json_encode($_W['account']['jssdkconfig']);?> || { jsApiList:[] };
        jssdkconfig.debug = false;
        jssdkconfig.jsApiList = ['checkJsApi','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','showOptionMenu','chooseWXPay','chooseImage','uploadImage','addCard','chooseCard','openCard'];
    	wx.config(jssdkconfig);
        	wx.ready(function () {
        	    wx.onMenuShareAppMessage(shareData);
        	    wx.onMenuShareTimeline(shareData);
        	    wx.onMenuShareQQ(shareData);
        	    wx.onMenuShareWeibo(shareData);
        	    
        	});
</script>