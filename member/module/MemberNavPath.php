<?php

/*
	[元件名稱] 會員模組導航條
	[適用範圍] 會員模組
*/


function MemberNavPath(){

	global $msql,$strHomePage;


	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	$pagename=$GLOBALS["PLUSVARS"]["pagename"];

	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);


	$var=array (
		'coltitle' => $coltitle,
		'sitename' => $GLOBALS["CONF"]["SiteName"]
	);

	$str=ShowTplTemp($TempArr["start"],$var);

	
	//模組頻道名稱
	if($GLOBALS["MEMBERCONF"]["ChannelNameInNav"]=="1"){
		$var=array ('channel' => $GLOBALS["MEMBERCONF"]["ChannelName"]);
	}

	switch($pagename){
		case "homepage":
			if($_GET["mid"]!=""){
				$msql->query("select pname from {P}_member where memberid='".$_GET["mid"]."'");
				if($msql->next_record()){
					$pname=$msql->f('pname');
				}
			}
			$var=array ('nav' => $pname.$strHomePage);
			$GLOBALS["pagetitle"]=$pname.$strHomePage;
			$str.=ShowTplTemp($TempArr["con"],$var);
		break;

		default:
			$str.=ShowTplTemp($TempArr["col"],$var);
			$var=array('nav' => $GLOBALS["PSET"]["name"]);
			$GLOBALS["pagetitle"].=$GLOBALS["PSET"]["name"];
			$str.=ShowTplTemp($TempArr["con"],$var);
		break;
	}
	
	
	
	
		
	


	$str.=$TempArr["end"];
	return $str;
}

?>