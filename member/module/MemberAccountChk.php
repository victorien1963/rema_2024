<?php


function MemberAccountChk(){

	global $msql,$fsql;
	
				$tempname=$GLOBALS["PLUSVARS"]["tempname"];
				$Temp=LoadTemp($tempname);
				$TempArr=SplitTblTemp($Temp);
				
				//exit(var_dump($_POST));
				
				$gen = $_POST[sex] == 1 ? "男性":"女性";
				$birthday=$_POST[birthday];
				$b_year = substr($birthday,0,4);
				$b_mon = substr($birthday,4,2);
				$b_day = substr($birthday,6,2);
				
				$var=array (
					'membertypeid' => $_POST[membertypeid],
					'email' => $_POST[email],
					'password' => $_POST[password],
					'newpassword' => $_POST[newpassword],
					'renewpass' => $_POST[renewpass],
					'name' => $_POST[name],
					'sex' => $_POST[sex],
					'gen' => $gen,
					'birthday' => $birthday,
					'b_year' => $b_year,
					'b_mon' => $b_mon,
					'b_day' => $b_day,
					'postcode' => $_POST[postcode],
					'addr' => $_POST[addr],
					'mov' => $_POST[mov],
					'tel' => $_POST[tel],
					'order_epaper' => $_POST[order_epaper],
				);
				$str=ShowTplTemp($Temp,$var);
				return $str;

}
?>