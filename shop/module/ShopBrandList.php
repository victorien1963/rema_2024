<?php

/*
	[����W��] �~�P�C��
	[�A�νd��] �Ҧ�����
*/



function ShopBrandList(){

		global $msql,$fsql,$tsql;

		$showtj=$GLOBALS["PLUSVARS"]["showtj"];
		$shownums=$GLOBALS["PLUSVARS"]["shownums"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$picw=$GLOBALS["PLUSVARS"]["picw"];
		$pich=$GLOBALS["PLUSVARS"]["pich"];


		//�Ҫ�����
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);
		$str=$TempArr["start"];

		//�~�P�C��
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

			//�Ҫ����Ҹ���
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