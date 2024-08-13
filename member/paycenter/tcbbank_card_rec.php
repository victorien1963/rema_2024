<?php
define( "ROOTPATH", "../../" );
include_once( ROOTPATH."includes/common.inc.php" );
include_once( ROOTPATH."member/includes/pay.inc.php" );

header("Content-Type:text/html; charset=utf-8");

//exit(print_r($_POST));

$pv = getpayval( "tcbbank_card" );
$MerchantNumber = $pv['pcenteruser'];

/*$authCode = getParameter("authCode");
$status = getParameter("status");
$merID = getParameter("merID");
$xid = getParameter("xid");
$lidm = getParameter("lidm");
$cardBrand = getParameter("cardBrand");
$pan = getParameter("pan");
$errcode = getParameter("errcode");
$currency = getParameter("currency");
$errDesc = mb_convert_encoding( getParameter("errDesc"), "UTF-8", "BIG5" );
$authRespTime = getParameter("authRespTime");
$amtExp = getParameter("amtExp");
$authAmt = getParameter("authAmt");*/

/*
[respCode]-[00]^[authRespTime]-[2017/03/28 19:03:22]^[acquirerName]-[???澈]^[MerchantId]-[006243118409001]^[TerminalID]-[90010001]^[qid]-[201703281900569218718]^[respMsg]-[success]^[lidm]-[381106032805813]^[MerchantName]-[Rema]^[authAmt]-[706]^[cardBrand]-[??臬]^[pan]-[524047******8607]
*/


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
if(!$data){
	$data = "\r\n無資料傳送".date("Y-m-d H:i:s")."\r\n";
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
				include( ROOTPATH."includes/ebmail.inc.php" );
				//$msql->query( "select card_mail,card_mail_admin,name,email,memberid,OrderNo,promolog from {P}_shop_order where orderid='{$arr_2}'" );
				$msql->query( "select * from {P}_shop_order where orderid='{$arr_2}'" );
				$msql->next_record();
				$mailbody_admin = $msql->f("card_mail_admin");				
				$mailbody = $msql->f("card_mail");
				$name = $msql->f("name");
				$email = $msql->f("email");
				$memberid = $msql->f("memberid");
				$OrderNo = $msql->f("OrderNo");
				
				$integrated = $msql->f("integrated");
				$contribute = $msql->f("contribute");
				$payid = $msql->f("payid");
				$dtime = time();
				$invoicenumber = $msql->f("invoicenumber");
				$invoicename = $msql->f("invoicename");
				$addr = $msql->f("s_addr");
				$mobi = $msql->f("mobi");
				
				
				$mailbody = str_replace("{#paytime#}",date("Y-m-d H:i:s",time()),$mailbody);
				$mailbody_admin = str_replace("{#paytime#}",date("Y-m-d H:i:s",time()),$mailbody_admin);
				$promolog = $msql->f("promolog");
				$newordertitle = "您的網站[".$GLOBALS['GLOBALS']['CONF'][SiteName]."]有一筆新訂單，請儘速處理!";
				$GLOBALS['GLOBALS']['CONF'][OrderEmail] = $GLOBALS['GLOBALS']['CONF'][OrderEmail] !=""? $GLOBALS['GLOBALS']['CONF'][OrderEmail]:$GLOBALS['GLOBALS']['CONF'][SiteEmail];
				ebmail( $GLOBALS['GLOBALS']['CONF'][OrderEmail], $GLOBALS['GLOBALS']['CONF'][SiteEmail], $newordertitle, $mailbody_admin );
				$subjtitle = "訂單成立通知- 訂單編號".$OrderNo;
				ebmail( $email, $GLOBALS['GLOBALS']['CONF'][SiteEmail], $subjtitle, $mailbody );
				
				
			/*寄發折價券 2013-12-14*/
				list($promotype, $promo_con, $promo_spec) = explode("|",$promolog);
				if($promotype == 3){
				$msql->query( "select code,mail_temp,memberid from {P}_shop_promocode where id='{$promo_con}' " );
				if ( $msql->next_record( ) ){
					$code = $msql->f( "code" );
					$mail_temp = $msql->f("mail_temp");
					$promo_member = $msql->f("memberid");
				
					$fromtitle = "Rema 銳馬-促銷活動電子折價券";
					$fromemail = $GLOBALS['GLOBALS']['CONF'][SiteEmail];
					$mail_temp = str_replace("\r\n","",$mail_temp);
					$mail_temp = str_replace("\r","",$mail_temp);
					$mail_temp = str_replace("\n","",$mail_temp);
					$message = $mail_temp;
		
					$promo_mailbody = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head>';
					$promo_mailbody .='<title>'.$fromtitle.'</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body bgcolor="#ffffff">';
					$promo_mailbody .='<table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="800">';
					$promo_mailbody .='<tr><td><img name="n1_r1_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_promo.png" width="800" height="208" alt=""></td></tr>';
					$promo_mailbody .='<tr><td width="100%" valign="top" style="padding:0px;">';
					$promo_mailbody .='<table width="800" border="0" align="left" cellpadding="0" cellspacing="0"><tr><td width="80" height="250">&nbsp;</td>';
					$promo_mailbody .='<td width="400" style="font-family:\'微軟正黑體\',Century Gothic;vertical-align: top;font-size:17px;">'.$message.'</td><td width="80">&nbsp;</td>';
					$promo_mailbody .='<td style="vertical-align: top;"><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_right_reg.png"></td></tr></table>';
					$promo_mailbody .='</td></tr><tr><td><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" width="800" height="240" alt=""></td></tr></table>';
					$promo_mailbody .='</body></html>';

							if(preg_match("/^[A-Za-z0-9\.|-|_]*[@]{1}[A-Za-z0-9\.|-|_]*[.]{1}[a-z]{2,5}$/", $email)){
								$allmail = $email;
							}
						/*回填限定會員ID*/
						$promo_member = $promo_member.",".$memberid;
						$msql->query("UPDATE {P}_shop_promocode SET memberid='{$promo_member}' WHERE id='{$promo_con}'");
						ebmail( $allmail, $fromemail, $fromtitle, $promo_mailbody );
					}
				}
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