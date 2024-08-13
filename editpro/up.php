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
$user = check_login();
//$user["root"] = $user["root"].$pathname.'/'.$file_path.'/';
$root = $user["root"];
if (!$user) exit3('登入超時!');
header("content-type:text/html; charset=utf-8");

$path=dealpath($path);
if (!$path) exit3("沒有權限!",0);
////////////檔案上傳//////////////
if ($action=="upsave" && $user["upfile"])
{
	if (substr($path,-1)!="/") $path.="/";
	$tt=0;
	$error='';
	$tsize = 0;
	if (!is_writable($path))
	{
		exit3("上傳失敗:目錄 {$path} 不可寫!",0);
	}
	foreach($_FILES as $file)
	{
		if ($file['tmp_name'])
		{
			$myfile=$file["tmp_name"];
			$myfile_name=$_POST['myfilename0']? $_POST['myfilename0']:checkfilename($file["name"]);
			$new_filename = $_POST['myfilename0'];
			$iscover = $_POST['myfilecover0'];
			$ftype = getext($myfile_name);
			if ($myfile_name!= $file["name"]&&!$_POST['myfilename0'] || !$myfile_name)
			{
				$error.="{$myfile_name}上傳失敗:檔案名有錯誤\\n";
			}
			else if ($user["limit"]["$ftype"] && !$user["only"])
			{
				$error.="{$myfile_name}上傳失敗:不能能上傳 ".$user["limittype"]." 類型的檔案\\n";
			}
			else if (!$user["limit"]["$ftype"] && $user["only"])
			{
				$error.="{$myfile_name}上傳失敗:不能能上傳除 ".$user["limittype"]." 類型以外的檔案\\n";
			}
			//else if (file_exists($path.$myfile_name))
			//$myfile_name = $new_filename;
			else if (file_exists($path.$myfile_name) && !$iscover)
			{
				$error.=$myfile_name."上傳失敗:有同名檔案存在!\\n".$myfile_name;
				continue;
			}
			else if (@move_uploaded_file($myfile,$path.$myfile_name))
			{
				$tt++;
				$tsize += filesize($path.$myfile_name);
				inlog("上傳檔案,".$path.$myfile_name."成功");
			}
			else
			{
				$error.=$myfile_name."上傳失敗:原因不明!\\n";
				continue;
			}
		}
	}
	$str="成功上傳{$tt}個檔案!!";
	$str.="\\n總大小:".dealsize($tsize)."\\n";
	$str.=($error)?"\\n以下是錯誤信息:\\n".$error:"";
	exit3($str);
}
else
{
	exit3("沒有權限!",0);
}

function exit3($s,$r=1)
{
	$ss = "<script language=javascript>alert('$s');";
	$ss.=($r)?"parent.reloaddata();":"";
	$ss.="</script>";
	exit($ss);
}

function checkfilename($file)
{
	if (!$file) return false;
	$file = trim($file);
	$a = substr($file,-1);
	while ($a =="." || $a =="/" || $a == "\\" || $a == " " || $a == "'" || $a == "+" || $a == "&" || $a == "\"" || $a == ".")
	{
		$file=substr($file,0,-1);
		$a = substr($file,-1);
	}
	$arr = array("../","./","..\\",".\\");
	$file = str_replace($arr,"",$file);
	return $file;
}
?>