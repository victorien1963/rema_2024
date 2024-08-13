<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include_once(ROOTPATH."includes/pages.inc.php");
include("language/".$sLan.".php");
NeedAuth(313);

$tp=$_REQUEST["tp"];
$tempstatus=$_REQUEST["tempstatus"];
$tempcontent=$_REQUEST["tempcontent"];
$tempsubject=$_REQUEST["tempsubject"];

if($tp == "temp"){
	$um=1;
	while($um<=7){		
	$msql -> query ("update {P}_shop_mailtemp set 
		status = '{$tempstatus[$um]}',
		fix_content = '{$tempcontent[$um]}',
		subject = '{$tempsubject[$um]}'
		where tid = '{$um}'
		");
		$um++;
	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script language="javascript" src="js/sm.js"></script>
<style>
.tablezone td{border-bottom:0px #ccc solid;}
</style>
</head>
<body>
<div class="formzone">
<div class="tablezone">
    <?php
	
	$msql -> query("SELECT * FROM {P}_shop_mailtemp");
	while ($msql -> next_record ()) {
		$tid = $msql -> f ('tid');
		$fix_content = $msql -> f ('fix_content');
		$ori_content = $msql -> f ('content');
		
		$content = $fix_content? $fix_content:$ori_content;
		
		$status = $msql -> f ('status');
		
		$gettemp[$tid][content] = "<textarea name=\"tempcontent[".$tid."]\" rows=\"8\" cols=\"58\">".$content."</textarea>";
		$gettemp[$tid][status] = $status? "checked":"";
		$gettemp[$tid][subject] = $msql -> f ('subject');
		
	}		
	?> 

<form method="post" action="mail_temp.php">
		
	<div class="namezone"><input type="checkbox" name="tempstatus[1]" value="1" <?php echo $gettemp[1][status]; ?>><?php echo $strUse; ?>：<?php echo $strSmPay; ?></div>
	<div class="tablezone">
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
			<tr> 
				<td class="innerbiaoti" colspan="2" height="25"><?php echo $strSubject; ?>：<input type="text" name="tempsubject[1]" value="<?php echo $gettemp[1][subject]; ?>" size="65"/></td>
			</tr>
    		<tr> 
      		<td class="innerbiaoti" height="25"><?php echo $gettemp[1][content]; ?></td>
      		<td class="innerbiaoti" width="100%" height="25">
      	{member_name}:替代為會員姓名<br/>
      	{site_name}:替代為網站名稱<br/>
      	{site_url}:替代為網站網址<br/>
      	{order_no}:替代為訂單編號<br/>
      	{pay_total}:替代為付/退款金額</td>
      		</tr>
  		</table>
	</div>
		
	<div class="namezone"><input type="checkbox" name="tempstatus[2]" value="1" <?php echo $gettemp[2][status]; ?>><?php echo $strUse; ?>：<?php echo $strSmExp; ?></div>
	<div class="tablezone">
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
			<tr> 
				<td class="innerbiaoti" colspan="2" height="25"><?php echo $strSubject; ?>：<input type="text" name="tempsubject[2]" value="<?php echo $gettemp[2][subject]; ?>" size="65"/></td>
			</tr>
    		<tr> 
      		<td class="innerbiaoti" height="25"><?php echo $gettemp[2][content]; ?></td>
      		<td class="innerbiaoti" width="100%" height="25">
      	{member_name}:替代為會員姓名<br/>
      	{site_name}:替代為網站名稱<br/>
      	{site_url}:替代為網站網址<br/>
      	{order_no}:替代為訂單編號<br/>
      	{pay_total}:替代為付/退款金額</td>
      		</tr>
  		</table>
	</div>
		
	<div class="namezone"><input type="checkbox" name="tempstatus[3]" value="1" <?php echo $gettemp[3][status]; ?>><?php echo $strUse; ?>：<?php echo $strSmRefund; ?></div>
	<div class="tablezone">
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
			<tr> 
				<td class="innerbiaoti" colspan="2" height="25"><?php echo $strSubject; ?>：<input type="text" name="tempsubject[3]" value="<?php echo $gettemp[3][subject]; ?>" size="65"/></td>
			</tr>
    		<tr> 
      		<td class="innerbiaoti" height="25"><?php echo $gettemp[3][content]; ?></td>
      		<td class="innerbiaoti" width="100%" height="25">
      	{member_name}:替代為會員姓名<br/>
      	{site_name}:替代為網站名稱<br/>
      	{site_url}:替代為網站網址<br/>
      	{order_no}:替代為訂單編號<br/>
      	{pay_total}:替代為付/退款金額</td>
      		</tr>
  		</table>
	</div>
				
	<div class="namezone"><input type="checkbox" name="tempstatus[4]" value="1" <?php echo $gettemp[4][status]; ?>><?php echo $strUse; ?>：<?php echo $strSmTui; ?></div>
	<div class="tablezone">
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
			<tr> 
				<td class="innerbiaoti" colspan="2" height="25"><?php echo $strSubject; ?>：<input type="text" name="tempsubject[4]" value="<?php echo $gettemp[4][subject]; ?>" size="65"/></td>
			</tr>
    		<tr> 
      		<td class="innerbiaoti" height="25"><?php echo $gettemp[4][content]; ?></td>
      		<td class="innerbiaoti" width="100%" height="25">
      	{member_name}:替代為會員姓名<br/>
      	{site_name}:替代為網站名稱<br/>
      	{site_url}:替代為網站網址<br/>
      	{order_no}:替代為訂單編號<br/>
      	{pay_total}:替代為付/退款金額</td>
      		</tr>
  		</table>
	</div>
				
	<div class="namezone"><input type="checkbox" name="tempstatus[5]" value="1" <?php echo $gettemp[5][status]; ?>><?php echo $strUse; ?>：<?php echo $strSmOrder; ?></div>
	<div class="tablezone">
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
			<tr> 
				<td class="innerbiaoti" colspan="2" height="25"><?php echo $strSubject; ?>：<input type="text" name="tempsubject[5]" value="<?php echo $gettemp[5][subject]; ?>" size="65"/></td>
			</tr>
    		<tr> 
      		<td class="innerbiaoti" height="25"><?php echo $gettemp[5][content]; ?></td>
      		<td class="innerbiaoti" width="100%" height="25">
      	{member_name}:替代為會員姓名<br/>
      	{site_name}:替代為網站名稱<br/>
      	{site_url}:替代為網站網址<br/>
      	{order_no}:替代為訂單編號<br/>
      	{pay_total}:替代為付/退款金額</td>
      		</tr>
  		</table>
	</div>
		
	<div class="namezone"><input type="checkbox" name="tempstatus[6]" value="1" <?php echo $gettemp[6][status]; ?>><?php echo $strUse; ?>：<?php echo $strSmOrder; ?></div>
	<div class="tablezone">
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
			<tr> 
				<td class="innerbiaoti" colspan="2" height="25"><?php echo $strSubject; ?>：<input type="text" name="tempsubject[6]" value="<?php echo $gettemp[6][subject]; ?>" size="65"/></td>
			</tr>
    		<tr> 
      		<td class="innerbiaoti" height="25"><?php echo $gettemp[6][content]; ?></td>
      		<td class="innerbiaoti" width="100%" height="25">
      	{member_name}:替代為會員姓名<br/>
      	{site_name}:替代為網站名稱<br/>
      	{site_url}:替代為網站網址<br/>
      	{order_no}:替代為訂單編號<br/>
      	{pay_type}:替代為退貨商品<br/>
      	{pay_total}:替代為付/退款金額</td>
      		</tr>
  		</table>
	</div>
				
	<div class="namezone"><input type="checkbox" name="tempstatus[7]" value="1" <?php echo $gettemp[7][status]; ?>><?php echo $strUse; ?>：<?php echo $strSmOrder; ?></div>
	<div class="tablezone">
		<table width="100%" border="0" cellpadding="5" cellspacing="0">
			<tr> 
				<td class="innerbiaoti" colspan="2" height="25"><?php echo $strSubject; ?>：<input type="text" name="tempsubject[7]" value="<?php echo $gettemp[7][subject]; ?>" size="65"/></td>
			</tr>
    		<tr> 
      		<td class="innerbiaoti" height="25"><?php echo $gettemp[7][content]; ?></td>
      		<td class="innerbiaoti" width="100%" height="25">
      	{member_name}:替代為會員姓名<br/>
      	{site_name}:替代為網站名稱<br/>
      	{site_url}:替代為網站網址<br/>
      	{order_no}:替代為訂單編號<br/>
      	{pay_type}:替代為退貨商品<br/>
      	{pay_total}:替代為付/退款金額</td>
      		</tr>
  		</table>
	</div>
				
	<input type="hidden" name="tp" value="temp">
	<input type="submit" name="Submit" value="<?php echo $strModify; ?>" class="button" />
</form>
	
</div><script src="../../base/admin/assets/js/plugins/iframeautoheight/iframeResizer.contentWindow.min.js"></script>
</body></html>