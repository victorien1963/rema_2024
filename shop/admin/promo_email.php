<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/ebmail.inc.php" );
include( "language/".$sLan.".php" );
include( "func/member.inc.php" );

$promoid = $_REQUEST['promoid'];
$step = $_REQUEST['step'];
$membertypeid = $_REQUEST['membertypeid']
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle;?></title>
</head>
<body>
<?php
if ( $step == "send" )
{
	$msql->query( "select code,mail_temp from {P}_shop_promocode where id='{$promoid}' " );
if ( $msql->next_record( ) ){
				$code = $msql->f( "code" );
				$mail_temp = $msql->f("mail_temp");
}
	$fromtitle = htmlspecialchars($_POST['fromtitle']);
	$fromemail = $_POST['fromemail'];
	/*$mail_temp = str_replace("\r\n","",$mail_temp);
	$mail_temp = str_replace("\r","",$mail_temp);
	$mail_temp = str_replace("\n","",$mail_temp);*/
	$message = $mail_temp;

	
	$mailbody = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head>';
	$mailbody .='<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body bgcolor="#ffffff">';
	$mailbody .='<table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="800">';
	$mailbody .='<tr><td><img name="n1_r1_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_discount.png" width="800" height="208" alt=""></td></tr>';
	$mailbody .='<tr><td width="100%" valign="top" style="padding:0px;">';
	$mailbody .='<table width="800" border="0" align="left" cellpadding="0" cellspacing="0"><tr><td width="80" height="250">&nbsp;</td>';
	$mailbody .='<td width="400" style="font-family:\'微軟正黑體\',Century Gothic;vertical-align: top;font-size:17px;">'.$message.'</td><td width="80">&nbsp;</td>';
	$mailbody .='<td style="vertical-align: top;"><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_right_order.png"></td></tr></table>';
	$mailbody .='</td></tr><tr><td><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" width="800" height="240" alt=""></td></tr></table>';
	$mailbody .='</body></html>';

$allmail=array();
$msql->query( "select user,email from {P}_member where email<>'' and  membertypeid='$membertypeid'" );
while( $msql->next_record( ) ){
	$user = $msql->f( "user" );
	$email = $msql->f( "email" )? $msql->f( "email" ):$user;
	

		if(preg_match("/^[A-Za-z0-9\.|-|_]*[@]{1}[A-Za-z0-9\.|-|_]*[.]{1}[a-z]{2,5}$/", $email)){
			$allmail[] = $email;
		}	

}
$msg = "無電子折價券信件發送！";

			$allmailcon = count(array_unique($allmail));
			$nu = floor($allmailcon/99);
			$nu2 = $nu>0? (100*($nu-1))+($allmailcon%99)-($nu+1):($allmailcon%99)-($nu+1);
			//每100封(1主信箱+99密件副本)一次發送
			if($nu>0){
				for($t=0;$t<$nu;$t++){
					unset($bcc);
					$bcc = array();
					list($_nouse, $nore) = explode("@",$GLOBALS['CONF']['SiteEmail']);
					$bcc[] = "no-replay@".$nore;
					$ts = 100*$t;
					for($m=100*$t;$m<99+$ts;$m++){
						$bcc[] = $allmail[$m];
					}
					$toemail = array_shift($bcc);
					ebmail( $toemail, $fromemail, $fromtitle, $mailbody, $bcc );
					$msg = "共發送：".$allmailcon." 封電子折價券信件！";
				}
			}
			//剩餘未達99封之發送
			$us = $nu>0? 100*($nu-1):"0";
			if($nu2>=$us){
				unset($bccb);
				$bccb = array();
				list($_nouse, $nore) = explode("@",$GLOBALS['CONF']['SiteEmail']);
				$bccb[] = "no-replay@".$nore;
				for($u=100*$nu;$u<=$nu2;$u++){					
					$bccb[] = $allmail[$u];
				}
				$toemail = array_shift($bccb);
				ebmail( $toemail, $fromemail, $fromtitle, $mailbody, $bccb );
				$msg = "共發送：".$allmailcon." 封電子折價券信件！";
			}
			

				echo "<script>parent.\$.unblockUI();parent.\$.blockUI({message:'".$msg."',css:{width:'320px',top:'100px'}});setTimeout(\"parent.\$.unblockUI()\",1500);</script>";
				exit( );
}
?>

<div class="formzone">
<form method="post" action="promo_email.php">
<div class="namezone" >發送電子折價券</div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="6">   
    <tr> 
      <td width="125"  align="right">發送目標 : </td>
      <td  ><select name="membertypeid" >
<?php
$fsql->query( "select * from {P}_member_type" );
while ( $fsql->next_record( ) )
{
				$membertypeid = $fsql->f( "membertypeid" );
				$membertype = $fsql->f( "membertype" );
				echo "<option value='".$membertypeid."'>會員類型：".$membertype."</option>";
}
?>
      	</select></td>
    </tr>
</table>
</div>
<div class="adminsubmit">
        <input type="submit" name="Submit" value="發送電子折價券"  class="button" />
        <input type="hidden" name="fromtitle" value="<?php echo $GLOBALS['CONF'][SiteName];?>-電子折價券" />
		<input type="hidden" name="promoid" value="<?php echo $promoid;?>" />
		<input type="hidden" name="fromemail" value="<?php echo $GLOBALS['CONF']['SiteEmail'];?>" />
        <input type="hidden" name="step" value="send" />
</div>
</form>
</div>
</body>
</html>