<?php
define("ROOTPATH", "../../../");
include(ROOTPATH."includes/common.inc.php");
include("../../language/".$sLan.".php");
include("../../includes/模組名稱.inc.php");

//定義模組名和頁面名
PageSet("模組名稱","TEMP");

//輸出
PrintPage();

?>