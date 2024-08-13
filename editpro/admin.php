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
header("content-type:text/html; charset=utf-8");

include_once("common.php");
$user = check_login();
//$user["root"] = $user["root"].$pathname.'/'.$file_path.'/';
if (!$user) exit("<script>window.location='login.php';</script>");
if (!$user["admin"]) exit("沒有權限");
$action = $_GET["action"];
?>

<html>
<head>
 <title>控制面板--<?php echo $title;?></title>
 <meta http-equiv='Pragma' content='no-cache' />
 <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
 <link rel="stylesheet" href="images/ctrl.css" type="text/css" />
</head>
<body>
<div class=tool style="margin-top:10px;">
<a href='?action=config'>基本設置</a> 
<a href='?action=adduser'>添加用戶</a> 
<a href='?action=user'>管理用戶</a>
<a href='?action=addgroup'>添加組</a>  
<a href='?action=group'>管理組</a> 
<a href='?action=update'>升級信息</a> 
</div>

<?
showjsfunctions();

if ($action == "adduser" && $user["adduser"])
{
?>
<div>
<form name=myform method=post action=ctrl.php onsubmit="return checkpass()">
<input type=hidden name='action' value='adduser' />
用戶名:<input type=text size=20 maxlength=30 name=new_user /><br/>
密&nbsp;&nbsp;碼:<input type=password size=20 maxlength=50 name=new_pass /><br/>
重&nbsp;&nbsp;復:<input type=password size=20 maxlength=50 name=new_confirm_pass onblur="checkpass(this);" /><br/>
根目錄:<input type=text size=20 name=new_root /> <a href="javascript:showhelp('roothelp')">幫助</a>
<div id='roothelp' style="width:200px;float:right;display:none">
關於"根目錄"的幫助信息:<br/>
   相對於程序的目錄名，比如本程序在 wwwroot/down/longbill/ 下，
而你想設置根目錄為 wwwroot/down/user/ 那麼應該輸入 ../user/ 。<br/>注: <br/>1: ../代表上級目錄<br/>2:如果此目錄不存在程序會自動創建
</div>
<br/>
用戶組:<select name=new_group>
<?
$arr = file("class/group.php");
for($i=1;$arr[$i];$i++)
{
	$v = trim ($arr[$i]);
	if (!$v || !strpos($v,"|")) continue;
	$arr2 = explode("|",$v);
	echo "<option value='{$arr2[0]}'>{$arr2[0]}</option>\n";
}
?>
</select>
<br/>
<input type=submit value="提交">&nbsp;<input type=reset value="重設">
</form>
</div>
<?
}

else if ($action == "muser" && $user["adduser"])
{
	$g = $_GET["name"];
	if (!$g) $g = $_POST["name"];
	$name = $g;
	$g = getuser($g);
	if (!$g) exit("<div>用戶名錯誤</div>");
?>
<div>
<form name=myform method=post action=ctrl.php onsubmit="return checkpass()">
<input type=hidden name='action' value='muser' />
用戶名:<input type=text size=20 maxlength=30 name=new_user value="<?php echo $name;?>" readonly />(不能修改)<br/>
原密碼:<input type=password size=20 name=origpass maxlength=50 /><br/>
新密碼:<input type=password size=20 maxlength=50 name=new_pass />(不需要修改密碼請留空)
<br/>
重&nbsp;&nbsp;復:<input type=password size=20 maxlength=50 name=new_confirm_pass onblur="checkpass(this);" /><br/>
根目錄:<input type=text size=20 name=new_root value="<?php echo $g["root"];?>" /> <a href="javascript:showhelp('roothelp')">幫助</a>
<div id='roothelp' style="width:200px;float:right;display:none">
關於"根目錄"的幫助信息:<br/>
   相對於程序的目錄名，比如本程序在 wwwroot/down/longbill/ 下，
而你想設置根目錄為 wwwroot/down/user/ 那麼應該輸入 ../user/ 。<br/>注: <br/>1: ../代表上級目錄<br/>2:如果此目錄不存在程序會自動創建
</div>
<br/>
用戶組:<select name=new_group>
<?
$arr = file("class/group.php");
for($i=1;$arr[$i];$i++)
{
	$v = trim ($arr[$i]);
	if (!$v || !strpos($v,"|")) continue;
	$arr2 = explode("|",$v);
	echo "<option value='{$arr2[0]}' ";
	if ($arr2[0] == $g["group"]) echo "selected";
	echo ">{$arr2[0]}</option>\n";
}
?>
</select>
<br/>
<input type=submit value="更新">&nbsp;<input type=reset value="重設">
</form>
</div>
<?
}
else if ($action == "user" || $action == "deluser")
{
?>
<div>
<form action=ctrl.php method=post name=myform>
<input type=hidden name=action value=deluser>
用戶:<select name=username>
<?
$arr = file("class/users.php");
for($i=1;$arr[$i];$i++)
{
	$v = trim ($arr[$i]);
	if (!$v || !strpos($v,"|")) continue;
	$arr2 = explode("|",$v);
	echo "<option value='{$arr2[0]}'>{$arr2[0]}</option>\n";
}
?>
</select>
&nbsp;&nbsp;
<input type=button value='刪除' onclick="deluser()"> <input type=button value='編輯' onclick="muser()">
</form>
<script>
function deluser()
{
	var name = document.myform.username.value;
	if (confirm("你真的要刪除用戶 "+name+" 嗎?")) document.myform.submit();
}
function muser()
{
	var name = document.myform.username.value;
	window.location = "?action=muser&name="+name;
}
</script>
</div>
<?
}
else if ($action == "config" || !$action)
{
?>
<div>
<form action=ctrl.php method=post>
<input type=hidden name=action value=config>
標題:<input type=text size=50 name=title value="<?php echo $title;?>"/><br/>
模板:<select name=tempname>
<?
$handle = @opendir("temp/");
while($v = readdir($handle))
{
	if (is_file("temp/".$v) || $v=="." || $v =="..") continue;
	echo "<option value='{$v}'";
	if (trim($v) == $tempname) echo " selected";
	echo ">{$v}</option>\n";
}
?>
</select><br/>
<input name='force_encode' type='hidden' value='utf-8' />

<input type=checkbox name='allowurlencode' <?php if ($allowurlencode) echo "checked";?> />對中文檔案名使用URL編碼
<br/>
<br/>

<input type=submit value=更新>&nbsp;<input type=reset value=重設>
</form>
</div>
<?
}
else if ($action == "group" || $action == "delgroup")
{
?>
<div>
<form action=ctrl.php method=post name=myform>
<input type=hidden name=action value=delgroup>
組:<select name=groupname>
<?
$arr = file("class/group.php");
for($i=1;$arr[$i];$i++)
{
	$v = trim ($arr[$i]);
	if (!$v || !strpos($v,"|")) continue;
	$arr2 = explode("|",$v);
	echo "<option value='{$arr2[0]}'>{$arr2[0]}</option>\n";
}
?>
</select>
&nbsp;&nbsp;
<input type=button value='刪除' onclick="delgroup()"> <input type=button value='編輯' onclick="mgroup()">
</form>
<script>
function delgroup()
{
	var name = document.myform.groupname.value;
	if (confirm("你真的要刪除組 "+name+" 嗎?")) document.myform.submit();
}
function mgroup()
{
	var name = document.myform.groupname.value;
	window.location = "?action=mgroup&name="+name;
}
</script>
</div>
<?
}
else if ($action == "addgroup" && $user["addgroup"])
{
?>
<div>
<form action=ctrl.php name=myform method=post onsubmit="return checkgroupform();">
<input type=hidden name=action value=addgroup>
組名:<input name=groupname type=text size=20 /><br/>
默認瀏覽方式:<input type=checkbox name=visit />瀏覽 <input type=checkbox name=big />大圖標<br/>
限制檔案類型:<input type=text name=limittype size=30 value="php|asp|jsp|aspx|php3|cgi|cer|cdx|asa|" />
 <input type=radio name=only value="true" />只允許
 <input type=radio name=only value="0" checked />不允許
 <a href="javascript:showhelp('limithelp')">幫助</a>
<div id=limithelp style="width:200px;float:right;display:none">
關於"限制檔案類型"的幫助:<br/>
<ul>
<li>"只允許"：用戶只能操作前面填的檔案類型，其他所有的檔案類型都不能操作。
<li>"不允許"：用戶不能操作前面填的檔案類型，其他的檔案類型都可以操作。
<li>如果選中"只允許"，請注意修改前面的檔案類型。
</ul>
</div>
<br/>
新建檔案:<input type=checkbox name=newfile /><br/>
新建目錄:<input type=checkbox name=newdir /><br/>
下載源檔案:<input type=checkbox name=downfile /><br/>
上傳檔案:<input type=checkbox name=upfile /><br/>
從URL下載:<input type=checkbox name=savefromurl /><br/>
刪除檔案:<input type=checkbox name=delete /><br/>
ZIP打包:<input type=checkbox name=zippack /><br/>
ZIP解壓:<input type=checkbox name=unpack /><br/>
搜索:<input type=checkbox name=search /><br/>
全選/反選:<input type=checkbox name=select checked /><br/>
複製檔案:<input type=checkbox name=copy /><br/>
移動檔案:<input type=checkbox name=move /><br/>
查看源檔案:<input type=checkbox name=viewsorce /><br/>
重命名:<input type=checkbox name=rename /><br/>
保存檔案:<input type=checkbox name=savefile /><br/>
查看統計:<input type=checkbox name=property /><br/>
控制面板:<input type=checkbox name=admin onclick="$('admindiv').style.display = this.checked?'':'none';" /><br/>
<div style="display:none;width:300px;" id=admindiv>
<ul>
<li>添加用戶:<input type=checkbox name=adduser />
<li>刪除用戶:<input type=checkbox name=deluser />
<li>添加組:<input type=checkbox name=addgroup  />
<li>刪除組:<input type=checkbox name=delgroup  />
</ul>
</div>
<input type=submit value=新建>&nbsp;<input type=reset value=重設>
</form>
</div>
<?
}
else if ($action == "mgroup" && $user["addgroup"])
{
	$g = $_GET["name"];
	if (!$g) $g = $_POST["name"];
	$name = $g;
	$g = getgroup($g);
	if (!$g) exit("<div>組名錯誤</div>");
?>
<div>
<form action=ctrl.php name=myform method=post onsubmit="return checkgroupform();">
<input type=hidden name=action value=mgroup>
組名:<input name=groupname type=text size=20 value="<?php echo $name;?>" readonly />(不能修改)<br/>
默認瀏覽方式:<input type=checkbox name=visit <?php echocheck($g["visit"]);?> />瀏覽 <input type=checkbox name=big <?php echocheck($g["big"]);?> />大圖標<br/>
限制檔案類型:<input type=text name=limittype size=30 value="<?php echo $g["limittype"];?>" />
 <input type=radio name=only value="true" <?php echocheck($g["only"]);?> />只允許
 <input type=radio name=only value="0" <?php echocheck(!$g["only"]);?> />不允許
 <a href="javascript:showhelp('limithelp')">幫助</a>
<div id=limithelp style="width:200px;float:right;display:none">
關於"限制檔案類型"的幫助:<br/>
<ul>
<li>"只允許"：用戶只能操作前面填的檔案類型，其他所有的檔案類型都不能操作。
<li>"不允許"：用戶不能操作前面填的檔案類型，其他的檔案類型都可以操作。
<li>如果選中"只允許"，請注意修改前面的檔案類型。
</ul>
</div>


<br/>
新建檔案:<input type=checkbox name=newfile <?php echocheck($g["newfile"]);?> /><br/>
新建目錄:<input type=checkbox name=newdir <?php echocheck($g["newdir"]);?> /><br/>
下載源檔案:<input type=checkbox name=downfile <?php echocheck($g["downfile"]);?> /><br/>
上傳檔案:<input type=checkbox name=upfile <?php echocheck($g["upfile"]);?> /><br/>
從URL下載:<input type=checkbox name=savefromurl <?php echocheck($g["savefromurl"]);?> /><br/>
刪除檔案:<input type=checkbox name=delete <?php echocheck($g["delete"]);?> /><br/>
ZIP打包:<input type=checkbox name=zippack <?php echocheck($g["zippack"]);?> /><br/>
ZIP解壓:<input type=checkbox name=unpack <?php echocheck($g["unpack"]);?> /><br/>
搜索:<input type=checkbox name=search <?php echocheck($g["search"]);?> /><br/>
全選/反選:<input type=checkbox name=select <?php echocheck($g["select"]);?> /><br/>
複製檔案:<input type=checkbox name=copy <?php echocheck($g["copy"]);?> /><br/>
移動檔案:<input type=checkbox name=move <?php echocheck($g["move"]);?> /><br/>
查看源檔案:<input type=checkbox name=viewsorce <?php echocheck($g["viewsorce"]);?> /><br/>
重命名:<input type=checkbox name=rename <?php echocheck($g["rename"]);?> /><br/>
保存檔案:<input type=checkbox name=savefile <?php echocheck($g["savefile"]);?> /><br/>
查看統計:<input type=checkbox name=property <?php echocheck($g["property"]);?> /><br/>
控制面板:<input type=checkbox name=admin <?php echocheck($g["admin"]);?> onclick="$('admindiv').style.display = this.checked?'':'none';" /><br/>
<div style="display:<?echo ($g["admin"])?"":"none";?>;width:300px;" id=admindiv>
<ul>
<li>添加用戶:<input type=checkbox name=adduser <?php echocheck($g["adduser"]);?> />
<li>刪除用戶:<input type=checkbox name=deluser <?php echocheck($g["deluser"]);?> />
<li>添加組:<input type=checkbox name=addgroup <?php echocheck($g["addgroup"]);?> />
<li>刪除組:<input type=checkbox name=delgroup <?php echocheck($g["delgroup"]);?> />
</ul>
</div>
<input type=submit value=更新>&nbsp;<input type=reset value=重設>
</form>
</div>
<?
}

else if ($action == "update")
{
	echo "<div>";
	echo "<script language=javascript src='http://www.longbill.cn/update/update.php?v={$v}'></script>";
	echo "</div>";
}
else
{
	echo "<div>沒有權限!</div>";
}

function echocheck($v)
{
	if ($v) echo "checked";
}

function getgroup($groupname)
{

	$group = array();
	$dd = array();
	$groups=@file("class/group.php");
	for($i=1;$groups[$i];$i++)
	{
		$v = trim ($groups[$i]);
		if (!$v || !strpos($v,"|")) continue;
		$arr = explode("|",$v);
		if ($arr[0] == $groupname )
		{
			$rights = $v;
			break;
		}
	}
	if (!$rights) return false;
	$right = explode("|",$rights);
	for($j=1;$j<count($right);$j++)
	{
		$v = $right[$j];
		if (!$v) continue;
		if (strrpos($v,"&"))
		{
			if (substr($v,0,1) == "&") $v = substr($v,1,strlen($v));
			if (substr($v,-1) != "&") $v.="&";
			$dd["limittype"] = str_replace("&","|",$v);
		}
		else $dd["{$v}"] = 1;
	}
	return $dd;
}

function getuser($username)
{
	$dd = array();
	$users=@file("class/users.php");
	for($i=1;$users[$i];$i++)
	{
		$v = trim ($users[$i]);
		if (!$v || !strpos($v,"|")) continue;
		$arr = explode("|",$v);
		if ($arr[0] == $username)
		{
			$rights = $v;
			break;
		}
	}
	if (!$rights) return false;
	$arr = explode("|",$rights);
	$dd["root"] = $arr[2];
	$dd["group"] = $arr[3];
	return $dd;
}


function showjsfunctions()
{
?>
<script language=javascript>
function $(obj)
{
	return document.getElementById(obj);
}
function showhelp(id,v,e)
{
	if (!v)
		$(id).style.display = ($(id).style.display == "none")?"":"none";
	else
		$(id).style.display = e?"":"none";
}

function checkpass(v)
{
	if (v && document.myform.new_pass.value != v.value)
	{
		alert("密碼不一致!");
	}
	else if (!v)
	{
		var f=document.myform;
		if (!f.new_user.value)
		{
			alert("請輸入用戶名!");
			return false;
		}
		if (users.indexOf(f.new_user.value)!=-1 && f.action.value != "muser")
		{
			alert("用戶 "+f.new_user.value+" 已經存在!");
			return false;
		}
		if (!f.new_pass.value && f.action.value != "muser")
		{
			alert("請輸入密碼!");
			return false;
		}
		if (f.new_pass.value != f.new_confirm_pass.value)
		{
			alert("密碼不一致!");
			return false;
		}
		if (!f.new_root.value)
		{
			alert("請輸入根目錄!");
			return false;
		}
	}
}

function checkgroupform()
{
	var f=document.myform;
	if (!f.groupname.value)
	{
		alert('請輸入組名');
		return false;
	}
	if (groups.indexOf(f.groupname.value)!=-1 && f.action.value !="mgroup")
	{
		alert('組 '+f.groupname.value+" 已經存在!");
		return false;
	}
	if (document.myform.only[0].checked)
	{
		var limit =document.myform.limittype.value.toLowerCase();
		var types = "php|asp|jsp|aspx|php3|cgi";
		var type = types.split("|");
		for(var i=0;i<type.length;i++)
		{
			if (limit.indexOf(type[i]) !=-1 && !confirm("你真的希望用戶能夠操作 "+type[i]+" 類型的檔案嗎?\n這是很危險的!")) return false;
		}
	}
}
var groups = "||<?
$arr = file("class/group.php");
for($i=1;$arr[$i];$i++)
{
	$v = trim ($arr[$i]);
	if (!$v || !strpos($v,"|")) continue;
	$arr2 = explode("|",$v);
	echo "{$arr2[0]}|";
}
?>||";
var users = "||<?
$arr = file("class/users.php");
for($i=1;$arr[$i];$i++)
{
	$v = trim ($arr[$i]);
	if (!$v || !strpos($v,"|")) continue;
	$arr2 = explode("|",$v);
	echo "{$arr2[0]}|";
}
?>||";
</script>
<?
}


?>