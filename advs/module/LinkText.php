<?php

/*
	[元件名稱] 文字友站連結
	[適用範圍] 全站
*/


function LinkText(){

	global $fsql,$sybtype,$lantype;

	//2016獲取貨幣、匯率
	if($sybtype){
		list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid,$lantitle,$showtitle) = explode(",",$sybtype);
	}else{
		list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid,$lantitle,$showtitle) = explode(",",getDefaultSyb());
	}
	
	
	//語言
	$arraySQL = getUseLan($lantype);

	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$shownums=$GLOBALS["PLUSVARS"]["shownums"];
	$target=$GLOBALS["PLUSVARS"]["target"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];




		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		
		$var=array(
			'coltitle' => $coltitle,
			'morelink' => $morelink
		);

		$str=ShowTplTemp($TempArr["start"],$var);
		
		
	
		if($getpriceid && $groupid=='1'){
			//不同國家不同跑馬燈
			$scl .= " and forcountry='{$getpriceid}'";
		}elseif($groupid=='1'){
			$scl .= " and forcountry='1'";
		}
		

		$n = 1;
		$fsql->query("select * from {P}_advs_link where groupid='$groupid' and iffb='1' {$scl} order by xuhao limit 0,$shownums");
		while($fsql->next_record()){
			
			$id=$fsql->f('id');
			/*多國語言轉換*/
			$getlans = strTranslate("advs_link", $id);
			
			$name=$getlans['name']? $getlans['name']:$fsql->f('name');
			$link=$fsql->f('url');
			$target=$fsql->f('type');
			
			$var=array (
			'name' => $name, 
			'link' => $link,
			'target' => $target,
			'active' =>$n==1? "active":"",
			);

			$str.=ShowTplTemp($TempArr["list"],$var);
			$n++;
		}
		

        $str.=$TempArr["end"];


		

		return $str;


}

?>