<?php

/*
	[����W��] �����ɯ���
	[�A�νd��] ����

*/


function BottomMenu(){
	
	global $msql,$SiteUrl;


	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$shownums=$GLOBALS["PLUSVARS"]["shownums"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$tempcolor=$GLOBALS["PLUSVARS"]["tempcolor"];


	$Temp=LoadTemp($tempname);

	$TempArr=SplitTblTemp($Temp);

	
	$var=array (
		'tempcolor' => $tempcolor
	);
	
	/*�h��y���ഫ $getlans['menu']? $getlans['menu']:*/

	$str=ShowTplTemp($TempArr["start"],$var);
	$n=1;
	$msql->querylan("select * from {P}_menu where ifshow='1' and groupid='$groupid' order by xuhao limit 0,$shownums");
	while($msql->next_record()){
			$id=$msql->f('id');
			$getlans = strTranslate("menu", $id);
			$menu=$getlans['menu']? $getlans['menu']:$msql->f('menu');
			$linktype=$msql->f('linktype');
			$coltype=$msql->f('coltype');
			$folder=$msql->f('folder');
			$url=$msql->f('url');
			$target=$msql->f('target');
			
			
			switch($linktype){
			

			//1=�����s��
			case "1" :
				$menuurl=ROOTPATH.$folder;
			break;

			
			//2=�~���s��
			case "2" :
				$menuurl=$url;
			break;


			
			//�s����Ҳ�
			default:
				
				
				if($coltype=="index"){
					
					//�����S��B�z
					if($GLOBALS["CONF"]["CatchOpen"]=="1"){
						$menuurl=ROOTPATH;
					}else{
						$menuurl=ROOTPATH."index.php";
					}

				}else{
					
					//���`�Ҳճs��
					if($GLOBALS["CONF"]["CatchOpen"]=="1"){
						$menuurl=ROOTPATH.$coltype."/";
					}else{
						$menuurl=ROOTPATH.$coltype."/index.php";
					}
				}
				

			break;

		
		}

		
		$var=array (
		'menu' => $menu, 
		'menuurl' => $menuurl,
		'target' => $target
		);
		
		if($n>1){
			$str.=$TempArr["m0"];
		}

		$str.=ShowTplTemp($TempArr["menu"],$var);
		$n++;
		
		if($n%5==0){
			$str .= $TempArr["end"].$TempArr["start"];
		}
	}

	
	$str.=$TempArr["end"];

	return $str;
		
	

}

?>