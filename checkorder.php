<?php
define("ROOTPATH", "");
include(ROOTPATH."includes/common.inc.php");
include(ROOTPATH."member/includes/pay.inc.php");

     function getParameter($pname){
          return isset($_POST[$pname])?$_POST[$pname]:"";
     }
     
     $paymenttype        = getParameter('paymenttype');
     
				if( $paymenttype == "WEBATM" ) {$paytype = "neweb_atm";}
				elseif( $paymenttype == "CS" ) {$paytype = "neweb_cs";}
				elseif( $paymenttype == "ALIPAY" ) {$paytype = "neweb_alipay";}
				else{$paytype = "neweb_mmk";}
				$pv = getpayval( $paytype );
				
	 $msql->query("select pcenterkey from {P}_member_paycenter where hbtype='{$paytype}'");
	 if($msql->next_record()){
			$pcenterkey=$msql->f('pcenterkey');
	 }
	 
     $code               = $pcenterkey;
     $merchantnumber     = getParameter('merchantnumber');
     $ordernumber        = getParameter('ordernumber');
     $amount             = getParameter('amount');
     $serialnumber       = getParameter('serialnumber');
     $writeoffnumber     = getParameter('writeoffnumber');
     $timepaid           = getParameter('timepaid');
     $tel                = getParameter('tel');
     $hash               = getParameter('hash');

     $verify = md5("merchantnumber=".$merchantnumber.
                   "&ordernumber=".$ordernumber.
                   "&serialnumber=".$serialnumber.
                   "&writeoffnumber=".$writeoffnumber.
                   "&timepaid=".$timepaid.
                   "&paymenttype=".$paymenttype.
                   "&amount=".$amount.
                   "&tel=".$tel.
                   $code);

     if(hash!=verify){
          //-- 驗證碼錯誤，資料可能遭到竄改，或是資料不是由ezPay簡單付發送
          /*print "驗證碼錯誤!".
                "\nhash=".hash.
                "\nmerchantnumber=".merchantnumber.
                "\nordernumber=".ordernumber.
                "\nserialnumber=".serialnumber.
                "\nwriteoffnumber=".writeoffnumber.
                "\ntimepaid=".timepaid.
                "\npaymenttype=".paymenttype.
                "\namount=".amount.
                "\ntel=".tel;*/
     }else{
          //-- 驗證正確，請更新資料庫訂單狀態
          /*print "驗證碼正確!".
                "\nmerchantnumber=".merchantnumber.
                "\nordernumber=".ordernumber.
                "\nserialnumber=".serialnumber.
                "\nwriteoffnumber=".writeoffnumber.
                "\ntimepaid=".timepaid.
                "\npaymenttype=".paymenttype.
                "\namount=".amoun.
                "\ntel=".tel);*/
                $arr_1 = substr($ordernumber,0,1);
				$arr_1 = substr($ordernumber,0,1);
				if($arr_1 == "1"){ 
					$arr_1 = "SHOP";
					$arr_2 = substr($ordernumber,1);
					$arr_2 = $arr_2 - 100000;
				}elseif($arr_1 == "2"){
					$arr_1 = "MEMBER";
					$arr_2 = substr($ordernumber,1);
				}else{
					$arr_1 = "NONE";
				}
				$back_coltype = $arr_1;
				$back_orderid = $arr_2;
				$back_fee = $amount;
				$back_payid = $pv['payid'];
				payback( $back_payid, $back_coltype, $back_orderid, $back_fee );
     }
?>