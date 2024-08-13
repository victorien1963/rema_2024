<?php

/*
	[����W��] �ӫ~�˯�
	[�A�νd��] �����˯���
*/ 


function ShopQuery(){

	global $fsql,$msql,$sybtype,$strColors,$strNoresult;

	
	
	$shownums=$GLOBALS["PLUSVARS"]["shownums"];
	$cutword=$GLOBALS["PLUSVARS"]["cutword"];
	$target=$GLOBALS["PLUSVARS"]["target"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$picw=$GLOBALS["PLUSVARS"]["picw"];
	$pich=$GLOBALS["PLUSVARS"]["pich"];
	$fittype=$GLOBALS["PLUSVARS"]["fittype"];
	$cutbody=$GLOBALS["PLUSVARS"]["cutbody"];
	
		//����f���B�ײv
		if($sybtype){
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",$sybtype);
		}else{
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",getDefaultSyb());
		}

	//���}�d�Ѽ�
	if(strstr($_SERVER["QUERY_STRING"],".html")){
		$Arr=explode(".html",$_SERVER["QUERY_STRING"]);
		$catid=$nowcatid=$Arr[0];
		
	}elseif($_GET["catid"]>0){
		$catid=$nowcatid=$_GET["catid"];
	}else{
		$catid=$nowcatid=0;
	}

	$key=str_replace("?","",$_GET["key"]);
	$showtj=$_GET["showtj"];
	$page=$_GET["page"];
	$myord=$_GET["myord"];
	$myshownums=$_GET["myshownums"];
	$memberid=$_GET["memberid"];
	$showtag=$_GET["showtag"];
	$showbrandid=$_GET["showbrandid"];
	$pricefrom=$_GET["pricefrom"];
	$priceto=$_GET["priceto"];
	$showmethod=$_GET["showmethod"];

	switch($myord){
		case "priceasc":
			$showord=" price asc ";
		break;
		case "pricedesc":
			$showord=" price desc ";
		break;
		case "uptime":
			$showord=" uptime desc ";
		break;
		case "dtime":
			$showord=" dtime desc ";
		break;
		case "cl":
			$showord=" cl desc ";
		break;
		case "salenums":
			$showord=" salenums desc ";
		break;
		default:
			$myord="xuhao";
			//$showord="catpath asc, fourcatid asc, thirdcatid asc, subcatid asc, catid asc, xuhao asc ";
			$showord="catpath asc, fourcatid asc, thirdcatid asc, subcatid asc, catid asc, xuhao asc ";
		break;
	}


	switch($showmethod){
		case "lb":
			$querylist="menu";
		break;
		case "tu":
			$querylist="con";
		break;
		default:
			$querylist="list";
			$showmethod="cc";
		break;
	}

	

	if($myshownums!="" && $myshownums!="0"){
		$shownums=$myshownums;
	}else{
		$myshownums="12";
	}

 	$fsql->query("select cat,catpath from {P}_shop_cat where catid='$catid'");
 	if($fsql->next_record()){
 		$catname=$fsql->f("cat");
 		list($Fcat)=explode(":",$fsql->f("catpath"));
 		$Fcat = (INT)$Fcat;
 	}
 	$catnameArr=explode(" ",$catname);
	
	if($catid==0){
		$catnameArr[0]="Product Search";
		$catnameArr[0]=iconv("BIG5","UTF-8",$catnameArr[0]);
	}
	
	$msql->query("select src from {P}_shop_cat where catid='$catid'");
		if($msql->next_record()){
			$catsrc=ROOTPATH.$msql->f('src');
		}
	
	//�Ҫ�����
	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);
	
	$var=array (
	'catname' => $catname,
	'catname1' => $catnameArr[0],
	'catname2' => $catnameArr[1],
	'showmethod' => $showmethod,
	'myshownums' => $myshownums,
	'catid' => $catid,
	'showbrandid' => $showbrandid,
	'pricefrom' => $pricefrom,
	'priceto' => $priceto,
	'key' => $key,
	'myord' => $myord,
	'catsrc' => $catsrc,
	);
	
	//���Y���D�w�q
	$GLOBALS["pagetitle"]=$catname;

	$str=ShowTplTemp($TempArr["start"],$var);


	$scl=" iffb='1' and catid!='0' ";

	if($catid!="0" && $catid!=""){
		//$fmdpath=fmpath($catid);
		//$scl.=" and (catpath regexp '$fmdpath' or fourcatpath regexp '$fmdpath'or thirdcatpath regexp '$fmdpath' or subcatpath regexp '$fmdpath') ";
		//2020 10 24--��Ѥ���ID����ӫ~��X
		//�^������ID�P�U�Ҫ�ID
		$fsql->query("select catid from {P}_shop_cat where pid='$catid'");
	 	while($fsql->next_record()){
	 		$listcatid[]= fmpath($fsql->f("catid"));
	 	}
	 	if(!$listcatid){
	 		$listcatid = array(fmpath($catid));
	 	}
	}

	if($showtj!="" && $showtj!="all"){
	$scl.=" and tj='$showtj' ";

	}
	if($memberid!="" && $memberid!="all"){
	$scl.=" and memberid='$memberid' ";
	}

	if($showbrandid!="" && $showbrandid!="0"){
	$scl.=" and brandid='$showbrandid' ";
	}

	if($pricefrom!="" && $priceto!=""){
	$scl.=" and price>='$pricefrom' and price<='$priceto' ";
	}


	if($key!=""){
		
		$scl.=" and (title regexp '$key' or bn regexp '$key') ";
		
	}
	
	if($showtag!=""){
		$scl.=" and tags regexp '$showtag' ";
	}

	$scl .= " and (starttime<='".time()."' OR starttime='') and (endtime>='".time()."' OR endtime='') ";
	
	$scl .= "and ifsub='0'";


	
	include_once(ROOTPATH."includes/pages.inc.php");
	$pages=new pages;

	$totalnums=TblCount("_shop_con","id",$scl);
	
	$pages->setvar(array("catid" => $catid,"myord" => $myord,"myshownums" => $myshownums,"showmethod" => $showmethod,"pricefrom" => $pricefrom,"priceto" => $priceto,"showtj" => $showtj,"showbrandid" => $showbrandid,"key" => $key));

	$pages->set($shownums,$totalnums);		                          
		
	$pagelimit=$pages->limit();
	
	$fsql->query("select * from {P}_shop_sort where catid='$catid' order by xuhao asc");
	while($fsql->next_record()){
		$sortlist .= $sortlist? ",".$fsql->f('gid'):$fsql->f('gid');
	}
	
	
	if($sortlist){
		$showord = "FIELD(`id`, $sortlist)";
	}
	
	
	$r=1;
	
	$listcatid = $listcatid? $listcatid:array("0");
	
foreach($listcatid AS $arrcatid){
	
	if($arrcatid){
		$catscl = " and (catpath regexp '$arrcatid' or fourcatpath regexp '$arrcatid'or thirdcatpath regexp '$arrcatid' or subcatpath regexp '$arrcatid') ";
		$getpcat = (INT)$arrcatid;
	}
	
	$flag= true;
	$fsql->query("select * from {P}_shop_con where $scl $catscl order by $showord limit $pagelimit");
	while($fsql->next_record()){
		$colorstr = "";
		$id=$orid=$fsql->f('id');
		$ifpic=$fsql->f('ifpic');
		$subpicid=$fsql->f('subpicid');
		if($ifpic == "1"){
			$id = $subpicid;
		}
		
		$colorcode = $fsql->f('colorcode');
		$colorcode && $colorstr=str_replace("{#colorcode#}",$colorcode,$TempArr["text"]);
		
		$getlans = strTranslate("shop_con", $id);
		if($ifpic == "1"){
			$id = $subpicid;
			$msql->query("select * from {P}_shop_con where id='{$id}'");
			$msql->next_record();
			$title=$getlans['title']? $getlans['title']:$msql->f('title');
			$catid=$msql->f('catid');
			$catpath=$msql->f('catpath');
			$dtime=$msql->f('dtime');
			$nowcatid=$msql->f('catid');
			$ifbold=$msql->f('ifbold');
			$ifred=$msql->f('ifred');
			$author=$msql->f('author');
			$source=$msql->f('source');
			$type=$msql->f('type');
			
			$src=$fsql->f('src');
			$srcs=dirname($src)."/sp_".basename($src);
			
			$cl=$msql->f('cl');
			$prop1=$msql->f('prop1');
			$prop2=$msql->f('prop2');
			$prop3=$msql->f('prop3');
			$prop4=$msql->f('prop4');
			$prop5=$msql->f('prop5');
			$prop6=$msql->f('prop6');
			$prop7=$msql->f('prop7');
			$prop8=$msql->f('prop8');
			$prop9=$msql->f('prop9');
			$prop10=$msql->f('prop10');
			$prop11=$msql->f('prop11');
			$prop12=$msql->f('prop12');
			$prop13=$msql->f('prop13');
			$prop14=$msql->f('prop14');
			$prop15=$msql->f('prop15');
			$prop16=$msql->f('prop16');
			$prop17=$msql->f('prop17');
			$prop18=$msql->f('prop18');
			$prop19=$msql->f('prop19');
			$prop20=$msql->f('prop20');
			$memo=$msql->f('memo');
			$bn=$msql->f('bn');
			$weight=$msql->f('weight');
			$kucun=$msql->f('kucun');
			$cent=$msql->f('cent');
			$price=$getrate!="1"? round(($msql->f('price')*$getrate),$getpoint):$msql->f('price');
			$price0=$getrate!="1"? round(($msql->f('price0')*$getrate),$getpoint):$msql->f('price0');
			$brandid=$msql->f('brandid');
			$danwei=$msql->f('danwei');
			$salenums=$msql->f('salenums');
			$saletag=$msql->f('saletag');
			$colorpic=$fsql->f('colorpic');
			$colorpics = ROOTPATH.dirname($colorpic)."/sp_".basename($colorpic);
			$colorpic=ROOTPATH.$colorpic;
		}else{
			$title=$getlans['title']? $getlans['title']:$fsql->f('title');
			$catid=$fsql->f('catid');
			$catpath=$fsql->f('catpath');
			
			$cats = explode(":",$catpath);
			$tnums=sizeof($cats)-2;
			//$getpcat = (INT)$cats[$tnums];
			//$getpcat = (INT)$fmdpath;
			
			$dtime=$fsql->f('dtime');
			$nowcatid=$fsql->f('catid');
			$ifbold=$fsql->f('ifbold');
			$ifred=$fsql->f('ifred');
			$author=$fsql->f('author');
			$source=$fsql->f('source');
			$type=$fsql->f('type');
			$src=$fsql->f('src');
			$srcs=dirname($src)."/sp_".basename($src);
			$cl=$fsql->f('cl');
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
			$price=$getrate!="1"? round(($fsql->f('price')*$getrate),$getpoint):$fsql->f('price');
			$price0=$getrate!="1"? round(($fsql->f('price0')*$getrate),$getpoint):$fsql->f('price0');
			$brandid=$fsql->f('brandid');
			$danwei=$fsql->f('danwei');
			$salenums=$fsql->f('salenums');
			$saletag=$fsql->f('saletag');
			$colorpic=$fsql->f('colorpic');
			$colorpics = ROOTPATH.dirname($colorpic)."/sp_".basename($colorpic);
			$colorpic=ROOTPATH.$colorpic;
			
		}
		//if($catid && $getcatid!=$catid){
		/*if($catid && $getcatid!=$catid){
			$flag = true;
		}*/
		
		if($flag){
			/*��������*/
			if($getpcat == ""){
				$maybeclass = preg_replace('/\D/', '', $_SERVER['REQUEST_URI']);
				$getpcat = $maybeclass;
			}
			$msql->query("select * from {P}_shop_cat where catid='{$getpcat}'");
			$msql->next_record();
			$catname=$msql->f('cat');
			$catmemo=$msql->f('memo');
			$catsrc=$msql->f('src');
			
			$menustr = str_replace("{#catsrc#}",ROOTPATH.$catsrc,$TempArr["menu"]);
			$menustr = str_replace("{#catname#}",$catname,$menustr);
			$menustr = str_replace("{#memo#}",$catmemo,$menustr);
			
			$str .= $getcatid? "</div><!--E***--><br style='clear:both;'><hr style='border: 1px #dedede solid;margin: 40px auto; width:65%;'>".$menustr:$menustr;
			
			$getcatid = $catid;
			$flag=false;
		}

		$msql->query("select brand from {P}_shop_brand where id='$brandid' limit 0,1");
		if($msql->next_record()){
			$brand=$msql->f('brand');
		}
		
		if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/html/".$id.".html")){
			if($ifpic == "1"){
				//$link=ROOTPATH."shop/html/".$id."-".$orid.".html";
				$link=ROOTPATH."rshop".$id."-".$orid;
				$gids = $id.$orid;
			}else{
				//$link=ROOTPATH."shop/html/".$id.".html";
				$link=ROOTPATH."rshop".$id;
				$gids = $id;
			}
		}else{
			if($ifpic == "1"){
				//$link=ROOTPATH."shop/html/?".$id."-".$orid.".html";
				$link=ROOTPATH."shop".$id."-".$orid;
				$gids = $id.$orid;
			}else{
				//$link=ROOTPATH."shop/html/?".$id.".html";
				$link=ROOTPATH."shop".$id;
				$gids = $id;
			}
		}


		$dtime=date("Y-m-d",$dtime);

		if($ifbold=="1"){$bold=" style='font-weight:bold' ";}else{$bold="";}
		if($ifred!="0"){$red=" style='color:".$ifred."' ";}else{$red="";}

		if($cutword!="0"){$title=csubstr($title,0,$cutword);}
		if($cutbody!="0"){$memo=csubstr($memo,0,$cutbody);}

		if($src==""){
			$src="shop/pics/nopic.gif";
			$srcs="shop/pics/nopic.gif";
		}
		$src=ROOTPATH.$src;
		$srcs=ROOTPATH.$srcs;
		
		if($saletag=="" || $saletag=="0"){
				$saletagstr=" ";		
		}else{
				$saletagstr="<img src='".ROOTPATH.$saletag."' />";
		}



		//�ѼƦC
		$propstr="";

		$i=1;
		$msql->query("select * from {P}_shop_prop where catid='$catid' order by xuhao");
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


		//�p�����
		include_once(ROOTPATH."shop/includes/shop.inc.php");
		$price=getMemberPrice($id,$price);

		
				$pricex=number_format($price0-$price,$getpoint);
				$price=number_format($price,$getpoint);
				$price0=number_format($price0,$getpoint);

		/*//���׼�
		$msql->query("select count(id) from {P}_comment where catid='11' and rid='$id'");
		if($msql->next_record()){
			$commentcount=$msql->f('count(id)');
		}

		//�����`�M
		$msql->query("select sum(pj1) from {P}_comment where catid='11' and rid='$id'");
		if($msql->next_record()){
			$totalpj=$msql->f('sum(pj1)');
		}

		//�p�⥭����
		if($commentcount>0){
			$centavg=ceil($totalpj/$commentcount);
		}else{
			$centavg=0;
		}

		$stars=shopstarnums($centavg,ROOTPATH);*/

		/*�W��ؤo-STR*/
		/*$sizes = "";
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
		}*/
		/*�W��ؤo-END*/
		
		/*�W���C��-STR*/

		/*unset($coloricon,$color,$iconsrc,$getcolor);
		$msql->query("select * from {P}_shop_conspec where gid='$id' order by id asc");
		while($msql->next_record()){
			$getcolor[]=$msql->f('colorname');
			$color[]=$msql->f('colorcode');
			$iconsrc[]="../../".$msql->f('iconsrc');
		}
		$result = array_unique($getcolor);
		if($getcolor){
			$result = array_unique($getcolor);
			$color = array_unique($color);
			$iconsrc = array_unique($iconsrc);
			foreach($result AS $key => $colorname){
				$coloricon .= "<div width='12' class='cicon'><img width='12' src='".$iconsrc[$key]."' style='width:12px;' /></div>";
			}
		}*/
		/*�W���C��-END*/
		
		/*����ĤG�i*/
			$n=2;
			$m0=$m2="";
			$msql->query( "select id,colorpic,subpicid,colorcode from {P}_shop_con where subid='{$orid}' order by id" );
			while ( $msql->next_record( ) )
			{
				$ssrc=$msql->f('colorpic');
				$srcb=dirname($ssrc)."/sp_".basename($ssrc);
				$sid = $sorid = $msql->f('id');
				$ssubpicid=$msql->f('subpicid');
				$scolorcode=$msql->f('colorcode');
				
				$scolorcode && $colorstr.=str_replace("{#colorcode#}",$scolorcode,$TempArr["text"]);
				
				if($ifpic == "1"){
					$sid = $ssubpicid;
				}
				if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/html/".$sid.".html")){
					if($ifpic == "1"){
						$slink=ROOTPATH."shop/html/".$sid."-".$sorid.".html";
						$gids = $sid.$sorid;
					}else{
						$slink=ROOTPATH."shop/html/".$sid.".html";
						$gids = $sid;
					}
					//$slink=ROOTPATH."shop/html/".$sid.".html";
				}else{
					if($ifpic == "1"){
						$slink=ROOTPATH."shop/html/?".$sid."-".$sorid.".html";
						$gids = $sid.$sorid;
					}else{
						$slink=ROOTPATH."shop/html/?".$sid.".html";
						$gids = $sid;
					}
					//$slink=ROOTPATH."shop/html/?".$sid.".html";
				}
				
				$ma = str_replace("{#src#}",ROOTPATH.$srcb,$TempArr["m0"]);
				$ma = str_replace("{#gid#}",$id,$ma);
				$ma = str_replace("{#gids#}",$gids,$ma);
				$ma = str_replace("{#n#}",$n,$ma);
				$ma = str_replace("{#link#}",$slink,$ma);
				
				
				$mb = str_replace("{#srcs#}",ROOTPATH.$srcb,$TempArr["m2"]);
				$mb = str_replace("{#gid#}",$id,$mb);
				$mb = str_replace("{#gids#}",$gids,$mb);
				$mb = str_replace("{#n#}",$n,$mb);
				$mb = str_replace("{#link#}",$slink,$mb);
				
				
				if($n%3 == 1 ){
					$mb = $TempArr["m3"].$mb;
				}
				
				$n++;
				
				$m0 .= $ma;
				$m2 .= $mb;
			}
			
				$showli = "";
			
			if($r>1 && $r%2==1){
				$showli = "li-3";
			}
			
			if($r>1 && $r%3==1){
				$showli = "li-4";
			}
			$title=stripslashes($title);
		$var=array (
			'gid' => $id, 
			'gids' => $gids, 
			'title' => $title, 
			'memo' => $memo,
			'dtime' => $dtime, 
			'stars' => $stars, 
			'centavg' => $centavg, 
			'commentcount' => $commentcount, 
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
			'srcb' => $srcb,
			'row' => $row,
			'coloricon' => $coloricon,
			'showprice0' => $price0>0? "":"none",
			'pricesymbol' => $getsymbol,
			'm0' => $m0,
			'm2' => $m2,
			'colorpic' => $colorpic,
			'colorpics' => $colorpics,
			//'clear' => $r>1 && $r%2==1? "style='clear:both;'":"",
			'showli' => $showli,
			'r' => $r,
			'colors' => $colorstr,
			'colornums' => $n-1,
			'strColors' => $strColors,
		);

		$str.=ShowTplTemp($TempArr[$querylist],$var);
		
		$r++;
	}
}
	if($r==1){
		$var = array('strNoresult'=>$strNoresult);
		$str.=ShowTplTemp($TempArr["con"],$var);
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
	'totalnums' => $totalnums,
	'n' => $Fcat==1? "0":"1",
	);

	$str=ShowTplTemp($str,$var);

	return $str;


}
?>