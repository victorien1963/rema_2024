<?php

/*
	[元件名稱] 同級分類
	[適用範圍] 檢索頁(顯示目前類別同一級分類)
*/



function ShopSameClass(){

		global $msql,$fsql,$tsql;


		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$shownums=$GLOBALS["PLUSVARS"]["shownums"];
		$showtj=$GLOBALS["PLUSVARS"]["showtj"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$pagename=$GLOBALS["PLUSVARS"]["pagename"];

		$maybeclass = preg_replace('/\D/', '', $_SERVER['REQUEST_URI']);

		//網址攔參數
		if($pagename=="query"){
			if(strstr($_SERVER["QUERY_STRING"],".html")){
				$Arr=explode(".html",$_SERVER["QUERY_STRING"]);
				$nowcatid=$Arr[0];
			}elseif($_GET["catid"]>0){
				$nowcatid=$_GET["catid"];
			}else{
				$nowcatid=0;
			}
			
		}elseif($pagename=="detail"){
			
			if(strstr($_SERVER["QUERY_STRING"],".html")){
				$Arr=explode(".html",$_SERVER["QUERY_STRING"]);
				list($getid, $subpicid) = explode("-",$Arr[0]);
				//$getid=$Arr[0];
				$getid=$subpicid!=""? $subpicid:$getid;
				
				$gg = $msql->getone("select catid,subcatid,thirdcatid,fourcatid,subcatpath,thirdcatpath,fourcatpath from {P}_shop_con where id='$getid'");
				$nowcatid = $gg["catid"];
				$subcatpath = $gg["subcatpath"];
				$thirdcatpath=$gg["thirdcatpath"];
				$fourcatpath=$gg["fourcatpath"];
					
				$Arr=explode(".html",$_SERVER['HTTP_REFERER']);
				$Arr=explode("/?",$Arr[0]);
				$oricatid=(INT)$Arr[1];
				if($oricatid == 0){
					$Arr=explode("/shopclass",$_SERVER['HTTP_REFERER']);
					$oricatid=(INT)$Arr[1];
				}
				
				$fmdsubpath = fmpath( $oricatid );
				if(stripos($subcatpath, $fmdsubpath) !== false){
					$nowcatid = $gg["subcatid"];
				}elseif(stripos($thirdcatpath, $fmdsubpath) !== false){
					$nowcatid = $gg["thirdcatid"];
				}elseif(stripos($fourcatpath, $fmdsubpath) !== false){
					$nowcatid = $gg["fourcatid"];
				}
				
				$maybeclass = $nowcatid;
				
			}
			
		}
		
		if($nowcatid!="0"){
			$msql->query("select pid,catpath from {P}_shop_cat where catid='$nowcatid'");
			if($msql->next_record()){
				//$pid=$msql->f("pid");
				$catpath = explode(":",$msql->f("catpath"));
				$pid= (INT)$catpath["0"];
				$inid= (INT)$catpath["1"];
			}else{
				$pid=0;
			}
		}else{
			$pid=0;
		}



		$scl=" pid='$pid' ";
		
		if($showtj!="" && $showtj!="0"){
			$scl.=" and tj='1' ";
		}


		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);
		
		$catname = $msql->getonelan("SELECT cat FROM {P}_shop_cat WHERE catid='$pid'");
		$getlans = strTranslate("shop_cat", $pid);
		$catname["cat"]=$getlans['cat']? $getlans['cat']:$fsql->f('cat');
		
		//循環開始
		$var=array(
			'coltitle' => $coltitle,
			'catname' => $catname["cat"]
		);
		$str=ShowTplTemp($TempArr["start"],$var);


		$n = 1;
		$msql->query("select * from {P}_shop_cat where $scl order by xuhao");
		$gg = $msql->nf();
		while($msql->next_record()){
				$catid=$msql->f("catid");
				$getlans = strTranslate("shop_cat", $catid);
				$cat=$getlans['cat']? $getlans['cat']:$msql->f('cat');
				//$cat=$msql->f("cat");
				$catpath=$msql->f("catpath");
				$ifchannel=$msql->f('ifchannel');
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
				$inid = false;
				$fsql->query("select * from {P}_shop_cat where pid='$catid' $subscl order by xuhao");
				while($fsql->next_record()){
					$scatid=$fsql->f("catid");
					$getlans = strTranslate("shop_cat", $scatid);
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
					
					if($maybeclass == $scatid){
						$active = "color: #01c3ff";
						$inid = true;
					}else{
						$active = "";
					}

					$substr=str_replace("{#slink#}",$slink,$TempArr["list"]);
					$substr=str_replace("{#target#}",$target,$substr);
					$substr=str_replace("{#scat#}",$scat,$substr);
					$substr=str_replace("{#subcount#}",$subcount,$substr);
					$substr=str_replace("{#active#}",$active,$substr);
					$sublinkstr.=$substr;
					//$n++;
				}



				$var=array (
				'toplink' => $toplink, 
				'catid' => $catid,
				'cat' => $cat, 
				'topcount' => $topcount, 
				'sublinkstr' => $sublinkstr, 
				'target' => $target,
				'n' => $n,
				'in' => $inid? "display:block;":"",
				'border' => $gg==$n? "border-bottom":"",
				);
				$str.=ShowTplTemp($TempArr["menu"],$var);
				$n++;
		
		}


		$str.=$TempArr["end"];


		return $str;
		
}


?>