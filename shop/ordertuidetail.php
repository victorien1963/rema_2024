<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/shop.inc.php");


//定義模組名和頁面名
if(islogin()){
	PageSet("member","shopordertuidetail");
}else{
	PageSet("member","login");
}


//輸出
PrintPage();


?>