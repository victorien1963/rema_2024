<?php
header("Location: class/" );

define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/shop.inc.php");


//�w�q�ҲզW�M�����W
PageSet("shop","main");


//��X
PrintPage();


?>