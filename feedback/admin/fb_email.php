<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/ebmail.inc.php" );
include( "language/".$sLan.".php" );

$step = $_REQUEST['step'];
$fid = $_REQUEST['fid'];
$msql->query( "select * from {P}_feedback_info where `id`='{$fid}' limit 0,1" );
if ( $msql->next_record( ) )
{
		$name=$msql->f('name');
		$email=$msql->f('email');
}
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
		$dtime = time();
		
		$msql->query( "INSERT INTO {P}_feedback_bz SET fid='$fid',body='$message',dtime='$dtime'" );
		
		ebmail( $toemail, $fromemail, $fromtitle, $message );
		echo "<script>parent.\$.unblockUI()</script>";
		exit( );
}

$sign = $msql->getone( "select body from {P}_page where id='4'" );
$signature = $sign["body"];
?>
<div class="formzone">
<form method="post" action="fb_email.php">
<div class="namezone" ><?php echo $strMemberMailSend; ?></div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="6">
   
    <tr> 
      <td width="125"  align="right">郵件標題 : </td>
      <td  > 
        <input type="text" name="fromtitle" size="66"  class="input" value="<?php echo $GLOBALS['CONF']['SiteName'].$strMemberMailPub; ?>-表單回覆" />
      </td>
    </tr>
    <tr> 
      <td width="125"  align="right">收件人 : </td>
      <td  > 
        <input type="text" name="toemail" size="66" value="<?php echo $email; ?>"  class="input" />
      </td>
    </tr>
    <tr> 
      <td width="125"  align="right">信件內容 : </td>
      <td > 
        <textarea name="message" cols="65" rows="13"  class="textarea" style="width:680px;height:450px;visibility:hidden;"><?php echo $name." 您好：<br /><br /><br /><br /><br /><br />-------------------------------------<br />".$signature; ?></textarea>

<script type="text/javascript" src="../../kedit/kindeditor-min.js"></script>
		  <script charset="utf-8" src="../../kedit/lang/zh_TW.js"></script>
            
	<script>
		KindEditor.ready(function(K) {
			var editor = K.create('textarea[name="message"]', {
				uploadJson : '../../kedit/php/upload_json.php?attachPath=shop/pics/',
				fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=shop/pics/',
				allowFlashUpload : false,
				allowMediaUpload : false,
				allowFileManager : true,
				langType : 'zh_TW',
				syncType: '',
				afterBlur: function () { editor.sync(); }

			});
			//prettyPrint();
		});
             </script>
      </td>
    </tr>
    <tr> 
      <td width="125"  align="right">寄件人 : </td>
      <td  > 
        <input type="text" name="fromemail" size="66" value="<?php echo $GLOBALS['CONF']['SiteEmail']; ?>"  class="input" />
      </td>
    </tr>
</table>
</div>
<div class="adminsubmit">
        <input type="submit" name="Submit" value="送出信件"  class="button" />
        <input type="hidden" name="fid" value="<?php echo $fid; ?>" />
        <input type="hidden" name="step" value="send" />
</div>
</form>
</div>
</body>
</html>