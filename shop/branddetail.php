<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/shop.inc.php");


//定義模組名和頁面名
PageSet("shop","branddetail");


//輸出
PrintPage();


?>