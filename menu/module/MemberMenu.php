<?php

/*
	[元件名稱] 會員選單
	[適用範圍] 所有頁面
*/


function MemberMenu(){

		global $msql,$fsql;


		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$tempcolor=$GLOBALS["PLUSVARS"]["tempcolor"];

		if(!isLogin()){
			return "";
		}else{
			$membertypeid=$_COOKIE["MEMBERTYPEID"];
			$msql->query("select menugroupid from {P}_member_type where membertypeid='$membertypeid'");
			if($msql->next_record()){
				$groupid=$msql->f('menugroupid');
			}else{
				return "";
			}
		}
		


		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);
		
		$var=array (
		'tempcolor' => $tempcolor, 
		);
		
		$str.=ShowTplTemp($TempArr["start"],$var);


		$msql->query("select * from {P}_menu where ifshow='1' and groupid='$groupid' and pid='0' order by xuhao ");
		while($msql->next_record()){
			$topid=$msql->f("id");
			$getlans = strTranslate("menu", $topid);
			$topmenu=$getlans['menu']? $getlans['menu']:$msql->f('menu');
			list($topmenu)=explode("|",$topmenu);
				$toplinktype=$msql->f('linktype');
				$topcoltype=$msql->f('coltype');
				$topfolder=$msql->f('folder');
				$topurl=$msql->f('url');
				$toptarget=$msql->f('target');
				
				switch($toplinktype){
					case "1" :
						$topmenuurl=ROOTPATH.$topfolder;
					
						list($topcoltype) = explode("/",$topfolder);
						
						if($_SERVER['PHP_SELF'] == "/".$topfolder || $_SERVER['PHP_SELF'] == "/".$topfolder."/index.php"){$active = true; }else{$active=false;}
					break;
					case "2" :
						$topmenuurl=$topurl;
					break;
					default:
						if($topcoltype=="index"){
							if($GLOBALS["CONF"]["CatchOpen"]=="1"){
								$topmenuurl=ROOTPATH;
							}else{
								$topmenuurl=ROOTPATH."index.php";
							}
						}else{
							if($GLOBALS["CONF"]["CatchOpen"]=="1"){
								$topmenuurl=ROOTPATH.$topcoltype."/";
							}else{
								$topmenuurl=ROOTPATH.$topcoltype."/index.php";
							}
						}
					break;
				}


			$menustr="";
			$fsql->query("select * from {P}_menu where ifshow='1' and  pid='$topid' order by xuhao ");
			while($fsql->next_record()){
				$id=$fsql->f("id");
				list($menu)=explode("|",$fsql->f("menu"));
				$linktype=$fsql->f('linktype');
				$coltype=$fsql->f('coltype');
				$folder=$fsql->f('folder');
				$url=$fsql->f('url');
				$target=$fsql->f('target');

				switch($linktype){
					case "1" :
						$menuurl=ROOTPATH.$folder;
					break;
					case "2" :
						$menuurl=$url;
					break;
					default:
						if($coltype=="index"){
							if($GLOBALS["CONF"]["CatchOpen"]=="1"){
								$menuurl=ROOTPATH;
							}else{
								$menuurl=ROOTPATH."index.php";
							}
						}else{
							if($GLOBALS["CONF"]["CatchOpen"]=="1"){
								$menuurl=ROOTPATH.$coltype."/";
							}else{
								$menuurl=ROOTPATH.$coltype."/index.php";
							}
						}
					break;
				}

				$menustr.="<li><a href='".$menuurl."' target='".$target."'>".$menu."</a></li>";

			}

			$var=array (
			'menustr' => $menustr,
			'topmenu' => $topmenu,
			'topmenuurl' => $topmenuurl,
			'toptarget' => $toptarget,
			'icon-prev' => $active? "icon-prev":"",
			);
			
			if($topfolder == "logout.php" && $TempArr["m0"]){
				$str.=ShowTplTemp($TempArr["m0"],$var);
			}else{
				$str.=ShowTplTemp($TempArr["list"],$var);
			}

		}
		
        $str.=$TempArr["end"];
		return $str;
				
}



?>