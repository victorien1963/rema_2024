<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/common.inc.php");
include("../language/".$sLan.".php");
include("../includes/pagetourl.php");
PageToUrl();
//�w�q�ҲզW�M�����W
PageSet("page","faq_main");

//��X
PrintPage();

?>