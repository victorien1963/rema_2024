<?php
define( "ROOTPATH", "../" );
include( ROOTPATH."includes/common.inc.php" );
include( "language/".$sLan.".php" );
$act = $_POST['act'];
switch ( $act )
{
case "pluslocat" :
		if ( admincheckauth( ) )
		{
				$id = explode( ",", $_POST['id'] );
				$zindex = explode( ",", $_POST['zindex'] );
				$top = explode( ",", $_POST['top'] );
				$left = explode( ",", $_POST['left'] );
				$width = explode( ",", $_POST['width'] );
				$height = explode( ",", $_POST['height'] );
				$display = explode( ",", $_POST['display'] );
				$th = $_POST['th'];
				$ch = $_POST['ch'];
				$bh = $_POST['bh'];
				$pagecontainwidth = $_POST['pagecontainwidth'];
				$pagebgcolor = $_POST['pagebgcolor'];
				$bgimage = $_POST['bgimage'];
				$bgposition = $_POST['bgposition'];
				$bgrepeat = $_POST['bgrepeat'];
				$bgatt = $_POST['bgatt'];
				$containbg = $_POST['containbg'];
				$containmargin = $_POST['containmargin'];
				$containpadding = $_POST['containpadding'];
				$containcenter = $_POST['containcenter'];
				$topbg = $_POST['topbg'];
				$topbgout = $_POST['topbgout'];
				$contentbg = $_POST['contentbg'];
				$contentbgout = $_POST['contentbgout'];
				$bottombg = $_POST['bottombg'];
				$bottombgout = $_POST['bottombgout'];
				$contentmargin = $_POST['contentmargin'];
				$pageid = $_POST['pageid'];
				$psetglobal = $_POST['psetglobal'];
				$pagesavetemp = $_POST['pagesavetemp'];
				$pagetempname = $_POST['pagetempname'];
				$plusplansave = $_POST['plusplansave'];
				$plusplanname = $_POST['plusplanname'];
				$pagecname = $_POST['pagecname'];
				$pagetitle = $_POST['pagetitle'];
				$metakey = $_POST['metakey'];
				$metacon = $_POST['metacon'];				
				for ( $i = 0;	$i < count( $id );	$i++	)
				{
						if ( substr( $id[$i], 0, 4 ) == "pdv_" )
						{
								$upid = substr( $id[$i], 4 );
								$msql->query( "update {P}_base_plus set 
						`zindex`='{$zindex[$i]}',
						`top`='{$top[$i]}',
						`left`='{$left[$i]}',
						`width`='{$width[$i]}',
						`height`='{$height[$i]}'
						where `id` = '{$upid}' 
					" );
						}
				}
															
				
				if ( $bgimage != "" && $bgimage != "none" )
				{
						$bgimage = preg_replace( "/(url\\()+.+(effect\\/)/", "url(effect/", $bgimage );
						$bgimage = str_replace( "\")",")",$bgimage );
				}
				if ( strstr( $containbg, "url(" ) )
				{
						$containbg = preg_replace( "/(url\\()+.+(effect\\/)/", "url(effect/", $containbg );
						$containbg = str_replace( "\")",")",$containbg );
				}
				if ( strstr( $topbg, "url(" ) )
				{
						$topbg = preg_replace( "/(url\\()+.+(effect\\/)/", "url(effect/", $topbg );
						$topbg = str_replace( "\")",")",$topbg );
				}
				if ( strstr( $topbgout, "url(" ) )
				{
						$topbgout = preg_replace( "/(url\\()+.+(effect\\/)/", "url(effect/", $topbgout );
						$topbgout = str_replace( "\")",")",$topbgout );
				}
				if ( strstr( $contentbg, "url(" ) )
				{
						$contentbg = preg_replace( "/(url\\()+.+(effect\\/)/", "url(effect/", $contentbg );
						$contentbg = str_replace( "\")",")",$contentbg );
				}
				if ( strstr( $contentbgout, "url(" ) )
				{
						$contentbgout = preg_replace( "/(url\\()+.+(effect\\/)/", "url(effect/", $contentbgout );
						$contentbgout = str_replace( "\")",")",$contentbgout );
				}
				if ( strstr( $bottombg, "url(" ) )
				{
						$bottombg = preg_replace( "/(url\\()+.+(effect\\/)/", "url(effect/", $bottombg );
						$bottombg = str_replace( "\")",")",$bottombg );
				}
				if ( strstr( $bottombgout, "url(" ) )
				{
						$bottombgout = preg_replace( "/(url\\()+.+(effect\\/)/", "url(effect/", $bottombgout );
						$bottombgout = str_replace( "\")",")",$bottombgout );
				}
				$msql->query( "update {P}_base_pageset set 
			`name`='{$pagecname}',
			`pagetitle`='{$pagetitle}',
			`metakey`='{$metakey}',
			`metacon`='{$metacon}',
			`containwidth`='{$pagecontainwidth}',
			`containbg`='{$containbg}',
			`containmargin`='{$containmargin}',
			`containpadding`='{$containpadding}',
			`containcenter`='{$containcenter}',
			`bgcolor`='{$pagebgcolor}',
			`bgimage`='{$bgimage}',
			`bgposition`='{$bgposition}',
			`bgrepeat`='{$bgrepeat}',
			`bgatt`='{$bgatt}',
			`topbg`='{$topbg}',
				`topbgout`='{$topbgout}',
			`contentbg`='{$contentbg}',
				`contentbgout`='{$contentbgout}',
			`contentmargin`='{$contentmargin}',
			`bottombg`='{$bottombg}',
				`bottombgout`='{$bottombgout}',
			`th`='{$th}',
			`ch`='{$ch}',
			`bh`='{$bh}'
			where `id`='{$pageid}'" );
				if ( $psetglobal == "true" )
				{
						$msql->query( "update {P}_base_pageset set 
				`containwidth`='{$pagecontainwidth}',
				`containbg`='{$containbg}',
				`containmargin`='{$containmargin}',
				`containpadding`='{$containpadding}',
				`containcenter`='{$containcenter}',
				`bgcolor`='{$pagebgcolor}',
				`bgimage`='{$bgimage}',
				`bgposition`='{$bgposition}',
				`bgrepeat`='{$bgrepeat}',
				`bgatt`='{$bgatt}',
				`topbg`='{$topbg}',
					`topbgout`='{$topbgout}',
				`contentbg`='{$contentbg}',
					`contentbgout`='{$contentbgout}',
				`contentmargin`='{$contentmargin}',
				`bottombg`='{$bottombg}',
					`bottombgout`='{$bottombgout}'
				" );
				}
				if ( $pagesavetemp == "true" )
				{
						$msql->query( "insert into {P}_base_pagetemp set 
				`tempname`='{$pagetempname}',
				`containwidth`='{$pagecontainwidth}',
				`containbg`='{$containbg}',
				`containmargin`='{$containmargin}',
				`containpadding`='{$containpadding}',
				`containcenter`='{$containcenter}',
				`bgcolor`='{$pagebgcolor}',
				`bgimage`='{$bgimage}',
				`bgposition`='{$bgposition}',
				`bgrepeat`='{$bgrepeat}',
				`bgatt`='{$bgatt}',
				`topbg`='{$topbg}',
					`topbgout`='{$topbgout}',
				`contentbg`='{$contentbg}',
					`contentbgout`='{$contentbgout}',
				`contentmargin`='{$contentmargin}',
				`bottombg`='{$bottombg}',
					`bottombgout`='{$bottombgout}'
				" );
				}
				if ( $plusplansave == "true" )
				{
						$msql->query( "select coltype,pagename from {P}_base_pageset where id='{$pageid}'" );
						if ( $msql->next_record( ) )
						{
								$coltype = $msql->f( "coltype" );
								$pagename = $msql->f( "pagename" );
						}
						$msql->query( "insert into {P}_base_plusplanid set planname='{$plusplanname}',plustype='{$coltype}',pluslocat='{$pagename}'" );
						$planid = $msql->instid( );
						$msql->query( "insert into {P}_base_plusplan (`coltype` , `pluslable` , `plusname` , `plustype` , `pluslocat` , `tempname` , `tempcolor` , `showborder` , `bordercolor` , `borderwidth` , `borderstyle` , `borderlable` , `borderroll` , `showbar` , `barbg` , `barcolor` , `backgroundcolor` , `morelink` , `width` , `height` , `top` , `left` , `zindex` , `padding` , `shownums` , `ord` , `sc` , `showtj` , `cutword` , `target` , `catid` , `cutbody` , `picw` , `pich` , `fittype` , `title` , `body` , `pic` , `piclink` , `attach` , `movi` , `sourceurl` , `word` , `word1` , `word2` , `word3` , `word4` , `text` , `text1` , `code` , `link` , `link1` , `link2` , `link3` , `link4` , `tags` , `groupid` , `projid` , `modno` , `setglobal` , `overflow` , `bodyzone` , `display` ) SELECT `coltype` , `pluslable` , `plusname` , `plustype` , `pluslocat` , `tempname` , `tempcolor` , `showborder` , `bordercolor` , `borderwidth` , `borderstyle` , `borderlable` , `borderroll` , `showbar` , `barbg` , `barcolor` , `backgroundcolor` , `morelink` , `width` , `height` , `top` , `left` , `zindex` , `padding` , `shownums` , `ord` , `sc` , `showtj` , `cutword` , `target` , `catid` , `cutbody` , `picw` , `pich` , `fittype` , `title` , `body` , `pic` , `piclink` , `attach` , `movi` , `sourceurl` , `word` , `word1` , `word2` , `word3` , `word4` , `text` , `text1` , `code` , `link` , `link1` , `link2` , `link3` , `link4` , `tags` , `groupid` , `projid` , `modno` , `setglobal` , `overflow` , `bodyzone` , `display`  FROM {P}_base_plus where plustype='{$coltype}' and pluslocat='{$pagename}' " );
						$msql->query( "update {P}_base_plusplan set planid='{$planid}' where planid='0'" );
				}
				echo "OK";
		}
		else
		{
				echo $strNorights;
		}
		exit( );
		break;
case "plusdel" :
		if ( admincheckauth( ) )
		{
				$pdvid = $_POST['pdvid'];
				$id = substr( $pdvid, 4 );
				$msql->query( "delete from {P}_base_plus where id='{$id}'" );
				echo "OK";
		}
		else
		{
				echo $strNorights;
		}
		exit( );
		break;
case "pluscopyme" :
		if ( admincheckauth( ) )
		{
				$pdvid = $_POST['pdvid'];
				$id = substr( $pdvid, 4 );
				$msql->query( "select `pluslable`  from {P}_base_plus where id='{$id}'" );
				if ( $msql->next_record( ) )
				{
						$pluslable = $msql->f( "pluslable" );
				}
				else
				{
						echo "1000";
						exit( );
				}
				$msql->query( "select `ifmul`  from {P}_base_plusdefault where pluslable='{$pluslable}'" );
				if ( $msql->next_record( ) )
				{
						$ifmul = $msql->f( "ifmul" );
				}
				if ( $ifmul == "0" )
				{
						echo "1001";
						exit( );
				}
				$msql->query( "insert into {P}_base_plus (`coltype`, `pluslable`, `plusname`, `plustype`, `pluslocat`, `tempname`, `tempcolor`, `showborder`, `bordercolor`, `borderwidth`, `borderstyle`, `borderlable`, `borderroll`, `showbar`, `barbg`, `barcolor`, `backgroundcolor`, `morelink`, `width`, `height`, `top`, `left`, `zindex`, `padding`, `shownums`, `ord`, `sc`, `showtj`, `cutword`, `target`, `catid`, `cutbody`, `picw`, `pich`, `fittype`, `title`, `body`, `pic`, `piclink`, `attach`, `movi`, `sourceurl`, `word`, `word1`, `word2`, `word3`, `word4`, `text`, `text1`, `code`, `link`, `link1`, `link2`, `link3`, `link4`, `tags`, `groupid`, `projid`, `modno`, `setglobal`, `overflow`, `bodyzone`, `display`) select `coltype`, `pluslable`, `plusname`, `plustype`, `pluslocat`, `tempname`, `tempcolor`, `showborder`, `bordercolor`, `borderwidth`, `borderstyle`, `borderlable`, `borderroll`, `showbar`, `barbg`, `barcolor`, `backgroundcolor`, `morelink`, `width`, `height`, `top`+10, `left`+10, `zindex`+1, `padding`, `shownums`, `ord`, `sc`, `showtj`, `cutword`, `target`, `catid`, `cutbody`, `picw`, `pich`, `fittype`, `title`, `body`, `pic`, `piclink`, `attach`, `movi`, `sourceurl`, `word`, `word1`, `word2`, `word3`, `word4`, `text`, `text1`, `code`, `link`, `link1`, `link2`, `link3`, `link4`, `tags`, `groupid`, `projid`, `modno`, `setglobal`, `overflow`, `bodyzone`, `display`  from {P}_base_plus where id='{$id}'" );
				$backid = $msql->instid( );
				echo "OK_".$backid;
		}
		else
		{
				echo $strNorights;
		}
		exit( );
		break;
case "plusgetcol" :
		$coltype = $_POST['coltype'];
		$str = "<ul>";
		$str .= "<li id='admincol_all' class='admin_collist' ><span class='admin_collisttext'>".$strPlusColAll."</span></li>";
		$msql->query( "select * from {P}_base_coltype order by id" );
		while ( $msql->next_record( ) )
		{
				$selcolid = $msql->f( "id" );
				$selcoltype = $msql->f( "coltype" );
				$selcolname = $msql->f( "colname" );
				$ifpubplus = $msql->f( "ifpubplus" );
				if ( $coltype == $selcoltype )
				{
						$str .= "<li id='admincol_".$selcoltype."' class='admin_collistnow' ><span class='admin_collisttext'>".$selcolname."</span></li>";
				}
				else if ( $ifpubplus == "1" )
				{
						$str .= "<li id='admincol_".$selcoltype."' class='admin_collist' ><span class='admin_collisttext'>".$selcolname."</span></li>";
				}
		}
		$str .= "</ul>";
		echo $str;
		exit( );
		break;
case "plusgetmodule" :
		$coltype = $_POST['coltype'];
		$showcoltype = $_POST['showcoltype'];
		$pagename = $_POST['pagename'];
		$pdvrp = $_POST['pdvrp'];
		if ( $showcoltype != "" && $showcoltype != "all" )
		{
				$addsql = "  and  coltype='".$showcoltype."' ";
		}
		$str = "<ul>";
		$i = 0;
		$msql->query( "select * from {P}_base_plusdefault where (plustype='".$coltype."' or plustype='all') and (pluslocat='".$pagename."'  or pluslocat='all')  ".$addsql." order by coltype " );
		while ( $msql->next_record( ) )
		{
				$lplusname = $msql->f( "plusname" );
				$lpluslable = $msql->f( "pluslable" );
				$lpluscoltype = $msql->f( "coltype" );
				$ifmul = $msql->f( "ifmul" );
				$pluslab = substr( $lpluslable, 3 );
				$logofile = ROOTPATH.$lpluscoltype."/templates/icon/".$pluslab.".gif";
				if ( file_exists( $logofile ) )
				{
						$pluslogo = $pdvrp.$lpluscoltype."/templates/icon/".$pluslab.".gif";
				}
				else
				{
						$pluslogo = $pdvrp."base/templates/icon/default.gif";
				}
				$fsql->query( "select max(modno) from {P}_base_plus where plustype='".$coltype."' and pluslocat='".$pagename."' and pluslable='".$lpluslable."'" );
				if ( $fsql->next_record( ) )
				{
						$newmodno = $fsql->f( "max(modno)" ) + 1;
				}
				if ( $ifmul == "1" || $ifmul == "0" && $newmodno <= 1 )
				{
						$str .= "<li class='admin_plussellist' onClick=\"plusAdd('".$pdvrp."base/admin/plusadd.php?plustype=".$coltype."&pluslocat=".$pagename."&pluslable=".$lpluslable."&modno=".$newmodno."')\" >";
						$str .= "<div class='admin_plusselpic' style='background:url(".$pluslogo.") left no-repeat'></div><div class='admin_plusseltext'>".$lplusname."</div></li>";
						$i++;
				}
		}
		if ( $i < 1 )
		{
				echo $strPlusNTC3;
				exit( );
		}
		$str .= "</ul>";
		echo $str;
		exit( );
		break;
case "plusnowlist" :
		$coltype = $_POST['coltype'];
		$pagename = $_POST['pagename'];
		$pdvrp = $_POST['pdvrp'];
		$str = "<ul>";
		$msql->query( "select * from {P}_base_plus where plustype='".$coltype."' and pluslocat='".$pagename."' order by id" );
		while ( $msql->next_record( ) )
		{
				$adminplusid = $msql->f( "id" );
				$adminpluslable = $msql->f( "pluslable" );
				$adminplusname = $msql->f( "plusname" );
				$adminmodno = $msql->f( "modno" );
				$admindisplay = $msql->f( "display" );
				$lpluscoltype = $msql->f( "coltype" );
				$pluslab = substr( $adminpluslable, 3 );
				$logofile = ROOTPATH.$lpluscoltype."/templates/icon/".$pluslab.".gif";
				if ( file_exists( $logofile ) )
				{
						$pluslogo = $pdvrp.$lpluscoltype."/templates/icon/".$pluslab.".gif";
				}
				else
				{
						$pluslogo = $pdvrp."base/templates/icon/default.gif";
				}
				$str .= "<li id='nowv_".$adminplusid."' class='admin_pluslist'>";
				$str .= "<div class='admin_pluslistpic' style='background:url(".$pluslogo.") left no-repeat'></div>";
				$str .= "<div class='admin_pluslisttext'>".$adminplusname." </div><div class='admin_pluslisttext1'>No.".$adminmodno."-".$adminplusid."</div>";
				$str .= "<div id='v_".$adminplusid."' class='admin_pluslistedit' title='".$strPlusSetup."'></div><div id='dv_".$adminplusid."' class='admin_pluslistdel' title='".$strPlusDel."' ></div>";
				$str .= "</li>";
		}
		$str .= "</ul>";
		echo $str;
		exit( );
		break;
case "pagetemplist" :
		$pageid = $_POST['pageid'];
		$str = "<ul>";
		$msql->query( "select * from {P}_base_pagetemp order by id" );
		while ( $msql->next_record( ) )
		{
				$tempid = $msql->f( "id" );
				$tempname = $msql->f( "tempname" );
				$str .= "<li id='pagetemplist_".$tempid."' class='admin_pagetemplist' ><div id='pagetempdel_".$tempid."' class='pagetempdel'></div><span id='pagetemp_".$tempid."' class='admin_pagetemplisttext'>".$tempname."</span></li>";
		}
		$str .= "</ul>";
		echo $str;
		exit( );
		break;
case "planlist" :
		$str = "<ul>";
		$msql->query( "select * from {P}_base_plusplanid order by id desc" );
		while ( $msql->next_record( ) )
		{
				$planid = $msql->f( "id" );
				$planname = $msql->f( "planname" );
				$str .= "<li id='plusplanlist_".$planid."' class='plusplanlist' ><div id='plusplandel_".$planid."' class='plusplandel' title='".$strPlusPlanDel."'></div><div id='plusplanuse_".$planid."' class='plusplanuse' title='".$strPlusPlanUse."'></div><span id='plusplan_".$planid."' class='plusplan'>".$planname."</span></li>";
		}
		$str .= "</ul>";
		echo $str;
		exit( );
		break;
case "plusplandel" :
		$planid = $_POST['planid'];
		$msql->query( "delete from {P}_base_plusplan where planid='{$planid}' or planid='0'" );
		$msql->query( "delete from {P}_base_plusplanid where id='{$planid}'" );
		echo "OK";
		exit( );
		break;
case "plusplanuse" :
		$planid = $_POST['planid'];
		$pageid = $_POST['pageid'];
		$planusezone = $_POST['planusezone'];
		switch ( $planusezone )
		{
		case "top" :
				$addsql = " and bodyzone='top' ";
				break;
		case "bottom" :
				$addsql = " and bodyzone='bottom' ";
				break;
		case "topbottom" :
				$addsql = " and (bodyzone='top' or bodyzone='bottom')";
				break;
		case "alltop" :
				$addsql = " and bodyzone='top' ";
				$copytoall = TRUE;
				break;
		case "allbottom" :
				$addsql = " and bodyzone='bottom' ";
				$copytoall = TRUE;
				break;
		case "alltopbottom" :
				$addsql = " and (bodyzone='top' or bodyzone='bottom')";
				$copytoall = TRUE;
				break;
				/**/
		case "alltop_mobi" :
				$addsql = " and bodyzone='top'";
				$selsql = " where pagename regexp '_m$'";
				$copytoall = TRUE;
				break;
		case "allbottom_mobi" :
				$addsql = " and bodyzone='bottom'";
				$selsql = " where pagename regexp '_m$'";
				$copytoall = TRUE;
				break;
		case "alltopbottom_mobi" :
				$addsql = " and (bodyzone='top' or bodyzone='bottom')";
				$selsql = " where pagename regexp '_m$'";
				$copytoall = TRUE;
				break;
		case "alltop_pc" :
				$addsql = " and bodyzone='top'";
				$selsql = " where pagename regexp '[^_m]$'";
				$copytoall = TRUE;
				break;
		case "allbottom_pc" :
				$addsql = " and bodyzone='bottom'";
				$selsql = " where pagename regexp '[^_m]$'";
				$copytoall = TRUE;
				break;
		case "alltopbottom_pc" :
				$addsql = " and (bodyzone='top' or bodyzone='bottom')";
				$selsql = " where pagename regexp '[^_m]$'";
				$copytoall = TRUE;
				break;
				/**/
		default :
				$addsql = " ";
				break;
		}
if(!$copytoall){
		$msql->query( "select coltype,pagename from {P}_base_pageset where id='{$pageid}'" );
		if ( $msql->next_record( ) )
		{
				$coltype = $msql->f( "coltype" );
				$pagename = $msql->f( "pagename" );
		}
		$msql->query( "delete from {P}_base_plus where plustype='{$coltype}' and pluslocat='{$pagename}' ".$addsql );
		$msql->query( "insert into {P}_base_plus (`coltype` , `pluslable` , `plusname` , `tempname` , `tempcolor` , `showborder` , `bordercolor` , `borderwidth` , `borderstyle` , `borderlable` , `borderroll` , `showbar` , `barbg` , `barcolor` , `backgroundcolor` , `morelink` , `width` , `height` , `top` , `left` , `zindex` , `padding` , `shownums` , `ord` , `sc` , `showtj` , `cutword` , `target` , `catid` , `cutbody` , `picw` , `pich` , `fittype` , `title` , `body` , `pic` , `piclink` , `attach` , `movi` , `sourceurl` , `word` , `word1` , `word2` , `word3` , `word4` , `text` , `text1` , `code` , `link` , `link1` , `link2` , `link3` , `link4` , `tags` , `groupid` , `projid` , `modno` , `setglobal` , `overflow` , `bodyzone` , `display` ) SELECT `coltype` , `pluslable` , `plusname` , `tempname` , `tempcolor` , `showborder` , `bordercolor` , `borderwidth` , `borderstyle` , `borderlable` , `borderroll` , `showbar` , `barbg` , `barcolor` , `backgroundcolor` , `morelink` , `width` , `height` , `top` , `left` , `zindex` , `padding` , `shownums` , `ord` , `sc` , `showtj` , `cutword` , `target` , `catid` , `cutbody` , `picw` , `pich` , `fittype` , `title` , `body` , `pic` , `piclink` , `attach` , `movi` , `sourceurl` , `word` , `word1` , `word2` , `word3` , `word4` , `text` , `text1` , `code` , `link` , `link1` , `link2` , `link3` , `link4` , `tags` , `groupid` , `projid` , `modno` , `setglobal` , `overflow` , `bodyzone` , `display`  FROM {P}_base_plusplan where  planid='{$planid}' ".$addsql );
		$msql->query( "select pluslable,id from {P}_base_plus where plustype='0' and pluslocat='0'" );
		while ( $msql->next_record( ) )
		{
				$pluslable = $msql->f( "pluslable" );
				$plusid = $msql->f( "id" );
				$fsql->query( "select plustype,pluslocat from {P}_base_plusdefault where pluslable='{$pluslable}' limit 0,1" );
				if ( $fsql->next_record( ) )
				{
						$allowtype = $fsql->f( "plustype" );
						$allowlocat = $fsql->f( "pluslocat" );
				}
				if ( ( $allowtype == "all" || $allowtype == $coltype ) && ( $allowlocat == "all" || $allowlocat == $pagename ) )
				{
						$fsql->query( "update {P}_base_plus set plustype='{$coltype}',pluslocat='{$pagename}' where id='{$plusid}'" );
				}
				else
				{
						$fsql->query( "delete from {P}_base_plus where id='{$plusid}'" );
				}
		}
}else{
		$msql->query( "select coltype,pagename from {P}_base_pageset $selsql" );
		while ( $msql->next_record( ) )
		{
				$coltype = $msql->f( "coltype" );
				$pagename = $msql->f( "pagename" );
		$fsql->query( "delete from {P}_base_plus where plustype='{$coltype}' and pluslocat='{$pagename}' ".$addsql );
		$fsql->query( "insert into {P}_base_plus (`coltype` , `pluslable` , `plusname` , `tempname` , `tempcolor` , `showborder` , `bordercolor` , `borderwidth` , `borderstyle` , `borderlable` , `borderroll` , `showbar` , `barbg` , `barcolor` , `backgroundcolor` , `morelink` , `width` , `height` , `top` , `left` , `zindex` , `padding` , `shownums` , `ord` , `sc` , `showtj` , `cutword` , `target` , `catid` , `cutbody` , `picw` , `pich` , `fittype` , `title` , `body` , `pic` , `piclink` , `attach` , `movi` , `sourceurl` , `word` , `word1` , `word2` , `word3` , `word4` , `text` , `text1` , `code` , `link` , `link1` , `link2` , `link3` , `link4` , `tags` , `groupid` , `projid` , `modno` , `setglobal` , `overflow` , `bodyzone` , `display` ) SELECT `coltype` , `pluslable` , `plusname` , `tempname` , `tempcolor` , `showborder` , `bordercolor` , `borderwidth` , `borderstyle` , `borderlable` , `borderroll` , `showbar` , `barbg` , `barcolor` , `backgroundcolor` , `morelink` , `width` , `height` , `top` , `left` , `zindex` , `padding` , `shownums` , `ord` , `sc` , `showtj` , `cutword` , `target` , `catid` , `cutbody` , `picw` , `pich` , `fittype` , `title` , `body` , `pic` , `piclink` , `attach` , `movi` , `sourceurl` , `word` , `word1` , `word2` , `word3` , `word4` , `text` , `text1` , `code` , `link` , `link1` , `link2` , `link3` , `link4` , `tags` , `groupid` , `projid` , `modno` , `setglobal` , `overflow` , `bodyzone` , `display`  FROM {P}_base_plusplan where  planid='{$planid}' ".$addsql );
		$tsql->query( "select pluslable,id from {P}_base_plus where plustype='0' and pluslocat='0'" );
		while ( $tsql->next_record( ) )
		{
				$pluslable = $tsql->f( "pluslable" );
				$plusid = $tsql->f( "id" );
				$fsql->query( "select plustype,pluslocat from {P}_base_plusdefault where pluslable='{$pluslable}' limit 0,1" );
				if ( $fsql->next_record( ) )
				{
						$allowtype = $fsql->f( "plustype" );
						$allowlocat = $fsql->f( "pluslocat" );
				}
				if ( ( $allowtype == "all" || $allowtype == $coltype ) && ( $allowlocat == "all" || $allowlocat == $pagename ) )
				{
						$fsql->query( "update {P}_base_plus set plustype='{$coltype}',pluslocat='{$pagename}' where id='{$plusid}'" );
				}
				else
				{
						$fsql->query( "delete from {P}_base_plus where id='{$plusid}'" );
				}
		}
		}
}
		echo "OK";
		exit( );
		break;
case "getpagetemp" :
		$pagetempid = $_POST['pagetempid'];
		$RP = $_POST['RP'];
		$str = "var J={";
		$msql->query( "select * from {P}_base_pagetemp where id='{$pagetempid}'" );
		if ( $msql->next_record( ) )
		{
				$str .= "CW:'".$msql->f( "containwidth" )."',";
				$str .= "CB:'".str_replace( "url(effect/", "url(".$RP."effect/", $msql->f( "containbg" ) )."',";
				$str .= "CM:'".$msql->f( "containmargin" )."',";
				$str .= "CP:'".$msql->f( "containpadding" )."',";
				$str .= "CC:'".$msql->f( "containcenter" )."',";
				$str .= "BC:'".$msql->f( "bgcolor" )."',";
				$str .= "BP:'".$msql->f( "bgposition" )."',";
				$str .= "BR:'".$msql->f( "bgrepeat" )."',";
				$str .= "BA:'".$msql->f( "bgatt" )."',";
				$str .= "TB:'".str_replace( "url(effect/", "url(".$RP."effect/", $msql->f( "topbg" ) )."',";
				$str .= "TBO:'".str_replace( "url(effect/", "url(".$RP."effect/", $msql->f( "topbgout" ) )."',";
				$str .= "NB:'".str_replace( "url(effect/", "url(".$RP."effect/", $msql->f( "contentbg" ) )."',";
				$str .= "NBO:'".str_replace( "url(effect/", "url(".$RP."effect/", $msql->f( "contentbgout" ) )."',";
				$str .= "NM:'".$msql->f( "contentmargin" )."',";
				$str .= "BB:'".str_replace( "url(effect/", "url(".$RP."effect/", $msql->f( "bottombg" ) )."',";
				$str .= "BBO:'".str_replace( "url(effect/", "url(".$RP."effect/", $msql->f( "bottombgout" ) )."',";
				$bgimage = $msql->f( "bgimage" );
		}
		$bgimage = str_replace( "url(effect/", "url(".$RP."effect/", $bgimage );
		$str .= "BI:'".$bgimage."'";
		$str .= "}";
		echo $str;
		exit( );
		break;
case "pagetempdel" :
		if ( admincheckauth( ) )
		{
				$pagetempid = $_POST['pagetempid'];
				$msql->query( "delete from {P}_base_pagetemp where id='{$pagetempid}'" );
				echo "OK";
		}
		else
		{
				echo $strNorights;
		}
		exit( );
		break;
case "getpagemeta" :
		$pageid = $_POST['pageid'];
		$msql->query( "select * from {P}_base_pageset where id='{$pageid}'" );
		if ( $msql->next_record( ) )
		{
				$nowcontain = $msql->f( "contain" );
				$pagecname = $msql->f( "name" );
				$pagetitle = $msql->f( "pagetitle" );
				$metakey = $msql->f( "metakey" );
				$metacon = $msql->f( "metacon" );
		}
		$str = "<div class='pageconsetitem'>".$strPageName."<input type='text' id='pagecname' class='input' size='38' value='".$pagecname."' /></div>";
		$str .= "<div class='pageconsetitem'>".$strPageTitle."<input type='text' id='pagetitle' class='input' size='38' value='".$pagetitle."' /></div>";
		$str .= "<div class='pageconsetitem'>".$strPageMetaKey."<input type='text' id='metakey' class='input' size='38' value='".$metakey."' /></div>";
		$str .= "<div class='pageconsetitem'>".$strPageMetaCon."<input type='text' id='metacon' class='input' size='38' value='".$metacon."' /></div>";
		echo $str;
		exit( );
		break;
case "pagebgimglist" :
		$pageid = $_POST['pageid'];
		$RP = $_POST['RP'];
		$sourcefold = ROOTPATH."effect/source/bg";
		$handle = opendir( $sourcefold );
		$i = 0;
		while ( $image_file = readdir( $handle ) )
		{
				if ( $image_file != "." && $image_file != ".." && $image_file != "_notes" && !strstr( $image_file, "/" ) )
				{
						$nowfile = $RP."effect/source/bg/".$image_file;
						$str .= "<div class='pagesourcediv' style='background:url(".$nowfile.")'></div>";
				}
				$i++;
		}
		closedir( $handle );
		echo $str;
		exit( );
		break;
case "containimglist" :
		$pageid = $_POST['pageid'];
		$RP = $_POST['RP'];
		$cw = $_POST['cw'];
		$sourcefold = ROOTPATH."effect/source/contain/".$cw;
		$handle = opendir( $sourcefold );
		$i = 0;
		while ( $image_file = readdir( $handle ) )
		{
				if ( $image_file != "." && $image_file != ".." && $image_file != "_notes" && !strstr( $image_file, "/" ) )
				{
						$nowfile = $RP."effect/source/contain/".$cw."/".$image_file;
						$str .= "<div class='containbgdiv'><img class='containbgimg' src='".$nowfile."' width='60' /></div>";
				}
				$i++;
		}
		closedir( $handle );
		echo $str;
		exit( );
		break;
}
?>