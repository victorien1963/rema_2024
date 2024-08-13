<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
NeedAuth(0);

require_once 'JSON.php';

/*$php_path = dirname(__FILE__) . '/';*/
/*$php_url = dirname($_SERVER['PHP_SELF']) . '/';*/

$attachPath = $_GET[attachPath];


//文件保存目錄路徑
$save_path = ROOTPATH.$attachPath;
//文件保存目錄URL
$save_url = ROOTPATH.$attachPath;
//定義允許上傳的文件副檔名
$ext_arr = array(
	'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
	'flash' => array('swf', 'flv'),
	'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2', 'pdf','gif', 'jpg', 'jpeg', 'png','svg','css','js'),
);
//最大文件大小
$max_size = 10000000;

$save_path = realpath($save_path) . '/';

//有上傳文件時
if (empty($_FILES) === false) {
	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//伺服器上臨時文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//檢查文件名
	if (!$file_name) {
		alert("請選擇文件。");
	}
	//檢查目錄
	if (@is_dir($save_path) === false) {
		alert("上傳目錄不存在。");
	}
	//檢查目錄寫權限
	/*if (@is_writable($save_path) === false) {
		alert("上傳目錄沒有寫入權限。");
	}*/
	//檢查是否已上傳
	if (@is_uploaded_file($tmp_name) === false) {
		alert("臨時文件可能不是上傳文件。");
	}
	//檢查文件大小
	if ($file_size > $max_size) {
		alert("上傳文件大小超過限制。");
	}
	//檢查目錄名
	$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
	/*if (empty($ext_arr[$dir_name])) {
		alert("目錄名不正確。");
	}*/
	//獲得文件副檔名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	//檢查副檔名
	if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
		alert("上傳文件副檔名是不允許的副檔名。\n只允許" . implode(",", $ext_arr[$dir_name]) . "格式。");
	}
	//建立文件夾
	/*if ($dir_name !== '') {
		$save_path .= $dir_name . "/";
		$save_url .= $dir_name . "/";
		if (!file_exists($save_path)) {
			@mkdir($save_path,0777);
		}
	}*/
	$ymd = date("Ymd");
	$save_path .= $ymd . "/";
	$save_url .= $ymd . "/";
	if (!file_exists($save_path)) {
		@mkdir($save_path,0777);
	}
	//新文件名
	$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
	//移動文件
	$file_path = $save_path . $new_file_name;
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("上傳文件失敗。");
	}
	@chmod($file_path, 0644);
	$file_url = $save_url . $new_file_name;
	
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 0, 'url' => $file_url));
	exit;
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}
?>