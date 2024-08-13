<?php

/*
	[元件名稱] 會員產品搜索表單
	[適用範圍] 會員產品檢索頁
*/


function MemberProductSearchForm(){

	global $msql,$fsql;
	
	
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	

	//網址攔參數
	if(isset($_GET["mid"]) && $_GET["mid"]!="" && $_GET["mid"]!="0"){
		$mid=$_GET["mid"];
	}else{
		return "";
	}

	$key=$_GET["key"];
	$myord=$_GET["myord"];
	$myshownums=$_GET["myshownums"];
	$pcatid=$_GET["pcatid"];
		
		$fsql->query("select * from {P}_product_pcat where memberid='$mid' order by xuhao");
		while($fsql->next_record()){
			$cat=$fsql->f('cat');
			$catid=$fsql->f('catid');
			if($pcatid==$catid){
				$catlist.="<option value='".$catid."' selected>".$cat."</option>";
			}else{
				$catlist.="<option value='".$catid."'>".$cat."</option>";
			}
		}

	

	//模版解釋
	$Temp=LoadTemp($tempname);

	$var=array (
	'coltitle' => $coltitle,
	'myshownums' => $myshownums, 
	'myord' => $myord, 
	'key' => $key, 
	'mid' => $mid, 
	'catlist' => $catlist
	);

	$str=ShowTplTemp($Temp,$var);

	return $str;


}
?>