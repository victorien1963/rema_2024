<?php
function PaperProject( )
{
				global $msql;
				global $fsql,$pathname,$file_path;
				$coltitle = $GLOBALS['PLUSVARS']['coltitle'];
				$target = $GLOBALS['PLUSVARS']['target'];
				$tempname = $GLOBALS['PLUSVARS']['tempname'];
				$cutword = $GLOBALS['PLUSVARS']['cutword'];
				$Temp = loadtemp( $tempname );
				$TempArr = splittbltemp( $Temp );
				$var = array(
								"coltitle" => $coltitle
				);
				$str = showtpltemp( $TempArr['start'], $var );
				$msql->query( "select * from {P}_paper_proj order by id desc" );
				while ( $msql->next_record( ) )
				{
								$id = $msql->f( "id" );
								$project = $msql->f( "project" );
								$folder = $msql->f( "folder" );
								if ( $cutword != "0" )
								{
												$project = csubstr( $project, 0, $cutword );
								}
								$link = ROOTPATH."paper/project/".$folder."/";
								$var = array(
												"link" => $link,
												"project" => $project,
												"target" => $target
								);
								$str .= showtpltemp( $TempArr['list'], $var );
				}
				$str .= $TempArr['end'];
				return $str;
}

?>