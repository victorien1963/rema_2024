<?php

/*
	[元件名稱] 商品訂購
*/

function ShopStartOrder(){

	global $fsql,$msql,$tsql,$sybtype,$strPleaseSelect,$lantype;
	
		$memberid= $_COOKIE["MEMBERID"];
		//2016獲取貨幣、匯率
		if($sybtype){
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",$sybtype);
		}else{
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",getDefaultSyb());
		}
		
		//echo $sybtype;

		$promocodestr = URIAuthcode($_GET[promocode]);
		
		list($yunfei,$promocode,$promoprice,$disaccount,$promolog) = explode("-",$promocodestr);

		//exit($promocodestr);
		
		if( AdminCheckModle()==true ){
			$source = $_GET["source"];
			$sourceyun = $_GET["sourceyun"];
			$sourceyunfei = $_GET["sourceyunfei"];
			$sourcediscount = $_GET["sourcediscount"];
			$promoprice += $sourcediscount;
			$yunfei = $sourceyunfei? $sourceyunfei:"0";
			setcookie("SOURCE",$source, time( ) + 3600, "/" );
			setcookie("SOURCEYUN",$sourceyun, time( ) + 3600, "/" );
			setcookie("SOURCEYUNFEI",$sourceyunfei, time( ) + 3600, "/" );
			setcookie("SOURCEDISCOUNT",$sourcediscount, time( ) + 3600, "/" );
		}
		
		
		/*商品促銷*/
		list($promotype, $promo_con, $promo_spec) = explode("|",$promolog);
		if($promotype == 1){
			/*送贈品*/
			list($pid) = explode("#",$promo_con);
			list($psize, $psizeid) = explode("^",$promo_spec);
			###加註在訂單COOKIE中###
			$_COOKIE['SHOPCART'] = $_COOKIE['SHOPCART'].$pid."|1|".$psize."^0^".$psizeid."#";
		}
		
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		$pagename=$GLOBALS["PLUSVARS"]["pagename"];
		
		/*if($_COOKIE["MEMBERID"] == "869"){
			$GLOBALS["PLUSVARS"]["tempname"]= "tpl_p_5451.htm";
			$tempname=$GLOBALS["PLUSVARS"]["tempname"];
		}*/
		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);

		$str=$TempArr["start"];

		
		//判斷積分規則
		$centopen=$GLOBALS["SHOPCONF"]["CentOpen"];

		if($centopen=="1" && isLogin()){
			$showcent="";
		}else{
			$showcent=" style='display:none' ";
		}
		
		//判斷是否允許非會員訂購
		$nomemberorder=$GLOBALS["SHOPCONF"]["NoMemberOrder"];
		

		//讀取購物車資訊
		$var=array('showcent'=>$showcent);
		$endstr.=ShowTplTemp($TempArr["m0"],$var);

		$CARTSTR=$_COOKIE["SHOPCART"];

		$array=explode('#',$CARTSTR);
		$tnums=sizeof($array)-1;
		$tjine=0;
		$tweight=0;
		$kk=0;
		
		
		for($t=0;$t<$tnums;$t++){
				$fff=explode('|',$array[$t]);
				//$gid=$fff[0];
				list($gid, $subpicid)=explode("-",$fff[0]);
				$acc=$fff[1];
				$fz=$fff[2];
				$disc=$fff[3];
				//list($buycolorname, $buysize, $buyprice, $buyspecid, $getisadd) = explode("^",$fz);
				//list($discat, $distype, $disnum, $disrate, $disprice) = explode("^",$disc);
				list($buysize, $buyprice, $buyspecid) = explode("^",$fz);
				$fzspecid = "_".$buyspecid;
				$specid = $buyspecid;
				//$addtitle = " (".$buycolorname."-".$buysize.")";
				//$addnote = $getisadd? "[加購] ":"";
				
				$fsql->query("select * from {P}_shop_con where id='$gid'");
				if($fsql->next_record()){
					$bn=$fsql->f('bn');
					$title=$addnote.$fsql->f('title').$addtitle;
					$danwei=$fsql->f('danwei');
				
					/*價格修正 2017-05-21*/
						$getp = $fsql->f('price');
						$buyprice = $getp;
					/*價格修正 END*/
					if($subpicid){
						$getsubpic = $msql->getone("select src from {P}_shop_con where id='$subpicid'");
						$src=$getsubpic["src"];
					}else{
						$src=$fsql->f('src');	
					}				
					$srcs=dirname($src)."/sp_".basename($src);
					$srcs=ROOTPATH.$srcs;
					$colorname=$fsql->f('colorname');
					
					//幣值更換
					$oribuyprice=$buyprice;
					$oriprice=$fsql->f('price');
					
					$buyprice=$getrate!="1"? round(($buyprice*$getrate),$getpoint):$buyprice;
					$price=$getrate!="1"? round(($fsql->f('price')*$getrate),$getpoint):$fsql->f('price');	

					$price= isset($buyprice)? $buyprice:$price;
					
					//$price=(INT)$fsql->f('price');
					$cent=$fsql->f('cent');
					$weight=$fsql->f('weight');

					//$showprice=number_format($price,2,'.','');
					/*促銷商品計算 START*/
						/*$discat-1-單商品折扣。2-滿幾件統一售價*/
						if( $discat == 1 ){
							$disprice = isset($buyprice)? ceil($buyprice*$acc):ceil($price*$disrate*$acc);
							$jine=$disprice;
							$price=isset($buyprice)? $buyprice:ceil($price*$disrate);
						}elseif( $discat == 2 ){
							/*訂購數量滿規則*/
							$discpro[$distype][] = $acc."|".$disnum."|".$disprice."|".$price;
							$jine = "-促銷另計-";
						}else{
							$jine=$price*$acc;
						}
						
					/*促銷商品計算 END*/
					$price=getMemberPrice($gid,$price);
					$showprice=number_format($price);
					//$jine=$price*$acc;
					//$jine=number_format($jine,2,'.','');
					$weight=$weight*$acc;
					
					//realjine預設幣值費用
					$realjine = $oriprice*$acc;
					

					//計算積分
					$cent=accountCent($cent,$price)*$acc;
					
					$goodsurl=ROOTPATH."shop/html/?".$gid.".html";
				
					$var=array (
					'gid' => $gid,
					'goodsurl' => $goodsurl,
					'jine' => number_format($jine, $getpoint), 
					'showjine' => number_format($jine,0),
					'weight' => $weight, 
					'price' => number_format($price, $getpoint),
					'acc' => $acc,
					'fz' => $fz,
					'goodsname' => $title,
					'danwei' => $danwei,
					'bn' => $bn,
					'showcent'=>$showcent,
					'cent'=>$cent,
					'distag' => $distag[$t],
					'buysize'=> $buysize,
					'srcs' => $srcs,
					'colorname' => $colorname,
					'pricesymbol' => $getsymbol,
					);
						
					$endstr.=ShowTplTemp($TempArr["list"],$var);
					
					
				}
			$tjine=$tjine+$jine;
			$tcent=$tcent+$cent;
			$tweight=$tweight+$weight;
			$kk++;
			
			$realtjine = $realtjine+$realjine;
		}
		
					
		/*多件統一價促銷品計算*/
		//var_dump($discpro);
		if($discpro){
			$arr_pro = array_keys($discpro);
			$dnums = sizeof($arr_pro)-1;
			for($d=0;$d<=$dnums;$d++){
				$edis=$discpro[$arr_pro[$d]];
				$enums = sizeof($edis)-1;
				//迴圈取得資料
				$eacc=$enum=$eprice=$oriprice=$totalacc=$leaveejine=$oldoriprice="";
					for($k=0;$k<=$enums;$k++){
						list($eacc[], $enum[], $eprice[], $oriprice[]) = explode("|",$edis[$k]);
					}
				//加總所有件數
					foreach($eacc AS $keys=>$values){
						$totalacc += $values;
					}
				$enewacc = floor($totalacc/$enum[0]);
				//計算促銷價
				$ejine = $eprice[0]*$enewacc;
				//取得剩餘件數計算原價，並以價格高的為優先計價
				$eleaveacc = $totalacc%$enum[0];
				if( $eleaveacc > 0 ){
					rsort($oriprice);//價格由大到小排序
					
					for($s=0;$s<$eleaveacc;$s++){
						$leaveejine += $oriprice[$s]? $oriprice[$s]:$oldoriprice;//加總剩餘費用
						$oldoriprice = $oriprice[$s];
					}
				}
				$allejine += $ejine+$leaveejine;
			}
		}
		/**/
		//$tjine=number_format($tjine,2,'.','');
		$yunfei=$getrate!="1"? round(($yunfei*$getrate),$getpoint):$yunfei;
		
		$tjine = $tjine+$allejine;
		
		$disaccount=$getrate!="1"? round(($disaccount*$getrate),$getpoint):$disaccount;
		$promoprice=$getrate!="1"? round(($promoprice*$getrate),$getpoint):$promoprice;
				
		$tjine = $tjine+$yunfei-$disaccount-$promoprice;
		
		
		$var=array('tjine' => $tjine,'tweight' => $tweight,'showcent'=>$showcent,'tcent'=>$tcent,'showtjine' => number_format($tjine,$getpoint),
				'pricesymbol' => $getsymbol,);
		
		$str.=ShowTplTemp($TempArr["m1"],$var);
		
		//2016 擷取地址
		//會員
		
		$fsql->query("select * from {P}_member where memberid='$memberid'");
		if($fsql->next_record()){
			$s_addr = $fsql->f("addr");
			$s_postcode = $fsql->f("postcode");
			$s_mov = $fsql->f("mov");
			$s_tel = $fsql->f("tel");
			$s_country = $fsql->f("country");
			$s_countryid = $fsql->f("countryid");
			$s_zoneid = $fsql->f("zoneid");
			$s_name = $fsql->f("name");
			
			$seladdr = "<option value='0'>".$s_addr."(註冊資料，請於個人資料中修改)</option>";
				
			$s_addr_a=mb_substr( $s_addr,0,3,"utf-8" );
			$s_addr_b=mb_substr( $s_addr,3,3,"utf-8" );
			$s_addr_c=mb_substr( $s_addr,6,9999,"utf-8" );
		}
		
			$ZONE=ZoneList($s_zoneid, $s_countryid);
			$ZoneList=$ZONE["str"];
			$Province=$ZONE["pr"];
		
		$fsql->query("select * from {P}_member_addr where memberid='$memberid'");
		while($fsql->next_record()){
			$aid = $fsql->f("id");
			$ss_addr = $fsql->f("addr");
			$ss_postcode = $fsql->f("postcode");
			$ss_mov = $fsql->f("mov");
			$ss_tel = $fsql->f("tel");
			$ss_country = $fsql->f("country");
			$ss_zoneid = $fsql->f("zoneid");
			$ss_uptime = $fsql->f("uptime");
			
			$getaddr=$msql->getone("SELECT s_addr FROM {P}_shop_order WHERE memberid='$memberid' AND ifpay='1' ORDER BY orderid DESC limit 0,1");
			
			// 選取上次地址或是新增地址
			if(stripos( $getaddr["s_addr"],$ss_addr) !== false || time()-$ss_uptime < 60){
				$seladdr .= "<option value='".$aid."' selected>".$ss_addr."</option>";
			}else{
				$seladdr .= "<option value='".$aid."'>".$ss_addr."</option>";
			}
		}
		
		$selcountry = $blankcountry = "<option value=''> ".$strPleaseSelect."</option>";
		
		$getlantype = "_".str_replace("zh_","",$lantype);
		$getlantype = str_replace("_tw","",$getlantype);
		$fsql->query("select * from {P}".$getlantype."_member_zone where pid='0' and xuhao<>'0' order by xuhao");
		while ( $fsql->next_record( ) )
		{
			$ccat = $fsql->f("cat");
			if($country == $ccat){
				if($act == ""){
					$selcountry .= "<option value='".$ccat."_".$fsql->f("catid")."'> ".$ccat."</option>";
				}elseif($act == "modi"){
					$selcountry .= "<option value='".$ccat."_".$fsql->f("catid")."' selected> ".$ccat."</option>";
				}
				
			}else{
				$selcountry .= "<option value='".$ccat."_".$fsql->f("catid")."'> ".$ccat."</option>";
			}
			$blankcountry .= "<option value='".$ccat."_".$fsql->f("catid")."'> ".$ccat."</option>";
		}

		if($kk>0){
			
			//匯入發票資訊
			if($getrate == "1"){
				$includeInvoice = $TempArr["menu"];
			}else{
				$includeInvoice = $TempArr["text"];
			}
			
			
			$var=array(
				'tjine' => $tjine,
				'nomemberorder'=>$nomemberorder,
				'urlstr'=>$_GET[promocode], 
				'payid'=>$_COOKIE[PAYMENT],
				'seladdr' => $seladdr,
				's_addr_a' => $s_addr_a,
				's_addr_b' => $s_addr_b,
				's_addr_c' => $s_addr_c,
				's_addr' => $s_addr,
				's_name' => $s_name,
				's_mobi' => $s_mov,
				's_tel' => $s_tel,
				's_postcode' => $s_postcode,
				's_country' => $s_country,
				'pricesymbol' => $getsymbol,
				//'displaycard' => $_COOKIE[PAYMENT]=="1"? "in":"",
				'displaycard' => $_COOKIE[PAYMENT]=="1"? "flex":"none",
				'displaycardb' => $_COOKIE[PAYMENT]=="1"? "block":"none",
				'displayyun' => $_COOKIE[PAYMENT]=="1"? "none":"flex",
				'showtjine' => number_format($tjine,$getpoint),
				'includeInvoice' => $includeInvoice,
				'memberid' => $memberid,
				'adminshipinfo' => AdminCheckModle()? '<li class="style-toggle" ><div class="btn-group" data-toggle="buttons"><label class="btn active fix-padding two-addr-btn" data-toggle="collapse" data-parent="#accordion" data-target="#three-addr"><input type="radio" name="shipinfo" value="3" checked><i class="icon-circle-o"></i><i class="icon-dot-circle-o"></i> <span>  實體門市購買</span></label></div></li>':'',
				'showadmin' => AdminCheckModle()? 'none':'block',
				'disabled' => $getpricecode!="TWD"? "disabled":"",
			);
			$str.=ShowTplTemp($TempArr["m2"],$var);
		}else{
			header("location:cart.php");
		}
		
		$var=array(
			'ZoneList' => $ZoneList, 
			'Province' => $Province, 
			'oritjine' => $realtjine,
			'tjine' => $tjine,
			'yunfei' => $yunfei,
			'account' => $multiaccount? $multiaccount:$account,
			'disaccount' => $multidisaccount? $multidisaccount:$disaccount,
			'promoprice' => $multipromoprice? $multipromoprice:$promoprice,
			'pricesymbol' => $getsymbol,
			'selcountry' => $selcountry,
		);
		
		$str.=$endstr.ShowTplTemp($TempArr["end"],$var);


		return $str;

}

function URIAuthcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    if( $operation == 'DECODE') $string=str_replace(array("-","_"), array('+','/'),$string);
     $ckey_length = 4;
     $key = md5($key ? $key : $GLOBALS['UC_KEY']);
     $keya = md5(substr($key, 0, 16));
     $keyb = md5(substr($key, 16, 16));
     $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
     $cryptkey = $keya.md5($keya.$keyc);
     $key_length = strlen($cryptkey);
     $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
     $string_length = strlen($string);
     $result = '';
     $box = range(0, 255);
     $rndkey = array();
     for($i = 0; $i <= 255; $i++) {
         $rndkey[$i] = ord($cryptkey[$i % $key_length]);
     }
     for($j = $i = 0; $i < 256; $i++) {
         $j = ($j + $box[$i] + $rndkey[$i]) % 256;
         $tmp = $box[$i];
         $box[$i] = $box[$j];
         $box[$j] = $tmp;
     }
     for($a = $j = $i = 0; $i < $string_length; $i++) {
         $a = ($a + 1) % 256;
         $j = ($j + $box[$a]) % 256;
         $tmp = $box[$a];
         $box[$a] = $box[$j];
         $box[$j] = $tmp;
         $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
     }
     if($operation == 'DECODE') {
         if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
             return substr($result, 26);
         } else {
             return '';
         }
     } else {
         return $keyc.str_replace(array("=","+","/"), array('','-','_'), base64_encode($result));
     }
 }
?>