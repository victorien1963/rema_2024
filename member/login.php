<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/member.inc.php");

//�w�q�ҲզW�M�����W
if(islogin()){
PageSet("member","main");
}else{
PageSet("member","login");
}
//��X
PrintPage();

?>