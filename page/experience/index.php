<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/common.inc.php");
include("../language/".$sLan.".php");
include("../includes/pagetourl.php");
PageToUrl();
//定義模組名和頁面名
PageSet("page","experience");

//輸出
PrintPage();

?>