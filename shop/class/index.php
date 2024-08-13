<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/common.inc.php");
include("../language/".$sLan.".php");
include("../includes/shop.inc.php");

				if ( strstr( $_SERVER['QUERY_STRING'], ".html" ) )
				{
								$idArr = explode( ".html", $_SERVER['QUERY_STRING'] );
								$id = $idArr[0];
				}
				if($_GET['catid']){ $id = $_GET['catid']; }
				if($id){ 
					$fsql->query( "select catpath from {P}_shop_cat where catid='{$id}' limit 0,1" );
					if ( $fsql->next_record( ) )
					{				
								$catpath = explode(":",$fsql->f( "catpath" ));
								foreach($catpath AS $cats){
									$cats = $cats-0;
									$tsql->query( "select cattemp from {P}_shop_cat where catid='{$cats}' limit 0,1" );
										if ( $tsql->next_record( ) )
										{
											$cat = $tsql->f( "cattemp" )? $cats:$cat;
										}
								}
					}
				}
//定義模組名和頁面名			
if($cat)
{
	PageSet( "shop", "query_".$cat );
}else{
	PageSet("shop","query");
}
//輸出
PrintPage();

?>