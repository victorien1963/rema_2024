
delete from `{P}_base_pageset` where `coltype`='paper';
delete from `{P}_base_pageset` where `coltype`='member' and `pagename`='papergl';
delete from `{P}_base_pageset` where `coltype`='member' and `pagename`='paperfabu';
delete from `{P}_base_pageset` where `coltype`='member' and `pagename`='papermodify';
delete from `{P}_base_pageset` where `coltype`='member' and `pagename`='papercat';

delete from `{P}_base_adminauth` where `coltype`='paper';
delete from `{P}_member_secure` where `coltype`='paper';
delete from `{P}_member_centrule` where `coltype`='paper';

delete from `{P}_comment_cat` where `coltype`='paper';

delete from `{P}_base_plusdefault` where `coltype`='paper';
delete from `{P}_base_plustemp` where `pluslable` regexp 'modPaper';

delete from `{P}_base_plus` where `coltype`='paper';
delete from `{P}_base_plus` where `plustype`='paper';
delete from `{P}_base_plus` where `plustype`='member' and `pluslocat`='papergl';
delete from `{P}_base_plus` where `plustype`='member' and `pluslocat`='paperfabu';
delete from `{P}_base_plus` where `plustype`='member' and `pluslocat`='papermodify';
delete from `{P}_base_plus` where `plustype`='member' and `pluslocat`='papercat';

delete from `{P}_base_plusplan` where `coltype`='paper';
delete from `{P}_base_plusplan` where `plustype`='paper';
delete from `{P}_base_plusplanid` where `plustype`='paper';

DROP TABLE IF EXISTS `{P}_paper_cat`;
DROP TABLE IF EXISTS `{P}_paper_con`;
DROP TABLE IF EXISTS `{P}_paper_config`;
DROP TABLE IF EXISTS `{P}_paper_downlog`;
DROP TABLE IF EXISTS `{P}_paper_pages`;
DROP TABLE IF EXISTS `{P}_paper_pcat`;
DROP TABLE IF EXISTS `{P}_paper_proj`;
DROP TABLE IF EXISTS `{P}_paper_prop`;
DROP TABLE IF EXISTS `{P}_paper_nomail`;
DROP TABLE IF EXISTS `{P}_paper_order`;
DROP TABLE IF EXISTS `{P}_paper_cron`;
DROP TABLE IF EXISTS `{P}_paper_cronjobs`;
delete from `{P}_base_coltype` where `coltype`='paper';
