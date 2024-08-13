<?php

/*
	[元件名稱] 自訂內容模組-標題列表元件
	[適用範圍] 全站
*/

function PageTitleList(){

	global $fsql,$msql;

		//元件設置
		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$shownums=$GLOBALS["PLUSVARS"]["shownums"];
		$cutword=$GLOBALS["PLUSVARS"]["cutword"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$groupid=$GLOBALS["PLUSVARS"]["groupid"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];


		if($groupid!=0 && $groupid!=""){
			$fsql->query("select folder from {P}_page_group where id='$groupid'");
			if($fsql->next_record()){
				$folder=$fsql->f('folder');
			}
		}else{
			$str="NO GROUPID";
			return $str;
		}
		



		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		$var=array(
			'coltitle' => $coltitle,
		);
		$str=ShowTplTemp($TempArr["start"],$var);
		

		$fsql->query("select * from {P}_page where groupid='$groupid' order by xuhao limit 0,$shownums");

		while($fsql->next_record()){
			
			$id=$fsql->f('id');
			$title=$fsql->f('title');
			$url=$fsql->f('url');
			$pagefolder=$fsql->f('pagefolder');

			//連結，如果有跳轉網址則優先跳轉 20090503
			if(strlen($url)>1){
				if(substr($url,0,7)=="http://"){
					$link=$url;
				}else{
					$link=ROOTPATH.$url;
				}
			}else{
				
				
				//如果有獨立頁，優先獨立頁
				if($pagefolder!="" && file_exists(ROOTPATH."page/".$folder."/".$pagefolder.".php")){
					$link=ROOTPATH."page/".$folder."/".$pagefolder.".php";
				}else{
					if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."page/".$folder."/".$id.".html")){
						$link=ROOTPATH."page/".$folder."/".$id.".html";
					}else{
						$link=ROOTPATH."page/".$folder."/?".$id.".html";
					}
				}

			}


			if($cutword!="0"){$title=csubstr($title,0,$cutword);}



			//模版標籤解釋

			$var=array (
			'pageid' => $id,
			'title' => $title, 
			'link' => $link,
			'target' => $target
			);
			$str.=ShowTplTemp($TempArr["list"],$var);

		}

		$str.=$TempArr["end"];


		return $str;

}

?>