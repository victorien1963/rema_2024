<?php
header("Content-type: text/html; charset=utf-8");
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 2 );

$sourcefold = ROOTPATH.'/cache/modsql/';
$style_backup = scandir( $sourcefold );
if(count($style_backup)>='12'){
err( $strMaxStyleBack, "", "" );
}



function table2sql($table) 
{ 
global $msql; 
$tabledump = "\n\n\nDROP TABLE IF EXISTS $table;\n"; 
$createtable = $msql->query("SHOW \nCREATE TABLE $table"); 
$create = mysql_fetch_row($createtable); 
$tabledump .= $create[1]."; "; 
return $tabledump; 
} 
function create_check_code($len=4) 
{ 
if ( !is_numeric($len) || ($len>6) || ($len<1)) { return; } 

$check_code = substr(create_sess_id(), 16, $len ); 
return strtoupper($check_code); 
} 

function create_sess_id($len=32) 
{ 
if( !is_numeric($len) || ($len>32) || ($len<16)) { return; } 
list($u, $s) = explode(' ', microtime()); 
$time = (float)$u + (float)$s; 
$rand_num = rand(100000, 999999); 
$rand_num = rand($rand_num, $time); 
mt_srand($rand_num); 
$rand_num = mt_rand(); 
$sess_id = md5( md5($time). md5($rand_num) ); 
$sess_id = substr($sess_id, 0, $len); 
return $sess_id; 
} 

function data2sql($table) 
{ 
global $msql; 
$tabledump = "\n\n\nDROP TABLE IF EXISTS $table;\n "; 
$createtable = $msql->query("SHOW CREATE TABLE $table"); 
$create = mysql_fetch_row($createtable); 
$tabledump .= $create[1]."; "; 
$rows = $msql->query("SELECT * FROM $table"); 
$numfields = $msql->num_fields($rows); 
$numrows = $msql->num_rows($rows); 
while ($row = mysql_fetch_row($rows)) 
{ 
$comma = ""; 
$tabledump .= "\nINSERT INTO $table VALUES("; 
for($i = 0; $i < $numfields; $i++) 
{ 
$tabledump .= $comma."'".mysql_escape_string($row[$i])."'"; 
$comma = ","; 
} 
$tabledump .= "); "; 
} 
$tabledump .= " "; 
return $tabledump; 
} 

/* 備份數據庫 */ 
$tables = array($TablePre.'_base_pageset',$TablePre.'_base_plus'); //定義要保存的數據表，一個陣列 
$prefix = '_style'; // 要保存的.sql文件的前綴 
$saveto = 'server'; // 要保存到什麼地方，是本地還是伺服器上，預設是伺服器
$db_backup_path = '../../cache/modsql/';
$back_mode = 'all'; // 要保存的方式，是全部備份還是只保存資料庫結構 
$admin = $_COOKIE['SYSUSER']; //管理員名稱 
$admin_email = $_SERVER[HTTP_HOST]; // 管理員郵箱 
// 定義數據保存的文件名 
$local_filename = time().$prefix.'.sql"'; 
if (!$filename) { $filename = $db_backup_path . time().$prefix . '_'. create_check_code(4) . ".sql"; } 
//$filename = $prefix.date(Ymd_His). create_check_code(6).".sql"; // 保存在服務器上的文件名 
// 注意後面的create_check_code()函數，這是一個生成隨機碼的函數，詳細可以參考： 

// 獲取數據庫結構和數據內容 
foreach($tables as $table) 
{ 
if ($back_mode == 'all') { $sqldump .= data2sql($table); } 
if ($back_mode == 'table') { $sqldump .= table2sql($table); } 
} 
// 如果數據內容不是空就開始保存 
if(trim($sqldump)) 
{ 
// 寫入開頭訊息 
$sqldump = 
"# -------------------------------------------------------- \n". 
"# 風格設定資料表 \n". 
"# \n". 
"# 伺服器: $msql->Host \n". 
"# 資料庫：$msql->Database \n". 
"# 備份編號: ". create_sess_id() ." \n". // 這裡有一個生成session id的函數 
"# 備份時間: ".time()." \n". // 這裡就是獲取目前的時間的函數 
"# \n". 
"# 操作人員：$admin ($admin_email) \n". // 管理員的用戶名和郵箱地址 
"# $copyright \n". 
"# -------------------------------------------------------- \n". 
$sqldump; 
// 保存到本地 
if($saveto == "local") 
{ 
ob_end_clean(); 
header('Content-Encoding: none'); 
header('Content-Type: '.(strpos($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'MSIE') ? 'application/octetstream' : 'application/octet-stream')); 
header('Content-Disposition: '.(strpos($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'MSIE') ? 'inline; ' : 'attachment; ').'filename="'.$local_filename); 
header('Content-Length: '.strlen($sqldump)); 
header('Pragma: no-cache'); 
header('Expires: 0'); 
echo $sqldump; 
} 
// 保存到本地結束 
// 保存在服務器 
if($saveto == "server") 
{ 
if($filename != "") 
{ 
if(file_exists($db_backup_path) == FALSE){
@mkdir($db_backup_path,0777);
}
@$fp = fopen($filename, "w+"); 
if ($fp) 
{ 
@flock($fp, 3); 
if(@!fwrite($fp, $sqldump)) 
{ 
@fclose($fp); 
echo("數據文件無法保存到服務器，請檢查目錄屬性你是否有寫的權限。"); 
} 
else 
{ 
sayok( $strStyleBackOk, "", "" );
} 
} 
else 
{ 
echo("無法打開你指定的目錄". $filename ."，請確定該目錄是否存在，或者是否有相應權限"); 
} 
} 
else 
{ 
echo("您沒有輸入備份文件名，請返回修改。"); 
} 
} 
// 保存到服務器結束 
} 
else 
{ 
echo("數據表沒有任何內容"); 
} 
/* 備份數據庫結束 */ 
?>