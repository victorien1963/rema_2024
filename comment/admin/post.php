<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 131 );
$act = $_POST['act'];
switch ( $act )
{
case "addcattemp" :
				$catid = htmlspecialchars( $_POST['catid'] );
				if ( $catid == "" )
				{
								echo $strZlNTC1;
								exit( );
				}
				$msql->query( "update {P}_comment_cat set `cattemp`='1' where catid='{$catid}'" );
				$chgdb= array('query','detail');
				foreach($chgdb AS $chgname){
				$msql->query( "select * from {P}_base_pageset where coltype='comment' and pagename='{$chgname}'" );
				if ( $msql->next_record( ) )
				{
					$fsql->query( "insert into {P}_base_pageset (`id`, `name`, `coltype`, `pagename`, `th`, `ch`, `bh`, `pagetitle`, `metakey`, `metacon`, `bgcolor`, `bgimage`, `bgposition`, `bgrepeat`, `bgatt`, `containwidth`, `containbg`, `containimg`, `containmargin`, `containpadding`, `containcenter`, `topbg`, `topwidth`, `contentbg`, `contentwidth`, `contentmargin`, `bottombg`, `bottomwidth`, `buildhtml`, `xuhao`) VALUES (NULL,'{$msql->f('name')}','{$msql->f('coltype')}','{$chgname}_{$catid}','{$msql->f('th')}','{$msql->f('ch')}','{$msql->f('bh')}','{$msql->f('pagetitle')}','{$msql->f('metakey')}','{$msql->f('metacon')}','{$msql->f('bgcolor')}','{$msql->f('bgimage')}','{$msql->f('bgposition')}','{$msql->f('bgrepeat')}','{$msql->f('bgatt')}','{$msql->f('containwidth')}','{$msql->f('containbg')}','{$msql->f('containimg')}','{$msql->f('containmargin')}','{$msql->f('containpadding')}','{$msql->f('containcenter')}','{$msql->f('topbg')}','{$msql->f('topwidth')}','{$msql->f('contentbg')}','{$msql->f('contentwidth')}','{$msql->f('contentmargin')}','{$msql->f('bottombg')}','{$msql->f('bottomwidth')}','{$msql->f('buildhtml')}','{$msql->f('xuhao')}') " );
				}
				else
				{
								echo $strZlNTC2;
								exit( );
				}
				
				$msql->query( "select * from {P}_base_plusdefault where coltype='comment' and pluslocat='{$chgname}'" );
				while ( $msql->next_record( ) )
				{
					$fsql->query( "INSERT INTO {P}_base_plusdefault (`id`, `coltype`, `pluslable`, `plusname`, `plustype`, `pluslocat`, `tempname`, `tempcolor`, `showborder`, `bordercolor`, `borderwidth`, `borderstyle`, `borderlable`, `borderroll`, `showbar`, `barbg`, `barcolor`, `backgroundcolor`, `morelink`, `width`, `height`, `top`, `left`, `zindex`, `padding`, `shownums`, `ord`, `sc`, `showtj`, `cutword`, `target`, `catid`, `cutbody`, `picw`, `pich`, `fittype`, `title`, `body`, `pic`, `piclink`, `attach`, `movi`, `sourceurl`, `word`, `word1`, `word2`, `word3`, `word4`, `text`, `text1`, `code`, `link`, `link1`, `link2`, `link3`, `link4`, `tags`, `groupid`, `projid`, `moveable`, `classtbl`, `grouptbl`, `projtbl`, `setglobal`, `overflow`, `bodyzone`, `display`, `ifmul`, `ifrefresh`) VALUES (NULL, '{$msql->f('coltype')}', '{$msql->f('pluslable')}', '{$msql->f('plusname')}', '{$msql->f('plustype')}', '{$chgname}_{$catid}', '{$msql->f('tempname')}', '{$msql->f('tempcolor')}', '{$msql->f('showborder')}', '{$msql->f('bordercolor')}', '{$msql->f('borderwidth')}', '{$msql->f('borderstyle')}', '{$msql->f('borderlable')}', '{$msql->f('borderroll')}', '{$msql->f('showbar')}', '{$msql->f('barbg')}', '{$msql->f('barcolor')}', '{$msql->f('backgroundcolor')}', '{$msql->f('morelink')}', '{$msql->f('width')}', '{$msql->f('height')}', '{$msql->f('top')}', '{$msql->f('left')}', '{$msql->f('zindex')}', '{$msql->f('padding')}', '{$msql->f('shownums')}', '{$msql->f('ord')}', '{$msql->f('sc')}', '{$msql->f('showtj')}', '{$msql->f('cutword')}', '{$msql->f('target')}', '{$msql->f('catid')}', '{$msql->f('cutbody')}', '{$msql->f('picw')}', '{$msql->f('pich')}', '{$msql->f('fittype')}', '{$msql->f('title')}', '{$msql->f('body')}', '{$msql->f('pic')}', '{$msql->f('piclink')}', '{$msql->f('attach')}', '{$msql->f('movi')}', '{$msql->f('sourceurl')}', '{$msql->f('word')}', '{$msql->f('word1')}', '{$msql->f('word2')}', '{$msql->f('word3')}', '{$msql->f('word4')}', '{$msql->f('text')}', '{$msql->f('text1')}', '{$msql->f('code')}', '{$msql->f('link')}', '{$msql->f('link1')}', '{$msql->f('link2')}', '{$msql->f('link3')}', '{$msql->f('link4')}', '{$msql->f('tags')}', '{$msql->f('groupid')}', '{$msql->f('projid')}', '{$msql->f('moveable')}', '{$msql->f('classtbl')}', '{$msql->f('grouptbl')}', '{$msql->f('projtbl')}', '{$msql->f('setglobal')}', '{$msql->f('overflow')}', '{$msql->f('bodyzone')}', '{$msql->f('display')}', '{$msql->f('ifmul')}', '{$msql->f('ifrefresh')}')" );
				}
				}								
				echo "OK";
				exit( );
				break;
case "delcattemp" :
				$catid = htmlspecialchars( $_POST['catid'] );
				if ( $catid == "" )
				{
								echo $strZlNTC1;
								exit( );
				}
				$msql->query( "select catid from {P}_comment_cat where catid='{$catid}'" );
				if ( $msql->next_record( ) )
				{
				}
				else
				{
								echo $strZlNTC2;
								exit( );
				}
				$chgdb= array('query','detail');
				foreach($chgdb AS $chgname){
				$pagename = $chgname."_".$catid;
				$msql->query( "delete from {P}_base_pageset where coltype='comment' and pagename='{$pagename}'" );
				$msql->query( "delete from {P}_base_plusdefault where plustype='comment' and pluslocat='{$pagename}'" );
				$msql->query( "delete from {P}_base_plus where plustype='comment' and pluslocat='{$pagename}'" );
				$msql->query( "update {P}_comment_cat set `cattemp`='0' where catid='{$catid}'" );
				}
				echo "OK";
				exit( );
				break;
}
?>