<?php

/*
	[����W��] �U�@�Ť���
	[�A�νd��] �˯���(��ܥثe���O���U�@�����O,�A�X��ܦb�˯��W��)
*/



function ProductClassFc(){

		global $msql,$fsql;


		$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
		$shownums=$GLOBALS["PLUSVARS"]["shownums"];
		$showtj=$GLOBALS["PLUSVARS"]["showtj"];
		$target=$GLOBALS["PLUSVARS"]["target"];
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];


		//���}�d�Ѽ�
		if(strstr($_SERVER["QUERY_STRING"],".html")){
			$Arr=explode(".html",$_SERVER["QUERY_STRING"]);
			$nowcatid=$Arr[0];
		}elseif($_GET["catid"]>0){
			$nowcatid=$_GET["catid"];
		}else{
			$nowcatid=0;
		}

		
		$msql->query("select catid from {P}_product_cat where pid='$nowcatid'");
		if($msql->next_record()){
			$scl=" pid='$nowcatid' ";
		}else{
			$fsql->query("select pid from {P}_product_cat where catid='$nowcatid'");
			if($fsql->next_record()){
				$pid=$fsql->f("pid");
				$scl=" pid='$pid' ";
			}
		}

		
		if($showtj!="" && $showtj!="0"){
			$scl.=" and tj='1' ";
		}


		//�Ҫ�����
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		
		//�`���}�l
		$var=array('coltitle' => $coltitle);
		$str=ShowTplTemp($TempArr["start"],$var);


		$msql->query("select * from {P}_product_cat where $scl order by xuhao");
		
		while($msql->next_record()){
				$pid=$msql->f("pid");
				$catid=$msql->f("catid");
				$cat=$msql->f("cat");
				$catpath=$msql->f("catpath");
				$ifchannel=$msql->f('ifchannel');
				if($ifchannel=="1"){
					$link=ROOTPATH."product/class/".$catid."/";
				}else{
					if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."product/class/".$catid.".html")){
						$link=ROOTPATH."product/class/".$catid.".html";
					}else{
						$link=ROOTPATH."product/class/?".$catid.".html";
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