<?php
/*
*#########################################
* PHPCMS File Manager
* Copyright (c) 2004-2006 phpcms.cn
* Author: Longbill ( http://www.longbill.cn )
* longbill.cn@gmail.com
*#########################################
*/

include_once("info.php");
$welcome="歡迎使用 WayHunt™ 邊框模板檔案管理器 v1.0";			//登入成功後的提示信息
$preload = 0;			//客戶端是否啟用預下載（啟用後，客戶端速度加快，但服務器負擔加重）
$jumpfiles="";			//需要服務端跳轉的檔案（暫時還不支持）
$max_time_limit=60; 			//頁面執行最長時間(秒)
$charset="UTF-8";			//默認編碼
$imgmax=7024;			//圖片最大寬或高
$cookieexp = 60;			//客戶端剪貼板過期時間
$v=404;				//內部版本號
$version = "4.04";			//版本
$sitewidth = 860;			//網站整體寬度(僅僅對某些風格模板有效)
$editfiles="|php|php3|asp|txt|jsp|inc|ini|pas|cpp|bas|in|lang|out|htm|html|cs|config|js|htc|css|c|sql|bat|vbs|cgi|dhtml|shtml|xml|xsl|aspx|tpl|ihtml|htaccess|dwt|lib|lbi|";
				//可用編輯器編輯的檔案類型
$searchfiles = $editfiles;		//可搜索內容的檔案類型

$language = "traditional_chinese.lang.php"; 	//語言檔案
$host_charset = "UTF-8";		//服務器檔案名編碼
function_exists('date_default_timezone_set') && @date_default_timezone_set('Etc/GMT-8');

//小圖標檔案，可以自己添加，然後將對應的圖片上傳至 images/ 下
$icons = array(
"jpg|gif|png|bmp|jpeg" => "icon_image.gif",
$editfiles => "icon_txt.gif",
"zip|rar" => "icon_zip.gif",
"exe|dll" => "icon_exe.gif",
"mp3" => "icon_mp3.gif"
);
//大圖標檔案
$big_icons = array(
$editfiles => "big_txt.gif",
"zip|rar" => "big_rar.gif",
"exe|dll" => "big_exe.gif",
"mp3" => "icon_mp3.gif"
);

?>