<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include(ROOTPATH."member/includes/member.inc.php");
include("language/".$sLan.".php");
include("includes/product.inc.php");

SecureMember();

//�w�q�ҲզW�M�����W
PageSet("member","productmodify");


//��X
PrintPage();


?>