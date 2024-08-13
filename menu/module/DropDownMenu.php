<?php

/*
	[����W��] �U�Ԧ��ɯ���
	[�A�νd��] ����

*/

function DropDownMenu(){
	
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


	$n=-1;
	$msql->querylan("select * from {P}_menu where ifshow='1' and groupid='$groupid' and pid='0' order by xuhao ");
	while($msql->next_record()){
			$id=$msql->f('id');
			$menu=$msql->f('menu');
			$linktype=$msql->f('linktype');
			$coltype=$msql->f('coltype');
			$folder=$msql->f('folder');
			$url=$msql->f('url');
			$target=$msql->f('target');
			
			switch($linktype){
				

				//1=�����s��
				case "1" :

					$menuurl=ROOTPATH.$folder;
					if($coltype != "page"){
						if(stripos($_SERVER['PHP_SELF'] ,$coltype)){$active = true; }else{$active=false;}
						list($REQUEST_URI) = explode("?&lan=",$_SERVER['REQUEST_URI']);
						if(substr($REQUEST_URI,1) == $folder && stripos($pagename,"detail") === false){$active = true; }else{$active=false;}
					}else{
						if($_SERVER['PHP_SELF'] == "/".$folder || $_SERVER['PHP_SELF'] == "/".$folder."/index.php"){$active = true; }else{$active=false;}
					}

					//�G�ſ��
					$sMenuStr=Menu001_s($id,$TempArr["menu"]);
					$n++;

				break;

				
				
				//2=�~���s��
				case "2" :

					$menuurl=$url;

					//�G�ſ��
					$sMenuStr=Menu001_s($id,$TempArr["menu"]);
					$n++;

				break;


				
				//�s����Ҳ�
				default:
					
					
					if($coltype=="index"){
						
						//�����S���B�z
						if($GLOBALS["CONF"]["CatchOpen"]=="1"){
							$menuurl=ROOTPATH;
							if($_SERVER['PHP_SELF'] == "/" || $_SERVER['PHP_SELF'] == "/index.php"){$active = true; }else{$active = false;}
						}else{
							$menuurl=ROOTPATH."index.php";
							if($_SERVER['PHP_SELF'] == "/index.php"){$active = true; }else{$active = false;}
						}

					}else{
						
						//���`�Ҳճs��
						if($GLOBALS["CONF"]["CatchOpen"]=="1"){
							$menuurl=ROOTPATH.$coltype."/";
							if(stripos($_SERVER['PHP_SELF'] ,$coltype)){$active = true; }else{$active = false;}
						}else{
							$menuurl=ROOTPATH.$coltype."/index.php";
							if(stripos($_SERVER['PHP_SELF'] ,$coltype)){$active = true; }else{$active = false;}
						}
					}
					
					

					//�G�ſ��
					$sMenuStr=Menu001_s($id,$TempArr["menu"]);
					$n++;

				break;

			
			}


			$var=array (
			'menu' => $menu, 
			'n' => $n, 
			'menuurl' => $menuurl, 
			'target' => $target,
			'smenustr' => $sMenuStr,
			'current' => $active==true? "current-menu-item":"",
			);
			
			if($sMenuStr){
				$str.=ShowTplTemp($TempArr["list"],$var);
			}else{
				$str.=ShowTplTemp($TempArr["menu"],$var);
			}

	
	}


		
	
	$str.=$TempArr["end"];
	return $str;


}


//�G�ſ��
function Menu001_s($pid,$sTemp){
	
	global $fsql;
	

	
	
	$s=0;
	$substr=array();
	$fsql->querylan("select * from {P}_menu where ifshow='1' and pid='$pid' order by xuhao ");
	while($fsql->next_record()){
			$id=$fsql->f('id');
			$menu=$fsql->f('menu');
			$linktype=$fsql->f('linktype');
			$coltype=$fsql->f('coltype');
			$folder=$fsql->f('folder');
			$url=$fsql->f('url');
			$target=$fsql->f('target');
			$m_id=$fsql->f('m_id');
			$m_class=$fsql->f('m_class');


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

			$var=array (
			'id' => $id, 
			'menu' => $menu, 
			'menuurl' => $menuurl, 
			'target' => $target
			);

			$substr[$m_id].=ShowTplTemp($sTemp,$var);
			$tt[$m_id] = $m_class;
			
			$s++;

	}
	
	foreach($substr AS $keyname=>$mval){
		$str.="<div class=\"sf-mega-section col-md-3 col-xs-3 col-sm-3\">
                    <h2><a href=\"".ROOTPATH.$tt[$keyname]."\">".$keyname."</a></h2>
                    <ul class=\"sub-menu-list-article\">\n";
        $str.= $mval;
		
		$str.="</ul></div>\n";
	}
	
	
	if($s>0){
		return $str;
	}

}


?>