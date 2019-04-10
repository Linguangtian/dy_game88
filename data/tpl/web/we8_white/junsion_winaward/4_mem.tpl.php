<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if(empty($op) || $op=='display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('mem')?>">会员列表</a></li>
	<?php  if($op=='credit') { ?><li class="active"><a href="<?php  echo $this->createWebUrl('mem',array('op'=>'credit','id'=>$mid))?>">储值日志</a></li><?php  } ?>
	<?php  if($op=='next') { ?><li class="active"><a href="<?php  echo $this->createWebUrl('mem',array('op'=>'next','id'=>$mid))?>">我的下线</a></li><?php  } ?>
	<?php  if($op=='red') { ?><li class="active"><a href="<?php  echo $this->createWebUrl('mem',array('op'=>'red','id'=>$mid))?>">红包日志</a></li><?php  } ?>
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
.account-stat-num > div{width:50%; float:left; font-size:16px; text-align:center;}
.account-stat-num > div span{display:block; font-size:30px; font-weight:bold;}
</style>
<div class="panel panel-default">
	<div class="panel-heading">
		订单数据统计
	</div>
		<div class="panel-body">
			<div class="account-stat-num row">
				<div>今日会员人数<span><?php  if(empty($today)) { ?>0<?php  } else { ?><?php  echo $today;?><?php  } ?></span></div>
				<div>总会员人数<span><?php  if(empty($daytotal)) { ?>0<?php  } else { ?><?php  echo $daytotal;?><?php  } ?></span></div>
			</div>
		</div>
</div>
<form action="" method="get" class="form-horizontal" role="form">
<div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="junsion_winaward" />
                <input type="hidden" name="do" value="mem" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <input class="form-control" name="keyword" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入会员昵称/id">
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">状态</label>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <select name="status" class="form-control">
                        	<option value="">全部</option>
                        	<option value="0" <?php  if(empty($_GPC['status']) && $_GPC['status']!='') { ?>selected<?php  } ?>>正常</option>
                        	<option value="1" <?php  if($_GPC['status']==1) { ?>selected<?php  } ?>>黑名单</option>
                        </select>
                    </div>
                	<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                    <div class=" col-xs-12 col-sm-3 col-lg-3">
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
            	<th>id</th>
            	<th>昵称</th>
                <th>头像</th>
                <th>余额</th>
                <th>红包<br/>总红包</th>
                <?php  if(isSelfHost(1)) { ?>
                <th>代理</th>
                <?php  } ?>
                <th>等级</th>
                <th>状态</th>
                <th>时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody id="mem-list">
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
            <tr>
            	<td><?php  echo $item['id'];?></td>
            	<td><?php  echo $item['nickname'];?></td>
                <td><img src="<?php  echo $item['avatar'];?>" style="width:60px;"></td>
                <td><?php  echo $item['credit'];?></td>
                <td><?php  echo $item['red'];?><br/><?php  echo $item['total_red'];?></td>
                <?php  if($isSelfHost) { ?>
	               	<td>
	               	<?php  if($item['isagent']) { ?><span onclick="changeAgent(this, <?php  echo $item['id'];?>);" class="label label-success">是</span>
	               	<?php  } else { ?><span onclick="changeAgent(this, <?php  echo $item['id'];?>);" class="label label-default">否</span><?php  } ?>
	               	</td>
               	<?php  } ?>
                <td><img src="<?php  echo toimage($levels[$item['lid']]['logo'])?>" style="width:60px;"><br/><?php  echo $levels[$item['lid']]['title'];?></td>
               	<td data-id='<?php  echo $item["id"];?>'><?php  if(!$item['status']) { ?><label class="label label-success">正常</label><?php  } else { ?><label class="label label-default">黑名单</label><?php  } ?></td>
               	<td><?php  echo date('Y-m-d H:i',$item['createtime']);?></td>
               <td>
                   <a class="btn btn-info btn-sm" href="<?php  echo $this->createWebUrl('mem', array('op' => 'credit', 'id' => $item['id']))?>">储值日志</a>
                   <a class="btn btn-warning btn-sm" href="<?php  echo $this->createWebUrl('mem', array('op' => 'next', 'id' => $item['id']))?>">我的下线</a>
                   <br/>
                   <a class="btn btn-success btn-sm" href="<?php  echo $this->createWebUrl('mem', array('op' => 'red', 'id' => $item['id']))?>">红包日志</a>
                   <a class="btn btn-primary btn-sm" onclick="goRecharge('<?php  echo $item['id'];?>',0)">充值余额</a>
                   <br/>
                   <?php  if(!empty($alllevels)) { ?><a class="btn btn-info btn-sm" onclick="goRecharge('<?php  echo $item['id'];?>',1)">更改会员等级</a><?php  } ?>
                   <a class="btn btn-danger btn-sm" onclick="return confirm('确认删除吗？');return false;" href="<?php  echo $this->createWebUrl('mem', array('op' => 'del', 'id' => $item['id']))?>">删除</a>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
<script>
function changeAgent(obj, mid){
	if(!confirm('确认更改会员代理身份吗？')){
		return false;
	}
	var label = $(obj);
	console.log(mid);
	$.ajax({
		url:"<?php  echo $this->createWebUrl('mem',array('op'=>'changeagent'))?>",
		type:'post',
		data:{id:mid},
		success:function(status){
			console.log(status);
			if(status == '1'){
				if(label.hasClass('label-success')){
					label.removeClass('label-success').addClass('label-default');
					label.text('否');
				}else{
					label.removeClass('label-default').addClass('label-success');
					label.text('是');
				}
			}
		}
	});
}
$('table label').click(function(){
	var label = $(this);
	$.ajax({
		url:"<?php  echo $this->createWebUrl('mem',array('op'=>'status'))?>",
		type:'post',
		data:{id:label.parent().attr('data-id')},
		success:function(status){
			if(status == '1'){
				if(label.hasClass('label-success')){
					label.removeClass('label-success').addClass('label-default');
					label.text('黑名单');
				}else{
					label.removeClass('label-default').addClass('label-success');
					label.text('正常');
				}
			}
		}
	});
});
</script>
<style>
.check_bg{
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,.5);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 99;
    display: none;
}
.check_main{
	width: 40%;
    height: auto;
    background: #fff;
    position: fixed;
    top: 150px;
    left: 30%;
    border-radius: 5px;
}
.check_main>textarea{
	width: 80%;
    margin-left: 10%;
    margin-top: 0px;
    height: 100px;
    border-radius: 5px;
}
.check_main>button{
    display: block;
    margin-top: 10px;
    border: none;
    border-radius: 5px;
    height: 34px;
    width: 80%;
    margin-left: 10%;
    margin-bottom: 20px;
    background: #5bc0de;
    color: #fff;
}
.check_main .title{
	text-align: center;
    height: 50px;
    line-height: 50px;
    font-size: 18px;
    font-weight: bold;
}
.check_close{
	position: fixed;
    left: 68.5%;
    margin-top: 10px;
    font-size: 16px;
}
.control-label{
	text-align: right;
}
.form-group{
	height: 30px;
}
</style>
<div class="check_bg">
	<div class="check_main">
        <span class="check_close"
              onclick="hideBg();">X</span>
		<div class='title' id="mtitle">请输入发货信息</div>
		<div class="panel panel-info">
	        <div class="panel-body">
                <div class="form-group" id="islevel">
                    <label class="col-xs-12 col-sm-4 col-md-3 control-label">会员等级</label>
                    <div class="col-xs-12 col-sm-8 col-lg-8">
                    	<select id="lid" class="form-control">
                        	<option value="0">普通会员</option>
                        	<?php  if(is_array($alllevels)) { foreach($alllevels as $k => $l) { ?>
                        	<option value="<?php  echo $l['id'];?>"><?php  echo $l['title'];?></option>
                        	<?php  } } ?>
                        </select>
                    </div>
                </div>
                <div class="info_level" id="isrecharge">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 col-md-3 control-label">金额</label>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <input class="form-control infoearn" name="money" id="money" type="number" placeholder="请输入快递单号" />
                        </div>
                    </div>
                        <span class="help-block" style="text-align: center;">金额大于0为增加会员余额，小于0为减少会员余额</span>
				</div>
	        </div>
        </div>
		<button id="check_btn" onclick="doRecharge();">提交</button>
	</div>
</div>
<script>
var rmid = 0;
var type = 0;
function goRecharge(oid, otype){
	rmid = oid;
	type = otype;
	if(type == 0){
		$('#isrecharge').show();
		$('#islevel').hide();
		$('#mtitle').text('请输入发货信息');
	}
	else{
		$('#islevel').show();
		$('#isrecharge').hide();
		$('#mtitle').text('请选择会员等级');
	}
	$('.check_bg').show();
	$('#money').val('');
}
function hideBg(){
	$('.check_bg').hide();
	rmid = 0;
}
function doRecharge(){
	var money = 0;
	var lid = 0;
	if(type == 0){
		money = $('#money').val();
		if(!money || money==0){
			alert('请输入充值金额');
			return false;
		}
		var url = "<?php  echo $this->createWebUrl('mem', array('op' => 'recharge'))?>";
		var msg = '确认充值吗？';
	}
	else{
		lid = $('#lid').val();
		var url = "<?php  echo $this->createWebUrl('mem', array('op' => 'level'))?>";
		var msg = '确认更改会员等级吗？';
	}
	if(rmid==0){
		alert('请选择会员');
		return false;
	}
	if(!confirm(msg))return false;
	$.ajax({
        url: url,
        type: 'post',
        data: {id: rmid,money: money, lid: lid},
        success(data){
            if(data!='1'){
            	alert(data);
            }
            else{
            	alert('操作成功');
				window.location.reload(); 
            }
        }
    });
}
</script>
<?php  } else if($op=='credit') { ?>
<form action="" method="get" class="form-horizontal" role="form">
<div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="junsion_winaward" />
                <input type="hidden" name="do" value="mem" />
                <input type="hidden" name="id" value="<?php  echo $mid;?>" />
                <input type="hidden" name="op" value="credit" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">时间</label>
                	<div class="col-xs-12 col-sm-3 col-lg-3">
                        <?php  echo tpl_form_field_daterange('dateline',array('start'=>date('Y-m-d H:i',$start),'end'=>date('Y-m-d H:i',$end)),true);?>
                    </div> 
                	<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                    <div class=" col-xs-12 col-sm-3 col-lg-3">
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
                <th>金额</th>
                <th>备注</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody id="mem-list">
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
            <tr>
                <td><?php  echo $item['credit'];?></td>
                <td><?php  echo $item['remark'];?></td>
               	<td><?php  echo date('Y-m-d H:i',$item['createtime']);?></td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
<?php  } else if($op=='red') { ?>
<form action="" method="get" class="form-horizontal" role="form">
<div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="junsion_winaward" />
                <input type="hidden" name="do" value="mem" />
                <input type="hidden" name="id" value="<?php  echo $mid;?>" />
                <input type="hidden" name="op" value="red" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">时间</label>
                	<div class="col-xs-12 col-sm-3 col-lg-3">
                        <?php  echo tpl_form_field_daterange('dateline',array('start'=>date('Y-m-d H:i',$start),'end'=>date('Y-m-d H:i',$end)),true);?>
                    </div> 
                	<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                    <div class=" col-xs-12 col-sm-3 col-lg-3">
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
                <th>金额</th>
                <th>备注</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody id="mem-list">
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
            <tr>
                <td><?php  echo $item['credit'];?></td>
                <td><?php  echo $item['remark'];?></td>
               	<td><?php  echo date('Y-m-d H:i',$item['createtime']);?></td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
<?php  } else if($op=='next') { ?>
<style>
.account-stat-num > div{width:33.3333%; float:left; font-size:16px; text-align:center;}
.account-stat-num > div span{display:block; font-size:30px; font-weight:bold;}
</style>
<div class="panel panel-default">
	<div class="panel-heading">
		订单数据统计
	</div>
		<div class="panel-body">
			<div class="account-stat-num row">
				<div>一级人数<span><?php  if(empty($first)) { ?>0<?php  } else { ?><?php  echo $first;?><?php  } ?></span></div>
				<div>二级人数<span><?php  if(empty($second)) { ?>0<?php  } else { ?><?php  echo $second;?><?php  } ?></span></div>
				<div>三级人数<span><?php  if(empty($third)) { ?>0<?php  } else { ?><?php  echo $third;?><?php  } ?></span></div>
			</div>
		</div>
</div>
<form action="" method="get" class="form-horizontal" role="form">
<div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="junsion_winaward" />
                <input type="hidden" name="do" value="mem" />
                <input type="hidden" name="id" value="<?php  echo $mid;?>" />
                <input type="hidden" name="op" value="next" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员名称</label>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <input class="form-control" name="keyword" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入会员名称">
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">分销层级</label>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <select name="level" class="form-control">
                        	<option value="0" <?php  if(empty($_GPC['level'])) { ?>selected<?php  } ?>>一级下线</option>
                        	<option value="1" <?php  if($_GPC['level']==1) { ?>selected<?php  } ?>>二级下线</option>
                        	<option value="2" <?php  if($_GPC['level']==2) { ?>selected<?php  } ?>>三级下线</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">时间</label>
                	<div class="col-xs-12 col-sm-3 col-lg-3">
                        <?php  echo tpl_form_field_daterange('dateline',array('start'=>date('Y-m-d H:i',$start),'end'=>date('Y-m-d H:i',$end)),true);?>
                    </div> 
                	<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                    <div class=" col-xs-12 col-sm-3 col-lg-3">
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
                <th>头像</th>
                <th>昵称</th>
                <th>余额佣金</th>
                <th>红包佣金</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody id="mem-list">
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
            <tr>
            	<td>
	            	<img src="<?php  echo toimage($item['avatar'])?>" style="width:60px;">
            	</td>
                <td><?php  echo $item['nickname'];?></td>
                <td><?php  echo $recharges[$item['id']]['tcommission'];?></td>
                <td><?php  echo $recharges[$item['id']]['tcommission_red'];?></td>
               	<td><?php  echo date('Y-m-d H:i',$item['createtime']);?></td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
<?php  } ?>
