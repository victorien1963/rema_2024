<?php
///////////上傳文件函數

function NewUploadFile($jpg,$jpg_type,$fname,$jpg_size,$path){

	global $strDownNotice9,$strDownNotice11,$strDownNotice12; 

	if ($jpg_size == 0) {

		$arr[0]="err";
		$arr[1]=$strDownNotice9;
		return $arr;

	}

	if (substr($fname,-4)!=".rar" && substr($fname,-4)!=".zip" && substr($fname,-4)!=".doc" && substr($fname,-4)!=".xls" && substr($fname,-4)!=".htm" && substr($fname,-5)!=".html" && substr($fname,-4)!=".gif" && substr($fname,-4)!=".jpg" && substr($fname,-4)!=".png" && substr($fname,-4)!=".chm" && substr($fname,-4)!=".txt" && substr($fname,-4)!=".pdf" && substr($fname,-5)!=".docx" && substr($fname,-5)!=".pptx" && substr($fname,-4)!=".ppt") {
			$arr[0]="err";
			$arr[1]=$strDownNotice11;
			return $arr;
			
	}
	
	
	$hzarr=explode(".",$fname);
	$num=sizeof($hzarr)-1;
	$UploadImage[2]=$hzarr[$num];
		
 
		
		$timestr=time();
		$hz=substr($fname,-4);

		/*$file_path = ROOTPATH.$path."/".$timestr.$hz;
		$UploadImage[3] = $path."/".$timestr.$hz;*/
		
		$file_path = ROOTPATH.$path."/".$fname;
		$UploadImage[3] = $path."/".$fname;
		
		copy ($jpg,$file_path);
		chmod ($file_path,0666);
		
		$UploadImage[0]="OK";
		$UploadImage[1]="OK";

		return $UploadImage;

}

function check_animation($image_file){
$fp = fopen($image_file, 'rb');
$image_head = fread($fp,1024);
fclose($fp);
return preg_match("/".chr(0x21).chr(0xff).chr(0x0b).'NETSCAPE2.0'."/",$image_head)  ? true : false;
}

function ImageResize($from_filename, $save_filename, $in_width=800, $in_height=600, $quality=88)
{
    $allow_format = array('jpeg', 'jpg', 'png', 'gif');
    $sub_name = $t = '';

    $img_info = getimagesize($from_filename);
    $width    = $img_info['0'];
    $height   = $img_info['1'];
    $imgtype  = $img_info['2'];
    $imgtag   = $img_info['3'];
    $bits     = $img_info['bits'];
    $channels = $img_info['channels'];
    $mime     = $img_info['mime'];

    list($t, $sub_name) = split('/', $mime);
    if ($sub_name == 'jpg') {
       		 $sub_name = 'jpeg';
    }

    if (!in_array($sub_name, $allow_format)) {
        return false;
    }

    $percent = getResizePercent($width, $height, $in_width, $in_height);
    $new_width  = $width * $percent;
    $new_height = $height * $percent;

    $image_new = imagecreatetruecolor($new_width, $new_height);

    if ($sub_name == 'jpg' || $sub_name == 'jpeg') {
    $image = imagecreatefromjpeg($from_filename);

    imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    return imagejpeg($image_new, $save_filename, $quality);
    }elseif($sub_name == 'gif') {
    		$image = imagecreatefromgif($from_filename);
			$bgcolor=ImageColorAllocate($image_new,0,0,0);
			ImageColorTransparent($image_new,$bgcolor) ;

    		imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    		return imagegif($image_new, $save_filename);
    }elseif($sub_name == 'png') {
    	    $image = imagecreatefrompng($from_filename);
	$image_new = imagecreatetruecolor( $new_width, $new_height);
	imagealphablending($image_new,false);
	imagesavealpha($image_new,true);
	imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    return imagepng($image_new, $save_filename);
    }
}


function getResizePercent($source_w, $source_h, $inside_w, $inside_h)
{
    if ($source_w < $inside_w && $source_h < $inside_h) {
        return 1; 
    }

    $w_percent = $inside_w / $source_w;
    $h_percent = $inside_h / $source_h;

    return ($w_percent > $h_percent) ? $h_percent : $w_percent;
}

function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType) {
		case "image/gif":
	  	return	imagegif($newImage,$thumb_image_name); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  	return	imagejpeg($newImage,$thumb_image_name,90); 
			break;
		case "image/png":
		case "image/x-png":
		return	imagepng($newImage,$thumb_image_name);  
			break;
    }
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}

function ImageCreateFromBMP( $filename )
{

    if ( ! $f1 = fopen ( $filename , "rb" )) return FALSE ;

    $FILE = unpack ( "vfile_type/Vfile_size/Vreserved/Vbitmap_offset" , fread ( $f1 , 14 ));
    if ( $FILE [ 'file_type' ] != 19778 ) return FALSE ;

    $BMP = unpack ( 'Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel' . '/Vcompression/Vsize_bitmap/Vhoriz_resolution' .
    '/Vvert_resolution/Vcolors_used/Vcolors_important' , fread ( $f1 , 40 ));
    $BMP [ 'colors' ] = pow ( 2 , $BMP [ 'bits_per_pixel' ]);
    if ( $BMP [ 'size_bitmap' ] == 0 ) $BMP [ 'size_bitmap' ] = $FILE [ 'file_size' ] - $FILE [ 'bitmap_offset' ];
    $BMP [ 'bytes_per_pixel' ] = $BMP [ 'bits_per_pixel' ] / 8 ;
    $BMP [ 'bytes_per_pixel2' ] = ceil ( $BMP [ 'bytes_per_pixel' ]);
    $BMP [ 'decal' ] = ( $BMP [ 'width' ] * $BMP [ 'bytes_per_pixel' ] / 4 );
    $BMP [ 'decal' ] -= floor ( $BMP [ 'width' ] * $BMP [ 'bytes_per_pixel' ] / 4 );
    $BMP [ 'decal' ] = 4 - ( 4 * $BMP [ 'decal' ]);
    if ( $BMP [ 'decal' ] == 4 ) $BMP [ 'decal' ] = 0 ;

    $PALETTE = array ();
    if ( $BMP [ 'colors' ] < 16777216 )
    {
    $PALETTE = unpack ( 'V' . $BMP [ 'colors' ] , fread ( $f1 , $BMP [ 'colors' ] * 4 ));
    }

    $IMG = fread ( $f1 , $BMP [ 'size_bitmap' ]);
    $VIDE = chr ( 0 );
    $res = imagecreatetruecolor( $BMP [ 'width' ] , $BMP [ 'height' ]);
    $P = 0 ;
    $Y = $BMP [ 'height' ] - 1 ;
    while ( $Y >= 0 )
    {
    $X = 0 ;
    while ( $X < $BMP [ 'width' ])
    {
    if ( $BMP [ 'bits_per_pixel' ] == 24 )
    $COLOR = unpack ( "V" , substr ( $IMG , $P , 3 ) . $VIDE );
    elseif ( $BMP [ 'bits_per_pixel' ] == 16 )
    {
    $COLOR = unpack ( "n" , substr ( $IMG , $P , 2 ));
    $COLOR [ 1 ] = $PALETTE [ $COLOR [ 1 ] + 1 ];
    }
    elseif ( $BMP [ 'bits_per_pixel' ] == 8 )
    {
    $COLOR = unpack ( "n" , $VIDE . substr ( $IMG , $P , 1 ));
    $COLOR [ 1 ] = $PALETTE [ $COLOR [ 1 ] + 1 ];
    }
    elseif ( $BMP [ 'bits_per_pixel' ] == 4 )
    {
    $COLOR = unpack ( "n" , $VIDE . substr ( $IMG , floor ( $P ) , 1 ));
    if (( $P * 2 ) % 2 == 0 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] >> 4 ) ; else $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x0F );
    $COLOR [ 1 ] = $PALETTE [ $COLOR [ 1 ] + 1 ];
    }
    elseif ( $BMP [ 'bits_per_pixel' ] == 1 )
    {
    $COLOR = unpack ( "n" , $VIDE . substr ( $IMG , floor ( $P ) , 1 ));
    if (( $P * 8 ) % 8 == 0 ) $COLOR [ 1 ] = $COLOR [ 1 ] >> 7 ;
    elseif (( $P * 8 ) % 8 == 1 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x40 ) >> 6 ;
    elseif (( $P * 8 ) % 8 == 2 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x20 ) >> 5 ;
    elseif (( $P * 8 ) % 8 == 3 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x10 ) >> 4 ;
    elseif (( $P * 8 ) % 8 == 4 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x8 ) >> 3 ;
    elseif (( $P * 8 ) % 8 == 5 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x4 ) >> 2 ;
    elseif (( $P * 8 ) % 8 == 6 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x2 ) >> 1 ;
    elseif (( $P * 8 ) % 8 == 7 ) $COLOR [ 1 ] = ( $COLOR [ 1 ] & 0x1 );
    $COLOR [ 1 ] = $PALETTE [ $COLOR [ 1 ] + 1 ];
    }
    else
    return FALSE ;
    imagesetpixel( $res , $X , $Y , $COLOR [ 1 ]);
    $X ++ ;
    $P += $BMP [ 'bytes_per_pixel' ];
    }
    $Y -- ;
    $P += $BMP [ 'decal' ];
    }

    fclose ( $f1 );
    return $res ;
}

function NewUploadImage( $jpg, $jpg_type, $jpg_size, $path, $in_width=800, $in_height=600, $sin_width=150, $sin_height=150 )
{
				global $strUploadNotice1;
				global $strUploadNotice2;
				global $strUploadNotice3;
				if ( $jpg_size == 0 )
				{
								$arr[0] = "err";
								$arr[1] = $strUploadNotice1;
								return $arr;
				}
				if ( 5000000 < $jpg_size )
				{
								$arr[0] = "err";
								$arr[1] = $strUploadNotice2;
								return $arr;
				}
				if ( $jpg_type != "image/pjpeg" && $jpg_type != "image/jpeg" && $jpg_type != "image/jpg" && $jpg_type != "image/gif" && $jpg_type != "image/x-png" && $jpg_type != "image/png" && $jpg_type != "application/x-shockwave-flash" )
				{
								$arr[0] = "err";
								$arr[1] = $strUploadNotice3;
								return $arr;
				}
				switch ( $jpg_type )
				{
				case "image/pjpeg" :
								$extention = ".jpg";
								$UploadImage[2] = "jpg";
								break;
				case "image/jpeg" :
								$extention = ".jpg";
								$UploadImage[2] = "jpg";
								break;
				case "image/jpg" :
								$extention = ".jpg";
								$UploadImage[2] = "jpg";
								break;
				case "image/gif" :
								$extention = ".gif";
								$UploadImage[2] = "gif";
								break;
				case "image/x-png" :
								$extention = ".png";
								$UploadImage[2] = "png";
								break;
				case "image/png" :
								$extention = ".png";
								$UploadImage[2] = "png";
								break;
				case "application/x-shockwave-flash" :
								$extention = ".swf";
								$UploadImage[2] = "swf";
								break;
				}
				$fname = time( );
				$fname .= $extention;
				$file_path = ROOTPATH.$path."/".$fname;
				$sp_file_path = ROOTPATH.$path."/sp_".$fname;
				$UploadImage[3] = $path."/".$fname;
				if($UploadImage[2] == "swf"){
					copy( $jpg, $file_path );
					chmod ($file_path,0666);
					copy( $jpg, $sp_file_path );				
					chmod ($sp_file_path,0666);
				}else{
					if(check_animation($jpg)){
						copy( $jpg, $file_path );
						chmod ($file_path,0666);
						copy( $jpg, $sp_file_path );				
						chmod ($sp_file_path,0666);
					}else{
						ImageResize($jpg,$file_path,$in_width,$in_height,'88');
						chmod ($file_path,0666);
						ImageResize($jpg,$sp_file_path,$sin_width,$sin_height,'88');
						chmod ($sp_file_path,0666);
					}
				}
				$UploadImage[0] = "OK";
				$UploadImage[1] = "OK";
				return $UploadImage;
}

?>