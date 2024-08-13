<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/member.inc.php");

$mid=$_GET["mid"];

//定義模組名和頁面名
PageSet("member","homepage");

//輸出
PrintPage();

?>
