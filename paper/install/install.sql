INSERT INTO `{P}_base_coltype` VALUES (0, 'paper', '電子報模組', '電子報', 1, 1, 1, 1, 1, '_paper_cat');

INSERT INTO `{P}_base_pageset` VALUES (0, '電子報檢索', 'paper', 'query', 226, 522, 137, '', '', '', 'rgb(112,128,144)', 'none', '0% 0%', 'repeat', 'scroll', 900, 'rgb(255,255,255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', 'catid', 2, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '電子報正文', 'paper', 'detail', 228, 741, 139, '', '0', '0', 'rgb(112,128,144)', 'none', '0% 0%', 'repeat', 'scroll', 900, 'rgb(255,255,255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', 'id', 3, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '頻道首頁', 'paper', 'main', 230, 451, 151, '', '', '', 'rgb(112,128,144)', 'none', '0% 0%', 'repeat', 'scroll', 900, 'rgb(255,255,255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', 'index', 0, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '會員電子報', 'paper', 'memberpaper', 164, 185, 152, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 12, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '電子報發佈', 'member', 'paperfabu', 228, 803, 139, '', '', '', 'rgb(112,128,144)', 'none', '0% 0%', 'repeat', 'scroll', 900, 'rgb(255,255,255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 8, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '電子報管理', 'member', 'papergl', 162, 325, 150, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 9, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '電子報修改', 'member', 'papermodify', 164, 808, 152, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 10, 'transparent', 'transparent', 'transparent', '');
INSERT INTO `{P}_base_pageset` VALUES (0, '電子報分類', 'member', 'papercat', 147, 267, 150, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 9, 'transparent', 'transparent', 'transparent', '');



INSERT INTO `{P}_base_adminauth` VALUES (0, 'paper', 817, '電子報模組參數設置', '', 0, 12, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'paper', 814, '電子報分類', '', 1, 12, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'paper', 811, '電子報管理', '', 2, 12, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'paper', 816, '訂閱管理', '', 3, 12, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'paper', 812, '電子報發佈', '', 4, 12, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'paper', 813, '電子報修改', '', 5, 12, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'paper', 815, '電子報專題設置', '', 6, 12, '');

INSERT INTO `{P}_member_secure` VALUES (811, 'paper', '電子報發佈權限', 'func', 6);
INSERT INTO `{P}_member_secure` VALUES (812, 'paper', '電子報修改權限', 'func', 7);
INSERT INTO `{P}_member_secure` VALUES (813, 'paper', '電子報發佈/修改免審核權限', 'func', 8);
INSERT INTO `{P}_member_secure` VALUES (814, 'paper', '電子報圖片上傳權限', 'func', 5);
INSERT INTO `{P}_member_secure` VALUES (815, 'paper', '電子報附件上傳權限', 'func', 8);
INSERT INTO `{P}_member_secure` VALUES (816, 'paper', '電子報公共分類投稿授權', 'class', 12);
INSERT INTO `{P}_member_secure` VALUES (817, 'paper', '電子報自訂分類權限', 'func', 9);
INSERT INTO `{P}_member_secure` VALUES (819, 'paper', '電子報版主權限(推薦/刪除)', 'banzhu', 9);

INSERT INTO `{P}_member_centrule` VALUES (0, 'paper', '發佈電子報', 121, 10, 0, 0, 0, 0);
INSERT INTO `{P}_member_centrule` VALUES (0, 'paper', '電子報被支持', 122, 0, 1, 0, 0, 0);
INSERT INTO `{P}_member_centrule` VALUES (0, 'paper', '電子報被反對', 123, 0, -1, 0, 0, 0);
INSERT INTO `{P}_member_centrule` VALUES (0, 'paper', '電子報被版主推薦', 124, 20, 0, 0, 0, 0);
INSERT INTO `{P}_member_centrule` VALUES (0, 'paper', '電子報被版主刪除並扣分', 125, -20, 0, 0, 0, 0);


INSERT INTO `{P}_comment_cat` VALUES (811, 0, '電子報評論', '0811:', 'paper', 1, 0, 0, 0, 0);

INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperPicMemo', '電子報圖片+標題+摘要', 'all', 'all', 'tpl_paperpicmemo.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 300, 320, 0, 0, 99, 5, 3, 'id|dtime|uptime|prop1|prop2|cl', 'desc', 0, 12, '_self', 0, 35, 80, 80, 'fill', '圖片新聞', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_paper_cat', '', '_paper_proj', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperQuery', '電子報翻頁檢索', 'paper', 'query', 'tpl_paperquery.htm', '-1', 'A010', '#dddddd', 0, 'solid', '', '', 'none', '#cccccc', '#fff', '#fff', '-1', 600, 500, 30, 200, 90, 10, 20, '-1', '-1', -1, 30, '_self', -1, -1, -1, -1, '-1', '電子報檢索', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_paper_cat', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperClass', '電子報一級分類', 'all', 'all', 'tpl_paperclass.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 200, 0, 0, 90, 12, -1, '-1', '-1', 0, -1, '_self', 0, -1, -1, -1, '-1', '電子報分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_paper_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperTreeClass', '電子報分類（樹形）', 'all', 'all', 'tpl_classtree.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 200, 200, 200, 90, 12, -1, '-1', '-1', 0, -1, '_self', 0, -1, -1, -1, '-1', '電子報分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_paper_cat', '', '', -1, 'hidden', 'content', 'block', 0, 1);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperProjList', '相關電子報(同專題)', 'paper', 'detail', 'tpl_paperlist.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 200, 0, 0, 90, 12, 5, '-1', '-1', 0, 12, '_self', 0, -1, -1, -1, '-1', '相關電子報', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_paper_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperAuthorList', '相關電子報(同發佈人)', 'paper', 'detail', 'tpl_paperlist.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 200, 0, 0, 90, 12, 5, '-1', '-1', 0, 12, '_self', 0, -1, -1, -1, '-1', '相關電子報', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_paper_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperClassFc', '電子報逐級分類', 'paper', 'query', 'tpl_paperclass.htm', '-1', 'A001', '', 0, 'solid', '', '', 'none', '', '', '#fff', '-1', 200, 200, 0, 0, 90, 12, 99, '-1', '-1', 0, -1, '_self', -1, -1, -1, -1, '-1', '電子報分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperList', '電子報列表', 'all', 'all', 'tpl_paperlist.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '{#RP#}paper/class/', 200, 200, 0, 0, 90, 10, 5, 'id|dtime|uptime|prop1|prop2|cl', 'desc', 0, 12, '_self', 0, 50, -1, -1, '-1', '最新電子報', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_paper_cat', '', '_paper_proj', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperContent', '電子報正文', 'paper', 'detail', 'tpl_papercontent.htm', '-1', '1000', '#dddddd', 1, 'solid', '', '', 'none', '#cccccc', '#fff', '#fff', '-1', 630, 300, 30, 0, 90, 0, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '電子報正文', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_paper_cat', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperSearchForm', '電子報搜索表單', 'paper', 'all', 'tpl_paper_searchform.htm', '-1', 'A500', '', 0, 'solid', '', '', 'none', '', '', '', '-1', 650, 30, 0, 0, 90, 3, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '電子報搜索', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_paper_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperComment', '電子報評論', 'paper', 'detail', 'tpl_paper_comment.htm', '-1', '1000', '#dddddd', 1, 'solid', '', '', 'none', '', '', '#fff', 'http://', 630, 300, 300, 0, 90, 1, 5, '-1', '-1', -1, 20, '_self', -1, 120, -1, -1, '-1', '電子報評論', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperNavPath', '目前的位置提示條', 'paper', 'all', 'tpl_navpath.htm', '-1', '1000', '#dddddd', 0, 'solid', '', '', 'none', '#cccccc', '#fff', '#fff', '-1', 650, 30, 0, 200, 90, 0, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '目前的位置', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_paper_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperProject', '電子報專題名稱列表', 'all', 'all', 'tpl_paperproj.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 200, 0, 0, 90, 12, -1, '-1', '-1', -1, 12, '_self', -1, -1, -1, -1, '-1', '最新專題', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperPic', '電子報圖片+標題', 'all', 'all', 'tpl_paperpic.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 300, 0, 0, 99, 5, 4, 'id|dtime|uptime|prop1|prop2|cl', 'desc', 0, 6, '_self', 0, -1, 160, 120, 'fill', '圖片新聞', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_paper_cat', '', '_paper_proj', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperHot', '電子報人氣榜', 'all', 'all', 'tpl_paperhot.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '{#RP#}paper/class/index.php?myord=cl', 200, 280, 0, 0, 90, 10, 10, '-1', '-1', 0, 12, '_self', 0, -1, -1, -1, '-1', '電子報人氣榜', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_paper_cat', '', '_paper_proj', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperFabu', '電子報發佈表單', 'member', 'paperfabu', 'tpl_paper_fabu.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 700, 700, 0, 0, 99, 20, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '電子報發佈', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperGl', '電子報管理', 'member', 'papergl', 'tpl_paper_gl.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 700, 700, 0, 0, 99, 5, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '電子報管理', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperModify', '電子報修改表單', 'member', 'papermodify', 'tpl_paper_modify.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 700, 700, 0, 0, 99, 20, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '電子報修改', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperMyCat', '電子報分類管理', 'member', 'papercat', 'tpl_paper_mycat.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 700, 300, 0, 0, 99, 5, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '電子報分類管理', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modMemberPaperList', '會員最新電子報', 'member', 'homepage', 'tpl_paperlist.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '{#RP#}paper/memberpaper.php?mid={#mid#}', 380, 170, 0, 0, 90, 10, 5, 'id|dtime|uptime|prop1|prop2|cl', 'desc', 0, 20, '_self', -1, -1, -1, -1, '-1', '我的電子報', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modMemberPaperClass', '會員電子報分類', 'paper', 'memberpaper', 'tpl_memberpaper_class.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 180, 0, 0, 99, 12, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '電子報分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modMemberPaperQuery', '會員電子報檢索', 'paper', 'memberpaper', 'tpl_paperquery.htm', '-1', 'A010', '#dddddd', 0, 'solid', '', '', 'none', '#cccccc', '#fff', '#fff', '-1', 680, 300, 30, 220, 90, 10, 20, '-1', '-1', -1, 30, '_self', -1, -1, -1, -1, '-1', '會員電子報', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modMemberPaperSearchForm', '會員電子報搜索', 'paper', 'memberpaper', 'tpl_memberpaper_searchform.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 175, 0, 0, 99, 15, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '電子報搜索', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperHot30', '本月電子報人氣榜', 'all', 'all', 'tpl_paperhot.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '{#RP#}paper/class/index.php?myord=cl', 200, 280, 0, 0, 90, 10, 10, '-1', '-1', 0, 12, '_self', 0, -1, -1, -1, '-1', '本月人氣榜', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_paper_cat', '', '_paper_proj', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperSameTagList', '相關電子報(同標籤)', 'paper', 'detail', 'tpl_paperlist.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 200, 0, 0, 90, 12, 5, '-1', '-1', 0, 12, '_self', 0, -1, -1, -1, '-1', '相關電子報', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_paper_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperPicRollx3', '三圖輪播特效', 'all', 'all', 'tpl_paperpicrollx3.htm', 'A', '1000', '#dddddd', 0, 'solid', '', '', 'none', '#dddddd', '#fff', '#fff', '-1', 700, 270, 0, 200, 99, 0, -1, '-1', '-1', 0, 12, '_self', 0, 25, -1, -1, '-1', '圖片新聞', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_paper_cat', '', '_paper_proj', -1, 'hidden', 'content', 'block', 0, 1);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperSameClass', '電子報同級分類', 'paper', 'query', 'tpl_paperclass.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 200, 0, 0, 90, 12, -1, '-1', '-1', 0, -1, '_self', -1, -1, -1, -1, '-1', '電子報分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperPicLb', '電子報圖片輪播', 'all', 'all', 'tpl_paperpic_lb.htm', '-1', '1000', '', 0, 'solid', '', '', 'none', '', '', '', '-1', 300, 280, 0, 0, 99, 1, 5, 'id|dtime|uptime|prop1|prop2|cl', 'desc', 0, 15, '-1', 0, -1, -1, -1, '-1', '圖片新聞', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '-1', 1, '_paper_cat', '', '_paper_proj', -1, 'hidden', 'content', 'block', 1, 1);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperTwoClass', '電子報二級分類', 'all', 'all', 'tpl_papertwoclass.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 300, 0, 0, 90, 12, -1, '-1', '-1', 0, -1, '_self', 0, -1, -1, -1, '-1', '電子報分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_paper_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'paper', 'modPaperOrder', '訂閱電子報','all', 'all', 'tpl_paperorder.htm', '-1', '1000', '#dddddd', 1, 'solid', '', '', 'none', '#cccccc', '#fff', '#fff', '-1', 630, 300, 30, 0, 90, 0, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '訂閱/取消電子報', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);


INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperAuthorList', '標題+時間', 'tpl_paperlist_time.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperAuthorList', '類別+標題', 'tpl_paperlist_cat.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperAuthorList', '標題+摘要', 'tpl_paperlist_memo.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperAuthorList', '標題+作者', 'tpl_paperlist_author.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperContent', '仿新聞門戶正文風格', 'tpl_papercontent_portal.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperHot', '標題+圖標風格2', 'tpl_paperhot2.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperHot', '標題+時間', 'tpl_paperhot_time.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperHot', '標題+作者', 'tpl_paperhot_author.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperHot', '標題+圖標風格3', 'tpl_paperhot3.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperHot', '標題+圖標風格4', 'tpl_paperhot4.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperHot', '標題+點選數', 'tpl_paperhot_cl.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperHot30', '標題+圖標風格2', 'tpl_paperhot2.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperHot30', '標題+時間', 'tpl_paperhot_time.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperHot30', '標題+作者', 'tpl_paperhot_author.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperHot30', '標題+圖標風格3', 'tpl_paperhot3.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperHot30', '標題+圖標風格4', 'tpl_paperhot4.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperHot30', '標題+點選數', 'tpl_paperhot_cl.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperList', '標題+時間', 'tpl_paperlist_time.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperList', '類別+標題', 'tpl_paperlist_cat.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperList', '標題+參數列1,2,3', 'tpl_paperlist_prop3.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperList', '標題+參數列1,2', 'tpl_paperlist_prop2.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperList', '標題+參數列1', 'tpl_paperlist_prop1.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperList', '標題+摘要', 'tpl_paperlist_memo.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperList', '標題+作者', 'tpl_paperlist_author.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperPicMemo', '圖片+標題+兩個參數列', 'tpl_paperpicprop_2.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperPicMemo', '圖片+標題+三個參數列', 'tpl_paperpicprop.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperProjList', '標題+時間', 'tpl_paperlist_time.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperProjList', '類別+標題', 'tpl_paperlist_cat.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperProjList', '標題+摘要', 'tpl_paperlist_memo.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperProjList', '標題+作者', 'tpl_paperlist_author.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modPaperOrder', '訂閱電子報含分類頻道', 'tpl_paperorder_cat.htm');

CREATE TABLE `{P}_paper_cat` (
  `catid` int(12) NOT NULL auto_increment,
  `pid` int(12) NOT NULL default '0',
  `cat` char(100) NOT NULL default '',
  `xuhao` int(12) NOT NULL default '0',
  `catpath` char(255) NOT NULL default '',
  `nums` int(20) NOT NULL default '0',
  `tj` int(1) NOT NULL default '0',
  `ifchannel` int(1) NOT NULL default '0',
  `cattemp` int(1) NOT NULL default '0',
  PRIMARY KEY  (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `{P}_paper_con` (
  `id` int(12) NOT NULL auto_increment,
  `catid` int(12) NOT NULL default '0',
  `catpath` varchar(255) NOT NULL default '',
  `pcatid` int(12) NOT NULL default '0',
  `contype` varchar(20) NOT NULL default 'paper',
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


CREATE TABLE `{P}_paper_config` (
  `xuhao` int(3) NOT NULL default '0',
  `vname` varchar(50) NOT NULL default '',
  `settype` varchar(30) NOT NULL default 'input',
  `colwidth` varchar(3) NOT NULL default '30',
  `variable` varchar(32) NOT NULL default '',
  `value` text NOT NULL,
  `intro` text NOT NULL,
  PRIMARY KEY  (`variable`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `{P}_paper_config` VALUES (1, '模組功能名稱', 'input', '30', 'ChannelName', '電子報', '本模組對應的功能名稱，如「電子E報」；用於顯示在網頁標題、目前的位置提示條等處');
INSERT INTO `{P}_paper_config` VALUES (2, '是否在目前的位置提示條顯示模組功能名稱', 'YN', '30', 'ChannelNameInNav', '1', '是否在目前的位置提示條顯示模組功能名稱');
INSERT INTO `{P}_paper_config` VALUES (5, '電子報主題圖片上傳尺寸限制(Byte)', 'input', '30', 'PicSizeLimit', '256000', '會員發佈電子報上傳主題圖片時,單個圖片尺寸的限制');
INSERT INTO `{P}_paper_config` VALUES (6, '電子報編輯器圖片上傳限制(Byte)', 'input', '30', 'EditPicLimit', '512000', '會員發佈電子報時,在編輯器內上傳圖片,單個圖片的尺寸限制');
INSERT INTO `{P}_paper_config` VALUES (7, '附件上傳大小限制', 'input', '30', 'FileSizeLimit', '1024000', '會員發佈電子報上傳附件時,允許上傳附件的文件大小;但最高設置不能超過2M ');
INSERT INTO `{P}_paper_config` VALUES (8, '會員發佈電子報關鍵詞過濾', 'textarea', '30', 'KeywordDeny', '幹你,你娘,肏,fuck,shit', '會員發佈電子報時禁止的詞語，多個以逗號分割');
INSERT INTO `{P}_paper_config` VALUES (9, '伺服器登入帳號', 'input', '30', 'CpanelUser', '', 'Cpanel 主機伺服器登入帳號');
INSERT INTO `{P}_paper_config` VALUES (10, '伺服器登入密碼', 'input', '30', 'CpanelPasswd', '', 'Cpanel 主機伺服器登入密碼');
INSERT INTO `{P}_paper_config` VALUES (11, '伺服器連接埠', 'input', '30', 'CpanelPort', '2083', '伺服器連接埠，Cpanel多半為 2082 或 SSL連線的 2083');

CREATE TABLE `{P}_paper_downlog` (
  `id` int(12) NOT NULL auto_increment,
  `paperid` int(12) NOT NULL default '0',
  `memberid` int(12) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




CREATE TABLE `{P}_paper_pages` (
  `id` int(12) NOT NULL auto_increment,
  `paperid` int(12) NOT NULL default '0',
  `body` text NOT NULL,
  `xuhao` int(5) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




CREATE TABLE `{P}_paper_pcat` (
  `catid` int(12) NOT NULL auto_increment,
  `memberid` int(12) NOT NULL default '0',
  `pid` int(12) NOT NULL default '0',
  `cat` char(100) NOT NULL default '',
  `xuhao` int(12) NOT NULL default '0',
  `catpath` char(255) NOT NULL default '',
  PRIMARY KEY  (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE `{P}_paper_proj` (
  `id` int(12) NOT NULL auto_increment,
  `project` varchar(100) default NULL,
  `folder` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `{P}_paper_prop` (
  `id` int(20) NOT NULL auto_increment,
  `catid` int(20) NOT NULL default '0',
  `propname` char(30) default NULL,
  `xuhao` int(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `xuhao` (`xuhao`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{P}_paper_order` (
  `id` int(11) NOT NULL auto_increment,
  `is_member` int(1) NOT NULL default '0',
  `member_id` int(11) NOT NULL default '0',
  `member_type` int(11) NOT NULL default '0',
  `is_order` int(1) NOT NULL default '1',
  `order_cat` varchar(255) NOT NULL default 'all',
  `email` varchar(255) NOT NULL default '',
  `dtime` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `{P}_paper_cron` (
  `id` int(12) NOT NULL auto_increment,
  `pid` int(12) NOT NULL default '0',
  `cat` char(100) NOT NULL default '',
  `items` int(12) NOT NULL default '0',
  `nums` int(20) NOT NULL default '0',
  `sendnums` int(20) NOT NULL default '0',
  `ifclose` INT(1) NOT NULL DEFAULT '0',
  `dtime` int(10) NOT NULL default '0',
  `linekey` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `{P}_paper_cronjobs` (
  `id` int(12) NOT NULL auto_increment,
  `pid` int(12) NOT NULL default '0',
  `email` longtext NOT NULL default '',
  `alltimes` int(12) NOT NULL default '0',
  `nowtimes` int(20) NOT NULL default '0',
  `ifsend` int(1) NOT NULL default '0',
  `dtime` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;