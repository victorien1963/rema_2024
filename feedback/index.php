<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
//定義模組名和頁面名

				if ( $_REQUEST['groupid'] )
				{
					$fsql->query( "select cattemp from {P}_feedback_group where id='{$_REQUEST[groupid]}' limit 0,1" );
					if ( $fsql->next_record( ) )
					{
								$cat = $fsql->f('cattemp')? $_REQUEST['groupid']:"";
					}
				}
if($cat)
{
	PageSet("feedback","main_".$cat);
}else{
	PageSet("feedback","main");
}

//輸出
PrintPage();

?>