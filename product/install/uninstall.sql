
delete from `{P}_base_pageset` where `coltype`='product';
delete from `{P}_base_pageset` where `coltype`='member' and `pagename`='productgl';
delete from `{P}_base_pageset` where `coltype`='member' and `pagename`='productfabu';
delete from `{P}_base_pageset` where `coltype`='member' and `pagename`='productmodify';
delete from `{P}_base_pageset` where `coltype`='member' and `pagename`='productcat';

delete from `{P}_base_adminauth` where `coltype`='product';
delete from `{P}_member_secure` where `coltype`='product';
delete from `{P}_member_centrule` where `coltype`='product';

delete from `{P}_comment_cat` where `coltype`='product';

delete from `{P}_base_plusdefault` where `coltype`='product';
delete from `{P}_base_plustemp` where `pluslable` regexp 'modProduct';

delete from `{P}_base_plus` where `coltype`='product';
delete from `{P}_base_plus` where `plustype`='product';
delete from `{P}_base_plus` where `plustype`='member' and `pluslocat`='productgl';
delete from `{P}_base_plus` where `plustype`='member' and `pluslocat`='productfabu';
delete from `{P}_base_plus` where `plustype`='member' and `pluslocat`='productmodify';
delete from `{P}_base_plus` where `plustype`='member' and `pluslocat`='productcat';

delete from `{P}_base_plusplan` where `coltype`='product';
delete from `{P}_base_plusplan` where `plustype`='product';
delete from `{P}_base_plusplanid` where `plustype`='product';

DROP TABLE IF EXISTS `{P}_product_cat`;
DROP TABLE IF EXISTS `{P}_product_con`;
DROP TABLE IF EXISTS `{P}_product_config`;
DROP TABLE IF EXISTS `{P}_product_pages`;
DROP TABLE IF EXISTS `{P}_product_pcat`;
DROP TABLE IF EXISTS `{P}_product_proj`;
DROP TABLE IF EXISTS `{P}_product_prop`;

delete from `{P}_base_coltype` where `coltype`='product';
