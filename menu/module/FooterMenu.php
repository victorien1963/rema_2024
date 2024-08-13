<?php

/*
	[����W��] �����ɯ���
	[�A�νd��] ����

*/


function FooterMenu(){
	
	global $msql,$SiteUrl,$fsql;


	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$shownums=$GLOBALS["PLUSVARS"]["shownums"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$tempcolor=$GLOBALS["PLUSVARS"]["tempcolor"];
	

	$Temp=LoadTemp($tempname);

	$TempArr=SplitTblTemp($Temp);

	
	$var=array (
		'tempcolor' => $tempcolor
	);
	
	/*�h��y���ഫ $getlans['menu']? $getlans['menu']:*/

	$str = ShowTplTemp($TempArr["start"],$var);
	$n=1;
	$msql->querylan("select * from {P}_menu where ifshow='1' and groupid='$groupid' and pid=0 order by xuhao limit 0,$shownums");
	while($msql->next_record()){
		
		$pid=$msql->f('id');
		$title=$msql->f('menu');

		$var=array (
			'menu' => $title
		);
		$str.=ShowTplTemp($TempArr["m1"],$var);

		$fsql->query("select * from {P}_menu where ifshow='1' and pid='$pid' order by xuhao limit 0,$shownums");
		while($fsql->next_record()){
				$id=$fsql->f('id');
				$getlans = strTranslate("menu", $id);
				$menu=$getlans['menu']? $getlans['menu']:$fsql->f('menu');
				$linktype=$fsql->f('linktype');
				$coltype=$fsql->f('coltype');
				$folder=$fsql->f('folder');
				$url=$fsql->f('url');
				$target=$fsql->f('target');
				$id='';
				$menuurl = '';
				switch($linktype){
				

				//1=�����s��
				case "1" :
					$menuurl=ROOTPATH.$folder;
				break;

				
				//2=�~���s��
				case "2" :
					$menuurl=$url;
				break;
				
				case "3" :
					$id=$folder;
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
			$className = '';
			if($folder === 'member/index.php') {
				$className = 'member';
				if(!islogin()) {
					$menuurl = 'javascript:;';
				}
			}
			$var=array (
				'menu' => $menu, 
				'menuurl' => $menuurl,
				'target' => $target,
				'className' => $className
			);
			
			// if($n>1){
			// 	$str.=$TempArr["m0"];
			// }
			if($linktype == 3 && $id === 'lantype') {
				// advs/module/LinkPic.php
				$var['id'] = $id;
				$str.=ShowTplTemp($TempArr["m0"],$var);
			} else {
				$str.=ShowTplTemp($TempArr["menu"],$var);
			}
			
			$n++;
			
		}
		$str .= $TempArr["end"].$TempArr["start"];
	};
	

	
	$str.=$TempArr["end"];

	return $str;
		
	

}

?>