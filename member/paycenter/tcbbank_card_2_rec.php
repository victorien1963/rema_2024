<?php
define( "ROOTPATH", "../../" );
include_once( ROOTPATH."includes/common.inc.php" );
include_once( ROOTPATH."member/includes/pay.inc.php" );

header("Content-Type:text/html; charset=utf-8");

//exit(print_r($_POST));

$pv = getpayval( "tcbbank_card_2" );
$MerchantNumber = $pv['pcenteruser'];

extract($_POST);
$errDesc = mb_convert_encoding( $errDesc, "UTF-8", "BIG5" );
$respMsg = mb_convert_encoding( $respMsg, "UTF-8", "BIG5" );

				$arr_1 = substr($lidm,2,1);
				if($arr_1 == "1"){ 
					$arr_1 = "SHOP";
					$arr_2 = substr($lidm,3);
					$arr_2 = substr($arr_2,-5) - 0;
				}elseif($arr_1 == "2"){
					$arr_1 = "MEMBER";
					$arr_2 = substr($lidm,3);
				}else{
					$arr_1 = "NONE";
				}
				
				
//紀錄交易資料
foreach($_POST AS $key=>$value){
	$data .= $data? "^[".$key."]-[".$value."]":"\r\n[".$key."]-[".$value."]";
}

filesave("PAYLOG.php",$data,"ab+");


//-- 交易成功
if( $status=="0" || $errcode=="00" || $respCode == "00"){
    		
      		if(!$MerchantNumber){
//$msql->query("DELETE FROM {P}_shop_order WHERE orderid='{$arr_2}'");
//$msql->query("DELETE FROM {P}_shop_orderitems WHERE orderid='{$arr_2}'");

$msql->query("UPDATE {P}_shop_order SET iftui='1' WHERE orderid='{$arr_2}'");

/*紀錄交易資訊*/
$oribz=$msql->getone( "SELECT bz FROM {P}_shop_order where orderid='{$arr_2}'" );
$data = $oribz[bz]."\r\n".$data;
$msql->query( "UPDATE {P}_shop_order SET bz='$data' where orderid='{$arr_2}'" );

$showjob_msg="請注意!訂單驗證碼錯誤!!\\r\\n本網站將會刪除這筆訂單，請您重新訂購，不便之處敬請見諒。";
echo "<html>
<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<script>alert(\"".$showjob_msg."\");window.location.href=\"".ROOTPATH."shop/class\";
</script></head></html>";
      		}else{
                $showjob_msg="交易成功!!(已檢驗)".$errcode;
				$back_coltype = $arr_1;
				$back_orderid = $arr_2;
				$back_fee = $authAmt;
				$back_payid = $pv['payid'];
				/*紀錄交易資訊*/
				$oribz=$msql->getone( "SELECT bz FROM {P}_shop_order where orderid='{$arr_2}'" );
				$data = $oribz[bz]."\r\n".$data;
				$msql->query( "UPDATE {P}_shop_order SET bz='$data' where orderid='{$arr_2}'" );
				/**/

				payback( $back_payid, $back_coltype, $back_orderid, $back_fee );                    
      		}

	}else{
//-- 交易失敗；
$showjob_msg = $errDesc;
$showjob_msg .="\\r\\n請注意!交易失敗!!\\r\\n請重新操作付款，不便之處敬請見諒。";
/*紀錄交易資訊*/
$oribz=$msql->getone( "SELECT bz FROM {P}_shop_order where orderid='{$arr_2}'" );
$data = $oribz[bz]."\r\n".$data;
$msql->query( "UPDATE {P}_shop_order SET bz='$data' where orderid='{$arr_2}'" );
/**/
echo "<html>
<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<script>alert(\"".$showjob_msg."\");window.location.href=\"".ROOTPATH."shop/orderpay.php?orderid=".$arr_2."\";
</script></head></html>";
    }
    
function filesave($filename,$data,$method='rb+',$iflock=1,$check=1,$chmod=1){
	$check && strpos($filename,'ROOTPATH')!==false && exit('Forbidden');
	touch($filename);
	$handle = fopen($filename,$method);
	$iflock && flock($handle,LOCK_EX);
	fwrite($handle,$data);
	$method=='rb+' && ftruncate($handle,strlen($data));
	fclose($handle);
	$chmod && @chmod($filename,0777);
}

function getParameter($pname){
          return isset($_POST[$pname])?$_POST[$pname]:"";
     }

?>