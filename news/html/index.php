<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/common.inc.php");
include("../language/".$sLan.".php");
include("../includes/news.inc.php");

//網址轉發(1.4.3/20100922)
NewsToUrl();
				if ( strstr( $_SERVER['QUERY_STRING'], ".html" ) )
				{
								$idArr = explode( ".html", $_SERVER['QUERY_STRING'] );
								$id = $idArr[0];
				}
				if($_GET['catid']){ $id = $_GET['catid']; }
				if($id){
					$fsql->query( "select catpath from {P}_news_con where id='{$id}' limit 0,1" );
					if ( $fsql->next_record( ) )
					{
								$catpath = explode(":",$fsql->f( "catpath" ));
								foreach($catpath AS $cats){
									$cats = $cats-0;
									$tsql->query( "select cattemp from {P}_news_cat where catid='{$cats}' limit 0,1" );
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
	PageSet("news","detail_".$cat);
}else{
	PageSet("news","detail");
}

//輸出
PrintPage();

?>