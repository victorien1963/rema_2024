<?php
include( "ShopTemperature.php" );

/*
	[元件名稱] 商品詳情元件
	[適用範圍] 詳情頁
*/

function ShopContent(){

	global $fsql,$msql,$tsql,$sybtype,$lantype;
	include( "../language/".$lantype.".php" );
	/*檢測一小時內未付款之刷卡訂單-20130901*/
	$msql->query("SELECT * FROM {P}_shop_order WHERE payid='1' AND ifpay='0' AND iftui='0'");
	while($msql->next_record()){
		$OrderNo = $msql->f("OrderNo");
		$orderid = $msql->f("orderid");
		$dtime = $msql->f("dtime");
		/*加回庫存**/
		if(time()-$dtime > 3600){
			$fsql->query( "select gid,nums,fz from {P}_shop_orderitems where orderid='{$orderid}'" );
			while ( $fsql->next_record( ) )
			{
				$gid = $fsql->f("gid");
				$acc = $fsql->f("nums");
				list($buysize, $buyprice, $buyspecid) = explode("^",$fsql->f("fz"));
				$tsql->query( "UPDATE {P}_shop_con SET kucun=kucun+{$acc} WHERE id='{$gid}'" );
				if($buyspecid){
					$tsql->query( "UPDATE {P}_shop_conspec SET stocks=stocks+{$acc} WHERE id='{$buyspecid}'" );
				}
			}
						
			/*退還餘額付款20170520*/
			$memberid = $msql->f("memberid");
			$disaccount = $msql->f("disaccount");
			if ( $disaccount > 0 )
			{
				$tsql->query( "UPDATE {P}_member SET account=account+{$disaccount} WHERE memberid='{$memberid}'" );
			}
			/*退還餘額付款*/
			$fsql->query( "update {P}_shop_order set iftui='1' where orderid='{$orderid}'" );
			$fsql->query( "update {P}_shop_orderitems set iftui='1' where orderid='{$orderid}'" );
			
			//給POS用
			$idtui .= $idtui? ",".$orderid:$orderid;
			$ONO[$orderid] = $OrderNo;

			//api
			include_once( ROOTPATH."costomer.php");
			$data['status'] = "2";
			$data['orderid'] = $orderid;
			$data['oper'] = $_COOKIE["SYSNAME"];
			upd_order_complete(http_build_query($data));

		}
		/*加回庫存 END*/
	}

	
	// if($idtui != ""){
		/*刪除產生 POS專用EXCEL*/
		/*這邊應該要改放 取消訂單的API*/
		//api
		// include_once( ROOTPATH."costomer.php");
		// $data['status'] = "2";
		// $data['orderid'] = $orderid;
		// $data['oper'] = $_COOKIE["SYSNAME"];
		// upd_order_complete(http_build_query($data));
	// }
	/*檢測一小時內未付款之刷卡訂單 END*/
	

	

	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	
	//獲取貨幣、匯率
	if($sybtype){
		list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",$sybtype);
	}else{
		list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",getDefaultSyb());
	}
		
	//模版解釋
	$Temp=LoadTemp($tempname);
	$TempArr=SplitTblTemp($Temp);
	
	//獲取網址攔參數
	if(strstr($_SERVER["QUERY_STRING"],".html")){
		$idArr=explode(".html",$_SERVER["QUERY_STRING"]);
		list($id, $subpicid) = explode("-",$idArr[0]);
		//$id=$idArr[0];
	}elseif(isset($_GET["id"]) && $_GET["id"]!=""){
		$id=$_GET["id"];
	}
	
		/*尺吋表*/
	$act = $_GET["act"];
	if($act == "size"){
		$canshu = $fsql->getone("select canshu from {P}_shop_con where id='$id'");
		
		$var = array(
			'mobisize' => ROOTPATH.$canshu["canshu"],
		);
		
		$str = ShowTplTemp($TempArr["m2"],$var);
		return $str;
	}
	/**/
	$scl = " and (starttime<='".time()."' OR starttime='') and (endtime>='".time()."' OR endtime='') ";
	

	$Arr=explode(".html",$_SERVER['HTTP_REFERER']);
	$Arr=explode("/?",$Arr[0]);
	$oricatid=(INT)$Arr[1];
	if($oricatid == 0){
		$Arr=explode("/shopclass",$_SERVER['HTTP_REFERER']);
		$oricatid=(INT)$Arr[1];
	}
	
	
	if($subpicid != ""){
		$getothpic = $fsql->getone("select src,body,colorpic,canshu,subid,catpath from {P}_shop_con where id='$subpicid'");
	}

	$fsql->query("select * from {P}_shop_con where id='$id' $scl");
	if($fsql->next_record()){
		
		
		$getlans = strTranslate("shop_con", $id);
		

		$catid=$fsql->f('catid');
		$subcatid=$fsql->f('subcatid');
		$getcatname = $tsql->getone("select catpath from {P}_shop_cat where catid='$catid'");
		list($maincatid,$subcatid) = explode(":",$getcatname[catpath]);
		$maincatid = $maincatid-0;
		$subcatid = $subcatid-0;
		
		if($subcatid != $oricatid){
			$getcatname = $tsql->getone("select catpath from {P}_shop_cat where catid='$subcatid'");
			list($maincatid,$subcatid) = explode(":",$getcatname[catpath]);
			$maincatid = $maincatid-0;
			$subcatid = $subcatid-0;
		}
		
		/*$getcatname = $tsql->getone("select cat from {P}_shop_cat where catid='$maincatid'");
		list($catname) = explode(" ",$getcatname[cat]);*/
		
		$getsubcatname = $tsql->getone("select cat from {P}_shop_cat where catid='$subcatid'");
		list($catname,$subcatname) = explode(" ",$getsubcatname[cat]);
			if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/class/".$subcatid.".html")){
				$sublink=ROOTPATH."shop/class/".$subcatid.".html";
			}else{
				$sublink=ROOTPATH."shop/class/?".$subcatid.".html";
			}
			
		$catpath=$fsql->f('catpath');
		
		if($oricatid == 0){
			list($Haa,$Hbb,$oricatid) = explode(":",$catpath);
			$oricatid = $oricatid-0;
		}else{
			list($Haa) = explode(":",$catpath);
		}
		
		$memberid=$fsql->f('memberid');
		$memo=$getlans['memo']? $getlans['memo']:$fsql->f('memo');
		$memotext=$getlans['memotext']? $getlans['memotext']:$fsql->f('memotext');
		$after_sales_service=$getlans['after_sales_service']? $getlans['after_sales_service']:$fsql->f('after_sales_service');
		$after_sales_service=nl2br($after_sales_service);
		$body=$getlans['body']? $getlans['body']:$fsql->f('body');
		$mbody=$getlans['mbody']? $getlans['mbody']:$fsql->f('mbody');
		if($subpicid != ""){
			$getlans_P = strTranslate("shop_con", $subpicid, "body");
			$getbody=$getlans_P['body']? $getlans_P['body']:$getothpic['body'];
			$getcanshu=$getlans_P['canshu']? $getlans_P['canshu']:$getothpic['canshu'];
			if($getcanshu != ""){
				$body=$getbody;
			}
		}
		
		$dtime=$fsql->f('dtime');
		
		$title=$getlans['title']? $getlans['title']:$fsql->f('title');
		$title=stripslashes($title);
		
		$source=$fsql->f('source');
		$author=$fsql->f('author');
		$iffb=$fsql->f('iffb');
		$cl=$fsql->f('cl');
		$secure=$fsql->f('secure');
		$src=$getothpic['src']? $getothpic['src']:$fsql->f('src');
		$srcs = ROOTPATH.dirname($src)."/sp_".basename($src);

		//$srcs = ROOTPATH.$src;
		/**/
		$colorname = $getlans['colorname']? $getlans['colorname']:$fsql->f('colorname');
		$colorpic = $getothpic['colorpic']? ROOTPATH.$getothpic['colorpic']:ROOTPATH.$fsql->f('colorpic');
		$colorpics = dirname($colorpic)."/sp_".basename($colorpic);
		$subid = $fsql->f('subid');
		
		/**/
		$tags=$fsql->f('tags');
		$prop1=$fsql->f('prop1');
		$prop2=$fsql->f('prop2');
		$prop3=$fsql->f('prop3');
		$prop4=$fsql->f('prop4');
		$prop5=$fsql->f('prop5');
		$prop6=$fsql->f('prop6');
		$prop7=$fsql->f('prop7');
		$prop8=$fsql->f('prop8');
		$prop9=$fsql->f('prop9');
		$prop10=$fsql->f('prop10');
		$prop11=$fsql->f('prop11');
		$prop12=$fsql->f('prop12');
		$prop13=$fsql->f('prop13');
		$prop14=$fsql->f('prop14');
		$prop15=$fsql->f('prop15');
		$prop16=$fsql->f('prop16');
		$prop17=$fsql->f('prop17');
		$prop18=$fsql->f('prop18');
		$prop19=$fsql->f('prop19');
		$prop20=$fsql->f('prop20');
		$desciption=$fsql->f('desciption') ? json_decode($fsql->f('desciption'), true) : [];
		
		if($fsql->f('b_body')==""){
			$show_b_body = "none";
		}
		
		$a_body=$getlans['a_body']? $getlans['a_body']:$fsql->f('a_body');
		$b_body=$getlans['b_body']? $getlans['b_body']:$fsql->f('b_body');
		$c_body=$getlans['c_body']? $getlans['c_body']:$fsql->f('c_body');
		$d_body=$getlans['d_body']? $getlans['d_body']:$fsql->f('d_body');

		/**
		 * 溫度範圍＆環境條件
		 */
		$shop = new ShopTemperature;
		$shop->temperatureValue = $fsql->f('temperature');
		$temperature = $shop->getHtml($TempArr['m1']);

		$shop->ambienceValue = $fsql->f('ambience');
		$ambience = $shop->getAmbienceHtml($TempArr['m4']);
		
		
		if(empty($desciption)) {
			// 使用正则表达式匹配以<开始，以>结束的子字符串
			// 分解字串

			$pattern = '/<[^>]*>/';
			preg_match_all($pattern, $a_body, $matches);
			
			$new_a_body = count($matches[0]) > 0? $matches[0][0] : '';
			$b_body = "
			<div class=\"row justify-content-center\">
				<div class=\"col-md-12\">
					<h2>$title</h2>
				</div>            
				<div class=\"col-md-12\">
					<div class=\"pic\">$new_a_body</div>
				</div>
				<div class=\"col-md-7\">
					<div class=\"text\">
						" . nl2br($memotext) . "
					</div>
				</div>
			</div>  
			";
		} else {
			// preg_match_all('/<img [^>]*>/i', $b_body, $matches);
			// function callback($matches) {
				
			// 	if(!strpos($matches[1], '<img')) {
			// 		$matches[0] = str_replace('<p>', '<p class="col-md-7 mx-auto">', $matches[0]);
			// 	}  
			// 	return $matches[0]; 
			// }
			// $b_body = preg_replace_callback('/<p>(.*?)<\/p>/s', 'callback', $b_body);
			
			$b_body_limt = "";
			$index = 0;
			foreach($desciption as $key => $d) {

				if(array_key_exists('img', $d)) {
					$b_body_limt .= "
						<div class=\"col-md-12\">
							<div class=\"pic\">
								<img src=\"" . $d['img'] . "\">
							</div>
						</div>
					";
				} else {
					if($index === 0) {
						$b_body_limt .= "
						<div class=\"col-md-12\">
							<h2 style=\"font-size: 2rem;font-weight: 600;\">" . str_replace('#SPACE#', '&nbsp;', nl2br($d)) . "</h2>
						</div>
						";
					} else {
						$b_body_limt .= "
						<div class=\"col-md-7\">
							<div class=\"text\">
								" . str_replace('#SPACE#', '&nbsp;', nl2br($d)) . "
							</div>
						</div>
						";
					}
					
				}
				$index++;
			}
			$b_body = "
			<div class=\"row justify-content-center\">   
				      
				$b_body_limt
			</div>  
			";
		}
		
		$a_body=path2url($a_body);
		$b_body=path2url($b_body);
		$c_body=nl2br($c_body);
		$d_body=path2url($d_body);
		
		
		$zhichi=$fsql->f('zhichi');
		$fandui=$fsql->f('fandui');
		$usepicsize = $fsql->f( "usepicsize" );
		$bn=$fsql->f('bn');		
		list($sizeitem_a,$sizeitem_b,$sizeitem_c)=explode("|",$fsql->f('sizeitem'));
		

		$canshu=$getlans['canshu']? $getlans['canshu']:$fsql->f('canshu');
		$shape=$fsql->f('shape');
		if($subpicid != ""){
			$getlans_P = strTranslate("shop_con", $subpicid, "canshu");
			$getcanshu=$getlans_P['canshu']? $getlans_P['canshu']:$getothpic['canshu'];
			if($getcanshu != ""){
				$canshu=$getcanshu;
			}
		}
		/*取得尺寸表路徑*/
		/*preg_match('/<img.+src=\"?(.+\.(jpg|gif|bmp|bnp|png))\"?.+>/i',$canshu,$match);
		$sizechart = ROOTPATH.$match[1];
		if(!$match[1]){
			
				$sizechart = ROOTPATH."base/files/Brusco/WebComponents/SizeChart/Women_300dpi_1937x1500.png";
			
		}*/
		/**/
		$weight=$fsql->f('weight');
		$kucun=$fsql->f('kucun');
		$cent=$fsql->f('cent');
		//$price=$fsql->f('price');
		//$price0=$fsql->f('price0');
		$oriprice = $fsql->f('price');
		
		$price=$getrate!="1"? round(($fsql->f('price')*$getrate),$getpoint):$fsql->f('price');
		$price0=$getrate!="1"? round(($fsql->f('price0')*$getrate),$getpoint):$fsql->f('price0');
		
		$brandid=$fsql->f('brandid');
		$danwei=$fsql->f('danwei');
		$salenums=$fsql->f('salenums');
		/*更新促銷-START*/
		
			$isdisc=$fsql->f('isdisc');
			$discat=$fsql->f('discat');
			$distype=$fsql->f('distype');
			$disnum=$fsql->f('disnum');
			$disrate=$fsql->f('disrate');
			$disprice=$fsql->f('disprice');
			$newdisprice = $price;
			$usedis = 0;
			if($isdisc){
				//尋找該商品銷方案的起迄時間做更新
				$msql->query("select * from {P}_shop_promote where id='$distype' limit 0,1");
				if($msql->next_record()){
					list($sYear,$sMon,$sDay)=explode("-",$msql->f('startdate'));
					list($sH,$sM,$sS)=explode(":",$msql->f('starttime'));
					list($eYear,$eMon,$eDay)=explode("-",$msql->f('enddate'));
					list($eH,$eM,$eS)=explode(":",$msql->f('endtime'));
					$starts = mktime($sH,$sM,$sS,$sMon,$sDay,$sYear);
					$ends = mktime($eH,$eM,$eS,$eMon,$eDay,$eYear);
					//獲取標籤
					$tag2 = ROOTPATH.$msql->f('tag2');
					$distag = "<img src='".ROOTPATH.$tag2."' />";
				}
				
				
				if( time() > $starts && time() < $ends ){
					$usedis = 1;
					if($isdisc && $disrate){
						if($discat == 1){
							$newdisprice = ceil($price*$disrate);
						}
					}				
				}elseif( $ends < time() ){
					$msql->query( "update {P}_shop_con set isdisc='',discat='',distype='',disnum='',disrate='',disprice='' where id='{$id}'" );
				}
				
			}
		/*更新促銷-END*/
		$isadd = $fsql->f('isadd');
		if($isadd){
			$CARTSTR=$_COOKIE["SHOPCART"];
			$array=explode('#',$CARTSTR);
			$tnums=sizeof($array)-1;
			for($t=0;$t<$tnums;$t++){
				$fff=explode('|',$array[$t]);
				$gid=$fff[0];
				$acc=$fff[1];
				$fz=$fff[2];
				list($buycolorname, $buysize, $buyprice, $buyspecid, $getisadd) = explode("^",$fz);
				$mainpro += $getisadd;
			}
			if($tnums==$mainpro || !$CARTSTR){
				$str.=$TempArr["err3"];
				return $str;
			}
		}
		
		/*list($getcat) = explode(":",$catpath);
		$getcat = (INT)$getcat;
		$fsql->query("SELECT * FROM {P}_shop_cat WHERE catid='$getcat' AND ifhide='1'");
		if($fsql->next_record()){
			$str.=$TempArr["err3"];
			return $str;
		}*/
		
				$subcatid=$fsql->f('subcatid');
				$thirdcatid=$fsql->f('thirdcatid');
				$fourcatid=$fsql->f('fourcatid');
				$subcatpath=$fsql->f('subcatpath');
				$thirdcatpath=$fsql->f('thirdcatpath');
				$fourcatpath=$fsql->f('fourcatpath');
				
				$fmdsubpath = fmpath( $oricatid );
				if(stripos($subcatpath, $fmdsubpath) !== false){
					$mobicatid = $subcatid;
				}elseif(stripos($thirdcatpath, $fmdsubpath) !== false){
					$mobicatid = $thirdcatid;
				}elseif(stripos($fourcatpath, $fmdsubpath) !== false){
					$mobicatid = $fourcatid;
				}else{
					$mobicatid = $oricatid;
				}
				
		
	}else{
		$str.=$TempArr["err1"];
		return $str;
	}

	$fsql->query("update {P}_shop_con set cl=cl+1 where id='$id'");
	
	//發佈校驗-管理員可看
	// if(AdminCheckModle()==false && $iffb!="1"){
	// 	$str.=$TempArr["err1"];
	// 	return $str;
	// }
	
	//定義全局變量，使內容閱讀權限限制時不產生靜態頁
	$GLOBALS["consecure"]=$secure;


	//頁頭標題定義
	$GLOBALS["pagetitle"]=$title;
	

	//判斷閱讀權限
	if($secure>0){
		if(AdminCheckModle()==false && (!isLogin() || $_COOKIE["SE"]<$secure)){
			$str.=$TempArr["err2"];
			return $str;
		}
	}

	$msql->query("select brand from {P}_shop_brand where id='$brandid' limit 0,1");
	if($msql->next_record()){
		$brand=$msql->f('brand');
	}

	//標籤
	if($tags!=""){
		$tagsarr=explode(",",$tags);
		for($i=0;$i<sizeof($tagsarr);$i++){
			if($tagsarr[$i]!=""){
				$tagstr.="<a href='".ROOTPATH."shop/class/index.php?showtag=".urlencode($tagsarr[$i])."'>".$tagsarr[$i]."</a> ";
			}
		}
		$showtag="block";
	}else{
		$showtag="none";
	}

	/*//評論數
	$msql->query("select count(id) from {P}_comment where catid='11' and rid='$id'");
	if($msql->next_record()){
		$commentcount=$msql->f('count(id)');
	}

	//評分總和
	$msql->query("select sum(pj1) from {P}_comment where catid='11' and rid='$id'");
	if($msql->next_record()){
		$totalcent=$msql->f('sum(pj1)');
	}

	//計算平均分
	if($commentcount>0){
		$centavg=ceil($totalcent/$commentcount);
	}else{
		$centavg=0;
	}

	$stars=shopstarnums($centavg,ROOTPATH);

	//評論網址
	$commentutl=ROOTPATH."comment/class/index.php?catid=2&rid=".$id;*/


	$dtime=date("Y-m-d H:i:s",$dtime);

	if($src==""){$src="shop/pics/nopic.gif";}
	$src=ROOTPATH.$src;

	if($memo!=""){
		$memo=nl2br($memo);
		$showmemo="block";
	}else{
		$showmemo="none";
	}
	$memotext=nl2br($memotext);
	
	//發佈人網址
	if($memberid!="0"){
		$memberurl=ROOTPATH."member/home.php?mid=".$memberid;
	}else{
		$memberurl="#";
	}

	//屬性列
	$propstr="";

	$i=1;
	$msql->query("select * from {P}_shop_prop where catid='$catid' order by xuhao");
	while($msql->next_record()){
		$propname=$msql->f('propname');
		$pn="prop".$i;

		$pstr=str_replace("{#propname#}",$propname,$TempArr["list"]);
		$pstr=str_replace("{#prop#}",$$pn,$pstr);

		$propstr.=$pstr;

	$i++;
	}

	//計算價格
	include_once(ROOTPATH."shop/includes/shop.inc.php");
	$price=getMemberPrice($id,$price);
	
	$pricex=number_format($price0-$price,$getpoint);
	$price=number_format($price,$getpoint);
	$price0=number_format($price0,$getpoint);

	/*$pricex=number_format($price0-$price,0);
	$price=(INT)$price;
	$price0=number_format($price0,0);*/
	$newdisprice = number_format($newdisprice,$getpoint);
	$oriprice = round($oriprice,$getpoint);
	
	/*抓取尺寸*/
	/*$tsql->query("select * from {P}_shop_conspec where gid='{$id}' order by id");
	while($tsql->next_record()){
		$sizeselect .= '<option value="'.$tsql->f("size").'-'.$tsql->f("id").'">'.$tsql->f("size").'</option>';
		if($tsql->f("iconsrc")){
			$iconsrc = ROOTPATH.$tsql->f("iconsrc");
		}
	}*/
	
	/*抓取附圖片*/
	/*$zoomlist = str_replace("{#active#}","active",$TempArr["m0"]);
	$zoomlist = str_replace("{#src#}",$src,$zoomlist);
	$zoomlist = str_replace("{#srcs#}",$srcs,$zoomlist);
	$zoomlist = str_replace("{#n#}","1",$zoomlist);
	$zoomlist = str_replace("{#id#}","1",$zoomlist);
	
	$substr = str_replace("{#select#}","select",$TempArr["m1"]);
	$substr = str_replace("{#srcs#}",$srcs,$substr);
	$substr = str_replace("{#n#}","1",$substr);
	$substr = str_replace("{#id#}","1",$substr);*/
	
	$srcR = $srcs;
	
	$si=2;
	if($subpicid != ""){
		$sid = $subpicid;
	}else{
		$sid = $id;
	}

	$gsubstrb = str_replace("{#src#}",$src,$TempArr["m0"]);
	$zoomlist .= $gsubstrb;

	$msql->query( "select id,src from {P}_shop_pages where gid='{$sid}' order by xuhao" );
	while ( $msql->next_record( ) )
	{
			$picsrc = ROOTPATH.$msql->f('src');			
			$spicsrc = dirname($picsrc)."/sp_".basename($picsrc);
			
			$gsubstrb = str_replace("{#src#}",$picsrc,$TempArr["m0"]);
			$zoomlist .= $gsubstrb;
			// 	if($si==13){ $substr .= $TempArr["m2"]; }
				
			// 	if($si==2){
			// 		$srcL = $spicsrc;
			// 	}else{
			// 		// $gsubstr = str_replace("{#select#}","",$TempArr["m1"]);
			// 		// $gsubstr = str_replace("{#srcs#}",$spicsrc,$gsubstr);
			// 		// $gsubstr = str_replace("{#n#}",$si,$gsubstr);
			// 		// $gsubstr = str_replace("{#id#}","1",$gsubstr);
			// 		// $substr .= $gsubstr;
					
			// 		$gsubstrb = str_replace("{#active#}","",$TempArr["m0"]);
			// 		$gsubstrb = str_replace("{#src#}",$picsrc,$gsubstrb);
			// 		$gsubstrb = str_replace("{#srcs#}",$spicsrc,$gsubstrb);
			// 		$gsubstrb = str_replace("{#n#}",$si,$gsubstrb);
			// 		$gsubstrb = str_replace("{#id#}","1",$gsubstrb);
					
			// 		$zoomlist .= $gsubstrb;
			// 	}
			
			// $si++;
	}
	
	
	$selcolor = str_replace("{#src#}",$colorpics,$TempArr["menu"]);
	$selcolor = str_replace("{#active#}","activ",$selcolor);	
	if($subpicid != ""){		
		$selcolor = str_replace("{#id#}",$id."_".$subpicid,$selcolor);
	}else{
		$selcolor = str_replace("{#id#}",$id,$selcolor);
	}
	$selcolor = str_replace("{#n#}","1",$selcolor);
	
	if(!$m_src){
		$m_src = $colorpics;
	}
	
	$selcolor_mobile = str_replace("{#srcs#}",$colorpics,$TempArr["more"]);
	$selcolor_mobile = str_replace("{#act#}","filter-act",$selcolor_mobile);
	
	if($subpicid != ""){		
		$selcolor_mobile = str_replace("{#id#}",$id."_".$subpicid,$selcolor_mobile);
	}else{
		$selcolor_mobile = str_replace("{#id#}",$id,$selcolor_mobile);
	}
	$selcolor_mobile = str_replace("{#n#}","1",$selcolor_mobile);
	
	/*其他顏色*/
	$subn = 2;
	$piclist = "";
	if($subpicid != ""){
		$subid = $getothpic["subid"];
		if($subid>0){
			$tsql->query("select id from {P}_shop_con where id='{$subid}' OR subid='{$subid}' AND id!='{$subpicid}' order by id");
			while($tsql->next_record()){
				$piclist .= $piclist? ",".$tsql->f("id"):$tsql->f("id");
			}
		}else{
			$tsql->query("select id from {P}_shop_con where subid='{$subpicid}' order by id");
			while($tsql->next_record()){
				$piclist .= $piclist? ",".$tsql->f("id"):$tsql->f("id");
			}
		}
			$piclist && $tsql->query("select id,colorpic,colorname,subid,subpicid from {P}_shop_con where id IN($piclist) order by id");

	}else{
		if($subid>0){
			$tsql->query("select id,colorpic,colorname from {P}_shop_con where id='{$subid}' OR subid='{$subid}' AND id!='{$id}' order by id");
		}else{
			$tsql->query("select id,colorpic,colorname from {P}_shop_con where subid='{$id}' order by id");
		}
	}
	
	while($tsql->next_record()){
		if($subpicid != ""){
			$gid = $tsql->f("subpicid")."_".$tsql->f("id");
		}else{
			$gid = $tsql->f("id");
		}
		
		$tcolorpic = dirname($tsql->f("colorpic"))."/sp_".basename($tsql->f("colorpic"));
		
		$subselcolor = str_replace("{#src#}",ROOTPATH.$tcolorpic,$TempArr["menu"]);
		$subselcolor = str_replace("{#active#}","",$subselcolor);			
		$subselcolor = str_replace("{#id#}",$gid,$subselcolor);
		$subselcolor = str_replace("{#n#}",$subn,$subselcolor);
		
		$subselcolor_m = str_replace("{#srcs#}",ROOTPATH.$tcolorpic,$TempArr["more"]);
		$subselcolor_m = str_replace("{#act#}","",$subselcolor_m);			
		$subselcolor_m = str_replace("{#id#}",$gid,$subselcolor_m);
		$subselcolor_m = str_replace("{#n#}",$subn,$subselcolor_m);
		$subn++;
		$selcolor .= $subselcolor;
		$selcolor_mobile .= $subselcolor_m;
	}	
	
	/*抓取尺寸*/
	
	// include( ROOTPATH."costomer.php");
		
	// $data['gid'] = $id;
	// $data['bn'] = $bn;
	// $selsize = get_stock(http_build_query($data));
	$tsql->query("select * from {P}_shop_conspec where gid='{$id}' order by id");
	$stocksCheck = 0;
	while($tsql->next_record()){
		$gselsize = str_replace("{#size#}",$tsql->f("size"),$TempArr["text"]);
		$gselsize = str_replace("{#specid#}",$tsql->f("id"),$gselsize);
		if($tsql->f("stocks") <= 0) {
			$gselsize = str_replace("{#status#}","disabled",$gselsize);
		}
		$stocksCheck += $tsql->f("stocks");
		$selsize .= $gselsize;
	}

	//api
	// $tsql->query("select * from {P}_shop_conspec where gid='{$id}' order by id");
	// include_once( ROOTPATH."costomer.php");
	// $Arr = array("UAS001-BA,UAS001-GR,UAS001-WHS","UAS001-BA,UAS001-GR,UAS001-WHM","UAS001-BA,UAS001-GR,UAS001-WHL", 
	// "URS002-BA,URS002-LGS", "UCS004-GR,UCS004-DBS", "UCS004-GR,UCS004-DBM", "UCS004-GR,UCS004-DBL", 
	// "UCS005-BA,UCS005-DBS", "UCS005-BA,UCS005-DBL", "UCS006-RD,UCS006-DBS" , "UCS006-RD,UCS006-DBM" , "UCS006-RD,UCS006-DBL");
	// while($tsql->next_record()){	
	// 	$posproid = $tsql->f("posproid");
	// 	if (!in_array($posproid, $Arr)){
	// 		$data['posproid'] = $posproid;
	// 		$data['shopContent'] = "shopContent.php";
	// 		$stocks=get_stock_one(http_build_query($data));
	// 	}
	// }
	
	//$showarr = "block";
	if(admincheckauth()){
		$showad = true;
	}
	
	for($t=100;$t<=221;$t++){
		$select_tall .= '<option value="'.$t.'">'.$t.'cm</option>';
	}
	for($w=30;$w<=150;$w++){
		$select_weight .= '<option value="'.$w.'">'.$w.'kg</option>';
	}
	for($h=50;$h<=135;$h++){
		$in = round($h*0.3937,1);
		$select_hips .= '<option value="'.$h.'">'.$h.'cm/ '.$in.'吋</option>';
	}
	
    $msql->query("select * from `cpp_shop_product_size` where id='$id'");
    while($msql->next_record()){
        $size = $msql->f('size');
    }
    
    if ($size >= 1 && $size <=3)
        $sex = "男";
    else
        $sex = "女";
    
    if ($size == 1 || $size == 4)
        $style = "緊 身 ";
    else if ($size == 2 || $size == 5)
        $style = "修 身 ";
    else if ($size == 3 || $size == 6)
        $style = "寬 鬆 ";

    
    $msql->query("select * from `cpp_shop_product_size_chart` where size='$size'");
    while($msql->next_record()){
        $sizeContent = $msql->f('sizeContent');
    }
    $sizeArray = explode(",", $sizeContent);
    // 處理新版商品頁的主要商品圖
	// ShowTplTemp($TempArr["m0"],'');
	
	// 使用正则表达式匹配以<开始，以>结束的子字符串
	// 分解字串
	
	// $pattern = '/<[^>]*>/';
	// preg_match_all($pattern, $a_body, $matches);
	// $new_a_body = '';
	// foreach($matches[0] as $k => $v) {
	// 	$new_a_body .= ShowTplTemp($TempArr["m0"], [
	// 		"img" => $v
	// 	]);
	// }
	$var=array (
		'sitename' => $GLOBALS["CONF"]["SiteName"],
		'gid' => $id, 
		'id' => $id, 
		'catid' => $catid, 
		'body' => ROOTPATH.$body, 
		'canshu' => ROOTPATH.$canshu,
		'canshu_check' => $canshu ? '' : 'd-none',
		'shape'=> $shape ? ROOTPATH.$shape : '{#TM#}img/img_size_ref.jpg',
		'sizechart' => $sizechart,
		'memo' => $memo, 
		'memotext' => stripslashes($memotext), 
		'ambience_status' => ($temperature || $ambience) ? '' : 'd-none',
		'temperature' => $temperature,
		'ambience' => $ambience,
		'bn' => $bn, 
		'weight' => $weight, 
		'kucun' => $kucun, 
		'cent' => $cent, 
		'price' => $price, 
		'price0unit' => $price0 ? $getsymbol . $price0 : '',
		'price0' => $price0? $price0."&nbsp;&nbsp;":"",
			'showprice0' => $price0>0? "":"none",
		'pricex' => $pricex, 
		'brand' => $brand, 
		'brandid' => $brandid, 
		'danwei' => $danwei, 
		'salenums' => $salenums, 
		'buyurl' => $buyurl, 
		'propstr' => $propstr, 
		'showmemo' => $showmemo, 
		'src' => $src, 
		'dtime' => $dtime, 
		'title' => $title, 
		'source' => $source, 
		'iffb' => $iffb, 
		'author' => $author, 
		'tagstr' => $tagstr, 
		'showtag' => $showtag, 
		'commentutl' => $commentutl, 
		'commentcount' => $commentcount, 
		'memberurl' => $memberurl, 
		'centavg' => $centavg, 
		'stars' => $stars, 
		'zhichi' => $zhichi, 
		'fandui' => $fandui, 
		'cl' => $cl,
		'isadd' => $isadd,
			'oriprice' => $oriprice,
			'discat' => $discat,
			'distype' => $distype,
			'disnum' => $disnum,
			'disrate' => $disrate,
			'disprice' => $disprice,
			'newdisprice' => $newdisprice,
			'distag' => $distag,
			'brandlogo' => $brandlogos,
			'usedis' => $usedis,
			'padsmorelink' => $padsmorelink,
			'catname' => $catname,
			'subcatname' => $subcatname,
			'sublink' => $sublink,
			'sizeselect' => $sizeselect,
			'iconsrc' => $iconsrc,
			'subpic' => $substr,
			'showarr' => $showarr,
			'pricesymbol' => $getsymbol,
			'zoomlist' => $zoomlist,
			'selcolor' => $selcolor,
			'selcolor_mobile' => $selcolor_mobile,
			'm_src'=> $m_src,
			'selsize' => $selsize,
			'btn_none' => $stocksCheck > 0? '' : 'btn-none',
			'stock_check' => $stocksCheck > 0 ? ($stocksCheck > 10 ? $strInStocks : $strLowStocks) : $strOutOfStocks,
			'instocks' => $stocksCheck > 10 ? $strInStocks : $strLowStocks,
			'outofstocks' => $strOutOfStocks,
			'subpicid' => $subpicid,
			'thisurl' => $_SERVER['REQUEST_URI'],
			'mbody' => $mbody,
			'mobicatid' => $mobicatid,
			'colorname' => $colorname,
			'showchecksize' => $showad? "inline-block":"none",
			'pricecode'=>$getpricecode,
			'srcR' => $srcR,
			'srcL' => $srcL,
			'select_tall' => $select_tall,
			'select_weight' => $select_weight,
			'select_hips' => $select_hips,
			'a_body' => $a_body,
			'after_sales_service_status' => $after_sales_service ? '' : 'd-none',
			'after_sales_service' => $after_sales_service,
			'b_body' => $b_body,
			'c_body' => $c_body,
			'd_body' => $d_body,
			'show_b_body' => $show_b_body,
                'sex' => $sex,
                'size' => $size,
                'style' => $style,
                'sizeArray0' => $sizeArray[0],
                'sizeArray1' => $sizeArray[1],
                'sizeArray2' => $sizeArray[2],
                'sizeArray3' => $sizeArray[3],
                'sizeArray4' => $sizeArray[4],
                'sizeArray5' => $sizeArray[5],
                'sizeArray6' => $sizeArray[6],
                'sizeArray7' => $sizeArray[7],
                'sizeArray8' => $sizeArray[8],
                'sizeArray9' => $sizeArray[9],
                'sizeArray10' => $sizeArray[10],
                'sizeArray11' => $sizeArray[11],
                'sizeArray12' => $sizeArray[12],
                'sizeArray13' => $sizeArray[13],
                'sizeArray14' => $sizeArray[14],
                'sizeArray15' => $sizeArray[15],
                'sizeArray16' => $sizeArray[16],
                'sizeArray17' => $sizeArray[17],
                'sizeArray18' => $sizeArray[18],
                'sizeArray19' => $sizeArray[19],
                'sizeArray20' => $sizeArray[20],
                'sizeArray21' => $sizeArray[21],
                'sizeArray22' => $sizeArray[22],
                'sizeArray23' => $sizeArray[23],
                'sizeArray24' => $sizeArray[24],
                'sizeArray25' => $sizeArray[25],
                'sizeArray26' => $sizeArray[26],
                'sizeArray27' => $sizeArray[27],
                'sizeArray28' => $sizeArray[28],
                'sizeArray29' => $sizeArray[29],
                'sizeArray30' => $sizeArray[30],
                'sizeArray31' => $sizeArray[31],
                'sizeArray32' => $sizeArray[32],
                'sizeArray33' => $sizeArray[33],
                'sizeArray34' => $sizeArray[34],
                'sizeArray35' => $sizeArray[35],
                'sizeArray36' => $sizeArray[36],
                'sizeArray37' => $sizeArray[37],
                'sizeArray38' => $sizeArray[38],
                'sizeArray39' => $sizeArray[39],
                'sizeArray40' => $sizeArray[40],
                'sizeArray41' => $sizeArray[41],
                'sizeArray42' => $sizeArray[42],
                'sizeArray43' => $sizeArray[43],
                'sizeArray44' => $sizeArray[44],
                'sizeArray45' => $sizeArray[45],
                'sizeArray46' => $sizeArray[46],
                'sizeArray47' => $sizeArray[47],
                'sizeArray48' => $sizeArray[48],
                'sizeArray49' => $sizeArray[49],
                'sizeArray50' => $sizeArray[50],
                'sizeArray51' => $sizeArray[51],
                'sizeArray52' => $sizeArray[52],
                'sizeArray53' => $sizeArray[53],
                'sizeArray54' => $sizeArray[54],
                'sizeArray55' => $sizeArray[55],
                'sizeArray56' => $sizeArray[56],
                'sizeArray57' => $sizeArray[57],
                'sizeArray58' => $sizeArray[58],
                'sizeArray59' => $sizeArray[59],
                'sizeArray60' => $sizeArray[60],
                'sizeArray61' => $sizeArray[61],
                'sizeArray62' => $sizeArray[62],
                'sizeArray63' => $sizeArray[63],
                'sizeArray64' => $sizeArray[64],
                'sizeArray65' => $sizeArray[65],
                'sizeArray66' => $sizeArray[66],
                'sizeArray67' => $sizeArray[67],
                'sizeArray68' => $sizeArray[68],
                'sizeArray69' => $sizeArray[69],
                
                
	    		'showsize_A' => $usepicsize==1? "block":"none",
	    		'showsize_B' => $usepicsize==1? "none":"block"
	);
    $str=ShowTplTemp($TempArr["start"],$var);
	
	
	$GLOBALS['fbtrack'] ="
		
	    fbq('track', 'ViewContent', { 
			content_type: 'product',
			content_ids: ['".$bn."'],
			content_name: '".$title."',
			content_category: '".$catname."',
			value: ".$oriprice.",
			currency: '".$getpricecode."'
		});
		function fbtocart(url){
			fbq('track', 'AddToCart', { 
				content_type: 'product',
				content_ids: ['".$bn."'],
				value: ".$oriprice.",
				currency: '".$getpricecode."'
			});
			gtag_report_conversion();
		}
		function gtag_report_conversion(url) {
		  var callback = function () {
		    if (typeof(url) != 'undefined') {
		      window.location = url;
		    }
		  };
		  gtag('event', 'conversion', {
		      'send_to': 'AW-711995140/9HaiCLapzKkBEITewNMC',
		      'event_callback': callback
		  });
		  return false;
		}
		";
	
	$str.=ShowTplTemp($TempArr["end"],$var);
	//$str.=$TempArr["end"];
	
	if($getothpic){
		list($getcat) = explode(":",$getothpic['catpath']);
	}else{
		list($getcat) = explode(":",$catpath);
	}
	$getcat = (INT)$getcat;
	if($getcat == 1){
        	$nav = 0;
        }else{
        	$nav = 1;
        }
        
    $str=str_replace("{#nav#}",$nav,$str);
    
    $memberid = $_COOKIE["MEMBERID"];
    if($memberid){
	    $getmember = $msql->getone("SELECT * FROM {P}_member WHERE  memberid='{$memberid}'");
	    $member_tall = $getmember['tall'];
	    $member_weight = $getmember['weight'];
	    $member_chest = $getmember['chest'];
	    $member_waist = $getmember['waist'];
	    $member_hips = $getmember['hips'];
    }else{
    	list($member_tall, $member_weight, $member_chest, $member_waist, $member_hips) = explode("^",$_COOKIE["SIZECHART"]);
    }
    
    //if($showad){
	    if($usepicsize == 1){
			$str .= str_replace("{#m3#}","<img src='../../".$canshu."' style='max-width: 100%;height: auto !important;'>",$TempArr["col"]);
		}else{
			//手機用
			for($t=90; $t<=220; $t++){
				if($t == $member_tall){
					$m_tall_list .= '<option value="'.$t.'" selected>'.$t.' cm</option>';
				}else{
					$m_tall_list .= '<option value="'.$t.'">'.$t.' cm</option>';
				}
			}
			for($k=25; $k<=120; $k++){
				if($k == $member_weight){
					$m_weight_list .= '<option value="'.$k.'" selected>'.$k.' kg</option>';
				}else{
					$m_weight_list .= '<option value="'.$k.'">'.$k.' kg</option>';
				}
			}
			
			$m_chest_list = '<option value="0" >不設定</option>';
			for($c=1; $c<=122; $c++){
				$inc = round($c/2.54,1);
				if($c == $member_chest){
					$m_chest_list .= '<option value="'.$c.'" selected>'.$c.' cm  ／ '.$inc.' 吋</option>';
				}else{
					$m_chest_list .= '<option value="'.$c.'">'.$c.' cm  ／ '.$inc.' 吋</option>';
				}
			}
			
			$m_waist_list = '<option value="0" >不設定</option>';
			for($c=1; $c<=122; $c++){
				$inc = round($c/2.54,1);
				if($c == $member_waist){
					$m_waist_list .= '<option value="'.$c.'" selected>'.$c.' cm  ／ '.$inc.' 吋</option>';
				}else{
					$m_waist_list .= '<option value="'.$c.'">'.$c.' cm  ／ '.$inc.' 吋</option>';
				}
			}
			
			$m_hips_list = '<option value="0" >不設定</option>';
			for($c=1; $c<=122; $c++){
				$inc = round($c/2.54,1);
				if($c == $member_hips){
					$m_hips_list .= '<option value="'.$c.'" selected>'.$c.' cm  ／ '.$inc.' 吋</option>';
				}else{
					$m_hips_list .= '<option value="'.$c.'">'.$c.' cm  ／ '.$inc.' 吋</option>';
				}
			}
			
			if($sizeitem_a=="1"){
				$inacc="inchest";
			}elseif($sizeitem_b=="1"){
				$inacc="inwaist";
			}elseif($sizeitem_c=="1"){
				$inacc="inhips";
			}
			
	    	$var=array(
	    		'gid' => $id,
	    		'itempic' => $Haa=='0001'? "man.png":"women.png",
	    		'sizeitem_a' => $sizeitem_a=="1"? "":"none",
	    		'sizeitem_b' => $sizeitem_b=="1"? "":"none",
	    		'sizeitem_c' => $sizeitem_c=="1"? "":"none",
	    		'tall' => $member_tall? $member_tall:"165",//預設身高
	    		'weight' => $member_weight? $member_weight:"60",//預設體重
	    		'chest' => $member_chest? $member_chest:"0",//預設胸圍
	    		'waist' => $member_waist? $member_waist:"0",//預設腰圍
	    		'hips' => $member_hips? $member_hips:"0",//預設臀圍
	    		'm_tall_list' => $m_tall_list,
	    		'm_weight_list' => $m_weight_list,
	    		'm_chest_list' => $m_chest_list,
	    		'm_waist_list' => $m_waist_list,
	    		'm_hips_list' => $m_hips_list,
	    		'inacc' => $inacc,
	    		'inchest' => $member_chest? round($member_chest/2.54,1):"0",//預設胸圍
	    		'inwaist' => $member_waist? round($member_waist/2.54,1):"0",//預設腰圍
	    		'inhips' => $member_hips? round($member_hips/2.54,1):"0",//預設臀圍
	    		'checkInput' => $member_tall? "checkInput();":"",
	    	);
	    	
	    	$tt = ShowTplTemp($TempArr["m3"],$var);
	    	$str .= str_replace("{#m3#}",$tt,$TempArr["col"]);
	    }
    //}
	
	return $str;


}

?>
