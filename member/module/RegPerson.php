<?php


function RegPerson(){

	global $msql,$fsql;

	$tempname="tpl_reg_person.htm";
	
	$memberid=$_COOKIE["MEMBERID"];

	
	//獲取會員資料
	$msql->query("select * from {P}_member where memberid='$memberid'");
	if($msql->next_record()){
		$pname=$msql->f('pname');
		$signature=$msql->f('signature');
		$nowface=$msql->f('nowface');
		$membertypeid=$msql->f('membertypeid');
	}

	if($nowface==""){$nowface="1";}

	$var=array (
		'membertypeid' => $membertypeid, 
		'pname' => $pname, 
		'signature' => $signature, 
		'nowface' => $nowface
	);


	//模版解釋
	$Temp=LoadTemp($tempname);
	$str=ShowTplTemp($Temp,$var);

	return $str;

}



?>