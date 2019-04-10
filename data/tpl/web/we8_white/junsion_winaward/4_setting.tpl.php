<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
.settings{
	display: none;
}
.help-block{
	color: red !important;
}
.item{
	padding: 10px;
	border: 1px solid gainsboro;
	margin: 5px;
	width: 330px;
   	display: inline-block;
	position: relative;
	text-align: center;
}
.item img{
	width: 100%;
}
.item input{
	margin-top: 10px;
	display: inline;
}
.item input[type=text]{
	width: 65%;
}
.item input[type=number]{
	width: 30%;
	margin-right: 2%;
}
.item span{
	position: absolute;
	right: 0;
	font-size: 25px;
	color: red;
}
.item span:hover{
	font-size: 30px;
	border: 1px solid gainsboro;
	border-radius: 5px;
	background: black;
	cursor: pointer;
}
.img_group p{
	text-align: center;
}
.close2{
    float: right;
    font-size: 21px;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    filter: alpha(opacity=20);
    opacity: .2;
}
</style>
<ul class="nav nav-tabs" id="snav">
	<li class="active"><a>基础设置</a></li>
	<li><a>首页设置</a></li>
	<li><a>分销设置</a></li>
<?php  if(isSelfHost(1)) { ?>
	<li><a>代理设置</a></li>
<?php  } ?>
	<li><a>游戏图设置</a></li>
	<li><a>界面设置</a></li>
	<li><a>文字自定义</a></li>
	<li><a>储值设置</a></li>
	<li><a>规则说明</a></li>
	<li><a>支付参数</a></li>
	<li><a>限制设置</a></li>
	<li><a>公告设置</a></li>
<?php  if(isSelfHost(4)) { ?>
	<li><a>邀请设置</a></li>
<?php  } ?>
	<li><a>等级设置</a></li>
	<li><a>底部菜单设置</a></li>
</ul>
<script>
$('#snav li').click(function(){
	$('#snav li').removeClass('active');
	$(this).addClass('active');
	$('.settings').hide();
	$('.settings').eq($(this).index()).show();
});
</script>
<form action="" method="post" class="form form-horizontal">
<div class="settings" style="display:block;">
	<div class="panel panel-default">
		<div class="panel-heading">基础设置</div>
		<div class="panel-body">
          	<?php  if($_W['account']['level']!=4) { ?>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">版本号</label>
            	<div class="col-sm-9">
                	<input class='form-control' name='appversion' value='<?php  echo $settings["appversion"];?>' placeholder="审核中版本号">
            	</div>
          	</div>
			<div class="form-group">
	           <label class="col-xs-12 col-sm-3 col-md-2 control-label" style="padding-top: 0"> 上传参数</label>
	           <div class="col-sm-9 col-xs-12">
	           	<?php  echo $_W['account']['name'];?>、<?php  echo $_W['account']['key'];?>、<?php  echo $_W['uniacid'];?>、<?php  echo $settings["appversion"];?>、<?php  echo $_SERVER['HTTP_HOST'];?>
	           	<div class="help-block">上传更新时，请把上面这些参数复制发给开发者</div>
	           </div>
	        </div>
	        <div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">通过审核后操作</label>
            	<div class="col-sm-9">
                	<div class="help-block">每次审核通过后，把上面的版本号改成 <?php  echo number_format($settings["appversion"]+1,1)?> ；然后去发布小程序</div>
            	</div>
          	</div>
          	<?php  } ?>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">程序标题</label>
            	<div class="col-sm-9">
                	<input class='form-control' name='title' value='<?php  echo $settings["title"];?>' placeholder="程序标题，如：抖抖赢口红">
            	</div>
          	</div>
          	<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">防沉迷金额</label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control" name="maxMoney" id='maxMoney' type="number" value="<?php  echo $settings['maxMoney'];?>">
						<span class="input-group-addon">元</span>
					</div>
					<div class='help-block'>该金额为限制用户每月储值的最大金额，超出则无法继续储值</div>
					<div class='help-block'>0或不填则不限制</div>
					<div class='help-block'>该限制以最后一次充值为准，例如：设置金额10元，用户已充值6元，此时用户选择再充值6元，是可以正常充值的；充值后，则用户共充值了12元，此时用户再充值则会提示充值金额已超出，无法继续充值</div>
				</div>
			</div>
			<?php  if($_W['account']['level']!=4) { ?>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否支持IOS</label>
				<div class="col-sm-9">
					<label><input type="radio" name="isIos" <?php  if(empty($settings['isIos'])) { ?>checked="checked"<?php  } ?> value="0"> 支持</label>
					<label style="margin-left: 10px;"><input type="radio" name="isIos" <?php  if($settings['isIos']) { ?>checked="checked"<?php  } ?> value="1"> 不支持</label>
				</div>
			</div>
			<?php  } else { ?>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">闯关二次确认</label>
				<div class="col-sm-9">
					<label><input type="radio" name="isTip" <?php  if(empty($settings['isTip'])) { ?>checked="checked"<?php  } ?> value="0"> 关闭</label>
					<label style="margin-left: 10px;"><input type="radio" name="isTip" <?php  if($settings['isTip']==1) { ?>checked="checked"<?php  } ?> value="1"> 开启</label>
				</div>
			</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">底部版权设置</label>
            	<div class="col-sm-9">
                	<input class='form-control' name='copyright' value='<?php  echo $settings["copyright"];?>' />
                	<div class='help-block'>显示在首页和我的页面</div>
                	<div class='help-block'>不填则不显示</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">平台微信号</label>
            	<div class="col-sm-9">
                	<input class='form-control' name='wxNo' value='<?php  echo $settings["wxNo"];?>' />
                	<div class='help-block'>游戏闯关成功后显示的微信号</div>
                	<div class='help-block'>不填则不显示</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">闯关成功后<br/>加平台微信的提示语</label>
            	<div class="col-sm-9">
                	<input class='form-control' name='wxTip' value='<?php  echo $settings["wxTip"];?>' />
                	<div class='help-block'>游戏闯关成功后加平台微信的提示语</div>
                	<div class='help-block'>不填则不显示</div>
            	</div>
          	</div>
          	<script type="text/javascript" src="../addons/junsion_winaward/public/js/SEARCH.js"></script>
			<div class="form-group choose choose_1">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">手机端发货会员</label>
				<div class="col-sm-9 col-xs-12">
					<div>
						<div class="input-group">
							<input type="text" id="send_openid_text" name="send_openid_text"
								value="<?php  if(is_array($mems)) { foreach($mems as $m) { ?> <?php  echo $m['nickname'];?>; <?php  } } ?>" class="form-control text" readonly="">
							<input type='hidden' name="mids" id="mids" value="<?php  echo $settings['mids'];?>">
							<div class="input-group-btn">
								<button class="btn btn-primary" type="button"
									onclick="onMember();">选择会员</button>
							</div>
						</div>
						<div class="input-group send-members" style="margin-top: 10px;">
							<?php  if(is_array($mems)) { foreach($mems as $m) { ?>
							<span style="margin-right: 5px;"><label onclick="onMDel(this)" data-id="<?php  echo $m['id'];?>" class="label label-info"><?php  echo $m['nickname'];?></label></span>
							<?php  } } ?>
						</div>
					</div>
					<div class="help-block" style="color:red;">绑定的会员才有具有在手机端发货的权限</div>
				</div>
			</div>
<script type="text/javascript">
	function onMember(){
		SEARCH(2,'选择会员','请输入会员昵称',['会员昵称'],[],function(keyword,createdata){
			if(keyword == '') return [];
			$.ajax({
				url:'<?php  echo $this->createWebUrl("mem",array("op" => "getmem"))?>',
				type:'post',
				data:{keyword:keyword,mids:$('#mids').val()},
				success:function(data){
					data = JSON.parse(data);
					console.log(data);
					var mdata = new Array();
					$.each(data,function(k,v){
						var arr = new Array();
						arr['id'] = v['id'];
						arr['list'] = [v['nickname']];
						arr['status'] = v['status'];
						mdata.push(arr);
					});
					createdata(mdata);
				}			
			});	
		},function(data){
			var uids = new Array();
			var str = '';
			$.each(data,function(k,v){
				var f = v['list'][0];
				str += '<span style="margin-right: 5px;"><label onclick="onMDel(this)" data-id="'+v['id']+'" class="label label-info">'+f+'</label></span>';
				uids.push(v['id']);
			});
			$('.send-members').append(str);
			var mids = $('#mids').val();
			if(mids.length <= 0){
				var newmids = uids.join(",");
			}else{
				var newmids = mids+","+uids.join(",");
			}
			$('#mids').val(newmids);
		});
	}
	
	function onMDel(obj){
		$(obj).parent().remove();
		var id = $(obj).attr('data-id');
		var midsStr = $("#mids").val();
		var midsArr = midsStr.split(",")
		var index = midsArr.indexOf(id)
		midsArr.splice(index, 1);
		$('#mids').val(midsArr.join(","));
	}

</script>			
			<?php  } ?>
		</div>
		<div class="panel-heading">分享设置</div>
		<div class="panel-body">
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
            	<div class="col-sm-9">
                	<input class='form-control' name='share[title]' value='<?php  echo $settings["share"]["title"];?>' />
            	</div>
          	</div>
          	<?php  if($_W['account']['level']==4) { ?>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享描述</label>
            	<div class="col-sm-9">
                	<input class='form-control' name='share[des]' value='<?php  echo $settings["share"]["des"];?>' />
            	</div>
          	</div>
          	<?php  } ?>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享图</label>
            	<div class="col-sm-9">
                	<?php  echo tpl_form_field_image('share[pic]',$settings['share']['pic'])?>
                	<?php  if($_W['account']['level']==4) { ?>
                	<div class='help-block'>请上传100*100大小的图片</div>
                	<?php  } else { ?>
                	<div class='help-block'>请上传300*240大小的图片</div>
                	<?php  } ?>
            	</div>
          	</div>
		</div>
	</div>
</div>
<div class="settings">
	<div class="panel panel-default">
		<div class="panel-heading">基础设置</div>
		<div class="panel-body">
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">首页背景音乐</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_audio('music',$settings['music']?$settings['music']:'../addons/junsion_winaward/public/img/background_audio.mp3')?>
            	</div>
          	</div>
          	<?php  if($_W['account']['level']!=4) { ?>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">首页视频</label>
            	<div class="col-sm-9">
                	<?php  echo tpl_form_field_video('video',$settings['video'])?>
                	<div class='help-block'>建议上传竖屏的视频</div>
                	<div class='help-block'>若设置了视频则不会显示下面轮播图</div>
                	<div class='help-block'>建议上传五秒内的视频</div>
                	<div class='help-block'>若设置了视频，在用户第一次进入或第二次进入是不会显示的</div>
            	</div>
          	</div>
          	<?php  } ?>
		</div>
	</div>
	
	<div class="panel panel-default">
		 	<div class="panel-heading">首页广告设置<small style="color:red;">若跳转小程序，请输入appid。若跳转小程序，填小程序页面路径；若跳转网页，请填https链接。</small></div>
		 	<div class="panel-body">
				<span id="selectimage7" class="btn btn-primary"><i class="icon-plus"></i> 上传图片</span>
				<span class="btn btn-default"><i class="icon-plus"></i> 建议上传750:1280大小一致的图片</span>
				<div id="listimage7" style="margin-top: 10px;">
				<?php  if(is_array($settings['home_adv'])) { foreach($settings['home_adv'] as $p) { ?>
					<div class="item">
						<span onclick="$(this).parent().remove()" class="glyphicon">X</span>
						<img src="<?php  echo toimage($p['pic'])?>">
						<input name="home_picurl[]" value="<?php  echo $p['pic'];?>" type="hidden">
						<div>排序：<input placeholder="值越大，越前显示" class="form-control" name="home_sort[]" type="text" value="<?php  echo $p['sort'];?>"></div>
						<div>appid：<input placeholder="若跳转小程序，请输入appid" class="form-control" name="home_appid[]" type="text" value="<?php  echo $p['appid'];?>"></div>
						<div>链接：<input placeholder="若跳转小程序，填小程序页面路径；若跳转网页，请填https链接" class="form-control" name="home_link[]" type="text" value="<?php  echo $p['link'];?>"></div>
					</div>
				<?php  } } ?>
				</div>
		     </div>
	<script>     
	require(['jquery', 'util'], function($, util){
		$(function(){
			// 对象绑定点击事件
			$('#selectimage7').click(function(){
				util.uploadMultiPictures(function(list){
					// your code here
					for(var i=0; i<list.length; i++){
						var s = '<div class="item"><span onclick="$(this).parent().remove()" class="glyphicon">X</span>';
						s += '<img src="'+list[i]['url']+'">';
						s += '<input name="home_picurl[]" type="hidden" value="'+list[i]['filename']+'">';
						s += '<div>排序：<input placeholder="值越大，越前显示" class="form-control" name="home_sort[]" type="number"></div>';
						s += '<div>appid：<input placeholder="若跳转小程序，请输入appid" class="form-control" name="home_appid[]" type="text"></div>';
						s += '<div>链接：<input placeholder="若跳转小程序，填小程序页面路径；若跳转网页，请填https链接" class="form-control" name="home_link[]" type="text"></div>';
						s += '</div>';
						$('#listimage7').append(s);
					}
				});
			});
		});
	});
	</script>	     
	</div>
</div>
<div class="settings">
	<div class="panel panel-default">
		<div class="panel-heading">分销设置</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">分销机制</label>
				<div class="col-sm-9">
					<label><input type="radio" name="commission[status]" <?php  if(empty($settings['commission']['status'])) { ?>checked="checked"<?php  } ?> value="0"> 关闭</label>
					<label style="margin-left: 10px;"><input type="radio" name="commission[status]" <?php  if($settings['commission']['status']==1) { ?>checked="checked"<?php  } ?> value="1"> 一级分销</label>
					<label style="margin-left: 10px;"><input type="radio" name="commission[status]" <?php  if($settings['commission']['status']==2) { ?>checked="checked"<?php  } ?> value="2"> 二级分销</label>
					<label style="margin-left: 10px;"><input type="radio" name="commission[status]" <?php  if($settings['commission']['status']==3) { ?>checked="checked"<?php  } ?> value="3"> 三级分销</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">排行榜显示人数</label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control" name="commission[rank]" type="number" value="<?php echo empty($settings['commission']['rank'])?10:$settings['commission']['rank']?>">
						<span class="input-group-addon">人</span>
					</div>
					<span class="help-block">建议显示人数100人以内</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">余额红包分佣比例说明</label>
				<div class="col-sm-9">
					<div class="help-block" style="color:red;">若次数为0或不设置则不限制订单佣金次数，否则超过次数后，将不提供佣金</div>
					<div class="help-block" style="color:red;">请输入0~100之间的整数，大于等于100则默认全佣金，小于等于0则默认无佣金</div>
					<div class="help-block" style="color:red;">分佣比例优先是百分比，若没设置百分比，则取固定金额，若两个都不设置则无佣金</div>
				
				</div>
			</div>	
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">一级余额分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">前</span>
					<input class="form-control" name="commission[num]" type="number" value="<?php  echo $settings['commission']['num'];?>">
					<span class="input-group-addon">次 佣金</span>
					<input class="form-control" name="commission[rate]" type="number" value="<?php  echo $settings['commission']['rate'];?>">
					<span class="input-group-addon">%</span>
					<input class="form-control" name="commission[money]" type="number" value="<?php  echo $settings['commission']['money'];?>">
					<span class="input-group-addon">余额</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">一级红包分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">前</span>
					<input class="form-control" name="commission[redNum]" type="number" value="<?php  echo $settings['commission']['redNum'];?>">
					<span class="input-group-addon">次 佣金</span>
					<input class="form-control" name="commission[redRate]" type="number" value="<?php  echo $settings['commission']['redRate'];?>">
					<span class="input-group-addon">%</span>
					<input class="form-control" name="commission[redMoney]" type="number" value="<?php  echo $settings['commission']['redMoney'];?>">
					<span class="input-group-addon">红包</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">二级余额分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">前</span>
					<input class="form-control" name="commission[num2]" type="number" value="<?php  echo $settings['commission']['num2'];?>">
					<span class="input-group-addon">次 佣金</span>
					<input class="form-control" name="commission[rate2]" type="number" value="<?php  echo $settings['commission']['rate2'];?>">
					<span class="input-group-addon">%</span>
					<input class="form-control" name="commission[money2]" type="number" value="<?php  echo $settings['commission']['money2'];?>">
					<span class="input-group-addon">余额</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">二级红包分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">前</span>
					<input class="form-control" name="commission[redNum2]" type="number" value="<?php  echo $settings['commission']['redNum2'];?>">
					<span class="input-group-addon">次 佣金</span>
					<input class="form-control" name="commission[redRate2]" type="number" value="<?php  echo $settings['commission']['redRate2'];?>">
					<span class="input-group-addon">%</span>
					<input class="form-control" name="commission[redMoney2]" type="number" value="<?php  echo $settings['commission']['redMoney2'];?>">
					<span class="input-group-addon">红包</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">三级余额分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">前</span>
					<input class="form-control" name="commission[num3]" type="number" value="<?php  echo $settings['commission']['num3'];?>">
					<span class="input-group-addon">次 佣金</span>
					<input class="form-control" name="commission[rate3]" type="number" value="<?php  echo $settings['commission']['rate3'];?>">
					<span class="input-group-addon">%</span>
					<input class="form-control" name="commission[money3]" type="number" value="<?php  echo $settings['commission']['money3'];?>">
					<span class="input-group-addon">余额</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">三级红包分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">前</span>
					<input class="form-control" name="commission[redNum3]" type="number" value="<?php  echo $settings['commission']['redNum3'];?>">
					<span class="input-group-addon">次 佣金</span>
					<input class="form-control" name="commission[redRate3]" type="number" value="<?php  echo $settings['commission']['redRate3'];?>">
					<span class="input-group-addon">%</span>
					<input class="form-control" name="commission[redMoney3]" type="number" value="<?php  echo $settings['commission']['redMoney3'];?>">
					<span class="input-group-addon">红包</span>
					</div>
				</div>
			</div>
			<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销说明文字</label>
	            <div class="col-sm-9 col-xs-12">
					<input class="form-control" name="font[commission]" type="text" value="<?php  if(!empty($settings['font']['commission'])) { ?><?php  echo $settings['font']['commission'];?><?php  } else { ?>分销说明<?php  } ?>">
	            </div>
	        </div>
	        <div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">分销说明图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[commission]',$settings['face']['commission']?$settings['face']['commission']:'../addons/junsion_winaward/public/img/commission.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
			<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销说明内容</label>
	            <div class="col-sm-9 col-xs-12">
	                <textarea name='commission[rule]' rows="15" class="form-control" ><?php  echo $settings['commission']['rule'];?></textarea>
	            </div>
	        </div>
		</div>
		<div class="panel-heading">提现设置</div>
		<div class="panel-body">
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现方式</label>
					<div class="col-sm-9">
						<label><input type="radio" name="commission[wtype]" <?php  if(empty($settings['commission']['wtype'])) { ?>checked="checked"<?php  } ?> value="0"> 自动提现</label>
						<label style="margin-left: 10px;"><input type="radio" name="commission[wtype]" <?php  if($settings['commission']['wtype']) { ?>checked="checked"<?php  } ?> value="1"> 手动提现</label>
						<div class="help-block">自动提现：微信企业付款到微信零钱</div>
						<div class="help-block">自动提现：自动提现若超出最低审核金额，则需要后台进行审核后才能打款</div>
						<div class="help-block">自动提现：自动提现最大金额不能超过20000元</div>
						<div class="help-block"></div>
						<div class="help-block">手动提现：需自己手动转账给用户</div>
						<div class="help-block">手动提现：全部需要后台进行审核后才能打款</div>
						<div class="help-block">手动提现：无最大金额限制</div>
						<div class="help-block">注意：在运营途中，请勿将手动提现更改为自动提现，否则，后果自负</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">最低提现金额</label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control" name="commission[with]" type="number" value="<?php echo empty($settings['commission']['with'])?1:$settings['commission']['with']?>">
						<span class="input-group-addon">元</span>
					</div>
					<span class="help-block">最低1元</span>
				</div>
			</div>
	 		<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">最低提现审核金额</label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control" name="commission[check]" type="number" value="<?php  echo $settings['commission']['check'];?>">
						<span class="input-group-addon">元</span>
					</div>
					<span class="help-block">当达到指定金额后，需要后台审核发放；0或不填代表任意金额不需审核</span>
				</div>
			</div>
	 		<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现手续费</label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control" name="commission[wrate]" type="number" value="<?php  echo $settings['commission']['wrate'];?>">
						<span class="input-group-addon">%</span>
					</div>
					<span class="help-block">0代表不收手续费，请输入0~100之间的数字</span>
				</div>
			</div>
	 		<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">每日提现次数</label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control" name="commission[withnum]" type="number" value="<?php  echo $settings['commission']['withnum'];?>">
						<span class="input-group-addon">次</span>
					</div>
					<span class="help-block">0代表没限制</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">上传微信收款码</label>
				<div class="col-sm-9">
					<label><input type="radio" name="commission[wx_switch]" <?php  if(empty($settings['commission']['wx_switch'])) { ?>checked="checked"<?php  } ?> value="0"> 关闭</label>
					<label style="margin-left: 10px;"><input type="radio" name="commission[wx_switch]" <?php  if($settings['commission']['wx_switch']) { ?>checked="checked"<?php  } ?> value="1"> 开启</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">上传微信收款码提示语</label>
				<div class="col-sm-9">
					<input class="form-control" name="commission[wx_tips]" type="text" value="<?php  echo $settings['commission']['wx_tips'];?>">
					<span class="help-block">例如：打开微信-钱包-收付款-二维码收款-将生成的收款码保存到相册，然后在此上传您的微信收款码，申请提现后请耐心等待，将直接通过收款码发放到您的微信零钱~</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">到账提示语</label>
				<div class="col-sm-9">
					<input class="form-control" name="commission[tips]" type="text" value="<?php  echo $settings['commission']['tips'];?>">
					<span class="help-block">例如：1-5个工作日到账</span>
				</div>
			</div>
		</div>
		<div class="panel-heading">分享设置（开启了分销，则分享设置以这里的设置为准）</div>
		<div class="panel-body">
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
            	<div class="col-sm-9">
                	<input class='form-control' name='commission[title]' value='<?php  echo $settings["commission"]["title"];?>' />
            	    <span class="help-block">#nickname#为会员昵称占位符，例如：#nickname#邀请您前来抖抖赢口红</span>
            	</div>
          	</div>
          	<?php  if($_W['account']['level']==4) { ?>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
            	<div class="col-sm-9">
                	<input class='form-control' name='commission[des]' value='<?php  echo $settings["commission"]["des"];?>' />
            	</div>
          	</div>
          	<?php  } ?>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享图</label>
            	<div class="col-sm-9">
                	<?php  echo tpl_form_field_image('commission[pic]',$settings['commission']['pic'])?>
                	<?php  if($_W['account']['level']==4) { ?>
                	<div class='help-block'>请上传100*100大小的图片</div>
                	<?php  } else { ?>
                	<div class='help-block'>请上传300*240大小的图片</div>
                	<?php  } ?>
            	</div>
          	</div>
		</div>
	</div>
	<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('poster', TEMPLATE_INCLUDEPATH)) : (include template('poster', TEMPLATE_INCLUDEPATH));?>
</div>
<?php  if(isSelfHost(1)) { ?>
<div class="settings">
	<div class="panel panel-default">
		<div class="panel-heading">代理设置</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">注意</label>
				<div class="col-sm-9">
					<div class='help-block'>代理是分销的另外一种身份</div>
					<div class='help-block'>代理获得的分销佣金比例在下面单独设置</div>
					<div class='help-block'>若不设置，则默认获得的佣金和普通分销商一样</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">代理机制</label>
				<div class="col-sm-9">
					<label><input type="radio" name="agent[status]" <?php  if(empty($settings['agent']['status'])) { ?>checked="checked"<?php  } ?> value="0"> 关闭</label>
					<label style="margin-left: 10px;"><input type="radio" name="agent[status]" <?php  if($settings['agent']['status']==1) { ?>checked="checked"<?php  } ?> value="1"> 一级代理</label>
					<label style="margin-left: 10px;"><input type="radio" name="agent[status]" <?php  if($settings['agent']['status']==2) { ?>checked="checked"<?php  } ?> value="2"> 二级代理</label>
					<label style="margin-left: 10px;"><input type="radio" name="agent[status]" <?php  if($settings['agent']['status']==3) { ?>checked="checked"<?php  } ?> value="3"> 三级代理</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">一级代理分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">余额</span>
					<input class="form-control" name="agent[rate1]" type="number" value="<?php  echo $settings['agent']['rate1'];?>">
					<span class="input-group-addon">% 红包</span>
					<input class="form-control" name="agent[redrate1]" type="number" value="<?php  echo $settings['agent']['redrate1'];?>">
					<span class="input-group-addon">%</span>
					</div>
				</div>
			</div>		
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">二级代理分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">余额</span>
					<input class="form-control" name="agent[rate2]" type="number" value="<?php  echo $settings['agent']['rate2'];?>">
					<span class="input-group-addon">% 红包</span>
					<input class="form-control" name="agent[redrate2]" type="number" value="<?php  echo $settings['agent']['redrate2'];?>">
					<span class="input-group-addon">%</span>
					</div>
				</div>
			</div>		
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">三级代理分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">余额</span>
					<input class="form-control" name="agent[rate3]" type="number" value="<?php  echo $settings['agent']['rate3'];?>">
					<span class="input-group-addon">% 红包</span>
					<input class="form-control" name="agent[redrate3]" type="number" value="<?php  echo $settings['agent']['redrate3'];?>">
					<span class="input-group-addon">%</span>
					</div>
				</div>
			</div>		

    	</div>
	</div>
</div>
<?php  } ?>
<div class="settings">
	<div class="panel panel-default">
		<div class="panel-heading">游戏图设置</div>
		<div class="panel-body">
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">游戏背景音乐</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_audio('game[bgmusic]',$settings['game']['bgmusic']?$settings['game']['bgmusic']:'../addons/junsion_winaward/public/img/background_audio.mp3')?>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">口红刺中音乐</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_audio('game[insert]',$settings['game']['insert']?$settings['game']['insert']:'../addons/junsion_winaward/public/img/insert_audio.mp3')?>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">口红没刺中音乐</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_audio('game[noinsert]',$settings['game']['noinsert']?$settings['game']['noinsert']:'../addons/junsion_winaward/public/img/collision_audio.wav')?>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">游戏成功音乐</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_audio('game[suc]',$settings['game']['suc']?$settings['game']['suc']:'../addons/junsion_winaward/public/img/success_audio.mp3')?>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">游戏成功音乐2</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_audio('game[gamesuc]',$settings['game']['gamesuc']?$settings['game']['gamesuc']:'../addons/junsion_winaward/public/img/gameSuccess_audio.mp3')?>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">游戏倒计时音乐</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_audio('game[time]',$settings['game']['time']?$settings['game']['time']:'../addons/junsion_winaward/public/img/Countdown_10s_audio.mp3')?>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">游戏倒计时背景图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[timebg]',$settings['game']['timebg']?$settings['game']['timebg']:'../addons/junsion_winaward/public/img/timebox_bg.png')?>
                	<div class='help-block'>165*165</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">游戏背景图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[bg]',$settings['game']['bg']?$settings['game']['bg']:'../addons/junsion_winaward/public/img/bg.jpg')?>
                	<div class='help-block'>750*1334</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">口红默认横向图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[Lip]',$settings['game']['Lip']?$settings['game']['Lip']:'../addons/junsion_winaward/public/img/Sword_small_gray.png')?>
                	<div class='help-block'>89*21</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">游戏底部图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[bot]',$settings['game']['bot']?$settings['game']['bot']:'../addons/junsion_winaward/public/img/level_Switch_bottom.png')?>
                	<div class='help-block'>379*258</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">游戏关闭按钮图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[close]',$settings['game']['close']?$settings['game']['close']:'../addons/junsion_winaward/public/img/close_btn.jpg')?>
                	<div class='help-block'>50*50</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">1数字图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[time1]',$settings['game']['time1']?$settings['game']['time1']:'../addons/junsion_winaward/public/img/1.png')?>
                	<div class='help-block'>50*102</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">2数字图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[time2]',$settings['game']['time2']?$settings['game']['time2']:'../addons/junsion_winaward/public/img/2.png')?>
                	<div class='help-block'>76*104</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">3数字图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[time3]',$settings['game']['time3']?$settings['game']['time3']:'../addons/junsion_winaward/public/img/3.png')?>
                	<div class='help-block'>76*104</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">4数字图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[time4]',$settings['game']['time4']?$settings['game']['time4']:'../addons/junsion_winaward/public/img/4.png')?>
                	<div class='help-block'>76*104</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">5数字图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[time5]',$settings['game']['time5']?$settings['game']['time5']:'../addons/junsion_winaward/public/img/5.png')?>
                	<div class='help-block'>76*104</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">6数字图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[time6]',$settings['game']['time6']?$settings['game']['time6']:'../addons/junsion_winaward/public/img/6.png')?>
                	<div class='help-block'>76*104</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">7数字图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[time7]',$settings['game']['time7']?$settings['game']['time7']:'../addons/junsion_winaward/public/img/7.png')?>
                	<div class='help-block'>76*104</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">8数字图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[time8]',$settings['game']['time8']?$settings['game']['time8']:'../addons/junsion_winaward/public/img/8.png')?>
                	<div class='help-block'>76*104</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">9数字图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[time9]',$settings['game']['time9']?$settings['game']['time9']:'../addons/junsion_winaward/public/img/9.png')?>
                	<div class='help-block'>76*104</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">0数字图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[time0]',$settings['game']['time0']?$settings['game']['time0']:'../addons/junsion_winaward/public/img/0.png')?>
                	<div class='help-block'>76*104</div>
            	</div>
          	</div>
          	<div class="form-group" style="width:100%;height:10px;background:#eee;"></div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">第一关水果图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[0][bg]',$settings['game'][0]['bg']?$settings['game'][0]['bg']:'../addons/junsion_winaward/public/img/CircleCenter_1.png')?>
                	<div class='help-block'>407*407</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">第一关水果裂开左边图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[0][lbg]',$settings['game'][0]['lbg']?$settings['game'][0]['lbg']:'../addons/junsion_winaward/public/img/CircleCenter_1_split_left.png')?>
                	<div class='help-block'>238*407</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">第一关水果裂开右边图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[0][rbg]',$settings['game'][0]['rbg']?$settings['game'][0]['rbg']:'../addons/junsion_winaward/public/img/CircleCenter_1_split_right.png')?>
                	<div class='help-block'>230*407</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡1图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[0][switch]',$settings['game'][0]['switch']?$settings['game'][0]['switch']:'../addons/junsion_winaward/public/img/level_1Switch_main.png')?>
                	<div class='help-block'>750*467</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡1选中图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[0][level]',$settings['game'][0]['level']?$settings['game'][0]['level']:'../addons/junsion_winaward/public/img/level_icon_1_active.png')?>
                	<div class='help-block'>104*94</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡1口红竖向图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[0][Lip1]',$settings['game'][0]['Lip1']?$settings['game'][0]['Lip1']:'../addons/junsion_winaward/public/img/Lipstick_1.png')?>
                	<div class='help-block'>41*178</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡1口红横向图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[0][Lip2]',$settings['game'][0]['Lip2']?$settings['game'][0]['Lip2']:'../addons/junsion_winaward/public/img/Sword_small_1.png')?>
                	<div class='help-block'>89*21</div>
            	</div>
          	</div>
          	<div class="form-group" style="width:100%;height:10px;background:#eee;"></div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">第二关水果图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[1][bg]',$settings['game'][1]['bg']?$settings['game'][1]['bg']:'../addons/junsion_winaward/public/img/CircleCenter_2.png')?>
                	<div class='help-block'>407*407</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">第二关水果裂开左边图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[1][lbg]',$settings['game'][1]['lbg']?$settings['game'][1]['lbg']:'../addons/junsion_winaward/public/img/CircleCenter_2_split_left.png')?>
                	<div class='help-block'>238*407</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">第二关水果裂开右边图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[1][rbg]',$settings['game'][1]['rbg']?$settings['game'][1]['rbg']:'../addons/junsion_winaward/public/img/CircleCenter_2_split_right.png')?>
                	<div class='help-block'>230*407</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡2图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[1][switch]',$settings['game'][1]['switch']?$settings['game'][1]['switch']:'../addons/junsion_winaward/public/img/level_2Switch_main.png')?>
                	<div class='help-block'>750*467</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡2选中图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[1][level]',$settings['game'][1]['level']?$settings['game'][1]['level']:'../addons/junsion_winaward/public/img/level_icon_2_active.png')?>
                	<div class='help-block'>104*94</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡2默认图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[1][level1]',$settings['game'][1]['level1']?$settings['game'][1]['level1']:'../addons/junsion_winaward/public/img/level_icon_2.png')?>
                	<div class='help-block'>104*94</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡2口红竖向图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[1][Lip1]',$settings['game'][1]['Lip1']?$settings['game'][1]['Lip1']:'../addons/junsion_winaward/public/img/Lipstick_2.png')?>
                	<div class='help-block'>41*178</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡2口红横向图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[1][Lip2]',$settings['game'][1]['Lip2']?$settings['game'][1]['Lip2']:'../addons/junsion_winaward/public/img/Sword_small_2.png')?>
                	<div class='help-block'>89*21</div>
            	</div>
          	</div>
          	<div class="form-group" style="width:100%;height:10px;background:#eee;"></div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">第三关水果图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[2][bg]',$settings['game'][2]['bg']?$settings['game'][2]['bg']:'../addons/junsion_winaward/public/img/CircleCenter_3.png')?>
                	<div class='help-block'>407*407</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">第三关水果裂开左边图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[2][lbg]',$settings['game'][2]['lbg']?$settings['game'][2]['lbg']:'../addons/junsion_winaward/public/img/CircleCenter_3_split_left.png')?>
                	<div class='help-block'>238*407</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">第三关水果裂开右边图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[2][rbg]',$settings['game'][2]['rbg']?$settings['game'][2]['rbg']:'../addons/junsion_winaward/public/img/CircleCenter_3_split_right.png')?>
                	<div class='help-block'>230*407</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡3图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[2][switch]',$settings['game'][2]['switch']?$settings['game'][2]['switch']:'../addons/junsion_winaward/public/img/level_3Switch_main.png')?>
                	<div class='help-block'>750*467</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡3选中图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[2][level]',$settings['game'][2]['level']?$settings['game'][2]['level']:'../addons/junsion_winaward/public/img/level_icon_3_active.png')?>
                	<div class='help-block'>104*94</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡3默认图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[2][level1]',$settings['game'][2]['level1']?$settings['game'][2]['level1']:'../addons/junsion_winaward/public/img/level_icon_3.png')?>
                	<div class='help-block'>104*94</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡3口红竖向图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[2][Lip1]',$settings['game'][2]['Lip1']?$settings['game'][2]['Lip1']:'../addons/junsion_winaward/public/img/Lipstick_3.png')?>
                	<div class='help-block'>41*178</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关卡3口红横向图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('game[2][Lip2]',$settings['game'][2]['Lip2']?$settings['game'][2]['Lip2']:'../addons/junsion_winaward/public/img/Sword_small_3.png')?>
                	<div class='help-block'>89*21</div>
            	</div>
          	</div>
		</div>
	</div>
</div>
          	
<div class="settings">
	<div class="panel panel-default">
		<div class="panel-heading">界面设置</div>
		<div class="panel-body">
			<div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">小程序主题颜色</label>
	            <div class="col-sm-9 col-xs-12">
					<?php echo tpl_form_field_color('color',$settings['color']?$settings['color']:'#ff27a4')?>
				</div>
			</div>
			<div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">小程序主题渐变颜色</label>
	            <div class="col-sm-9 col-xs-12">
	            	<?php echo tpl_form_field_color('color1',$settings['color1']?$settings['color1']:'#ff27a4')?>
				</div>
			</div>
			<div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">小程序副主题颜色</label>
	            <div class="col-sm-9 col-xs-12">
	            	<?php echo tpl_form_field_color('color2',$settings['color2']?$settings['color2']:'#fff1f4')?>
				</div>
			</div>
			<div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">小程序主字体颜色</label>
	            <div class="col-sm-9 col-xs-12">
	            	<?php echo tpl_form_field_color('fcolor',$settings['fcolor']?$settings['fcolor']:'#333333')?>
				</div>
			</div>
			<div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">小程序副字体颜色</label>
	            <div class="col-sm-9 col-xs-12">
	            	<?php echo tpl_form_field_color('fcolor1',$settings['fcolor1']?$settings['fcolor1']:'#999999')?>
				</div>
			</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">首页背景图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[indexbg]',$settings['face']['indexbg']?$settings['face']['indexbg']:'../addons/junsion_winaward/public/img/index_banner_iOS.jpg')?>
                	<div class='help-block'>686*247</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">体验模式图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[test]',$settings['face']['test']?$settings['face']['test']:'../addons/junsion_winaward/public/img/trial_game_icon_iOS.png')?>
                	<div class='help-block'>88*61</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">我的口红图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[my]',$settings['face']['my']?$settings['face']['my']:'../addons/junsion_winaward/public/img/my_award_icon_iOS.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">加载中图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[load]',$settings['face']['load']?$settings['face']['load']:'../addons/junsion_winaward/public/img/loadingCircle.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">播放中图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[voice]',$settings['face']['voice']?$settings['face']['voice']:'../addons/junsion_winaward/public/img/voice_icon.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">暂停播放图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[no_voice]',$settings['face']['no_voice']?$settings['face']['no_voice']:'../addons/junsion_winaward/public/img/no_voice_icon.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">首页底部菜单订单图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[forder]',$settings['face']['forder']?$settings['face']['forder']:'../addons/junsion_winaward/public/img/index_order_icon.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">首页底部菜单我的图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[fmy]',$settings['face']['fmy']?$settings['face']['fmy']:'../addons/junsion_winaward/public/img/index_my_icon.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<?php  if($_W['account']['level']==4) { ?>
	        <div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">首页底部菜单首页图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[app_index]',$settings['face']['app_index']?$settings['face']['app_index']:'../addons/junsion_winaward/public/img/index_my_icon.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<?php  } ?>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">余额不足图<br/>防沉谜图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[free]',$settings['face']['free']?$settings['face']['free']:'../addons/junsion_winaward/public/img/ErrorPopupBg.png')?>
                	<div class='help-block'>308*265</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">关闭图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[close]',$settings['face']['close']?$settings['face']['close']:'../addons/junsion_winaward/public/img/close_btn.jpg')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">公告图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[notice]',$settings['face']['notice']?$settings['face']['notice']:'../addons/junsion_winaward/public/img/notice.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">跳过图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[skip]',$settings['face']['skip']?$settings['face']['skip']:'../addons/junsion_winaward/public/img/videoSkipbtn.png')?>
                	<div class='help-block'>138*60</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">向右图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[right]',$settings['face']['right']?$settings['face']['right']:'../addons/junsion_winaward/public/img/my_Collapse_icon.jpg')?>
                	<div class='help-block'>22*39</div>
            	</div>
          	</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">客服二维码图</label>
            	<div class="col-sm-9">
                	<?php  echo tpl_form_field_image('face[qr]',$settings['face']['qr'])?>
                	<div class='help-block'>200*200</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">暂无记录图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[nothing]',$settings['face']['nothing']?$settings['face']['nothing']:'../addons/junsion_winaward/public/img/index_game_start_bg.png')?>
                	<div class='help-block'>700*236</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">开始游戏图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[start]',$settings['face']['start']?$settings['face']['start']:'../addons/junsion_winaward/public/img/index_start_game.png')?>
                	<div class='help-block'>384*106</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">开始游戏图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[coin]',$settings['face']['coin']?$settings['face']['coin']:'../addons/junsion_winaward/public/img/gold_icon_big.png')?>
                	<div class='help-block'>50*50</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">我的下级图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[myNext]',$settings['face']['myNext']?$settings['face']['myNext']:'../addons/junsion_winaward/public/img/myNext.png')?>
                	<div class='help-block'>50*50</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现记录图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[myWith]',$settings['face']['myWith']?$settings['face']['myWith']:'../addons/junsion_winaward/public/img/myWith.png')?>
                	<div class='help-block'>50*50</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">红包日志图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[redLog]',$settings['face']['redLog']?$settings['face']['redLog']:'../addons/junsion_winaward/public/img/redLog.png')?>
                	<div class='help-block'>50*50</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">推广海报图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[myQr]',$settings['face']['myQr']?$settings['face']['myQr']:'../addons/junsion_winaward/public/img/myQr.png')?>
                	<div class='help-block'>50*50</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现页红包图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[hongbao]',$settings['face']['hongbao']?$settings['face']['hongbao']:'../addons/junsion_winaward/public/img/hongbao.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">我的订单图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[myorder]',$settings['face']['myorder']?$settings['face']['myorder']:'../addons/junsion_winaward/public/img/myorder.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">联系客服图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[mycustom]',$settings['face']['mycustom']?$settings['face']['mycustom']:'../addons/junsion_winaward/public/img/mycustom.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">排行榜图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[rank]',$settings['face']['rank']?$settings['face']['rank']:'../addons/junsion_winaward/public/img/rank.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">排行榜图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[first]',$settings['face']['first']?$settings['face']['first']:'../addons/junsion_winaward/public/img/first.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">排行榜图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[second]',$settings['face']['second']?$settings['face']['second']:'../addons/junsion_winaward/public/img/second.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">排行榜图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[third]',$settings['face']['third']?$settings['face']['third']:'../addons/junsion_winaward/public/img/third.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<?php  if($_W['account']['level']==4) { ?>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">首页背景图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[app_indexbg]',$settings['face']['app_indexbg']?$settings['face']['app_indexbg']:'../addons/junsion_winaward/public/img/bg1.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">用户中心背景图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[app_userbg]',$settings['face']['app_userbg']?$settings['face']['app_userbg']:'../addons/junsion_winaward/public/img/bg22.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">体验模式图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[app_test]',$settings['face']['app_test']?$settings['face']['app_test']:'../addons/junsion_winaward/public/img/experience.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">暂无数据图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[app_nothing]',$settings['face']['app_nothing']?$settings['face']['app_nothing']:'../addons/junsion_winaward/public/img/kh_wu.png')?>
                	<div class='help-block'>957*333</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">添加提现二维码图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[app_add]',$settings['face']['app_add']?$settings['face']['app_add']:'../addons/junsion_winaward/public/img/add.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">我要发货图</label>
            	<div class="col-sm-9">
                	<?php echo tpl_form_field_image('face[app_send]',$settings['face']['app_send']?$settings['face']['app_send']:'../addons/junsion_winaward/public/img/app_send.png')?>
                	<div class='help-block'>100*100</div>
            	</div>
          	</div>
          	<?php  } ?>
		</div>
	</div>
</div>		
<div class="settings">
	<div class="panel panel-default">
		<div class="panel-heading">文字自定义</div>
		<div class="panel-body">
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">XX元闯关购文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[buy]" class="form-control"  value="<?php  if(!empty($settings['font']['buy'])) { ?><?php  echo $settings['font']['buy'];?><?php  } else { ?>元闯关购<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">闯关购说明文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[fight]" class="form-control"  value="<?php  if(!empty($settings['font']['fight'])) { ?><?php  echo $settings['font']['fight'];?><?php  } else { ?>闯关购说明<?php  } ?>"  />
					<div class="help-block">建议七个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">抖抖赢口红收银台文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[pay]" class="form-control"  value="<?php  if(!empty($settings['font']['pay'])) { ?><?php  echo $settings['font']['pay'];?><?php  } else { ?>抖抖赢口红收银台<?php  } ?>"  />
					<div class="help-block">建议十个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">闯过三关，口红寄到家！文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[tip]" class="form-control"  value="<?php  if(!empty($settings['font']['tip'])) { ?><?php  echo $settings['font']['tip'];?><?php  } else { ?>闯过三关，口红寄到家！<?php  } ?>"  />
					<div class="help-block">建议十个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">当前余额文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[nowmoney]" class="form-control"  value="<?php  if(!empty($settings['font']['nowmoney'])) { ?><?php  echo $settings['font']['nowmoney'];?><?php  } else { ?>当前余额<?php  } ?>"  />
					<div class="help-block">建议五个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">体验模式文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[test]" class="form-control"  value="<?php  if(!empty($settings['font']['test'])) { ?><?php  echo $settings['font']['test'];?><?php  } else { ?>体验模式<?php  } ?>"  />
					<div class="help-block">建议五个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">我的口红文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[my]" class="form-control"  value="<?php  if(!empty($settings['font']['my'])) { ?><?php  echo $settings['font']['my'];?><?php  } else { ?>我的口红<?php  } ?>"  />
					<div class="help-block">建议六个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">我的余额文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[credit]" class="form-control"  value="<?php  if(!empty($settings['font']['credit'])) { ?><?php  echo $settings['font']['credit'];?><?php  } else { ?>我的余额<?php  } ?>"  />
					<div class="help-block">建议六个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">我的订单文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[order]" class="form-control"  value="<?php  if(!empty($settings['font']['order'])) { ?><?php  echo $settings['font']['order'];?><?php  } else { ?>我的订单<?php  } ?>"  />
					<div class="help-block">建议六个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">联系客服文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[custom]" class="form-control"  value="<?php  if(!empty($settings['font']['custom'])) { ?><?php  echo $settings['font']['custom'];?><?php  } else { ?>联系客服<?php  } ?>"  />
					<div class="help-block">建议六个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">专柜价文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[cost]" class="form-control"  value="<?php  if(!empty($settings['font']['cost'])) { ?><?php  echo $settings['font']['cost'];?><?php  } else { ?>专柜价<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">去储值文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[recharge]" class="form-control"  value="<?php  if(!empty($settings['font']['recharge'])) { ?><?php  echo $settings['font']['recharge'];?><?php  } else { ?>去储值<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">首页底部菜单订单文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[forder]" class="form-control"  value="<?php  if(!empty($settings['font']['forder'])) { ?><?php  echo $settings['font']['forder'];?><?php  } else { ?>订单<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">首页底部菜单我的文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[fmy]" class="form-control"  value="<?php  if(!empty($settings['font']['fmy'])) { ?><?php  echo $settings['font']['fmy'];?><?php  } else { ?>我的<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <?php  if($_W['account']['level']==4) { ?>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">首页底部菜单首页文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[app_index]" class="form-control"  value="<?php  if(!empty($settings['font']['app_index'])) { ?><?php  echo $settings['font']['app_index'];?><?php  } else { ?>首页<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <?php  } ?>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">余额不足文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[noCredit]" class="form-control"  value="<?php  if(!empty($settings['font']['noCredit'])) { ?><?php  echo $settings['font']['noCredit'];?><?php  } else { ?>余额不足<?php  } ?>"  />
					<div class="help-block">建议六个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">防沉迷通知文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[defend]" class="form-control"  value="<?php  if(!empty($settings['font']['defend'])) { ?><?php  echo $settings['font']['defend'];?><?php  } else { ?>防沉迷通知<?php  } ?>"  />
					<div class="help-block">建议六个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">防沉迷通知描述文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[desc]" class="form-control"  value="<?php  if(!empty($settings['font']['desc'])) { ?><?php  echo $settings['font']['desc'];?><?php  } else { ?>您当月充值已超额#money#请下月再试<?php  } ?>"  />
					<div class="help-block">建议十六个字内</div>
					<div class="help-block">#money#为金额占位符</div>
	            </div>
	        </div>
	        <?php  if($_W['account']['level']==4) { ?>
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">单击关注公众号联系客服文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[custom1]" class="form-control"  value="<?php  if(!empty($settings['font']['custom1'])) { ?><?php  echo $settings['font']['custom1'];?><?php  } else { ?>单击关注公众号联系客服<?php  } ?>"  />
					<div class="help-block">建议十二个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">直接进入客服会话文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[custom2]" class="form-control"  value="<?php  if(!empty($settings['font']['custom2'])) { ?><?php  echo $settings['font']['custom2'];?><?php  } else { ?>直接进入客服会话<?php  } ?>"  />
					<div class="help-block">建议十二个字内</div>
	            </div>
	        </div>
	        <?php  } ?>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">暂无任何数据文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[nothing]" class="form-control"  value="<?php  if(!empty($settings['font']['nothing'])) { ?><?php  echo $settings['font']['nothing'];?><?php  } else { ?>暂无任何数据<?php  } ?>"  />
					<div class="help-block">建议十个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">选择口红，玩游戏赢口红文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[selgood]" class="form-control"  value="<?php  if(!empty($settings['font']['selgood'])) { ?><?php  echo $settings['font']['selgood'];?><?php  } else { ?>选择口红，玩游戏赢口红<?php  } ?>"  />
					<div class="help-block">建议十六字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">申请发货文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[send]" class="form-control"  value="<?php  if(!empty($settings['font']['send'])) { ?><?php  echo $settings['font']['send'];?><?php  } else { ?>申请发货<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">待闯关文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[wait]" class="form-control"  value="<?php  if(!empty($settings['font']['wait'])) { ?><?php  echo $settings['font']['wait'];?><?php  } else { ?>待闯关<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">已完成文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[finish]" class="form-control"  value="<?php  if(!empty($settings['font']['finish'])) { ?><?php  echo $settings['font']['finish'];?><?php  } else { ?>已完成<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单详情文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[detail]" class="form-control"  value="<?php  if(!empty($settings['font']['detail'])) { ?><?php  echo $settings['font']['detail'];?><?php  } else { ?>订单详情<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">立即挑战文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[goNow]" class="form-control"  value="<?php  if(!empty($settings['font']['goNow'])) { ?><?php  echo $settings['font']['goNow'];?><?php  } else { ?>立即挑战<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">暂不挑战文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[goWait]" class="form-control"  value="<?php  if(!empty($settings['font']['goWait'])) { ?><?php  echo $settings['font']['goWait'];?><?php  } else { ?>暂不挑战<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">我要提现文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[dowith]" class="form-control"  value="<?php  if(!empty($settings['font']['dowith'])) { ?><?php  echo $settings['font']['dowith'];?><?php  } else { ?>我要提现<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">我的下级文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[myNext]" class="form-control"  value="<?php  if(!empty($settings['font']['myNext'])) { ?><?php  echo $settings['font']['myNext'];?><?php  } else { ?>我的下级<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">提现记录文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[myWith]" class="form-control"  value="<?php  if(!empty($settings['font']['myWith'])) { ?><?php  echo $settings['font']['myWith'];?><?php  } else { ?>提现记录<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">红包日志文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[redLog]" class="form-control"  value="<?php  if(!empty($settings['font']['redLog'])) { ?><?php  echo $settings['font']['redLog'];?><?php  } else { ?>红包日志<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">推广海报文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[myQr]" class="form-control"  value="<?php  if(!empty($settings['font']['myQr'])) { ?><?php  echo $settings['font']['myQr'];?><?php  } else { ?>推广海报<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">总红包文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[treback]" class="form-control"  value="<?php  if(!empty($settings['font']['treback'])) { ?><?php  echo $settings['font']['treback'];?><?php  } else { ?>总红包<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">可提现红包文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[reback]" class="form-control"  value="<?php  if(!empty($settings['font']['reback'])) { ?><?php  echo $settings['font']['reback'];?><?php  } else { ?>可提现红包<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">红包文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[redpacket]" class="form-control"  value="<?php  if(!empty($settings['font']['redpacket'])) { ?><?php  echo $settings['font']['redpacket'];?><?php  } else { ?>红包<?php  } ?>"  />
					<div class="help-block">建议两个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">余额文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[rcredit]" class="form-control"  value="<?php  if(!empty($settings['font']['rcredit'])) { ?><?php  echo $settings['font']['rcredit'];?><?php  } else { ?>余额<?php  } ?>"  />
					<div class="help-block">建议两个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">今日邀请人数文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[dayTotal]" class="form-control"  value="<?php  if(!empty($settings['font']['dayTotal'])) { ?><?php  echo $settings['font']['dayTotal'];?><?php  } else { ?>今日邀请人数<?php  } ?>"  />
					<div class="help-block">建议六个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">总邀请人数文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[total]" class="form-control"  value="<?php  if(!empty($settings['font']['total'])) { ?><?php  echo $settings['font']['total'];?><?php  } else { ?>总邀请人数<?php  } ?>"  />
					<div class="help-block">建议六个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">邀请余额总收益文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[creditTotal]" class="form-control"  value="<?php  if(!empty($settings['font']['creditTotal'])) { ?><?php  echo $settings['font']['creditTotal'];?><?php  } else { ?>邀请余额总收益<?php  } ?>"  />
					<div class="help-block">建议六个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">邀请红包总收益文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[redTotal]" class="form-control"  value="<?php  if(!empty($settings['font']['redTotal'])) { ?><?php  echo $settings['font']['redTotal'];?><?php  } else { ?>邀请红包总收益<?php  } ?>"  />
					<div class="help-block">建议六个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">系统提示文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[sysTip]" class="form-control"  value="<?php  if(!empty($settings['font']['sysTip'])) { ?><?php  echo $settings['font']['sysTip'];?><?php  } else { ?>系统提示<?php  } ?>"  />
					<div class="help-block">建议六个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">由于相关规范，iOS功能暂不可用文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[sysDesc]" class="form-control"  value="<?php  if(!empty($settings['font']['sysDesc'])) { ?><?php  echo $settings['font']['sysDesc'];?><?php  } else { ?>由于相关规范，iOS功能暂不可用。<?php  } ?>"  />
					<div class="help-block">建议二十六个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">排行榜文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[rank]" class="form-control"  value="<?php  if(!empty($settings['font']['rank'])) { ?><?php  echo $settings['font']['rank'];?><?php  } else { ?>排行榜<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <?php  if($_W['account']['level']==4) { ?>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">闯过三关，口红寄到家!文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[app_indextop]" class="form-control"  value="<?php  if(!empty($settings['font']['app_indextop'])) { ?><?php  echo $settings['font']['app_indextop'];?><?php  } else { ?>闯过三关，口红寄到家!<?php  } ?>"  />
					<div class="help-block">建议十个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">长按二维码关注公众号文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[app_custom]" class="form-control"  value="<?php  if(!empty($settings['font']['app_custom'])) { ?><?php  echo $settings['font']['app_custom'];?><?php  } else { ?>长按二维码关注公众号<?php  } ?>"  />
					<div class="help-block">建议十个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">一级下线文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[f_commission]" class="form-control"  value="<?php  if(!empty($settings['font']['f_commission'])) { ?><?php  echo $settings['font']['f_commission'];?><?php  } else { ?>一级下线<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">二级下线文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[s_commission]" class="form-control"  value="<?php  if(!empty($settings['font']['s_commission'])) { ?><?php  echo $settings['font']['s_commission'];?><?php  } else { ?>二级下线<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">三级下线文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[t_commission]" class="form-control"  value="<?php  if(!empty($settings['font']['t_commission'])) { ?><?php  echo $settings['font']['t_commission'];?><?php  } else { ?>三级下线<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">虚拟商品订单<br/>要求客户商户输入微信号文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[dummy_order]" class="form-control"  value="<?php  if(!empty($settings['font']['dummy_order'])) { ?><?php  echo $settings['font']['dummy_order'];?><?php  } else { ?>该商品为虚拟商品，为了方便管理员联系您，请务必输入您的微信号<?php  } ?>" />
					<div class="help-block">建议三十个字内</div>
	            </div>
	        </div>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">我要发货文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[app_send]" class="form-control"  value="<?php  if(!empty($settings['font']['app_send'])) { ?><?php  echo $settings['font']['app_send'];?><?php  } else { ?>我要发货<?php  } ?>" />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
	        <?php  } ?>
		</div>
	</div>
</div>
<div class="panel panel-info settings">
	<div class="panel panel-info">
		<div class='panel-heading' style="color:red;">储值设置（建议总数不超过6个，充值金额不能小于0，必须小于20000）</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">首充双倍</label>
				<div class="col-sm-9">
					<label><input type="radio" name="isdouble" <?php  if(empty($settings['isdouble'])) { ?>checked="checked"<?php  } ?> value="0"> 关闭</label>
					<label style="margin-left: 10px;"><input type="radio" name="isdouble" <?php  if($settings['isdouble']) { ?>checked="checked"<?php  } ?> value="1"> 开启</label>
					<div class="help-block">首充双倍是以金额为准的</div>
					<div class="help-block">仅仅当用户充值金额在下列设置的金额中才有效，否则无效</div>
					<div class="help-block">例如：开启首充双倍。用户第一次充值1元，实际到账2元，用户第一次充值3元，实际到账6元</div>
				</div>
			</div>
			<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">首充双倍提示语</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[double_tip]" class="form-control"  value="<?php  echo $settings['font']['double_tip'];?>" />
					<div class="help-block">建议十六个字内</div>
	            </div>
	        </div>
            <div class="form-group">
				<div class="col-sm-12">
					<table class="table">
						<thead>
						<th style="width:60px;"></th>
						<th  style="width:150px;">金额</th>
						<th>操作</th>
						</thead>
						<tbody id="tbody">
							<?php  if(is_array($settings['recharge'])) { foreach($settings['recharge'] as $c) { ?>
							<tr class="recharge-item">
								<td><a href="javascript:;" class="btn btn-default btn-sm btn-move"><i class="fa fa-arrows"></i></a></td>
								<td><input type="text" class="form-control" name="money[]" value="<?php  echo $c['money'];?>" /></td>
								<td><button type="button" class="btn btn-danger  btn-sm" onclick="removeRecharge(this)"><i class="fa fa-remove"></i></button>
							</tr>
							<?php  } } ?>
						</tbody>
						<tbody>
							<tr>
								<td colspan="4"><button type="button" class="btn btn-default  btn-sm" onclick="addRecharge()"><i class="fa fa-plus"></i> 添加金额</button></td>
							</tr>
					</table>
				</div>
			</div>
        </div>
	</div>
</div>
<script>
function removeRecharge(obj){
	$(obj).closest('.recharge-item').remove();
}
function addRecharge(){
	var html='<tr class="recharge-item">';
	html+='<td><a href="javascript:;" class="btn btn-default btn-sm btn-move"><i class="fa fa-arrows"></i></a></td>';
	html+='<td><input type="text" class="form-control" name="money[]" /></td>';
	html+='<td><button type="button" class="btn btn-danger  btn-sm" onclick="removeRecharge(this)"><i class="fa fa-remove"></i></button>';
	html+='</td>';
	html+='</tr>';
	$('#tbody').append(html);
	bindEvents();
}
function bindEvents() {
	require(['jquery', 'util'], function ($, util) {
		$('.btn-select-pic').unbind('click').click(function () {
			var imgitem = $(this).closest('.img-item');
			util.image('', function (data) {
				imgitem.find('img').attr('src', data['url']);
				imgitem.find('input').val(data['attachment']);
			});
		});
	});
	require(['jquery.ui'] ,function(){
		$("#tbody").sortable({handle: '.btn-move'});
    });
}
$(function(){
	bindEvents();
});
</script>
<div class="settings">
	<div class="panel panel-default">
		<div class="panel-heading">说明设置</div>
		<div class="panel-body">
	        <?php  if($_W['account']['level']==4) { ?>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">规则说明</label>
	            <div class="col-sm-9 col-xs-12">
	                <textarea name='agreement1' rows="20" class="form-control" ><?php  echo $settings['agreement1'];?></textarea>
	            </div>
	        </div>
	        <?php  } else { ?>
	        <div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">规则说明</label>
	            <div class="col-sm-9 col-xs-12">
	                <?php  echo tpl_ueditor('agreement',$settings['agreement'], array('height'=>360));?>
	            </div>
	        </div>
	        <?php  } ?>
		</div>
	</div>
</div>
<div class="settings">
	<div class="panel panel-default">
		<?php  if($_W['account']['level']!=4) { ?>
		<div class="panel-heading">支付参数</div>
		<div class="panel-body">
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">小程序支付商户号</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="mchid" class="form-control"  value="<?php  echo $settings['mchid'];?>"  />
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">小程序支付秘钥</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="APPKEY" class="form-control"  value="<?php  echo $settings['APPKEY'];?>"  />
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务器IP</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="ip" class="form-control"  value="<?php  if($settings['ip']) { ?><?php  echo $settings['ip'];?><?php  } else { ?><?php  echo $_W['clientip'];?><?php  } ?>"  />
	            </div>
	        </div>
	 		<div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">appId</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="appid" class="form-control"  value="<?php  echo $settings['appid'];?>"  />
	            </div>
			</div>
			<div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">商户支付证书</label>
	            <div class="col-sm-9 col-xs-12">
	                <textarea class="form-control" name="cert" rows="8" placeholder="为保证安全性, 不显示证书内容. 若要修改, 请直接输入"></textarea>
	                <span class="help-block">从商户平台上下载支付证书, 解压并取得其中的 <mark>apiclient_cert.pem</mark> 用记事本打开并复制文件内容, 填至此处</span>
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付证书私钥</label>
	            <div class="col-sm-9 col-xs-12">
	                <textarea class="form-control" name="key" rows="8" placeholder="为保证安全性, 不显示证书内容. 若要修改, 请直接输入"></textarea>
	                <span class="help-block">从商户平台上下载支付证书, 解压并取得其中的 <mark>apiclient_key.pem</mark> 用记事本打开并复制文件内容, 填至此处</span>
	            </div>
	        </div>
		</div>
		<?php  } ?>
		<?php  if($_W['account']['level']==4) { ?>
		<div class="panel-heading">码支付参数(第三方支付请自行官网申请对接，只要复制对应参数填这里就行了)</div>
		<div class="panel-body">
	        <div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">码支付官网</label>
				<div class="col-sm-9">
					<div class="help-block">https://codepay.fateqq.com</div>
				</div>
			</div>
	        <div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">码支付</label>
				<div class="col-sm-9">
					<label><input type="radio" name="codepay[status]" <?php  if(empty($settings['codepay']['status'])) { ?>checked="checked"<?php  } ?> value="0"> 关闭</label>
					<label style="margin-left: 10px;"><input type="radio" name="codepay[status]" <?php  if($settings['codepay']['status']) { ?>checked="checked"<?php  } ?> value="1"> 开启</label>
					<div class="help-block">开启了则优先使用码支付</div>
				</div>
			</div>
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">码支付ID</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="codepay[id]" class="form-control"  value="<?php  echo $settings['codepay']['id'];?>"  />
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">码支付通讯密钥</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="codepay[key]" class="form-control"  value="<?php  echo $settings['codepay']['key'];?>"  />
	            </div>
	        </div>
	    </div>
	    <?php  if(isSelfHost(3)) { ?>
	    <div class="panel-heading">竣付通参数(第三方支付请自行官网申请对接，只要复制对应参数填这里就行了)</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">竣付通官网</label>
				<div class="col-sm-9">
					<div class="help-block">http://www.jtpay.com/</div>
				</div>
			</div>
	        <div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">竣付通支付</label>
				<div class="col-sm-9">
					<label><input type="radio" name="rainpay[status]" <?php  if(empty($settings['rainpay']['status'])) { ?>checked="checked"<?php  } ?> value="0"> 关闭</label>
					<label style="margin-left: 10px;"><input type="radio" name="rainpay[status]" <?php  if($settings['rainpay']['status']) { ?>checked="checked"<?php  } ?> value="1"> 开启</label>
				</div>
			</div>
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">应用ID</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="rainpay[id]" class="form-control"  value="<?php  echo $settings['rainpay']['id'];?>"  />
	            </div>
	        </div>
	         <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">收款账号</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="rainpay[account]" class="form-control"  value="<?php  echo $settings['rainpay']['account'];?>"  />
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">密钥</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="rainpay[key]" class="form-control"  value="<?php  echo $settings['rainpay']['key'];?>"  />
	            </div>
	        </div>
	    </div>
	    <?php  } ?>
	    <?php  if(isSelfHost(2)) { ?>
		<div class="panel-heading">融易付参数</div>
		<div class="panel-body">
	        <div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">融易付</label>
				<div class="col-sm-9">
					<label><input type="radio" name="eespay[status]" <?php  if(empty($settings['eespay']['status'])) { ?>checked="checked"<?php  } ?> value="0"> 关闭</label>
					<label style="margin-left: 10px;"><input type="radio" name="eespay[status]" <?php  if($settings['eespay']['status']) { ?>checked="checked"<?php  } ?> value="1"> 开启</label>
					<div class="help-block">未开启码支付，开启了融易付则优先使用融易付</div>
				</div>
			</div>
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付ID</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="eespay[id]" class="form-control"  value="<?php  echo $settings['eespay']['id'];?>"  />
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付通讯密钥</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="eespay[key]" class="form-control"  value="<?php  echo $settings['eespay']['key'];?>"  />
	            </div>
	        </div>
	    </div>
	    <?php  } ?>
		<div class="panel-heading">支付参数</div>
		<div class="panel-body">
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付商户号</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="mchid1" class="form-control"  value="<?php  echo $settings['mchid1'];?>"  />
	                  <div class="help-block">请确保输入内容不带空格！！仔细检查</div>
	                  <div class="help-block">记得在 微信支付后台->产品中心->开发配置 设置支付授权目录;内容为： 域名/app/</div>
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付秘钥</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="APPKEY1" class="form-control"  value="<?php  echo $settings['APPKEY1'];?>"  />
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务器IP</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="ip1" class="form-control"  value="<?php  if($settings['ip1']) { ?><?php  echo $settings['ip1'];?><?php  } else { ?><?php  echo $_W['clientip'];?><?php  } ?>"  />
	            </div>
	        </div>
	 		<div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">公众号appid</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="appid1" class="form-control" value="<?php  echo $settings['appid1'];?>"  />
	            </div>
			</div>
			<div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">商户支付证书</label>
	            <div class="col-sm-9 col-xs-12">
	                <textarea class="form-control" name="cert1" rows="8" placeholder="为保证安全性, 不显示证书内容. 若要修改, 请直接输入"></textarea>
	                <span class="help-block">从商户平台上下载支付证书, 解压并取得其中的 <mark>apiclient_cert.pem</mark> 用记事本打开并复制文件内容, 填至此处</span>
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付证书私钥</label>
	            <div class="col-sm-9 col-xs-12">
	                <textarea class="form-control" name="key1" rows="8" placeholder="为保证安全性, 不显示证书内容. 若要修改, 请直接输入"></textarea>
	                <span class="help-block">从商户平台上下载支付证书, 解压并取得其中的 <mark>apiclient_key.pem</mark> 用记事本打开并复制文件内容, 填至此处</span>
	            </div>
	        </div>
		</div>
		<?php  } ?>
	</div>          	
</div>
<div class="settings">
	<div class="panel panel-default">
		<div class="panel-heading">限制设置</div>
		<div class="panel-body">
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">难度设置</label>
	            <div class="col-sm-9 col-xs-12">
	            	<div class="input-group">
	            		<span class="input-group-addon">当用户中了</span>
						<input class="form-control" name="limit[hard]" type="number" value="<?php  echo $settings['limit']['hard'];?>">
						<span class="input-group-addon">次奖后，自动把第三关难度全部升级为变态难</span>
					</div>
					<div class='help-block'>不填或者0，代表关闭该功能</div>
	            </div>
	        </div>
	        
	        <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">不可玩设置</label>
	            <div class="col-sm-9 col-xs-12">
	            	<div class="input-group">
	            		<span class="input-group-addon">当用户中了</span>
						<input class="form-control" name="limit[forbid]" type="number" value="<?php  echo $settings['limit']['forbid'];?>">
						<span class="input-group-addon">次奖后，禁止用户继续玩游戏</span>
						<span class="input-group-addon">提示语：</span>
						<input class="form-control" name="limit[ftips]" placeholder="例如：留点机会给别人吧，还有余额，请联系客服退款" value="<?php  echo $settings['limit']['ftips'];?>">
					</div>
					<div class='help-block'>不填或者0，代表关闭该功能</div>
	            </div>
	        </div>
		</div>
	</div>
</div>
<div class="settings">
	<div class="panel panel-info">
		<div class='panel-heading'> 首页公告设置 <small>  拖动改变位置，若跳转小程序，请输入appid。若跳转小程序，填小程序页面路径；若跳转网页，请填https链接。</small></div>
		<div class="panel-body">
            <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">公告提示语</label>
	            <div class="col-sm-9 col-xs-12">
	                  <input type="text" name="nTip" class="form-control"  value="<?php  if(!empty($settings['nTip'])) { ?><?php  echo $settings['nTip'];?><?php  } else { ?>#nickname#连闯三关，赢得#gname#<?php  } ?>"  />
	            		<div class='help-block'>#nickname#为会员昵称占位符，#gname#为奖品名称占位符</div>
	            		<div class='help-block'>例如：#nickname#连闯三关，赢得#gname#</div>
	            </div>
	        </div>
            <div class="form-group">
				<div class="col-sm-12">
					<table class="table">
						<thead>
						<th style="width:60px;"></th>
						<th  style="width:400px;">内容</th>
						<th  style="width:200px;">链接</th>
						<th>操作</th>
						</thead>
						<tbody id="notice_tbody">
							<?php  if(is_array($settings['notice'])) { foreach($settings['notice'] as $notice) { ?>
							<tr class="notice-item">
								<td><a href="javascript:;" class="btn btn-default btn-sm btn-move"><i class="fa fa-arrows"></i></a></td>
								<td><input type="text" class="form-control" name="notice_txt[]" value="<?php  echo $notice['txt'];?>"/></td>
								<td><input type="text" class="form-control" name="notice_url[]" value="<?php  echo $notice['url'];?>"/></td>
								<td><button type="button" class="btn btn-danger  btn-sm" onclick="removeNotice(this)"><i class="fa fa-remove"></i></button>
								</td>
							</tr>
							<?php  } } ?>
						</tbody>
						<tbody>
							<tr>
								<td colspan="4"><button type="button" class="btn btn-default  btn-sm" onclick="addNotice()"><i class="fa fa-plus"></i> 添加公告</button></td>
							</tr>
					</table>
				</div>
			</div>
        </div>
	</div>
<script text="text/javascript">
$(function () {
	bindEvents();
});
function bindEvents() {
	require(['jquery.ui'] ,function(){
		$("#notice_tbody").sortable({handle: '.btn-move'});
    });
}
//添加公告
function addNotice(){
	var html='<tr class="notice-item">';
	html+='<td><a href="javascript:;" class="btn btn-default btn-sm btn-move"><i class="fa fa-arrows"></i></a></td>';
	html+='<td><input type="text" class="form-control" name="notice_txt[]" /></td>';
	html+='<td><input type="text" class="form-control" name="notice_url[]" /></td>';
	html+='<td><button type="button" class="btn btn-danger  btn-sm" onclick="removeNotice(this)"><i class="fa fa-remove"></i></button>';
	
	html+='</td>';
	html+='</tr>';
	$('#notice_tbody').append(html);
	bindEvents();
}
function removeNotice(obj){
	$(obj).closest('.notice-item').remove();
}
</script>
</div>
<?php  if(isSelfHost(4)) { ?>
<div class="settings">
	<div class="panel panel-default">
		<div class="panel-heading">邀请设置</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">邀请机制</label>
				<div class="col-sm-9">
					<label><input type="radio" name="invite[status]" <?php  if(empty($settings['invite']['status'])) { ?>checked="checked"<?php  } ?> value="0"> 关闭</label>
					<label style="margin-left: 10px;"><input type="radio" name="invite[status]" <?php  if($settings['invite']['status']==1) { ?>checked="checked"<?php  } ?> value="1"> 开启</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">邀请赠送</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">每邀请</span>
					<input class="form-control" name="invite[mem]" type="number" value="<?php  echo $settings['invite']['mem'];?>">
					<span class="input-group-addon">人 赠送</span>
					<input class="form-control" name="invite[num]" type="number" value="<?php  echo $settings['invite']['num'];?>">
					<span class="input-group-addon">余额 每天限</span>
					<input class="form-control" name="invite[limit]" type="number" value="<?php  echo $settings['invite']['limit'];?>">
					<span class="input-group-addon">次</span>
					</div>
					<div class='help-block'>邀请人数不填或0，则表示每邀请1人就赠送设置的次数</div>
					<div class='help-block'>赠送余额不填或0，则表示不赠送</div>
					<div class='help-block'>每天限制次数不填或0，则表示不限制</div>
				</div>
			</div>	
			<div class="form-group" style="display:none;">
			    <label class="col-xs-12 col-sm-3 col-md-2 control-label">赠送商品</label>
			    <div class="col-sm-9 col-xs-12">
	                <input type='hidden' id='inviteGid' name='invite[gid]' value="<?php  echo $settings['invite']['gid'];?>" />
	                <div class='input-group'>
	                
	                    <input type="text" name="ititle" id="ititle" value="<?php  if(!empty($settings['invite']['gid'])) { ?><?php  echo $good['title'];?>-<?php  echo $good['sub_title'];?><?php  } ?>" class="form-control" readonly />
	                    <div class='input-group-btn'>
	                        <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus2').modal();">选择商品</button>
	                        <button class="btn btn-danger" type="button" onclick="$('#inviteGid').val('');$('#ititle').val('');">清除选择</button>
	                    </div>
	                </div>
	                <div id="modal-module-menus2"  class="modal fade" tabindex="-1">
	                    <div class="modal-dialog" style='width: 920px;'>
	                        <div class="modal-content">
	                            <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close2" type="button">×</button><h3>选择商品</h3></div>
	                            <div class="modal-body" >
	                                <div class="row">
	                                    <div class="input-group">
	                                        <input type="text" class="form-control" value="" id="search-kwd2" placeholder="请输入商品名称" />
	                                        <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_goods();">搜索</button></span>
	                                    </div>
	                                </div> 
	                                <div id="module-menus2" style="padding-top:5px;"></div>
	                            </div>
	                            <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
	                        </div>
	
	                    </div>
	                </div>
	                <div class='help-block'>若不选择赠送商品，则表示邀请设置无效</div>
	            </div>
			</div>
			
		</div>
	</div>
<script>
function search_goods() {
	$("#module-menus2").html("正在搜索....")
	$.get('<?php  echo $this->createWebUrl('good',array('op'=>'query'));?>', {
		keywords: $.trim($('#search-kwd2').val())
	}, function(dat){
		$('#module-menus2').html(dat);
	});
}
function select_good(o) {
	$("#inviteGid").val(o.id);
	$("#ititle").val( o.title+'-'+o.sub_title);
	$(".close2").click();
}
</script>	
</div>
<?php  } ?>
<div class="settings">
	<div class="panel panel-default">
		<div class="panel-heading">等级设置</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">注意</label>
				<div class="col-sm-9">
					<div class="help-block">每个等级可以独立设置分销佣金比例</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">等级机制</label>
				<div class="col-sm-9">
					<label><input type="radio" name="islevel" <?php  if(empty($settings['islevel'])) { ?>checked="checked"<?php  } ?> value="0"> 关闭</label>
					<label style="margin-left: 10px;"><input type="radio" name="islevel" <?php  if($settings['islevel']==1) { ?>checked="checked"<?php  } ?> value="1"> 开启</label>
				</div>
			</div>
			<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">普通会员文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[level]" class="form-control"  value="<?php  if(!empty($settings['font']['level'])) { ?><?php  echo $settings['font']['level'];?><?php  } else { ?>普通会员<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">升级等级文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[uplevel]" class="form-control"  value="<?php  if(!empty($settings['font']['uplevel'])) { ?><?php  echo $settings['font']['uplevel'];?><?php  } else { ?>升级<?php  } ?>"  />
					<div class="help-block">建议二个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">升级说明文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[updes]" class="form-control"  value="<?php  if(!empty($settings['font']['updes'])) { ?><?php  echo $settings['font']['updes'];?><?php  } else { ?>升级说明<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
          	<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">我要升级文字</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="font[myup]" class="form-control"  value="<?php  if(!empty($settings['font']['myup'])) { ?><?php  echo $settings['font']['myup'];?><?php  } else { ?>我要升级<?php  } ?>"  />
					<div class="help-block">建议四个字内</div>
	            </div>
	        </div>
			<div class="form-group" >
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">等级说明</label>
	            <div class="col-sm-9 col-xs-12">
	                <textarea name='level_des' rows="20" class="form-control" ><?php  echo $settings['level_des'];?></textarea>
	            </div>
	        </div>			

		</div>
	</div>
</div>			
<div class="settings">
	<div class="panel panel-info">
		<div class='panel-heading'> 底部菜单设置（菜单数量不能超过五个） <small>  拖动改变位置</small></div>
		<div class="panel-body">
            <div class="form-group">
				<div class="col-sm-12">
					<table class="table">
						<thead>
						<th style="width:60px;"></th>
						<th  style="width:400px;">图标</th>
						<th  style="width:400px;">文字</th>
						<th  style="width:300px;">链接</th>
						<th>操作</th>
						</thead>
						<tbody id="footer_tbody">
							<?php  if(is_array($settings['footer'])) { foreach($settings['footer'] as $d) { ?>
							<tr class="footer-item">
								<td><a href="javascript:;" class="btn btn-default btn-sm btn-move"><i class="fa fa-arrows"></i></a></td>
								<td>
								<div class="input-group img-item">
									<div class="input-group-addon">
										<img src="<?php  echo tomedia($d['img'])?>" style="height:20px;width:50px" />
									</div>
									<input type="text" class="form-control" name="footer_img[]" value="<?php  echo $d['img'];?>" />
									<div class="input-group-btn">
										<button type="button" class="btn btn-default btn-select-pic">选择图片</button>
									</div>
								</div>
							</td>
								<td><input type="text" class="form-control" name="footer_title[]" value="<?php  echo $d['title'];?>"/></td>
								<td><input type="text" class="form-control" name="footer_url[]" value="<?php  echo $d['url'];?>"/></td>
								<td><button type="button" class="btn btn-danger  btn-sm" onclick="removeFooter(this)"><i class="fa fa-remove"></i></button>

								</td>
							</tr>
							<?php  } } ?>
						</tbody>
						<tbody>
							<tr>
								<td colspan="4"><button type="button" class="btn btn-default  btn-sm" onclick="addFooter()"><i class="fa fa-plus"></i> 添加菜单</button></td>
							</tr>
					</table>
				</div>
			</div>
        </div>
	</div>
<script>
$(function () {
	bindEvents();
});
function bindEvents() {
	require(['jquery', 'util'], function ($, util) {
		$('.btn-select-pic').unbind('click').click(function () {
			var imgitem = $(this).closest('.img-item');
			util.image('', function (data) {
				imgitem.find('img').attr('src', data['url']);
				imgitem.find('input').val(data['attachment']);
			});
		});
	});
	require(['jquery.ui'] ,function(){
		$("#footer_tbody").sortable({handle: '.btn-move'});
    });
}
function addFooter(){
	var html='<tr class="footer-item">';
	html+='<td><a href="javascript:;" class="btn btn-default btn-sm btn-move"><i class="fa fa-arrows"></i></a></td>';
	html+='<td>';
	html+='<div class="input-group img-item">';
	html+='<div class="input-group-addon">';
	html+='<img src="" style="height:20px;width:50px" />';
	html+='</div>';
	html+='<input type="text" class="form-control" name="footer_img[]" />';
	html+='<div class="input-group-btn">';
	html+='<button type="button" class="btn btn-default btn-select-pic">选择图片</button>';
	html+='</div>';
	html+='</div>';
	html+='</td>';
	html+='<td><input type="text" class="form-control" name="footer_title[]" /></td>';
	html+='<td><input type="text" class="form-control" name="footer_url[]" /></td>';
	html+='<td><button type="button" class="btn btn-danger  btn-sm" onclick="removeFooter(this)"><i class="fa fa-remove"></i></button>';
	
	html+='</td>';
	html+='</tr>';
	$('#footer_tbody').append(html);
	bindEvents();
}
function removeFooter(obj){
	$(obj).closest('.footer-item').remove();
}
</script>	
</div>			
<button class="btn btn-primary" type="submit" name="submit" value="提交">提交</button>
<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
</form>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
