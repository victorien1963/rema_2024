<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/member.inc.php");

if($_GET["chk"] == "" || ($_GET["chk"] != "e" && $_GET["chk"] != "c") ){
	$_GET["chk"] = "e";
}

//SecureMember();

//�w�q�ҲզW�M�����W
if(islogin()){
	PageSet("member","account");
}else{
	PageSet("member","login");
}
//��X
PrintPage();

?>