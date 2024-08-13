<?php
function PageToUrl(){

	global $fsql,$SiteUrl,$tsql;
	
	if(strstr($_SERVER["QUERY_STRING"],".html")){
		$idArr=explode(".html",$_SERVER["QUERY_STRING"]);
		$id=$idArr[0];
	}elseif(isset($_GET["id"]) && $_GET["id"]!=""){
		$id=$_GET["id"];
	}
	$tourl="";
	$fsql->query("select url from {P}_page where id='$id' limit 0,1");
	if($fsql->next_record()){
		$tourl=$fsql->f('url');
	}else{
			$id=basename($_SERVER['SCRIPT_NAME'],".php");
		$id && $tsql->query("select url from {P}_page where pagefolder='$id' limit 0,1");
		if($tsql->next_record()){
			$tourl=$tsql->f('url');
		}
	}
	if($tourl!="http://"  &&  $tourl!="" &&  strlen($tourl)>1){
		if(substr($tourl,0,7)=="http://"){
			header("location:".$tourl);
		}elseif(substr($tourl,0,8)=="https://"){
			header("location:".$tourl);
		}elseif(substr($tourl,0,1)=="/"){
			$tourl=substr($tourl,1);
			header("location:".$SiteUrl.$tourl);
		}else{
			header("location:".$SiteUrl.$tourl);
		}
	}else{
		return false;
	}
	return false;
}
?>