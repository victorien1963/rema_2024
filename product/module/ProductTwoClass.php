<?php

/*
	[元件名稱] 產品一、二級分類
	[適用範圍] 所有頁面
*/



function ProductTwoClass(){

		global $msql,$fsql,$tsql;

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
			$subscl=" and tj='1' ";
		}



		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);


		$str=$TempArr["start"];

			
		$msql->query("select * from {P}_product_cat where $scl order by xuhao");
		while($msql->next_record()){
				$catid=$msql->f("catid");
				$cat=$msql->f("cat");
				$catpath=$msql->f("catpath");
				$ifchannel=$msql->f('ifchannel');
				if($ifchannel=="1"){
					$toplink=ROOTPATH."product/class/".$catid."/";
				}else{
					if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."product/class/".$catid.".html")){
						$toplink=ROOTPATH."product/class/".$catid.".html";
					}else{
						$toplink=ROOTPATH."product/class/?".$catid.".html";
					}
				}

				$tsql->query("select count(id) from {P}_product_con where iffb='1' and catid!='0' and  catpath regexp '".fmpath($catpath)."'");
				if($tsql->next_record()){
					$topcount=$tsql->f('count(id)');
				}

				$sublinkstr="";
				$fsql->query("select * from {P}_product_cat where pid='$catid' $subscl order by xuhao");
				while($fsql->next_record()){
					$scatid=$fsql->f("catid");
					$scat=$fsql->f("cat");
					$scatpath=$fsql->f("catpath");
					$sifchannel=$fsql->f('ifchannel');
					if($sifchannel=="1"){
						$slink=ROOTPATH."product/class/".$scatid."/";
					}else{
						if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."product/class/".$scatid.".html")){
							$slink=ROOTPATH."product/class/".$scatid.".html";
						}else{
							$slink=ROOTPATH."product/class/?".$scatid.".html";
						}
					}
					
					$tsql->query("select count(id) from {P}_product_con where iffb='1' and catid!='0' and  catpath regexp '".fmpath($scatpath)."'");
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
				'cat' => $cat, 
				'topcount' => $topcount, 
				'sublinkstr' => $sublinkstr, 
				'target' => $target
				);
				$str.=ShowTplTemp($TempArr["menu"],$var);
	
		
		}
		
		
        $str.=$TempArr["end"];
       
		return $str;

		
}


?>