<?php defined('IN_IA') or exit('Access Denied');?><html><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php  echo $cfg['title'];?></title>
    <link rel="stylesheet" href="<?php echo RES;?>css/weui.css">
    <link rel="stylesheet" href="<?php echo RES;?>css/kouhong.css?v=<?php echo TIMESTAMP;?>">
    <link rel="stylesheet" href="<?php echo RES;?>css/index.css?v=<?php echo TIMESTAMP;?>">
    <link rel="stylesheet" href="<?php echo RES;?>css/swiper.min.css?v=<?php echo TIMESTAMP;?>">

<style>
a{
	color:<?php  echo $cfg['fcolor'];?>;
}
.swiper-container-notice{
	height:30px;
	line-height:30px;
	overflow:hidden;
	color:<?php  echo $cfg['fcolor'];?>;
}
.swiper-slide{
	font-size:12px;
	overflow:hidden;
}
.adv{
	z-index:1000001;
	position: fixed;
	width:100%;
	height:100%;
}
.swiper-container-adv{
	width:100%;
	height:auto;
	z-index:1000001;
}
.swiper-container-adv .swiper-slide img{
	width:100%;
}
.i-skip{
    position: fixed;
    bottom: 80px;
    right: 0;
    z-index: 1000001;
    width: 70px;
}
.copyright{
    width: 80%;
    margin: 0 10%;
    text-align: center;
    font-size: 13px;
}
.double_tip{
    text-align: center;
    font-size: 13px;
    color:<?php  echo $cfg['color1'];?>;
}
</style>
<link rel="stylesheet" href="<?php echo RES;?>css/layer.css?v=3.0.3303" id="layuicss-skinlayercss">

</head>

<body style="--wx_color:<?php  echo $cfg['color'];?>;--wx_color1:<?php  echo $cfg['color1'];?>;--wx_color2:<?php  echo $cfg['color2'];?>;--wx_fcolor:<?php  echo $cfg['fcolor'];?>;--wx_fcolor1:<?php  echo $cfg['fcolor1'];?>;">
<?php  if(!empty($adv)) { ?>
<div class="adv">
	<div class="swiper-container-adv">
		<div class="swiper-wrapper">
	 	<?php  if(is_array($adv)) { foreach($adv as $a) { ?>
	 	<div class="swiper-slide">
			<a href="<?php  echo $a['url'];?>"><img src="<?php  echo $a['pic'];?>" /></a>
	 	</div>
	 	<?php  } } ?>
		</div>
	</div>
<img class="i-skip" onclick="showPage()" src="<?php  echo $face['skip'];?>" />
</div>
<?php  } ?>
<div class="page" id="page" <?php  if(!empty($adv)) { ?>style="display:none;"<?php  } ?>>
    <div class="bg_img" style="background:url(<?php  echo $face['app_indexbg'];?>) no-repeat; background-size:100% auto;-moz-background-size:100% auto;">
        <div class="row">
            <div class="kh_h2" style="display:inline-block;color: #fff; margin-top: 20px;margin-left: 24px; font-size: 18px;"><?php  echo $txt['app_indextop'];?></div>

            <?php  if(!empty($cfg['music'])) { ?>
            <div class="musicbg">
                <audio id="music1" controls="controls" src="<?php  echo $cfg['music'];?>" loop="true" hidden="">
                </audio>
                <img src="<?php  echo $face['voice'];?>" class="music" id="onmusicTap">
            </div>
            <?php  } ?>
        </div>
        <?php  if(!empty($cfg['notice'])) { ?>
        <div class="rows">
            <div class="kh_gg">
                <img src="<?php  echo $face['notice'];?>" class="gg_img">
                <div class="swiper-container-notice">
                	<div class="swiper-wrapper">
	                	<?php  if(is_array($cfg['notice'])) { foreach($cfg['notice'] as $n) { ?>
	                	<div class="swiper-slide">
	                		<a <?php  if($n['url']) { ?>href="<?php  echo $n['url'];?>"<?php  } ?>><?php  echo $n['txt'];?></a>
	                	</div>
	                	<?php  } } ?>
                	</div>
                </div>
            </div>
        </div>
        <?php  } ?>
        <div class="kh_banner ">
            <img class="Kh_bimg" src="<?php  echo $face['indexbg'];?>">
        </div>
        <div class="kh_title flexColumn">
            <div class="kh_h2"><?php  echo $txt['tip'];?></div>
            <div class="kh_explain" id="bindexplain"><?php  echo $txt['fight'];?></div>
            <input type="hidden" value="<?php  echo $txt['fight'];?>" id="explain_title">
            <input type="hidden" value="<?php  echo $cfg['agreement1'];?>" id="explain_info">
        </div>
        <div style="background: #FFF;">
            <div class="kh_body page__bd">
                <div class="item_cell_box" id="gooslist">

                 </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <div class="copyright"><?php  echo $cfg['copyright'];?></div>
        <div style="width:100%;height:80px;"></div>
    </div>
    
    <div class="cardWrap" id="bindgames">
        <a href="<?php  echo $this->createMobileUrl('game',array('isapp'=>2));?>">
        <img src="<?php  echo $face['app_test'];?>" class="Refresh">
        </a>
    </div>

    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
</div>
<div id="dialogs">
    <div class="js_dialog" id="showModal3" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog modal-dialog">
            <div class="weui-dialog_hd"></div>
            <div class="weui-dialog_bd">
                <div class="modal-body">
                    <img src="<?php  echo $face['free'];?>">
                    <div class="kh_none"><?php  echo $txt['noCredit'];?></div>
                </div>
            </div>

            <div class="weui-dialog_ft">
                <div class="kh_btn" id="onConfirm"><?php  echo $txt['recharge'];?></div>

            </div>

        </div>
    </div>
    <div class="js_dialog" id="showModal2" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog modal-dialog">
            <div class="weui-dialog_hd kh_none" id="mtitle"><?php  echo $cfg['fight'];?></div>
            <div class="weui-dialog_bd">
                <div class="modal-body">
                    <textarea class="kh_sm" id="minfo" style="border:none;width:100%;height:250px;"><?php  echo $cfg['agreement1'];?></textarea>
                </div>
            </div>

            <div class="weui-dialog_ft">

            </div>

        </div>
    </div>
    <div class="js_dialog" id="showModal4" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog modal-dialog">
            <div class="weui-dialog_hd kh_none"><?php  echo $txt['pay'];?></div>
            <?php  if($cfg['isdouble']==1) { ?><div class="double_tip"><?php  echo $cfg['font']['double_tip'];?></div><?php  } ?>
            <div class="weui-dialog_bd">
                <div class="modal-body">

                    <div class="modal-kh_box">
                        <div class="modal_zpic">
                           <?php  echo $txt['nowmoney'];?>：
                            <div class="modal_pic"><span id="memCredit"><?php  echo $mem['credit'];?></span></div>
                        </div>
                        <div class="kh_grids" id="kh_grids">
							<?php  if(is_array($cfg['recharge'])) { foreach($cfg['recharge'] as $k => $r) { ?>
							<div class="kh_grids-item kh_pics" onclick="goRecharge(<?php  echo $k;?>,<?php  echo $r['money'];?>)">
                                <div class="kh_grids_pic"><?php  echo $r['money'];?>
                                    <text></text>
                                </div>
                            </div>
                            <?php  } } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="weui-dialog_ft">

            </div>

        </div>
    </div>


</div>

<script src="<?php echo RES;?>js/jquery-3.2.1.min.js"></script>
<script src="<?php echo RES;?>js/layer.js"></script>
<script src="<?php echo RES;?>js/swiper.min.js?v=<?php echo TIMESTAMP;?>"></script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('jsweixin', TEMPLATE_INCLUDEPATH)) : (include template('jsweixin', TEMPLATE_INCLUDEPATH));?>
<script>
var app_buy = "<?php  echo $txt['buy'];?>";
var app_cost = "<?php  echo $txt['cost'];?>";
var page = 1;
//下拉加载
var range = -50; //距下边界长度/单位px
var totalheight = 0;
var loading = false;
$(window).scroll(function(){
	if(loading) return false;
var srollPos = $(window).scrollTop(); //滚动条距顶部距离(页面超出窗口的高度)
totalheight = parseFloat($('body').height()) + parseFloat(srollPos);
if(($("body").height()-range) <= totalheight) {
	if(loading) return false;
	page++;
	getList();
}            
});
function getList(){
	if(loading) return false;
	loading = true;
	var layerIndex = layer.load(2, {shade: 0.3}); 
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('index')?>",
		data: {page:page,scroll:true},
		type: "post",
		success: function(dat){
			layer.close(layerIndex); 
			dat = JSON.parse(dat);
			if(dat.status==1){
				dat = dat.lists;
				var str = '';
				for(var i in dat){
					
					str += '<div class="goods">';
					str += '<div class="kh_goods" onclick="bindgome('+dat[i].id+','+dat[i].price+')">';
					str += '<div>';
					str += '<img class="kh_img" src="'+dat[i].logo+'">';
					str += '</div>';
					str += '<div>';
					str += '<div class="kh_shoppe">'+app_cost+'￥'+dat[i].costprice+'</div>';
					str += '<div class="kh_maintitle">'+dat[i].title+'</div>';
					str += '<div class="kh_subtitle">'+dat[i].sub_title+'</div>';
					str += '</div>';
					str += '<div>';
					str += '<div class="kh_pic">';
					str += dat[i].price+app_buy;
					str += '</div>';
					str += '</div>';
					str += '</div>';
					str += '</div>';
					
				}
				$('#gooslist').append(str);
				loading = false;
			}
			else{
				loading = true;
			}
		}	
	});	
}



<?php  if(!empty($cfg['music'])) { ?>
    var audio = document.getElementById('music1');
    var music_pic = "<?php  echo $face['voice'];?>";
    var mute_pic = "<?php  echo $face['no_voice'];?>";
    $("#onmusicTap").bind("touchstart", function bf() {
        if(audio !== null) {
//检测播放是否已暂停.audio.paused 在播放器播放时返回false.
//alert(audio.paused);
            if(audio.paused) {
                audio.play(); //audio.play();// 这个就是播放
                $("#onmusicTap").attr("src",music_pic)
            } else {
                audio.pause(); // 这个就是暂停
                $("#onmusicTap").attr("src",mute_pic)
            }
        }
    })
document.addEventListener('DOMContentLoaded', function() {
	audioAutoPlay('music1');
});
function audioAutoPlay(obj) {
	var audio = document.getElementById(obj);
	audio.play();
	document.addEventListener("WeixinJSBridgeReady", function() {
		audio.play();
	}, false);
}
<?php  } ?>
<?php  if(!empty($adv)) { ?>
var myAdvSwiper = new Swiper('.swiper-container-adv', {
	autoplay: 2500,//可选选项，自动滑动
	loop:true
})
setTimeout('showPage()', 5000);
function showPage(){
	$('#page').show();
	$('.adv').hide();
	<?php  if($_GPC['isRecharge']) { ?>
	layer.msg('储值成功');
	<?php  } ?>
	
	<?php  if(!empty($cfg['notice'])) { ?>
	new Swiper('.swiper-container-notice', {
	  autoplay: 2500,//可选选项，自动滑动
	  direction : 'vertical',
	  loop:true
	})
	<?php  } ?>
}
<?php  } else if(!empty($cfg['notice'])) { ?>
new Swiper('.swiper-container-notice', {
  autoplay: 2500,//可选选项，自动滑动
  direction : 'vertical',
  loop:true
})
<?php  } ?>
$(function(){
	getList();
	layer.closeAll();
	<?php  if(empty($adv) && $_GPC['isRecharge']) { ?>
	layer.msg('储值成功');
	<?php  } ?>
    var $showModal2 = $('#showModal2'),
        $showModal3 = $('#showModal3'),
        $showModal4 = $('#showModal4'),
        $androidDialog2 = $('#androidDialog2');

    $('#dialogs').on('click', '.js_dialog', function(){
        $(this).fadeOut(200);
        $("#page").removeClass("pages");
    });

    $('#bindenotice').on('click', function(){
        var title=$("#notce_title").text();
        var info=$("#notce_info").val();
        $("#mtitle").text(title);
        $("#minfo").text(info);
        $("#page").addClass("pages");
        $showModal2.fadeIn(200);
    });
    $('#bindexplain').on('click', function(){
        var title=$("#explain_title").val();
        var info=$("#explain_info").val();
        $("#mtitle").text(title);
        $("#minfo").text(info);
        $("#page").addClass("pages");
        $showModal2.fadeIn(200);
    });

    $("#onConfirm").click(function(event){
        event.stopPropagation();
        $showModal3.fadeOut(200);
        $showModal4.fadeIn(200);
    })
});
</script>
<script>
var memMoney = "<?php  echo $mem['credit'];?>";
    function bindgome(gid, price){
    	if(!memMoney || parseFloat(memMoney) < parseFloat(price)){
    		var $showModal3 = $('#showModal3');
            $showModal3.fadeIn(200);
    	}
    	else{
    		if(!gid || gid==0){
    			layer.msg('商品错误，请重新选择');
    			return false;
    		}
    		//if(!confirm('确认闯关吗？')){
    		//	return false;
    		//}
    		var layerIndex = layer.load(2, {shade: 0.3}); 
    		$.ajax({
    			type:'post',
    			url:"<?php  echo $this->createMobileUrl('CreateOrder',array('openid'=>$_W['openid']));?>",
    			data:{id: gid},
    			success:function(data){
    				layer.close(layerIndex); 
    				layer.closeAll();
    				data = JSON.parse(data);
    				if(data.code==1){
    					var memCredit = $('#memCredit').text();
    					var lastCredit = parseFloat(memCredit) - parseFloat(price);
    					$('#memCredit').text(lastCredit);
    					<?php  if(empty($cfg['isTip'])) { ?>
	    					var url = "<?php  echo $this->createMobileUrl('game',array('isapp'=>2));?>&oid="+data.oid+'&mid='+data.mid;
							var layerIndex = layer.load(2, {shade: 0.3}); 
							location.href = url;
							layer.close(layerIndex); 
    					<?php  } else { ?>
    					var layerConfirm = layer.confirm('确认立即挑战麽？', {
   						  btn: ["<?php  echo $txt['goNow'];?>", "<?php  echo $txt['goWait'];?>"] //按钮
   						}, function(){
							layer.close(layerConfirm); 
							var url = "<?php  echo $this->createMobileUrl('game',array('isapp'=>2));?>&oid="+data.oid+'&mid='+data.mid;
							var layerIndex = layer.load(2, {shade: 0.3}); 
							location.href = url;
							layer.close(layerIndex); 
   						}, function(){
							layer.close(layerConfirm); 
   						  console.log('暂不挑战');
   						});
    					<?php  } ?>
    				}
    				else if(data.code==2){
    					var $showModal3 = $('#showModal3');
    		            $showModal3.fadeIn(200);
    				}
    				else{
    					layer.msg(data.msg);
    				}	   				
    			}
    			,error:function(){
    				layer.msg('网络错误，请刷新重试');
    			}
    		});	
    	}
    }
</script>
<script>
    var orderid = 0;
    var rechargeMoney = 0;
    function goRecharge(index, money){
		if(!money || money<=0){
			layer.msg('储值金额错误，请重新选择');
			return false;
		}
		rechargeMoney = money;
		var layerIndex = layer.load(2, {shade: 0.3}); 
		$.ajax({
			type:'post',
			url:"<?php  echo $this->createMobileUrl('CreateRecharge',array('openid'=>$_W['openid']));?>",
			data:{op: 'app',rIndex: index},
			success:function(data){
				layer.close(layerIndex); 
				data = JSON.parse(data);
				if(data.code==1){
					var json = data.res;
					orderid = json.orderid;
					WeixinJSBridge.invoke('getBrandWCPayRequest', json, function (res) {
	                      if (res.err_msg === "get_brand_wcpay_request:ok") {
	                    	  checkorder();
	                      } else {
	                    	  layer.msg('支付失败')
	                      }
	                  });
					/*
					wx.chooseWXPay({
					    timestamp: json.timeStamp, 
					    nonceStr: json.nonceStr, 
					    package: json.package, 
					    signType: json.signType, 
					    paySign: json.paySign,
					    success: function (res) {
						   	checkorder();
					    },
					    fail:function(res){
					    	var str = JSON.stringify(res);
					    	layer.msg(str)
					    }
					});
					*/
				}
				else if(data.code==2){
					location.href = data.url;
				}
				else{
					layer.msg(data.msg);
				}
			}
			,error:function(){
				layer.msg('网络错误，请刷新重试');
			}
		});
    }

    function checkorder(){
		if(orderid > 0){
			$.ajax({
				 type:'POST',
				 data:{orderid:orderid},
				 url:'<?php  echo $this->createMobileUrl("CheckRecharge");?>',
				 success:function(data){
					  if(data == 1){
						  var memCredit = $('#memCredit').text();
    					  var lastCredit = parseFloat(memCredit) + parseFloat(rechargeMoney);
    					  $('#memCredit').text(lastCredit);
    					  memMoney = lastCredit;
						  layer.msg('储值成功！');
					  }else{	 
						  setTimeout(function(){
							  checkorder();
						  },1000);
					  }
				 }
			 });
		}
	}
    
</script>
<script>



</script>

<script>;</script><script type="text/javascript" src="http://www.game88.com/app/index.php?i=4&c=utility&a=visit&do=showjs&m=junsion_winaward"></script></body></html>