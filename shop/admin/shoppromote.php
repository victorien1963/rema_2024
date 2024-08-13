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
	$msql->query("delete from {P}_shop_promote where id='$id'");
}
?>
<div class="formzone">
<div class="namezone" style="float:left;margin:10px 10px 0px 10px">商品促銷設定</div>
<div style="float:right;margin-right:3px;margin-top:5px">
<input type="button" name="Button" value="<?php echo $strShopPromoteAdd; ?>" class="button" onClick="self.location='shoppromote_modi.php?id=0'" /> 
</div>
<div class="tablezone" style="clear:both;">
<table width="100%" border="0" cellspacing="0" cellpadding="5" >
  <tr> 
    <td class="innerbiaoti" align="center" height="28" width="50" ><?php echo $strNumber; ?></td>
    <td width="150" height="28" class="innerbiaoti" ><?php echo $strPromoteCate; ?></td>
    <td width="200" height="28" class="innerbiaoti" ><?php echo $strPromoteName; ?></td>
    <td width="100" height="28" class="innerbiaoti" ><?php echo $strPromoteAmount; ?></td>
    <td width="200" height="28" class="innerbiaoti" ><?php echo $strPromoteType; ?></td>
    <td width="200" height="28" class="innerbiaoti" ><?php echo $strPromoteStar; ?></td>
    <td width="200" height="28" class="innerbiaoti" ><?php echo $strPromoteEnd; ?></td>
    <td class="innerbiaoti" height="28" width="55" ><?php echo $strModify; ?></td>
    <td class="innerbiaoti" height="28" width="55" ><?php echo $strDelete; ?></td>
  </tr>
  <?php 
    $msql -> query ("select * from {P}_shop_promotegroup");
	$t=1;
	while ($msql -> next_record ()) {
		$getGroupName[$t] = $msql->f('groupname');
		$t++;
	}
	$msql -> query ("select * from {P}_shop_promote order by id desc");
	while ($msql -> next_record ()) {
		$id = $msql -> f ('id');
		$groupid = $msql -> f ('groupid');
		$name = $msql -> f ('name');
		$promo_amount =  $msql -> f ('promo_amount');
		$startdate = $msql -> f ('startdate');
		$enddate = $msql -> f ('enddate');
		$starttime = $msql -> f ('starttime');
		$endtime = $msql -> f ('endtime');
		$promo_codeid = $msql -> f ('promo_codeid');
		$promo_productid = $msql -> f ('promo_productid');
		$promo_money = $msql -> f ('promo_money');
		$range_add = $msql -> f ('range_add');
		
		if($groupid == 1){
			$fsql->query ("select title from {P}_shop_con where id='$promo_productid'");
			if($fsql -> next_record ()){
				$promote = "<span style=\"color:red;\">".$fsql->f('title')."</span>";
			}
		}elseif($groupid == 2){
				$promo_money = $range_add? $promo_money." (級距折價)":$promo_money;
				$promote = "<span style=\"color:red;\">折價 NT$. ".$promo_money."</span>";
		}elseif($groupid == 3){
			$fsql->query ("select code from {P}_shop_promocode where id='$promo_codeid'");
			if($fsql -> next_record ()){
				$promote = "<span style=\"color:red;\">".$fsql->f('code')."</span>";
			}
		}
			echo '<tr class="list"> 
				<td align="center" height="28" width="50" >'.$id.'</td>
				<td width="150" >'.$getGroupName[$groupid].'</td>
				<td width="200" >'.$name.'</td>
				<td width="100" >NT$.'.$promo_amount.'</td>
				<td>'.$promote.'</td>
				<td>'.$startdate.' '.$starttime.'</td>
				<td>'.$enddate.' '.$endtime.'</td>
				<td height="28" width="55" ><img src="images/edit.png"  style="cursor:pointer" onClick="window.location=\'shoppromote_modi.php?id='.$id.'\'"></td>
				<td height="28" width="55" ><img src="images/delete.png"  style="cursor:pointer" onClick="window.location=\'shoppromote.php?step=del&id='.$id.'\'"></td>
				</tr>';
}
?> 
</table>
</div>
</div>
</body>
</html>