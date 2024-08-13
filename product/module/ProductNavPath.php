<?php

/*
	[元件名稱] 模組導航條
	[適用範圍] 產品模組
*/


function ProductNavPath(){

	global $msql,$strMemberProduct;


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
	if($GLOBALS["PRODUCTCONF"]["ChannelNameInNav"]=="1"){
		$var=array (
			'channel' => $GLOBALS["PRODUCTCONF"]["ChannelName"]
		);

		$str.=ShowTplTemp($TempArr["col"],$var);

		//頁頭標題
		$GLOBALS["pagetitle"]=$GLOBALS["PRODUCTCONF"]["ChannelName"];
	}
	

	//不同頁面名稱顯示不同的第三節導航
	if($pagename=="query"){
			if(strstr($_SERVER["QUERY_STRING"],".html")){
				$Arr=explode(".html",$_SERVER["QUERY_STRING"]);
				$nowcatid=$Arr[0];
			}elseif($_GET["catid"]>0){
				$nowcatid=$_GET["catid"];
			}else{
				$nowcatid=0;
			}
			
			$msql->query("select catpath from {P}_product_cat where catid='$nowcatid'");
			if($msql->next_record()){
				$catpath=$msql->f('catpath');
			}
				$array=explode(":",$catpath);
				$cpnums=sizeof($array)-1;
				for($i=0;$i<$cpnums;$i++){
					$arr=$array[$i]+0;
					$msql->query("select * from {P}_product_cat where catid='$arr'");
					while($msql->next_record()){
						$catid=$msql->f('catid');
						$cat=$msql->f('cat');
						$ifchannel=$msql->f('ifchannel');
							if($ifchannel=="1"){
								$url=ROOTPATH."product/class/".$catid."/";
							}else{
								if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."product/class/".$catid.".html")){
									$url=ROOTPATH."product/class/".$catid.".html";
								}else{
									$url=ROOTPATH."product/class/?".$catid.".html";
								}
							}
							
							
							$var=array (
							'nav' => $cat,
							'url' => $url
							);
							$str.=ShowTplTemp($TempArr["list"],$var);

							$GLOBALS["pagetitle"].="-".$cat;
						
					}
				
			  }
	}


	if($pagename=="detail"){
			
			//獲取網址攔參數
			if(strstr($_SERVER["QUERY_STRING"],".html")){
				$idArr=explode(".html",$_SERVER["QUERY_STRING"]);
				$id=$idArr[0];
			}elseif(isset($_GET["id"]) && $_GET["id"]!=""){
				$id=$_GET["id"];
			}
			$msql->query("select title from {P}_product_con where id='$id'");
			if($msql->next_record()){
				$title=$msql->f('title');
			}
			$var=array (
			'nav' => $title
			);
			$str.=ShowTplTemp($TempArr["con"],$var);
			$GLOBALS["pagetitle"]=$title;
	}

	if(substr($pagename,0,6)=="class_"){
			$var=array (
			'nav' => $GLOBALS["PSET"]["name"],
			);
			$str.=ShowTplTemp($TempArr["con"],$var);
			$GLOBALS["pagetitle"]=$GLOBALS["PSET"]["name"];
	}

	if(substr($pagename,0,5)=="proj_"){
			$var=array (
			'nav' => $GLOBALS["PSET"]["name"],
			);
			$str.=ShowTplTemp($TempArr["con"],$var);
			$GLOBALS["pagetitle"]=$GLOBALS["PSET"]["name"];
	}

	if($pagename=="memberproduct"){
		
		if($_GET["mid"]!=""){
			$msql->query("select pname from {P}_member where memberid='".$_GET["mid"]."'");
			if($msql->next_record()){
				$pname=$msql->f('pname');
			}
		}
		
		$var=array (
		'nav' => $pname.$strMemberProduct,
		);
		$str.=ShowTplTemp($TempArr["con"],$var);
		$GLOBALS["pagetitle"]=$pname.$strMemberProduct;
	
	}



	$str.=$TempArr["end"];
	return $str;
}

?>