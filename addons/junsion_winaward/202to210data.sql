SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE `ims_junsion_winaward_rouge` MODIFY COLUMN `expressno` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '快递单号' AFTER `express`;
SET FOREIGN_KEY_CHECKS=1;