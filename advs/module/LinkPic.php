<?php

/*
	[����W��] �Ϥ��ͯ��s��
	[�A�νd��] ����
*/


function LinkPic(){

	global $fsql,$msql,$sybtype,$lantype;
	
	//2016����f���B�ײv
	if($sybtype){
		list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid,$lantitle,$showtitle, $lang) = explode(",",$sybtype);
	}else{
		list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid,$lantitle,$showtitle) = explode(",",getDefaultSyb());
	}
	
	
	//�y��
	$arraySQL = getUseLan($lantype);
	
	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$shownums=$GLOBALS["PLUSVARS"]["shownums"];
	$target=$GLOBALS["PLUSVARS"]["target"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$pagename=$GLOBALS["PLUSVARS"]["pagename"];
	$ism = substr($pagename,-1)=="m"? true:false;

	$scl=" groupid='$groupid' and src!='' ";


	//�Ҫ�����
	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);
	
	$var=array(
		'coltitle' => $coltitle,
		'morelink' => $morelink
	);

	$str=ShowTplTemp($TempArr["start"],$var);
	
	$msql->query("select * from {P}_base_language");	
	while($msql->next_record()){
		$langcode_list[] = "?&lan=".$msql->f("langcode");
		$blanks[] = "";
	}
	
	$msql->query("select * from {P}_base_currency");	
	while($msql->next_record()){
		$syb_list[] = "&syb=".$msql->f("id");
		$syb_listb[] = "&syb=".$msql->f("pricecode");
		$sybblanks[] = "";
	}
	
	//�z�藍�n���y��
	//$scl .= " and xuhao<>'1' and xuhao<>'4'";

	$g = 0;
	$fsql->query("select * from {P}_advs_link where $scl order by xuhao limit 0,$shownums");
	
	while($fsql->next_record()){
		
		$id=$fsql->f('id');
		$getlans = strTranslate("advs_link", $id);
		$name=$getlans['name']? $getlans['name']:$fsql->f('name');
		$memo=$getlans['memo']? $getlans['memo']:$fsql->f('memo');
		list($name, $subname)=explode(",",$name);
		list($link, $sublink)=explode(",",$fsql->f('url'));
		list($linkstr, $sublinkstr)=explode(",",$memo);
		$pic=$fsql->f('src');
		$memo=$fsql->f('memo');
		$oth=$fsql->f('oth');
		
		$target=$fsql->f('type');
		$target=$target? $target:"_blank";
		if($link=="" || $link=="http://"){
			$target="";
		}

		$src=ROOTPATH.$pic;
		
		$REQUEST_URI = str_replace($langcode_list,$blanks,$_SERVER['REQUEST_URI']);
		$REQUEST_URI = str_replace($syb_list,$sybblanks,$REQUEST_URI);
		$REQUEST_URI = str_replace($syb_listb,$sybblanks,$REQUEST_URI);
		
		//�y���۲ŹϤ�
		if(stripos($link,"syb=".$getpriceid) !== false){
			$sybsrc = $src;
		}
		if(!$sybsrc){
			if(stripos($link,"syb=".$getpricecode) !== false){
				$sybsrc = $src;
			}
		}
		

		$var=array (
		'name' => addslashes($name),
		'subname' => addslashes($subname),
		'link' => $link=="" || $link=="http://"? "javascript:;":$link,
		'sublink' => $sublink=="" || $sublink=="http://"? "javascript:;":$sublink,
		'lanlink' => $link=="" || $link=="http://"? "javascript:;":$REQUEST_URI.$link,
		'sublanlink' => $sublink=="" || $sublink=="http://"? "javascript:;":$REQUEST_URI.$sublink,
		'src' => $src,
		'memo' => $memo,
		'linkstr' => $linkstr,
		'sublinkstr' => $sublinkstr,
		'target' => $target,
		'oth' => $oth,
		'showsublan' => $sublink==""? "none":"",
		'noboder' => $sublink==""? "noboder":"",
		);
		

			if(substr($pic,-4)==".swf"){
				$str.=ShowTplTemp($TempArr["menu"],$var);
			}else{
				$str.=ShowTplTemp($TempArr["list"],$var);
			}
			$g++;

	}

	
	$lantypestr = $lantitle." ".$getsymbol;
	
	$lantypestr_mobi = "<img src='".$sybsrc."' alt=''> ".$lantitle." ".$getsymbol."/".$arraySQL['showtitle'];
	
	
	$var=array (
		'src' => $sybsrc,
		'lantypestr' => $lantypestr,
		'lantypestr_mobi' => $lantypestr_mobi,
		'lantype' => $lantitle,
		'getsymbol' => '幣別/' . $getsymbol,
		'showtitle' => '語言/' . $arraySQL['showtitle']
	);
	
	$str.=ShowTplTemp($TempArr["end"],$var);

	/*if(!$ism && $g == 2){
		$str = '<div class="col-xs-3"></div>'.$str;
	}*/


	return $str;


}

?>