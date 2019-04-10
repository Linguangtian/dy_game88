<?php defined('IN_IA') or exit('Access Denied');?>
		<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public_head', TEMPLATE_INCLUDEPATH)) : (include template('public_head', TEMPLATE_INCLUDEPATH));?>
		<!--中间内容开始-->
		<section>
		    <section class="hbox stretch">
		    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public_left', TEMPLATE_INCLUDEPATH)) : (include template('public_left', TEMPLATE_INCLUDEPATH));?>
		    <!--右边框架-->
			  <section id="content">
			    <section class="vbox">
			        <section class="scrollable padder"  style="padding-bottom:50px;">
                        <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                          <li><a href="<?php  echo $this->createWebUrl('index')?>"><i class="fa fa-home"></i> 首页  </a></li>
                          <li class="active">会员管理</li>
                        </ul>
			            <!--编辑内容-->
                        <ul class="nav nav-tabs">
                            <li <?php  if(!$status) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('share',array('pid'=>$pid))?>">推广记录</a></li>
                            <li <?php  if($status) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('share',array('pid'=>$pid,'status'=>1))?>">黑名单</a></li>
                        </ul>
                        
                       <!---->
                       <section class="panel panel-default">
                          <div class="row m-l-none m-r-none bg-light lter">
                          	<div class="col-sm-6 col-md-3 padder-v b-r b-light"><span style="font-size:20px"><?php  if($sumcredit2) { ?><?php  echo $sumcredit2;?><?php  } else { ?>0.00<?php  } ?></span><br>总剩余(余额)</div>
                          	<div class="col-sm-6 col-md-3 padder-v b-r b-light lt"><span style="font-size:20px"><?php  if($sumcredit1) { ?><?php  echo intval($sumcredit1)?><?php  } else { ?>0<?php  } ?></span><br>总剩余(积分)</div>
                          	<div class="col-sm-6 col-md-3 padder-v b-r b-light "><span style="font-size:20px"><?php  if($daycredit2) { ?><?php  echo $daycredit2;?>/<?php  } else { ?>0.00/<?php  } ?><?php  if($dayjcredit2) { ?><?php  echo $dayjcredit2;?><?php  } else { ?>0.00<?php  } ?></span><br>今日总增减(余额)</div>
                          	<div class="col-sm-6 col-md-3 padder-v b-r b-light lt"><span style="font-size:20px"><?php  if($daycredit1) { ?><?php  echo $daycredit1;?>/<?php  } else { ?>0/<?php  } ?><?php  if($dayjcredit1) { ?><?php  echo $dayjcredit1;?><?php  } else { ?>0<?php  } ?></span><br>今日总增减(积分)</div>
                          </div>
                        </section>
                       <!---->
                        
                        
                        
                        <div class="panel panel-info">
                        <div class="panel-heading">筛选</div>
                        <div class="panel-body">
                        	<form action="<?php  echo $this->createWebUrl('share',array('pid'=>$pid,'status'=>$status))?>" method="get" class="form-horizontal">
                            <input type="hidden" name="c" value="site">
                            <input type="hidden" name="a" value="entry">
                            <input type="hidden" name="m" value="tiger_newhu">
                            <input type="hidden" name="do" value="share">
                                <div class="form-group">
                                   <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="width: 200px;">昵称或UID/openid</label>
                                    <div class="col-sm-2 col-lg-3">
                                        <input type="text" name="name" value="<?php  echo $name;?>" class="form-control" style="display: inline-block;">
                                    </div>
                                   <button class="btn btn-default">搜索</button>
                                </div>
                            </form>
                        </div>
                </div>
<style>
th{
	text-align: left !important;
}
.table-responsive .label { display:inline-block;margin:0;margin-bottom:2px;}
td{
	text-align: left !important;
	/*white-space: normal !important;
	word-break: break-all !important;*/
}
.table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
   white-space: inherit;
    overflow: visible;
    text-overflow: ellipsis;
}

</style>
<!--a onclick="return confirm('确定后请不要关闭页面，直到优化完毕！')" href='<?php  echo $this->createWebUrl("memberzh")?>' class='btn btn-danger btn-sm'>数据优化（适应新系统）</a-->
<div style="padding-bottom:15px;">
<a onclick="return confirm('你确定要全部【开启】链接查券功能吗')" href='<?php  echo $this->createWebUrl("sharecq",array("type"=>1))?>' class='btn btn-info btn-sm'>全部【开启】查卷功能</a>
<a onclick="return confirm('你确定要全部【关闭】链接查券功能吗')" href='<?php  echo $this->createWebUrl("sharecq",array("type"=>2))?>' class='btn btn-danger btn-sm'>全部【关闭】查卷功能</a>
</div>
                <div class="panel panel-default">

                    <div class="panel-body" style="text-align: center;">

                        <table class="table table-hover">

                            <thead class="navbar-inner">
                                <tr>
                                	<th width="60"><input type="checkbox" name="" onclick="var ck = this.checked;$(':checkbox').each(function(){this.checked = ck});"></th>
                                    <th width="60">uid</th>	
                                    <th width="35"></th>
                                    <th>昵称</th>		
                                    <th width="120">下级</th>
                                    <th width="100">订阅</th>
                                    <th width="100">黑名单</th>
                                    <th >上级</th>
                                    <th>积分/余额</th>
                                    <th>注册时间</th>
                                    <th>来源</th>
                                    <th style="width: 250px;">操作</th>
                                </tr>
                            </thead>
<form action="<?php  echo $this->createWebUrl('share',array('op'=>'display'))?>" method="post" class="form-horizontal" id="form1">
                            <tbody id="table_content">

                                <?php  if(is_array($mlist)) { foreach($mlist as $l) { ?>

                   <!--<tr rel="pop" data-title="UID: <?php  echo $l['tjrid'];?> " data-content="推荐人 <br/> 				
                                              [<?php  echo $l['tjrid'];?>]<?php  if($l['tjrname']!='') { ?><?php  echo $l['tjrname'];?><?php  } else { ?>平台<?php  } ?>" data-original-title="" title="" aria-describedby="popover215830">-->
                    <tr rel="pop" title="">
                    <td><input type="checkbox" name="id[]" value="<?php  echo $l['id'];?>" class=""></td>
                    <td> <?php  echo $l['id'];?></td>
                    <td><img src="<?php  echo $l['avatar'];?>" style="width: 30px;height: 30px;"> </td>
                    <td><?php  echo $l['nickname'];?><?php  if($l['dltype']==1) { ?><b style="color: #ff0000;">(代理)</b><?php  } ?></td>
                    
                    <td>
                        <div class="btn btn-info btn-sm"><?php  if($l['l1']<>0) { ?><a style="color:#ffffff;" href="<?php  echo $this->createWebUrl('share',array('pid'=>$pid,'sid'=>$l['uid']))?>" class="col">一级 : <?php  echo $l['l1'];?></a><?php  } else { ?> 一级：0<?php  } ?></div><br>
                        <div style="clear:both;height:4px;"></div>

                        <div class="btn btn-info btn-sm"><?php  if($l['l2']<>0) { ?><a style="color:#ffffff"  href="<?php  echo $this->createWebUrl('share',array('pid'=>$pid,'cid'=>$l['uid']))?>" class="col">二级: <?php  echo $l['l2'];?></a><?php  } else { ?>二级: 0<?php  } ?></div><br>

                        <!--label class="label label-info"><?php  if($l['lv3']<>0) { ?><a style="color:#ffffff"  href="<?php  echo $this->createWebUrl('hymember',array('id'=>$l['id'],'pid'=>$pid,op=>'3'));?>" class="col">三级: <?php  echo $l['lv3'];?></a><?php  } else { ?>三级: 0<?php  } ?></label><br-->
                    </td>
                    <td><?php  if($l['dytype']==1) { ?><a href='###' class='btn btn-danger btn-sm'>已退订阅</a><?php  } else { ?><a href='###' class='btn btn-info btn-sm'>已订阅</a><?php  } ?></td>
                    <td><?php  if($l['status']==1) { ?><a href='###' class='btn btn-info btn-sm lahei'>黑</a><?php  } ?></td>
                    <td><?php  if($l['tjrid']) { ?><?php  echo $l['tjrname'];?>(UID:<?php  echo $l['tjrid'];?>)<?php  } ?></td>
                    <td>积分：<?php  if($l['credit1']) { ?><?php  echo $l['credit1'];?><?php  } else { ?>0<?php  } ?><br>余额：<?php  if($l['credit2']) { ?><?php  echo $l['credit2'];?><?php  } else { ?>0.00<?php  } ?></td>                
                    <td><?php  echo date('Y-m-d',$l['createtime'])?><Br><?php  echo date('H:i:s',$l['createtime'])?></td>
                    <td><?php  if($l['lytype']==1) { ?><label class="label label-success">APP</label><?php  } else if($l['lytype']==2) { ?><label class="label label-warning">小程序</label><?php  } else { ?><label class="label label-info">公众号</label><?php  } ?></td>


                    <td>
                 <a href='<?php  echo $this->createWebUrl("memberecord",array("id"=>$l["id"]))?>' class='btn btn-success btn-sm'>积分/余额</a>
                    	<a href='<?php  echo $this->createWebUrl("memberedit",array("id"=>$l["id"]))?>' class='btn btn-info btn-sm'>编辑信息</a>
                        <!--a href='<?php  echo $this->createWebUrl("memberedit",array("id"=>$l["id"]))?>' class='btn btn-info btn-sm'>分销订单</a-->
                    	<a onclick="return confirm('删除后将无法恢复，确定删除吗？')" href='<?php  echo $this->createWebUrl("delete",array("sceneid"=>$l["sceneid"],"sid"=>$l["id"],"status"=>$status))?>' class='btn btn-danger btn-sm'>删除</a>
                    </td>
                </tr>
                <?php  } } ?>
                <tr>
                	<td><input type="checkbox" name="" onclick="var ck = this.checked;$(':checkbox').each(function(){this.checked = ck});"></td>
                	<td colspan="8" style="text-align: left !important;">
                		<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
                        <input type="submit" class="btn btn-primary" name="submit" value="批量转换积分/余额" /> 
                        <input type="submit" class="btn btn-primary lahei" name="submitlh" value="批量拉黑" />  
                        <input type="submit" class="btn btn-primary" name="submitlhqx" value="批量取消拉黑" /> 
                	</td>
                </tr>

                            </tbody>

                        </table>
</form>
                        <?php  echo $pager;?>

                    </div>

                </div>
                        <!--编辑内容结束-->
			        </section>
			        <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public_bottom', TEMPLATE_INCLUDEPATH)) : (include template('public_bottom', TEMPLATE_INCLUDEPATH));?>
			    </section>
			    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
			  </section>
			  <aside class="bg-light lter b-l aside-md hide" id="notes">
			       <div class="wrapper">不知道放什么</div>
			  </aside>
			<!--右边框架结束-->
			</section>
		  </section>
		<!--中间内容结束-->
	</section>
<style>
	.lahei{background-color: #000000;border-color: #000000;}
</style>
<script language="javascript">
		require(['bootstrap'],function(){
        $("[rel=pop]").popover({
            trigger:'manual',
            placement : 'top', 
            title : $(this).data('title'),
            html: 'true', 
            content : $(this).data('content'),
            animation: false
        }).on("mouseenter", function () {
                    var _this = this;
                    $(this).popover("show"); 
                    $(this).siblings(".popover").on("mouseleave", function () {
                        $(_this).popover('hide');
                    });
                }).on("mouseleave", function () {
                    var _this = this;
                    setTimeout(function () {
                        if (!$(".popover:hover").length) {
                            $(_this).popover("hide")
                        }
                    }, 100);
                });
	   });
				   
</script>
</body>
</html>