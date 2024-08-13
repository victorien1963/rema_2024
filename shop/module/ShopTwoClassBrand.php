<?php

/*
	[元件名稱] 分類品牌組合切換
	[適用範圍] 所有頁面
*/



function ShopTwoClassBrand(){

		global $msql,$fsql,$tsql;

		$showtj=$GLOBALS["PLUSVARS"]["showtj"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$picw=$GLOBALS["PLUSVARS"]["picw"];
		$pich=$GLOBALS["PLUSVARS"]["pich"];
		$catid=$GLOBALS["PLUSVARS"]["catid"];


		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);
		$str=$TempArr["start"];


		//獲取分類
		if($catid){
			$scl=" pid='$catid' ";
		}else{
			$scl=" pid='0' ";
		}
		
		if($showtj!="" && $showtj!="0"){
			$scl.=" and tj='1' ";
			$subscl=" and tj='1' ";
		}


		$n = 1;
		$msql->query("select * from {P}_shop_cat where $scl order by xuhao");
		while($msql->next_record()){
				$catid=$msql->f("catid");
				$getlans = strTranslate("shop_cat", $catid);
				$oricat = $msql->f('cat');
				$cat=$getlans['cat']? $getlans['cat']:$msql->f('cat');
				//$cat=$msql->f("cat");
				$catpath=$msql->f("catpath");
				$ifchannel=$msql->f('ifchannel');
				$src=ROOTPATH.$msql->f('src');
				if($ifchannel=="1"){
					$toplink=ROOTPATH."shop/class/".$catid."/";
				}else{
					if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/class/".$catid.".html")){
						//$toplink=ROOTPATH."shop/class/".$catid.".html";
						$toplink=ROOTPATH."rshopclass".$catid;
					}else{
						//$toplink=ROOTPATH."shop/class/?".$catid.".html";
						$toplink=ROOTPATH."shopclass".$catid;
					}
				}

				$tsql->query("select count(id) from {P}_shop_con where iffb='1' and catid!='0' and  catpath regexp '".fmpath($catpath)."'");
				if($tsql->next_record()){
					$topcount=$tsql->f('count(id)');
				}

				$sublinkstr="";
				$fsql->query("select * from {P}_shop_cat where pid='$catid' $subscl order by xuhao");
				while($fsql->next_record()){
					$scatid=$fsql->f("catid");
					$getlans = strTranslate("shop_cat", $scatid);
					$soricat = $fsql->f('cat');
					$scat=$getlans['cat']? $getlans['cat']:$fsql->f('cat');
					//$scat=$fsql->f("cat");
					$scatpath=$fsql->f("catpath");
					$sifchannel=$fsql->f('ifchannel');
					if($sifchannel=="1"){
						$slink=ROOTPATH."shop/class/".$scatid."/";
					}else{
						if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/class/".$scatid.".html")){
							//$slink=ROOTPATH."shop/class/".$scatid.".html";
							$slink=ROOTPATH."rshopclass".$scatid;
						}else{
							//$slink=ROOTPATH."shop/class/?".$scatid.".html";
							$slink=ROOTPATH."shopclass".$scatid;
						}
					}
					
					$tsql->query("select count(id) from {P}_shop_con where iffb='1' and catid!='0' and  catpath regexp '".fmpath($scatpath)."'");
					if($tsql->next_record()){
						$subcount=$tsql->f('count(id)');
					}

					$substr=str_replace("{#slink#}",$slink,$TempArr["list"]);
					$substr=str_replace("{#target#}",$target,$substr);
					$substr=str_replace("{#scat#}",$scat,$substr);
					$substr=str_replace("{#subcount#}",$subcount,$substr);
					$sublinkstr.=$substr;
				}



				$var=array (
				'toplink' => $toplink, 
				'catid' => $catid,
				'cat' => $cat, 
				'topcount' => $topcount, 
				'sublinkstr' => $sublinkstr, 
				'target' => $target,
				'src' => $src,
				'n' => $n,
				);
				$str.=ShowTplTemp($TempArr["menu"],$var);
				$n++;
		
		}
		
		
		
		
        $str.=$TempArr["end"];
        
        if($GLOBALS["PLUSVARS"]["catid"] == 1){
        	$nav = 0;
        }else{
        	$nav = 1;
        }
        
        $str=str_replace("{#nav#}",$nav,$str);



		//品牌列表
		$str.=$TempArr["m0"];
		
		if($showtj!="" && $showtj!="0"){
			$addscl=" where tj='1' ";
		}else{
			$addscl="";
		}

		$tsql->query("select * from {P}_shop_brand $addscl order by xuhao ");
		while($tsql->next_record()){
			$brandid=$tsql->f('id');
			$brand=$tsql->f('brand');
			$src=$tsql->f('logo');
			$url=$tsql->f('url');
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
			$str.=ShowTplTemp($TempArr["m1"],$var);

		}
			
		$str.=$TempArr["m2"];
       
		return $str;

		
}


?>