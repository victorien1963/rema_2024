<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
NeedAuth(310);

/*if( $_COOKIE["SYSUSER"] != "smartfly" ){
	exit("程式撰寫測試中，您尚無權限瀏覽！");
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>

</head>

<body>
<?php
$step=$_REQUEST["step"];
$id=$_REQUEST["id"];
if($step=="del"){
	$msql->query("delete from {P}_shop_promotebuy where id='$id'");
}
?>
<div class="formzone">
<div class="namezone" style="float:left;margin:10px 10px 0px 10px">商品加購設定</div>
<div style="float:right;margin-right:3px;margin-top:5px">
<input type="button" name="Button" value="增加加購設定" class="button" onClick="self.location='shoppromotebuy_modi.php?id=0'" /> 
</div>
<div class="tablezone" style="clear:both;">
<table width="100%" border="0" cellspacing="0" cellpadding="5" >
  <tr> 
    <td class="innerbiaoti" align="center" height="28" width="50" ><?php echo $strNumber; ?></td>
    <td width="200" height="28" class="innerbiaoti" >加購商品標題</td>
    <td width="100" height="28" class="innerbiaoti" >加購折扣</td>
    <td width="200" height="28" class="innerbiaoti" >主商品/加購商品</td>
    <td width="200" height="28" class="innerbiaoti" ><?php echo $strPromoteStar; ?></td>
    <td width="200" height="28" class="innerbiaoti" ><?php echo $strPromoteEnd; ?></td>
    <td class="innerbiaoti" height="28" width="55" ><?php echo $strModify; ?></td>
    <td class="innerbiaoti" height="28" width="55" ><?php echo $strDelete; ?></td>
  </tr>
  <?php 
	$msql -> query ("select * from {P}_shop_promotebuy order by id desc");
	while ($msql -> next_record ()) {
		$id = $msql -> f ('id');
		$name = $msql -> f ('name');
		$startdate = $msql -> f ('startdate');
		$enddate = $msql -> f ('enddate');
		$starttime = $msql -> f ('starttime');
		$endtime = $msql -> f ('endtime');
		$promo_productid = $msql -> f ('promo_productid');
		$promo_productaddid = $msql -> f ('promo_productaddid');
		$promo_money = $msql -> f ('promo_money');
		$promote = $promo_productid."/".$promo_productaddid;
		
			echo '<tr class="list"> 
				<td align="center" height="28" width="50" >'.$id.'</td>
				<td width="200" >'.$name.'</td>
				<td width="100" >NT$.'.$promo_money.'</td>
				<td>'.$promote.'</td>
				<td>'.$startdate.' '.$starttime.'</td>
				<td>'.$enddate.' '.$endtime.'</td>
				<td height="28" width="55" ><img src="images/edit.png"  style="cursor:pointer" onClick="window.location=\'shoppromotebuy_modi.php?id='.$id.'\'"></td>
				<td height="28" width="55" ><img src="images/delete.png"  style="cursor:pointer" onClick="window.location=\'shoppromotebuy.php?step=del&id='.$id.'\'"></td>
				</tr>';
}
?> 
</table>
</div>
</div>
</body>
</html>