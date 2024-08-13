<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/comment.inc.php");


//定義模組名和頁面名
PageSet("comment","main");


//輸出
PrintPage();


?>