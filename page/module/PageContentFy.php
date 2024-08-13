<?php

/*
	[元件名稱] 內容詳情翻頁
	[適用範圍] 內容詳情頁
*/


function PageContentFy(){

	global $fsql;


	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$pagename=$GLOBALS["PLUSVARS"]["pagename"];


	//獲取網址攔參數
	if(strstr($_SERVER["QUERY_STRING"],".html")){
		$idArr=explode(".html",$_SERVER["QUERY_STRING"]);
		$id=$idArr[0];
		$fsql->query("select groupid from {P}_page where id='$id'");
		if($fsql->next_record()){
			$groupid=$fsql->f('groupid');
		}
	}elseif(isset($_GET["id"]) && $_GET["id"]!=""){
		$id=$_GET["id"];
		$fsql->query("select groupid from {P}_page where id='$id'");
		if($fsql->next_record()){
			$groupid=$fsql->f('groupid');
		}
	}elseif(strstr($pagename,"_")){
		$arr=explode("_",$pagename);
		$fsql->query("select id from {P}_page_group where folder='$arr[0]'");
		if($fsql->next_record()){
			$groupid=$fsql->f('id');
		}
	}else{
		$fsql->query("select id from {P}_page_group where folder='$pagename'");
		if($fsql->next_record()){
			$groupid=$fsql->f('id');
		}
	}

	


	//模版解釋
	$Temp=LoadTemp($tempname);


	$i=1;
	$fsql->query("select id from {P}_page where groupid='$groupid' order by xuhao");
	while($fsql->next_record()){
		$parr[$i]=$fsql->f('id');
		if($parr[$i]==$id){
			$pcurrent=$i;
		}
	$i++;
	}

	$totalnums=$i-1;



	include_once(ROOTPATH."page/includes/contentpages.inc.php");
	$pages=new pages;

	
	$pages->setvar(array());
	$pages->set(1,$totalnums,$parr,$pcurrent);		


	$pagesinfo=$pages->ShowNow();

	$var=array (
	'showpages' => $pages->output(1),
	'pagestotal' => $pagesinfo["total"],
	'pagesnow' => $pagesinfo["now"],
	'pagesshownum' => $pagesinfo["shownum"],
	'pagesfrom' => $pagesinfo["from"],
	'pagesto' => $pagesinfo["to"],
	'totalnums' => $totalnums
	);

    $str=ShowTplTemp($Temp,$var);
	return $str;

}

?>