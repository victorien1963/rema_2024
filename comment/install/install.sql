INSERT INTO `{P}_base_coltype` VALUES (0, 'comment', '留言評論', '評論', 1, 1, 1, 1, 1, '_comment_cat');

INSERT INTO `{P}_base_adminauth` VALUES (0, 'comment', 131, '評論分類', '', 1, 13, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'comment', 132, '評論管理', '', 2, 13, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'comment', 130, '評論模組參數設置', '', 0, 13, '');

INSERT INTO `{P}_base_pageset` VALUES (0, '評論詳情', 'comment', 'detail', 226, 909, 137, '', '', '', '', '', '0% 0%', 'repeat', 'scroll', 900, '', '', 10, 10, 'auto', '', '900', 'none transparent scroll repeat 0% 0%', '900', 10, 'none transparent scroll repeat 0% 0%', '900', 'id', 17);
INSERT INTO `{P}_base_pageset` VALUES (0, '評論檢索', 'comment', 'query', 228, 211, 139, '', '0', '0', '', '', '0% 0%', 'repeat', 'scroll', 900, '', '', 10, 10, 'auto', '', '900', 'none transparent scroll repeat 0% 0%', '900', 10, 'none transparent scroll repeat 0% 0%', '900', 'catid', 12);
INSERT INTO `{P}_base_pageset` VALUES (0, '評論頻道首頁', 'comment', 'main', 253, 289, 160, '', '', '', '', '', '0% 0%', 'repeat', 'scroll', 900, '', '', 10, 10, 'auto', '', '900', 'none transparent scroll repeat 0% 0%', '900', 10, 'none transparent scroll repeat 0% 0%', '900', 'index', 11);

CREATE TABLE IF NOT EXISTS `{P}_comment` (
  `id` int(20) NOT NULL auto_increment,
  `pid` int(20) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `rid` int(20) NOT NULL default '0',
  `contype` varchar(30) NOT NULL default 'comment',
  `pname` varchar(100) NOT NULL default '',
  `title` varchar(200) NOT NULL default '',
  `body` text,
  `pj1` int(1) NOT NULL default '3',
  `pj2` int(1) NOT NULL default '3',
  `pj3` int(1) NOT NULL default '3',
  `dtime` int(11) NOT NULL default '0',
  `uptime` int(11) NOT NULL default '0',
  `ip` varchar(16) NOT NULL default '',
  `iffb` int(1) NOT NULL default '0',
  `tuijian` int(1) NOT NULL default '0',
  `cl` int(10) NOT NULL default '0',
  `lastname` varchar(50) NOT NULL default '',
  `lastmemberid` int(12) NOT NULL default '0',
  `backcount` int(12) NOT NULL default '0',
  `picsrc` varchar(255) NOT NULL default '',
  `xuhao` int(5) NOT NULL default '0',
  `memberid` int(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=518 DEFAULT CHARSET=utf8 AUTO_INCREMENT=518 ;

# 
# 導出表中的資料 `{P}_comment`
# 


# --------------------------------------------------------

# 
# 表的結構 `{P}_comment_cat`
# 

CREATE TABLE IF NOT EXISTS `{P}_comment_cat` (
  `catid` int(12) NOT NULL auto_increment,
  `pid` int(6) NOT NULL default '0',
  `cat` varchar(50) NOT NULL default '',
  `catpath` varchar(255) NOT NULL,
  `coltype` varchar(30) NOT NULL default '',
  `xuhao` int(4) NOT NULL default '0',
  `moveable` int(1) NOT NULL default '0',
  `ifbbs` int(1) NOT NULL default '1',
  `ifshow` int(1) NOT NULL default '1',
  PRIMARY KEY  (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8 AUTO_INCREMENT=113 ;

# 
# 導出表中的資料 `{P}_comment_cat`
# 

INSERT INTO `{P}_comment_cat` VALUES (1, 0, '文章評論', '0001:', 'news', 2, 0, 0, 1);
INSERT INTO `{P}_comment_cat` VALUES (112, 0, '網友留言', '0112:', 'comment', 3, 1, 1, 1);

# --------------------------------------------------------

# 
# 表的結構 `{P}_comment_config`
# 

CREATE TABLE IF NOT EXISTS `{P}_comment_config` (
  `xuhao` int(3) NOT NULL default '0',
  `vname` varchar(50) NOT NULL default '',
  `settype` varchar(30) NOT NULL default 'input',
  `colwidth` varchar(3) NOT NULL default '30',
  `variable` varchar(32) NOT NULL default '',
  `value` text NOT NULL,
  `intro` text NOT NULL,
  PRIMARY KEY  (`variable`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# 
# 導出表中的資料 `{P}_comment_config`
# 

INSERT INTO `{P}_comment_config` VALUES (5, '匿名評論是否審核', 'YN', '30', 'noMembercheck', '0', '匿名發表、回覆評論時是否審核');
INSERT INTO `{P}_comment_config` VALUES (7, '評論圖片上傳大小限制(Byte)', 'input', '30', 'EditPicLimit', '204800', '發表評論時，編輯器內上傳圖片大小的限制');
INSERT INTO `{P}_comment_config` VALUES (6, '未登入時是否允許上傳圖片', 'YN', '30', 'NoMemberUpPic', '0', '未登入會員時,是否允許在編輯器內上傳圖片(備註:會員登入後發表評論是否可以上傳圖片，在會員權限中設置)');
INSERT INTO `{P}_comment_config` VALUES (1, '模組頻道名稱', 'input', '30', 'ChannelName', '網友評論', '本模組對應的頻道名稱，如「網友評論」；用於顯示在網頁標題、目前位置提示條等處');
INSERT INTO `{P}_comment_config` VALUES (2, '是否在目前位置提示條顯示模組頻道名稱', 'YN', '30', 'ChannelNameInNav', '1', '是否在目前位置提示條顯示模組頻道名稱');
INSERT INTO `{P}_comment_config` VALUES (8, '評論關鍵詞過濾', 'textarea', '30', 'KeywordDeny', '', '評論禁止的詞語，多個以逗號分割');

# --------------------------------------------------------
