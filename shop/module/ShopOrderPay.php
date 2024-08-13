<?php

/*
	[元件名稱] 訂單付款
*/

function ShopOrderPay(){

	global $fsql,$msql,$sybtype;

		
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$pagename=$GLOBALS["PLUSVARS"]["pagename"];
		
		//2016獲取貨幣、匯率
		if($sybtype){
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",$sybtype);
		}else{
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",getDefaultSyb());
		}

		
		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		$str=$TempArr["start"];

		$ifshowpay=0;

		$orderid=$_GET["orderid"]? $_GET["orderid"]:$_COOKIE["ORDERID"];
		setcookie("ORDERID",$orderid);
		$act=$_GET["act"];
		
		$ism = substr($pagename,-1)=="m"? true:false;
		


		$msql->query("select * from {P}_shop_order where orderid='$orderid'");
		if($msql->next_record()){
			$OrderNo=$msql->f('OrderNo');
			$memberid=$msql->f('memberid');
			$paytotal=$msql->f('paytotal');
			$payid=$msql->f('payid');
			$paytype=$msql->f('paytype');
			$ifpay=$msql->f('ifpay');
			$iftui=$msql->f('iftui');
			$items=$msql->f('items');
			$s_name=$msql->f('s_name');
			$payname=$msql->f('name');
			$payphone=$msql->f('mobi')?$msql->f('mobi'):$msql->f('tel');
			$email=$msql->f('email');
			$s_addr=$msql->f('s_addr');
			$s_country=$msql->f('country');
			$s_postcode=$msql->f('s_postcode');
			$pricesymbol=$msql->f('pricesymbol');
			$multiprice=$msql->f('multiprice');
			$multiyunfei=$msql->f('multiyunfei');
			$disaccount=$msql->f('disaccount');
			$source=$msql->f('buysource');
			$sourcepay=$msql->f('sourcepay');
			
			$multidisaccount=$getrate!="1"? round(($disaccount*$getrate),$getpoint):$disaccount;
			
			$multitotal = $multiprice + $multiyunfei;
			
			//臉書TRACK專用
			//擷取購買商品的產品編號
			$fsql->query("select * from {P}_shop_orderitems where orderid='$orderid'");
			while($fsql->next_record()){
				$bns .= $bns? ",'".$fsql->f('bn')."'":"'".$fsql->f('bn')."'";
				$cons .= $cons? ",{'id': '".$fsql->f('bn')."', 'quantity': ".$fsql->f('nums').", 'item_price': ".$fsql->f('price')."}":"{'id': '".$fsql->f('bn')."', 'quantity': ".$fsql->f('nums').", 'item_price': ".$fsql->f('price')."}";
				
				$itemid=$fsql->f('gid');
				$bn=$fsql->f('bn');
				$goods=$fsql->f('goods');
				$price=$fsql->f('price');
				$nums=$fsql->f('nums');
				$jine=$fsql->f('jine');
				
				$colorname = $fsql->f("colorname");
				
				$pricesymbol=$fsql->f('pricesymbol');
				$multiprice=$fsql->f('multiprice');
				$multijine=$fsql->f('multijine');
				
				$price=$multiprice? $multiprice:$price;
				$jine=$multijine? $multijine:$jine;
				
				list($buysize, $buyprice, $buyspecid) = explode("^",$fsql->f('fz'));
				
				$subpicid = $fsql->f('subpicid');
				
				if($subpicid){
					$getsubpic = $msql->getone("select src from {P}_shop_con where id='$subpicid'");
					$src=$getsubpic["src"];
				}else{
					$getsubpic = $msql->getone("select src from {P}_shop_con where id='$itemid'");
					$src=$getsubpic["src"];
				}
				$srcs=dirname($src)."/sp_".basename($src);
				$srcs=ROOTPATH.$srcs;
				
				$var=array (
					'jine' => number_format($jine, $getpoint), 
					'acc' => $nums,
					'goodsname' => $goods,
					'bn' => $bn,
					'buysize'=> $buysize,
					'srcs' => $srcs,
					'colorname' => $colorname,
					'pricesymbol' => $getsymbol,
					);
						
				$endstr.=ShowTplTemp($TempArr["menu"],$var);
				
			}
			
			$s_addr_a=mb_substr($s_addr,0,9);
			$s_addr_b=mb_substr($s_addr,9,9);
			$s_addr_c=mb_substr($s_addr,18);

			//非會員訂單查詢碼生成(防止直接網址攔輸入訂單號)
			$md=substr(md5($OrderNo.$s_name),0,5);

			//線上支付成功返回提示
			if($act=="ok" && $ifpay=="1" && ($memberid=="0" || ($memberid!="0" && isLogin() && $memberid==$_COOKIE["MEMBERID"]))){
				$var=array(
				'orderid'=>$orderid,
				'OrderNo'=>$OrderNo,
				'md'=>$md,
				'paytotal'=>$getpriceid==1? "":"(NT$ ".number_format($paytotal,0).")",
				'showpaytotal'=>number_format($multitotal,$getpoint),
				'paytype'=>$paytype,
						's_addr_a' => $s_addr_a,
						's_addr_b' => $s_addr_b,
						's_addr_c' => $s_addr_c,
						's_postcode' => $s_postcode,
						's_country' => $s_country,
						's_name' => $s_name,
						's_mobi' => $payphone,
						'pricesymbol'=>$pricesymbol,
						'multitotal' => $multitotal,
						'endstr'=>$endstr
				);
				setcookie("SHOPCART", "", time( ) - 3600, "/" );
				$str.=ShowTplTemp($TempArr["ok1"],$var);
				$str.=$TempArr["end"];
				
				$GLOBALS['fbtrack'] ="gtag('event', 'conversion', {
      'send_to': 'AW-711995140/Z9FpCMipzKkBEITewNMC',
      'transaction_id': ''
  });
fbq('track', 'Purchase',{
					content_type: 'product',
					value:'".$paytotal."', 
					currency:'".$getpricecode."',
					content_ids:[".$bns."],
					contents:[".$cons."]
				});";
				
				return $str;
			}
			
			//判斷會員本人訂單或非會員訂單
			if($memberid!="0"){
				if(islogin()){
					if($memberid==$_COOKIE["MEMBERID"]){
						$ifshowpay=1;
					}else{
						//訂單的會員和目前會員不符
						$ifshowpay=0;
						$var=array('ntc'=>"訂單不存在");
						$str.=ShowTplTemp($TempArr["err1"],$var);
						$str.=$TempArr["end"];
						return $str;
					}

				}else{
					//會員訂單在沒有登入時不能付款並跳轉到登入
					$ifshowpay=0;
					header("location:".ROOTPATH."member/login.php");
				}
			}else{
				if($payid=="0"){
					//非會員訂購禁止會員帳戶扣款
					$ifshowpay=0;
					$var=array('ntc'=>"目前訂單不可使用會員帳戶扣款");
					$str.=ShowTplTemp($TempArr["err1"],$var);
					$str.=$TempArr["end"];
					return $str;
				}else{
					$ifshowpay=1;
				}
			}

			
			//已經付款
			if($ifpay=="1"){
				$ifshowpay=0;
				$var=array('ntc'=>"目前訂單是已付款狀態，不能重複付款");
				$str.=ShowTplTemp($TempArr["err1"],$var);
				$str.=$TempArr["end"];
				return $str;
			}

			//已經退訂
			if($iftui=="1"){
				$ifshowpay=0;
				$var=array('ntc'=>"目前訂單已經退訂，不能付款");
				$str.=ShowTplTemp($TempArr["err1"],$var);
				$str.=$TempArr["end"];
				return $str;
			}

			

		}else{
			$var=array('ntc'=>"訂單不存在");
			$str.=ShowTplTemp($TempArr["err1"],$var);
			$str.=$TempArr["end"];
			return $str;
		}
		
		

		if($ifshowpay=="1"){

			//付款方式為會員帳戶扣款，已經登入且登入身份相符
			if($payid=="0" && islogin() && $memberid!="0" && $memberid==$_COOKIE["MEMBERID"]){

				$fsql->query("select account from {P}_member where memberid='$memberid'");
				if($fsql->next_record()){
					$account=$fsql->f('account');
				}
				
				if($source !="0"){
					if($account>=$paytotal){
						$payntc="<input type='button' id='memberpay' value='從會員帳戶扣款支付訂單' class='bigbutton' />";
					}else{
						$payntc="您的會員帳戶餘額不足，請儲值後再為訂單付款<br /></br /><a href='orderdetail.php?orderid=".$orderid."'>點這裡觀看訂單</a>";
					}
				}else{
					//設定已經付款
					//3: 現場付款，4：刷卡付款
					if($payid == "3" || $payid == "4"){
						$fsql->query("UPDATE {P}_shop_order SET ifpay='1' WHERE orderid='$orderid'");
						$fsql->query("UPDATE {P}_shop_orderitems SET ifpay='1' WHERE orderid='$orderid'");
					}
					$payntc="您已成功使用管理員身份建立來源訂單！<br /></br /><a class='btn btn-black btn-lg gostart' href='orderdetail.php?orderid=".$orderid."'>點這裡觀看訂單</a>";
				}
				$var=array(
				'orderid'=>$orderid,
				'OrderNo'=>$OrderNo,
				'md'=>$md,
				'account'=>$account,
				'payntc'=>$payntc,
				'paytotal'=>number_format($paytotal,0),
				);
				
				$str.=ShowTplTemp($TempArr["m0"],$var);
			}

			//付款方式不是會員帳戶扣款
			if($payid!="0"){
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
					
					if($_COOKIE["LANTYPE"] == "en"){
						if($pcenter=="線上刷卡"){
							$pcenter= "Credit Card";
						}else{
							$pcenter= "Cash on Delivery";
						}
					}
					
					//是否關閉線上刷卡，關閉則列入 IF 中
					if($source =="1-1" || $source =="1-2" || $source =="1-3" || $source =="1-4" || $source =="1-5"){
						$pcentertype="0";
					}

					//線下支付
					if($pcentertype=="0" && $source !=="0" && $source !==""){
						
						if($payid == "3" || $payid == "4"){
							$fsql->query("UPDATE {P}_shop_order SET ifpay='1' WHERE orderid='$orderid'");
							$fsql->query("UPDATE {P}_shop_orderitems SET ifpay='1' WHERE orderid='$orderid'");
						}
						
						
						switch ( $source )
						{
						case "0" :
								$sourcestr = "官網訂單";
								break;
						case "1-1" :
								$sourcestr = "板橋店";
								break;
						case "1-2" :
								$sourcestr = "新莊店";
								break;
						case "1-3" :
								$sourcestr = "內湖店";
								break;
						case "1-4" :
								$sourcestr = "三重店";
								break;
						case "1-5" :
								$sourcestr = "南屯店";
								break;
						case "2-1" :
								$sourcestr = "蝦皮";
								break;
						case "2-2" :
								$sourcestr = "MOMO";
								break;
						default :
								$sourcestr = "官網訂單";
						}
						$payntc="您已成功使用管理員身份建立來源訂單！<br /></br /><a class='btn btn-black btn-lg gostart' href='orderdetail.php?orderid=".$orderid."'>點這裡觀看訂單</a>";
						
						$var=array(
							'orderid'=>$orderid,
							'OrderNo'=>$OrderNo,
							'md'=>$md,
							'payntc'=>$payntc,
							'paytotal'=>$getpriceid==1? "":"(NT$ ".number_format($paytotal,0).")",
							'pricesymbol'=>$pricesymbol,
							'showpaytotal'=>number_format($multitotal,$getpoint),
							'sourcestr' =>$sourcestr
						);
						
						setcookie("SHOPCART", "", time( ) - 3600, "/" );
						$str.=ShowTplTemp($TempArr["m3"],$var);
						
					}elseif($pcentertype=="0"){
						$var=array(
						'orderid'=>$orderid,
						'OrderNo'=>$OrderNo,
						'md'=>$md,
						'paytotal'=>$getpriceid==1? "":"(NT$ ".number_format($paytotal,0).")",
						'intro'=>$intro,
						'pcenter'=>$pcenter,
						's_addr_a' => $s_addr_a,
						's_addr_b' => $s_addr_b,
						's_addr_c' => $s_addr_c,
						's_postcode' => $s_postcode,
						's_country' => $s_country,
						's_name' => $s_name,
						's_mobi' => $payphone,
						'pricesymbol'=>$pricesymbol,
						'showpaytotal'=>number_format($multitotal,$getpoint),
						'endstr'=>$endstr
						);
						setcookie("SHOPCART", "", time( ) - 3600, "/" );
						$str.=ShowTplTemp($TempArr["m1"],$var);
						
						$GLOBALS['fbtrack'] ="gtag('event', 'conversion', {
						      'send_to': 'AW-711995140/Z9FpCMipzKkBEITewNMC',
						      'transaction_id': ''
						  });
						fbq('track', 'Purchase',{
							content_type: 'product',
							value:'".$paytotal."', 
							currency:'".$getpricecode."',
							content_ids:[".$bns."],
							contents:[".$cons."]
						});";
					}



					//線上支付
					if( ($pcentertype=="1" && $source=="0") || ($pcentertype=="1" && substr($source,0,1)=="1")){
						
						
						//定義一些常用參數供接口使用
						global $SiteUrl;

						$myurl=$GLOBALS["CONF"][$SiteHttp];  //本網站地址
						$return_url=$SiteUrl."member/paycenter/".$recfile; //同步返回地址  
						$notify_url=$SiteUrl."member/paycenter/".$key2; //異步返回地址
						$v_orderid="SHOP-".$orderid; //帶模組名的傳遞訂單號，返回時可識別
													 //在會員帳戶儲值時，模組名是MEMBER
						
						$cardid = $_COOKIE["CARDID"];

						//包含支付接口
						$post_api=ROOTPATH."member/paycenter/".$postfile;
						
						
						
						if(file_exists($post_api)){
							
							include_once($post_api);
							
							
							$var=array(
							'orderid'=>$orderid,
							'OrderNo'=>$OrderNo,
							'paytotal'=>$getpriceid==1? "":"(NT$ ".number_format($paytotal,0).")",
							'pricesymbol'=>$pricesymbol,
							'showpaytotal'=>number_format($multitotal,$getpoint),
							'intro'=>$intro,
							'pcenter'=>$pcenter,
							'hiddenString'=>$hiddenString,
							'hiddenString_j'=>$hiddenString_j,
							'link' => $link
							);
							$str.=ShowTplTemp($TempArr["m2"],$var);
						}else{
							$var=array('ntc'=>"介接錯誤：付款介接文件(".$postfile.")不存在");
							$str.=ShowTplTemp($TempArr["err1"],$var);
						}
					}elseif($pcentertype=="1" && substr($source,0,1)=="2"){
						if($payid == "4"){
							$fsql->query("UPDATE {P}_shop_order SET ifpay='1' WHERE orderid='$orderid'");
							$fsql->query("UPDATE {P}_shop_orderitems SET ifpay='1' WHERE orderid='$orderid'");
						}
						switch ( $source )
						{
						case "0" :
								$sourcestr = "官網訂單";
								break;
						case "1-1" :
								$sourcestr = "板橋店";
								break;
						case "1-2" :
								$sourcestr = "新莊店";
								break;
						case "1-3" :
								$sourcestr = "內湖店";
								break;
						case "1-4" :
								$sourcestr = "三重店";
								break;
						case "1-5" :
								$sourcestr = "南屯店";
								break;
						case "2-1" :
								$sourcestr = "蝦皮";
								break;
						case "2-2" :
								$sourcestr = "MOMO";
								break;
						default :
								$sourcestr = "官網訂單";
						}
						$payntc="您已成功使用管理員身份建立來源訂單！<br /></br /><a class='btn btn-black btn-lg gostart' href='orderdetail.php?orderid=".$orderid."'>點這裡觀看訂單</a>";
						
						$var=array(
							'orderid'=>$orderid,
							'OrderNo'=>$OrderNo,
							'md'=>$md,
							'payntc'=>$payntc,
							'paytotal'=>$getpriceid==1? "":"(NT$ ".number_format($paytotal,0).")",
							'pricesymbol'=>$pricesymbol,
							'showpaytotal'=>number_format($multitotal,$getpoint),
							'sourcestr' =>$sourcestr
						);
						
						setcookie("SHOPCART", "", time( ) - 3600, "/" );
						$str.=ShowTplTemp($TempArr["m3"],$var);
						
						$GLOBALS['fbtrack'] ="gtag('event', 'conversion', {
      'send_to': 'AW-711995140/Z9FpCMipzKkBEITewNMC',
      'transaction_id': ''
  });
fbq('track', 'Purchase',{
							content_type: 'product',
							value:'".$paytotal."', 
							currency:'".$getpricecode."',
							content_ids:[".$bns."],
							contents:[".$cons."]
						});";
					}

				}else{
					$var=array('ntc'=>"付款方式不存在，您所選擇的付款方式可能已被管理員刪除");
					$str.=ShowTplTemp($TempArr["err1"],$var);
				}
				
			}



		}
		$var=array('orderid'=>$orderid);
		$str.=ShowTplTemp($TempArr["end"],$var);
		//$str.=$TempArr["end"];
		return $str;

}

?>