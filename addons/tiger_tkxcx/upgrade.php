<?php 
$sql="CREATE TABLE IF NOT EXISTS `ims_tiger_tkxcx_hb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `type` varchar(250) DEFAULT '0',
  `title` varchar(250) DEFAULT '0',
  `pic` varchar(250) DEFAULT '0',
  `url` varchar(1000) DEFAULT '0',
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_tiger_tkxcx_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `gzwid` int(11) DEFAULT '0' COMMENT '对接公众号ID',
  `shtype` int(11) DEFAULT '0' COMMENT '审核模式  1审核模式',
  `tzurl` varchar(1000) NOT NULL COMMENT '跳转域名',
  `xsversion` varchar(50) NOT NULL COMMENT '线上运行版本',
  `shversion` varchar(50) NOT NULL COMMENT '提交审核版本',
  `tbuid` varchar(100) NOT NULL COMMENT '淘宝ID',
  `sharetitle` varchar(500) NOT NULL COMMENT '0',
  `shareimg` varchar(500) NOT NULL COMMENT '列表分享图标',
  `titlecolor` varchar(100) NOT NULL,
  `bjcolor` varchar(100) NOT NULL,
  `cjsimg` varchar(500) NOT NULL,
  `cjsbjcolor` varchar(500) NOT NULL,
  `cjsfontcolor` varchar(100) NOT NULL,
  `cjsjcimg` varchar(100) NOT NULL,
  `weburl` varchar(500) NOT NULL,
  `fxtype` varchar(10) NOT NULL,
  `dlkgtype` varchar(10) NOT NULL,
  `hybjimg` varchar(500) NOT NULL,
  `viewhelpid` varchar(500) NOT NULL,
  `ggtype` varchar(10) NOT NULL,
  `mstype` varchar(10) NOT NULL,
  `tlad` varchar(500) NOT NULL,
  `tladurl` varchar(500) NOT NULL,
  `stimg` varchar(500) NOT NULL,
  `flmsg` varchar(500) NOT NULL,
  `dlxsyj` int(5) NOT NULL COMMENT '代理显示佣金  1显示',
  `bottomtype` int(5) DEFAULT '0',
  `qiandaomsg` varchar(500) DEFAULT '',
  `tztype` varchar(10) DEFAULT '',
  `tzimg` varchar(500) DEFAULT '',
  `tzcurl` varchar(500) DEFAULT '',
  `tztitle` varchar(500) DEFAULT '',
  `hometkltype` varchar(10) DEFAULT '',
  `kltype` varchar(10) DEFAULT '0',
  `zctype` varchar(10) DEFAULT '0',
  `zdyurl` varchar(500) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `weid` (`weid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
";
pdo_run($sql);
if(!pdo_fieldexists("tiger_tkxcx_hb", "id")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_hb")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("tiger_tkxcx_hb", "weid")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_hb")." ADD   `weid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("tiger_tkxcx_hb", "type")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_hb")." ADD   `type` varchar(250) DEFAULT '0';");
}
if(!pdo_fieldexists("tiger_tkxcx_hb", "title")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_hb")." ADD   `title` varchar(250) DEFAULT '0';");
}
if(!pdo_fieldexists("tiger_tkxcx_hb", "pic")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_hb")." ADD   `pic` varchar(250) DEFAULT '0';");
}
if(!pdo_fieldexists("tiger_tkxcx_hb", "url")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_hb")." ADD   `url` varchar(1000) DEFAULT '0';");
}
if(!pdo_fieldexists("tiger_tkxcx_hb", "createtime")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_hb")." ADD   `createtime` int(10) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "id")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "weid")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `weid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "gzwid")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `gzwid` int(11) DEFAULT '0' COMMENT '对接公众号ID';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "shtype")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `shtype` int(11) DEFAULT '0' COMMENT '审核模式  1审核模式';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "tzurl")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `tzurl` varchar(1000) NOT NULL COMMENT '跳转域名';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "xsversion")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `xsversion` varchar(50) NOT NULL COMMENT '线上运行版本';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "shversion")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `shversion` varchar(50) NOT NULL COMMENT '提交审核版本';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "tbuid")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `tbuid` varchar(100) NOT NULL COMMENT '淘宝ID';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "sharetitle")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `sharetitle` varchar(500) NOT NULL COMMENT '0';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "shareimg")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `shareimg` varchar(500) NOT NULL COMMENT '列表分享图标';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "titlecolor")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `titlecolor` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "bjcolor")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `bjcolor` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "cjsimg")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `cjsimg` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "cjsbjcolor")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `cjsbjcolor` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "cjsfontcolor")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `cjsfontcolor` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "cjsjcimg")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `cjsjcimg` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "weburl")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `weburl` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "fxtype")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `fxtype` varchar(10) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "dlkgtype")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `dlkgtype` varchar(10) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "hybjimg")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `hybjimg` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "viewhelpid")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `viewhelpid` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "ggtype")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `ggtype` varchar(10) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "mstype")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `mstype` varchar(10) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "tlad")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `tlad` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "tladurl")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `tladurl` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "stimg")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `stimg` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "flmsg")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `flmsg` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "dlxsyj")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `dlxsyj` int(5) NOT NULL COMMENT '代理显示佣金  1显示';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "bottomtype")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `bottomtype` int(5) DEFAULT '0';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "qiandaomsg")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `qiandaomsg` varchar(500) DEFAULT '';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "tztype")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `tztype` varchar(10) DEFAULT '';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "tzimg")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `tzimg` varchar(500) DEFAULT '';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "tzcurl")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `tzcurl` varchar(500) DEFAULT '';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "tztitle")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `tztitle` varchar(500) DEFAULT '';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "hometkltype")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `hometkltype` varchar(10) DEFAULT '';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "kltype")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `kltype` varchar(10) DEFAULT '0';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "zctype")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `zctype` varchar(10) DEFAULT '0';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "zdyurl")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   `zdyurl` varchar(500) DEFAULT '0';");
}
if(!pdo_fieldexists("tiger_tkxcx_set", "weid")) {
 pdo_query("ALTER TABLE ".tablename("tiger_tkxcx_set")." ADD   KEY `weid` (`weid`);");
}

 ?>