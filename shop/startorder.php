<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/shop.inc.php");
include(ROOTPATH."member/includes/member.inc.php");
//SecureMember();
//�w�q�ҲզW�M�����W
if(islogin()){
	PageSet("shop","startorder");
}else{
	PageSet("member","login");
}

//��X
PrintPage();

//var_dump($_COOKIE);

?>