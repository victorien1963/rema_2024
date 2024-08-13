<?php


function ProductModify(){


		global $msql,$fsql,$tsql;

		
		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];


		//模版解釋
		$Temp=LoadTemp($tempname);
		

		$id=$_REQUEST["id"];


		$memberid=$_COOKIE["MEMBERID"];
		$msql->query("select * from {P}_product_con where id='$id' and memberid='$memberid'");
		if($msql->next_record()){
			$catid=$msql->f('catid');
			$mypcatid=$msql->f('pcatid');
			$title=$msql->f('title');
			$src=$msql->f('src');
			$author=$msql->f('author');
			$source=$msql->f('source');
			$memo=$msql->f('memo');
			$body=$msql->f('body');
			$tags=$msql->f('tags');
			$proj=$msql->f('proj');

		}else{
			return "Invalied ID";
		}


		if($src!=""){
			$icon="image.gif";
			$src=ROOTPATH.$src;
		}else{
			$icon="noimage.gif";
		}

		$body=htmlspecialchars($body);
		$body=Path2Url($body);

		//個人分類
		$fsql -> query ("select * from {P}_product_pcat where memberid='$memberid' order by xuhao");
		while ($fsql -> next_record ()) {
			$pcatid = $fsql -> f ("catid");
			$pcat = $fsql -> f ("cat");
			if($mypcatid==$pcatid){
				$pcatlist.="<option value='".$pcatid."' selected>".$pcat."</option>";
			}else{
				$pcatlist.="<option value='".$pcatid."'>".$pcat."</option>";
			}
		}

		//獲取公共分類授權
		$secureset=SecureClass("186");

		//公共分類
		$fsql -> query ("select * from {P}_product_cat order by catpath");
		while ($fsql -> next_record ()) {
			$lpid = $fsql -> f ("pid");
			$lcatid = $fsql -> f ("catid");
			$cat = $fsql -> f ("cat");
			$catpath = $fsql -> f ("catpath");
			$lcatpath = explode (":", $catpath);

			//當主分類有授權時讀取下級分類
			if(strstr($secureset,":".intval($lcatpath[0]).":")){
			
				for ($i = 0; $i < sizeof ($lcatpath)-2; $i ++) {
					$tsql->query("select catid,cat from {P}_product_cat where catid='$lcatpath[$i]'");
					if($tsql->next_record()){
						$ncatid=$tsql->f('cat');
						$ncat=$tsql->f('cat');
						$ppcat.=$ncat."/";
					}
				}
				
				if($catid==$lcatid){
					$catlist.="<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
				}else{
					$catlist.="<option value='".$lcatid."'>".$ppcat.$cat."</option>";
				}
				$ppcat="";
			}
			
		}

		//標籤處理
		$tags=explode(",",$tags);


		//專題
		$fsql -> query ("select * from {P}_product_proj order by id desc");
		while ($fsql -> next_record ()) {
			$projid = $fsql -> f ("id");
			$project = $fsql -> f ("project");
			$NowPath=fmpath($projid);
			$musellist.="<option value=".$NowPath.">".$project."</option>";
			
		}

		//已選專題
		$arrs = explode (":",$proj);
		for ($k = 0; $k < sizeof ($arrs)-1; $k ++) {
			$projid=$arrs[$k]+0;
			$tsql->query("select project from {P}_product_proj where id='$projid'");
			if($tsql->next_record()){
				$project=$tsql->f('project');
			}
			$munowlist.="<option value=".$arrs[$k].">".$project."</option>";
		}


		//模版解釋
		
		$var=array (
		'catlist' => $catlist,
		'pcatlist' => $pcatlist,
		'author' => $author, 
		'source' => $source,
		'body' => $body,
		'memo' => $memo,
		'icon' => $icon, 
		'src' => $src,
		'title' => $title,
		'id' => $id,
		'musellist' => $musellist,
		'munowlist' => $munowlist,
		'tags0' => $tags[0],
		'tags1' => $tags[1],
		'tags2' => $tags[2],
		'tags3' => $tags[3],
		'tags4' => $tags[4]
		);
		
		$str=ShowTplTemp($Temp,$var);
		
		return $str;
		

}

?>