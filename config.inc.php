<?php

#[資料庫參數]
$dbHost="mariadb-rema";
$dbName="remaspor_2024";
$dbUser="root";
$dbPass="dsa951230";

#[資料表前綴]
$TablePre="cpp";

#[語言]
$sLan="zh_tw";

#[網址]
$SiteUrl="http://localhost:80/";

#[時區]
date_default_timezone_set("Asia/Taipei");

#[允許語言]
$aLanList=array("zh_tw","en","zh_cn","");

#----------------------------------#

/*require_once $_SERVER['DOCUMENT_ROOT']."/wayhunt/config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/wayhunt/project-security.php";*/


if(!get_magic_quotes_gpc()){
	$REQUEST_METHOD=$REQUEST_METHOD?$REQUEST_METHOD:$_SERVER['REQUEST_METHOD'];
	if($REQUEST_METHOD=="GET"){
		$_GET=stripslashes_array($_GET);
		$_GET=addslashes_array($_GET);
	}elseif($REQUEST_METHOD=="POST"){
		$_POST=stripslashes_array($_POST);
		$_POST=addslashes_array($_POST);
	}
}

function addslashes_array($array){
	while(list($key,$var)=each($array)){
		if($key!='argc'&&$key!='argv'&&(strtoupper($key)!=$key||''.intval($key)=="$key")){
			if(is_string($var)){
				$array[$key]=addslashes($var);
			}
			if(is_array($var)){
				$array[$key]=addslashes_array($var);
			}
		}
	}
	return $array;
}

function stripslashes_array($array){
	while(list($key,$var)=each($array)){
		if($key!='argc'&&$key!='argv'&&(strtoupper($key)!=$key||''.intval($key)=="$key")){
			if(is_string($var)){
				$array[$key]=stripslashes($var);
			}
			if(is_array($var)){
				$array[$key]=stripslashes_array($var);
			}
		}
	}
	return $array;
}




?>