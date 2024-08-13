<?php

/*
	[元件名稱] 圖片廣告位
	[適用範圍] 全站
*/

function AdvsPic() { 
	
	global $msql;



	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$w=$GLOBALS["PLUSVARS"]["w"];
	$h=$GLOBALS["PLUSVARS"]["h"];
	$showborder=$GLOBALS["PLUSVARS"]["showborder"];
	$padding=$GLOBALS["PLUSVARS"]["padding"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$pagename=$GLOBALS["PLUSVARS"]["pagename"];
	
	if($coltitle=="ADBG_77"){
		if(stripos($pagename,"query") !== false && strstr($_SERVER["QUERY_STRING"],".html")){
			$Arr=explode(".html",$_SERVER["QUERY_STRING"]);
			$nowcatid=$Arr[0];
		}
		if(in_array($nowcatid,array("3","11","12","13","14","15"))){
			$groupid = $groupid;
		}elseif(in_array($nowcatid,array("4","16","17","18","19","20"))){
			$groupid = $groupid+1;
		}elseif(in_array($nowcatid,array("5","21","22","23","24","25"))){
			$groupid = $groupid+2;
		}elseif(in_array($nowcatid,array("9","41","42","43","44","45"))){
			$groupid = $groupid+3;
		}elseif(in_array($nowcatid,array("6","26","27","28","29","30"))){
			$groupid = $groupid+4;
		}elseif(in_array($nowcatid,array("7","31","32","33","34","35"))){
			$groupid = $groupid+5;
		}elseif(in_array($nowcatid,array("8","36","37","38","39","40"))){
			$groupid = $groupid+6;
		}elseif(in_array($nowcatid,array("10","46","47","48","49","50"))){
			$groupid = $groupid+7;
		}elseif(in_array($nowcatid,array("51","56","57"))){
			$groupid = $groupid+8;
		}elseif(in_array($nowcatid,array("52","53","54","55"))){
			$groupid = $groupid+9;
		}elseif($nowcatid == "2"){
			$groupid = $groupid+4;
		}
	}
	
	
	
	$msql->query("select * from {P}_advs_pic where id='$groupid'");
	if($msql->next_record()){
		$src=$msql->f('src');
		$link=$msql->f('url');
		//list($title, $subtitle)=explode("\r\n",$msql->f('text'));
		$getlans = strTranslate("advs_pic", $groupid);
		$memo=$getlans['memo']? $getlans['memo']:$msql->f('memo');
		list($title, $subtitle)=explode("\r\n",$memo);
		$target=$msql->f('target');
		
		if($link){
			$youtube_url = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
			preg_match($youtube_url, $link, $matches);
			$matches = array_filter($matches, function($var) {
				return($var !== '');
			});
			if (sizeof($matches) == 2) {
				$YID = $matches[1];
				$link = "https://www.youtube.com/embed/".$YID."?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1&amp;enablejsapi=1&amp;version=3&amp;loop=1&amp;playlist=".$YID;
				$mediapic = "https://img.youtube.com/vi/".$YID."/0.jpg";
				$showmedia = true;
			}else{
				$showmedia = false;
			}
			
			/*$youtube_url = "/https?:\/\/(?:www\.)?youtu(?:\.be|be\.com)\/watch(?:\?(.*?)&|\?)v=([a-zA-Z0-9_\-]+)(\S*)/i";
			if (preg_match($youtube_url, $url, $youtube)){
				$url = "https://www.youtube.com/embed/".$youtube[2]."?feature=oembed&amp;amp;wmode=opaque";
				$showmedia = true;
			}else{
				$showmedia = false;
			}*/
		}else{
			$showmedia = false;
		}
		
		
	}

	$src=ROOTPATH.$src;

	$w=$w-$padding;
	$h=$h-$padding;

	if($showborder!="none"){
		$w=$w-1;
		$h=$h-1;
	}



	$Temp=LoadTemp($tempname);

	$TempArr=SplitTblTemp($Temp);


	$var=array (
		'coltitle' => $coltitle,
		'title' => $title,
		'subtitle' => $subtitle,
		'src' => $src,
		'w' => $w,
		'h' => $h,
		'link' => $link
	);
	
	$str=ShowTplTemp($TempArr["start"],$var);

	
	if($showmedia){
		$str .= showtpltemp( $TempArr['m1'], $var );
	}else{
		if($link==""){
			$str .= showtpltemp( $TempArr['m0'], $var );
		}elseif($target=="_blank"){
			$str .= showtpltemp( $TempArr['list'], $var );
		}else{
			$str .= showtpltemp( $TempArr['list'], $var );
		}
	}
	
	/*if(substr($src,-4)==".swf"){
		$str.=ShowTplTemp($TempArr["menu"],$var);
	}elseif($link=="http://" || !$link){
		$str.=ShowTplTemp($TempArr["text"],$var);
	}else{
		$str.=ShowTplTemp($TempArr["list"],$var);
	}*/

	$str.=$TempArr["end"];
	return $str;
		
}

?>