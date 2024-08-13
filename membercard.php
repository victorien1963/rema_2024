<?php
define("ROOTPATH", "");
include(ROOTPATH."includes/common.inc.php");

/*$getInput = file_get_contents("php://input");
file_put_contents('BBB.txt', $getInput);*/

extract($_POST);
//card_ban //統編
//card_no1 //載具明碼(會員EMAIL)
//card_no2 //載具隱碼(會員ID)
//card_typ //載具類別編號
//token //驗證(時間戳)

$card_no1 = base64_decode($card_no1);
$card_no2 = base64_decode($card_no2);

//第一次驗證
if(!$rtn_flag){
	$msql->query("select * from {P}_member where memberid='$card_no2' and email='$card_no1' and cardtoken='$token'");
	if($msql->next_record()){
		exit("Y");
	}else{
		exit("N");
	}
//接收第二次回傳
}elseif($rtn_flag == "Y"){
	//歸戶成功
	$msql->query("select * from {P}_member where memberid='$card_no2' and email='$card_no1'");
	if($msql->next_record()){
		$msql->query("UPDATE {P}_member SET cardtoken='OK' where memberid='$card_no2' ");
	}
}else{
	//歸戶失敗
}

?>