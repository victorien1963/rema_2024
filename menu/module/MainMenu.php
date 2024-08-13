<?php

/*
	[����W��] �@�žɯ���
	[�A�νd��] ����

*/

function MainMenu(){
	
	global $msql,$fsql;


	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$tempcolor=$GLOBALS["PLUSVARS"]["tempcolor"];

	

	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);

	$var=array (
		'tempcolor' => $tempcolor
	);

	$str=ShowTplTemp($TempArr["start"],$var);


	$msql->query("select * from {P}_menu where ifshow='1' and groupid='$groupid' and pid='0' order by xuhao ");
	while($msql->next_record()){
			$id=$msql->f('id');
			$getlans = strTranslate("menu", $id);
			$menu=$getlans['menu']? $getlans['menu']:$msql->f('menu');
			list($menu,$m_class,$m_id)=explode(",",$menu);
			$linktype=$msql->f('linktype');
			$coltype=$msql->f('coltype');
			$folder=$msql->f('folder');
			$url=$msql->f('url');
			$target=$msql->f('target');
			
			/*$m_id=$msql->f('m_id');
			$m_class=$msql->f('m_class');*/
			
			list($icon, $liclass)=explode("-",$m_class);
			
			switch($linktype){
				

				//1=�����s��
				case "1" :
					$menuurl=ROOTPATH.$folder;
				break;

				//2=�~���s��
				case "2" :
					$menuurl=$url;
				break;


				
				//�s����Ҳ�
				default:
					
					
					if($coltype=="index"){
						
						//�����S���B�z
						if($GLOBALS["CONF"]["CatchOpen"]=="1"){
							$menuurl=ROOTPATH;
						}else{
							$menuurl=ROOTPATH."index.php";
						}

					}else{
						
						//���`�Ҳճs��
						if($GLOBALS["CONF"]["CatchOpen"]=="1"){
							$menuurl=ROOTPATH.$coltype."/";
						}else{
							$menuurl=ROOTPATH.$coltype."/index.php";
						}
					}
					
					

				break;

			
			}
			
			if($m_id == "scart"){
				$CARTSTR = $_COOKIE["SHOPCART"];
				$array=explode('#',$CARTSTR);
				$tnums=sizeof($array)-1;
				$tjine=0;
				$tacc=0;
				
				for($t=0;$t<$tnums;$t++){
					$fff=explode('|',$array[$t]);
					$gid=$fff[0];
					$acc=$fff[1];
					$fz=$fff[2];

					$tjine=$tjine+$jine;
					$tacc=$tacc+$acc;
				}
			}


			$var=array (
			'menu' => $menu, 
			'menuurl' => $menuurl, 
			'target' => $target,
			'spanid' => $m_id,
			'class' => $m_class,
			'liclass' => $liclass,
			'tacc' => $tnums,
			);

			$str.=ShowTplTemp($TempArr["menu"],$var);

	
	}

	
	$str.=$TempArr["end"];
	return $str;


}





?>