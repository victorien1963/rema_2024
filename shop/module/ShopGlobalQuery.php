<?php

/*
	[元件名稱] 全站翻頁商品列表
*/

function ShopGlobalQuery(){

	global $fsql,$msql;

		
		$shownums=$GLOBALS["PLUSVARS"]["shownums"];
		$ord=$GLOBALS["PLUSVARS"]["ord"];
		$sc=$GLOBALS["PLUSVARS"]["sc"];
		$showtj=$GLOBALS["PLUSVARS"]["showtj"];
		$cutword=$GLOBALS["PLUSVARS"]["cutword"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$catid=$GLOBALS["PLUSVARS"]["catid"];
		$tags=$GLOBALS["PLUSVARS"]["tags"];
		$pagename=$GLOBALS["PLUSVARS"]["pagename"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$picw=$GLOBALS["PLUSVARS"]["picw"];
		$pich=$GLOBALS["PLUSVARS"]["pich"];
		$fittype=$GLOBALS["PLUSVARS"]["fittype"];
		$projid=$GLOBALS["PLUSVARS"]["projid"];
		
		
		
		//預設條件		
		$scl=" iffb='1' and catid!='0' ";

		if($showtj!="" && $showtj!="0"){
			$scl.=" and tj='1' ";
		}

		//符合分類
		if($catid!=0 && $catid!=""){
			$catid=fmpath($catid);
			$scl.=" and catpath regexp '$catid' ";
		}


		//判斷符合標籤
		if($tags!=""){
			$tags=$tags.",";
			$scl.=" and tags regexp '$tags' ";
		}

		//取得目前專題名稱
		if(substr($pagename,"proj")){
			$projStr=explode("_",$pagename);
			
			$fsql->query("select project from {P}_shop_proj where folder='$projStr[1]'");
			if($fsql->next_record()){
				$projname=$fsql->f('project');
			}
			
			if($projid!="" && $projid!=0){
				$scl.=" and proj regexp '$projid' ";
			}
		}


		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);
		
		$var=array(
			'projname' => $projname
		);

		$str.=ShowTplTemp($TempArr["start"],$var);

		//翻頁
		include_once(ROOTPATH."includes/pages.inc.php");
		$pages=new pages;

		$totalnums=TblCount("_shop_con","id",$scl);
		
		$pages->setvar(array("key" => $key));

		$pages->set($shownums,$totalnums);		                          
			
		$pagelimit=$pages->limit();	
		
		

		$picnum=1;
		$fsql->query("select * from {P}_shop_con where $scl order by $ord $sc limit $pagelimit");

		while($fsql->next_record()){
			
			$id=$fsql->f('id');
			$title=$fsql->f('title');
			$catpath=$fsql->f('catpath');
			$dtime=$fsql->f('dtime');
			$nowcatid=$fsql->f('catid');
			$ifnew=$fsql->f('ifnew');
			$ifred=$fsql->f('ifred');
			$ifbold=$fsql->f('ifbold');
			$author=$fsql->f('author');
			$source=$fsql->f('source');
			$cl=$fsql->f('cl');
			$src=$fsql->f('src');
			$srcs=dirname($src)."/sp_".basename($src);
			$prop1=$fsql->f('prop1');
			$prop2=$fsql->f('prop2');
			$prop3=$fsql->f('prop3');
			$prop4=$fsql->f('prop4');
			$prop5=$fsql->f('prop5');
			$prop6=$fsql->f('prop6');
			$prop7=$fsql->f('prop7');
			$prop8=$fsql->f('prop8');
			$prop9=$fsql->f('prop9');
			$prop10=$fsql->f('prop10');
			$prop11=$fsql->f('prop11');
			$prop12=$fsql->f('prop12');
			$prop13=$fsql->f('prop13');
			$prop14=$fsql->f('prop14');
			$prop15=$fsql->f('prop15');
			$prop16=$fsql->f('prop16');
			$prop17=$fsql->f('prop17');
			$prop18=$fsql->f('prop18');
			$prop19=$fsql->f('prop19');
			$prop20=$fsql->f('prop20');
			$memo=$fsql->f('memo');
			$bn=$fsql->f('bn');
			$weight=$fsql->f('weight');
			$kucun=$fsql->f('kucun');
			$cent=$fsql->f('cent');
			$price=$fsql->f('price');
			$price0=$fsql->f('price0');
			$brandid=$fsql->f('brandid');
			$danwei=$fsql->f('danwei');
			$salenums=$fsql->f('salenums');
			$saletag=$fsql->f('saletag');

			$msql->query("select brand from {P}_shop_brand where id='$brandid' limit 0,1");
			if($msql->next_record()){
				$brand=$msql->f('brand');
			}

			
			if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/html/".$id.".html")){
				$link=ROOTPATH."shop/html/".$id.".html";
			}else{
				$link=ROOTPATH."shop/html/?".$id.".html";
			}
			
			
			
			$dtime=date("Y-m-d",$dtime);

			if($ifbold=="1"){$bold=" style='font-weight:bold' ";}else{$bold="";}

			if($ifred!="0"){$red=" style='color:".$ifred."' ";}else{$red="";}

			if($cutword!="0"){$title=csubstr($title,0,$cutword);}


			if($src==""){
				$src="shop/pics/nopic.gif";
				$srcs="shop/pics/nopic.gif";
			}
			
			$src=ROOTPATH.$src;
			$srcs=ROOTPATH.$srcs;
			
			if($saletag=="" || $saletag=="0"){
				$saletagstr=" ";		
			}else{
				$saletagstr="<img src='".ROOTPATH.$saletag."' width='50' height='50' />";
			}

			//參數列
			$propstr="";

			$i=1;
			$msql->query("select * from {P}_shop_prop where catid='$nowcatid' order by xuhao");
			while($msql->next_record()){
				$propname=$msql->f('propname');
				$pn="prop".$i;
				$pa="propname".$i;
				$$pa=$propname;
				$pstr=str_replace("{#propname#}",$propname,$TempArr["m1"]);
				$pstr=str_replace("{#prop#}",$$pn,$pstr);

				$propstr.=$pstr;

			$i++;
			}

			//計算價格
			include_once(ROOTPATH."shop/includes/shop.inc.php");
			$price=getMemberPrice($id,$price);

			
			$pricex=number_format($price0-$price,0);
			$price=number_format($price,0);
			$price0=number_format($price0,0);

		/*規格尺寸-STR*/
		$sizes = "";
		$getsize = "";
		$msql->query("select size from {P}_shop_conspec where gid='$id' order by id asc");
		while($msql->next_record()){
			$getsize[] = $msql->f('size');
		}
		if($getsize){
			$result = array_unique($getsize);
			foreach($result AS $size_value){
				$sizes .= "<span class='sizespan'>".$size_value."</span>";
			}
		}
		/*規格尺寸-END*/
		
		/*抓取第二張*/
			$msql->query( "select src from {P}_shop_pages where gid='{$id}' order by xuhao" );
			if ( $msql->next_record( ) )
			{
				$ssrc=$msql->f('src');
				$srcb=dirname($ssrc)."/sp_".basename($ssrc);
			}
			
			if($srcb==""){
				$srcb="shop/pics/nopic.gif";
			}
			$srcb=ROOTPATH.$srcb;
			
			//模版標籤解釋

			$var=array (
			'gid' => $id, 
			'title' => $title, 
			'memo' => $memo,
			'dtime' => $dtime, 
			'red' => $red, 
			'bold' => $bold,
			'link' => $link,
			'target' => $target,
			'author' => $author, 
			'source' => $source,
			'cat' => $cat, 
			'src' => $src,
			'srcs' => $srcs, 
			'picw' => $picw,
			'pich' => $pich,
			'cl' => $cl, 
			'bn' => $bn, 
			'weight' => $weight, 
			'kucun' => $kucun, 
			'cent' => $cent, 
			'price' => $price,
			'pricex' => $pricex, 
			'price0' => $price0, 
			'brand' => $brand, 
			'danwei' => $danwei, 
			'salenums' => $salenums, 
			'buyurl' => $buyurl, 
			'propstr' => $propstr, 
			'prop1' => $prop1,
			'prop2' => $prop2,
			'prop3' => $prop3,
			'prop4' => $prop4,
			'prop5' => $prop5,
			'prop6' => $prop6,
			'prop7' => $prop7,
			'prop8' => $prop8,
			'prop9' => $prop9,
			'prop10' => $prop10,
			'prop11' => $prop11,
			'prop12' => $prop12,
			'prop13' => $prop13,
			'prop14' => $prop14,
			'prop15' => $prop15,
			'prop16' => $prop16,
			'prop17' => $prop17,
			'prop18' => $prop18,
			'prop19' => $prop19,
			'prop20' => $prop20,
			'propname1' => $propname1,
			'propname2' => $propname2,
			'propname3' => $propname3,
			'propname4' => $propname4,
			'propname5' => $propname5,
			'propname6' => $propname6,
			'propname7' => $propname7,
			'propname8' => $propname8,
			'propname9' => $propname9,
			'propname10' => $propname10,
			'propname11' => $propname11,
			'propname12' => $propname12,
			'propname13' => $propname13,
			'propname14' => $propname14,
			'propname15' => $propname15,
			'propname16' => $propname16,
			'propname17' => $propname17,
			'propname18' => $propname18,
			'propname19' => $propname19,
			'propname20' => $propname20,
			'saletagstr' => $saletagstr,
			'sizes' => $sizes,
			'srcb' => $srcb
			
			);
			$str.=ShowTplTemp($TempArr["list"],$var);


		$picnum++;

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