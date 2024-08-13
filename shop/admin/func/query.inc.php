<?php
//發票20180306
function INVO($orderid){
	global $msql,$fsql;
		$InvoiceDate = time();
		/*發票明細使用*/
		$fsql->query( "select * from {P}_shop_orderitems where orderid='$orderid' and itemtui='0' and iftui='0'" );
		while($fsql->next_record()){
			
			$orderbn = $fsql->f("bn");
			$goods = $fsql->f("goods");
			$colorname = $fsql->f("colorname");
			list($fz) = explode("^",$fsql->f("fz"));
			$fzs = $colorname.$fz;			
			$item_nums = $fsql->f("nums");
			$item_paytotal = (INT)$fsql->f("price");
			
				$productlist.= '<ProductItem>';
					 $productlist.= '<ProductionCode>'.$orderbn.'</ProductionCode>'; //商品編號
					 $productlist.= '<Description>'.$goods.'/'.$fzs.'</Description>'; //品名
					 $productlist.= '<Quantity>'.$item_nums.'</Quantity>';//數量
					 $productlist.= '<Unit>套</Unit>';//單位
					 $productlist.= '<UnitPrice>'.$item_paytotal.'</UnitPrice>';//單價
					 $productlist.= '<DType></DType>';//稅別 TaxType為9需要註記 TZ：零稅率 TN：免稅商品 空白：應稅
				 $productlist.= '</ProductItem>';
		}
		
		
		//提取訂單
		$msql->query( "select * from {P}_shop_order where orderid='{$orderid}'" );
		if ( $msql->next_record( ) )
		{
				$integrated = $msql->f("integrated");
				$contribute = $msql->f("contribute");
				$invoicename = $msql->f("invoicename");
				$invoicenumber = $msql->f("invoicenumber");
				$OrderNo = $msql->f("OrderNo");
				$dtime = $msql->f("dtime");
				$name = $msql->f("name");
				$mobi = $msql->f("mobi");
				$user = $msql->f("user");
				$email = $msql->f("email")? $msql->f("email"):$user;
				$memberid = $msql->f("memberid");
				$payid = $msql->f("payid");
				$addr = $msql->f("s_addr");
				$promoprice = $msql->f("promoprice");
				
				$yunfei = (INT)$msql->f("yunfei");
		}
		
/*電子發票 STR*/
	
	$DonateMark = "2"; //預設會員
	//是否有載具
	if($integrated != ""){
		list($seta, $setb, $setc) = explode("|",$integrated);
		$DonateMark = "0";
	}elseif($contribute !=""){
		//愛心碼
		list($cfa, $cfb) = explode("|",$contribute);
		$DonateMark = "1";
	}
	//付款方式
	if($payid == "1"){
		$payment = "3";
	}else{
		$payment = "5";
	}
	
	// 要訪問的 WebService 路徑
	$NusoapWSDL="https://www.ei.com.tw/InvoiceB2C/InvoiceAPI?wsdl";
	// 生成用戶端物件
	$client = new SoapClient($NusoapWSDL, array('encoding'=>'UTF-8'));
	
	$OrderId = $OrderNo;//自訂訂單編號(必填)
	$OrderDate = date("Y/m/d");//訂單日期 yyyy/MM/dd(必填)
	$BuyerIdentifier = $invoicenumber;//買家統編
	$BuyerName = $invoicename!=""? $invoicename:$name;//買家姓名(必填)
	$BuyerAddress = $DonateMark=="2"? trim($addr):"";//買家地址(收取紙本發票則為必填)
	$BuyerPersonInCharge = trim($name);//買家負責人姓名
	$BuyerTelephoneNumber = trim($mobi);//電話號碼
	$BuyerFacsimileNumber = "";//傳真號碼
	$BuyerEmailAddress = trim($email);//買家電子郵件(必填)
	$BuyerCustomerNumber = trim($memberid);//客戶編號
	$DonateMark = $DonateMark;//捐贈註記 0：載具 1：捐贈 2：紙本(必填)
	$InvoiceType = "07";//發票種類 07：一般稅額 08：特種稅額
	$CarrierType = $setc;//載具類別
	$CarrierId1 = $setb;//載具顯碼
	$CarrierId2 = $setb;//載具隱碼
	$NPOBAN = $cfb;//社福愛心碼
	$TaxType = "1";//稅別 1：應稅 2：零稅率（非經海關出口） 3：免稅 4：應稅（特種稅）5：零稅率（經海關出口）9：混和（收銀機類型使用）
	$TaxRate = "0.05";//預設 0.05 TaxType：4則必填
	$PayWay = $payment;//付款方式 1：現金 2：ATM 3：信用卡 4：超商代收 5：其他
	$Remark = "";//備註
	$MailSend = "0";//發送通知 預設0：加值中心發送 1：自行處理(不發送) 

  	$xml_str = '<?xml version="1.0" encoding="UTF-8" ?>';
	$xml_str .= '<Invoice XSDVersion = "2.8">';
	$xml_str .= '<OrderId>'.$OrderId.'</OrderId>'; 
	$xml_str .= '<OrderDate>'.$OrderDate.'</OrderDate>';
	$xml_str .= '<BuyerIdentifier>'.$BuyerIdentifier.'</BuyerIdentifier>';
	$xml_str .= '<BuyerName>'.$BuyerName.'</BuyerName>';
	$xml_str .= '<BuyerAddress>'.$BuyerAddress.'</BuyerAddress>'; 
	$xml_str .= '<BuyerPersonInCharge>'.$BuyerPersonInCharge.'</BuyerPersonInCharge>';
	$xml_str .= '<BuyerTelephoneNumber>'.$BuyerTelephoneNumber.'</BuyerTelephoneNumber>';
	$xml_str .= '<BuyerFacsimileNumber>'.$BuyerFacsimileNumber.'</BuyerFacsimileNumber>'; 
	$xml_str .= '<BuyerEmailAddress>'.$BuyerEmailAddress.'</BuyerEmailAddress>';
	$xml_str .= '<BuyerCustomerNumber>'.$BuyerCustomerNumber.'</BuyerCustomerNumber>';
	$xml_str .= '<DonateMark>'.$DonateMark.'</DonateMark>';
	$xml_str .= '<InvoiceType>'.$InvoiceType.'</InvoiceType>'; 
	$xml_str .= '<CarrierType>'.$CarrierType.'</CarrierType>'; 
	$xml_str .= '<CarrierId1>'.$CarrierId1.'</CarrierId1>'; 
	$xml_str .= '<CarrierId2>'.$CarrierId2.'</CarrierId2>'; 
	$xml_str .= '<NPOBAN>'.$NPOBAN.'</NPOBAN>'; 
	$xml_str .= '<TaxType>'.$TaxType.'</TaxType>'; 
	$xml_str .= '<TaxRate>'.$TaxRate.'</TaxRate>'; 
	$xml_str .= '<PayWay>'.$PayWay.'</PayWay>';
	$xml_str .= '<Remark>'.$Remark.'</Remark>';
	$xml_str .= '<MailSend>'.$MailSend.'</MailSend>';
	
	//明細
	$xml_str .= '<Details>';
	
	if($yunfei>0){
		 $productlist.= '<ProductItem>';
			 $productlist.= '<ProductionCode>Shipping Fee</ProductionCode>'; //商品編號
			 $productlist.= '<Description>運費</Description>'; //品名
			 $productlist.= '<Quantity>1</Quantity>';//數量
			 $productlist.= '<Unit>次</Unit>';//單位
			 $productlist.= '<UnitPrice>'.$yunfei.'</UnitPrice>';//單價
			 $productlist.= '<DType></DType>';//稅別 TaxType為9需要註記 TZ：零稅率 TN：免稅商品 空白：應稅
		 $productlist.= '</ProductItem>';
	}
	if($promoprice>0){
		 $productlist.= '<ProductItem>';
			 $productlist.= '<ProductionCode>Promotion</ProductionCode>'; //商品編號
			 $productlist.= '<Description>促銷折價</Description>'; //品名
			 $productlist.= '<Quantity>1</Quantity>';//數量
			 $productlist.= '<Unit>次</Unit>';//單位
			 $productlist.= '<UnitPrice>-'.$promoprice.'</UnitPrice>';//單價
			 $productlist.= '<DType></DType>';//稅別 TaxType為9需要註記 TZ：零稅率 TN：免稅商品 空白：應稅
		 $productlist.= '</ProductItem>';
	}
		 	 
	$xml_str .= $productlist;
		 
	$xml_str .=  '</Details>';
	$xml_str .=  '</Invoice>';
	// xml
	$tax_val="1";//$_GET['RBt_Tax'];   //含稅或未稅
	$rentid = "24311840";    //統一編號
		
	//過濾引號以免XML錯誤
	$xml_str = mb_ereg_replace('\"','"',$xml_str);
	$xml_str = filterXmlStr($xml_str);
	
	// 設置參數
	$param = array('invoicexml'=>$xml_str,'hastax'=>$tax_val,'rentid'=>$rentid);	

	//呼叫存放開立發票  成功-->取回發票號碼十碼   失敗-->取回錯誤代碼(錯誤代碼說明請參考API規格設計文件)
	/*$result = $client->__soapCall('CreateInvoiceV3', array($param));
		$errorcode = $result->return;*/

	$err = "OK";
	if(	$result = $client->__soapCall('CreateInvoiceV3', array($param))){
		$errorcode = $result->return;
		$strlen = mb_strlen($errorcode);
		//記載發票號碼 或 錯誤碼
		if($strlen == "10"){
			$msql->query("UPDATE {P}_shop_order SET CreateInvoice='{$errorcode}',ifreceipt='1',InvoiceDate='{$InvoiceDate}' WHERE orderid='{$orderid}'");
		}elseif($errorcode == "S7"){
			$NusoapWSDL="https://www.ei.com.tw/InvoiceB2C/InvoiceAPI?wsdl";
			// 生成用戶端物件
			libxml_disable_entity_loader(false);
			$client = new SoapClient($NusoapWSDL, array('encoding'=>'UTF-8'));
			$param = array('Orderid'=>$OrderNo,'rentid'=>$rentid);
			$result = $client->__soapCall('QueryInvoiceNumberByOrderid', array($param));
			$errorcode = $result->return;
			if($errorcode != "nodata"){
				$msql->query("UPDATE {P}_shop_order SET CreateInvoice='{$errorcode}',ifreceipt='1',InvoiceDate='{$InvoiceDate}' WHERE orderid='{$orderid}'");
			}else{
				$msql->query("UPDATE {P}_shop_order SET CreateInvoice='{$errorcode}' WHERE orderid='{$orderid}'");
				$err = $orderid;
			}
		}else{
			$msql->query("UPDATE {P}_shop_order SET CreateInvoice='{$errorcode}' WHERE orderid='{$orderid}'");
			$err = $orderid;
		}
	}
	/*電子發票 END*/
	return $err;
}


function filterXmlStr($str) 
{ 
  return preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/",'',$str);
}

//查詢訂單繳款狀況
function QueryOrders($payid,$ordernumber,$paymenttype,$getinfo="all"){
	 global $tsql;
	 $tsql->query("select * from {P}_member_paycenter where id='$payid'");
	 if($tsql->next_record()){
			$pcenteruser=$tsql->f('pcenteruser');
			$pcenterkey=$tsql->f('pcenterkey');
			$key2=$tsql->f('key2');
	 }
	 $adminurl = $key2;
	 $adminurl = "http://maple2.neweb.com.tw:80/CashSystemFrontEnd/Query";
     $code = $pcenterkey;
     $merchantnumber     = $pcenteruser;
     $ordernumber        = $ordernumber;
     $paymenttype        = $paymenttype;
     $operation          = "queryorders";
     
     $Year = date('Y');
     $month = date('m');
     $Day = date('d');
     $Hour = date('H');
     $Minute = date('i');
     $Second = date('s');

     $time = $Year.$month.$Day.$Hour.$Minute.$Second;

     $hash = md5($operation.$code.$time);

     $postdata = "merchantnumber=".$merchantnumber."&ordernumber=".$ordernumber."&writeoffnumber=".$writeoffnumber.
                 "&paymenttype=".$paymenttype."&timecreateds=".$timecreateds."&timecreatede=".$timecreatede.
                 "&timepaids=".$timepaids."&timepaide=".$timepaide."&status=".$status.
                 "&operation=".$operation."&time=".$time."&hash=".$hash;

     $url = parse_url($adminurl);

     $postdatalen = strlen($postdata);
     $postdata = "POST ".$url['path']." HTTP/1.0\r\n".
                "Content-Type: application/x-www-form-urlencoded\r\n".
                "Host: ".$url['host'].":".$url['port']."\r\n".
                "Content-Length: ".$postdatalen."\r\n".
                "\r\n".
                $postdata;

     $receivedata = "";
     $fp = fsockopen ($url['host'], $url['port'], $errno, $errstr, 90);
     
     if(!$fp) { 
          echo "$errstr ($errno)<br>\n";
     }else{ 
          fputs ($fp, $postdata);

          do{ 
               if(feof($fp)){
                 	break;
               }
               $tmpstr = fgets($fp,128);
               $receivedata = $receivedata.$tmpstr;
          }while(true);
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
          /*if($httpcode=="404") echo "網址錯誤，無法找到網頁!";
          else if($httpcode=="500") echo "伺服器錯誤!";
          else echo $httpmessage;*/
          return;
     }

     $rc = null;
     $rc2 = null;
     $orders = array();
     $array1 = split("&",$result);
     for($i=0,$ocount = -1;$i<count($array1);$i++){
          $array2 = split("=",$array1[$i]);
          if($i==0){
               $rc = $array2[1];
               if($rc!="0"){
                    $array2 = split("=",$array1[++$i]);
                    if($array2[0]=="rc2") $rc2 = $array2[1];
               }
          }else{
               if($array2[0]=="merchantnumber"){
                    $orders[++$ocount] = array();
                    $orders[$ocount][0] = $array2[1];
               }else if($array2[0]=="ordernumber"){
                    $orders[$ocount][1] = $array2[1];
               }else if($array2[0]=="serialnumber"){
                    $orders[$ocount][2] = $array2[1];
               }else if($array2[0]=="amount"){
                    $orders[$ocount][3] = $array2[1];
               }else if($array2[0]=="paymenttype"){
                    $orders[$ocount][4] = $array2[1];
               }else if($array2[0]=="writeoffnumber"){
                    $orders[$ocount][5] = $array2[1];
               }else if($array2[0]=="status"){
                    $orders[$ocount][6] = $array2[1];
               }else if($array2[0]=="timecreated"){
                    $orders[$ocount][7] = $array2[1];
               }else if($array2[0]=="timepaid"){
                    $orders[$ocount][8] = $array2[1];
               }else if($array2[0]=="paycount"){
                    $orders[$ocount][9] = $array2[1];
               }else if($array2[0]=="paidamount"){
                    $orders[$ocount][10] = $array2[1];
               }
          }
     }
     if($getinfo="all"){
     	return $orders[0];
     }else{
     	return $orders[0][$getinfo];
     }
}

//重新獲得繳款頁面，未使用，未完成
function RegetOrders($payid,$amount,$bankid="004",$ordernumber,$paymenttype){
	 global $tsql;
	 $tsql->query("select * from {P}_member_paycenter where id='$payid'");
	 if($tsql->next_record()){
			$pcenteruser=$tsql->f('pcenteruser');
			$pcenterkey=$tsql->f('pcenterkey');
			$key2=$tsql->f('key2');
	 }
	 $adminurl = $key2;
	 $adminurl = "http://maple2.neweb.com.tw:80/CashSystemFrontEnd/Query";
     $code = $pcenterkey;
     $amount			 = $amount;
     $bankid			 = $bankid;
     $merchantnumber     = $pcenteruser;
     $ordernumber        = $ordernumber;
     $paymenttype        = $paymenttype;
     $operation          = "regetorder";
     $returnvalue		 = "1";
     $tohash = $merchantnumber.$code.$amount.$ordernumber;
     $hash = md5($tohash);
     
	if($returnvalue){
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
     $fp = fsockopen ($url['host'], $url['port'], $errno, $errstr, 90);
     
     if(!$fp) { 
          echo "$errstr ($errno)<br>\n";
     }else{ 
          fputs ($fp, $postdata);

          do{ 
               if(feof($fp)){
                 	break;
               }
               $tmpstr = fgets($fp,128);
               $receivedata = $receivedata.$tmpstr;
          }while(true);
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
          /*if($httpcode=="404") echo "網址錯誤，無法找到網頁!";
          else if($httpcode=="500") echo "伺服器錯誤!";
          else echo $httpmessage;*/
          return;
     }
		echo "received==>[".$result."]";
          return;
		
    }
}

function __fgetcsv($handle, $big5 = null, $length = null, $d = ",", $e = '"') {
	$d = preg_quote($d);
	$e = preg_quote($e);
	$_line = "";
	$eof=false;
	while ($eof != true) {
		$_line .= (empty ($length) ? fgets($handle) : fgets($handle, $length));
		$itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
		if ($itemcnt % 2 == 0){
			$eof = true;
		}
	}
 
	$_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));
 
	$_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
	preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
	$_csv_data = $_csv_matches[1];
 
	for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
		$_csv_data[$_csv_i] = preg_replace("/^" . $e . "(.*)" . $e . "$/s", "$1", $_csv_data[$_csv_i]);
		$_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
		if($big5){
			$_csv_data[$_csv_i] = mb_convert_encoding($_csv_data[$_csv_i], "UTF-8", "BIG5");
		}
	}
 
	return empty ($_line) ? false : $_csv_data;
}
?>