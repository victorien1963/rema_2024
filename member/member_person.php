<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/member.inc.php");
//SecureMember();

//�w�q�ҲզW�M�����W
if(islogin()){
	PageSet("member","person");
}else{
	PageSet("member","login");
}
//��X
PrintPage();

?>