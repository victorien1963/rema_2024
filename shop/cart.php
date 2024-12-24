<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/shop.inc.php");

//�w�q�ҲզW�M�����W

if(islogin()){
	PageSet("shop","cartNew");
}else{
	PageSet("member","login");
}

//��X
PrintPage();

?>