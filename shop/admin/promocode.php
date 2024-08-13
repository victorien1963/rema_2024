<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
NeedAuth(310);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script type="text/javascript" src="js/promo.js"></script>
</head>

<body>
<?php
$step=$_REQUEST["step"];
$id=$_REQUEST["id"];
if($step=="del"){
	$msql->query("delete from {P}_shop_promocode where id='$id'");
}
?>
<div class="formzone">
<div class="namezone" style="float:left;margin:10px 10px 0px 10px">商品折價設定</div>
<div style="float:right;margin-right:3px;margin-top:5px">
<input type="button" name="Button" value="<?php echo $strPromoAdd; ?>" class="button" onClick="self.location='promocode_modi.php?id=0'" /> 
</div>
<div class="tablezone" style="clear:both;">
<table width="100%" border="0" cellspacing="0" cellpadding="5" >
  <tr> 
    <td class="innerbiaoti" align="center" height="28" width="50" ><?php echo $strNumber; ?></td>
    <td width="120" height="28" class="innerbiaoti" ><?php echo $strPromoCode; ?></td>
    <td width="80" height="28" class="innerbiaoti" ><?php echo $strPromoType; ?></td>
    <td width="80" height="28" class="innerbiaoti" ><?php echo $strPromoValue; ?></td>
    <td width="120" height="28" class="innerbiaoti" ><?php echo $strPromoTimes.$strPromoTimes2; ?></td>
    <td width="120" height="28" class="innerbiaoti" ><?php echo $strPromoPerTimes; ?></td>
    <!--<td width="120" height="28" class="innerbiaoti" ><?php echo $strPromoShopCat; ?></td>
    <td width="120" height="28" class="innerbiaoti" ><?php echo $strPromoShopId; ?></td>-->
    <td width="120" height="28" class="innerbiaoti" ><?php echo $strPromoMemberTypeId; ?></td>
    <td width="120" height="28" class="innerbiaoti" ><?php echo $strPromoMemberId; ?></td>
    <td width="120" height="28" class="innerbiaoti" ><?php echo $strPromoMemberReg; ?></td>
    <td width="200" height="28" class="innerbiaoti" ><?php echo $strPromoStart; ?></td>
    <td width="200" height="28" class="innerbiaoti" ><?php echo $strPromoEnd; ?></td>
    <td width="120" height="28" class="innerbiaoti" ><?php echo $strPromoMail; ?></td>
    <td class="innerbiaoti" height="28" width="55" ><?php echo $strModify; ?></td>
    <td class="innerbiaoti" height="28" width="55" ><?php echo $strDelete; ?></td>
  </tr>
  <?php 

	$msql -> query ("select * from {P}_shop_promocode order by id desc");
	while ($msql -> next_record ()) {
		$id = $msql -> f ('id');
		$type = $msql -> f ('type');
		$type_value = $msql -> f ('type_value');
		$code = $msql -> f ('code');
		$times = $msql -> f ('times');
		$pertimes = $msql -> f ('pertimes');
		$shopcat = $msql -> f ('shopcat');
		$shopid = $msql -> f ('shopid');
		$membertypeid = $msql -> f ('membertypeid');
		$memberid = $msql -> f ('memberid');
		$memberreg = $msql -> f ('memberreg');
		$starttime = $msql -> f ('starttime')? date("Y-m-d",$msql -> f ('starttime')):"";
		$endtime = $msql -> f ('endtime')? date("Y-m-d",$msql -> f ('endtime')):"";
		$ismail = $msql -> f ('ismail');
		$used_times = $msql -> f ('used_times');
		if($type == 1){
			$promote = "<span style=\"color:red;\">折價金</span>";
			$pp = " 元";
		}else{
			$promote = "<span style=\"color:blue;\">折扣%</span>";
			$pp = " 折";
		}
		if($ismail == 1){
			$mailbt = "";
		}else{
			$mailbt = '<img src="images/mail.png"  class="promomail" style="cursor:pointer" id=\'promomail_'.$id.'\'">';
		}
		$membertype = $fsql->getone( "select membertype from {P}_member_type where membertypeid='$membertypeid'" );

			echo '<tr class="list"> 
				<td align="center" height="28" width="50" >'.$id.'</td>
				<td width="120" >'.$code.'</td>
				<td width="80" >'.$promote.'</td>
				<td width="80" >'.$type_value.$pp.'</td>
				<td width="120" >'.$times.'/'.$used_times.'</td>
				<td width="120" >'.$pertimes.'</td>
				<!--<td width="120" >'.$shopcat.'</td>
				<td width="120" >'.$shopid.'</td>-->
				<td width="120" >'.$membertype[membertype].'</td>
				<td width="120" >'.$memberid.'</td>
				<td width="120" >';
					showyn( $memberreg );
				echo '</td>
				<td>'.$startdate.' '.$starttime.'</td>
				<td>'.$enddate.' '.$endtime.'</td>
				<td width="120" >'.$mailbt.'</td>
				<td height="28" width="55" ><img src="images/edit.png"  style="cursor:pointer" onClick="window.location=\'promocode_modi.php?id='.$id.'\'"></td>
				<td height="28" width="55" ><img src="images/delete.png"  style="cursor:pointer" onClick="window.location=\'promocode.php?step=del&id='.$id.'\'"></td>
				</tr>';
}
?> 
</table>
</div>
</div>
</body>
</html>