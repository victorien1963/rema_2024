<?php
function PaperGl( )
{
				global $fsql;
				global $tsql;
				$coltitle = $GLOBALS['PLUSVARS']['coltitle'];
				$tempname = $GLOBALS['PLUSVARS']['tempname'];
				$memberid = $_COOKIE['MEMBERID'];
				$showcatid = $_GET['showcatid'];
				$showpcatid = $_GET['showpcatid'];
				$shownum = $_GET['shownum'];
				$key = $_GET['key'];
				$page = $_GET['page'];
				$step = $_GET['step'];
				if ( $step == "update" )
				{
								$id = $_GET['id'];
								$now = time( );
								$fsql->query( "update {P}_paper_con set uptime='{$now}' where id='{$id}' and memberid='{$memberid}'" );
				}
				if ( $step == "del" )
				{
								$id = $_GET['id'];
								$fsql->query( "select src,fileurl from {P}_paper_con where memberid='{$memberid}' and id='{$id}'" );
								if ( $fsql->next_record( ) )
								{
												$oldsrc = $fsql->f( "src" );
												$fileurl = $fsql->f( "fileurl" );
												if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )
												{
																@unlink( ROOTPATH.$oldsrc );
												}
												if ( file_exists( ROOTPATH.$fileurl ) && $fileurl != "" && !strstr( $fileurl, "../" ) && !strstr( $fileurl, "http://" ) )
												{
																@unlink( ROOTPATH.$fileurl );
												}
												$candel = "yes";
								}
								else
								{
												$candel = "no";
								}
								if ( $candel == "yes" )
								{
												$fsql->query( "delete from {P}_paper_pages where paperid='{$id}'" );
								}
								$fsql->query( "delete from {P}_paper_con where id='{$id}' and memberid='{$memberid}'" );
				}
				$Temp = loadtemp( $tempname );
				$TempArr = splittbltemp( $Temp );
				$fsql->query( "select * from {P}_paper_pcat where memberid='{$memberid}' order by xuhao" );
				while ( $fsql->next_record( ) )
				{
								$pcatid = $fsql->f( "catid" );
								$pcat = $fsql->f( "cat" );
								if ( $showpcatid == $pcatid )
								{
												$pcatlist .= "<option value='".$pcatid."' selected>".$pcat."</option>";
								}
								else
								{
												$pcatlist .= "<option value='".$pcatid."'>".$pcat."</option>";
								}
				}
				$fsql->query( "select * from {P}_paper_cat order by catpath" );
				while ( $fsql->next_record( ) )
				{
								$lpid = $fsql->f( "pid" );
								$lcatid = $fsql->f( "catid" );
								$cat = $fsql->f( "cat" );
								$catpath = $fsql->f( "catpath" );
								$lcatpath = explode( ":", $catpath );
								$i = 0;
								for ( ;	$i < sizeof( $lcatpath ) - 2;	++$i	)
								{
												$tsql->query( "select catid,cat from {P}_paper_cat where catid='{$lcatpath[$i]}'" );
												if ( $tsql->next_record( ) )
												{
																$ncatid = $tsql->f( "cat" );
																$ncat = $tsql->f( "cat" );
																$ppcat .= $ncat."/";
												}
								}
								if ( $showcatid == $lcatid )
								{
												$catlist .= "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
								}
								else
								{
												$catlist .= "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
								}
								$ppcat = "";
				}
				$var = array(
								"catlist" => $catlist,
								"pcatlist" => $pcatlist
				);
				$str = showtpltemp( $TempArr['start'], $var );
				$scl = " memberid='{$memberid}' ";
				if ( $showcatid != "" && $showcatid != "0" )
				{
								$fmdpath = fmpath( $showcatid );
								$scl .= " and catpath regexp '{$fmdpath}' ";
				}
				if ( $showpcatid != "" && $showpcatid != "0" )
				{
								$scl .= " and pcatid ='{$showpcatid}' ";
				}
				if ( $key != "" )
				{
								$scl .= " and (title regexp '{$key}' or body regexp '{$key}') ";
				}
				if ( $shownum == "" )
				{
								$shownum = "10";
				}
				include_once( ROOTPATH."includes/pages.inc.php" );
			
				$pages = new pages( );
				$totalnums = tblcount( "_paper_con", "id", $scl );
				$pages->setvar( array(
								"key" => $key,
								"shownum" => $shownum,
								"showcatid" => $showcatid,
								"showpcatid" => $showpcatid
				) );
				$pages->set( $shownum, $totalnums );
				$pagelimit = $pages->limit( );
				$fsql->query( "select * from {P}_paper_con where {$scl} order by uptime desc limit {$pagelimit}" );
				while ( $fsql->next_record( ) )
				{
								$id = $fsql->f( "id" );
								$title = $fsql->f( "title" );
								$dtime = $fsql->f( "dtime" );
								$src = $fsql->f( "src" );
								$uptime = $fsql->f( "uptime" );
								$iffb = $fsql->f( "iffb" );
								$dtime = date( "Y-m-d", $dtime );
								$uptime = date( "Y-m-d", $uptime );
								if ( $iffb == "1" )
								{
												$check = "<img src='".ROOTPATH."paper/templates/images/yes.gif'>";
								}
								else
								{
												$check = "<img src='".ROOTPATH."paper/templates/images/no.gif'>";
								}
								if ( $src != "" )
								{
												$icon = "image.gif";
												$src = ROOTPATH.$src;
								}
								else
								{
												$icon = "noimage.gif";
								}
								$link = ROOTPATH."paper/html/?".$id.".html";
								$var = array(
												"page" => $page,
												"title" => $title,
												"dtime" => $dtime,
												"src" => $src,
												"icon" => $icon,
												"uptime" => $uptime,
												"check" => $check,
												"target" => "_blank",
												"link" => $link,
												"id" => $id
								);
								$str .= showtpltemp( $TempArr['list'], $var );
				}
				$str .= $TempArr['end'];
				$pagesinfo = $pages->ShowNow( );
				$var = array(
								"key" => $key,
								"showcatid" => $showcatid,
								"shownum" => $shownum,
								"showpages" => $pages->output( 1 ),
								"pagestotal" => $pagesinfo['total'],
								"pagesnow" => $pagesinfo['now'],
								"pagesshownum" => $pagesinfo['shownum'],
								"pagesfrom" => $pagesinfo['from'],
								"pagesto" => $pagesinfo['to'],
								"totalnums" => $totalnums
				);
				$str = showtpltemp( $str, $var );
				return $str;
}

?>