<?php
function MemberPaperQuery( )
{
				global $fsql;
				global $msql;
				$shownums = $GLOBALS['PLUSVARS']['shownums'];
				$cutword = $GLOBALS['PLUSVARS']['cutword'];
				$target = $GLOBALS['PLUSVARS']['target'];
				$tempname = $GLOBALS['PLUSVARS']['tempname'];
				if ( isset( $_GET['mid'] ) && $_GET['mid'] != "" && $_GET['mid'] != "0" )
				{
								$mid = $_GET['mid'];
				}
				else
				{
								return "";
				}
				$key = $_GET['key'];
				$page = $_GET['page'];
				$myord = $_GET['myord'];
				$myshownums = $_GET['myshownums'];
				$showtag = $_GET['showtag'];
				$pcatid = $_GET['pcatid'];
				if ( $myord == "" )
				{
								$myord = "uptime";
				}
				if ( $myshownums != "" && $myshownums != "0" )
				{
								$shownums = $myshownums;
				}
				$Temp = loadtemp( $tempname );
				$TempArr = splittbltemp( $Temp );
				$str = $TempArr['start'];
				$scl = " iffb='1' and memberid='{$mid}' ";
				if ( $pcatid != "0" && $pcatid != "" )
				{
								$scl .= " and pcatid='{$pcatid}' ";
				}
				if ( $key != "" )
				{
								$scl .= " and (title regexp '{$key}' or body regexp '{$key}') ";
				}
				if ( $showtag != "" )
				{
								$scl .= " and tags regexp '{$showtag}' ";
				}
				include_once( ROOTPATH."includes/pages.inc.php" );
			
				$pages = new pages( );
				$totalnums = tblcount( "_paper_con", "id", $scl );
				$pages->setvar( array(
								"mid" => $mid,
								"pcatid" => $pcatid,
								"myord" => $myord,
								"myshownums" => $myshownums,
								"key" => $key
				) );
				$pages->set( $shownums, $totalnums );
				$pagelimit = $pages->limit( );
				$fsql->query( "select * from {P}_paper_con where {$scl} order by {$myord} desc limit {$pagelimit}" );
				while ( $fsql->next_record( ) )
				{
								$id = $fsql->f( "id" );
								$title = $fsql->f( "title" );
								$catid = $fsql->f( "catid" );
								$catpath = $fsql->f( "catpath" );
								$dtime = $fsql->f( "dtime" );
								$nowcatid = $fsql->f( "catid" );
								$ifbold = $fsql->f( "ifbold" );
								$ifred = $fsql->f( "ifred" );
								$author = $fsql->f( "author" );
								$source = $fsql->f( "source" );
								$cl = $fsql->f( "cl" );
								$memo = $fsql->f( "memo" );
								$dtime = date( "Y-m-d", $dtime );
								$memo = nl2br( $memo );
								if ( $GLOBALS['CONF']['CatchOpen'] == "1" && file_exists( ROOTPATH."paper/html/".$id.".html" ) )
								{
												$link = ROOTPATH."paper/html/".$id.".html";
								}
								else
								{
												$link = ROOTPATH."paper/html/?".$id.".html";
								}
								if ( $ifbold == "1" )
								{
												$bold = " style='font-weight:bold' ";
								}
								else
								{
												$bold = "";
								}
								if ( $ifred != "0" )
								{
												$red = " style='color:".$ifred."' ";
								}
								else
								{
												$red = "";
								}
								if ( $cutword != "0" )
								{
												$title = csubstr( $title, 0, $cutword );
								}
								$var = array(
												"title" => $title,
												"dtime" => $dtime,
												"red" => $red,
												"author" => $author,
												"source" => $source,
												"src" => $src,
												"cl" => $cl,
												"link" => $link,
												"target" => $target,
												"memo" => $memo,
												"bold" => $bold
								);
								$str .= showtpltemp( $TempArr['list'], $var );
				}
				$str .= $TempArr['end'];
				$pagesinfo = $pages->ShowNow( );
				$var = array(
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