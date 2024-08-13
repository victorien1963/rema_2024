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
					$fsql->query( "select cattemp from {P}_comment_cat where catid='{$id}' limit 0,1" );
					if ( $fsql->next_record( ) )
					{				
								$cat = $fsql->f( "cattemp" )? $id:"";
					}
				}
//定義模組名和頁面名			
if($cat)
{
	PageSet( "comment", "query_".$cat );
}else{
	PageSet("comment","query");
}
//輸出
PrintPage();

?>