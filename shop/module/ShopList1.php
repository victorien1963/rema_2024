<?php

/*
	[����W��] �ۿ�ӫ~�C��
	[�A�νd��] ����
*/

function ShopList1(){
    
 

	global $fsql,$msql,$sybtype;

		
		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$shownums=$GLOBALS["PLUSVARS"]["shownums"];
		$ord=$GLOBALS["PLUSVARS"]["ord"];
		$sc=$GLOBALS["PLUSVARS"]["sc"];
		$showtj=$GLOBALS["PLUSVARS"]["showtj"];
		$cutword=$GLOBALS["PLUSVARS"]["cutword"];
		$cutbody=$GLOBALS["PLUSVARS"]["cutbody"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$catid=$GLOBALS["PLUSVARS"]["catid"];
		$tags=$GLOBALS["PLUSVARS"]["tags"];
		$pagename=$GLOBALS["PLUSVARS"]["pagename"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$picw=$GLOBALS["PLUSVARS"]["picw"];
		$pich=$GLOBALS["PLUSVARS"]["pich"];
		$fittype=$GLOBALS["PLUSVARS"]["fittype"];

		//�p�����]�t
		include_once(ROOTPATH."shop/includes/shop.inc.php");
		
		 	
		//2016����f���B�ײv
		if($sybtype){
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",$sybtype);
		}else{
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",getDefaultSyb());
		}

		//���}�d�Ѽ�
		if($pagename=="query" && strstr($_SERVER["QUERY_STRING"],".html")){
			$Arr=explode(".html",$_SERVER["QUERY_STRING"]);
			$nowcatid=$Arr[0];
		}elseif($_GET["catid"]>0){
			$nowcatid=$_GET["catid"];
		}elseif(strstr($_SERVER["QUERY_STRING"],".html")){
// 			$Arr=explode(".html",$_SERVER["QUERY_STRING"]);
// 			$nowcatid=$Arr[0];
		}else{
			$nowcatid=0;
		}


		//�w�]����		
		$scl=" iffb='1' and catid!='0' ";

		if($showtj!="" && $showtj!="0"){
			$scl.=" and tj='1' ";
		}


		//��ܤ����W�h:�p�G��x�����w����,�h��ܥثe�Ҧb����,�_�h��������

		if($catid!=0 && $catid!=""){
			$catid=fmpath($catid);
			$scl.=" and catpath regexp '$catid' ";
		}elseif($nowcatid!=0 && $nowcatid!=""){
			$catid=fmpath($nowcatid);
			$scl.=" and catpath regexp '$catid' ";
		}


		//�P�_�ŦX����
		if($tags!=""){
			$tags=$tags.",";
			$scl.=" and tags regexp '$tags' ";
		}
		
		$fsql->query("select cat from {P}_shop_cat where catid='$catid'");
		 	if($fsql->next_record()){
		 		$catname=$fsql->f("cat");
		 	}
		 	$catnameArr=explode(" ",$catname);

		//�Ҫ�����
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		$var=array(
		'catname' => $catname,
		'catname1' => $catnameArr[0],
		'catname2' => $catnameArr[1],
			'coltitle' => $coltitle,
			'morelink' => $morelink
		);
		$str=ShowTplTemp($TempArr["start"],$var);
		
		//**���oIP**
		if(getenv('HTTP_CLIENT_IP')){
         $onlineip = getenv('HTTP_CLIENT_IP');
        }
        elseif(getenv('HTTP_X_FORWARDED_FOR')){
         $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif(getenv('REMOTE_ADDR')){
         $onlineip = getenv('REMOTE_ADDR');
        }
        else{
         $onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
        }
        
        //�إ��[�ݰO��
        $Arr=explode(".html",$_SERVER["QUERY_STRING"]);
		$nowcatid=$Arr[0];
		$fsql->query("select * from {P}_shop_con_ip_log where `ip`='{$onlineip}' and `conid`='{$nowcatid}' ");

        if($fsql->num_rows()==0){
	       $fsql->query("INSERT INTO {P}_shop_con_ip_log SET ip='{$onlineip}',`conid`='{$nowcatid}',`look_count`=1 ");
	    }else{
	        $fsql->query("update {P}_shop_con_ip_log set look_count=look_count+1 where `ip`='{$onlineip}' and `conid`='{$nowcatid}'" );
	    }
	    
		$picnum=1;
        //$fsql->query("SELECT * FROM cpp_shop_con con LEFT JOIN cpp_shop_con_ip_log m ON con.id = m.conid where m.ip = '{$onlineip}' or catid!='0' GROUP BY con.id ORDER by look_count DESC limit 0,8");
        $fsql->query("SELECT * FROM cpp_shop_con con LEFT JOIN cpp_shop_con_ip_log m ON con.id = m.conid where m.ip = '{$onlineip}'  ORDER by look_count DESC limit 0,8");
 		//$fsql->query("select * from {P}_shop_con where $scl order by $ord $sc limit 0,$shownums");
        //select * from cpp_shop_con where iffb='1' and catid!='0' and tj='1' order by RAND() desc limit 0,8
        
        
		while($fsql->next_record()){
			
			$id=$orid=$fsql->f('id');
			$ifpic=$fsql->f('ifpic');
			$subpicid=$fsql->f('subpicid');
			if($ifpic == "1"){
				$id = $subpicid;
			}
			
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
			//$title=$fsql->f('title');
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

			
			$msql->query("select brand from {P}_shop_brand where id='$brandid' limit 0,1");
			if($msql->next_record()){
				$brand=$msql->f('brand');
			}

			if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/html/".$id.".html")){
				if($ifpic == "1"){
					//$link=ROOTPATH."shop/html/".$id."-".$orid.".html";
					$link=ROOTPATH."rshop".$id."-".$orid;
				}else{
					//$link=ROOTPATH."shop/html/".$id.".html";
					$link=ROOTPATH."rshop".$id;
				}
			}else{
				if($ifpic == "1"){
					//$link=ROOTPATH."shop/html/?".$id."-".$orid.".html";
					$link=ROOTPATH."shop".$id."-".$orid;
				}else{
					//$link=ROOTPATH."shop/html/?".$id.".html";
					$link=ROOTPATH."shop".$id;
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
			
			/*����ĤG�i*/
			$msql->query( "select src from {P}_shop_pages where gid='{$orid}' order by xuhao" );
			if ( $msql->next_record( ) )
			{
				$ssrc=$msql->f('src');
				$srcb=dirname($ssrc)."/sp_".basename($ssrc);
			}
			
			if($srcb==""){
				$srcb="shop/pics/nopic.gif";
			}
			$srcb=ROOTPATH.$srcb;
			
			//echo $saletag." , ";
			
			if($saletag=="" || $saletag=="0"){
				$saletagstr=" ";		
			}else{
				$saletagstr="<img src='".ROOTPATH.$saletag."' />";
			}
			


			//�ѼƦC
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
			

			//�p�����
			
			$price=getMemberPrice($id,$price);
		
		

				$pricex=number_format($price0-$price,$getpoint);
				$price=number_format($price,$getpoint);
				$price0=number_format($price0,$getpoint);


		/*�W��ؤo-STR*/
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
		
		/*�W��ؤo-END*/

			$title=stripslashes($title);
			//�Ҫ����Ҹ���
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
			//'srcs' => $srcs, 
			'srcs' => $colorpics,
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
			'pricesymbol' => $getsymbol,
			'colorpic' => $colorpic,
			'colorpics' => $colorpics,
			);
			$str.=ShowTplTemp($TempArr["list"],$var);


		$picnum++;

		}
		
		
		
		
        $num = 8-$fsql->num_rows();
        if($num !=0){
            $fsql->query("select * from {P}_shop_con where $scl order by $ord $sc limit 0,$num");
            while($fsql->next_record()){
			
			$id=$orid=$fsql->f('id');
			$ifpic=$fsql->f('ifpic');
			$subpicid=$fsql->f('subpicid');
			if($ifpic == "1"){
				$id = $subpicid;
			}
			
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
			//$title=$fsql->f('title');
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

			
			$msql->query("select brand from {P}_shop_brand where id='$brandid' limit 0,1");
			if($msql->next_record()){
				$brand=$msql->f('brand');
			}

			if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/html/".$id.".html")){
				if($ifpic == "1"){
					//$link=ROOTPATH."shop/html/".$id."-".$orid.".html";
					$link=ROOTPATH."rshop".$id."-".$orid;
				}else{
					//$link=ROOTPATH."shop/html/".$id.".html";
					$link=ROOTPATH."rshop".$id;
				}
			}else{
				if($ifpic == "1"){
					//$link=ROOTPATH."shop/html/?".$id."-".$orid.".html";
					$link=ROOTPATH."shop".$id."-".$orid;
				}else{
					//$link=ROOTPATH."shop/html/?".$id.".html";
					$link=ROOTPATH."shop".$id;
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
			
			/*����ĤG�i*/
			$msql->query( "select src from {P}_shop_pages where gid='{$orid}' order by xuhao" );
			if ( $msql->next_record( ) )
			{
				$ssrc=$msql->f('src');
				$srcb=dirname($ssrc)."/sp_".basename($ssrc);
			}
			
			if($srcb==""){
				$srcb="shop/pics/nopic.gif";
			}
			$srcb=ROOTPATH.$srcb;
			
			//echo $saletag." , ";
			
			if($saletag=="" || $saletag=="0"){
				$saletagstr=" ";		
			}else{
				$saletagstr="<img src='".ROOTPATH.$saletag."' />";
			}
			


			//�ѼƦC
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
			

			//�p�����
			
			$price=getMemberPrice($id,$price);
		
		

				$pricex=number_format($price0-$price,$getpoint);
				$price=number_format($price,$getpoint);
				$price0=number_format($price0,$getpoint);


		/*�W��ؤo-STR*/
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
		
		/*�W��ؤo-END*/

			$title=stripslashes($title);
			//�Ҫ����Ҹ���
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
			//'srcs' => $srcs, 
			'srcs' => $colorpics,
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
			'pricesymbol' => $getsymbol,
			'colorpic' => $colorpic,
			'colorpics' => $colorpics,
			);
			$str.=ShowTplTemp($TempArr["list"],$var);


		$picnum++;

		}
        }

		$var=array(
			'fittype' => $fittype
		);
		$str.=ShowTplTemp($TempArr["end"],$var);


		return $str;

}

?>