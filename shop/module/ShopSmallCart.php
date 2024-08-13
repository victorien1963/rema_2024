<?php

/*
	[元件名稱] 購物車提示資訊
*/

function ShopSmallCart(){

	global $fsql,$msql,$lantype,$sybtype,$SiteUrl;

		
		$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	
		//獲取貨幣、匯率
		if($sybtype){
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",$sybtype);
		}else{
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",getDefaultSyb());
		}

		
		//計算價格包含
		include_once(ROOTPATH."shop/includes/shop.inc.php");
		
		//模版解釋
		$Temp=LoadTemp($tempname);
		$TempArr=SplitTblTemp($Temp);


		$CARTSTR = $_COOKIE["SHOPCART"];
		//$VIEWITEM = $_COOKIE["VIEWITEM"];
		
		/*觀看記錄轉商品*/
		/*$viewgoods=explode(',',$VIEWITEM);
		foreach($viewgoods AS $viewgid){
			$msql->query("select src,title from {P}_shop_con where id='{$viewgid}'");
			if ( $msql->next_record( ) )
			{
				$src=$msql->f('src');
				$srcs=dirname($src)."/sp_".basename($src);
				if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/html/".$viewgid.".html")){
					$link=ROOTPATH."shop/html/".$viewgid.".html";
				}else{
					$link=ROOTPATH."shop/html/?".$viewgid.".html";
				}
				$var=array('link' => $link,'src' => ROOTPATH.$srcs,'title'=>$msql->f('title'));
				$clickitem .= ShowTplTemp($TempArr["list"],$var);
			}
		}*/
		

		$array=explode('#',$CARTSTR);
		$tnums=sizeof($array)-1;
		$tjine=0;
		$tacc=0;
		$kk=0;
		
		for($t=0;$t<$tnums;$t++){
				$fff=explode('|',$array[$t]);
				$gid=$fff[0];
				$acc=$fff[1];
				$fz=$fff[2];
				list($size, $buyprice, $specid) = explode("^",$fz);

				$fsql->query("select * from {P}_shop_con where id='$gid'");
				if($fsql->next_record()){
					$price=$fsql->f('price');
					$price=getMemberPrice($gid,$price);
					//幣值更換
					$price=$getrate!="1"? round(($price*$getrate),$getpoint):$price;
					$jine=$price*$acc;
					
					$title=$fsql->f('title');
					$colorname=$fsql->f('colorname');
					$src = $fsql->f('src');
					$srcs = dirname($src)."/sp_".basename($src);
			
					$var=array(
						'title' => $title,
						'colorname'=>$colorname,
						'size'=>$size,
						'acc' => $acc,
						'src' => ROOTPATH.$srcs,
						'price' => $getsymbol.' '.number_format($jine, $getpoint)
					);
					$items .= ShowTplTemp($TempArr["m0"],$var);
					
				}
				$tjine=$tjine+$jine;
				$tacc=$tacc+$acc;
			
			
			$kk++;
		}
		$tjine=number_format($tjine, $getpoint);
		
		$var=array('tjine' => $tjine,'tnums'=>$tnums,'tacc'=>$tacc,'clickitem' => $clickitem, 'itemlist'=>$items, 'pricesymbol' => $getsymbol,);

		$str=ShowTplTemp($TempArr["start"],$var);
		
		$str.=$TempArr["end"];

		return $str;

}

?>