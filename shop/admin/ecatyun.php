<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/query.inc.php" );
include( ROOTPATH."includes/ebmail.inc.php" );

$get_orderid = $_POST["orderid"];
$get_yunid = $_POST["yunid"];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle;?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
</head>
<body>

<?php
if(!isset($_FILES["file"]) && !isset($get_orderid)){
	//上傳檔案
?>
<div class="formzone">
	<div class="namezone">匯入新竹物流托運單檔案</div>
	<div class="tablezone">
		<form method="post" action="ecatyun.php" method="post" enctype="multipart/form-data" >
			<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
				<tr>
					<td class="innerbiaoti">匯入檔案：<input type="file" name="file" class="input"> <input type="submit" class="button" value="送出檔案"></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<?php
}elseif($get_orderid == ""){
//匯入貨運單號
$get_yunfile = $_FILES["file"];

if(0 < $get_yunfile['size']){
	
	$csvfile = fopen($get_yunfile['tmp_name'],"r");
	$e = 0;
	echo "<pre>";
	while(!feof($csvfile)){
	    	$getdata = __fgetcsv($csvfile,true);
	    	foreach($getdata AS $kk=>$vv){
	    		$get[$kk] = str_replace('="','',$vv);
	    		$getdata[$kk] = str_replace('"','',$get[$kk]);
	    	}
	    	$getdata[2] = $getdata[2]!=""? $getdata[2]:'無資料';
	    	/*$getdata[3] = $getdata[3]!=""? substr($getdata[3],1):'無資料';
	    	$lists .= isset($lists)? '
	    		<tr>
					<td class="innerbiaoti" width="180"><input type="text" class="input" name="orderid[]" value="'.$getdata[2].'"></td>
					<td class="innerbiaoti" width="180"><input type="text" class="input" name="yunid[]" value="'.$getdata[3].'"></td>
					<td class="innerbiaoti">'.$getdata[7].'</td>
					<td class="innerbiaoti">'.$getdata[4].'</td>
				</tr>':'';*/
			
			//新竹專用
			$getdata[14] = $getdata[14]!=""? $getdata[14]:'無資料';
	    	$lists .= isset($lists) && $getdata[2]!='無資料'? '
	    		<tr>
					<td class="innerbiaoti" width="180"><input type="text" class="input" name="orderid[]" value="'.$getdata[2].'"></td>
					<td class="innerbiaoti" width="180"><input type="text" class="input" name="yunid[]" value="'.$getdata[15].'"></td>
					<td class="innerbiaoti">'.$getdata[12].'</td>
					<td class="innerbiaoti">'.$getdata[17].'</td>
				</tr>':'';
	}
	echo "</pre>";
	fclose($csvfile);
}
?>
<div class="formzone" style="text-align: center;">
	<div class="namezone" style="text-align: left;">檔案內容列表</div>
	<form method="post" action="ecatyun.php" method="post" enctype="multipart/form-data" >
		<div class="tablezone">
			<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
				<tr>
					<td class="innerbiaoti" style="text-align: left;">訂單號碼</td>
					<td class="innerbiaoti" style="text-align: left;">托運單號</td>
					<td class="innerbiaoti">訂購人</td>
					<td class="innerbiaoti">代收金額</td>
				</tr>
				<?php echo $lists; ?>
			</table>
		</div>
	
		<input type="submit" class="button" value="匯入托運單號至各訂單">
	</form>
</div>
	
<?php
}else{
	//匯入完畢
	foreach($get_orderid AS $kk => $vv){
		if($vv != "無資料" && $vv != ""){
			//$msql->query("UPDATE {P}_shop_order SET sendtypeno='1|{$get_yunid[$kk]}' WHERE OrderNo='{$vv}'");
			$msql->query("UPDATE {P}_shop_order SET sendtypeno='4|{$get_yunid[$kk]}' WHERE OrderNo='{$vv}'");
			/*$nowt = time();
			$msql->query("UPDATE {P}_shop_order SET sendtypeno='4|{$get_yunid[$kk]}',ifyun='1',yuntime='{$nowt}' WHERE OrderNo='{$vv}'");
			$getid = $msql->getone("SELECT orderid FROM {P}_shop_order WHERE OrderNo='{$vv}'");
			$getorderid = $getid["orderid"];
			$msql->query("UPDATE {P}_shop_orderitems SET ifyun='1',yuntime='{$nowt}' WHERE orderid='{$getorderid}'");*/
			//寄發發貨信件
			/*$fsql->query( "SELECT * FROM {P}_shop_order WHERE OrderNo='{$vv}' AND yun_mail='0'" );
			if( $fsql->next_record() ){					
				$memname = $fsql->f("name");
				$membermail = $fsql->f("email");
				$OrderNo = $vv;
				$paytype = $fsql->f("paytype");
				$paytotal = $fsql->f("paytotal");
				list($yuntype,$yun_no) = explode("|",$fsql->f("sendtypeno"));
				
				$yun_no = $yun_no."^".$strSend[$yuntype]."^".$strSendAPI[$yuntype];
				$msql->query( "SELECT * FROM {P}_shop_mailtemp WHERE tid='2' AND status='1'");//§쩺¼˪O
					if($msql->next_record()){
				$smsg = $memname."|".$GLOBALS['GLOBALS']['CONF'][SiteName]."|".time()."|".$OrderNo."|".$paytype."|".$paytotal."|".$GLOBALS['GLOBALS']['CONF'][SiteHttp]."|".$yun_no;
				$from = $GLOBALS['GLOBALS']['CONF'][SiteEmail];
				shopmail( $membermail, $from, $smsg, "2" );							
					}
				$msql->query("UPDATE {P}_shop_order SET yun_mail='1' WHERE OrderNo='{$vv}'");
			}*/
		}else{
			$errlist .= $errlist? "<br>托運單號[ ".$get_yunid[$kk]." ]缺少網站訂單號":"托運單號[ ".$get_yunid[$kk]." ]缺少網站訂單號";
		}
	}
	
?>
<div class="formzone" style="text-align: center;">
	<div class="namezone" style="text-align: left;">匯入完畢</div>
		<div class="tablezone">
			<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
				<tr>
					<td class="innerbiaoti" style="text-align: left;">資料匯入完畢。</td>
				</tr>
				<tr>
					<td style="text-align: left;"><?php echo $errlist; ?></td>
				</tr>
			</table>
		</div>
</div>

<?php
}
?>
	</body>
</html>