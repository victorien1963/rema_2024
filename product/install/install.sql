
INSERT INTO `{P}_base_coltype` VALUES (0, 'product', '布料展示', '布料', 1, 1, 1, 1, 1, '_product_cat');

INSERT INTO `{P}_base_pageset` VALUES (0, '布料頻道首頁', 'product', 'main', 226, 392, 137, '', '', '', 'rgb(112,128,144)', 'none', '0% 0%', 'repeat', 'scroll', 900, 'rgb(255,255,255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', 'index', 1, 'transparent', 'transparent', 'transparent');
INSERT INTO `{P}_base_pageset` VALUES (0, '布料查詢', 'product', 'query', 230, 515, 151, '', '', '', 'rgb(112,128,144)', 'none', '0% 0%', 'repeat', 'scroll', 900, 'rgb(255,255,255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', 'catid', 2, 'transparent', 'transparent', 'transparent');
INSERT INTO `{P}_base_pageset` VALUES (0, '布料詳情', 'product', 'detail', 164, 1172, 152, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', 'id', 3, 'transparent', 'transparent', 'transparent');
INSERT INTO `{P}_base_pageset` VALUES (0, '會員布料', 'product', 'memberproduct', 164, 290, 152, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 12, 'transparent', 'transparent', 'transparent');
INSERT INTO `{P}_base_pageset` VALUES (0, '布料管理', 'member', 'productgl', 162, 267, 150, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 1, 'transparent', 'transparent', 'transparent');
INSERT INTO `{P}_base_pageset` VALUES (0, '布料發佈', 'member', 'productfabu', 164, 435, 152, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 0, 'transparent', 'transparent', 'transparent');
INSERT INTO `{P}_base_pageset` VALUES (0, '布料修改', 'member', 'productmodify', 164, 493, 152, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 0, 'transparent', 'transparent', 'transparent');
INSERT INTO `{P}_base_pageset` VALUES (0, '布料分類', 'member', 'productcat', 147, 267, 150, '', '', '', 'rgb(112, 128, 144)', '', 'center top', 'repeat', 'fixed', 900, 'rgb(255, 255, 255)', '', 10, 10, 'auto', 'transparent', '900', 'transparent', '900', 10, 'transparent', '900', '0', 9, 'transparent', 'transparent', 'transparent');


INSERT INTO `{P}_base_adminauth` VALUES (0, 'product', 180, '布料模組參數設置', '', 0, 15, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'product', 181, '布料分類', '', 1, 15, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'product', 182, '布料管理', '', 2, 15, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'product', 183, '布料專題設置', '', 3, 15, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'product', 185, '布料發佈', '', 5, 15, '');
INSERT INTO `{P}_base_adminauth` VALUES (0, 'product', 186, '布料修改', '', 6, 15, '');

INSERT INTO `{P}_member_secure` VALUES (181, 'product', '會員布料發佈權限', 'func', 6);
INSERT INTO `{P}_member_secure` VALUES (182, 'product', '會員布料修改權限', 'func', 7);
INSERT INTO `{P}_member_secure` VALUES (183, 'product', '會員布料發佈/修改免審核權限', 'func', 8);
INSERT INTO `{P}_member_secure` VALUES (184, 'product', '會員布料介紹編輯器圖片上傳權限', 'func', 9);
INSERT INTO `{P}_member_secure` VALUES (186, 'product', '會員布料公共分類發佈授權', 'class', 11);
INSERT INTO `{P}_member_secure` VALUES (187, 'product', '會員布料自訂分類權限', 'func', 9);
INSERT INTO `{P}_member_secure` VALUES (189, 'product', '布料版主管理權限(推薦/刪除)', 'banzhu', 9);

INSERT INTO `{P}_member_centrule` VALUES (0, 'product', '發佈布料', 181, 10, 0, 0, 0, 0);
INSERT INTO `{P}_member_centrule` VALUES (0, 'product', '布料被支持', 182, 0, 1, 0, 0, 0);
INSERT INTO `{P}_member_centrule` VALUES (0, 'product', '布料被反對', 183, 0, -1, 0, 0, 0);
INSERT INTO `{P}_member_centrule` VALUES (0, 'product', '布料被版主推薦', 184, 20, 0, 0, 0, 0);
INSERT INTO `{P}_member_centrule` VALUES (0, 'product', '布料被版主刪除並扣分', 185, -20, 0, 0, 0, 0);


INSERT INTO `{P}_comment_cat` VALUES (4, 0, '布料評論', '0004:', 'product', 4, 0, 0, 1, 0);


INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductQuery', '布料檢索搜索', 'product', 'query', 'tpl_product_query.htm', '-1', '1000', '#dddddd', 0, 'solid', '', '', 'none', '#cccccc', '#fff', '#fff', '-1', 680, 500, 30, 200, 90, 5, 20, '-1', '-1', -1, 30, '_self', -1, 30, 120, 120, 'fill', '布料檢索', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_product_cat', '', '', -1, 'visible', 'content', 'block', 0, 1);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductContent', '布料詳情', 'product', 'detail', 'tpl_product_content.htm', '-1', '1000', '', 0, 'solid', '', '', 'none', '', '', '', '-1', 650, 300, 30, 0, 90, 0, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '布料詳情', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_product_cat', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductClass', '布料分類（列表）', 'all', 'all', 'tpl_productclass.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 200, 0, 0, 90, 12, -1, '-1', '-1', 0, -1, '_self', 0, -1, -1, -1, '-1', '布料分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_product_cat', '', '', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductList', '自選布料列表', 'all', 'all', 'tpl_productlist.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '{#RP#}product/class/', 300, 350, 0, 0, 90, 10, 5, 'id|dtime|uptime|prop1|prop2|cl', 'desc', 0, 12, '_self', 0, 30, 80, 80, 'fill', '最新布料', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_product_cat', '', '_product_proj', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductSearchForm', '布料搜索表單', 'product', 'all', 'tpl_product_searchform.htm', '-1', 'A500', '', 0, 'solid', '', '', 'none', '', '', '', '-1', 650, 30, 0, 200, 90, 3, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '布料搜索', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_product_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductNavPath', '目前位置提示條', 'product', 'all', 'tpl_navpath.htm', '-1', '1000', '#dddddd', 0, 'solid', '', '', 'none', '#cccccc', '#fff', '#fff', '-1', 650, 30, 0, 200, 90, 0, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '目前位置', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_product_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductProject', '布料專題（列表）', 'all', 'all', 'tpl_productproj.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 200, 0, 0, 90, 12, -1, '-1', '-1', -1, 12, '_self', -1, -1, -1, -1, '-1', '最新專題', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductProjList', '相關布料(同專題)', 'product', 'detail', 'tpl_productpic.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 300, 0, 0, 90, 10, 6, '-1', '-1', 0, 12, '_self', 0, -1, 100, 100, 'fill', '相關布料', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_product_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductClassFc', '布料逐級分類', 'product', 'query', 'tpl_productclass.htm', '-1', 'A001', '', 0, 'solid', '', '', 'none', '', '#fff', '#fff', '-1', 200, 200, 0, 0, 90, 12, 99, '-1', '-1', 0, -1, '_self', -1, -1, -1, -1, '-1', '布料分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductComment', '布料評論', 'product', 'detail', 'tpl_product_comment.htm', '-1', '1000', '#dddddd', 1, 'solid', '', '', 'none', '', '', '#fff', 'http://', 650, 350, 350, 0, 90, 1, 5, '-1', '-1', -1, 20, '_self', -1, 120, -1, -1, '-1', '布料評論', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductFabu', '布料發佈表單', 'member', 'productfabu', 'tpl_product_fabu.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 700, 700, 0, 0, 99, 20, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '布料發佈', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductGl', '布料管理', 'member', 'productgl', 'tpl_product_gl.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 700, 700, 0, 0, 99, 5, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '布料管理', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductModify', '布料修改表單', 'member', 'productmodify', 'tpl_product_modify.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 700, 700, 0, 0, 99, 20, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '布料修改', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductMyCat', '布料分類管理', 'member', 'productcat', 'tpl_product_mycat.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 700, 300, 0, 0, 99, 5, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '布料分類管理', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modMemberProductPic', '會員最新布料', 'member', 'homepage', 'tpl_productpic.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '{#RP#}product/memberproduct.php?mid={#mid#}', 500, 200, 0, 0, 90, 10, 10, 'id|dtime|uptime|prop1|prop2|cl', 'desc', 0, 7, '_self', -1, -1, 120, 120, 'fill', '我的布料', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 1, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modMemberProductClass', '會員布料分類', 'product', 'memberproduct', 'tpl_memberproduct_class.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 200, 0, 0, 99, 12, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '布料分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modMemberProductQuery', '會員布料檢索', 'product', 'memberproduct', 'tpl_product_query.htm', '-1', '1000', '#dddddd', 0, 'solid', '', '', 'none', '#cccccc', '#fff', '#fff', '-1', 650, 350, 0, 220, 99, 0, 20, '-1', '-1', -1, -1, '-1', -1, -1, 120, 120, 'fill', '布料檢索', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'visible', 'content', 'block', 0, 1);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modMemberProductSearchForm', '會員布料搜索', 'product', 'memberproduct', 'tpl_memberproduct_searchform.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 175, 0, 0, 99, 15, -1, '-1', '-1', -1, -1, '-1', -1, -1, -1, -1, '-1', '布料搜索', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductAuthorList', '相關布料(同發佈人)', 'product', 'detail', 'tpl_productpic.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 300, 0, 0, 90, 10, 6, '-1', '-1', 0, 12, '_self', 0, -1, 100, 100, 'fill', '相關布料', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_product_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductSameTagList', '相關布料(同標籤)', 'product', 'detail', 'tpl_productpic.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', 'http://', 200, 300, 0, 0, 90, 10, 6, '-1', '-1', 0, 12, '_self', 0, -1, 100, 100, 'fill', '相關布料', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_product_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductRollx3', '布料三圖輪播特效', 'all', 'all', 'tpl_productrollx3.htm', 'A', '1000', '#dddddd', 0, 'solid', '', '', 'none', '#dddddd', '#fff', '#fff', '-1', 700, 270, 0, 200, 99, 0, -1, '-1', '-1', 0, 12, '_self', 0, 25, -1, -1, '-1', '布料圖片特效', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_product_cat', '', '_product_proj', -1, 'hidden', 'content', 'block', 0, 1);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductSameClass', '布料同級分類', 'product', 'query', 'tpl_productclass.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 200, 0, 0, 90, 12, -1, '-1', '-1', 0, -1, '_self', -1, -1, -1, -1, '-1', '布料分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductCarousel', '布料圖片旋轉特效', 'all', 'all', 'tpl_productcarousel_cyrano.htm', '-1', '1000', '#dddddd', 0, 'solid', '', '', 'none', '#dddddd', '#fff', '#fff', '-1', 600, 225, 0, 200, 99, 0, -1, '-1', '-1', 0, -1, '_self', 0, -1, 180, 180, '-1', '布料圖片特效', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_product_cat', '', '_product_proj', -1, 'hidden', 'content', 'block', 0, 1);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductTwoClass', '布料二級分類', 'all', 'all', 'tpl_producttwoclass.htm', '-1', 'A001', '#dddddd', 1, 'solid', '', '', 'block', '#cccccc', '#fff', '#fff', '-1', 200, 300, 0, 0, 90, 12, -1, '-1', '-1', 0, -1, '_self', 0, -1, -1, -1, '-1', '布料分類', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', 1, '_product_cat', '', '', -1, 'hidden', 'content', 'block', 0, 0);
INSERT INTO `{P}_base_plusdefault` VALUES (0, 'product', 'modProductGlobalQuery', '全站翻頁布料列表', 'all', 'all', 'tpl_product_query.htm', '-1', 'A001', '', 1, 'solid', '', '', 'block', '', '', '#fff', '-1', 650, 350, 0, 0, 90, 15, 10, 'id|dtime|uptime|prop1|prop2|cl|xuhao', 'desc', 0, 12, '_self', 0, 50, 180, 160, 'fill', '最新布料', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '', '-1', '0', 1, '_product_cat', '', '_product_proj', -1, 'visible', 'content', 'block', 0, 0);


INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductSearchForm', '豎式搜索表單', 'tpl_product_searchform_h.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductTwoClass', '布料二級分類緊湊型風格', 'tpl_producttwoclass_1.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductList', '布料名稱+圖片+簡介(每行兩個布料)', 'tpl_productlist_1.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductList', '布料名稱+圖片+參數列(每行兩個布料)', 'tpl_productlist_2.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductList', '布料名稱+圖片+簡介+參數列(每行兩個布料)', 'tpl_productlist_3.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductList', '布料名稱+圖片+簡介(每行三個布料)', 'tpl_productlist_4.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductList', '布料名稱+圖片+參數列(每行三個布料)', 'tpl_productlist_5.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductList', '布料名稱+圖片+參數列(文字在圖下方，每行布料數自動)', 'tpl_productlist_6.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductGlobalQuery', '圖片 名稱 介紹(圖片居左)', 'tpl_product_query_dolphin.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductQuery', '布料名稱+圖片+簡介(每行兩個布料)', 'tpl_product_query_1.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductQuery', '布料名稱+圖片+參數列(每行兩個布料)', 'tpl_product_query_2.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductQuery', '布料名稱+圖片+簡介+參數列(每行兩個布料)', 'tpl_product_query_3.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductQuery', '布料名稱+圖片+簡介(每行三個布料)', 'tpl_product_query_4.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductQuery', '布料名稱+圖片+參數列(每行三個布料)', 'tpl_product_query_5.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductQuery', '布料名稱+圖片+參數列(文字在圖下方，每行布料數自動)', 'tpl_product_query_6.htm');
INSERT INTO `{P}_base_plustemp` VALUES (0, 'modProductContent', '會員互動型布料詳情風格', 'tpl_product_content_1.htm');


CREATE TABLE `{P}_product_cat` (
  `catid` int(12) NOT NULL auto_increment,
  `pid` int(12) default NULL,
  `cat` char(100) default NULL,
  `xuhao` int(12) default NULL,
  `catpath` char(255) default NULL,
  `nums` int(20) default NULL,
  `tj` int(1) NOT NULL default '0',
  `ifchannel` int(1) NOT NULL default '0',
  PRIMARY KEY  (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `{P}_product_con` (
  `id` int(12) NOT NULL auto_increment,
  `catid` int(12) NOT NULL default '0',
  `catpath` varchar(255) NOT NULL default '',
  `pcatid` int(12) NOT NULL default '0',
  `contype` varchar(20) NOT NULL default 'product',
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
  `tags` varchar(255) NOT NULL,
  `zhichi` int(5) NOT NULL default '0',
  `fandui` int(5) NOT NULL default '0',
  `tplog` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `{P}_product_config` (
  `xuhao` int(3) NOT NULL default '0',
  `vname` varchar(50) NOT NULL default '',
  `settype` varchar(30) NOT NULL default 'input',
  `colwidth` varchar(3) NOT NULL default '30',
  `variable` varchar(32) NOT NULL default '',
  `value` text NOT NULL,
  `intro` text NOT NULL,
  PRIMARY KEY  (`variable`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{P}_product_config` VALUES (1, '模組頻道名稱', 'input', '30', 'ChannelName', '布料展示', '本模組對應的頻道名稱，如「布料展示」；用於顯示在網頁標題、目前位置提示條等處');
INSERT INTO `{P}_product_config` VALUES (2, '是否在目前位置提示條顯示模組頻道名稱', 'YN', '30', 'ChannelNameInNav', '1', '是否在目前位置提示條顯示模組頻道名稱');
INSERT INTO `{P}_product_config` VALUES (5, '會員上傳布料圖片大小限制(Byte)', 'input', '30', 'PicSizeLimit', '256000', '會員上傳布料圖片時,單個圖片大小的限制');
INSERT INTO `{P}_product_config` VALUES (6, '布料介紹編輯器圖片上傳限制(Byte)', 'input', '30', 'EditPicLimit', '512000', '會員發佈布料時,在編輯器內上傳圖片,單個圖片的大小限制');


CREATE TABLE `{P}_product_pages` (
  `id` int(12) NOT NULL auto_increment,
  `productid` int(12) NOT NULL default '0',
  `src` varchar(150) NOT NULL default '',
  `xuhao` int(5) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `{P}_product_pcat` (
  `catid` int(12) NOT NULL auto_increment,
  `memberid` int(12) NOT NULL default '0',
  `pid` int(12) NOT NULL default '0',
  `cat` char(100) NOT NULL default '',
  `xuhao` int(12) NOT NULL default '0',
  `catpath` char(255) NOT NULL default '',
  PRIMARY KEY  (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `{P}_product_proj` (
  `id` int(12) NOT NULL auto_increment,
  `project` varchar(100) default NULL,
  `folder` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `{P}_product_prop` (
  `id` int(20) NOT NULL auto_increment,
  `catid` int(20) NOT NULL default '0',
  `propname` char(30) default NULL,
  `xuhao` int(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `xuhao` (`xuhao`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

