<?php

/*
	[����W��] �����D�D�Ϥ�+���D+�K�n
	[�A�νd��] ����
*/

function PagePicList(){

	global $fsql,$msql;

		//����]�m
		$shownums=$GLOBALS["PLUSVARS"]["shownums"];
		$cutword=$GLOBALS["PLUSVARS"]["cutword"];
		$cutbody=$GLOBALS["PLUSVARS"]["cutbody"];
		$picw=$GLOBALS["PLUSVARS"]["picw"];
		$pich=$GLOBALS["PLUSVARS"]["pich"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$groupid=$GLOBALS["PLUSVARS"]["groupid"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$fittype=$GLOBALS["PLUSVARS"]["fittype"];

		if($groupid!=0 && $groupid!=""){
			$fsql->query("select folder,groupname from {P}_page_group where id='$groupid' limit 0,1");
			if($fsql->next_record()){
				$folder=$fsql->f('folder');
				$getlans = strTranslate("page_group", $groupid);
				$groupname=$getlans['groupname']? $getlans['groupname']:$fsql->f('groupname');
				//$groupname=$fsql->f('groupname');
			}
		}else{
			$str="NO GROUPID";
			return $str;
		}
		
		if($_GET["getin"]){
			$getin = $_GET["getin"];
		}else{
			$getin = 1;
		}

		//���Y���D�w�q
		$GLOBALS["pagetitle"]=$groupname;
		$GLOBALS["channel"]=$groupname;
		



		//�Ҫ�����
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		$var=array(
			'groupname' => $groupname,
		);
		$str=ShowTplTemp($TempArr["start"],$var);
		
		$n = 1;
		$fsql->query("select * from {P}_page where groupid='$groupid' order by xuhao limit 0,$shownums");

		while($fsql->next_record()){
			
			$id=$fsql->f('id');
			$getlans = strTranslate("page", $id);
			$title=$getlans['title']? $getlans['title']:$fsql->f('title');
			$body=$getlans['body']? $getlans['body']:$fsql->f('body');
			//$title=$fsql->f('title');
			$src=$fsql->f('src');
			$memo=$fsql->f('memo');
			//$body=$fsql->f('body');
			$url=$fsql->f('url');
			$pagefolder=$fsql->f('pagefolder');

			//�s���A�p�G��������}�h�u������ 20090503
			if(strlen($url)>1){
				if(substr($url,0,7)=="http://"){
					$link=$url;
				}else{
					$link=ROOTPATH.$url;
				}
			}else{
				//�p�G���W�߭��A�u���W�߭�
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
			if($cutbody!="0"){$memo=csubstr($memo,0,$cutbody);}

			$memo=nl2br($memo);

			if($src==""){$src="page/pics/nopic.gif";}
			
			$src=ROOTPATH.$src;



			//�Ҫ����Ҹ���

			$var=array (
			'pageid' => $id,
			'title' => $title, 
			'memo' => $memo,
			'body' => $body,
			'link' => $link,
			'src' => $src,
			'picw' => $picw,
			'pich' => $pich,
			'target' => $target,
			'n' => $n,
			'in' => $n==$getin? "in":"",
			);
			$str.=ShowTplTemp($TempArr["list"],$var);
			$n++;
		}

		$var=array(
			'fittype' => $fittype
		);
		$str.=ShowTplTemp($TempArr["end"],$var);


		return $str;

}

?>