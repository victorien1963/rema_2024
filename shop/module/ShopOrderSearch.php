<?php

/*
	[元件名稱] 非會員訂單查詢
*/


function ShopOrderSearch(){

	
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];


	$Temp=LoadTemp($tempname);

	return $Temp;


}
?>