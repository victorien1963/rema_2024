INSERT INTO `{P}_base_coltype` VALUES (0, 'news', '文章模組', '文章', 1, 1, 1, 1, 1, '_news_cat');

INSERT INTO `{P}_base_pageset` VALUES (0, '文章檢索', 'news', 'query', 226, 522, 137, '', '', '', 'rgb(112,128,144)', 'none', '0% 0%', 'repeat', 'scroll', 900, 'rgb(255,255,255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', 'catid', 2, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '文章正文', 'news', 'detail', 228, 741, 139, '', '0', '0', 'rgb(112,128,144)', 'none', '0% 0%', 'repeat', 'scroll', 900, 'rgb(255,255,255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', 'id', 3, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '頻道首頁', 'news', 'main', 230, 451, 151, '', '', '', 'rgb(112,128,144)', 'none', '0% 0%', 'repeat', 'scroll', 900, 'rgb(255,255,255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', 'index', 0, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '會員文章', 'news', 'membernews', 164, 185, 152, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 12, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '文章發佈', 'member', 'newsfabu', 228, 803, 139, '', '', '', 'rgb(112,128,144)', 'none', '0% 0%', 'repeat', 'scroll', 900, 'rgb(255,255,255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 8, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '文章管理', 'member', 'newsgl', 162, 325, 150, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 9, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '文章修改', 'member', 'newsmodify', 164, 808, 152, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 10, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '文章分類', 'member', 'newscat', 147, 267, 150, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 9, 'transparent', 'transparent', 'transparent', '');



INSERT INTO `{P}_base_adminauth` VALUES (0, 'news', 120, '文章模組參數設置', '', 0, 12, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'news', 121, '文章分類', '', 1, 12, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'news', 122, '文章管理', '', 2, 12, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'news', 123, '文章專題設置', '', 3, 12, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'news', 125, '文章發佈', '', 5, 12, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'news', 126, '文章修改', '', 6, 12, '');


INSERT INTO `{P}_member_secure` VALUES (121, 'news', '文章發佈權限', 'func', 6);
INSERT INTO `{P}_member_secure` VALUES (122, 'news', '文章修改權限', 'func', 7);
INSERT INTO `{P}_member_secure` VALUES (123, 'news', '文章發佈/修改免審核權限', 'func', 8);
INSERT INTO `{P}_member_secure` VALUES (124, 'news', '文章圖片上傳權限', 'func', 5);
INSERT INTO `{P}_member_secure` VALUES (125, 'news', '文章附件上傳權限', 'func', 8);
INSERT INTO `{P}_member_secure` VALUES (126, 'news', '文章公共分類投稿授權', 'class', 12);
INSERT INTO `{P}_member_secure` VALUES (127, 'news', '文章自訂分類權限', 'func', 9);
INSERT INTO `{P}_member_secure` VALUES (129, 'news', '文章版主權限(推薦/刪除)', 'banzhu', 9);

INSERT INTO `{P}_member_centrule` VALUES (0, 'news', '發佈文章', 121, 10, 0, 0, 0, 0);
INSERT INTO `{P}_member_centrule` VALUES (0, 'news', '文章被支持', 122, 0, 1, 0, 0, 0);
INSERT INTO `{P}_member_centrule` VALUES (0, 'news', '文章被反對', 123, 0, -1, 0, 0, 0);
INSERT INTO `{P}_member_centrule` VALUES (0, 'news', '文章被版主推薦', 124, 20, 0, 0, 0, 0);
INSERT INTO `{P}_member_centrule` VALUES (0, 'news', '文章被版主刪除並扣分', 125, -20, 0, 0, 0, 0);


INSERT INTO `{P}_comment_cat` VALUES (1, 0, '文章評論', '0001:', 'news', 1, 0, 0, 0, 0);

INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsPicMemo', '文章圖片+標題+摘要', 'all', 'all', 'tpl_newspicmemo.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 300, 320, 0, 0, 99, 5, 3, 'id|dtime|uptime|prop1|prop2|cl', 'desc', 0, 12, '_self', 0, 35, 80, 80, 'fill', '圖片新聞', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_news_cat', '', '_news_proj', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsQuery', '文章翻頁檢索', 'news', 'query', 'tpl_newsquery.htm', '-1', 'A010', '#dddddd', 0, 'solid', '', '', 'none', '#cccccc', '#fff', '#fff', '-1', 600, 500, 30, 200, 90, 10, 20, '-1', '-1', -1, 30, '_self', -1, -1, -1, -1, '-1', '文章檢索', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_news_cat', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsClass', '文章一級分類', 'all', 'all', 'tpl_newsclass.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 200, 0, 0, 90, 12, -1, '-1', '-1', 0, -1, '_self', 0, -1, -1, -1, '-1', '文章分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_news_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsTreeClass', '文章分類（樹形）', 'all', 'all', 'tpl_classtree.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 200, 200, 200, 90, 12, -1, '-1', '-1', 0, -1, '_self', 0, -1, -1, -1, '-1', '文章分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_news_cat', '', '', -1, 'hidden', 'content', 'block', 0, 1);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsProjList', '相關文章(同專題)', 'news', 'detail', 'tpl_newslist.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 200, 0, 0, 90, 12, 5, '-1', '-1', 0, 12, '_self', 0, -1, -1, -1, '-1', '相關文章', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_news_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsAuthorList', '相關文章(同發佈人)', 'news', 'detail', 'tpl_newslist.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 200, 0, 0, 90, 12, 5, '-1', '-1', 0, 12, '_self', 0, -1, -1, -1, '-1', '相關文章', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_news_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsClassFc', '文章逐級分類', 'news', 'query', 'tpl_newsclass.htm', '-1', 'A001', '', 0, 'solid', '', '', 'none', '', '', '#fff', '-1', 200, 200, 0, 0, 90, 12, 99, '-1', '-1', 0, -1, '_self', -1, -1, -1, -1, '-1', '文章分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsList', '文章列表', 'all', 'all', 'tpl_newslist.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '{#RP#}news/class/', 200, 200, 0, 0, 90, 10, 5, 'id|dtime|uptime|prop1|prop2|cl', 'desc', 0, 12, '_self', 0, 50, -1, -1, '-1', '最新文章', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_news_cat', '', '_news_proj', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsContent', '文章正文', 'news', 'detail', 'tpl_newscontent.htm', '-1', '1000', '#dddddd', 1, 'solid', '', '', 'none', '#cccccc', '#fff', '#fff', '-1', 630, 300, 30, 0, 90, 0, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '文章正文', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_news_cat', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsSearchForm', '文章搜索表單', 'news', 'all', 'tpl_news_searchform.htm', '-1', 'A500', '', 0, 'solid', '', '', 'none', '', '', '', '-1', 650, 30, 0, 0, 90, 3, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '文章搜索', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_news_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsComment', '文章評論', 'news', 'detail', 'tpl_news_comment.htm', '-1', '1000', '#dddddd', 1, 'solid', '', '', 'none', '', '', '#fff', 'http://', 630, 300, 300, 0, 90, 1, 5, '-1', '-1', -1, 20, '_self', -1, 120, -1, -1, '-1', '文章評論', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsNavPath', '目前位置提示條', 'news', 'all', 'tpl_navpath.htm', '-1', '1000', '#dddddd', 0, 'solid', '', '', 'none', '#cccccc', '#fff', '#fff', '-1', 650, 30, 0, 200, 90, 0, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '目前位置', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_news_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsProject', '文章專題名稱列表', 'all', 'all', 'tpl_newsproj.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 200, 0, 0, 90, 12, -1, '-1', '-1', -1, 12, '_self', -1, -1, -1, -1, '-1', '最新專題', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsPic', '文章圖片+標題', 'all', 'all', 'tpl_newspic.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 300, 0, 0, 99, 5, 4, 'id|dtime|uptime|prop1|prop2|cl', 'desc', 0, 6, '_self', 0, -1, 160, 120, 'fill', '圖片新聞', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_news_cat', '', '_news_proj', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsHot', '文章人氣榜', 'all', 'all', 'tpl_newshot.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '{#RP#}news/class/index.php?myord=cl', 200, 280, 0, 0, 90, 10, 10, '-1', '-1', 0, 12, '_self', 0, -1, -1, -1, '-1', '文章人氣榜', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_news_cat', '', '_news_proj', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsFabu', '文章發佈表單', 'member', 'newsfabu', 'tpl_news_fabu.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 700, 700, 0, 0, 99, 20, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '文章發佈', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsGl', '文章管理', 'member', 'newsgl', 'tpl_news_gl.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 700, 700, 0, 0, 99, 5, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '文章管理', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsModify', '文章修改表單', 'member', 'newsmodify', 'tpl_news_modify.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 700, 700, 0, 0, 99, 20, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '文章修改', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsMyCat', '文章分類管理', 'member', 'newscat', 'tpl_news_mycat.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 700, 300, 0, 0, 99, 5, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '文章分類管理', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modMemberNewsList', '會員最新文章', 'member', 'homepage', 'tpl_newslist.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '{#RP#}news/membernews.php?mid={#mid#}', 380, 170, 0, 0, 90, 10, 5, 'id|dtime|uptime|prop1|prop2|cl', 'desc', 0, 20, '_self', -1, -1, -1, -1, '-1', '我的文章', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modMemberNewsClass', '會員文章分類', 'news', 'membernews', 'tpl_membernews_class.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 180, 0, 0, 99, 12, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '文章分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modMemberNewsQuery', '會員文章檢索', 'news', 'membernews', 'tpl_newsquery.htm', '-1', 'A010', '#dddddd', 0, 'solid', '', '', 'none', '#cccccc', '#fff', '#fff', '-1', 680, 300, 30, 220, 90, 10, 20, '-1', '-1', -1, 30, '_self', -1, -1, -1, -1, '-1', '會員文章', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modMemberNewsSearchForm', '會員文章搜索', 'news', 'membernews', 'tpl_membernews_searchform.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 175, 0, 0, 99, 15, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '文章搜索', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsHot30', '本月文章人氣榜', 'all', 'all', 'tpl_newshot.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '{#RP#}news/class/index.php?myord=cl', 200, 280, 0, 0, 90, 10, 10, '-1', '-1', 0, 12, '_self', 0, -1, -1, -1, '-1', '本月人氣榜', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_news_cat', '', '_news_proj', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsSameTagList', '相關文章(同標籤)', 'news', 'detail', 'tpl_newslist.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 200, 0, 0, 90, 12, 5, '-1', '-1', 0, 12, '_self', 0, -1, -1, -1, '-1', '相關文章', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_news_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsPicRollx3', '三圖輪播特效', 'all', 'all', 'tpl_newspicrollx3.htm', 'A', '1000', '#dddddd', 0, 'solid', '', '', 'none', '#dddddd', '#fff', '#fff', '-1', 700, 270, 0, 200, 99, 0, -1, '-1', '-1', 0, 12, '_self', 0, 25, -1, -1, '-1', '圖片新聞', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_news_cat', '', '_news_proj', -1, 'hidden', 'content', 'block', 0, 1);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsSameClass', '文章同級分類', 'news', 'query', 'tpl_newsclass.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 200, 0, 0, 90, 12, -1, '-1', '-1', 0, -1, '_self', -1, -1, -1, -1, '-1', '文章分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsPicLb', '文章圖片輪播', 'all', 'all', 'tpl_newspic_lb.htm', '-1', '1000', '', 0, 'solid', '', '', 'none', '', '', '', '-1', 300, 280, 0, 0, 99, 1, 5, 'id|dtime|uptime|prop1|prop2|cl', 'desc', 0, 15, '-1', 0, -1, -1, -1, '-1', '圖片新聞', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '-1', 1, '_news_cat', '', '_news_proj', -1, 'hidden', 'content', 'block', 1, 1);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsTwoClass', '文章二級分類', 'all', 'all', 'tpl_newstwoclass.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 300, 0, 0, 90, 12, -1, '-1', '-1', 0, -1, '_self', 0, -1, -1, -1, '-1', '文章分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_news_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'news', 'modNewsGlobalQuery', '全站翻頁文章列表', 'all', 'all', 'tpl_newsquery.htm', '-1', 'A001', '', 1, 'solid', '', '', 'block', '', '', '#fff', '-1', 650, 350, 0, 0, 90, 15, 10, 'id|dtime|uptime|prop1|prop2|cl|xuhao', 'desc', 0, 20, '_self', 0, 50, -1, -1, '-1', '最新文章', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_news_cat', '', '_news_proj', -1, 'visible', 'content', 'block', 0, 0);


INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsAuthorList', '標題+時間', 'tpl_newslist_time.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsAuthorList', '類別+標題', 'tpl_newslist_cat.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsAuthorList', '標題+摘要', 'tpl_newslist_memo.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsAuthorList', '標題+作者', 'tpl_newslist_author.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsContent', '仿新聞門戶正文風格', 'tpl_newscontent_portal.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsHot', '標題+圖標風格2', 'tpl_newshot2.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsHot', '標題+時間', 'tpl_newshot_time.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsHot', '標題+作者', 'tpl_newshot_author.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsHot', '標題+圖標風格3', 'tpl_newshot3.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsHot', '標題+圖標風格4', 'tpl_newshot4.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsHot', '標題+點選數', 'tpl_newshot_cl.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsHot30', '標題+圖標風格2', 'tpl_newshot2.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsHot30', '標題+時間', 'tpl_newshot_time.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsHot30', '標題+作者', 'tpl_newshot_author.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsHot30', '標題+圖標風格3', 'tpl_newshot3.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsHot30', '標題+圖標風格4', 'tpl_newshot4.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsHot30', '標題+點選數', 'tpl_newshot_cl.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsList', '標題+時間', 'tpl_newslist_time.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsList', '類別+標題', 'tpl_newslist_cat.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsList', '標題+參數列1,2,3', 'tpl_newslist_prop3.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsList', '標題+參數列1,2', 'tpl_newslist_prop2.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsList', '標題+參數列1', 'tpl_newslist_prop1.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsList', '標題+摘要', 'tpl_newslist_memo.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsList', '標題+作者', 'tpl_newslist_author.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsPicMemo', '圖片+標題+兩個參數列', 'tpl_newspicprop_2.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsPicMemo', '圖片+標題+三個參數列', 'tpl_newspicprop.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsProjList', '標題+時間', 'tpl_newslist_time.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsProjList', '類別+標題', 'tpl_newslist_cat.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsProjList', '標題+摘要', 'tpl_newslist_memo.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modNewsProjList', '標題+作者', 'tpl_newslist_author.htm');



CREATE TABLE `{P}_news_cat` (
  `catid` int(12) NOT NULL AUTO_INCREMENT,
  `pid` int(12) NOT NULL DEFAULT '0',
  `cat` char(100) NOT NULL DEFAULT '',
  `xuhao` int(12) NOT NULL DEFAULT '0',
  `catpath` char(255) NOT NULL DEFAULT '',
  `nums` int(20) NOT NULL DEFAULT '0',
  `tj` int(1) NOT NULL DEFAULT '0',
  `ifchannel` int(1) NOT NULL DEFAULT '0',
  `cattemp` int(1) NOT NULL DEFAULT '0',
  `src` varchar(120) NOT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


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
  `tourl` VARCHAR( 100 ) NOT NULL DEFAULT '',
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
INSERT INTO `{P}_news_config` VALUES (98, '主題圖片大圖縮圖的寬高值', 'input', '30', 'PhotoBWH', '1200|1200', '上傳時縮圖的寬高設定,請用「|」間隔，例如：寬|高，1200|1200');
INSERT INTO `{P}_news_config` VALUES (99, '主題圖片小圖縮圖的寬高值', 'input', '30', 'PhotoSWH', '450|450', '上傳時縮圖的寬高設定,請用「|」間隔，例如：寬|高，450|450');



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

