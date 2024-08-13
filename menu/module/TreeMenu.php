<?php

/*
	[元件名稱] 樹型導航選單
	[適用範圍] 所有頁面
*/


function TreeMenu(){

		global $msql;


		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$groupid=$GLOBALS["PLUSVARS"]["groupid"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];


		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		
		//循環開始
		$var=array(
			'coltitle' => $coltitle
		);

		$str=ShowTplTemp($TempArr["start"],$var);


		$msql->query("select * from {P}_menu where ifshow='1' and groupid='$groupid' order by xuhao ");
		while($msql->next_record()){
			$pid=$msql->f("pid");
			$id=$msql->f("id");
			$getlans = strTranslate("menu", $id);
			$menu=$getlans['menu']? $getlans['menu']:$msql->f('menu');
			//$menu=$msql->f("menu");
			list($menu,$subtitle)=explode("|",$menu);
			$linktype=$msql->f('linktype');
			$coltype=$msql->f('coltype');
			$folder=$msql->f('folder');
			$url=$msql->f('url');
			$target=$msql->f('target');


			switch($linktype){

				case "1" :
					$menuurl=ROOTPATH.$folder;
				break;
				case "2" :
					$menuurl=$url;
				break;
				default:
					if($coltype=="index"){
						//首頁特殊處理
						if($GLOBALS["CONF"]["CatchOpen"]=="1"){
							$menuurl=ROOTPATH;
						}else{
							$menuurl=ROOTPATH."index.php";
						}

					}else{
						//正常模組連結
						if($GLOBALS["CONF"]["CatchOpen"]=="1"){
							$menuurl=ROOTPATH.$coltype."/";
						}else{
							$menuurl=ROOTPATH.$coltype."/index.php";
						}
					}
				break;

			}

			$var=array (
			'menuurl' => $menuurl, 
			'id' => $id, 
			'pid' => $pid, 
			'menu' => $menu, 
			'target' => $target,
			'subtitle' => $subtitle,
			);
			
			$str.=ShowTplTemp($TempArr["list"],$var);

		}
		
        $str.=$TempArr["end"];
		return $str;
				
}



?>