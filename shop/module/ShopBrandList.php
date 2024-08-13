<?php

/*
	[元件名稱] 品牌列表
	[適用範圍] 所有頁面
*/



function ShopBrandList(){

		global $msql,$fsql,$tsql;

		$showtj=$GLOBALS["PLUSVARS"]["showtj"];
		$shownums=$GLOBALS["PLUSVARS"]["shownums"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$picw=$GLOBALS["PLUSVARS"]["picw"];
		$pich=$GLOBALS["PLUSVARS"]["pich"];


		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);
		$str=$TempArr["start"];

		//品牌列表
		$scl=" id!='' ";
		if($showtj!="" && $showtj!="0"){
			$scl.=" and tj='1' ";
		}else{
			$scl.="";
		}

		$tsql->query("select * from {P}_shop_brand where $scl order by xuhao limit 0,$shownums");
		while($tsql->next_record()){
			$brandid=$tsql->f('id');
			$brand=$tsql->f('brand');
			$src=$tsql->f('logo');
			$url=$tsql->f('url');
			$intro=$tsql->f('intro');
			$xuhao=$tsql->f('xuhao');
			$tj =$tsql->f('tj');
			
			$intro=strip_tags($intro);
			
			$brandlink=ROOTPATH."shop/class/?showbrandid=".$brandid;

			if($src==""){$src="shop/pics/nologo.gif";}
	
			$src=ROOTPATH.$src;

			//模版標籤解釋
			$var=array (
				'brandlink' => $brandlink,
				'target' => $target,
				'url' => $url, 
				'src' => $src, 
				'picw' => $picw,
				'pich' => $pich,
				'brand' => $brand 
			);
			$str.=ShowTplTemp($TempArr["list"],$var);
		}
			
		$str.=$TempArr["end"];
       
		return $str;
		
}


?>