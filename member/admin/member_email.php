<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/ebmail.inc.php" );
include( "language/".$sLan.".php" );
include( "func/member.inc.php" );
needauth( 55 );
$memberid = $_REQUEST['memberid'];
$step = $_REQUEST['step'];
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
if ( $step == "send" )
{
		$toemail = $_POST['toemail'];
		$fromemail = $_POST['fromemail'];
		$fromtitle = $_POST['fromtitle'];
		$message = $_POST['message'];
				
				$mailbody .='<div style="width: 800px; max-width: 100%;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_mem.png" style="width: 800px; max-width: 100%;"></div>';
				$mailbody .='<div style="width: 648px; max-width: 100%; padding:0 75px 50px 77px; "><div style="font-family: 微軟正黑體; font-size:17px; word-break:break-all; display: table;">'.$message.'</div></div>';
				$mailbody .='<div style="width: 800px; max-width: 100%;"><img src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" style="width: 800px; max-width: 100%;"></div>';


		ebmail( $toemail, $fromemail, $fromtitle, $mailbody );
		//$smtext = "孫悟空|".$GLOBALS['GLOBALS']['CONF'][SiteName]."|".time()."|80425584473|線上刷卡|2573|".$GLOBALS['GLOBALS']['CONF'][SiteHttp]."|998532496";
		//shopmail( $toemail, $fromemail, $smtext ,3 );
		
		echo "<script>parent.\$.unblockUI()</script>";
		exit( );
}

$msql->query( "select * from {P}_member where memberid='{$memberid}'" );
if ( $msql->next_record( ) )
{
		$email = $msql->f( "email" );
		$name = $msql->f( "name" );
}
?>
<div class="formzone">
<form method="post" action="member_email.php">
<div class="namezone" ><?php echo $strMemberMailSend; ?></div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="6">
   
    <tr> 
      <td width="125"  align="right"><?php echo $strMemberMailTitle; ?> : </td>
      <td  > 
        <input type="text" name="fromtitle" size="66"  class="input" value="<?php echo $GLOBALS['CONF']['SiteName'].$strMemberMailPub; ?>" />
      </td>
    </tr>
    <tr> 
      <td width="125"  align="right"><?php echo $strMemberMailTo; ?> : </td>
      <td  > 
        <input type="text" name="toemail" size="66" value="<?php echo $name.' <'.$email.'>'; ?>"  class="input" />
      </td>
    </tr>
    <tr> 
      <td width="125"  align="right"><?php echo $strMemberMailCon; ?> : </td>
      <td > 
        <textarea name="message" cols="65" rows="13"  class="textarea"><?php echo $name.$strMemberMailHello."\r\n\r\n\r\n\r\n\r\n\r\n\r\n".$GLOBALS['CONF']['SiteName']."\r\n".$GLOBALS['CONF']['SiteHttp']; ?></textarea>
      </td>
    </tr>
    <tr> 
      <td width="125"  align="right"><?php echo $strMemberMailFrom; ?> : </td>
      <td  > 
        <input type="text" name="fromemail" size="66" value="<?php echo $GLOBALS['CONF']['SiteEmail']; ?>"  class="input" />
      </td>
    </tr>
</table>
</div>
<div class="adminsubmit">
        <input type="submit" name="Submit" value="<?php echo $strMemberMailSD; ?>"  class="button" />
        <input type="hidden" name="memberid" value="<?php echo $memberid; ?>" />
        <input type="hidden" name="step" value="send" />
</div>
</form>
</div>
</body>
</html>