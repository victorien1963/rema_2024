INSERT INTO `{P}_base_coltype` VALUES (0, 'feedback', '留言反映', '反映', 1, 1, 1, 1, 1, '');

INSERT INTO `{P}_base_adminauth` VALUES (0, 'feedback', 211, '反映表單設置', '', 1, 21, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'feedback', 212, '反映留言管理', '', 3, 21, '');


INSERT INTO `{P}_base_pageset` VALUES (0, '留言反映', 'feedback', 'main', 228, 626, 139, '', '', '', 'rgb(112,128,144)', 'none', '0% 0%', 'repeat', 'scroll', 900, 'rgb(255,255,255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 1, 'transparent', 'transparent', 'transparent', '');

INSERT INTO `{P}_base_plusdefault` VALUES (0, 'feedback', 'modFeedBackNavPath', '目前位置提示條', 'feedback', 'all', 'tpl_navpath.htm', '-1', '1000', '#dddddd', 0, 'solid', '', '', 'none', '#cccccc', '#fff', '#fff', '-1', 650, 30, 0, 200, 90, 0, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '目前位置', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'feedback', 'modFeedBackForm', '留言反映表單', 'feedback', 'all', 'tpl_feedback_form.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 650, 500, 50, 220, 90, 20, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '留言反映', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '1', '-1', 1, '', '_feedback_group', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'feedback', 'modFeedBackSmallForm', '全站留言表單', 'all', 'all', 'tpl_feedback_smallform.htm', '-1', 'A001', '', 1, 'solid', '', '', 'none', '', '', '', '-1', 650, 500, 0, 0, 90, 10, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '留言給我', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '1', '-1', 1, '', '_feedback_group', '', 1, 'hidden', 'content', 'block', 0, 0);

INSERT INTO `{P}_base_plustemp` VALUES (0, 'modFeedBackSmallForm', '小型留言表單(適合放在左右側)', 'tpl_feedback_smallform1.htm');



CREATE TABLE `{P}_feedback` (
  `id` int(3) NOT NULL auto_increment,
  `groupid` int(5) NOT NULL default '0',
  `field_caption` varchar(200) NOT NULL default '',
  `field_type` int(1) NOT NULL default '0',
  `field_size` int(5) NOT NULL default '0',
  `field_name` varchar(200) NOT NULL default '',
  `field_value` varchar(255) NOT NULL default '',
  `field_null` int(1) NOT NULL default '0',
  `value_repeat` int(1) NOT NULL default '0',
  `field_intro` varchar(255) NOT NULL default '',
  `use_field` int(1) NOT NULL default '0',
  `moveable` int(1) NOT NULL default '0',
  `xuhao` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1496 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `{P}_feedback` VALUES (1, 0, '留言標題', 1, 399, 'title', '', 1, 1, '', 1, 1, 1);
INSERT INTO `{P}_feedback` VALUES (2, 0, '留言內容', 2, 399, 'content', '', 0, 1, '', 1, 0, 2);
INSERT INTO `{P}_feedback` VALUES (3, 0, '您的姓名', 1, 399, 'name', '', 0, 1, '', 0, 0, 3);
INSERT INTO `{P}_feedback` VALUES (5, 0, '聯絡電話', 1, 399, 'tel', '', 0, 1, '', 0, 0, 5);
INSERT INTO `{P}_feedback` VALUES (6, 0, '聯絡地址', 1, 399, 'address', '', 0, 1, '', 0, 0, 6);
INSERT INTO `{P}_feedback` VALUES (7, 0, '電子郵件', 1, 399, 'email', '', 0, 1, '', 0, 0, 7);
INSERT INTO `{P}_feedback` VALUES (8, 0, '網址URL', 1, 399, 'url', '', 0, 1, '', 0, 0, 8);
INSERT INTO `{P}_feedback` VALUES (9, 0, 'QQ號碼', 1, 399, 'qq', '', 0, 1, '', 0, 0, 9);
INSERT INTO `{P}_feedback` VALUES (10, 0, '公司名稱', 1, 399, 'company', '', 0, 1, '', 0, 0, 10);
INSERT INTO `{P}_feedback` VALUES (11, 0, '公司地址', 1, 399, 'company_address', '', 0, 1, '', 0, 0, 11);
INSERT INTO `{P}_feedback` VALUES (4, 0, '性　　別', 5, 399, 'sex', '男;女', 0, 1, '', 0, 0, 4);
INSERT INTO `{P}_feedback` VALUES (12, 0, '郵遞區號', 1, 399, 'zip', '', 0, 1, '', 0, 0, 12);
INSERT INTO `{P}_feedback` VALUES (13, 0, '傳真號碼', 1, 399, 'fax', '', 0, 1, '', 0, 0, 13);
INSERT INTO `{P}_feedback` VALUES (14, 0, '產品編號', 1, 399, 'products_id', '', 0, 1, '', 0, 0, 14);
INSERT INTO `{P}_feedback` VALUES (15, 0, '產品名稱', 1, 399, 'products_name', '', 0, 1, '', 0, 0, 15);
INSERT INTO `{P}_feedback` VALUES (16, 0, '訂購數量', 1, 399, 'products_num', '', 0, 1, '', 0, 0, 16);
INSERT INTO `{P}_feedback` VALUES (19, 0, '自訂一', 5, 399, 'custom1', '100;200;300;400;500', 0, 1, '', 0, 0, 17);
INSERT INTO `{P}_feedback` VALUES (18, 0, '自訂二', 5, 399, 'custom2', '100;200;300;400;500', 0, 1, '', 0, 0, 18);
INSERT INTO `{P}_feedback` VALUES (17, 0, '自訂三', 5, 399, 'custom3', '100;200;300;400;500', 0, 1, '', 0, 0, 19);
INSERT INTO `{P}_feedback` VALUES (20, 0, '自訂四', 1, 399, 'custom4', '', 0, 1, '', 0, 0, 20);
INSERT INTO `{P}_feedback` VALUES (21, 0, '自訂五', 1, 399, 'custom5', '', 0, 1, '', 0, 0, 21);
INSERT INTO `{P}_feedback` VALUES (22, 0, '自訂六', 1, 399, 'custom6', '', 0, 1, '', 0, 0, 22);
INSERT INTO `{P}_feedback` VALUES (23, 0, '自訂七', 1, 399, 'custom7', '', 0, 1, '', 0, 0, 23);
INSERT INTO `{P}_feedback` VALUES (1145, 1, '自訂二', 5, 399, 'custom2', '100;200;300;400;500', 0, 1, '', 0, 0, 18);
INSERT INTO `{P}_feedback` VALUES (1146, 1, '自訂三', 5, 399, 'custom3', '100;200;300;400;500', 0, 1, '', 0, 0, 19);
INSERT INTO `{P}_feedback` VALUES (1147, 1, '自訂四', 1, 399, 'custom4', '', 0, 1, '', 0, 0, 20);
INSERT INTO `{P}_feedback` VALUES (1148, 1, '自訂五', 1, 399, 'custom5', '', 0, 1, '', 0, 0, 21);
INSERT INTO `{P}_feedback` VALUES (1149, 1, '自訂六', 1, 399, 'custom6', '', 0, 1, '', 0, 0, 22);
INSERT INTO `{P}_feedback` VALUES (1150, 1, '自訂七', 1, 399, 'custom7', '', 0, 1, '', 0, 0, 23);
INSERT INTO `{P}_feedback` VALUES (1143, 1, '訂購數量', 1, 399, 'products_num', '', 0, 1, '', 0, 0, 16);
INSERT INTO `{P}_feedback` VALUES (1144, 1, '自訂一', 5, 399, 'custom1', '100;200;300;400;500', 0, 1, '', 0, 0, 17);
INSERT INTO `{P}_feedback` VALUES (1142, 1, '產品名稱', 1, 399, 'products_name', '', 0, 1, '', 0, 0, 15);
INSERT INTO `{P}_feedback` VALUES (1141, 1, '產品編號', 1, 399, 'products_id', '', 0, 1, '', 0, 0, 14);
INSERT INTO `{P}_feedback` VALUES (1140, 1, '傳真號碼', 1, 399, 'fax', '', 0, 1, '', 0, 0, 13);
INSERT INTO `{P}_feedback` VALUES (1139, 1, '郵遞區號', 1, 399, 'zip', '', 0, 1, '', 0, 0, 12);
INSERT INTO `{P}_feedback` VALUES (1138, 1, '性別稱謂', 5, 399, 'sex', '先生;女士', 0, 1, '', 0, 0, 9);
INSERT INTO `{P}_feedback` VALUES (1136, 1, '客戶名稱', 1, 399, 'company', '', 1, 1, '', 1, 0, 3);
INSERT INTO `{P}_feedback` VALUES (1137, 1, '公司地址', 1, 399, 'company_address', '', 0, 1, '', 0, 0, 11);
INSERT INTO `{P}_feedback` VALUES (1135, 1, 'QQ/MSN', 1, 399, 'qq', '', 0, 1, '', 1, 0, 9);
INSERT INTO `{P}_feedback` VALUES (1134, 1, '網址URL', 1, 399, 'url', '', 0, 1, '', 0, 0, 8);
INSERT INTO `{P}_feedback` VALUES (1133, 1, '電子郵件', 1, 399, 'email', '', 0, 1, '', 0, 0, 7);
INSERT INTO `{P}_feedback` VALUES (1132, 1, '聯絡地址', 1, 399, 'address', '', 0, 1, '', 0, 0, 6);
INSERT INTO `{P}_feedback` VALUES (1131, 1, '聯絡電話', 1, 399, 'tel', '', 1, 1, '', 1, 0, 5);
INSERT INTO `{P}_feedback` VALUES (1130, 1, '聯 系 人', 1, 399, 'name', '', 0, 1, '', 1, 0, 4);
INSERT INTO `{P}_feedback` VALUES (1129, 1, '咨詢內容', 2, 399, 'content', '', 1, 1, '', 1, 0, 2);
INSERT INTO `{P}_feedback` VALUES (1128, 1, '咨詢主題', 1, 399, 'title', '', 1, 1, '', 1, 1, 1);



CREATE TABLE `{P}_feedback_info` (
  `id` int(12) NOT NULL auto_increment,
  `groupid` int(5) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `name` varchar(200) NOT NULL default '',
  `sex` varchar(10) NOT NULL default '',
  `tel` varchar(100) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `company` varchar(255) NOT NULL default '',
  `company_address` varchar(255) NOT NULL default '',
  `zip` varchar(6) NOT NULL default '',
  `fax` varchar(20) NOT NULL default '',
  `products_id` varchar(100) NOT NULL default '',
  `products_name` varchar(200) NOT NULL default '',
  `products_num` varchar(9) NOT NULL default '',
  `custom1` text NOT NULL,
  `custom2` text NOT NULL,
  `custom3` text NOT NULL,
  `custom4` text NOT NULL,
  `custom5` text NOT NULL,
  `custom6` text NOT NULL,
  `custom7` text NOT NULL,
  `ip` varchar(20) NOT NULL default '',
  `time` int(11) NOT NULL default '0',
  `uptime` int(11) NOT NULL default '0',
  `memberid` int(12) NOT NULL default '0',
  `stat` int(2) NOT NULL default '0',
  `adminid` int(5) NOT NULL default '0',
  `coadminid` int(5) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=170 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE `{P}_feedback_group` (
  `id` int(3) NOT NULL auto_increment,
  `groupname` varchar(50) NOT NULL default '',
  `xuhao` int(5) NOT NULL default '0',
  `moveable` int(1) NOT NULL default '1',
  `ifano` int(11) NOT NULL default '0',
  `allowmembertype` varchar(255) NOT NULL,
  `allowfeedback` char(255) NOT NULL,
  `intro` text NOT NULL,
  `cattemp` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `{P}_feedback_group` VALUES (1, '客戶留言', 1, 0, 1, '|26|', '|3|', '歡迎諮詢', '');