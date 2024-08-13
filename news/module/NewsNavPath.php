<?php

/*
	[元件名稱] 文章模組導航條
	[適用範圍] 文章模組
*/


function NewsNavPath(){

	global $msql,$strMemberNews;


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
	if($GLOBALS["NEWSCONF"]["ChannelNameInNav"]=="1"){
		$var=array (
			'channel' => $GLOBALS["NEWSCONF"]["ChannelName"]
		);

		$str.=ShowTplTemp($TempArr["col"],$var);

		//頁頭標題
		$GLOBALS["pagetitle"]=$GLOBALS["NEWSCONF"]["ChannelName"];
	}
	

	//不同頁面名稱顯示不同的第三節導航
	if(substr($pagename,0,5)=="query"){
			if(strstr($_SERVER["QUERY_STRING"],".html")){
				$Arr=explode(".html",$_SERVER["QUERY_STRING"]);
				$nowcatid=$Arr[0];
			}elseif($_GET["catid"]>0){
				$nowcatid=$_GET["catid"];
			}else{
				$nowcatid=0;
			}
			
			$msql->query("select catpath from {P}_news_cat where catid='$nowcatid'");
			if($msql->next_record()){
				$catpath=$msql->f('catpath');
			}
				$array=explode(":",$catpath);
				$cpnums=sizeof($array)-1;
				for($i=0;$i<$cpnums;$i++){
					$arr=$array[$i]+0;
					$msql->query("select * from {P}_news_cat where catid='$arr'");
					while($msql->next_record()){
						$catid=$msql->f('catid');
						$cat=$msql->f('cat');
						$ifchannel=$msql->f('ifchannel');
							if($ifchannel=="1"){
								$url=ROOTPATH."news/class/".$catid."/";
							}else{
								if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."news/class/".$catid.".html")){
									$url=ROOTPATH."news/class/".$catid.".html";
								}else{
									$url=ROOTPATH."news/class/?".$catid.".html";
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

	if(substr($pagename,0,6)=="detail"){
			
			//獲取網址攔參數
			if(strstr($_SERVER["QUERY_STRING"],".html")){
				$idArr=explode(".html",$_SERVER["QUERY_STRING"]);
				$id=$idArr[0];
			}elseif(isset($_GET["id"]) && $_GET["id"]!=""){
				$id=$_GET["id"];
			}
			$msql->query("select title,catid from {P}_news_con where id='$id'");
			if($msql->next_record()){
				$title=$msql->f('title');
				$catid=$msql->f('catid');
			}
			$msql->query("select catpath from {P}_news_cat where catid='$catid'");
			if($msql->next_record()){
				$catpath=$msql->f('catpath');
			}
				$array=explode(":",$catpath);
				$cpnums=sizeof($array)-1;
				for($i=0;$i<$cpnums;$i++){
					$arr=$array[$i]+0;
					$msql->query("select * from {P}_news_cat where catid='$arr'");
					while($msql->next_record()){
						$catid=$msql->f('catid');
						$cat=$msql->f('cat');
						$ifchannel=$msql->f('ifchannel');
							if($ifchannel=="1"){
								$url=ROOTPATH."news/class/".$catid."/";
							}else{
								if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."news/class/".$catid.".html")){
									$url=ROOTPATH."news/class/".$catid.".html";
								}else{
									$url=ROOTPATH."news/class/?".$catid.".html";
								}
							}
							
							
							$var=array (
							'nav' => $cat,
							'url' => $url
							);
							$str.=ShowTplTemp($TempArr["list"],$var);
						
					}
				
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

	if($pagename=="membernews"){
		if($_GET["mid"]!=""){
			$msql->query("select pname from {P}_member where memberid='".$_GET["mid"]."'");
			if($msql->next_record()){
				$pname=$msql->f('pname');
			}
		}
		
		$var=array (
		'nav' => $pname.$strMemberNews,
		);
		$str.=ShowTplTemp($TempArr["con"],$var);
		$GLOBALS["pagetitle"]=$pname.$strMemberNews;
	}



	$str.=$TempArr["end"];
	return $str;
}

?>