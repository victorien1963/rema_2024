<?php

///////////�W�Ǥ����

function NewUploadFile($jpg,$jpg_type,$fname,$jpg_size,$path){

	global $strDownNotice9,$strDownNotice11; 

	if ($jpg_size == 0) {
		err($strDownNotice9,"","");
	}

	if (substr($fname,-4)!=".rar" && substr($fname,-4)!=".zip" && substr($fname,-4)!=".doc" && substr($fname,-4)!=".xls" && substr($fname,-4)!=".htm" && substr($fname,-5)!=".html" && substr($fname,-4)!=".gif" && substr($fname,-4)!=".jpg" && substr($fname,-4)!=".png" && substr($fname,-4)!=".chm" && substr($fname,-4)!=".txt" && substr($fname,-4)!=".mid" && substr($fname,-4)!=".xml") {
			err($strDownNotice11,"","");
	}
	
	
	$hzarr=explode(".",$fname);
	$num=sizeof($hzarr)-1;
	$UploadImage[2]=$hzarr[$num];
		
 
		
		$timestr=time();
		$hz=substr($fname,-4);

		$file_path = ROOTPATH.$path."/".$timestr.$hz;
		$UploadImage[3] = $path."/".$timestr.$hz;
		
		copy ($jpg,$file_path);
		chmod ($file_path,0666);
		
		$UploadImage[0]="";
		$UploadImage[1]="";

		return $UploadImage;

}

///////////�W�ǹϤ���FLASH���

function NewUploadImage($jpg,$jpg_type,$jpg_size,$path){

	
	global $strUploadNotice1,$strUploadNotice2,$strUploadNotice3;

	if ($jpg_size == 0) {

		err($strUploadNotice1,"","");

	}
	
	if ($jpg_size > 2040000) {

		err($strUploadNotice2,"","");

	}

	if ($jpg_type != "image/pjpeg" && $jpg_type != "image/jpeg" && $jpg_type != "image/jpg" && $jpg_type!= "image/gif" && $jpg_type != "image/x-png" && $jpg_type != "image/png" && $jpg_type != "application/x-shockwave-flash") {
				err($strUploadNotice3,"","");
	}
		
	switch ($jpg_type) {

			case "image/pjpeg" : 
			$extention = ".jpg";
			$UploadImage[2]="jpg";
			break;
			
			case "image/jpeg" : 
			$extention = ".jpg";
			$UploadImage[2]="jpg";
			break;
			
			case "image/jpg" : 
			$extention = ".jpg";
			$UploadImage[2]="jpg";
			break;

			case "image/gif" : 
			$extention = ".gif";
			$UploadImage[2]="gif";
			break;

			case "image/x-png" : 
			$extention = ".png";
			$UploadImage[2]="gif";
			break;
			
			case "image/png" : 
			$extention = ".png";
			$UploadImage[2]="png";
			break;

			case "application/x-shockwave-flash" : 
			$extention = ".swf";
			$UploadImage[2]="swf";
			break;
	}
			 
		$fname=time();
		$fname=$fname.$extention;
		$file_path = ROOTPATH.$path."/".$fname;
		$UploadImage[3] = $path."/".$fname;
		
		copy ($jpg,$file_path);
		chmod ($file_path,0666);
		
		$size = GetImageSize($file_path);
		if($size[0]>0 && $size[1]>0){
			
			$UploadImage[0]=$size[0];
			$UploadImage[1]=$size[1];
	
		}else{

			$UploadImage[0]=50;
			$UploadImage[1]=50;

		}
		return $UploadImage;

}
function updateposdata(){
	global $tsql,$wsql;
	
	### �e�x�P�h�f���|
	$shop_GO = ROOTPATH."shop/ftplog_GO/";
	$shop_GS = ROOTPATH."shop/ftplog_GS/";
	$shop_GR = ROOTPATH."shop/ftplog_GR/";
	//$shop_GT = ROOTPATH."shop/ftplog_GT/";
	### ��x�h�f���|
	$admin_GS = ROOTPATH."shop/admin/ftplog_GS/";
	$admin_GR = ROOTPATH."shop/admin/ftplog_GR/";
	//$admin_GT = ROOTPATH."shop/admin/ftplog_GT/";
	
	
	### �s���� FTP ���A���O localhost
	$conn_id = ftp_connect($GLOBALS['GLOBALS']['CONF'][ftpAddress]);
	 
	### �n�J FTP, �b���O USERNAME, �K�X�O PASSWORD
	$login_result = ftp_login($conn_id, $GLOBALS['GLOBALS']['CONF'][ftpAccount], $GLOBALS['GLOBALS']['CONF'][ftpPassword]);
	
	### �W�ǭq�� GO
	$arraylist = glob($shop_GO."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### �W���ɮ�
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GO/".$filename, $fp, FTP_BINARY))
		{
			@unlink($files);
		}
	}
	
	### �W�ǾP�f GS
	$arraylist = glob($shop_GS."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### �W���ɮ�
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GS/".$filename, $fp, FTP_BINARY))
		{
			@unlink($shop_GS.$files);
		}
	}
	
	### �W�ǾP�h GR
	$arraylist = glob($shop_GR."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### �W���ɮ�
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GR/".$filename, $fp, FTP_BINARY))
		{
			@unlink($shop_GR.$files);
		}
	}
	
	### �W�ǰh�f GT
	/*$arraylist = glob($shop_GT."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### �W���ɮ�
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GT/".$filename, $fp, FTP_BINARY))
		{
			@unlink($shop_GT.$files);
		}
	}*/
	
	
	### �W�ǫ�x�P�f GS
	$arraylist = glob($admin_GS."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### �W���ɮ�
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GS/".$filename, $fp, FTP_BINARY))
		{
			@unlink($admin_GS.$files);
		}
	}
	
	### �W�ǫ�x�P�h GR
	$arraylist = glob($admin_GR."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### �W���ɮ�
		$filename = basename($files);
		if(ftp_fput($conn_id, "ImportData/GR/".$filename, $fp, FTP_BINARY))
		{
			@unlink($admin_GR.$files);
		}
	}
	
	### �W�ǫ�x�h�f GT
	/*$arraylist = glob($admin_GT."*.xls");
	foreach( $arraylist AS $files ){
		$fp = fopen($files, 'r');
		### �W���ɮ�
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