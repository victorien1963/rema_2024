<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/news.inc.php");


//定義模組名和頁面名
PageSet("news","membernews");


//輸出
PrintPage();


?>