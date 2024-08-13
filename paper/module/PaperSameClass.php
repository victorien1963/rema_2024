<?php
function PaperSameClass( )
{
				global $msql;
				global $fsql;
				$coltitle = $GLOBALS['PLUSVARS']['coltitle'];
				$shownums = $GLOBALS['PLUSVARS']['shownums'];
				$showtj = $GLOBALS['PLUSVARS']['showtj'];
				$target = $GLOBALS['PLUSVARS']['target'];
				$tempname = $GLOBALS['PLUSVARS']['tempname'];
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
				if ( $nowcatid != "0" )
				{
								$msql->query( "select pid from {P}_paper_cat where catid='{$nowcatid}'" );
								if ( $msql->next_record( ) )
								{
												$pid = $msql->f( "pid" );
								}
								else
								{
												$pid = 0;
								}
				}
				else
				{
								$pid = 0;
				}
				$scl = " pid='{$pid}' ";
				if ( $showtj != "" && $showtj != "0" )
				{
								$scl .= " and tj='1' ";
				}
				$Temp = loadtemp( $tempname );
				$TempArr = splittbltemp( $Temp );
				$var = array(
								"coltitle" => $coltitle
				);
				$str = showtpltemp( $TempArr['start'], $var );
				$msql->query( "select * from {P}_paper_cat where {$scl} order by xuhao" );
				while ( $msql->next_record( ) )
				{
								$pid = $msql->f( "pid" );
								$catid = $msql->f( "catid" );
								$cat = $msql->f( "cat" );
								$catpath = $msql->f( "catpath" );
								$ifchannel = $msql->f( "ifchannel" );
								if ( $ifchannel == "1" )
								{
												$link = ROOTPATH."paper/class/".$catid."/";
								}
								else if ( $GLOBALS['CONF']['CatchOpen'] == "1" && file_exists( ROOTPATH."paper/class/".$catid.".html" ) )
								{
												$link = ROOTPATH."paper/class/".$catid.".html";
								}
								else
								{
												$link = ROOTPATH."paper/class/?".$catid.".html";
								}
								$var = array(
												"link" => $link,
												"cat" => $cat,
												"target" => $target
								);
								$str .= showtpltemp( $TempArr['list'], $var );
				}
				$str .= $TempArr['end'];
				return $str;
}

?>