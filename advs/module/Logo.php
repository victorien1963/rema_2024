<?php

/*
	[元件名稱] 網站標誌
	[適用範圍] 全站
*/

function Logo() { 
	
	global $msql;


	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$w=$GLOBALS["PLUSVARS"]["w"];
	$h=$GLOBALS["PLUSVARS"]["h"];
	$showborder=$GLOBALS["PLUSVARS"]["showborder"];
	$padding=$GLOBALS["PLUSVARS"]["padding"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];	$pagename=$GLOBALS["PLUSVARS"]["pagename"];
	$msql->query("select * from {P}_advs_logo where id='$groupid'");
	if($msql->next_record()){				$id=$msql->f('id');		/*多國語言轉換*/		$getlans = strTranslate("advs_logo", $id);
		$src=$getlans['src']? $getlans['src']:$msql->f('src');
		$link=$getlans['url']? $getlans['url']:$msql->f('url');				$groupname =$getlans['groupname']? $getlans['groupname']: $msql->f('groupname');
	}
	$msql->query("select * from {P}_advs_logo where id='2'");	if($msql->next_record()){		$src2=$msql->f('src');		$link2=$msql->f('url');				$groupname2 = $msql->f('groupname');	}		
	$src=ROOTPATH.$src;	$src2=ROOTPATH.$src2;

	$w=$w-$padding;
	$h=$h-$padding;

	if($showborder!="none"){
		$w=$w-1;
		$h=$h-1;
	}


	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);

	$var=array (
		'coltitle' => $coltitle,		'src' => $src,					'src2' => $src2,
		'w' => $w,
		'h' => $h,
		'link' => $link,		'link2' => $link2,		'groupname' => $groupname,		'groupname2' => $groupname2,
	);

	$str=ShowTplTemp($TempArr["start"],$var);


	if(substr($src,-4)==".swf"){
		//$str.=ShowTplTemp($TempArr["menu"],$var);	
	}elseif ( $link == "http://" || $link == "" ){
		
		$str .= showtpltemp( $TempArr['text'], $var );
		
	}else{
		$str.=ShowTplTemp($TempArr["list"],$var);
	}		$ism = substr($pagename,-1)=="m"? true:false;
	if( $ism ){		$str.= $TempArr["menu"];	}
	$str.=$TempArr["end"];
	return $str;

}



?>