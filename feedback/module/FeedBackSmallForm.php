<?php

/*
	[元件名稱] 全站反映表單
	[適用範圍] 表單頁
*/

function FeedBackSmallForm(){

	global $fsql,$tsql;


	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];

	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);
	
	//讀取表單組名稱
	$fsql -> query ("select * from {P}_feedback_group where id='$groupid'");
	if($fsql -> next_record ()) {
		$groupname=$fsql->f('groupname');
		$intro=$fsql->f('intro');
	}

	$var=array (
	'coltitle' => $coltitle,
	'groupname' => $groupname,
	'intro' => $intro,
	);

	$str=ShowTplTemp($TempArr["start"],$var);


	//調用表單
	$fsql -> query ("select * from {P}_feedback where groupid='$groupid' and use_field = '1' order by xuhao");
	while ($fsql -> next_record ()) {
		$field_caption = $fsql -> f ('field_caption');
		$field_type = $fsql -> f ('field_type');
		$field_size = $fsql -> f ('field_size');
		$field_name = $fsql -> f ('field_name');
		$field_value = $fsql -> f ('field_value');
		$field_null = $fsql -> f ('field_null');
		$field_value_repeat = $fsql -> f ('value_repeat');
		$field_intro = $fsql -> f ('field_intro');

		$field_null = ($field_null == "1") ? $mustfill = "* " : $mustfill= "";
		
		$memberid=$_COOKIE["MEMBERID"];
		$tsql->query("select name,email from {P}_member where memberid='$memberid'");
		if($tsql->next_record()){
			$name=$tsql->f('name');
			$email=$tsql->f('email');
		}
		if($field_name == "name"){
			$field_value = $name;
		}
		if($field_name == "email"){
			$field_value = $email;
		}
	


		if($field_type == "5"){

			if($step=="send"){
				$nowvalue=$_POST[$field_name];
			}
		
			$fieldvalue =  explode (";",$field_value);
			$nums = count ($fieldvalue);


			for ($i = 0; $i < $nums; $i ++) {
				if ($fieldvalue[$i] == $nowvalue) {
					$checked_select = "selected";
				} else {
					$checked_select = "";
				}
				$list.= "<option value=" . $fieldvalue[$i]." ".$checked_select.">" . $fieldvalue[$i] . "</option>";
			}

			

			$var=array (
			'title' => $field_caption, 
			'size' => $field_size, 
			'fieldname' => $field_name, 
			'fieldvalue' => $field_value, 
			'mustfill' => $mustfill, 
			'list' => $list, 
			'intro' => $field_intro
			);

			$str.=ShowTplTemp($TempArr["list"],$var);

			$list="";

		}elseif($field_type== "2") {

			if($step=="send"){
				$field_value=$_POST[$field_name];
			}
			
			$var=array (
			'title' => $field_caption, 
			'size' => $field_size, 
			'fieldname' => $field_name, 
			'fieldvalue' => $field_value, 
			'mustfill' => $mustfill, 
			'intro' => $field_intro
			);

			$str.=ShowTplTemp($TempArr["textarea"],$var);
		
		}else{

			if($step=="send"){
				$field_value=$_POST[$field_name];
			}elseif($field_name=="title" && $_GET["rel"]!=""){
				$field_value=$_GET["rel"];
			}
			
			$var=array (
			'title' => $field_caption, 
			'size' => $field_size, 
			'fieldname' => $field_name, 
			'fieldvalue' => $field_value, 
			'mustfill' => $mustfill, 
			'intro' => $field_intro
			);

			$str.=ShowTplTemp($TempArr["input"],$var);


			
		}
			 
	}

	$var=array (
		'groupid' => $groupid
	);

	$str.=ShowTplTemp($TempArr["end"],$var);


	return $str;
	
}

?>