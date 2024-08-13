<?php

/*
	[元件名稱] 模組導航條
*/


function ShopNavPath(){

	global $msql,$fsql,$tsql,$strResult;


	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$pagename=$GLOBALS["PLUSVARS"]["pagename"];

	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);


	$var=array (
		'coltitle' => $coltitle,
		'sitename' => $GLOBALS["CONF"]["SiteName"]
	);

	$str=ShowTplTemp($TempArr["start"],$var);

	//顯示模組頻道名稱
	if($GLOBALS["SHOPCONF"]["ChannelNameInNav"]=="1"){
		$var=array (
			'channel' => $GLOBALS["SHOPCONF"]["ChannelName"]
		);

		$str.=ShowTplTemp($TempArr["col"],$var);

		//頁頭標題
		$GLOBALS["pagetitle"]=$GLOBALS["SHOPCONF"]["ChannelName"];
	}
	
	/*$key=str_replace("?","",$_GET["key"]);
	if($key != ""){
		$str = "<em style='font-weight:600;'>".$key."</em>　".$strResult."<script>$('.in-page-ad').hide();</script>";
	}*/
	

	//不同頁面名稱顯示不同的第三節導航
	if(substr($pagename,0,5)=="query"){
		$ism = substr($pagename,-1)=="m"? true:false;
			
			if(strstr($_SERVER["QUERY_STRING"],".html")){
				$Arr=explode(".html",$_SERVER["QUERY_STRING"]);
				$nowcatid=$Arr[0];
			}elseif($_GET["catid"]>0){
				$nowcatid=$_GET["catid"];
			}else{
				$nowcatid=0;
			}
			
			$msql->query("select catpath,pid from {P}_shop_cat where catid='$nowcatid'");
			if($msql->next_record()){
				$catpath = $msql->f('catpath');
				$nowpid = $msql->f('pid');
			}
			
				$array=explode(":",$catpath);
				$cpnums=sizeof($array)-1;
				for($i=0;$i<$cpnums;$i++){
					$arr=$array[$i]+0;
					$msql->query("select * from {P}_shop_cat where catid='$arr'");
					while($msql->next_record()){
						$catid=$msql->f('catid');
						$getlans = strTranslate("shop_cat", $catid);
						$cat=$getlans['cat']? $getlans['cat']:$msql->f('cat');
						//$cat=$msql->f('cat');
						$pid=$msql->f('pid');
						$ifchannel=$msql->f('ifchannel');
							if($ifchannel=="1" && $ism==true){
								$url=ROOTPATH."shop/class/".$catid."/";
							}else{
								if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/class/".$catid.".html")){
									//$url=ROOTPATH."shop/class/".$catid.".html";
									$url=ROOTPATH."rshopclass".$catid;
								}else{
									//$url=ROOTPATH."shop/class/?".$catid.".html";
									$url=ROOTPATH."shopclass".$catid;
								}
							}
							
							
							if($cpnums == "2" && $pid==0 && $ism==true ){
								$oriurl=ROOTPATH."shop/class/".$catid."/";
							}
								
							if(($cpnums == "3" && $pid>0 && $ism==true) || ($cpnums == "2" && $ism==true)){
								$var=array (
									'nav' => $cat,
									'url' => $oriurl? $oriurl:$url,
								);
								$str.= $str? ShowTplTemp($TempArr["con"],$var):ShowTplTemp($TempArr["list"],$var);
							}elseif($ism==false){
								$var=array (
									'nav' => $cat,
									'url' => $oriurl? $oriurl:$url,
								);
								$str.= $str!=""? ShowTplTemp($TempArr["con"],$var):ShowTplTemp($TempArr["list"],$var);
							}

							$GLOBALS["pagetitle"].="-".$cat;
						
					}
				
			  }
	}


	if($pagename=="detail"){
			$ism = substr($pagename,-1)=="m"? true:false;
			//獲取網址攔參數
			/*if(strstr($_SERVER["QUERY_STRING"],".html")){
				$idArr=explode(".html",$_SERVER["QUERY_STRING"]);
				$id=$idArr[0];
			}elseif(isset($_GET["id"]) && $_GET["id"]!=""){
				$id=$_GET["id"];
			}
			$msql->query("select title from {P}_shop_con where id='$id'");
			if($msql->next_record()){
				$title=$msql->f('title');
			}
			$var=array (
			'nav' => $title
			);
			$str.=ShowTplTemp($TempArr["con"],$var);
			$GLOBALS["pagetitle"]=$title;*/
			//獲取網址攔參數
			if(strstr($_SERVER["QUERY_STRING"],".html")){
				$idArr=explode(".html",$_SERVER["QUERY_STRING"]);
				list($id, $subpicid) = explode("-",$idArr[0]);
				$orid = $id;
				$id=$subpicid!=""? $subpicid:$id;
				//$id=$idArr[0];
			}elseif(isset($_GET["id"]) && $_GET["id"]!=""){
				$id=$_GET["id"];
			}
			
			
			$msql->query("select title,catid,subcatid,thirdcatid,fourcatid,subcatpath,thirdcatpath,fourcatpath from {P}_shop_con where id='$id'");
			if($msql->next_record()){
				$getlans = strTranslate("shop_con", $id, "title");
				$title=$getlans['title']? $getlans['title']:$msql->f('title');
				//$title=$msql->f('title');
				if($subpicid!=""){
					$gettitle = $fsql->getone("select title from {P}_shop_con where id='$orid'");
					$getlans = strTranslate("shop_con", $orid, "title");
					$title=$getlans['title']? $getlans['title']:$gettitle['title'];
					//$title=$gettitle['title'];
				}
				$title=stripslashes($title);
				$catid=$msql->f('catid');
				$subcatid=$msql->f('subcatid');
				$thirdcatid=$msql->f('thirdcatid');
				$fourcatid=$msql->f('fourcatid');
				$subcatpath=$msql->f('subcatpath');
				$thirdcatpath=$msql->f('thirdcatpath');
				$fourcatpath=$msql->f('fourcatpath');
				
				$Arr=explode(".html",$_SERVER['HTTP_REFERER']);
				$Arr=explode("/?",$Arr[0]);
				$oricatid=(INT)$Arr[1];
				if($oricatid == 0){
					$Arr=explode("/shopclass",$_SERVER['HTTP_REFERER']);
					$oricatid=(INT)$Arr[1];
				}
				
				$fmdsubpath = fmpath( $oricatid );
				if(stripos($subcatpath, $fmdsubpath) !== false){
					$catid = $subcatid;
				}elseif(stripos($thirdcatpath, $fmdsubpath) !== false){
					$catid = $thirdcatid;
				}elseif(stripos($fourcatpath, $fmdsubpath) !== false){
					$catid = $fourcatid;
				}
			}
			$msql->query("select catpath from {P}_shop_cat where catid='$catid'");
			if($msql->next_record()){
				$catpath=$msql->f('catpath');
			}
			$array=explode(":",$catpath);
				$cpnums=sizeof($array)-1;
				for($i=0;$i<$cpnums;$i++){
					$arr=$array[$i]+0;
					$msql->query("select * from {P}_shop_cat where catid='$arr'");
					while($msql->next_record()){
						$catid=$msql->f('catid');
						$getlans = strTranslate("shop_cat", $arr);
						$cat=$getlans['cat']? $getlans['cat']:$msql->f('cat');
						//$cat=$msql->f('cat');
						$ifchannel=$msql->f('ifchannel');
							if($ifchannel=="1" && $ism==true){
								$url=ROOTPATH."photo/class/".$catid."/";
							}else{
								if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/class/".$catid.".html")){
									//$url=ROOTPATH."shop/class/".$catid.".html";
									$url=ROOTPATH."rshopclass".$catid;
								}else{
									//$url=ROOTPATH."shop/class/?".$catid.".html";
									$url=ROOTPATH."shopclass".$catid;
								}
							}
							
							
							$var=array (
							'nav' => $cat,
							'url' => $url
							);
							$str.= $str!=""? ShowTplTemp($TempArr["con"],$var):ShowTplTemp($TempArr["list"],$var);
						
					}
				
			  }
			$var=array (
			'nav' => $title
			);
			$str.=ShowTplTemp($TempArr["m1"],$var);
			
			$GLOBALS["pagetitle"]=$title;
	}

	if($pagename=="brand" || $pagename=="brandquery"){
			
			$var=array (
			'nav' => "品牌查詢"
			);
			$str.=ShowTplTemp($TempArr["con"],$var);

			$GLOBALS["pagetitle"]="品牌查詢";
	}

	if($pagename=="cart"){
			
			$var=array (
			'nav' => "購物車"
			);
			$str.=ShowTplTemp($TempArr["con"],$var);

			$GLOBALS["pagetitle"]="購物車";
	}

	if($pagename=="startorder"){
			
			$var=array (
			'nav' => "商品訂購"
			);
			$str.=ShowTplTemp($TempArr["con"],$var);

			$GLOBALS["pagetitle"]="商品訂購";
	}
	if($pagename=="shoporderpay"){
			
			$var=array (
			'nav' => "訂單付款"
			);
			$str.=ShowTplTemp($TempArr["con"],$var);

			$GLOBALS["pagetitle"]="訂單付款";
	}
	if($pagename=="shoporderdetail"){
			
			$var=array (
			'nav' => "觀看訂單"
			);
			$str.=ShowTplTemp($TempArr["con"],$var);

			$GLOBALS["pagetitle"]="觀看訂單";
	}

	if(substr($pagename,0,6)=="class_"){
			$var=array (
			'nav' => $GLOBALS["PSET"]["name"],
			);
			$str.=ShowTplTemp($TempArr["con"],$var);
			$GLOBALS["pagetitle"]=$GLOBALS["PSET"]["name"];
	}

	if($pagename=="branddetail"){
			
			//獲取網址攔參數
			if(isset($_GET["brandid"]) && $_GET["brandid"]!=""){
				$brandid=$_GET["brandid"];
			}
			$msql->query("select brand from {P}_shop_brand where id='$brandid'");
			if($msql->next_record()){
				$brand=$msql->f('brand');
			}
			$var=array (
			'nav' => $brand
			);
			$str.=ShowTplTemp($TempArr["con"],$var);
			$GLOBALS["pagetitle"]=$brand;
	}


	$str.=$TempArr["end"];
	return $str;
}

?>