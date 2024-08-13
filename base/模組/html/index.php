<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/common.inc.php");
include("../language/".$sLan.".php");
include("../includes/模組名稱.inc.php");

if ( strstr( $_SERVER['QUERY_STRING'], ".html" ) )
{
				$idArr = explode( ".html", $_SERVER['QUERY_STRING'] );
				$id = $idArr[0];
}

if($_GET['catid']){ $id = $_GET['catid']; }

if($id){
	$fsql->query( "select catpath from {P}_模組名稱_con where id='{$id}' limit 0,1" );
	if ( $fsql->next_record( ) )
	{
				$catpath = explode(":",$fsql->f( "catpath" ));
				foreach($catpath AS $cats){
					$cats = $cats-0;
					$tsql->query( "select cattemp from {P}_模組名稱_cat where catid='{$cats}' limit 0,1" );
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
	PageSet("模組名稱","detail_".$cat);
}else{
	PageSet("模組名稱","detail");
}

//輸出
PrintPage();

?>