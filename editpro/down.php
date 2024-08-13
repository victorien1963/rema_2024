<?php
/*
*#########################################
* PHPCMS File Manager
* Copyright (c) 2004-2006 phpcms.cn
* Author: Longbill ( http://www.longbill.cn )
* longbill.cn@gmail.com
*#########################################
*/
define( "ROOTPATH", "../" );
include( ROOTPATH."includes/admin.inc.php" );
needauth( 0 );
include_once("common.php");
include_once("class/longbill.class.php");

$user = check_login();
//$user["root"] = $user["root"].$pathname.'/'.$file_path.'/';
if (!$user)
{
	header("Content-type:TEXT/HTML;charset=utf-8");
	die("<script language=javascript>alert('登入超時!');parent.window.location='login.php';</script>");
}
$root = $user["root"];
$path = dealpath($path);
if (!$path || !$user["downfile"]) exit("<script>alert('沒有權限!');</script>");
if ($action == "downfile")
{
	$path = str_replace("|","",$path);
	$ftype = getext($path);
	if ($user["limit"]["$ftype"] && !$user["only"])
		exit("<script>alert('您不能下載{$user["limittype"]}類型的源檔案!');</script>");
	else if(!$user["limit"]["$ftype"] && $user["only"])
		exit("<script>alert('您不能下載除{$user["limittype"]}類型以外的源檔案!');</script>");
	$path=str_replace("|","",$path);
	if (!file_exists($path)) exit("<script>alert('檔案不存在!!');</script>");
	$filename = basename1($path);
	header('Content-type: application/force-download');
	header("Content-Disposition: attachment; filename={$filename}");
	header("Content-length: ".filesize($path));
	readfile($path);
	die;
}
else if ($action == "downfiles")
{
	$sfile = urldecode($_GET["files"]);
	$sdir = urldecode($_GET["dirs"]);
	if (!$content = zippack($path,$sdir,$sfile)) die("<script>alert('下載時出錯!');</script>");
	$filename = substr($path,0,strlen($path)-1).".zip";
	$filename = basename1($filename);
	if ($filename == "..zip" || $filename == "...zip") $filename = "root.zip";	
	header('Content-type: application/force-download');
	header("Content-Disposition: attachment; filename={$filename}");
	header("Content-length:".strlen($content));
	echo $content;
	die;
}
?>