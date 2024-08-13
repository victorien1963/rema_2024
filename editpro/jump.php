<?php
/*
*#########################################
* PHPCMS File Manager
* Copyright (c) 2004-2006 phpcms.cn
* Author: Longbill ( http://www.longbill.cn )
* longbill.cn@gmail.com
*#########################################
*/

include_once("func.php");
include_once("config.php");
header("Content-type:TEXT/HTML;charset=utf-8");

$url = $_GET["url"];
if (!$url) die();

if ($allowurlencode)
{
	header("location:".urlencode1(urldecode1($_GET["url"])) );
	die();
}
else 
{
?>
<html><head>
<title>跳轉</title>
<meta http-equiv="refresh" content="0; url=<?php echo $url;?>" />
</head>
<body>正在為您轉到相應的網頁，如果您的瀏覽器沒有自動跳轉，請點擊<a href="<?php echo $url;?>">這裡</a></body>
</html>
<?
}
exit;
?>