<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li class="active"><a href="<?php  echo $this->createWebUrl('rouge')?>">口红订单</a></li>
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
                <input type="hidden" name="do" value="rouge" />
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
                        	<option value="2" <?php  if($_GPC['status']==2) { ?>selected<?php  } ?>>已发货</option>
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
            	<th>会员<br/>单号<br/>类型</th>
            	<th>商品</th>
                <th>数量<br/>金额</th>
                <th>状态</th>
                <th>收货信息</th>
                <th>发货信息</th>
                <th>时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody id="mem-list">
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
            <tr>
            	<td>
            	<img src="<?php  echo $mems[$item['mid']]['avatar'];?>" style="width:60px;"><br/><?php  echo $mems[$item['mid']]['nickname'];?><br/><?php  echo $item['orderno'];?>
            	<br/><?php  if(empty($item['wx_no'])) { ?>实体订单<?php  } else { ?>虚拟订单<?php  } ?>
            	</td>
            	<td><img src="<?php  echo toimage($goods[$item['gid']]['logo'])?>" style="width:60px;height:60px;"><br/><?php  echo $goods[$item['gid']]['title'];?></td>
                <td><?php  echo $item['num'];?><br/><?php  echo $item['price'];?></td>
               	<td>
					<?php  if($item['status'] == 1) { ?>
	                <label class="label label-info">已付款</label>
					<?php  } else if($item['status'] == 2) { ?>
	                <label class="label label-success">已发货</label>
	                <?php  } else { ?>
	                <label class="label label-default">待支付</label>
	                <?php  } ?>
	                <?php  if($item['status'] > 0) { ?><br/><?php  echo $item['transid'];?><?php  } ?>
				</td>
				<td><?php  echo $item['uname'];?><br/><?php  echo $item['mobile'];?><br/><?php  if(empty($item['wx_no'])) { ?><?php  echo $item['addr'];?><?php  } else { ?>微信：<?php  echo $item['wx_no'];?><?php  } ?></td>
				<td>
				<?php  if($item['status'] == 2) { ?>
				<?php  if(empty($item['wx_no'])) { ?><?php  echo $express[$item['express']];?><br/><?php  echo $item['expressno'];?>
				<?php  } else { ?><?php  echo $item['expressno'];?><?php  } ?>
				<?php  } ?>
				
				</td>
               	<td><?php  echo date('Y-m-d H:i:s',$item['createtime']);?></td>
               <td>
                   <?php  if($item['status'] == 1) { ?>
                   <a class="btn btn-primary btn-sm" onclick="goSend('<?php  echo $item['id'];?>','<?php  echo $item['wx_no'];?>')">确认发货</a>
                   <br/>
                   <?php  } ?>
                   <a class="btn btn-danger btn-sm" onclick="return confirm('确认删除吗？');return false;" href="<?php  echo $this->createWebUrl('rouge', array('op' => 'del', 'id' => $item['id']))?>">删除</a>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
<?php  } ?>
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
		<div class='title'>请输入发货信息</div>
		<div class="panel panel-info">
	        <div class="panel-body">
                <div class="form-group" id="isdummy">
                    <label class="col-xs-12 col-sm-4 col-md-3 control-label">快递公司</label>
                    <div class="col-xs-12 col-sm-8 col-lg-8">
                    	<select id="express" class="form-control">
                        	<?php  if(is_array($express)) { foreach($express as $k => $e) { ?>
                        	<option value="<?php  echo $k;?>"><?php  echo $e;?></option>
                        	<?php  } } ?>
                        </select>
                    </div>
                </div>
                <div class="info_level">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-4 col-md-3 control-label" id='etitle'>快递单号</label>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <input class="form-control infoearn" name="expressno" id="expressno" type="text" />
                        </div>
                    </div>
				</div>
	        </div>
        </div>
		<button id="check_btn" onclick="doSend();">提交</button>
	</div>
</div>
<script>
var orderid = 0;
var wx_no = '';
function goSend(oid, wxno){
	orderid = oid;
	wx_no = wxno;
	if(wxno) {
		$('#isdummy').hide();
		$('#etitle').text('发货信息');
	}
	$('.check_bg').show();
	$('#expressno').val('');
	$('#express').val(0);
}
function hideBg(){
	$('.check_bg').hide();
	orderid = 0;
}
function doSend(){
	var express = $('#express').val();
	var expressno = $('#expressno').val();
	if(!expressno){
		alert('请输入快递单号');
		return false;
	}
	if(orderid==0){
		alert('请选择订单');
		return false;
	}
	var isDummy = 0;
	if(wx_no) isDummy = 1;
	if(!confirm('确认发货吗？'))return false;
	$.ajax({
        url: "<?php  echo $this->createWebUrl('rouge', array('op' => 'send'))?>",
        type: 'post',
        data: {id: orderid,express: express, expressno: expressno, isDummy: isDummy},
        success(data){
            if(data!='1'){
            	alert(data);
            }
            else{
            	alert('发货成功');
				window.location.reload(); 
            }
        }
    });
}
</script>