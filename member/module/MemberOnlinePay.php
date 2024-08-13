<?php

/*
	[元件名稱] 會員線上支付充值
*/

function MemberOnlinePay(){

	global $fsql,$msql;

		
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];

		$memberid=$_COOKIE["MEMBERID"];
		$now=time();
		$ip=$_SERVER["REMOTE_ADDR"];
		
		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		$str=$TempArr["start"];

		$act=$_GET["act"];
		$payid=$_GET["payid"];
		$payorderid=$_GET["payorderid"];
		$paytotal=$_GET["paytotal"];

		//線上支付成功返回提示
		if($act=="ok"){

			$msql->query("select * from {P}_member_onlinepay where id='$payorderid' and memberid='$memberid'");
			if($msql->next_record()){
				$paytype=$msql->f('paytype');
				$paytotal=$msql->f('paytotal');
			}

			$var=array(
			'payorderid'=>$payorderid,
			'paytype'=>$paytype,
			'paytotal'=>$paytotal
			);
			$str.=ShowTplTemp($TempArr["ok1"],$var);
			$str.=$TempArr["end"];
			return $str;

		}else if($payid!=""){

			if($paytotal=="" || $paytotal<0.01){
				$var=array('ntc'=>"充值金額錯誤");
				$str.=ShowTplTemp($TempArr["err1"],$var);
				$str.=$TempArr["end"];
				return $str;
			}

			$msql->query("select * from {P}_member_paycenter where id='$payid'");
			if($msql->next_record()){
				$pcenter=$msql->f('pcenter');
				$pcentertype=$msql->f('pcentertype');
				$pcenteruser=$msql->f('pcenteruser');
				$pcenterkey=$msql->f('pcenterkey');
				$hbtype=$msql->f('hbtype');
				$postfile=$msql->f('postfile');
				$recfile=$msql->f('recfile');
				$key1=$msql->f('key1');
				$key2=$msql->f('key2');
				$intro=$msql->f('intro');
				$intro=nl2br($intro);
			}

			if($pcentertype=="1"){

				$msql->query("insert into {P}_member_onlinepay set

					 `memberid`='$memberid',
					 `payid`='$payid',
					 `paytype`='$pcenter',
					 `paytotal`='$paytotal',
					 `ifpay`='0',
					 `addtime`='$now',
					 `backtime`='0',
					 `ip`='$ip'
				");

				$orderid=$msql->instid();

						
				//定義一些常用參數供接口使用
				global $SiteUrl;

				$myurl=$GLOBALS["CONF"][$SiteHttp];  //本網站地址
				$return_url=$SiteUrl."member/paycenter/".$recfile; //同步返回地址  
				$notify_url=""; //異步返回地址
				$v_orderid="MEMBER-".$orderid; //帶模組名的傳遞訂單號，返回時可識別
											   //在會員帳戶充值時，模組名是MEMBER
				$items="會員帳戶線上充值";

				//包含支付接口
				$post_api=ROOTPATH."member/paycenter/".$postfile;
				if(file_exists($post_api)){
					include($post_api);
					$var=array(
					'orderid'=>$orderid,
					'paytotal'=>$paytotal,
					'intro'=>$intro,
					'pcenter'=>$pcenter,
					'hiddenString'=>$hiddenString
					);
					$str.=ShowTplTemp($TempArr["m2"],$var);
					$str.=$TempArr["end"];
					return $str;
				}else{
					$var=array('ntc'=>"接口錯誤：支付接口文件(".$postfile.")不存在");
					$str.=ShowTplTemp($TempArr["err1"],$var);
					$str.=$TempArr["end"];
					return $str;
				}
			}


			
		

		}else{
			$paylist="";
			$msql->query("select * from {P}_member_paycenter where pcentertype='1'");
			while($msql->next_record()){
				$pcenter=$msql->f('pcenter');
				$payid=$msql->f('id');
				$paylist.="<option value='".$payid."'>".$pcenter."</option>";
			}
		
			$var=array(
			'paylist'=>$paylist
			);
			$str.=ShowTplTemp($TempArr["m1"],$var);
			$str.=$TempArr["end"];
			return $str;
		
		}


}

?>