<?php

/*
	[元件名稱] 下拉友站連結
	[適用範圍] 全站
*/


function LinkOpt(){

	global $fsql;


	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$shownums=$GLOBALS["PLUSVARS"]["shownums"];
	$target=$GLOBALS["PLUSVARS"]["target"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];




		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

	
		$var=array(
			'coltitle' => $coltitle
		);

		$str=ShowTplTemp($TempArr["start"],$var);


		$fsql->query("select * from {P}_advs_link where groupid='$groupid' order by xuhao limit 0,$shownums");
		
		while($fsql->next_record()){
			
			$id=$fsql->f('id');
			$name=$fsql->f('name');
			$link=$fsql->f('url');

			
			$var=array (
			'name' => $name, 
			'link' => $link,
			'target' => $target,
			);

			$str.=ShowTplTemp($TempArr["list"],$var);

		}
		

        $str.=$TempArr["end"];


		

		return $str;


}

?>