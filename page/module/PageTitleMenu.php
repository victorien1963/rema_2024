<?php

/*
	[元件名稱] 自訂內容模組-選單型標題元件
	[適用範圍] 全站
*/

function PageTitleMenu(){

	global $fsql,$msql;

		//元件設置
		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$shownums=$GLOBALS["PLUSVARS"]["shownums"];
		$cutword=$GLOBALS["PLUSVARS"]["cutword"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$groupid=$GLOBALS["PLUSVARS"]["groupid"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];


		if($groupid!=0 && $groupid!=""){
			$fsql->query("select folder,groupname from {P}_page_group where id='$groupid'");
			if($fsql->next_record()){
				$folder=$fsql->f('folder');
				$getlans = strTranslate("page_group", $groupid, "groupname");
				$groupname=$getlans['groupname']? $getlans['groupname']:$fsql->f('groupname');
				//$groupname=$fsql->f('groupname');
			}
		}else{
			$str="NO GROUPID";
			return $str;
		}
		
		$grouplink = ROOTPATH."page/".$folder."/";

		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		$var=array(
			'coltitle' => $coltitle,
			'groupname' => $groupname,
			'folder' => $folder,
			'grouplink' => $grouplink,
			'in' => stripos($_SERVER['PHP_SELF'],$folder)!==false? "in":"",
		);
		$str=ShowTplTemp($TempArr["start"],$var);
		
		$n = 1;
		$fsql->query("select * from {P}_page where groupid='$groupid' order by xuhao limit 0,$shownums");

		while($fsql->next_record()){
			
			$id=$fsql->f('id');
			$getlans = strTranslate("page", $id, "title");
			$title=$getlans['title']? $getlans['title']:$fsql->f('title');
			//$title=$fsql->f('title');
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
			'title' => $title, 
			'link' => $link,
			'target' => $target,
			'n' => $n,
			);
			$str.=ShowTplTemp($TempArr["list"],$var);
			$n++;
		}

		$str.=$TempArr["end"];


		return $str;

}

?>