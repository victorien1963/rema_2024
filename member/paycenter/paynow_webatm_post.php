<?php
/*紅陽多利多-WEBATM專用*/
/*此程式帶入的變量是由shop/module/ShopOrderPay.php產生*/
/*部分所需參數必須新增在:ShopOrderPay.php*/

//更新
$link= $key1;//連接多利多刷卡的網址
$WebNo = $pcenteruser;//身份證/統編<身分證開頭英文需大寫>
$Code = $pcenterkey;//商家交易碼
list($coltpye) = explode("-",$v_orderid);
if($coltpye == "SHOP"){ $coltpye = "1"; }elseif($coltpye == "MEMBER"){ $coltpye = "2";}else{ $coltpye = "9"; }
//$OrderNo = $OrderNo? $OrderNo:$orderid;//商店訂單編號
$OrderNumber = $coltpye.$OrderNo;//加上付款類別號的訂單編號，SHOP開頭加1，MEMBER開頭加2：返回參數時必須判斷為哪種付款(購物或是儲值)
$TotalPrice = (INT)$paytotal;//付款金額
$PassCode = sha1($WebNo.$OrderNumber.$TotalPrice.$Code);//驗證碼:WebNo+OrderNo+TotalPrice+商家交易碼
$ReceiverID = $_COOKIE[ReceiverID];//取得訂購人身分證字號

////////////////////產生付款按鈕///////////////////////////////////////////////

$hiddenString ="<form method='post' id='post' action='".$link."'>";
$hiddenString .= "<input type='hidden' name='WebNo' Value='".$WebNo."'>";
$hiddenString .= "<input type='hidden' name='PassCode'Value='".$PassCode."'>";
$hiddenString .= "<input type='hidden' name='OrderNo' Value='".$OrderNumber."'>";
$hiddenString .= "<input type='hidden' name='ECPlatform' Value='".$GLOBALS['GLOBALS']['CONF'][SiteName]."'>";
$hiddenString .= "<input type='hidden' name='TotalPrice' Value='".$TotalPrice."'>";
$hiddenString .= "<input type='hidden' name='OrderInfo' Value='訂單編號:".$OrderNo."'>";//商家自訂交易訊息
$hiddenString .= "<input type='hidden' name='ReceiverTel' Value='".(INT)$payphone."'>";//訂購人手機
$hiddenString .= "<input type='hidden' name='ReceiverName' Value='".$payname."'>";//訂購人姓名
$hiddenString .= "<input type='hidden' name='ReceiverEmail'Value='".$email."'>";//訂購人Email
$hiddenString .= "<input type='hidden' name='ReceiverID' Value='".$ReceiverID."'>";//訂購人身分證ID
$hiddenString .= "<input type='hidden' name='Note1' Value=''>";//備註 1
$hiddenString .= "<input type='hidden' name='Note2' Value=''>";//備註 2
$hiddenString .= "<input type='hidden' name='PayType' Value='02'>";//付款方式 01：信用卡02：WebATM03：虛擬帳號
$hiddenString .= "<input type='hidden' name='GoodsoutLimit' Value='0'>";//出貨期限 無物流：０(出貨期限請填０)有物流：2~14 賣方預計出貨期限最長不可超過14天(交易時間後2天～交易時間後14天)
$hiddenString .= "<input type='hidden' name='Packagekind' Value='0000'>";//物流狀況 0000：無物流(數字0000) TCAT：有物流
$hiddenString .= "<input type='hidden' name='AtmRespost' Value='0'>";//需回傳虛擬帳號? 交易時帶入新參數.表賣家須接虛擬 帳號新回傳參數(不帶入視為不接收)
$hiddenString .= "<input type='submit' class='bigbutton' value='通過".$pcenter."付款'>";
$hiddenString .= "</form>";

?>