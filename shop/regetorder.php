<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/shop.inc.php");

     function getParameter($pname){
          return isset($_POST[$pname])?$_POST[$pname]:"";
     }
	 $payid = getParameter('payid');	 
     $bankid = getParameter('bankid');
     
	 $tsql->query("select * from {P}_member_paycenter where id='$payid'");
	 if($tsql->next_record()){
			$pcenteruser=$tsql->f('pcenteruser');
			$pcenterkey=$tsql->f('pcenterkey');
			$key2=$tsql->f('key2');
				if( stripos($tsql->f('hbtype'),"atm") === TRUE ) {$paymenttype = "WEBATM";}
				elseif( stripos($tsql->f('hbtype'),"cs") === TRUE ) {$paymenttype = "CS";}
				elseif( stripos($tsql->f('hbtype'),"alipay") === TRUE ) {$paymenttype = "ALIPAY";}
				else{$paymenttype = "MMK"; $bankid="";}//超商繳款
	 }
     $code = $pcenterkey;//商家密碼
     $merchantnumber = $pcenteruser;
     $ordernumber = getParameter('ordernumber');
     $amount = floor(getParameter('amount'));
     $tohash = $merchantnumber.$code.$amount.$ordernumber;
     $hash = md5($tohash);
     $returnvalue = (getParameter('returnvalue')=="1");
     $orderid = getParameter('orderid');
     	 
     if($returnvalue){
          $adminurl = "https://maple2.neweb.com.tw:80/CashSystemFrontEnd/Query";
          $operation = "regetorder";
          $postdata = "merchantnumber=".$merchantnumber."&ordernumber=".$ordernumber."&amount=".$amount.
                      "&paymenttype=".$paymenttype."&bankid=".$bankid.
                      "&operation=".$operation."&returnvalue=".($returnvalue?"1":"0")."&hash=".$hash;

          $url = parse_url($adminurl);

          $postdatalen = strlen($postdata);
          $postdata = "POST ".$url['path']." HTTP/1.0\r\n".
                     "Content-Type: application/x-www-form-urlencoded\r\n".
                     "Host: ".$url['host'].":".$url['port']."\r\n".
                     "Content-Length: ".$postdatalen."\r\n".
                     "\r\n".
                     $postdata;
          
          $receivedata = "";
          
          //-- 若不用SSL(https)連接，則改為 $fp = fsockopen ($url['host'], $url['port'], $errno, $errstr, 90);
          $fp = fsockopen ("ssl://".$url['host'], $url['port'], $errno, $errstr, 90);
          
          //$fp = fsockopen ($hostip, $hostport, &$errno, &$errstr, 90);
          if(!$fp) { 
               echo "$errstr ($errno)<br>\n";
          }else{ 
               fputs ($fp, $postdata);
          
               do{ 
                    if(feof($fp)){
                         //echo "connect is break\n";
                      	break;
                    }
                    $tmpstr = fgets($fp,128);
                    $receivedata = $receivedata.$tmpstr;
               }while(true); //!($tmpstr=="0")
               fclose ($fp);
          }
          
          $receivedata = str_replace("\r","",trim($receivedata));
          $isbody = false;
          $httpcode = null;
          $httpmessage = null;
          $result = "";
          $array1 = split("\n",$receivedata);
          for($i=0;$i<count($array1);$i++){
               if($i==0){
                    $array2 = split(" ",$array1[$i]);
                    $httpcode = $array2[1];
                    $httpmessage = $array2[2];
               }else if(!$isbody){
                    if(strlen($array1[$i])==0) $isbody = true;
               }else{
                    $result = $result.$array1[$i];
               }
          }
          
          if($httpcode!="200"){
               if($httpcode=="404") echo "網址錯誤，無法找到網頁!";
               else if($httpcode=="500") echo "伺服器錯誤!";
               else echo $httpmessage;
               return;
          }

          echo "received==>[".$result."]";
          return;
     }
?>
<html>
<head>
<script>
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>繳費資訊重新產生頁</title>
</head>
<body>
<script language=JavaScript> 
setTimeout("form1.submit()",1);
</script> 

<form name="form1" method="POST" action="http://maple2.neweb.com.tw/CashSystemFrontEnd/Query">
<div style="display:none;">
<input type="hidden" name="merchantnumber" value="<?php echo $merchantnumber ?>">
<input type="hidden" name="ordernumber" value="<?php echo $ordernumber ?>">
<input type="hidden" name="amount" value="<?php echo $amount ?>">
<input type="hidden" name="paymenttype" value="<?php echo $paymenttype ?>">
<input type="hidden" name="bankid" value="<?php echo $bankid ?>">
<input type="hidden" name="operation" value="regetorder">
<input type="hidden" name="returnvalue" value="<?php echo ($returnvalue?"1":"0") ?>">
<input type="hidden" name="hash" value="<?php echo $hash ?>">
<input type="hidden" name="nexturl" value="http://<?php echo $_SERVER[HTTP_HOST]?>/shop/orderdetail.php?orderid=<?php echo $orderid?>">
<input type="submit" value=" 送 出 ">
</div>
</form>
</body>
</html>
