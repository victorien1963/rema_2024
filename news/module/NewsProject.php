<?php

/*
	[元件名稱] 文章專題名稱列表
	[適用範圍] 所有頁面
*/



function NewsProject(){

		global $msql,$fsql;



		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$cutword=$GLOBALS["PLUSVARS"]["cutword"];



		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		
		//循環開始
		$var=array(
			'coltitle' => $coltitle
		);

		$str=ShowTplTemp($TempArr["start"],$var);

			
		$msql->query("select * from {P}_news_proj order by id desc");
		
		while($msql->next_record()){
				$id=$msql->f("id");
				$project=$msql->f("project");
				$folder=$msql->f("folder");
			
				if($cutword!="0"){$project=csubstr($project,0,$cutword);}

				$link=ROOTPATH."news/project/".$folder."/";

				$var=array (
				'link' => $link, 
				'project' => $project, 
				'target' => $target
				);
				$str.=ShowTplTemp($TempArr["list"],$var);
		
		}
		
		
        $str.=$TempArr["end"];
       
		return $str;

		
}


?>