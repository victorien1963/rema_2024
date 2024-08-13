<?php
function PaperNavPath( )
{
				global $msql;
				global $strMemberPaper,$pathname,$file_path;
				$coltitle = $GLOBALS['PLUSVARS']['coltitle'];
				$tempname = $GLOBALS['PLUSVARS']['tempname'];
				$pagename = $GLOBALS['PLUSVARS']['pagename'];
				$Temp = loadtemp( $tempname );
				$TempArr = splittbltemp( $Temp );
				$var = array(
								"coltitle" => $coltitle,
								"sitename" => $GLOBALS['CONF']['SiteName']
				);
				$str = showtpltemp( $TempArr['start'], $var );
				if ( $GLOBALS['PAPERCONF']['ChannelNameInNav'] == "1" )
				{
								$var = array(
												"channel" => $GLOBALS['PAPERCONF']['ChannelName']
								);
								$str .= showtpltemp( $TempArr['col'], $var );
								$GLOBALS['GLOBALS']['pagetitle'] = $GLOBALS['PAPERCONF']['ChannelName'];
				}
				if ( $pagename == "query" )
				{
								if ( strstr( $_SERVER['QUERY_STRING'], ".html" ) )
								{
												$Arr = explode( ".html", $_SERVER['QUERY_STRING'] );
												$nowcatid = $Arr[0];
								}
								else if ( 0 < $_GET['catid'] )
								{
												$nowcatid = $_GET['catid'];
								}
								else
								{
												$nowcatid = 0;
								}
								$msql->query( "select catpath from {P}_paper_cat where catid='{$nowcatid}'" );
								if ( $msql->next_record( ) )
								{
												$catpath = $msql->f( "catpath" );
								}
								$array = explode( ":", $catpath );
								$cpnums = sizeof( $array ) - 1;
								$i = 0;
								for ( ;	$i < $cpnums;	++$i	)
								{
												$arr = $array[$i] + 0;
												$msql->query( "select * from {P}_paper_cat where catid='{$arr}'" );
												while ( $msql->next_record( ) )
												{
																$catid = $msql->f( "catid" );
																$cat = $msql->f( "cat" );
																$ifchannel = $msql->f( "ifchannel" );
																if ( $ifchannel == "1" )
																{
																				$url = ROOTPATH."paper/class/".$catid."/";
																}
																else if ( $GLOBALS['CONF']['CatchOpen'] == "1" && file_exists( ROOTPATH."paper/class/".$catid.".html" ) )
																{
																				$url = ROOTPATH."paper/class/".$catid.".html";
																}
																else
																{
																				$url = ROOTPATH."paper/class/?".$catid.".html";
																}
																$var = array(
																				"nav" => $cat,
																				"url" => $url
																);
																$str .= showtpltemp( $TempArr['list'], $var );
																$GLOBALS['pagetitle'] .= "-".$cat;
												}
								}
				}
				if ( $pagename == "detail" )
				{
								if ( strstr( $_SERVER['QUERY_STRING'], ".html" ) )
								{
												$idArr = explode( ".html", $_SERVER['QUERY_STRING'] );
												$id = $idArr[0];
								}
								else if ( isset( $_GET['id'] ) && $_GET['id'] != "" )
								{
												$id = $_GET['id'];
								}
								$msql->query( "select title from {P}_paper_con where id='{$id}'" );
								if ( $msql->next_record( ) )
								{
												$title = $msql->f( "title" );
								}
								$var = array(
												"nav" => $title
								);
								$str .= showtpltemp( $TempArr['con'], $var );
								$GLOBALS['GLOBALS']['pagetitle'] = $title;
				}
				if ( substr( $pagename, 0, 6 ) == "class_" )
				{
								$var = array(
												"nav" => $GLOBALS['PSET']['name']
								);
								$str .= showtpltemp( $TempArr['con'], $var );
								$GLOBALS['GLOBALS']['pagetitle'] = $GLOBALS['PSET']['name'];
				}
				if ( substr( $pagename, 0, 5 ) == "proj_" )
				{
								$var = array(
												"nav" => $GLOBALS['PSET']['name']
								);
								$str .= showtpltemp( $TempArr['con'], $var );
								$GLOBALS['GLOBALS']['pagetitle'] = $GLOBALS['PSET']['name'];
				}
				if ( $pagename == "memberpaper" )
				{
								if ( $_GET['mid'] != "" )
								{
												$msql->query( "select pname from {P}_member where memberid='".$_GET['mid']."'" );
												if ( $msql->next_record( ) )
												{
																$pname = $msql->f( "pname" );
												}
								}
								$var = array(
												"nav" => $pname.$strMemberPaper
								);
								$str .= showtpltemp( $TempArr['con'], $var );
								$GLOBALS['GLOBALS']['pagetitle'] = $pname.$strMemberPaper;
				}
				$str .= $TempArr['end'];
				return $str;
}

?>