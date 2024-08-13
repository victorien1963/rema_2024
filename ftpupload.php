<?php
define("ROOTPATH", "");
include(ROOTPATH."includes/common.inc.php");

//updateposdata();

function updateposdata(){
	global $tsql,$wsql;
	
	//檢測ftp是否開啟
	$wsql->query("SELECT * FROM {P}_base_config WHERE `variable`='ftpConnect'");
	if($wsql->next_record()){
		if($wsql->f("value") == "0"){
			return false;
		}
	}
	
	
	### 前台銷退貨路徑
	$shop_GO = ROOTPATH."shop/ftplog_GO/";
	$shop_GS = ROOTPATH."shop/ftplog_GS/";
	$shop_GR = ROOTPATH."shop/ftplog_GR/";
	//$shop_GT = ROOTPATH."shop/ftplog_GT/";
	### 後台退貨路徑
	$admin_GO = ROOTPATH."shop/admin/ftplog_GO/";
	$admin_GS = ROOTPATH."shop/admin/ftplog_GS/";
	$admin_GR = ROOTPATH."shop/admin/ftplog_GR/";
	//$admin_GT = ROOTPATH."shop/admin/ftplog_GT/";
	
	
	### 連接的 FTP 伺服器是 localhost
	$conn_id = ftp_connect($GLOBALS['GLOBALS']['CONF'][ftpAddress]);
	 
	### 登入 FTP, 帳號是 USERNAME, 密碼是 PASSWORD
	$login_result = ftp_login($conn_id, $GLOBALS['GLOBALS']['CONF'][ftpAccount], $GLOBALS['GLOBALS']['CONF'][ftpPassword]);
	
	### 上傳訂單 GO
	$arraylist = glob($shop_GO."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### 上傳檔案
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GO/".$filename, $fp, FTP_BINARY))
		{
			@unlink($files);
		}
	}
	
	### 上傳銷貨 GS
	$arraylist = glob($shop_GS."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### 上傳檔案
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GS/".$filename, $fp, FTP_BINARY))
		{
			@unlink($files);
		}
	}
	
	### 上傳銷退 GR
	$arraylist = glob($shop_GR."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### 上傳檔案
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GR/".$filename, $fp, FTP_BINARY))
		{
			@unlink($files);
		}
	}
	
	### 上傳退貨 GT
	/*$arraylist = glob($shop_GT."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### 上傳檔案
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GT/".$filename, $fp, FTP_BINARY))
		{
			@unlink($files);
		}
	}*/
	
	### 上傳後台銷貨 GO
	$arraylist = glob($admin_GO."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### 上傳檔案
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GO/".$filename, $fp, FTP_BINARY))
		{
			@unlink($files);
		}
	}
	### 上傳後台銷貨 GS
	$arraylist = glob($admin_GS."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### 上傳檔案
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GS/".$filename, $fp, FTP_BINARY))
		{
			@unlink($files);
		}
	}
	
	### 上傳後台銷退 GR
	$arraylist = glob($admin_GR."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### 上傳檔案
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GR/".$filename, $fp, FTP_BINARY))
		{
			@unlink($files);
		}
	}
	
	### 上傳後台退貨 GT
	/*$arraylist = glob($admin_GT."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### 上傳檔案
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GT/".$filename, $fp, FTP_BINARY))
		{
			@unlink($admin_GT.$files);
		}
	}*/
	
	ftp_close($conn_id);
	fclose($fp);
	
	return true;
}
?>