<?php

define("ROOTPATH", "../");

include(ROOTPATH."includes/common.inc.php");

include("language/".$sLan.".php");

include("includes/member.inc.php");

SecureMember();



//�w�q�ҲզW�M�����W

PageSet("member","main");



//��X

PrintPage();



?>

