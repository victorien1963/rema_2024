<?php

function MemberRegChk(){

	global $msql,$fsql;
	
				$tempname=$GLOBALS["PLUSVARS"]["tempname"];
				$Temp=LoadTemp($tempname);
				$TempArr=SplitTblTemp($Temp);
				
				//exit(var_dump($_POST));
				
				$gen = $_POST[sex] == 1 ? "男性":"女性";
				
				$getzoneid = $msql->getone("SELECT cat,pid FROM {P}_member_zone WHERE catid='$_POST[zoneid]'");
				$getProvince = $msql->getone("SELECT cat FROM {P}_member_zone WHERE catid='$getzoneid[pid]'");
				
				list($country, $countryid) = explode("_",$_POST[country]);
				
				$var=array (
					/*'membertypeid' => $_POST[membertypeid],
					'memberchk1' => $_POST[membertypeid]==1? "checked":"disabled",
					'memberchk2' => $_POST[membertypeid]==2? "checked":"",
					'in1' => $_POST[membertypeid]==1? "in active":"",
					'in2' => $_POST[membertypeid]==2? "in active":"",*/
					'membertypeid' => 1,
					'memberchk1' => "checked",
					'memberchk2' => "",
					'in1' => "in active",
					'in2' => "",
					'email' => $_POST[email],
					'password' => $_POST[password],
					'repass' => $_POST[repass],
					//'name' => $_POST[LastName].$_POST[FirstN],
					'name' => $_POST[name],
					'sex' => $_POST[sex],
					'gen' => $gen,
					'Year_ID' => $_POST[Year_ID],
					'Month_ID' => $_POST[Month_ID],
					'Day_ID' => $_POST[Day_ID],
					'birthday' => $_POST[Year_ID].$_POST[Month_ID].$_POST[Day_ID],
					'postcode' => $_POST[postcode],
					'addr' => $_POST[addr],
					'mov' => $_POST[mov],
					'tel' => $_POST[tel],
					'orderpaper' => $_POST[orderpaper],
					'orderchk' => $_POST[orderpaper]==1? "checked":"",
					'Province' => $getProvince[cat],
					'town' => $getzoneid[cat],
					'zoneid' => $_POST[zoneid],
					'passcode' => $_POST[passcode],
					'company' => $_POST[company],
					'country' => $country,
					'countryid' => $countryid,
				);
				$str=ShowTplTemp($Temp,$var);
				return $str;

}
?>