<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
NeedAuth(212);

$id=$_REQUEST["id"];

if($_GET["chgstat"]){
	
	$sts = $_GET["chgstat"]=="ok"? "1":"0";

	$fsql->query("update {P}_feedback_info SET stat='$sts' where id='$id'");

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script type="text/javascript" src="js/cattemp.js"></script>
</head>

<body>
<div class="formzone">
<div class="tablezone">

<?php
		trylimit("_feedback_info",30,"id");

		$fsql->query ("select * from {P}_feedback_info where id='$id'");
		if ($fsql -> next_record ()) {
		   $groupid=$fsql->f('groupid');
		   $title=$fsql->f('title');
		   $content=$fsql->f('content');
		   $name=$fsql->f('name');
		   $sex=$fsql->f('sex');
		   $tel=$fsql->f('tel');
		   $address=$fsql->f('address');
		   $email=$fsql->f('email');
		   $url=$fsql->f('url');
		   $qq=$fsql->f('qq');
		   $company=$fsql->f('company');
		   $company_address=$fsql->f('company_address');
		   $zip=$fsql->f('zip');
		   $fax=$fsql->f('fax');
		   $products_id=$fsql->f('products_id');
		   $products_name=$fsql->f('products_name');
		   $products_num=$fsql->f('products_num');
		   $custom1=$fsql->f('custom1');
		   $custom2=$fsql->f('custom2');
		   $custom3=$fsql->f('custom3');
		   $custom4=$fsql->f('custom4');
		   $custom5=$fsql->f('custom5');
		   $custom6=$fsql->f('custom6');
		   $custom7=$fsql->f('custom7');
		   $memberid=$fsql->f('memberid');
		   $ip=$fsql->f('ip');
		   $time=$fsql->f('time');
		   $uptime=$fsql->f('uptime');
		    $nowstat=$fsql->f('stat');
		   $time=date("Y-n-j H:i:s",$time);
		   $uptime=date("Y-n-j H:i:s",$uptime);
			
		   $content=nl2br($content);

		}
		
		

?>


<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#DEEFFA">
<tr> 
<td  width="90" align="right" bgcolor="#F2F9FD"><?php echo $strFeedBackNo; ?>：</td>
<td bgcolor="#FFFFFF"><?php echo $id; ?></td>
</tr>
<tr> 
<td  width="90" align="right" bgcolor="#F2F9FD">目前狀態：</td>
<td bgcolor="#FFFFFF"><?php if($nowstat == "1"){ echo "<span style=\"color:green;\">已處理</span> <a class=\"button\" href=\"look.php?id=".$id."&chgstat=no\">改為未處理</a>"; }else{ echo "<span style=\"color:red;\">未處理</span> <a class=\"button\" href=\"look.php?id=".$id."&chgstat=ok\">改為已處理</a>"; } ?></td>
</tr>

<tr> 
<td  width="90" align="right" bgcolor="#F2F9FD"><?php echo $strFormTime; ?>：</td>
<td bgcolor="#FFFFFF"  ><?php echo $time; ?> &nbsp; [IP: <?php echo $ip; ?>] </td>
</tr>
<?php
$msql -> query ("select field_caption,field_name from {P}_feedback where groupid='$groupid' and use_field = '1' order by xuhao");
while ($msql -> next_record ()) {
$field_caption = $msql -> f ('field_caption');
$field_name = $msql -> f ('field_name');
if(preg_match("/^[A-Za-z0-9\.|-|_]*[@]{1}[A-Za-z0-9\.|-|_]*[.]{1}[a-z]{2,5}$/", ${$field_name})){
		$sendmail = ' <img id="membermail_'.$id.'" class="membermail" src="../../member/admin/images/mail.png" border="0" style="cursor:pointer;">';
		}else{
			$sendmail = "";
		}

?>
<tr> 
<td  width="90" align="right" bgcolor="#F2F9FD"><?php echo $field_caption; ?>：</td>
<td bgcolor="#FFFFFF"><?php echo ${$field_name}.$sendmail; ?></td>
</tr>
<?php
}
?>
</table>
  <br />
  <table width="60%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CDE6FF">
  <tr>
    <td height="23" align="center" bgcolor="#F2F9FD">回覆紀錄</td>
    <td width="180" height="23" align="center" bgcolor="#F2F9FD" >時間</td>
    </tr>
 
<?php
$msql->query( "select * from {P}_feedback_bz where fid='{$id}'" );
while ( $msql->next_record( ) )
{
		$dtime = date("Y-m-d H:i:s",$msql->f( "dtime" ));
		$body = nl2br($msql->f( "body" ));
		echo "<tr>
    <td height=\"25\" class=\"biaoti\" style='background:#fff;'>".$body."</td>
    <td width=\"180\" height=\"25\" class=\"biaoti\"  align=\"center\" style='background:#fff;'>".$dtime."</td>
    </tr>";
}
?>
</table>
</div>
</div>

</body>
</html>
