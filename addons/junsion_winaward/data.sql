CREATE TABLE IF NOT EXISTS `ims_junsion_winaward_good` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT '0',
  `title` varchar(150) DEFAULT '',
  `sub_title` varchar(50) DEFAULT '',
  `label` varchar(10) DEFAULT '',
  `logo` varchar(255) DEFAULT '',
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `postage` decimal(11,2) NOT NULL DEFAULT '0.00',
  `costprice` decimal(11,2) NOT NULL DEFAULT '0.00',
  `game` text,
  `status` tinyint(1) DEFAULT '0' COMMENT '状态 0显示 1隐藏',
  `sort` int(10) DEFAULT '0',
  `buy` decimal(11,2) NOT NULL DEFAULT '0.00',
  `type` tinyint(1) DEFAULT '0' COMMENT '状态 0实体商品 1虚拟商品',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`weid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_junsion_winaward_invite_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT '0',
  `mid` int(10) DEFAULT '0',
  `gid` int(10) DEFAULT '0',
  `credit` decimal(11,2) NOT NULL DEFAULT '0.00',
  `remark` varchar(50) DEFAULT '',
  `createtime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mc` (`mid`,`createtime`),
  KEY `idx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_junsion_winaward_level` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `logo` varchar(255) DEFAULT '',
  `level` tinyint(1) DEFAULT '0',
  `commission` text,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_junsion_winaward_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT '0',
  `oid` int(10) DEFAULT '0',
  `mid` int(10) DEFAULT '0',
  `gid` int(10) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态 0未中奖 1已中奖',
  `createtime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mc` (`mid`,`createtime`),
  KEY `idx_uniacid` (`weid`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_junsion_winaward_lorder` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT '0',
  `orderno` varchar(50) DEFAULT '' COMMENT '订单编号',
  `mid` int(10) DEFAULT '0',
  `lid` int(10) DEFAULT '0',
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态 0待支付 1已支付',
  `transid` varchar(50) DEFAULT '' COMMENT '流水单号',
  `createtime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_junsion_winaward_mcredit` (
  `mid` int(11) DEFAULT '0',
  `credit` decimal(11,2) NOT NULL DEFAULT '0.00',
  `remark` varchar(50) DEFAULT '',
  `createtime` int(10) DEFAULT '0',
  UNIQUE KEY `mc` (`mid`,`createtime`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_junsion_winaward_mem` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT '0',
  `openid` varchar(50) DEFAULT '',
  `unionid` varchar(50) DEFAULT '' COMMENT '用户unionid',
  `nickname` varchar(50) DEFAULT '',
  `avatar` varchar(255) DEFAULT '',
  `credit` decimal(11,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态 0正常 1禁用',
  `agentid` int(11) DEFAULT '0',
  `red` decimal(11,2) NOT NULL DEFAULT '0.00',
  `total_red` decimal(11,2) NOT NULL DEFAULT '0.00',
  `total_credit` decimal(11,2) NOT NULL DEFAULT '0.00',
  `createtime` int(11) DEFAULT '0',
  `isagent` tinyint(1) DEFAULT '0' COMMENT '代理 0否 1是',
  `qr` varchar(255) DEFAULT '',
  `lid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_openid` (`openid`),
  KEY `idx_uniacid` (`weid`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_junsion_winaward_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT '0',
  `orderno` varchar(50) DEFAULT '' COMMENT '订单编号',
  `mid` int(10) DEFAULT '0',
  `gid` int(10) DEFAULT '0',
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态 0待支付 1已支付',
  `remark` varchar(150) DEFAULT '' COMMENT '备注',
  `createtime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`weid`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_junsion_winaward_rcredit` (
  `mid` int(11) DEFAULT '0',
  `aid` int(11) DEFAULT '0',
  `credit` decimal(11,2) NOT NULL DEFAULT '0.00',
  `remark` varchar(50) DEFAULT '',
  `createtime` int(10) DEFAULT '0',
  UNIQUE KEY `mc` (`mid`,`createtime`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_junsion_winaward_recharge` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT '0',
  `orderno` varchar(50) DEFAULT '' COMMENT '订单编号',
  `mid` int(10) DEFAULT '0',
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `commission` decimal(11,2) NOT NULL DEFAULT '0.00',
  `commission_red` decimal(11,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态 0待支付 1已支付',
  `transid` varchar(50) DEFAULT '' COMMENT '流水单号',
  `createtime` int(11) DEFAULT '0',
  `commission2` decimal(11,2) NOT NULL DEFAULT '0.00',
  `commission3` decimal(11,2) NOT NULL DEFAULT '0.00',
  `commission_red2` decimal(11,2) NOT NULL DEFAULT '0.00',
  `commission_red3` decimal(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`weid`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_junsion_winaward_rouge` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT '0',
  `orderno` varchar(50) DEFAULT '' COMMENT '订单编号',
  `oid` int(10) DEFAULT '0',
  `mid` int(10) DEFAULT '0',
  `gid` int(10) DEFAULT '0',
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态 0待支付 1已支付 2已发货',
  `transid` varchar(50) DEFAULT '' COMMENT '流水单号',
  `uname` varchar(50) DEFAULT '',
  `mobile` varchar(12) DEFAULT '',
  `addr` varchar(255) DEFAULT '',
  `express` int(11) DEFAULT '0' COMMENT '快递公司编号',
  `expressno` varchar(250) DEFAULT '' COMMENT '快递单号',
  `createtime` int(11) DEFAULT '0',
  `unit_price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `num` int(10) DEFAULT '1',
  `wx_no` varchar(50) DEFAULT '' COMMENT '虚拟商品必填',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`weid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_junsion_winaward_session` (
  `openid` varchar(50) DEFAULT '',
  `session_key` varchar(50) DEFAULT '',
  UNIQUE KEY `m_hid` (`openid`,`session_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_junsion_winaward_with` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `mid` int(11) DEFAULT '0',
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `wrate` decimal(11,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) DEFAULT '0',
  `transid` varchar(50) DEFAULT '',
  `createtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_mtime` (`mid`,`createtime`),
  KEY `weid` (`weid`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;