<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/member.inc.php");


//定義模組名和頁面名
if(islogin()){
PageSet("member","main");
}else{
PageSet("member","reg");
}

//輸出
PrintPage();


?>