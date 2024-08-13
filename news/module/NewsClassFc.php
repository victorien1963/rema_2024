<?php

/*
	[元件名稱] 文章下一級分類
	[適用範圍] 文章檢索頁(顯示目前類別的下一級類別,適合顯示在文章檢索上方)
*/



function NewsClassFc(){

		global $msql,$fsql;


		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$shownums=$GLOBALS["PLUSVARS"]["shownums"];
		$showtj=$GLOBALS["PLUSVARS"]["showtj"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];


		//網址攔參數
		if(strstr($_SERVER["QUERY_STRING"],".html")){
			$Arr=explode(".html",$_SERVER["QUERY_STRING"]);
			$nowcatid=$Arr[0];
		}elseif($_GET["catid"]>0){
			$nowcatid=$_GET["catid"];
		}else{
			$nowcatid=0;
		}



		$msql->query("select catid from {P}_news_cat where pid='$nowcatid'");
		if($msql->next_record()){
			$scl=" pid='$nowcatid' ";
		}else{
			$fsql->query("select pid from {P}_news_cat where catid='$nowcatid'");
			if($fsql->next_record()){
				$pid=$fsql->f("pid");
				$scl=" pid='$pid' ";
			}
		}

		
		if($showtj!="" && $showtj!="0"){
			$scl.=" and tj='1' ";
		}


		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		
		//循環開始
		$var=array('coltitle' => $coltitle);
		$str=ShowTplTemp($TempArr["start"],$var);


		$msql->query("select * from {P}_news_cat where $scl order by xuhao");
		
		while($msql->next_record()){
				$pid=$msql->f("pid");
				$catid=$msql->f("catid");
				$cat=$msql->f("cat");
				$catpath=$msql->f("catpath");
				$ifchannel=$msql->f('ifchannel');
				if($ifchannel=="1"){
					$link=ROOTPATH."news/class/".$catid."/";
				}else{
					if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."news/class/".$catid.".html")){
						$link=ROOTPATH."news/class/".$catid.".html";
					}else{
						$link=ROOTPATH."news/class/?".$catid.".html";
					}
				}

				$var=array (
				'link' => $link, 
				'cat' => $cat, 
				'target' => $target
				);
				$str.=ShowTplTemp($TempArr["list"],$var);


		}


		$str.=$TempArr["end"];


		return $str;
		
}


?>