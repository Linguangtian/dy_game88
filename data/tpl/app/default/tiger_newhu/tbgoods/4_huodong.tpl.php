<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no" />
  <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1" media="(device-height: 568px)" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-touch-fullscreen" content="yes" />
  <meta name="full-screen" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />
  <meta name="format-detection" content="telephone=no" />
  <meta name="format-detection" content="address=no" />
  <link href="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/css/style_v3.css" rel="stylesheet" type="text/css" />
  <link href="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/css/jp.bag.css" rel="stylesheet" type="text/css" />
  <title><?php  echo $cfg['fxtitle'];?></title>
  <meta name="keywords" content="<?php  echo $cfg['hdtitle'];?>" />
  <meta name="description" content="<?php  echo $cfg['hdtitle'];?>" />
  <script src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/js/jquery-1.8.0.js"></script>
  <script src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/js/underscore.js"></script>
  <link type="text/css" rel="stylesheet" href="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/css/alert.css" />
  <link type="text/css" rel="stylesheet" href="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/css/global.css" />
   <script src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/js/layer_mobile/layer.js"></script>
  
  <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
  <!-- 微信自定义接口 -->
<?php  if($views=='') { ?>
<script>
        var appid = "<?php  echo $_W['account']['jssdkconfig']['appId'];?>";
        var timestamp = "<?php  echo $_W['account']['jssdkconfig']['timestamp'];?>";
        var nonceStr = "<?php  echo $_W['account']['jssdkconfig']['nonceStr'];?>";
        var signature = "<?php  echo $_W['account']['jssdkconfig']['signature'];?>";
        wx.config({
            debug: false,
            appId: appid,
            timestamp: timestamp,
            nonceStr: nonceStr,
            signature: signature,
            jsApiList: [
                "onMenuShareAppMessage",
                "onMenuShareTimeline",
                "chooseImage",
                "uploadImage",
                "downloadImage"
            ]
        });

	wx.ready(function(){
		wx.onMenuShareAppMessage({
			title: "<?php  echo $fzview['title'];?>-<?php  echo $cfg['fxtitle'];?>",
			desc: "<?php  echo $cfg['fxcontent'];?>",
			link: window.location.href ,
			imgUrl: "<?php  echo tomedia($cfg['fxpicurl'])?>"
		}); 
		wx.onMenuShareTimeline({
			title: "<?php  echo $fzview['title'];?>-<?php  echo $cfg['fxtitle'];?>",
			desc: "<?php  echo $cfg['fxcontent'];?>",
			link: window.location.href ,
			imgUrl: "<?php  echo tomedia($cfg['fxpicurl'])?>"
		});
	});
</script>
<?php  } ?>
<!-- 微信自定义接口 -->
 </head>
 <body>
  <div class="main">
   <div class="app-other">
    <ul>
     <li class="search">
      <div id="search-box">
       <form id="search-form" action="<?php  echo $this->createMobileUrl('index')?>" method="get">
        <div class="box-search">
            <input type="hidden" name="i" value="<?php  echo $_W['uniacid'];?>">
            <input type="hidden" name="c" value="entry">
            <input type="hidden" name="dluid" value="<?php  echo $dluid;?>">
            <input type="hidden" name="m" value="tiger_newhu">
            <input type="hidden" name="do" value="index">
         <input type="text" id="keyword" name="key" x-webkit-speech="" placeholder="搜索商品" autocomplete="off" value="" />
         <a href="javascript:;" class="del"><img src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/del.png" /></a>
        </div>
        <button id="search-submit" type="submit" onclick="document.getElementById('keyword').value=encodeURI(document.getElementById('keyword').value);getId('search-form').submit()"><img src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/search.png" /></button>
       </form>
      </div></li>
     <li class="normal active "><a href="<?php  echo $this->createMobileUrl('index',array('dluid'=>$dluid))?>"><em class="home"></em>首页</a></li>
     <?php  if(is_array($fzlist)) { foreach($fzlist as $f) { ?>
     <li class="normal  "><a href="<?php  echo $this->createMobileUrl('index',array('typeid'=>$f['id'],'dluid'=>$dluid))?>"><em class=" fushi"></em><?php  echo $f['title'];?></a></li>
     <?php  } } ?>     
    </ul>
    <p>
       <?php  if($cfg['huiyuanurl']) { ?>
        <a href="<?php  echo $cfg['huiyuanurl'];?>"><em class="icon-user"></em><br />个人中心</a>
        <?php  } else { ?>
        <a href="<?php  echo $this->createMobileUrl('member',array('dluid'=>$dluid))?>"><em class="icon-user"></em><br />个人中心</a>
        <?php  } ?>
    
    <a href="<?php  echo $this->createMobileUrl('index',array('dluid'=>$dluid))?>"><em class="icon-about"></em><br />商城首页</a></p>
   </div>
   <div class="app">
    <div class="search_warp">
     <span id="classify" class="classify"><a href="javascript:;" class="btn btn-left btn-type"></a></span>
     <div class="search" style="float: none;">
      <form name="search" action="<?php  echo $this->createMobileUrl('index',array('dluid'=>$dluid))?>" method="get" id="search">
       <input type="hidden" name="i" value="<?php  echo $_W['uniacid'];?>">
       <input type="hidden" name="c" value="entry">
       <input type="hidden" name="dluid" value="<?php  echo $dluid;?>">
       <input type="hidden" name="m" value="tiger_newhu">
       <input type="hidden" name="do" value="index">
       <div class="seek_main">
        <input type="text" name="key" onclick="if(this.value=='请输入内容'){this.value='';this.className='seek_input seek_input_h'}" onblur="if(this.value==''){this.value='请输入内容';this.className='seek_input seek_input_f'}" class="seek_input seek_input_f" value="请输入内容" />
        <button type="submit" id="key" onclick="document.getElementById('key').value=encodeURI(document.getElementById('key').value);getId('search').submit()" class="seek_btn" value="搜本站"><img src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/search.png" /></button>
       </div>
      </form>
     </div>
    </div>
    <header class="head" id="head">
     <div class="fixtop">
      <span id="t-find" class="classify"><a href="javascript:void(0);" class="btn btn-left btn-type"></a></span>
      <span id="t-index">官方活动<i></i></span>
      <span id="t-user"><a href="javascript:;" class="choice">筛选<em class="cur"></em></a></span>
     </div>
     <dl class="screen-box">
      <dt>
       筛选方式：
      </dt>
      <dd>
       <a href="<?php  echo $this->createMobileUrl('list',array('typeid'=>$f['id'],'dluid'=>$dluid))?>" title="默认排序">默认 <img <?php  if($sort=='') { ?>style="display:block;" <?php  } ?> src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/selected.png" /></a>
      </dd>
      <dd>
       <a href="<?php  echo $this->createMobileUrl('list',array('typeid'=>$f['id'],'sort'=>'new','dluid'=>$dluid))?>" title="最新">最新<img <?php  if($sort=='new') { ?>style="display:block;" <?php  } ?> src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/selected.png" /></a>
      </dd>
      <dd>
       <a href="<?php  echo $this->createMobileUrl('list',array('typeid'=>$f['id'],'sort'=>'hot','dluid'=>$dluid))?>" title="最热">最热<img <?php  if($sort=='hot') { ?>style="display:block;" <?php  } ?> src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/selected.png" /></a>
      </dd>
      <dd>
       <a href="<?php  echo $this->createMobileUrl('list',array('typeid'=>$f['id'],'sort'=>'price','dluid'=>$dluid))?>" title="价格">价格<img <?php  if($sort=='price') { ?>style="display:block;" <?php  } ?> src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/selected.png" /></a>
      </dd>
      <dd class="pack_up">
       <a href="javascript:void(0);"><img src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/pack_up.png" /></a>
      </dd>
     </dl>
    </header>
    

    <div class="nav_box1">
         <nav class="nav" id="nav1">
          <ul class="">
           <li><a <?php  if($tj==1) { ?>class='active'<?php  } ?> href="<?php  echo $this->createMobileUrl('index',array('tj'=>1,'dluid'=>$dluid))?>" target="_self"><em class="icon icon-jk"></em><span>9.9专场</span><em class="line"></em></a></li>
          <li><a <?php  if($tj==2) { ?>class='active'<?php  } ?> href="<?php  echo $this->createMobileUrl('index',array('tj'=>2,'dluid'=>$dluid))?>" target="_self"><em class="icon icon-sjk"></em><span>19.9专场</span><em class="line"></em></a></li>
          <li><a href="<?php  echo $this->createMobileUrl('sdindex',array('dluid'=>$dluid))?>" target="_self"><em class="icon icon-yg"></em><span>晒单广场</span><em class="line"></em></a></li>
          <?php  if($cfg['huiyuanurl']) { ?>
          <li class="_border"><a href="<?php  echo $cfg['huiyuanurl'];?>" target="_self"><em class="icon icon-user"></em><span>用户中心</span><em class="line"></em></a></li>
          <?php  } else { ?>
           <li class="_border"><a href="<?php  echo $this->createMobileUrl('member',array('dluid'=>$dluid))?>" target="_self"><em class="icon icon-user"></em><span>用户中心</span><em class="line"></em></a></li>
          <?php  } ?>
          </ul>
         </nav>
    </div>



<script>$(function (){
    var aa = $(".goods-list li").innerWidth();
    $(".goods-list li img").css('height',aa);
})
</script>
    <div id="goods">
     <section class="goods" id="pageCon">
      <ul class="clear" style="width:96%;margin: 2%;">
      <?php  if(is_array($list)) { foreach($list as $v) { ?>
      <li style="width:100%;text-align:center;margin-top:6px;" onclick="view('<?php  echo $v['title'];?>','<?php  echo $v['kouling'];?>','<?php  echo $v['turl'];?>')">
      <img src="<?php  echo tomedia($v['picurl'])?>" style="width:100%;position: relative;
    display: inherit;">
    <p style="width:100%;height:30px; line-height:30px;"><?php  echo $v['title'];?></p>
    </li>
      <?php  } } ?>
      </ul>
     </section>
    </div>
    <style>
    .layui-m-layercont{padding:30px 30px;}
    </style>


    <script>
    function view(title,kouling,turl){
        //询问框
        var con = '';
        con +='<div class="am-margin-vertical am-margin-horizontal-lg">';
       con +='<div class="fq-goods-border am-text-center am-margin-top am-padding-vertical am-padding-horizontal-sm fq-background-white" style="margin:0;">';
        con +='<div class="fq-explain  am-center am-text-center">';
        con +='<span class="am-padding-horizontal-sm fq-nowrap " style="color:#f54d23;padding-bottom:10px;">长按框内 > 全选 > 复制</span>';
        con +='</div>';
         con +='<span id="copy_key_ios">'+title+'\r'+kouling+'</span>';
          con +='<textarea style="display: none;height:20px" id="copy_key_android" type="text" class="am-form-field am-text-center am-text-sm " oninput="regain();">'+title+'\r'+kouling+'</textarea>';
           con += '</div>';
          con +='</div>';

          var url=encodeURIComponent(turl);
          var topurl="<?php  echo $this->createMobileUrl('openview')?>&link="+url;

   
      layer.open({
        content:con
        ,btn: ['浏览器打开', '关闭']
        ,yes: function(index){
         //layer.close(turl);
         window.location.href=topurl;
        }
      });
    }


    $(function () {

        //事件监听
        //------------------------------------------
        var ua = navigator.userAgent.toLowerCase();
        if (ua.match(/iphone os 10/i) == "iphone os 10") {
        
            $('.copy_taowords').show();
            
            var clipboard = new Clipboard('.share', {
                target: function() {
                    return document.querySelector('.share_content');
                }
            });

            clipboard.on('success', function(e){
                e.trigger.innerHTML="已复制";
                e.trigger.style.backgroundColor="#9ED29E";
                e.trigger.style.borderColor="#9ED29E";
                $(".share_content").hide();
                console.info('Action:', e.action);
                console.info('Text:', e.text);
                console.info('Trigger:', e.trigger);
                e.clearSelection();
            });

            clipboard.on('error', function(e) {
                $(".share_content").hide();
                $("#fq_alert_info").html("<div class=\"am-text-danger\">由于您的浏览器不兼容或当前网速较慢，复制失败，请手动复制或更换主流浏览器！</div><div class=\"am-margin\" style=\"text-align: left;\">"+$(".share_content").html()+"</div>");
                $('#fq_alert').modal();
            });
                

        }     
            
            document.addEventListener("selectionchange", function (e) {
                if (window.getSelection().anchorNode.parentNode.id == 'copy_key_ios' && document.getElementById('copy_key_ios').innerText != window.getSelection()) {
                    var key = document.getElementById('copy_key_ios');
                    window.getSelection().selectAllChildren(key);
                }
                if (window.getSelection().anchorNode.parentNode.id == 'copy_key_ios1' && document.getElementById('copy_key_ios1').innerText != window.getSelection()) {
                    var key = document.getElementById('copy_key_ios1');
                    window.getSelection().selectAllChildren(key);
                }
                if (window.getSelection().anchorNode.parentNode.id == 'copy_key_ios2' && document.getElementById('copy_key_ios2').innerText != window.getSelection()) {
                    var key = document.getElementById('copy_key_ios2');
                    window.getSelection().selectAllChildren(key);
                }
                if (window.getSelection().anchorNode.parentNode.id == 'copy_key_ios3' && document.getElementById('copy_key_ios3').innerText != window.getSelection()) {
                    var key = document.getElementById('copy_key_ios3');
                    window.getSelection().selectAllChildren(key);
                }
                if (window.getSelection().anchorNode.parentNode.id == 'copy_key_ios4' && document.getElementById('copy_key_ios4').innerText != window.getSelection()) {
                    var key = document.getElementById('copy_key_ios4');
                    window.getSelection().selectAllChildren(key);
                }
            }, false);
        

    });

  
    </script>



    <div class="nav_box">
    <style>
    #nav ul li{width:24%;}
    </style>
     <nav class="nav" id="nav">
      <ul class="">
       <li><a <?php  if($tj=='') { ?>class='active'<?php  } ?> href="<?php  echo $this->createMobileUrl('index',array('dluid'=>$dluid))?>" target="_self"><em class="icon icon-jz"></em><span>首页</span><em class="line"></em></a></li>
       <li><a <?php  if($tj==1) { ?>class='active'<?php  } ?> href="<?php  echo $this->createMobileUrl('index',array('tj'=>1,'dluid'=>$dluid))?>" target="_self"><em class="icon icon-jk"></em><span>9.9专场</span><em class="line"></em></a></li>
       <li><a <?php  if($tj==2) { ?>class='active'<?php  } ?> href="<?php  echo $this->createMobileUrl('index',array('tj'=>2,'dluid'=>$dluid))?>" target="_self"><em class="icon icon-sjk"></em><span>19.9专场</span><em class="line"></em></a></li>
       <?php  if($cfg['huiyuanurl']) { ?>
       <li class="_border"><a href="<?php  echo $cfg['huiyuanurl'];?>" target="_self"><em class="icon icon-yg"></em><span>个人中心</span><em class="line"></em></a></li>
       <?php  } else { ?>
       <li class="_border"><a href="<?php  echo $this->createMobileUrl('member',array('dluid'=>$dluid))?>" target="_self"><em class="icon icon-yg"></em><span>个人中心</span><em class="line"></em></a></li>
       <?php  } ?>
      </ul>
     </nav>
    </div>
    <div id="back_top" class="slide-box" style="display:none">
    <?php  if($cfg['huiyuanurl']) { ?>
    <a href="<?php  echo $cfg['huiyuanurl'];?>" class="bag-enter" title="个人中心"><img src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/bag-icon.png" alt="个人中心" /></a>
    <?php  } else { ?>
     <a href="<?php  echo $this->createMobileUrl('member',array('dluid'=>$dluid))?>" class="bag-enter" title="个人中心"><img src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/bag-icon.png" alt="个人中心" /></a>
     <?php  } ?>
     <a href="#" class="back-top" title="返回顶部"><img src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/back-top.png" alt="返回顶部" /></a>
    </div>
    <div id="foot">
     <div class="foot-nav">
      <a href="<?php  echo $this->createMobileUrl('index',array('tj'=>1,'dluid'=>$dluid))?>"><img src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/phone.png" />9.9专场</a>
     <?php  if($cfg['huiyuanurl']) { ?>
      <a href="<?php  echo $cfg['huiyuanurl'];?>" class="joa_load_app"><img src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/client.png" />会员中心</a>
     <?php  } else { ?>
      <a href="<?php  echo $this->createMobileUrl('member',array('dluid'=>$dluid))?>" class="joa_load_app"><img src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/client.png" />会员中心</a>
     <?php  } ?>
      <a href="<?php  echo $this->createMobileUrl('index',array('dluid'=>$dluid))?>" class="_border"><img src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/images/home.png" />返回首页</a>
     </div>
     <div class="foot-copyright"></div>
    </div>

    <script type="text/javascript">document.getElementById("back_top").style.display = "none";
window.onscroll = function () {
    if (document.documentElement.scrollTop + document.body.scrollTop > 100) {
        document.getElementById("back_top").style.display = "block";
    }
    else {
        document.getElementById("back_top").style.display = "none";
    }
}
</script>
   </div>
  </div>
  <script type="text/javascript">    $(".huamei_1").off("click").on("click",function(){
       window.location.href = $(this).attr("data-url");
    });
</script>
  <script type="text/javascript" src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/js/mjp.min.js"></script>
  <script src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/js/lightbox.js" type="text/javascript"></script>
  <script type="text/javascript">	$("img.lazy").lazyload({threshold:200,failure_limit:30});	
</script>
  <script type="text/javascript" src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/js/swipeSlide.min.js"></script>
  <script type="text/javascript" src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/tbgoods/style5/js/jp.common.js"></script>
  <script type="text/javascript">            $(function(){
            function hideMenu() {
                setTimeout("window.scrollTo(0, 0)", 1);
            }

            $('.alert_black_bg .close').on('click', function(){
                $('.alert_black_bg').hide();
                $('#foot').height(120);
            });
            });
            $(".go-app .closed").on("click",function(){
                $(".go-app").hide();
                return false;
            })

</script>
<?php  if($cfg['lbtx']==1) { ?>
<style>
.useract {
    position: fixed;
    opacity: 0;
    color: #fff;
    border-radius: 20px;
    height: 30px;
    line-height: 30px;
    font-size: 12px;
    left: 0.2rem;
    padding-right: 10px;
    top: 3rem;
    z-index: 2000;
    background: #000;
}

.useract img {
    width: 30px;
    height: 30px;
    border-radius: 18px;
    vertical-align: -10px;
    margin-right: 8px;
}

.useractshow {
    opacity: 0.8;
    transition: all 0.3s;
    -webkit-transition: all 0.3s;
}
</style>
<script src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/user/js/jquery-1.7.2.min.js"></script>
<script src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/user/js/tool.js"></script>
<script src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/user/js/asynloading.js"></script>
<script src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/user/js/idangerous.swiper.min.js"></script>
<script src="<?php  echo $_W['siteroot'];?>addons/tiger_newhu/template/mobile/user/js/common_phone.js"></script>
<script>

var fixeddata = [
<?php  if(is_array($msg)) { foreach($msg as $v) { ?>
    {
        name: "<?php  echo $v['title'];?>",
        content: "<?php  echo $v['content'];?>",
        headerportarit: "<?php  echo tomedia($v['picurl'])?>"
    },
<?php  } } ?>

];
</script>
<?php  } ?>
 <script>;</script><script type="text/javascript" src="http://www.game88.com/app/index.php?i=4&c=utility&a=visit&do=showjs&m=tiger_newhu"></script></body>
</html>