<?php

/*
	[元件名稱] 底部導航選單
	[適用範圍] 全站

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
	
	/*多國語言轉換 $getlans['menu']? $getlans['menu']:*/

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
			

			//1=內部連結
			case "1" :
				$menuurl=ROOTPATH.$folder;
			break;

			
			//2=外部連結
			case "2" :
				$menuurl=$url;
			break;


			
			//連結到模組
			default:
				
				
				if($coltype=="index"){
					
					//首頁特殊處理
					if($GLOBALS["CONF"]["CatchOpen"]=="1"){
						$menuurl=ROOTPATH;
					}else{
						$menuurl=ROOTPATH."index.php";
					}

				}else{
					
					//正常模組連結
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