<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include(ROOTPATH."member/includes/member.inc.php");
include("language/".$sLan.".php");
include("includes/news.inc.php");

SecureMember();

//定義模組名和頁面名
PageSet("member","newsgl");


//輸出
PrintPage();


?>