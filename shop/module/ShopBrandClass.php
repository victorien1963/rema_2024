<?php

/*
	[元件名稱] 品牌商品一級分類
	[適用範圍] 所有頁面
*/



function ShopBrandClass(){

		global $msql,$fsql;


		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$showtj=$GLOBALS["PLUSVARS"]["showtj"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];


		//網址攔品牌id
		if(isset($_GET["brandid"]) && $_GET["brandid"]!=""){
			$brandid=$_GET["brandid"];
		}else{
			return "ERROR: NO BRANDID";
		}

		//獲取品牌關聯catid
		$msql->query("select * from {P}_shop_brandcat where brandid='$brandid'");
		while($msql->next_record()){
			$catArr[]=$msql->f('catid');
		}

		
		$scl=" pid='0' ";

		
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

			
		$msql->query("select * from {P}_shop_cat where $scl order by xuhao");
		
		while($msql->next_record()){
				$pid=$msql->f("pid");
				$catid=$msql->f("catid");
				$cat=$msql->f("cat");
				$catpath=$msql->f("catpath");

				if(is_array($catArr) && in_array($catid,$catArr)){
				
					$link=ROOTPATH."shop/class/?showbrandid=".$brandid."&catid=".$catid;

					$var=array (
					'link' => $link, 
					'cat' => $cat, 
					'target' => $target
					);
					$str.=ShowTplTemp($TempArr["list"],$var);
				}
		}
		
		
        $str.=$TempArr["end"];
       
		return $str;

		
}


?>