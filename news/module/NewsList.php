<?php

/*
	[元件名稱] 最新文章列表
	[適用範圍] 全站
*/

function NewsList(){

	global $fsql,$msql,$tsql;

		
		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$shownums=$GLOBALS["PLUSVARS"]["shownums"];
		$ord=$GLOBALS["PLUSVARS"]["ord"];
		$sc=$GLOBALS["PLUSVARS"]["sc"];
		$showtj=$GLOBALS["PLUSVARS"]["showtj"];
		$cutword=$GLOBALS["PLUSVARS"]["cutword"];
		$cutbody=$GLOBALS["PLUSVARS"]["cutbody"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$catid=$thisid=$GLOBALS["PLUSVARS"]["catid"];
		$projid=$GLOBALS["PLUSVARS"]["projid"];
		$tags=$GLOBALS["PLUSVARS"]["tags"];
		$pagename=$GLOBALS["PLUSVARS"]["pagename"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		
		$store = $_GET["store"];

		//網址攔參數

		if(stripos($pagename,"query") !== false && strstr($_SERVER["QUERY_STRING"],".html")){
			$Arr=explode(".html",$_SERVER["QUERY_STRING"]);
			$nowcatid=$Arr[0];
		}elseif($_GET["catid"]>0){
			$nowcatid=$_GET["catid"];
		}else{
			$nowcatid=5;
		}
		$thiscatid = $nowcatid;

		//預設條件	
		$scl=" iffb='1' and catid!='0' ";
		$scls=" iffb='1' and catid!='0' ";

		if($showtj!="" && $showtj!="0"){
			$scl.=" and tj='1' ";
			$scls.=" and tj='1' ";
		}


		//顯示分類規則:如果後台不指定分類,則顯示目前所在分類,否則不限分類
	
		if($catid!=0 && $catid!=""){
			$catid=fmpath($catid);
			if($nowcatid!=0 && $nowcatid!=""){
				$nowcatid=fmpath($nowcatid);
				$scl.=" and catpath regexp '".$nowcatid."' ";
				$scls.=" and catpath regexp '".$nowcatid."' ";
			}else{
				$scl.=" and catpath regexp '".$catid."' ";
				$scls.=" and catpath regexp '".$catid."' ";
			}
		}elseif($nowcatid!=0 && $nowcatid!=""){
			$catid=fmpath($nowcatid);
			$scl.=" and catpath regexp '$catid' ";
			$scls.=" and catpath regexp '$catid' ";
		}

		//符合專題
		if($projid!=0 && $projid!=""){
			$projid=fmpath($projid);
			$scl.=" and proj regexp '$projid' ";
			$scls.=" and proj regexp '$projid' ";
		}

		//判斷符合標籤
		if($tags!=""){
			$tags=$tags.",";
			$scl.=" and tags regexp '$tags' ";
			$scls.=" and tags regexp '$tags' ";
		}
		
		if($store){
			$scl = "id='".$store."'";
		}
		
		
		//獲取分類
		$getpid = $fsql->getone("SELECT pid FROM {P}_news_cat WHERE catid='$nowcatid'");
		$getcat = $fsql->getone("SELECT catid,cat FROM {P}_news_cat WHERE catid='$getpid[pid]'");
		
		$tsql->query( "select * from {P}_news_cat WHERE pid='2' AND hide='0'" );
		while ( $tsql->next_record( ) )
		{
			$storearea = $tsql->f( "cat" );
			$areaid = $tsql->f( "catid" );
			
				$allcatalog.= "<optgroup label='".$storearea."'>";
				$fsql->query( "select * from {P}_news_cat WHERE catpath regexp '$catid' AND pid!='0' AND pid='$areaid'  AND hide='0' order by xuhao asc,catpath asc" );
				//$allcatalog.= "<optgroup label='臺灣'>";
				//$fsql->query( "select * from {P}_news_cat WHERE catpath regexp '$catid' AND pid!='0' AND pid='3' AND hide='0' order by xuhao asc,catpath asc" );
				while ( $fsql->next_record( ) )
				{
						$lpid = $fsql->f( "pid" );
						$lcatid = $fsql->f( "catid" );
						$cat = $fsql->f( "cat" );
						$catpath = $fsql->f( "catpath" );
						$lcatpath = explode( ":", $catpath );
						
						for ( $i = 0;	$i < sizeof( $lcatpath ) - 2;	$i++	)
						{
								$msql->query( "select catid,cat from {P}_news_cat where catid='{$lcatpath[$i]}'" );
								if ( $msql->next_record( ) )
								{
										$ncatid = $msql->f( "cat" );
										$ncat = $msql->f( "cat" );
										$ppcat .= $ncat."/";
								}
						}
						if ( $nowcatid == $lcatid )
						{
							if($lpid == $thisid){
								$allcatalog.=$allcatalog? "</optgroup><optgroup label='".$cat."'>":"<optgroup label='".$cat."'>";
							}else{
								$allcatalog.="<option value='".$lcatid."' selected>".$cat."</option>";						
							}
						}
						else
						{
								
							if($lpid == $thisid){
								$allcatalog.=$allcatalog? "</optgroup><optgroup label='".$cat."'>":"<optgroup label='".$cat."'>";
							}else{
								$allcatalog.="<option value='".ROOTPATH."stores".$lcatid."'>".$cat."</option>";								
							}
						}
						$ppcat = "";
				}
						$allcatalog .= "</optgroup>";
		}
		
		//var_dump($allcatalog);
		
				/*$allcatalog.= "<optgroup label='香港'>";
				$fsql->query( "select * from {P}_news_cat WHERE catpath regexp '$catid' AND pid!='0' AND pid='4' order by xuhao asc,catpath asc" );
				while ( $fsql->next_record( ) )
				{
						$lpid = $fsql->f( "pid" );
						$lcatid = $fsql->f( "catid" );
						$cat = $fsql->f( "cat" );
						$catpath = $fsql->f( "catpath" );
						$lcatpath = explode( ":", $catpath );
						
						for ( $i = 0;	$i < sizeof( $lcatpath ) - 2;	$i++	)
						{
								$msql->query( "select catid,cat from {P}_news_cat where catid='{$lcatpath[$i]}'" );
								if ( $msql->next_record( ) )
								{
										$ncatid = $msql->f( "cat" );
										$ncat = $msql->f( "cat" );
										$ppcat .= $ncat."/";
								}
						}
						if ( $nowcatid == $lcatid )
						{
							if($lpid == $thisid){
								$allcatalog.=$allcatalog? "</optgroup><optgroup label='".$cat."'>":"<optgroup label='".$cat."'>";
							}else{
								$allcatalog.="<option value='".$lcatid."' selected>".$cat."</option>";						
							}
						}
						else
						{
								
							if($lpid == $thisid){
								$allcatalog.=$allcatalog? "</optgroup><optgroup label='".$cat."'>":"<optgroup label='".$cat."'>";
							}else{
								$allcatalog.="<option value='".ROOTPATH."news/class/?".$lcatid.".html'>".$cat."</option>";								
							}
						}
						$ppcat = "";
				}
						$allcatalog .= "</optgroup>";*/
						
		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		$var=array(
			'coltitle' => $coltitle,
			'morelink' => $morelink,
			'catname' => $getcat['cat'],
			'allcatalog' => $allcatalog,
		);
		$str=ShowTplTemp($TempArr["start"],$var);
		
		$picnum=1;
		$fsql->query("select * from {P}_news_con where $scl order by $ord $sc limit 0,$shownums");
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
			$cl=$fsql->f('cl');
			$fileurl=$fsql->f('fileurl');
			$downcount=$fsql->f('downcount');
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
			$mid=$fsql->f('memberid');
			$body = ROOTPATH.$fsql->f('body');
			
			if($picnum==1){
				$firid = $id;
			}

			if($mid>0){
				$memberurl=ROOTPATH."member/home.php?mid=".$mid;
			}else{
				$memberurl="#";
			}

			if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."news/html/".$id.".html")){
				$link=ROOTPATH."news/html/".$id.".html";
			}else{
				$link=ROOTPATH."news/html/?".$id.".html";
			}

	
			
			$dtime=date("m/d",$dtime);

			if($ifbold=="1"){$bold=" style='font-weight:bold' ";}else{$bold="";}

			if($ifred!="0"){$red=" style='color:".$ifred."' ";}else{$red="";}

			if($cutword!="0"){$title=csubstr($title,0,$cutword);}
			if($cutbody!="0"){$memo=csubstr($memo,0,$cutbody);}


			if($src==""){$src="news/pics/nopic.gif";}
			
			$src=ROOTPATH.$src;

			$downurl=ROOTPATH."news/download.php?id=".$id;


			//顯示所屬分類
			$msql->query("select cat from {P}_news_cat where catid='$nowcatid'");
			if($msql->next_record()){
				$cat=$msql->f('cat');
			}
			
			//參數列
			$i=1;
			$msql->query("select * from {P}_news_prop where catid='$nowcatid' order by xuhao");
			while($msql->next_record()){
				$pn="propname".$i;
				$$pn=$msql->f('propname');
			$i++;
			}
			
			$show1 = stripos($prop1,"單車") !== false? "":"style='display:none'";
			$show2 = stripos($prop1,"慢跑") !== false? "":"style='display:none'";
			$show3 = stripos($prop1,"壓縮") !== false? "":"style='display:none'";
			$show4 = stripos($prop1,"游泳") !== false? "":"style='display:none'";
			$show5 = stripos($prop1,"襪子") !== false? "":"style='display:none'";
			
			
			//分頁
			$piclist = str_replace("{#src#}",$body,$TempArr["m0"]);
			$msql->query("select body from {P}_news_pages where newsid='$id' order by id asc");
			while($msql->next_record()){
				$psrc = ROOTPATH.$msql->f('body');
				$piclist .= str_replace("{#src#}",$psrc,$TempArr["m0"]);
			}

			//模版標籤解釋

			$var=array (
			'id' => $id,
			'title' => $title, 
			'memo' => nl2br($memo),
			'dtime' => $dtime, 
			'red' => $red, 
			'bold' => $bold,
			'link' => $link,
			'target' => $target,
			'author' => $author, 
			'source' => $source,
			'cat' => $cat, 
			'src' => $src, 
			'cl' => $cl, 
			'memberurl' => $memberurl, 
			'picnum' => $picnum, 
			'downurl' => $downurl, 
			'fileurl' => $fileurl, 
			'downcount' => $downcount,
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
			'show1' => $show1,
			'show2' => $show2,
			'show3' => $show3,
			'show4' => $show4,
			'show5' => $show5,
			'piclist' => $piclist,
			);
			$str.=ShowTplTemp($TempArr["list"],$var);
			
			list($gea, $geb) = explode(",",$prop4);
			$gea = trim($gea);
			$geb = trim($geb);
			
			//$addrlist .= $addrlist? ",{'id': 'm".$id."', 'addr': ['".$gea."', '".$geb."'], 'text': '<strong>".$prop2."</strong>'}":"{'id': 'm".$id."', 'addr': ['".$gea."', '".$geb."'], 'text': '<strong>".$prop2."</strong>'}";

			if($picnum == 1){
				$firaddr = "'".$gea."', '".$geb."'";
			}

		$picnum++;

		}
		
		$var=array (
			'addrlist' => $addrlist,
			'firaddr' => $firaddr,
			);
		$str.=ShowTplTemp($TempArr["end"],$var);
		
		
		
		//擷取所有店鋪
		$fsql->query("select id,title from {P}_news_con where $scls order by $ord $sc");
		while($fsql->next_record()){
			$nnid = $fsql->f('id');
			if($nnid == $store || $nnid == $firid){
				$allstores .= "<option value='?store=".$nnid."' selected>".$fsql->f('title')."</option>";
			}else{
				$allstores .= "<option value='?store=".$nnid."'>".$fsql->f('title')."</option>";
			}
		}
		
		$str = str_replace("{#allstores#}",$allstores,$str);
		
		$str = str_replace("{#prop2#}",$prop2,$str);


		return $str;

}

?>