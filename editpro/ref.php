<?php
header("Expires: Wed, 4 Feb 1981 21:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
define( "ROOTPATH", "../" );
include( ROOTPATH."includes/common.inc.php" );
include_once("common.php");
@error_reporting(1);

$indir = $_GET['indir'];
$mode = $_GET['mode'];
$tempath =  $_GET['tempath'];

if(!$mode){
	$getroot="";
	}
elseif($mode=="border"){
	$getroot="../base/border/add/";
	}
elseif($mode=="temp"){
	$getroot="../".$tempath."/templates/add/";
	}else{
	$getroot=$mode;
	}


if($indir && $getroot){
mkcookie('indir',$indir);
mkcookie('getroot',$getroot);
}else{
mkcookie('indir','');
mkcookie('getroot','');
}

header("location:index.php");

?>