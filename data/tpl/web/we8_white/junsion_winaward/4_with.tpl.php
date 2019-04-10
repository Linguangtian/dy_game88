<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li class='active'><a href="<?php  echo $this->createWebUrl('with')?>">提现列表</a></li>
</ul>
<style>
th{
	text-align: center !important;
}
td{
	text-align: center !important;
	white-space: normal !important;
	word-break: break-all !important;
}
.account-stat-num > div{width:20%; float:left; font-size:16px; text-align:center;}
.account-stat-num > div span{display:block; font-size:30px; font-weight:bold;}
</style>

<div style="padding:15px;background: white;margin-bottom: 10px;">
	<div class="account-stat-num row">
		<div>今日待提现总额<span><?php  echo $today_num;?></span></div>
		<div>今日已提现总额<span><?php  echo $today_money;?></span></div>
		<div>待提现总额<span><?php  echo $all_num;?></span></div>
		<div>已提现总额<span><?php  echo $all_money;?></span></div>
		<div>总手续费<span><?php  echo $all_rate;?></span></div>
	</div>
</div>
<form action="" method="get" class="form-horizontal" role="form">
<div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="junsion_winaward" />
                <input type="hidden" name="do" value="with" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员</label>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <input class="form-control" name="keyword" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入会员昵称">
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">时间</label>
                    <div class="col-xs-12 col-sm-3 col-lg-3">
                        <?php  echo tpl_form_field_daterange('dateline',array('start'=>date('Y-m-d H:i',$start),'end'=>date('Y-m-d H:i',$end)),true);?>
                    </div>
                	<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 control-label"></label>
                    <div class=" col-xs-12 col-sm-2 col-lg-2">
                        <button class="btn btn-default" ><i class="fa fa-search"></i> 搜索</button>
                        <button class="btn btn-primary" name='export' value='1'>导出</button>
                   	</div>
                </div>
        </div>
    </div>
</form>
<link type="text/css" rel="stylesheet" href="<?php echo RES;?>css/jquery.galpop.css?v=<?php echo TIMESTAMP;?>" media="screen" />
<script type="text/javascript" src="<?php echo RES;?>js/jquery.galpop.min.js"></script>
<style>
#galpop-content img {
    width: 100%;
}
</style>
<div class="panel panel-default">
	<a href='<?php  echo $this->createWebUrl("with",array("op"=>"sendall"))?>' onclick="return check()" class='btn btn-warning'>全部提现</a>
    <div class="table-responsive panel-body">
        <table class="table table-hover">
            <thead class="navbar-inner">
            <tr>
            	<th>会员信息</th>
                <th>金额<br/>手续费</th>
                <th>微信收款二维码</th>
                <th>状态</th>
                <th>流水号</th>
                <th>提现时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody id="mem-list">
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
            <tr>
            	<td><img src="<?php  echo $item['avatar'];?>" style="width:60px;"><br/><?php  echo $item['nickname'];?></td>
               	<td><?php  echo $item['price'];?><br/><?php  echo $item['wrate'];?></td>
               	<td><a class="galpop-multiple" data-galpop-group="multiple" href="<?php  echo $item['qr'];?>"><img src="<?php  echo $item['qr'];?>" style="width:60px;"></a></td>
               	<td><?php  if(empty($item['status'])) { ?><label class="label label-primary">待审核</label><?php  } else { ?><label class="label label-success">已发放</label><?php  } ?></td>
               	<td><?php  echo $item['transid'];?></td>
               	<td><?php  echo date('Y-m-d H:i:s',$item['createtime']);?></td>
               	<td>
               	<?php  if(!$item['status']) { ?>
               		<a class="btn btn-primary btn-sm" onclick="return confirm('确认发放吗？');return false;" href="<?php  echo $this->createWebUrl('with', array('id' => $item['id'],'op'=>'send'))?>">确认发放</a>
                    <a class="btn btn-danger btn-sm" onclick="return confirm('确认删除吗？');return false;" href="<?php  echo $this->createWebUrl('with', array('op' => 'del', 'id' => $item['id']))?>">删除</a>
                <?php  } ?>    
               	</td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
<script>
$(function(){
	$('.galpop-multiple').galpop();
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('loading', TEMPLATE_INCLUDEPATH)) : (include template('loading', TEMPLATE_INCLUDEPATH));?>
<script>
function check(){
	if(confirm('确认全部提现吗？')){
		LOADING(true);
		return true;
	}
	return false;
}
</script>