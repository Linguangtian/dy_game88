<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('level',array('op'=>'post'))?>">添加等级</a></li>
	<li <?php  if(empty($op) || $op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('level')?>">等级列表</a></li>
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
                <input type="hidden" name="do" value="level" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <input class="form-control" name="keyword" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入等级名称">
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
            	<th>等级名称</th>
            	<th>logo</th>
            	<th>级别</th>
            	<th>价格</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody id="level-list">
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
            <tr>
            	<td><?php  echo $item['title'];?></td>
            	<td><img src="<?php  echo toimage($item['logo'])?>" style="width:60px;height:60px;"></td>
            	<td>级别<?php  echo $item['level']+1?></td>
            	<td><?php  echo $item['price'];?></td>
               <td>
                   <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('level', array('op' => 'post', 'id' => $item['id']))?>">编辑</a>
                   <a class="btn btn-danger btn-sm" onclick="return confirm('确认删除吗？');return false;" href="<?php  echo $this->createWebUrl('level', array('op' => 'del', 'id' => $item['id']))?>">删除</a>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
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
	<li><a>分销佣金设置</a></li>
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
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red;">*</span>等级名称</label>
				<div class="col-sm-9">
					<input class="form-control" required="required" name="title" id='title' type="text" value="<?php  echo $item['title'];?>">
					<div class='help-block'>建议五个字内</div>
				</div>
			</div>
			<div class="form-group">
            	<label class="col-xs-12 col-sm-3 col-md-2 control-label">等级logo图</label>
            	<div class="col-sm-9">
                	<?php  echo tpl_form_field_image('logo',$item['logo'])?>
                	<div class='help-block'>200*200</div>
            	</div>
          	</div>
          	<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">等级级别</label>
				<div class="col-sm-9">
					<select name="level" class="form-control">
                    	<option value="0" <?php  if($item['level']==0) { ?>selected<?php  } ?>>级别1</option>
                    	<option value="1" <?php  if($item['level']==1) { ?>selected<?php  } ?>>级别2</option>
                    	<option value="2" <?php  if($item['level']==2) { ?>selected<?php  } ?>>级别3</option>
                    	<option value="3" <?php  if($item['level']==3) { ?>selected<?php  } ?>>级别4</option>
                    	<option value="4" <?php  if($item['level']==4) { ?>selected<?php  } ?>>级别5</option>
                    	<option value="5" <?php  if($item['level']==5) { ?>selected<?php  } ?>>级别6</option>
                    	<option value="6" <?php  if($item['level']==6) { ?>selected<?php  } ?>>级别7</option>
                    	<option value="7" <?php  if($item['level']==7) { ?>selected<?php  } ?>>级别8</option>
                    </select>
				</div>
			</div>
          	<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">价格</label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control" name="price" id='price' type="text" value="<?php  echo $item['price'];?>">
						<span class="input-group-addon">元</span>
					</div>
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
					<div class="help-block" style="color:red;">此处的佣金指的是分销佣金</div>
					<div class="help-block" style="color:red;">成为会员获得的佣金和红包比例在此处独立设置</div>
					<div class="help-block" style="color:red;">若不设置，则应用参数设置中的分销佣金比例</div>
					<div class="help-block" style="color:red;">若参数设置中只开启一级分销，此处设置了二级或三级佣金比例，则表示该等级的会员，可以拿到二级或三级的分销佣金</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">一级余额分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">前</span>
					<input class="form-control" name="commission[num]" type="number" value="<?php  echo $commission['num'];?>">
					<span class="input-group-addon">次 佣金</span>
					<input class="form-control" name="commission[rate]" type="number" value="<?php  echo $commission['rate'];?>">
					<span class="input-group-addon">%</span>
					<input class="form-control" name="commission[money]" type="number" value="<?php  echo $commission['money'];?>">
					<span class="input-group-addon">余额</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">一级红包分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">前</span>
					<input class="form-control" name="commission[redNum]" type="number" value="<?php  echo $commission['redNum'];?>">
					<span class="input-group-addon">次 佣金</span>
					<input class="form-control" name="commission[redRate]" type="number" value="<?php  echo $commission['redRate'];?>">
					<span class="input-group-addon">%</span>
					<input class="form-control" name="commission[redMoney]" type="number" value="<?php  echo $commission['redMoney'];?>">
					<span class="input-group-addon">红包</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">二级余额分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">前</span>
					<input class="form-control" name="commission[num2]" type="number" value="<?php  echo $commission['num2'];?>">
					<span class="input-group-addon">次 佣金</span>
					<input class="form-control" name="commission[rate2]" type="number" value="<?php  echo $commission['rate2'];?>">
					<span class="input-group-addon">%</span>
					<input class="form-control" name="commission[money2]" type="number" value="<?php  echo $commission['money2'];?>">
					<span class="input-group-addon">余额</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">二级红包分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">前</span>
					<input class="form-control" name="commission[redNum2]" type="number" value="<?php  echo $commission['redNum2'];?>">
					<span class="input-group-addon">次 佣金</span>
					<input class="form-control" name="commission[redRate2]" type="number" value="<?php  echo $commission['redRate2'];?>">
					<span class="input-group-addon">%</span>
					<input class="form-control" name="commission[redMoney2]" type="number" value="<?php  echo $commission['redMoney2'];?>">
					<span class="input-group-addon">红包</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">三级余额分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">前</span>
					<input class="form-control" name="commission[num3]" type="number" value="<?php  echo $commission['num3'];?>">
					<span class="input-group-addon">次 佣金</span>
					<input class="form-control" name="commission[rate3]" type="number" value="<?php  echo $commission['rate3'];?>">
					<span class="input-group-addon">%</span>
					<input class="form-control" name="commission[money3]" type="number" value="<?php  echo $commission['money3'];?>">
					<span class="input-group-addon">余额</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">三级红包分佣比例</label>
				<div class="col-sm-9">
					<div class="input-group">
					<span class="input-group-addon">前</span>
					<input class="form-control" name="commission[redNum3]" type="number" value="<?php  echo $commission['redNum3'];?>">
					<span class="input-group-addon">次 佣金</span>
					<input class="form-control" name="commission[redRate3]" type="number" value="<?php  echo $commission['redRate3'];?>">
					<span class="input-group-addon">%</span>
					<input class="form-control" name="commission[redMoney3]" type="number" value="<?php  echo $commission['redMoney3'];?>">
					<span class="input-group-addon">红包</span>
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
			alert("请输入等级名称");
			return false;
		}
	});
});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>