<?php
function alert( $msg )
{
				echo "<html>";
				echo "<head>";
				echo "<title>error</title>";
				echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
				echo "</head>";
				echo "<body>";
				echo "<script type=\"text/javascript\">alert(\"".$msg."\");parent.KindDisableMenu();parent.KindReloadIframe();</script>";
				echo "</body>";
				echo "</html>";
				exit( );
}

define( "ROOTPATH", "../" );
include( ROOTPATH."includes/common.inc.php" );
include( "includes/news.inc.php" );
securemember( );
if ( securefunc( "814" ) == FALSE )
{
				alert( "您的會員帳號沒有上傳圖片的權限" );
}
$dt = date( "Ymd", time( ) );
if ( !is_dir( ROOTPATH.$_POST['attachPath'].$pathname."/".$file_path."/".$dt ) )
{
				@mkdir( ROOTPATH.$_POST['attachPath'].$pathname."/".$file_path."/".$dt, 511 );
}
$save_path = ROOTPATH.$_POST['attachPath'].$pathname."/".$file_path."/".$dt."/";
$save_url = $SiteUrl.$_POST['attachPath'].$pathname."/".$file_path."/".$dt."/";
$ext_arr = array( "gif", "jpg", "png", "bmp" );
$max_size = $GLOBALS['NEWSCONF']['EditPicLimit'];
@mkdir( $save_path, 511 );
$file_path = $save_path.$_POST['fileName'];
$file_url = $save_url.$_POST['fileName'];
if ( empty( $_FILES ) === FALSE )
{
				$file_name = $_FILES['fileData']['name'];
				$tmp_name = $_FILES['fileData']['tmp_name'];
				$file_size = $_FILES['fileData']['size'];
				if ( is_dir( $save_path ) === FALSE )
				{
								alert( "上傳目錄不存在。" );
				}
				if ( is_writable( $save_path ) === FALSE )
				{
								alert( "上傳目錄沒有寫權限。" );
				}
				if ( is_uploaded_file( $tmp_name ) === FALSE )
				{
								alert( "臨時文件可能不是上傳文件。" );
				}
				if ( $max_size < $file_size )
				{
								alert( "上傳文件大小超過限制。" );
				}
				$temp_arr = explode( ".", $_POST['fileName'] );
				$file_ext = array_pop( $temp_arr );
				$file_ext = trim( $file_ext );
				$file_ext = strtolower( $file_ext );
				if ( in_array( $file_ext, $ext_arr ) === FALSE )
				{
								alert( "上傳文件副檔名是不允許的副檔名。" );
				}
				if ( move_uploaded_file( $tmp_name, $file_path ) === FALSE )
				{
								alert( "上傳文件失敗。" );
				}
				@chmod( $file_path, 438 );
				echo "<html>";
				echo "<head>";
				echo "<title>Insert Image</title>";
				echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
				echo "</head>";
				echo "<body>";
				echo "<script type=\"text/javascript\">parent.KindInsertImage(\"".$file_url."\",\"".$_POST['imgWidth']."\",\"".$_POST['imgHeight']."\",\"".$_POST['imgBorder']."\",\"".$_POST['imgTitle']."\",\"".$_POST['imgAlign']."\",\"".$_POST['imgHspace']."\",\"".$_POST['imgVspace']."\");</script>";
				echo "</body>";
				echo "</html>";
}
?>