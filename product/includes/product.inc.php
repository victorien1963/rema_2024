<?php


ProductConfig();


//模組參數設置
function ProductConfig(){

	global $msql;

	$msql->query("select * from {P}_product_config");
	while($msql->next_record()){
	
	$variable=$msql->f('variable');
	$value=$msql->f('value');
	$GLOBALS["PRODUCTCONF"][$variable]=$value;
	}

}


//上傳圖片

function ProductUploadImage($jpg,$jpg_type,$jpg_size,$path){

	
	global $strUploadNotice1,$strUploadNotice2,$strUploadNotice3;

	
	if ($jpg_size == 0) {

			$arr[0]="err";
			$arr[1]=$strUploadNotice1;
			return $arr;

	}

	
	if ($jpg_size > $GLOBALS["PRODUCTCONF"]["PicSizeLimit"]) {
			$arr[0]="err";
			$arr[1]=$strUploadNotice2;
			return $arr;
	}

	if ($jpg_type != "image/pjpeg" && $jpg_type != "image/jpeg" && $jpg_type!= "image/gif" && $jpg_type != "image/x-png" && $jpg_type != "application/x-shockwave-flash") {
			$arr[0]="err";
			$arr[1]=$strUploadNotice3;
			return $arr;
	}
		
	switch ($jpg_type) {

			case "image/pjpeg" : 
			$extention = ".jpg";
			$UploadImage[2]="gif";
			break;

			case "image/gif" : 
			$extention = ".gif";
			$UploadImage[2]="gif";
			break;

			case "image/x-png" : 
			$extention = ".png";
			$UploadImage[2]="gif";
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


function pstarnums($n,$RP){


	$str="";

	if($n<0.5){
		$str='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
	}

	if($n>=0.5 && $n<1.0){
		$str='<img src='.$RP.'product/templates/images/icon_star_3.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
	}

	if($n>=1.0 && $n<1.5){
		$str='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
	}

	if($n>=1.5 && $n<2.0){
		$str='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_3.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
	}

	if($n>=2.0 && $n<2.5){
		$str='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
	}

	if($n>=2.5 && $n<3.0){
		$str='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_3.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
	}

	if($n>=3.0 && $n<3.5){
		$str='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
	}

	if($n>=3.5 && $n<4.0){
		$str='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_3.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
	}

	if($n>=4.0 && $n<4.5){
		$str='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_1.gif>';
	}
	
	if($n>=4.5 && $n<5.0){
		$str='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_3.gif>';
	}

	if($n>=5.0){
		$str='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
		$str.='<img src='.$RP.'product/templates/images/icon_star_2.gif>';
	}
		
	return $str;

}


?>