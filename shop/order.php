<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/shop.inc.php");

//SecureMember();

//�w�q�ҲզW�M�����W
if(islogin()){
	PageSet("member","shoporder");
}else{
	PageSet("member","login");
}

//��X
PrintPage();


?>