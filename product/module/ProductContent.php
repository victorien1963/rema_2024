<?php

/*
	[元件名稱] 產品詳情元件
	[適用範圍] 詳情頁
*/


function ProductContent(){

	global $fsql,$msql;


	$tempname=$GLOBALS["PLUSVARS"]["tempname"];


	//獲取網址攔參數
	if(strstr($_SERVER["QUERY_STRING"],".html")){
		$idArr=explode(".html",$_SERVER["QUERY_STRING"]);
		$id=$idArr[0];
	}elseif(isset($_GET["id"]) && $_GET["id"]!=""){
		$id=$_GET["id"];
	}	



	//模版解釋
	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);


	$fsql->query("select * from {P}_product_con where id='$id'");
	if($fsql->next_record()){
		$catid=$fsql->f('catid');
		$catpath=$fsql->f('catpath');
		$memberid=$fsql->f('memberid');
		$memo=$fsql->f('memo');
		$body=$fsql->f('body');
		$dtime=$fsql->f('dtime');
		$title=$fsql->f('title');
		$source=$fsql->f('source');
		$author=$fsql->f('author');
		$iffb=$fsql->f('iffb');
		$cl=$fsql->f('cl');
		$secure=$fsql->f('secure');
		$src=$fsql->f('src');
		$tags=$fsql->f('tags');
		$prop1=$fsql->f('prop1');
		$prop2=$fsql->f('prop2');
		$prop3=$fsql->f('prop3');
		$prop4=$fsql->f('prop4');
		$prop5=$fsql->f('prop5');
		$prop6=$fsql->f('prop6');
		$prop7=$fsql->f('prop7');
		$prop8=$fsql->f('prop8');
		$prop9=$fsql->f('prop9');
		$prop10=$fsql->f('prop10');
		$prop11=$fsql->f('prop11');
		$prop12=$fsql->f('prop12');
		$prop13=$fsql->f('prop13');
		$prop14=$fsql->f('prop14');
		$prop15=$fsql->f('prop15');
		$prop16=$fsql->f('prop16');
		$prop17=$fsql->f('prop17');
		$prop18=$fsql->f('prop18');
		$prop19=$fsql->f('prop19');
		$prop20=$fsql->f('prop20');
		$zhichi=$fsql->f('zhichi');
		$fandui=$fsql->f('fandui');
		
	}else{
		$str.=$TempArr["err1"];
		return $str;
	}

	$fsql->query("update {P}_product_con set cl=cl+1 where id='$id'");
	
	//發佈校驗-管理員可看
	if(AdminCheckModle()==false && $iffb!="1"){
		$str.=$TempArr["err1"];
		return $str;
	}

	//定義全局變量，使內容閱讀權限限制時不產生靜態頁
	$GLOBALS["consecure"]=$secure;


	//頁頭標題定義
	$GLOBALS["pagetitle"]=$title;
	

	//判斷閱讀權限
	if($secure>0){
		if(AdminCheckModle()==false && (!isLogin() || $_COOKIE["SE"]<$secure)){
			$str.=$TempArr["err2"];
			return $str;
		}
	}

	//標籤
	if($tags!=""){
		$tagsarr=explode(",",$tags);
		for($i=0;$i<sizeof($tagsarr);$i++){
			if($tagsarr[$i]!=""){
				$tagstr.="<a href='".ROOTPATH."product/class/index.php?showtag=".urlencode($tagsarr[$i])."'>".$tagsarr[$i]."</a> ";
			}
		}
		$showtag="block";
	}else{
		$showtag="none";
	}

	//評論數
	$msql->query("select count(id) from {P}_comment where catid='2' and rid='$id'");
	if($msql->next_record()){
		$commentcount=$msql->f('count(id)');
	}

	//評分總和
	$msql->query("select sum(pj1) from {P}_comment where catid='2' and rid='$id'");
	if($msql->next_record()){
		$totalcent=$msql->f('sum(pj1)');
	}

	//計算平均分
	if($commentcount>0){
		$centavg=ceil($totalcent/$commentcount);
	}else{
		$centavg=0;
	}

	//評論網址
	$commentutl=ROOTPATH."comment/class/index.php?catid=2&rid=".$id;


	$dtime=date("Y-m-d H:i:s",$dtime);

	if($src==""){$src="product/pics/nopic.gif";}
	$src=ROOTPATH.$src;

	if($memo!=""){
		$memo=nl2br($memo);
		$showmemo="block";
	}else{
		$showmemo="none";
	}

	
	//發佈人網址
	if($memberid!="0"){
		$memberurl=ROOTPATH."member/home.php?mid=".$memberid;
	}else{
		$memberurl="#";
	}

	//屬性列
	$propstr="";

	$i=1;
	$msql->query("select * from {P}_product_prop where catid='$catid' order by xuhao");
	while($msql->next_record()){
		$propname=$msql->f('propname');
		$pn="prop".$i;

		$pstr=str_replace("{#propname#}",$propname,$TempArr["list"]);
		$pstr=str_replace("{#prop#}",$$pn,$pstr);

		$propstr.=$pstr;

	$i++;
	}

	$var=array (
		'sitename' => $GLOBALS["CONF"]["SiteName"],
		'id' => $id, 
		'catid' => $catid, 
		'body' => $body, 
		'memo' => $memo, 
		'propstr' => $propstr, 
		'showmemo' => $showmemo, 
		'src' => $src, 
		'dtime' => $dtime, 
		'title' => $title, 
		'source' => $source, 
		'iffb' => $iffb, 
		'author' => $author, 
		'tagstr' => $tagstr, 
		'showtag' => $showtag, 
		'commentutl' => $commentutl, 
		'commentcount' => $commentcount, 
		'memberurl' => $memberurl, 
		'centavg' => $centavg, 
		'zhichi' => $zhichi, 
		'fandui' => $fandui, 
		'cl' => $cl
	);

    $str=ShowTplTemp($TempArr["start"],$var);


	
	
	

	

	$str.=$TempArr["end"];

	return $str;


}

?>