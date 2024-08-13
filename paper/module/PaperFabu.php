<?php
function PaperFabu( )
{
				global $msql;
				global $fsql;
				global $tsql;
				$coltitle = $GLOBALS['PLUSVARS']['coltitle'];
				$tempname = $GLOBALS['PLUSVARS']['tempname'];
				$memberid = $_COOKIE['MEMBERID'];
				$fsql->query( "select * from {P}_paper_pcat where memberid='{$memberid}' order by xuhao" );
				while ( $fsql->next_record( ) )
				{
								$pcatid = $fsql->f( "catid" );
								$pcat = $fsql->f( "cat" );
								$pcatlist .= "<option value='".$pcatid."'>".$pcat."</option>";
				}
				$secureset = secureclass( "126" );
				$fsql->query( "select * from {P}_paper_cat order by catpath" );
				while ( $fsql->next_record( ) )
				{
								$lpid = $fsql->f( "pid" );
								$lcatid = $fsql->f( "catid" );
								$cat = $fsql->f( "cat" );
								$catpath = $fsql->f( "catpath" );
								$lcatpath = explode( ":", $catpath );
								if ( strstr( $secureset, ":".intval( $lcatpath[0] ).":" ) )
								{
												$i = 0;
												for ( ;	$i < sizeof( $lcatpath ) - 2;	++$i	)
												{
																$lcatpath[$i] = intval( $lcatpath[$i] );
																$tsql->query( "select catid,cat from {P}_paper_cat where catid='{$lcatpath[$i]}'" );
																if ( $tsql->next_record( ) )
																{
																				$ncatid = $tsql->f( "cat" );
																				$ncat = $tsql->f( "cat" );
																				$ppcat .= $ncat."/";
																}
												}
												if ( $pid == $lcatid )
												{
																$catlist .= "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
												}
												else
												{
																$catlist .= "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
												}
												$ppcat = "";
								}
				}
				$fsql->query( "select * from {P}_paper_proj order by id desc" );
				while ( $fsql->next_record( ) )
				{
								$projid = $fsql->f( "id" );
								$project = $fsql->f( "project" );
								$NowPath = fmpath( $projid );
								$musellist .= "<option value=".$NowPath.">".$project."</option>";
				}
				$Temp = loadtemp( $tempname );
				$var = array(
								"pname" => $_COOKIE['MEMBERPNAME'],
								"pcatlist" => $pcatlist,
								"catlist" => $catlist,
								"musellist" => $musellist
				);
				$str .= showtpltemp( $Temp, $var );
				return $str;
}

?>