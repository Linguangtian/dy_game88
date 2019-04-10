<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<!-- saved from url=(0086)https://jwsykhtrial.suyuemobi.com/game.html?uid=undefined&res=&rand=&pid=&pay=-1&gid=1 -->
<html lang="en" style="font-size: 50px;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="edge">
<meta name="viewport"
	content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title><?php  echo $cfg['title'];?></title>
<link rel="stylesheet" href="<?php echo RES;?>css/game.css?v=<?php echo TIMESTAMP;?>">
<script>
var sysGame = '<?php  echo json_encode($game)?>';
sysGame = JSON.parse(sysGame);
var goodGame = '<?php  echo json_encode($gGame)?>';
goodGame = JSON.parse(goodGame);
var nowMid = "<?php  echo $mid;?>";
var nowOid = "<?php  echo $oid;?>";
var logId = 0;
var tmpTotalLevel = 3;
if(nowMid && nowMid>0) tmpTotalLevel = 4;
var initUrl = "<?php  echo $_W['siteroot']."app".substr($this->createMobileUrl('checkRes'),1)?>";
var appUrl = "<?php  echo $_W['siteroot']."app".substr($this->createMobileUrl('order'),1)?>";
var nowWindow = "<?php  echo $_GPC['isapp'];?>";
var wxTip = "<?php  echo $cfg['wxTip'];?>";
</script>
<script src="<?php echo RES;?>js/JicemoonMobileTouch.js?v=<?php echo TIMESTAMP;?>"></script>
<script src="<?php echo RES;?>js/HardestGame-min.js?v=<?php echo TIMESTAMP;?>"></script>
<script src="<?php echo RES;?>js/index-min.js?v=<?php echo TIMESTAMP;?>"></script>
<script type="text/javascript" src="<?php echo RES;?>js/bodymovin.js?v=<?php echo TIMESTAMP;?>"></script>
<!-- <script type="text/javascript" src="<?php echo RES;?>js/jweixin-1.3.0.js?v=<?php echo TIMESTAMP;?>"></script> -->
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.3.2.js"></script>
<script type="text/javascript" src="<?php echo RES;?>js/jquery-3.3.1.min.js?v=<?php echo TIMESTAMP;?>"></script>
<script type="text/javascript" src="<?php echo RES;?>js/jquery.cookie.js?v=<?php echo TIMESTAMP;?>"></script>
</head>
<style>
.wx_no{
    font-size: 15px;
    display: block;
    text-align: center;
    color:<?php  echo $cfg['fcolor'];?>;
}
.wx_no>span{
	font-size: 22px;
	color:<?php  echo $cfg['color'];?>;
}
</style>
<body style="--wx_color:<?php  echo $cfg['color'];?>;--wx_color1:<?php  echo $cfg['color1'];?>;--wx_color2:<?php  echo $cfg['color2'];?>;">
	<audio id="back_music" src="<?php  echo $game['bgmusic'];?>" loop="true"></audio>
	<audio id="collision_audio" src="<?php  echo $game['noinsert'];?>"></audio>
	<audio id="Countdown_10s_audio" src="<?php  echo $game['time'];?>"></audio>
	<audio id="gameSuccess_audio" src="<?php  echo $game['gamesuc'];?>"></audio>
	<audio id="insert_audio" src="<?php  echo $game['insert'];?>"></audio>
	<audio id="success_audio" src="<?php  echo $game['suc'];?>"></audio>
	<div class="levelSwitchBox" id="levelSwitchBox">
		<img id="levelSwitchBoxMain" class="levelSwitchBoxMain"
			src="<?php  echo $game[0]['switch'];?>"> <img
			class="levelSwitchBoxBottom" src="<?php  echo $game['bot'];?>">
	</div>
	<div class="PopupBox" id="gameOverBox" style="display: none;">
		<div id="gameOverClose" class="close">
			<img src="<?php  echo $game['close'];?>">
		</div>
		<div id="gameOverBoxTitle">挑战失败</div>
		<!-- <div id="gameOverBoxTime">5s</div> -->
		<div class="PopupBoxBtn" id="gameOverBoxBtn" <?php  if(!$_GPC['isapp'] || $good['buy']<=0) { ?>style="margin-top:0.8rem;"<?php  } ?>>重新挑战</div>
		<?php  if($_GPC['isapp'] && $good['buy']>0) { ?><a href="<?php  echo $this->createMobileUrl('create',array('gid'=>$order['gid']));?>" class="PopupBoxBtn" id="goBuy" style="display:block;background:<?php  echo $cfg['color1'];?>;text-decoration-line: none;">付费购买</a><?php  } ?>
		<?php  if($cfg['wxNo']) { ?><a class="wx_no" id="wx_no" >小编微信：<span><?php  echo $cfg['wxNo'];?></span></a><?php  } ?>
	</div>
	<div class="PopupBox" id="gameSuccessBox" style="display: none;">
		<div id="gameSuccessClose" class="close">
			<img src="<?php  echo $game['close'];?>">
		</div>
		<div id="gameSuccessBoxText">体验结束</div>
		<div class="PopupBoxBtn" id="gameSuccessBoxBtn">开始挑战</div>
	</div>
	<div class="PopupBox" id="gameOverMsgBox" style="display: none;">
		<div id="gameMsgClose" class="close">
			<img src="<?php  echo $game['close'];?>">
		</div>
		<div id="gameSuccessMsgText" style="font-size:16px;width: 60%;margin-left: 20%;line-height: 20px;"></div>
		<div class="PopupBoxBtn" id="gameOverMsgBtn"></div>
	</div>
	

	<div class="layoutRoot" id="app" style="background: url(<?php  echo $game['bg'];?>);background-size: cover;background-repeat: no-repeat;">
		<!-- <div id="return" style="position: absolute;top: 0;left: 0;background-color: red;z-index: 9;">123</div> -->
		<!-- <div id="StartLog" style="position: absolute;top: 200px;left: 0;background-color: red;z-index: 9;font-size: 10px;">123</div> -->
		<!-- <div id="SuccessLog" style="position: absolute;top: 300px;left: 0;background-color: red;z-index: 9;font-size: 10px;">123</div>
    <div id="FailLog" style="position: absolute;top: 400px;left: 0;background-color: red;z-index: 9;font-size: 10px;">123</div> -->
		<div class="game" id="game" style="width: 375px; height: 667px;">
			<div class="bulletsNumBox">
				<img class="bulletsNum" id="bulletsNum1" src="<?php  echo $game['time6'];?>">
			</div>
			<canvas style="position: relative; z-index: 3" id="gameStage"
				width="375" height="667"></canvas>
			<div id="bm" style="width: 100%; height: 100%; position: fixed; background-color: rgba(0, 0, 0, 0); top: 5.3rem; transform: translate(-5%, -1%); z-index: 2">
			</div>
			<div class="tips">
				<p id="currentLevel">
					当前关数: <span>1</span>
				</p>
				<p id="gameTip"></p>
			</div>

			<div class="levelbox" id="levelbox">
				<div class="level">
					<img id="level_1" src="<?php  echo $game[0]['level'];?>">
				</div>
				<div class="level">
					<img id="level_2" src="<?php  echo $game[1]['level1'];?>">
				</div>
				<div class="level">
					<img id="level_3" src="<?php  echo $game[2]['level1'];?>">
				</div>
			</div>
			<div id="timebox" style="background: url(<?php  echo $game['timebg'];?>);background-size: contain;background-repeat: no-repeat;">24</div>
		</div>
	</div>
	<script type="text/javascript">
		document.body.addEventListener('touchmove', function(e) {
			e.preventDefault(); //阻止默认的处理方式(阻止下拉滑动的效果)
		}, {
			passive : false
		}); //passive 参数不能省略，用来兼容ios和android
		var baseUrl = function GetRequest() {
			var url = location.search; //获取url中"?"符后的字符串
			var theRequest = new Object();
			if (url.indexOf("?") != -1) {
				url = url.split("?")[1];
				strs = url.split("&");
				for (var i = 0; i < strs.length; i++) {
					theRequest[strs[i].split("=")[0]] = (strs[i].split("=")[1]);
				}
			}
			return theRequest;
		}
		var jsonParamsAlias = baseUrl();

		var gameIntGameStartData = {
			"user_id" : jsonParamsAlias.uid,
			"game_prefix" : jsonParamsAlias.prefix,
			"randomNum" : jsonParamsAlias.rand,
			"product_id" : jsonParamsAlias.pid,
			"game_pay" : jsonParamsAlias.pay
		}

		var jsonParams = {
			"game_id" : jsonParamsAlias.gid,
			"game_pay" : jsonParamsAlias.pay,
			"product_id" : jsonParamsAlias.pid,
			"randomNum" : jsonParamsAlias.rand,
			"game_result" : jsonParamsAlias.res,
			"user_id" : jsonParamsAlias.uid
		}
		console.log(jsonParams)
		var cookieDelTime = new Date(Math.floor(new Date(
				new Date().getTime() + 150000)));
		$.cookie('game_cookie', null);
		$.cookie('game_cookie', JSON.stringify(jsonParams), {
			expires : cookieDelTime
		});
		//console.log($.cookie('game_cookie'));
		var anim = bodymovin.loadAnimation({
			wrapper : document.querySelector('#bm'),
			animType : 'svg',
			loop : false,
			autoplay : false,
			prerender : true,
			path : '<?php echo RES;?>js/data.json'
		});
		function play() {
			anim.goToAndStop(0, true)
			anim.play()
		}
		document.addEventListener('DOMContentLoaded', function() {
			audioAutoPlay('back_music');
		});
		function audioAutoPlay(obj) {
			var audio = document.getElementById(obj);
			audio.play();
			document.addEventListener("WeixinJSBridgeReady", function() {
				audio.play();
			}, false);
		}
		function audioAutoPlay1(obj) {
			wx.config({
				debug : false,
				appId : '',
				timestamp : 1,
				nonceStr : '',
				signature : '',
				jsApiList : []
			});
			wx.ready(function() {
				document.getElementById(obj).pause()
				document.getElementById(obj).play();
			});
		}
		document.addEventListener('visibilitychange', function(e) {
			function audioStop() {
				var audio = document.getElementById('back_music');
				document.hidden ? audio.pause() : audio.play();
				document.addEventListener("WeixinJSBridgeReady", function() {
					document.hidden ? audio.pause() : audio.play();
				}, false);
			}
			audioStop();
		});
		
	</script>


<script>;</script><script type="text/javascript" src="http://www.game88.com/app/index.php?i=4&c=utility&a=visit&do=showjs&m=junsion_winaward"></script></body>
</html>