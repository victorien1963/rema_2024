<?php

/*
	[����W��] �~�P�˯�
	[�A�νd��] �M��
*/

function ShopBrandQuery(){

	global $msql,$fsql,$tsql;
		
		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$shownums=$GLOBALS["PLUSVARS"]["shownums"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$pagename=$GLOBALS["PLUSVARS"]["pagename"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$picw=$GLOBALS["PLUSVARS"]["picw"];
		$pich=$GLOBALS["PLUSVARS"]["pich"];
		$fittype=$GLOBALS["PLUSVARS"]["fittype"];


		include_once(ROOTPATH."includes/pages.inc.php");
		$pages=new pages;

		

		//�Ҫ�����
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		$str=$TempArr["start"];

		//�u��ܫ��w�����~�P
		if($_GET["catid"]!="" && $_GET["catid"]!="0"){
			
			$catid=$_GET["catid"];

			$totalnums=TblCount("_shop_brandcat","id","catid='$catid'");
			$pages->setvar(array("catid" => $catid));

			$pages->set($shownums,$totalnums);		                          
			$pagelimit=$pages->limit();	  


			$fsql->query("select brandid from {P}_shop_brandcat where catid='$catid' limit $pagelimit");
			while($fsql->next_record()){
				$brandid=$fsql->f('brandid');
				$tsql->query("select * from {P}_shop_brand where id='$brandid' ");
				if($tsql->next_record()){
					$brand=$tsql->f('brand');
					$src=$tsql->f('logo');
					$url=$tsql->f('url');
					$intro=$tsql->f('intro');
					$xuhao=$tsql->f('xuhao');
					$tj =$tsql->f('tj');
					$intro=strip_tags($intro);
					
					$link=ROOTPATH."shop/class/?showbrandid=".$brandid;

					if($src==""){$src="shop/pics/nologo.gif";}
			
					$src=ROOTPATH.$src;

					//�Ҫ����Ҹ���
					$var=array (
					'link' => $link,
					'target' => $target,
					'intro' => $intro, 
					'url' => $url,
					'src' => $src, 
					'picw' => $picw,
					'pich' => $pich,
					'brand' => $brand 
					);
					$str.=ShowTplTemp($TempArr["list"],$var);

				}
			}


		//������������~�P�˯�
		}else{

			$totalnums=TblCount("_shop_brand","id","id!='0'");
			$pages->setvar(array("key" => $key));
			$pages->set($shownums,$totalnums);		                          
			$pagelimit=$pages->limit();	 

			$tsql->query("select * from {P}_shop_brand order by xuhao limit $pagelimit");
			while($tsql->next_record()){
				$brandid=$tsql->f('id');
				$brand=$tsql->f('brand');
				$src=$tsql->f('logo');
				$url=$tsql->f('url');
				$intro=$tsql->f('intro');
				$xuhao=$tsql->f('xuhao');
				$tj =$tsql->f('tj');
				$intro=strip_tags($intro);
				
				$link=ROOTPATH."shop/class/?showbrandid=".$brandid;

				if($src==""){$src="shop/pics/nologo.gif";}
		
				$src=ROOTPATH.$src;

				//�Ҫ����Ҹ���
				$var=array (
				'link' => $link,
				'target' => $target,
				'intro' => $intro, 
				'url' => $url, 
				'src' => $src, 
				'picw' => $picw,
				'pich' => $pich,
				'brand' => $brand 
				);
				$str.=ShowTplTemp($TempArr["list"],$var);

			}
			
		
		}


		$str.=$TempArr["end"];
		
		$pagesinfo=$pages->ShowNow();

		$var=array (
		'fittype' => $fittype,
		'showpages' => $pages->output(1),
		'pagestotal' => $pagesinfo["total"],
		'pagesnow' => $pagesinfo["now"],
		'pagesshownum' => $pagesinfo["shownum"],
		'pagesfrom' => $pagesinfo["from"],
		'pagesto' => $pagesinfo["to"],
		'totalnums' => $totalnums
		);

		$str=ShowTplTemp($str,$var);

		return $str;

}

?>