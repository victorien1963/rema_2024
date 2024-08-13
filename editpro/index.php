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
if(!getcookie("indir") || !getcookie("getroot")){exit("您沒有權限!");}
$user=check_login();

$root = $user["root"];

//header("location:login.php");

	$user_orig='wayhunt';
	$pass_orig='wayhunt';

	$user_name=my_encode($user_orig);
	$user_pass=my_encode($pass_orig);
	mkcookie('user_name',$user_name);
	mkcookie('user_pass',$user_pass);
	mkcookie('last_time',date("D, d M Y H:i:s")." GMT");


$configroot = substr($root,2);
$config = '<?xml version="1.0" encoding="utf-8" ?>
<configuration>
	<security name="MaxImageSize">300</security>
	<security name="MaxMediaSize">10000</security>
	<security name="MaxFlashSize">1000</security>
	<security name="MaxDocumentSize">1000</security>
	<security name="MaxTemplateSize">1000</security>
	<security name="ImageGalleryPath">'.$configroot.'images</security>
	<security name="MediaGalleryPath">'.$configroott.'images</security>
	<security name="FlashGalleryPath">'.$configroot.'images</security>
	<security name="TemplateGalleryPath">'.$configroot.'images</security>
	<security name="FilesGalleryPath">'.$configroot.'images</security>
	<security name="AllowUpload">true</security>
	<security name="AllowCreateFolder">true</security>
	<security name="AllowRename">true</security>
	<security name="AllowDelete">true</security>
	<security name="ImageFilters">
		<item>.jpg</item>
		<item>.jpeg</item>
		<item>.gif</item>
		<item>.png</item>
	</security>
	<security name="MediaFilters">
		<item>.avi</item>
		<item>.mpg</item>
		<item>.mpeg</item>
		<item>.mp3</item>
		<item>.wav</item>
		<item>.wmv</item>
	</security>
  <security name="DocumentFilters">
    <item>.txt</item>
    <item>.doc</item>
    <item>.pdf</item>
    <item>.zip</item>
    <item>.rar</item>
    <item>.avi</item>
    <item>.mpg</item>
    <item>.mpeg</item>
    <item>.jpg</item>
    <item>.jpeg</item>
    <item>.gif</item>
    <item>.png</item>
    <item>.htm</item>
  </security>
	<security name="TemplateFilters">
		<item>.html</item>
		<item>.htm</item>
	</security>
  <!-- Allow upload, disable the delete,create funtion -->
  <security name="DemoMode">false</security>
</configuration>';

/*	$botcache=fopen("../edit/cuteeditor_files/Configuration/Security/".$file_path.".config","w+");
	$write=fwrite($botcache,$config);
	fclose($botcache);*/

if (!$action)
{
	header("Content-type:TEXT/HTML;Charset=UTF-8");
	echo deal_temp("js/loading.htm",array("title"=>$title,"tempname"=>$tempname,"indir"=>$indirs));
	echo deal_temp("temp/$tempname/footer.htm");
	
}else if ($action=="menu")
{
	header("Content-type:TEXT/HTML;charset=utf-8");
	echo deal_temp( "temp/{$tempname}/header.htm", array(
		"title" => $title,
		"charset" => $charset,
		"keywords" => $keywords,
		"description" => $description
		) );
		


print <<<END
<script language=javascript>
window.onerror = function ()
{
	//alert(event.toString());
	//alert("程序加載時發生了未知錯誤!\\n原因可能是您的瀏覽器版本太低，建議您升級您的瀏覽器。\\n本程序支持IE6+,IE7,Firefox,Opera等主流瀏覽器。");
}
</script>
<script language=javascript src='js/functions.js'></script>
<script language=javascript src='js/sack.js'></script>
<script language=javascript src='js/gb2312.js'></script>
<script language=javascript src='javascript.php'></script>
<script language=javascript src='js/blueshow.js'></script>
<script language=javascript src='js/hash.js'></script>
END;


	if (file_exists("temp/{$tempname}/javascript.js")) echo "<script language=javascript src='temp/{$tempname}/javascript.js'></script>";
	
	reset($user);
	$dd=array();
	while (list($key, $val) = each($user))
	{
		$dd["{$key}"] = ($val)?"":"none";
	}
	$dd["wait"]  = $wait;
	$dd["paste"] = ($user["copy"] || $user["move"])?"":"none";
	$dd["version"] = $version;
	$main = deal_temp("temp/$tempname/table.htm",$dd);

	echo deal_temp( "temp/$tempname/main.htm", array(
		"sitewidth" => $sitewidth,
		"title" => $title,
		"logout" => "<a href='login.php?action=logout' target=_top>退出</a>",
		"main" => $main,
		"currentpath" => "<font id='currentpath'>當前路徑 .</font>",
		"username" => $user["name"],
		"footer" => deal_temp("temp/$tempname/footer.htm")
		) );
	echo "</body></html>";
	exit;
}

//檔案編輯界面
else if ($action=="editfile")
{
	$path=dealpath($_GET["path"]);
	if ( !$path || !$user["viewsorce"])
	{
		header("Content-type:TEXT/HTML;charset=utf-8");
		die("<script>alert('沒有權限!');window.close();</script>");
	}
	$ftype = getext($path);
	$encode = get_encode($path);
	
	if ($encode == false)
	{
		$encode = $force_encode;
	}
	if ($_GET['charset'])
	{
		$encode = strtoupper($_GET['charset']);
	}
	$selected_gb2312 = ($encode == "GB2312")?"selected":"";
	$selected_utf8 = ($encode == "UTF-8")?"selected":"";
	
	//if ($encode != "GB2312") die("<script>alert('文本編輯器暫時還不支持 {$encode} 編碼的檔案!');window.close();</script>");
	if ($user["limit"]["$ftype"] && !$user["only"])
	{
		header("Content-type:TEXT/HTML;charset=utf-8");
		die("<script>alert('不能編輯 ".$user["limittype"]." 類型的檔案!');window.close();</script>");
	}
	else if (!$user["limit"]["$ftype"] && $user["only"])
	{
		header("Content-type:TEXT/HTML;charset=utf-8");
		die("<script>alert('只能編輯 ".$user["limittype"]." 類型的檔案!');window.close();</script>");
	}
	header("Content-type:TEXT/HTML;Charset=".$encode);
	$out_str = deal_temp("temp/{$tempname}/header.htm",array(
		"title" => basename1($path)."  ".$title,
		"charset" => $charset,
		"keywords" => $keywords,
		"description" => $description
		));
	if ( strpos($editfiles,"|$ftype|") === false)
	{
		header("Content-type:TEXT/HTML;charset=utf-8");
		die("<script>alert('文本編輯器不可編輯此類型檔案：$ftype!');window.close();</script>");
	}
	$out_str.= "<body style='backgroud-color:#ffffff;'>\n";
	$out_str.= "<script language=javascript src=\"js/edit.js\"></script>\n";
	$out_str.= "<script language=javascript src=\"js/hash.js\"></script>\n";
	$out_str.= '<script language=javascript>
				function DelTxt() {
				document.editform.txt_ln.style.display = "none";
				//document.editform.txt_main.style.display = "none";
				//var txt_ln=document.getElementById("txt_ln");
				var txt_main=document.getElementById("txt_main");
				//txt_ln.parentNode.removeChild(txt_ln);
				txt_main.parentNode.removeChild(txt_main);
				//txt_main.removeNode(1);
			}</script>';
	$line = @file($path);
	$content = ""; $lines = "";
	$n = count($line);
	for ( $i=0; $i<$n; $i++) $content.=htmlspecialchars($line[$i]);
	$n+= 1000;
	for ( $i = 0; $i < $n; $i++ ) $lines.=($i+1)."\n";
	$main = deal_temp("js/editor.htm",array(
		"path" => $path,
		"titleback" => $icon["titleback"],
		"width" => $sitewidth-60,
		"filename" => basename1($path),
		"size" => dealsize(filesize($path)),
		"selected_gb2312" => $selected_gb2312,
		"selected_utf8" => $selected_utf8,
		"encode" => $encode
		));
	$main = deal_temp("temp/$tempname/main.htm",array(
		"sitewidth" => $sitewidth,
		"title" => "編輯檔案 ".basename1($path),
		"logout" => "<a href='login.php?action=logout' target=_top>退出</a>",
		"main" => $main,
		"currentpath" => " ",
		"username" => $user["name"],
		"footer" => ""
		));

	$encode2 = get_encode("temp/$tempname/main.htm");
	if ($encode != $encode2)
	{
		$s1 = @iconv($encode2,$encode,$out_str);
		$out_str = $s1 ? $s1:$out_str;
		$s1 = @iconv($encode2,$encode,$main);
		$main = $s1 ? $s1:$main;
	}
	echo $out_str;
	echo str_replace(array("{lines}","{content}"),array($lines,$content),$main);
	echo "<script>RoundCorner('titlediv');RoundCorner('maindiv');</script>";
	exit;
}
?>