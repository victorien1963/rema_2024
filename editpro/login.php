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
@error_reporting(1);
include_once("common.php");

$uc=check_login();
//$uc["root"] = $uc["root"].$pathname.'/'.$file_path.'/';
header("Content-type:TEXT/HTML;charset=utf-8");


if ($uc)
{
	uncookie('user_name');
	uncookie('user_pass');
	exitjs("您已經退出!","index.php?indir=500");
}
else
{
	if ($_POST["action"]!="login")
	{
		echo deal_temp("temp/$tempname/login.htm",array("title"=>$title));
		die;
	}
	$user_orig=$_POST["user_name"];
	$pass_orig=$_POST["user_pass"];
	$user_name=my_encode($user_orig);
	$user_pass=my_encode($pass_orig);
	$users=file("class/users.php");
	for($i=1;$i<count($users);$i++)
	{
		if (!trim($users[$i])) continue;
		$arr=explode("|",$users[$i]);
		if ($user_name == my_encode($arr[0]) && $user_pass == $arr[1])
		{
			mkcookie('user_name',$user_name);
			mkcookie('user_pass',$user_pass);
			mkcookie('last_time',date("D, d M Y H:i:s")." GMT");
			inlog("登入成功,用戶名:".$user_orig);
			if ($user_orig == "admin" && $pass_orig == "admin")
			{
				exit("<script language=javascript>alert(\"歡迎使用 PHPCMS 檔案管理器 \\n您是第一次登入本程序\\n現在請修改默認密碼!\");window.location = 'admin.php?action=muser&name=admin';</script>");
				
			}
			else
			{
?>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta http-equiv="refresh" content="1;url=index.php">
 <title><?=$title;?> --登入成功</title>
</head>
<body>
<table cellspacing="0" cellpadding="0" border="0" align="center" height="80%" width="50%">
 <tr><td>
  <table border="0" cellspacing="1" cellpadding="5" bgcolor="#4499ee" align="center">
   <tr><td style="font-family: Tahoma, Verdana; color: #FFFFFF; font-size: 12px; font-weight: bold; background: #8ec2f5;"><?=$title;?></td></tr>
   <tr><td bgcolor="#FFFFFF" style="font-family: Tahoma, Verdana; color: #333333; font-size: 12px;">您已經成功登錄 <?=$title;?>
   <br/><br/><a href="index.php" style="text-decoration: none;color:#333333;">如果沒有自動跳轉,請點擊這裡</a></td></tr>
  </table>
 </td></tr>
</table>
<br/>
<br/>
</body>
</html>
<?
				die;
			}
		}
	}
	exitjs("登入失敗:用戶名或密碼錯誤!","login.php");
}

?>