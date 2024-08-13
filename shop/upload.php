<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("includes/shop.inc.php");
SecureMember();

//上傳圖片校驗權限
if(SecureFunc("184")==false){
	alert("您的會員帳號沒有在編輯器內上傳圖片的權限");
}

$dt=date("Ymd",time());
if(!is_dir(ROOTPATH.$_POST['attachPath'].$dt)){
	@mkdir(ROOTPATH.$_POST['attachPath'].$dt,0777);
}

//文件保存目錄路徑
$save_path = ROOTPATH.$_POST['attachPath'].$dt.'/';

//文件保存目錄URL
$save_url = $SiteUrl.$_POST['attachPath'].$dt.'/';

//定義允許上傳的文件擴展名
$ext_arr = array('gif','jpg','png','bmp');

//最大文件大小
$max_size = $GLOBALS["SHOPCONF"]["EditPicLimit"];


//更改目錄權限
@mkdir($save_path, 0777);

//文件的全部路徑
$file_path = $save_path.$_POST['fileName'];

//文件URL
$file_url = $save_url.$_POST['fileName'];


//有上傳文件時
if (empty($_FILES) === false) {

	//原文件名
	$file_name = $_FILES['fileData']['name'];
	//伺服器上臨時文件名
	$tmp_name = $_FILES['fileData']['tmp_name'];
	//文件大小
	$file_size = $_FILES['fileData']['size'];
	//檢查目錄
	if (@is_dir($save_path) === false) {
		alert("上傳目錄不存在。");
	}
	//檢查目錄寫權限
	if (@is_writable($save_path) === false) {
		alert("上傳目錄沒有寫權限。");
	}
	//檢查是否已上傳
	if (@is_uploaded_file($tmp_name) === false) {
		alert("臨時文件可能不是上傳文件。");
	}
	//檢查文件大小
	if ($file_size > $max_size) {
		alert("上傳文件大小超過限制。");
	}
	//獲得文件擴展名
	$temp_arr = explode(".", $_POST['fileName']);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);

	//檢查擴展名
	if (in_array($file_ext, $ext_arr) === false) {
		alert("上傳文件擴展名是不允許的擴展名。");
	}

	//移動文件
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("上傳文件失敗。");
	}
	
	@chmod($file_path,0666);

	//插入圖片，關閉層
	echo '<html>';
	echo '<head>';
	echo '<title>Insert Image</title>';
	echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
	echo '</head>';
	echo '<body>';
	echo '<script type="text/javascript">parent.KindInsertImage("'.$file_url.'","'.$_POST['imgWidth'].'","'.$_POST['imgHeight'].'","'.$_POST['imgBorder'].'","'.$_POST['imgTitle'].'","'.$_POST['imgAlign'].'","'.$_POST['imgHspace'].'","'.$_POST['imgVspace'].'");</script>';
	echo '</body>';
	echo '</html>';
}

//提示，關閉層
function alert($msg)
{
	echo '<html>';
	echo '<head>';
	echo '<title>error</title>';
	echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
	echo '</head>';
	echo '<body>';
	echo '<script type="text/javascript">alert("'.$msg.'");parent.KindDisableMenu();parent.KindReloadIframe();</script>';
	echo '</body>';
	echo '</html>';
	exit;
}
?>