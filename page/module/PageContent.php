<?php

/*
	[元件名稱] 內容詳情元件
	[適用範圍] 內容詳情頁
*/


function PageContent(){

	global $fsql;


	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$pagename=$GLOBALS["PLUSVARS"]["pagename"];

	//本元件插入不同頁面時的智慧型判斷
	if(strstr($_SERVER["QUERY_STRING"],".html")){
		$idArr=explode(".html",$_SERVER["QUERY_STRING"]);
		$id=$idArr[0];
		$scl=" where id='$id' ";
	}elseif(isset($_GET["id"]) && $_GET["id"]!=""){
		$id=$_GET["id"];
		$scl=" where id='$id' ";
	}elseif(strstr($pagename,"_")){
		//直接瀏覽獨立產生網頁時
		$arr=explode("_",$pagename);
		if(sizeof($arr)==2){
			$fsql->querylan("select id from {P}_page_group where folder='$arr[0]'");
			if($fsql->next_record()){
				$groupid=$fsql->f('id');
			}
			$scl=" where groupid='$groupid' and pagefolder='$arr[1]'";
		}
	}else{
		//直接瀏覽網頁組時找到本組第一頁
		$fsql->querylan("select id from {P}_page_group where folder='$pagename'");
		if($fsql->next_record()){
			$groupid=$fsql->f('id');
		}
		$scl=" where groupid='$groupid' order by xuhao limit 0,1";
	}

	


	//模版解釋
	$Temp=LoadTemp($tempname);


	$fsql->querylan("select * from {P}_page $scl ");
	if($fsql->next_record()){
		$id=$fsql->f('id');
		$body=$fsql->f('body');
		$title=$fsql->f('title');
		$getlans = strTranslate("page", $id);
		$body=$getlans['body']? $getlans['body']:$body;
		$title=$getlans['title']? $getlans['title']:$title;
	}
	

	//頁頭標題定義
	$GLOBALS["pagetitle"]=$title;
	$GLOBALS["channel"]=$title;
	
	$body = str_replace("{#CP#}",ROOTPATH."page/templates/",$body);


	$var=array (
		'coltitle' => $coltitle,
		'body' => $body, 
		'title' => $title, 
	);

    $str=ShowTplTemp($Temp,$var);
	return $str;

}

?>