INSERT INTO `{P}_base_coltype` VALUES (0, 'news', '文章模組', '文章', 1, 1, 1, 1, 1, '_news_cat');

INSERT INTO `{P}_base_pageset` VALUES (0, '頻道首頁', 'news', 'main', 230, 451, 151, '', '', '', 'rgb(112,128,144)', 'none', '0% 0%', 'repeat', 'scroll', 900, 'rgb(255,255,255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', 'index', 0, 'transparent', 'transparent', 'transparent', '');

INSERT INTO `{P}_base_adminauth` VALUES (0, 'news', 120, '文章模組參數設置', '', 0, 12, '');

INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsPicMemo', '文章圖片+標題+摘要', 'all', 'all', 'tpl_newspicmemo.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 300, 320, 0, 0, 99, 5, 3, 'id|dtime|uptime|prop1|prop2|cl', 'desc', 0, 12, '_self', 0, 35, 80, 80, 'fill', '圖片新聞', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_news_cat', '', '_news_proj', -1, 'hidden', 'content', 'block', 1, 0);

INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsAuthorList', '標題+時間', 'tpl_newslist_time.htm');

CREATE TABLE `{P}_news_cat` (
  `catid` int(12) NOT NULL auto_increment,
  `pid` int(12) NOT NULL default '0',
  `cat` char(100) NOT NULL default '',
  `xuhao` int(12) NOT NULL default '0',
  `catpath` char(255) NOT NULL default '',
  `nums` int(20) NOT NULL default '0',
  `tj` int(1) NOT NULL default '0',
  `ifchannel` int(1) NOT NULL default '0',
  PRIMARY KEY  (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `{P}_news_con` (
  `id` int(12) NOT NULL auto_increment,
  `catid` int(12) NOT NULL default '0',
  `catpath` varchar(255) NOT NULL default '',
  `pcatid` int(12) NOT NULL default '0',
  `contype` varchar(20) NOT NULL default 'news',
  `title` varchar(255) NOT NULL default '',
  `body` text,
  `dtime` int(11) default '0',
  `xuhao` int(5) default '0',
  `cl` int(20) default NULL,
  `tj` int(1) default NULL,
  `iffb` int(1) default '0',
  `ifbold` int(1) default '0',
  `ifred` varchar(20) default NULL,
  `type` varchar(30) NOT NULL default '',
  `src` varchar(150) NOT NULL default '',
  `uptime` int(11) default '0',
  `author` varchar(100) default NULL,
  `source` varchar(100) default NULL,
  `memberid` varchar(100) default NULL,
  `proj` varchar(255) NOT NULL default '',
  `secure` int(11) NOT NULL default '0',
  `memo` text NOT NULL,
  `prop1` char(255) NOT NULL default '',
  `prop2` char(255) NOT NULL default '',
  `prop3` char(255) NOT NULL default '',
  `prop4` char(255) NOT NULL default '',
  `prop5` char(255) NOT NULL default '',
  `prop6` char(255) NOT NULL default '',
  `prop7` char(255) NOT NULL default '',
  `prop8` char(255) NOT NULL default '',
  `prop9` char(255) NOT NULL default '',
  `prop10` char(255) NOT NULL default '',
  `prop11` char(255) NOT NULL default '',
  `prop12` char(255) NOT NULL default '',
  `prop13` char(255) NOT NULL default '',
  `prop14` char(255) NOT NULL default '',
  `prop15` char(255) NOT NULL default '',
  `prop16` char(255) NOT NULL default '',
  `prop17` char(255) NOT NULL default '',
  `prop18` char(255) NOT NULL default '',
  `prop19` char(255) NOT NULL default '',
  `prop20` char(255) NOT NULL default '',
  `fileurl` varchar(100) NOT NULL,
  `downcount` int(10) NOT NULL default '0',
  `tags` varchar(255) NOT NULL,
  `zhichi` int(5) NOT NULL default '0',
  `fandui` int(5) NOT NULL default '0',
  `tplog` text NOT NULL,
  `downcentid` int(1) NOT NULL default '1',
  `downcent` int(5) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `{P}_news_config` (
  `xuhao` int(3) NOT NULL default '0',
  `vname` varchar(50) NOT NULL default '',
  `settype` varchar(30) NOT NULL default 'input',
  `colwidth` varchar(3) NOT NULL default '30',
  `variable` varchar(32) NOT NULL default '',
  `value` text NOT NULL,
  `intro` text NOT NULL,
  PRIMARY KEY  (`variable`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `{P}_news_config` VALUES (1, '模組頻道名稱', 'input', '30', 'ChannelName', '新聞動態', '本模組對應的頻道名稱，如「新聞中心」；用於顯示在網頁標題、目前位置提示條等處');
INSERT INTO `{P}_news_config` VALUES (2, '是否在目前位置提示條顯示模組頻道名稱', 'YN', '30', 'ChannelNameInNav', '1', '是否在目前位置提示條顯示模組頻道名稱');
INSERT INTO `{P}_news_config` VALUES (5, '文章主題圖片上傳大小限制(Byte)', 'input', '30', 'PicSizeLimit', '256000', '會員發佈文章上傳主題圖片時,單個圖片大小的限制');
INSERT INTO `{P}_news_config` VALUES (6, '文章編輯器圖片上傳限制(Byte)', 'input', '30', 'EditPicLimit', '512000', '會員發佈文章時,在編輯器內上傳圖片,單個圖片的大小限制');
INSERT INTO `{P}_news_config` VALUES (7, '附件上傳大小限制', 'input', '30', 'FileSizeLimit', '1024000', '會員發佈文章上傳附件時,允許上傳附件的文件大小;但最高設置不能超過2M ');
INSERT INTO `{P}_news_config` VALUES (8, '會員發佈文章關鍵詞過濾', 'textarea', '30', 'KeywordDeny', '法輪功,麻醉,興奮劑', '會員發佈文章時禁止的詞語，多個以逗號分割');


CREATE TABLE `{P}_news_downlog` (
  `id` int(12) NOT NULL auto_increment,
  `newsid` int(12) NOT NULL default '0',
  `memberid` int(12) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




CREATE TABLE `{P}_news_pages` (
  `id` int(12) NOT NULL auto_increment,
  `newsid` int(12) NOT NULL default '0',
  `body` text NOT NULL,
  `xuhao` int(5) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




CREATE TABLE `{P}_news_pcat` (
  `catid` int(12) NOT NULL auto_increment,
  `memberid` int(12) NOT NULL default '0',
  `pid` int(12) NOT NULL default '0',
  `cat` char(100) NOT NULL default '',
  `xuhao` int(12) NOT NULL default '0',
  `catpath` char(255) NOT NULL default '',
  PRIMARY KEY  (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE `{P}_news_proj` (
  `id` int(12) NOT NULL auto_increment,
  `project` varchar(100) default NULL,
  `folder` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `{P}_news_prop` (
  `id` int(20) NOT NULL auto_increment,
  `catid` int(20) NOT NULL default '0',
  `propname` char(30) default NULL,
  `xuhao` int(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `xuhao` (`xuhao`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

