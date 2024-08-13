<?php

function MemberReg(){

	global $msql,$fsql,$strPleaseSelect,$lantype;
	
	$step=$_REQUEST["step"];

	switch($step){

		case "person":
			include("module/RegPerson.php");
			return ShowActive(RegPerson());
		break;

		case "detail":
			include("module/RegDetail.php");
			return ShowActive(RegDetail());
		break;

		case "contact":
			include("module/RegContact.php");
			return ShowActive(RegContact());
		break;

		default:
				$tempname=$GLOBALS["PLUSVARS"]["tempname"];
				$Temp=LoadTemp($tempname);
				$TempArr=SplitTblTemp($Temp);
				$msql->query("select value from {P}_member_config where variable='MustRequestCode'");
				if($msql->next_record()){
					if($msql->f("value") == '1'){
						$fsql->query("select value from {P}_member_config where variable='RequestCode'");
						if($fsql->next_record()){
							$reqcode = $fsql->f("value");
							$MustRequestCode = '
								<div class="row">
									<div class="left">邀 請 碼：</div> <div class="mustfill">*</div>
										<div class="con">
											<input id="reqcode" type="text" name="reqcode"  class="input"  value="" style="width:200px"  />
										</div>
								</div>';
						}
					}
				}
				
				$ZONE=ZoneList($zoneid);
				$ZoneList=$ZONE["str"];
				$Province=$ZONE["pr"];
				for($y=(date("Y")-13); $y>(date("Y")-85); $y--){
					$showyear .= "<option value='".$y."'> ".$y."</option>";
				}
				
				$selcountry = "<option value=''> ".$strPleaseSelect."</option>";
				$getlantype = "_".str_replace("zh_","",$lantype);
				$getlantype = str_replace("_tw","",$getlantype);
				$msql->query("select * from {P}".$getlantype."_member_zone where pid='0' and xuhao<>'0' order by xuhao");
				while ( $msql->next_record( ) )
				{
					$postcode = $msql->f("postcode");
					$postcode = str_replace("+886","",$postcode);
					$selcountry .= "<option value='".$msql->f("cat")."_".$msql->f("catid")."_".$postcode."'> ".$msql->f("cat")."</option>";
				}

				$var=array (
					'typelist' => MemberTypeList(),
					"MustRequestCode" => $MustRequestCode,
					'ZoneList' => $ZoneList, 
					'Province' => $Province, 
					'showyear' => $showyear,
					'selcountry' => $selcountry,
				);
				$str=ShowTplTemp($TempArr["start"],$var);
				return $str;
		break;

	}

}
?>