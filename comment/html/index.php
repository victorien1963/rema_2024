<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/common.inc.php");
include("../language/".$sLan.".php");
include("../includes/comment.inc.php");

				if ( strstr( $_SERVER['QUERY_STRING'], ".html" ) )
				{
								$idArr = explode( ".html", $_SERVER['QUERY_STRING'] );
								$id = $idArr[0];
				}
				if($_GET['catid']){ $id = $_GET['catid']; }
				if($id){
					$fsql->query( "select catid from {P}_comment where id='{$id}' limit 0,1" );
					if ( $fsql->next_record( ) )
					{
								$cat = $fsql->f( "catid" );
								$tsql->query( "select cattemp from {P}_comment_cat where catid='{$cat}' limit 0,1" );
								if ( $tsql->next_record( ) )
								{
									$cat = $tsql->f( "cattemp" )? $cat:"";
								}
								
					}
				}
//定義模組名和頁面名
if($cat)
{
	PageSet("comment","detail_".$cat);
}else{
	PageSet("comment","detail");
}

//輸出
PrintPage();

?>