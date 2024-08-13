<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/shop.inc.php");
include(ROOTPATH."member/includes/member.inc.php");
//SecureMember();

//定義模組名和頁面名
if(islogin()){
	PageSet("shop","startorder");
}else{
	PageSet("member","login");
}

//輸出
PrintPage();

//var_dump($_COOKIE);

?>