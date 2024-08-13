<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/member.inc.php");
//SecureMember();

//定義模組名和頁面名
if(islogin()){
	PageSet("member","epaper");
}else{
	PageSet("member","login");
}
//輸出
PrintPage();

?>