<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/common.inc.php");
include("../language/".$sLan.".php");
include("../includes/�ҲզW��.inc.php");

if ( strstr( $_SERVER['QUERY_STRING'], ".html" ) )
{
				$idArr = explode( ".html", $_SERVER['QUERY_STRING'] );
				$id = $idArr[0];
}

if($_GET['catid']){ $id = $_GET['catid']; }

if($id){
	$fsql->query( "select catpath from {P}_�ҲզW��_con where id='{$id}' limit 0,1" );
	if ( $fsql->next_record( ) )
	{
				$catpath = explode(":",$fsql->f( "catpath" ));
				foreach($catpath AS $cats){
					$cats = $cats-0;
					$tsql->query( "select cattemp from {P}_�ҲզW��_cat where catid='{$cats}' limit 0,1" );
						if ( $tsql->next_record( ) )
						{
							$cat = $tsql->f( "cattemp" )? $cats:$cat;
						}
				}
				
	}
}
				
//�w�q�ҲզW�M�����W
if($cat)
{
	PageSet("�ҲզW��","detail_".$cat);
}else{
	PageSet("�ҲզW��","detail");
}

//��X
PrintPage();

?>