<?php
define("ROOTPATH", "../../../");
include(ROOTPATH."includes/common.inc.php");
include("../../language/".$sLan.".php");
include("../../includes/product.inc.php");

//模組名和頁面名
PageSet("product","TEMP");

//輸出
PrintPage();

?>