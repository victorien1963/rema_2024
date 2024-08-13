<?php

/*
	[元件名稱] 一級分類
	[適用範圍] 所有頁面
*/



function ShopClass(){

		global $msql,$fsql;


		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$shownums=$GLOBALS["PLUSVARS"]["shownums"];
		$catid=$GLOBALS["PLUSVARS"]["catid"];
		$showtj=$GLOBALS["PLUSVARS"]["showtj"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];

		if($catid!=0 && $catid!=""){
			$scl=" pid='$catid' ";
		}else{
			$scl=" pid='0' ";
		}

		
		if($showtj!="" && $showtj!="0"){
			$scl.=" and tj='1' ";
		}

	


		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		
		//循環開始
		$var=array(
			'coltitle' => $coltitle
		);

		$str=ShowTplTemp($TempArr["start"],$var);

			
		$msql->query("select * from {P}_shop_cat where $scl order by xuhao limit 0,$shownums");
		
		while($msql->next_record()){
				$pid=$msql->f("pid");
				$catid=$msql->f("catid");
				$cat=$msql->f("cat");
				$catpath=$msql->f("catpath");
				$ifchannel=$msql->f('ifchannel');
				$src=$msql->f('src');
				if($ifchannel=="1"){
					$link=ROOTPATH."shop/class/".$catid."/";
				}else{
					if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/class/".$catid.".html")){
						//$link=ROOTPATH."shop/class/".$catid.".html";
						$link=ROOTPATH."rshopclass".$catid;
					}else{
						//$link=ROOTPATH."shop/class/?".$catid.".html";
						$link=ROOTPATH."shopclass".$catid;
					}
				}

				$var=array (
				'src' => ROOTPATH.$src,
				'link' => $link, 
				'cat' => $cat, 
				'target' => $target
				);
				$str.=ShowTplTemp($TempArr["list"],$var);
	
		
		}
		
		
        $str.=$TempArr["end"];
       
		return $str;

		
}


?>