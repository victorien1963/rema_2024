<?php

function getpayval( $back_pcenter )
{
		global $msql;
		$Meta = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		//$msql->query( "select * from {P}_member_paycenter where hbtype='{$back_pcenter}' and ifuse='1' limit 0,1" );
		$msql->query( "select * from {P}_member_paycenter where hbtype='{$back_pcenter}' limit 0,1" );
		if ( $msql->next_record( ) )
		{
				$pv['payid'] = $msql->f( "id" );
				$pv['pcenteruser'] = $msql->f( "pcenteruser" );
				$pv['pcenterkey'] = $msql->f( "pcenterkey" );
				$pv['key1'] = $msql->f( "key1" );
				$pv['key2'] = $msql->f( "key2" );
				return $pv;
		}
		else
		{
				echo $Meta."支付返回調試錯誤：沒有和".$back_pcenter."匹配的可用付款方式";
				exit( );
		}
}

function payback( $back_payid, $back_coltype, $back_orderid, $back_fee )
{
		global $msql;
		global $fsql;
		global $tsql;
		$back_coltype = strtolower( $back_coltype );
		$dtime = time( );
		$ip = $_SERVER['REMOTE_ADDR'];
		$Meta = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		if ( $back_coltype == "" )
		{
				echo $Meta."支付返回調試錯誤：缺少模組原始碼";
				exit( );
		}
		$msql->query( "select * from {P}_base_coltype where coltype='{$back_coltype}'" );
		if ( $msql->next_record( ) )
		{
				$colname = $msql->f( "colname" );
		}
		else
		{
				echo $Meta."支付返回調試錯誤：指定的模組(".$back_coltype.")不存在";
				exit( );
		}
		switch ( $back_coltype )
		{
		case "shop" :
				$msql->query( "select * from {P}_shop_order where orderid='{$back_orderid}' and paytotal='{$back_fee}'" );
				if ( $msql->next_record( ) )
				{
						$memberid = $msql->f( "memberid" );
						$payid = $msql->f( "payid" );
						$paytype = $msql->f( "paytype" );
						$ifpay = $msql->f( "ifpay" );
						$iftui = $msql->f( "iftui" );
						$OrderNo = $msql->f( "OrderNo" );
						$tcent = $msql->f( "totalcent" );
						$name = $msql->f( "name" );
						if ( $back_payid != $payid )
						{
								echo $Meta."支付返回調試錯誤：付款方式編號不匹配(可能是同一支付接口存在多條付款方式記錄)";
								exit( );
						}
						if ( $ifpay == "1" )
						{
								echo $Meta."訂單[shop](".$back_orderid.")已經是付款狀態了，不能重複送出";
								exit( );
						}
						if ( $iftui == "1" )
						{
								/*echo $Meta."訂單[shop](".$back_orderid.")已經退訂，支付確認失敗";
								exit( );*/
								$fsql->query( "select gid,nums,fz from {P}_shop_orderitems where orderid='{$back_orderid}'" );
								while ( $fsql->next_record( ) )
								{
									$gid = $fsql->f("gid");
									$acc = $fsql->f("nums");
									list($buysize, $buyprice, $buyspecid) = explode("^",$fsql->f("fz"));
									$tsql->query( "UPDATE {P}_shop_con SET kucun=kucun-{$acc} WHERE id='{$gid}'" );
									if($buyspecid){
										$tsql->query( "UPDATE {P}_shop_conspec SET stocks=stocks-{$acc} WHERE id='{$buyspecid}'" );
									}
								}
						}
						if ( $memberid == "0" )
						{
								$fsql->query( "update {P}_shop_order set ifpay='1',paytime='{$dtime}' where orderid='{$back_orderid}' and paytotal='{$back_fee}'" );
								header( "location:".ROOTPATH."shop/orderpay.php?act=ok&orderid=".$back_orderid );
								exit( );
						}
						else
						{
								$mymemberid = $_COOKIE['MEMBERID']? $_COOKIE['MEMBERID']:$memberid;
								$user = $_COOKIE['MUSER']? $_COOKIE['MUSER']:$name;
								//if ( $mymemberid == $memberid )
								if ( $mymemberid )
								{
										$fsql->query( "update {P}_member set buytotal=buytotal+{$back_fee},paytotal=paytotal+{$back_fee} where memberid='{$memberid}'" );
										$fsql->query( "update {P}_shop_order set ifpay='1',paytime='{$dtime}',iftui='0' where orderid='{$back_orderid}' and paytotal='{$back_fee}'" );
										//因應退貨機制
										$fsql->query( "update {P}_shop_orderitems set iftui='0',ifpay='1' where orderid='{$back_orderid}'" );
										//
										$fsql->query( "insert into {P}_member_buylist set 
											`buyfrom`='{$colname}',
											`memberid`='{$memberid}',
											`orderid`='{$back_orderid}',
											`payid`='{$payid}',
											`paytype`='{$paytype}',
											`paytotal`='{$back_fee}',
											`daytime`='{$dtime}',
											`ip`='{$ip}',
											`OrderNo`='{$OrderNo}',
											`logname`='{$user}'
											" );
										$fsql->query( "insert into {P}_member_pay set 
											`memberid`='{$memberid}',
											`payid`='{$payid}',
											`oof`='{$back_fee}',
											`method`='{$paytype}',
											`type`='訂單付款',
											`addtime`='{$dtime}',
											`ip`='{$ip}',
											`logname`='{$user}'
											" );
										include( ROOTPATH."shop/includes/shop.inc.php" );
										$centopen = $GLOBALS['SHOPCONF']['CentOpen'];
										$centid = $GLOBALS['SHOPCONF']['CentId'];
										$centcol = "cent".$centid;
										if ( $centopen == "1" )
										{
												$fsql->query( "update {P}_member set `".$centcol."`=`".$centcol."`+{$tcent} where memberid='{$memberid}'" );
												$fsql->query( "insert into {P}_member_centlog set 
													`memberid`='{$memberid}',
													`dtime`='{$dtime}',
													`event`='0',
													`memo`='訂單付款',
													`".$centcol."`='{$tcent}'
												" );
										}
										membercentupdate( $memberid, "313" );
										header( "location:".ROOTPATH."shop/orderpay.php?act=ok&orderid=".$back_orderid );
										exit( );
								}
								else
								{
										echo $Meta."支付返回調試錯誤：目前登入的會員和訂單會員身份不符";
										exit( );
								}
						}
				}
				else
				{
						echo $Meta."支付返回調試錯誤：指定的訂單[shop](".$back_orderid.")不存在或訂單資料不匹配";
						exit( );
				}
				break;
		case "member" :
				$msql->query( "select * from {P}_member_onlinepay where id='{$back_orderid}' and paytotal='{$back_fee}'" );
				if ( $msql->next_record( ) )
				{
						$memberid = $msql->f( "memberid" );
						$payid = $msql->f( "payid" );
						$paytype = $msql->f( "paytype" );
						$paytotal = $msql->f( "paytotal" );
						$ifpay = $msql->f( "ifpay" );
						$name = $msql->f( "name" );
						if ( $back_payid != $payid )
						{
								echo $Meta."支付返回調試錯誤：付款方式編號不匹配(可能是同一支付接口存在多條付款方式記錄)";
								exit( );
						}
						if ( $ifpay == "1" )
						{
								echo $Meta."本次充值(".$back_orderid.")已經完成，不能重複送出";
								exit( );
						}
						$mymemberid = $_COOKIE['MEMBERID']? $_COOKIE['MEMBERID']:$memberid;
						$user = $_COOKIE['MUSER']? $_COOKIE['MUSER']:$name;
						if ( $mymemberid == $memberid )
						{
								$fsql->query( "update {P}_member_onlinepay set ifpay='1',backtime='{$dtime}' where id='{$back_orderid}' and paytotal='{$back_fee}'" );
								$fsql->query( "update {P}_member set account=account+{$back_fee},paytotal=paytotal+{$back_fee} where memberid='{$memberid}'" );
								$fsql->query( "insert into {P}_member_pay set 
					`memberid`='{$memberid}',
					`payid`='{$payid}',
					`oof`='{$back_fee}',
					`method`='{$paytype}',
					`type`='帳戶充值',
					`addtime`='{$dtime}',
					`ip`='{$ip}',
					`logname`='{$user}'
					" );
								header( "location:".ROOTPATH."member/member_onlinepay.php?act=ok&payorderid=".$back_orderid );
								exit( );
						}
						else
						{
								echo $Meta."支付返回調試錯誤：目前登入的會員和充值送出時的會員身份不符";
								exit( );
						}
				}
				else
				{
						echo $Meta."支付返回調試錯誤：指定的充值記錄(".$back_orderid.")不存在或充值記錄資料不匹配";
						exit( );
				}
				break;
		default :
				echo $Meta."支付返回調試錯誤：模組原始碼(".$back_coltype.")不可識別";
				exit( );
				break;
		}
}

?>