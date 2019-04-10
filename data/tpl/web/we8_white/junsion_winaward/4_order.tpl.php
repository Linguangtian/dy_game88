<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li class="active"><a href="<?php  echo $this->createWebUrl('order')?>">闯关订单</a></li>
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
.account-stat-num > div{width:25%; float:left; font-size:16px; text-align:center;}
.account-stat-num > div span{display:block; font-size:30px; font-weight:bold;}
</style>
<div class="panel panel-default">
	<div class="panel-heading">
		订单数据统计
	</div>
		<div class="panel-body">
			<div class="account-stat-num row">
				<div>今日记录数<span><?php  if(empty($today)) { ?>0<?php  } else { ?><?php  echo $today;?><?php  } ?></span></div>
				<div>今日金额<span><?php  if(empty($daymoney)) { ?>0<?php  } else { ?><?php  echo $daymoney;?><?php  } ?></span></div>
				<div>总记录数<span><?php  if(empty($total)) { ?>0<?php  } else { ?><?php  echo $total;?><?php  } ?></span></div>
				<div>总金额<span><?php  if(empty($money)) { ?>0<?php  } else { ?><?php  echo $money;?><?php  } ?></span></div>
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
                <input type="hidden" name="do" value="order" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">订单号</label>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <input class="form-control" name="keyword" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入订单编号">
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员昵称</label>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <input class="form-control" name="m_kwd" type="text" value="<?php  echo $_GPC['m_kwd'];?>" placeholder="请输入会员昵称">
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">商品名称</label>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <input class="form-control" name="g_kwd" type="text" value="<?php  echo $_GPC['g_kwd'];?>" placeholder="请输入商品名称">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">状态</label>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <select name="status" class="form-control">
                        	<option value="">全部</option>
                        	<option value="0" <?php  if(empty($_GPC['status']) && $_GPC['status']!='') { ?>selected<?php  } ?>>待支付</option>
                        	<option value="1" <?php  if($_GPC['status']==1) { ?>selected<?php  } ?>>已支付</option>
                        	<option value="2" <?php  if($_GPC['status']==2) { ?>selected<?php  } ?>>待申请发货</option>
                        	<option value="3" <?php  if($_GPC['status']==3) { ?>selected<?php  } ?>>已完成</option>
                        	<option value="-1" <?php  if($_GPC['status']==-1) { ?>selected<?php  } ?>>闯关失败</option>
                        </select>
                    </div>
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">时间</label>
                    <div class="col-xs-12 col-sm-3 col-lg-3">
                        <?php  echo tpl_form_field_daterange('dateline',array('start'=>date('Y-m-d H:i',$start),'end'=>date('Y-m-d H:i',$end)),true);?>
                    </div>
                    <div class=" col-xs-12 col-sm-2 col-lg-2">
                        <button class="btn btn-default" ><i class="fa fa-search"></i> 搜索</button>
                        <button class="btn btn-primary" name='export' value='1'>导出</button>
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
            	<th>单号</th>
            	<th>会员</th>
            	<th>商品</th>
                <th>金额</th>
                <th>状态</th>
                <th>备注</th>
                <th>时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody id="mem-list">
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
            <tr>
            	<td><?php  echo $item['orderno'];?></td>
            	<td><img src="<?php  echo $mems[$item['mid']]['avatar'];?>" style="width:60px;"><br/><?php  echo $mems[$item['mid']]['nickname'];?></td>
            	<td><img src="<?php  echo toimage($goods[$item['gid']]['logo'])?>" style="width:60px;"><br/><?php  echo $goods[$item['gid']]['title'];?></td>
                <td><?php  echo $item['price'];?></td>
               	<td>
					<?php  if($item['status'] == 1) { ?>
	                <label class="label label-info">已付款</label>
					<?php  } else if($item['status'] == 2) { ?>
	                <label class="label label-warning">待申请发货</label>
					<?php  } else if($item['status'] == 3) { ?>
	                <label class="label label-success">已完成</label>
					<?php  } else if($item['status'] == -1) { ?>
	                <label class="label label-danger">闯关失败</label>
	                <?php  } else { ?>
	                <label class="label label-default">待支付</label>
	                <?php  } ?>
				</td>
				<td><?php  echo $item['remark'];?></td>
               	<td><?php  echo date('Y-m-d H:i:s',$item['createtime']);?></td>
               <td>
                   <a class="btn btn-danger btn-sm" onclick="return confirm('确认删除吗？');return false;" href="<?php  echo $this->createWebUrl('order', array('op' => 'del', 'id' => $item['id']))?>">删除</a>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
<?php  } ?>