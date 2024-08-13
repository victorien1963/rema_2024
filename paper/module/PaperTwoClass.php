<?php
function PaperTwoClass( )
{
				global $msql;
				global $fsql;
				global $tsql,$pathname,$file_path;
				$catid = $GLOBALS['PLUSVARS']['catid'];
				$showtj = $GLOBALS['PLUSVARS']['showtj'];
				$target = $GLOBALS['PLUSVARS']['target'];
				$tempname = $GLOBALS['PLUSVARS']['tempname'];
				if ( $catid != 0 && $catid != "" )
				{
								$scl = " pid='{$catid}' ";
				}
				else
				{
								$scl = " pid='0' ";
				}
				if ( $showtj != "" && $showtj != "0" )
				{
								$scl .= " and tj='1' ";
								$subscl = " and tj='1' ";
				}
				$Temp = loadtemp( $tempname );
				$TempArr = splittbltemp( $Temp );
				$str = $TempArr['start'];
				$msql->query( "select * from {P}_paper_cat where {$scl} order by xuhao" );
				while ( $msql->next_record( ) )
				{
								$catid = $msql->f( "catid" );
								$cat = $msql->f( "cat" );
								$catpath = $msql->f( "catpath" );
								$ifchannel = $msql->f( "ifchannel" );
								if ( $ifchannel == "1" )
								{
												$toplink = ROOTPATH."paper/class/".$catid."/";
								}
								else if ( $GLOBALS['CONF']['CatchOpen'] == "1" && file_exists( ROOTPATH."paper/class/".$catid.".html" ) )
								{
												$toplink = ROOTPATH."paper/class/".$catid.".html";
								}
								else
								{
												$toplink = ROOTPATH."paper/class/?".$catid.".html";
								}
								$tsql->query( "select count(id) from {P}_paper_con where iffb='1' and catid!='0' and  catpath regexp '".fmpath( $catpath )."'" );
								if ( $tsql->next_record( ) )
								{
												$topcount = $tsql->f( "count(id)" );
								}
								$sublinkstr = "";
								$fsql->query( "select * from {P}_paper_cat where pid='{$catid}' {$subscl} order by xuhao" );
								while ( $fsql->next_record( ) )
								{
												$scatid = $fsql->f( "catid" );
												$scat = $fsql->f( "cat" );
												$scatpath = $fsql->f( "catpath" );
												$sifchannel = $fsql->f( "ifchannel" );
												if ( $sifchannel == "1" )
												{
																$slink = ROOTPATH."paper/class/".$scatid."/";
												}
												else if ( $GLOBALS['CONF']['CatchOpen'] == "1" && file_exists( ROOTPATH."paper/class/".$scatid.".html" ) )
												{
																$slink = ROOTPATH."paper/class/".$scatid.".html";
												}
												else
												{
																$slink = ROOTPATH."paper/class/?".$scatid.".html";
												}
												$tsql->query( "select count(id) from {P}_paper_con where iffb='1' and catid!='0' and  catpath regexp '".fmpath( $scatpath )."'" );
												if ( $tsql->next_record( ) )
												{
																$subcount = $tsql->f( "count(id)" );
												}
												$substr = str_replace( "{#slink#}", $slink, $TempArr['list'] );
												$substr = str_replace( "{#target#}", $target, $substr );
												$substr = str_replace( "{#scat#}", $scat, $substr );
												$substr = str_replace( "{#subcount#}", $subcount, $substr );
												$sublinkstr .= $substr;
								}
								$var = array(
												"toplink" => $toplink,
												"cat" => $cat,
												"topcount" => $topcount,
												"sublinkstr" => $sublinkstr,
												"target" => $target
								);
								$str .= showtpltemp( $TempArr['menu'], $var );
				}
				$str .= $TempArr['end'];
				return $str;
}

?>