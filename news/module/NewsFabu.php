<?php


function NewsFabu(){


		global $msql,$fsql,$tsql;
		
		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];

		$memberid=$_COOKIE["MEMBERID"];


		//個人分類
		
		$fsql -> query ("select * from {P}_news_pcat where memberid='$memberid' order by xuhao");
		while ($fsql -> next_record ()) {
			$pcatid = $fsql -> f ("catid");
			$pcat = $fsql -> f ("cat");
			$pcatlist.="<option value='".$pcatid."'>".$pcat."</option>";
		}


		//獲取公共分類授權
		$secureset=SecureClass("126");
		
		//公共分類
		$fsql -> query ("select * from {P}_news_cat order by catpath");
		while ($fsql -> next_record ()) {
			$lpid = $fsql -> f ("pid");
			$lcatid = $fsql -> f ("catid");
			$cat = $fsql -> f ("cat");
			$catpath = $fsql -> f ("catpath");
			$lcatpath = explode (":", $catpath);
		
			//當主分類有授權時讀取下級分類
			if(strstr($secureset,":".intval($lcatpath[0]).":")){
				
				for ($i = 0; $i < sizeof ($lcatpath)-2; $i ++) {
					$lcatpath[$i]=intval($lcatpath[$i]);
					$tsql->query("select catid,cat from {P}_news_cat where catid='$lcatpath[$i]'");
					if($tsql->next_record()){
						$ncatid=$tsql->f('cat');
						$ncat=$tsql->f('cat');
						$ppcat.=$ncat."/";
					}
				}
				
				if($pid==$lcatid){
					$catlist.="<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
				}else{
					$catlist.="<option value='".$lcatid."'>".$ppcat.$cat."</option>";
				}
				$ppcat="";

			}
			
			
		}




		//專題
		$fsql -> query ("select * from {P}_news_proj order by id desc");
		while ($fsql -> next_record ()) {
			$projid = $fsql -> f ("id");
			$project = $fsql -> f ("project");
			$NowPath=fmpath($projid);
			$musellist.="<option value=".$NowPath.">".$project."</option>";
			
		}


		//模版解釋
		$Temp=LoadTemp($tempname);



		$var=array (
		'pname' => $_COOKIE["MEMBERPNAME"],
		'pcatlist' => $pcatlist,
		'catlist' => $catlist,
		'musellist' => $musellist
		);
		$str.=ShowTplTemp($Temp,$var);
		
		return $str;

}


?>