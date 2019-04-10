<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('good',array('op'=>'post'))?>">添加商品</a></li>
	<li <?php  if(empty($op) || $op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('good')?>">商品列表</a></li>
</ul>
<?php  if($op == 'display') { ?>
<style>
th{
	text-align: center !important;
}
td{
	text-align: center !important;
	white-space: normal !important;
	word-break: break-all !important;
}
</style>
<form action="" method="get" class="form-horizontal" role="form">
<div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="junsion_winaward" />
                <input type="hidden" name="do" value="good" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <input class="form-control" name="keyword" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入商品名称">
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">状态</label>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <select name="status" class="form-control">
                        	<option value="">全部</option>
                        	<option value="0" <?php  if(empty($_GPC['status']) && $_GPC['status']!='') { ?>selected<?php  } ?>>隐藏</option>
                        	<option value="1" <?php  if($_GPC['status']==1) { ?>selected<?php  } ?>>显示</option>
                        </select>
                    </div>
                	<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                    <div class=" col-xs-12 col-sm-2 col-lg-2">
                        <button class="btn btn-default" ><i class="fa fa-search"></i> 搜索</button>
                   	</div>
                </div>
        </div>
    </div>
</form>
<div class="panel panel-default">
    <div class="table-responsive panel-body">
        <table class="table table-hover">
            <thead class="navbar-inner">
            <tr>
            	<th>排序</th>
            	<th>logo</th>
            	<th>商品名称<br/>商品别名</th>
            	<th>闯关价格<br/>商品原价<br/>购买价格</th>
            	<th>邮费</th>
                <th>商品类型</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody id="level-list">
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
            <tr>
            	<td><?php  echo $item['sort'];?></td>
            	<td><img src="<?php  echo toimage($item['logo'])?>" style="width:60px;height:60px;"></td>
            	<td><?php  echo $item['title'];?><br/><?php  echo $item['sub_title'];?></td>
            	<td><?php  echo $item['price'];?><br/><?php  echo $item['costprice'];?><br/><?php  echo $item['buy'];?></td>
            	<td><?php  echo $item['postage'];?></td>
                <td><?php  if($item['type']) { ?><span class="label label-primary">虚拟</span><?php  } else { ?><span class="label label-info">实体</span><?php  } ?></td>
                <td data-id='<?php  echo $item["id"];?>'><?php  if($item['status']) { ?><label class="label label-success">显示</label><?php  } else { ?><label class="label label-default">隐藏</label><?php  } ?></td>
               <td>
                   <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('good', array('op' => 'post', 'id' => $item['id']))?>">编辑</a>
                   <a class="btn btn-danger btn-sm" onclick="return confirm('确认删除吗？');return false;" href="<?php  echo $this->createWebUrl('good', array('op' => 'del', 'id' => $item['id']))?>">删除</a>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
<script>
$('table label').click(function(){
	var label = $(this);
	$.ajax({
		url:"<?php  echo $this->createWebUrl('good',array('op'=>'status'))?>",
		type:'post',
		data:{id:label.parent().attr('data-id')},
		success:function(status){
			if(status == '1'){
				if(label.hasClass('label-success')){
					label.removeClass('label-success').addClass('label-default');
					label.text('隐藏');
				}else{
					label.removeClass('label-default').addClass('label-success');
					label.text('显示');
				}
			}
		}
	});
});
</script>    
</div>

<?php  } else if($op == 'post') { ?>
<style>
.settings{
	display: none;
}
.help-block{
	color: red !important;
}
</style>
<ul class="nav nav-tabs" id="snav">
	<li class="active"><a>基础设置</a></li>
	<li><a>闯关设置</a></li>
</ul>
<script>
$('#snav li').click(function(){
	$('#snav li').removeClass('active');
	$(this).addClass('active');
	$('.settings').hide();
	$('.settings').eq($(this).index()).show();
});
</script>
<form action="" method="post" class="form-horizontal" role="form">
<input type="hidden" name="id" value="<?php  echo $item['id'];?>">
<div class="panel panel-info settings" style="display:block;">
		<div class="panel-body">
			<?php  load()->func('tpl')?>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
				<div class="col-sm-9">
					<input class="form-control" name="sort" id='sort' type="number" value="<?php  echo $item['sort'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red;">*</span>商品名称</label>
				<div class="col-sm-9">
					<input class="form-control" required="required" name="title" id='title' type="text" value="<?php  echo $item['title'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">商品别名</label>
				<div class="col-sm-9">
					<input class="form-control" name="sub_title" id='sub_title' type="text" value="<?php  echo $item['sub_title'];?>">
					<div class='help-block'>建议输入两个字以内，例如：正品</div>
				</div>
			</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">商品logo图</label>
            	<div class="col-sm-9">
                	<?php  echo tpl_form_field_image('logo',$item['logo'])?>
                	<div class='help-block'>200*200</div>
            	</div>
          	</div>
          	<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">商品类型</label>
				<div class="col-sm-9">
					<label><input type="radio" name="type" <?php  if(empty($item['type'])) { ?>checked="checked"<?php  } ?> value="0"> 实体商品</label>
					<label style="margin-left: 10px;"><input type="radio" name="type" <?php  if($item['type']) { ?>checked="checked"<?php  } ?> value="1"> 虚拟商品</label>
				</div>
			</div>
          	<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">商品标签</label>
				<div class="col-sm-9">
					<input class="form-control" name="label" id='label' type="text" value="<?php  echo $item['label'];?>">
				</div>
			</div>
          	<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">闯关价格</label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control" name="price" id='price' type="text" value="<?php  echo $item['price'];?>">
						<span class="input-group-addon">元</span>
					</div>
				</div>
			</div>
          	<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">直接购买价格</label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control" name="buy" id='buy' type="text" value="<?php  echo $item['buy'];?>">
						<span class="input-group-addon">元</span>
					</div>
				</div>
			</div>
          	<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">邮费</label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control" name="postage" id='postage' type="text" value="<?php  echo $item['postage'];?>">
						<span class="input-group-addon">元</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">商品原价</label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control" name="costprice" id='costprice' type="text" value="<?php  echo $item['costprice'];?>">
						<span class="input-group-addon">元</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
				<div class="col-sm-9">
					<label><input type="radio" name="status" <?php  if(empty($item['status'])) { ?>checked="checked"<?php  } ?> value="0"> 隐藏</label>
					<label style="margin-left: 10px;"><input type="radio" name="status" <?php  if($item['status']) { ?>checked="checked"<?php  } ?> value="1"> 显示</label>
				</div>
			</div>
	</div>
</div>
<div class="settings">
	<div class="panel panel-info">
		<div class="panel-body">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">注意</label>
				<div class="col-sm-9">
					<div class="help-block">旋转速度请输入0.01~0.1之间的小数，例如0.01，值越大，旋转速度越大</div>
					<div class="help-block">口红数必须大于0，建议输入小于或等于13的整数。例如6</div>
					<div class="help-block">闯关时间必须大于0，例如30</div>
					<div class="help-block">请依次设置游戏关卡</div>
				</div>
			</div>
			<div class="form-group">
	           	<label class="col-xs-12 col-sm-3 col-md-2 control-label">第一关设置</label>
	           	<div class="col-sm-9">
	               	<div class="input-group">
		           		<span class="input-group-addon">口红数</span>
		               	<input class='form-control' name='game[0][num]' type="number" value='<?php  if(!empty($game["0"]["num"])) { ?><?php  echo $game["0"]["num"];?><?php  } else { ?>6<?php  } ?>'>
		           		<span class="input-group-addon">条 难度</span>
		           		<select class='form-control' name='game[0][hard]'>
		           			<option value='1' <?php  if($game[0]['hard']==1 || empty($game[0]['hard'])) { ?>selected<?php  } ?>>简单</option>
		           			<option value='2' <?php  if($game[0]['hard']==2) { ?>selected<?php  } ?>>一般</option>
		           			<option value='3' <?php  if($game[0]['hard']==3) { ?>selected<?php  } ?>>较难</option>
		           			<option value='4' <?php  if($game[0]['hard']==4) { ?>selected<?php  } ?>>困难</option>
		           			<option value='5' <?php  if($game[0]['hard']==5) { ?>selected<?php  } ?>>变态难</option>
		           		</select>
		           		<span class="input-group-addon">闯关时间</span>
		               	<input class='form-control' name='game[0][time]' type="number" value='<?php  if(!empty($game["0"]["time"])) { ?><?php  echo $game["0"]["time"];?><?php  } else { ?>30<?php  } ?>'>
		           		<span class="input-group-addon">秒</span>
					</div>
	           	</div>
	    	</div>
			<div class="form-group">
	           	<label class="col-xs-12 col-sm-3 col-md-2 control-label">第二关设置</label>
	           	<div class="col-sm-9">
	               	<div class="input-group">
		           		<span class="input-group-addon">口红数</span>
		               	<input class='form-control' name='game[1][num]' type="number" value='<?php  if(!empty($game["1"]["num"])) { ?><?php  echo $game["1"]["num"];?><?php  } else { ?>10<?php  } ?>'>
		           		<span class="input-group-addon">条 难度</span>
		               	<select class='form-control' name='game[1][hard]'>
		           			<option value='1' <?php  if($game[1]['hard']==1) { ?>selected<?php  } ?>>简单</option>
		           			<option value='2' <?php  if($game[1]['hard']==2 || empty($game[1]['hard'])) { ?>selected<?php  } ?>>一般</option>
		           			<option value='3' <?php  if($game[1]['hard']==3) { ?>selected<?php  } ?>>较难</option>
		           			<option value='4' <?php  if($game[1]['hard']==4) { ?>selected<?php  } ?>>困难</option>
		           			<option value='5' <?php  if($game[1]['hard']==5) { ?>selected<?php  } ?>>变态难</option>
		           		</select>
		           		<span class="input-group-addon">闯关时间</span>
		               	<input class='form-control' name='game[1][time]' type="number" value='<?php  if(!empty($game["1"]["time"])) { ?><?php  echo $game["1"]["time"];?><?php  } else { ?>40<?php  } ?>'>
		           		<span class="input-group-addon">秒</span>
					</div>
	           	</div>
	    	</div>
			<div class="form-group">
	           	<label class="col-xs-12 col-sm-3 col-md-2 control-label">第三关设置</label>
	           	<div class="col-sm-9">
	               	<div class="input-group">
		           		<span class="input-group-addon">口红数</span>
		               	<input class='form-control' name='game[2][num]' type="number" value='<?php  if(!empty($game["2"]["num"])) { ?><?php  echo $game["2"]["num"];?><?php  } else { ?>13<?php  } ?>'>
		           		<span class="input-group-addon">条 难度</span>
		               	<select class='form-control' name='game[2][hard]'>
		           			<option value='1' <?php  if($game[2]['hard']==1) { ?>selected<?php  } ?>>简单</option>
		           			<option value='2' <?php  if($game[2]['hard']==2) { ?>selected<?php  } ?>>一般</option>
		           			<option value='3' <?php  if($game[2]['hard']==3 || empty($game[2]['hard'])) { ?>selected<?php  } ?>>较难</option>
		           			<option value='4' <?php  if($game[2]['hard']==4) { ?>selected<?php  } ?>>困难</option>
		           			<option value='5' <?php  if($game[2]['hard']==5) { ?>selected<?php  } ?>>变态难</option>
		           		</select>
		           		<span class="input-group-addon">闯关时间</span>
		               	<input class='form-control' name='game[2][time]' type="number" value='<?php  if(!empty($game["2"]["time"])) { ?><?php  echo $game["2"]["time"];?><?php  } else { ?>60<?php  } ?>'>
		           		<span class="input-group-addon">秒</span>
					</div>
	           	</div>
	    	</div>
		</div>
	</div>
</div>
<button type="submit" class="btn btn-primary" name="submit" id='summit_info' value="提交">保存</button>
<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
</form>
<script>
$(function(){
	$("#summit_info").click(function(){
		var title = $("#title").val();
		if(!title){
			alert("请输入商品名称");
			return false;
		}
	});
});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>