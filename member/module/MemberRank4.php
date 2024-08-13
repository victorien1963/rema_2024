<?php

/*
	[元件名稱] 會員榜(積分4)
	[適用範圍] 全站
*/

function MemberRank4(){

	global $fsql,$msql;

		
		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
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
		
		//積分名稱
		$msql->query("select * from {P}_member_centset");
		if($msql->next_record()){
		$centname1=$msql->f('centname1');
		$centname2=$msql->f('centname2');
		$centname3=$msql->f('centname3');
		$centname4=$msql->f('centname4');
		$centname5=$msql->f('centname5');
		}

		$picnum=1;
		$fsql->query("select * from {P}_member order by cent4 desc limit 0,$shownums");
		while($fsql->next_record()){
			$mid=$fsql->f('memberid');
			$pname=$fsql->f('pname');
			$nowface=$fsql->f('nowface');
			$cent1=$fsql->f('cent1');
			$cent2=$fsql->f('cent2');
			$cent3=$fsql->f('cent3');
			$cent4=$fsql->f('cent4');
			$cent5=$fsql->f('cent5');

			$memberurl=ROOTPATH."member/home.php?mid=".$mid;
			$face=ROOTPATH."member/face/".$nowface.".gif";



			//模版標籤解釋

			$var=array (
			'pname' => $pname, 
			'face' => $face,
			'memberurl' => $memberurl, 
			'cent' => $cent4, 
			'centname1' => $centname1, 
			'centname2' => $centname2, 
			'centname3' => $centname3, 
			'centname4' => $centname4, 
			'centname5' => $centname5, 
			'cent1' => $cent1, 
			'cent2' => $cent2, 
			'cent3' => $cent3, 
			'cent4' => $cent4, 
			'cent5' => $cent5, 
			'target' => $target, 
			'picnum' => $picnum
			);
			$str.=ShowTplTemp($TempArr["list"],$var);


		$picnum++;

		}

		$str.=$TempArr["end"];


		return $str;

}

?>