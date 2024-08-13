<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/ebmail.inc.php" );
include( "language/".$sLan.".php" );
include( "func/member.inc.php" );
include( "func/paper.inc.php" );
include( ROOTPATH."api/xmlapi.php" );
needauth( 0 );

$paperid = $_REQUEST['paperid'];
$step = $_REQUEST['step'];
$sendtype = $_REQUEST['sendtype'];
$cronitems = $_REQUEST['cronitems'];
$sitename = $GLOBALS['GLOBALS']['CONF'][SiteName];

//CPANEL START
$getUser=$GLOBALS["PAPERCONF"]["CpanelUser"];
$ip = $_SERVER["SERVER_ADDR"];
$root_pass = $GLOBALS["PAPERCONF"]["CpanelPasswd"];
$root_port = $GLOBALS["PAPERCONF"]["CpanelPort"];
$xmlapi = new xmlapi($ip);
$xmlapi->password_auth($getUser,$root_pass);
$xmlapi->set_port($root_port);
$xmlapi->set_output('json');
$xmlapi->set_debug(0);
//執行程式寄信通知的信箱，留空則不通知
$args = array ( 'email' => '' ); 
$xmlapi->api2_query($getUser, 'Cron','set_email', $args);
//CPANEL END
//執行程式的路徑
//$command = 'php '.$_SERVER["DOCUMENT_ROOT"].'/cron-job.php'; 
/*$args = array ( 'command' => $command, 
                'day' => '*', 
                'hour' => '*', 
                'minute' => '*', 
                'month' => '*', 
                'weekday' => '*', 
                );*/
//print $xmlapi->api2_query($getUser, 'Cron','add_line', $args);

//列出CRON
//$value = $xmlapi->api2_query($getUser, 'Cron','listcron');

//刪除CRON
//$linekey = "1";
//$args = array ( 'line' => $linekey );
//print $xmlapi->api2_query($getUser, 'Cron','remove_line', $args);

/*$getSubValue=json_decode($value,TRUE);
var_dump($getSubValue["cpanelresult"]["data"]["0"]);*/
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
if ( $step == "send" && $sendtype == "all")
{
	$msql->query( "select body from {P}_paper_con where id='{$paperid}' " );
if ( $msql->next_record( ) ){
				$paperbody = $msql->f( "body" );			
				$paperbody = path2url( $paperbody );
				
}
$fromtitle = htmlspecialchars($_POST['fromtitle']);
	$fromemail = $_POST['fromemail'];
	/*$paperbody = mb_eregi_replace("\r\n","",$paperbody);
	$paperbody = mb_eregi_replace("\r","",$paperbody);
	$paperbody = mb_eregi_replace("\n","",$paperbody);*/
	
	$message = $paperbody;



	//處理寄發目標
	list($tomode,$toobj) = explode("_",$_POST['mambertypeid']);
	
	switch($tomode){
		case "all":
				if($toobj == "ok"){
					$scl = "and is_order='1'";
				}elseif($toobj == "no"){
					$scl = "and is_order='0'";
				}else{
					$scl = "";
				}
			break;
		case "ok":
				if($toobj == "mem"){
					$scl = "and is_member='1' and is_order='1'";
				}elseif($toobj == "notmem"){
					$scl = "and is_member='0' and is_order='1'";
				}else{
					$memtype = $toobj;
					$scl = "and is_member='1' and member_type='{$memtype}' and is_order='1'";
				}
			break;
		case "no":
				if($toobj == "mem"){
					$scl = "and is_member='0' and is_order='0'";
				}elseif($toobj == "notmem"){
					$scl = "and is_member='0' and is_order='0'";
				}else{
					$memtype = $toobj;
					$scl = "and is_member='0' and member_type='{$memtype}' and is_order='0'";
				}
			break;
		default:
					$scl = "";	
	}
	
$allmail = array();
$msql->query( "select order_cat,email from {P}_paper_order where email<>'' {$scl} " );
while( $msql->next_record( ) ){
	$email = $msql->f( "email" );
	$ordercat = $msql->f( "order_cat" );
	$cats = explode(",",$ordercat);
	if($ordercat=="all" || in_array($papercat,$cats)){
		if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		}else{
			$allmail[] = $email;
		}
		/*if(preg_match("/^[A-Za-z0-9\.|-|_]*[@]{1}[A-Za-z0-9\.|-|_]*[.]{1}[a-z]{2,5}$/", $email)){
			$allmail[] = $email;
		}*/
	}
}


$msg = "無電子報信件發送！";
//剔除不願意接受電子報的信箱
//$allmail = array_diff($allmail,$nomail);

			$allmail = array_unique($allmail);
			$allmailcon = count($allmail);
			$nu = floor($allmailcon/99);
			$nu2 = $nu>0? (100*($nu-1))+($allmailcon%99)-($nu+1):($allmailcon%99)-($nu+1);
			//每100封(1主信箱+99密件副本)一次發送
			if($nu>0){
				for($t=0;$t<$nu;$t++){
					unset($bcc);
					$bcc = array();
					$ts = 100*$t;
					for($m=100*$t;$m<99+$ts;$m++){
						$bcc[] = $allmail[$m];
					}
					$toemail = array_shift($bcc);
					ebmails( $toemail, $fromemail, $fromtitle, $message, $bcc, 0);
					$msg = "共發送：".$allmailcon." 封電子報信件！";
				}
			}
			//剩餘未達99封之發送
			$us = $nu>0? 100*($nu-1):"0";
			if($nu2>=$us){
				unset($bccb);
				$bccb = array();
				for($u=100*$nu;$u<=$nu2;$u++){					
					$bccb[] = $allmail[$u];
				}
				$toemail = array_shift($bccb);
				ebmails( $toemail, $fromemail, $fromtitle, $message, $bccb, 0);
				$msg = "共發送：".$allmailcon." 封電子報信件！";
			}

				//echo "<script>parent.\$.unblockUI();parent.\$.blockUI({message:'".$msg."',css:{width:'320px',top:'100px'}});setTimeout(function(){parent.\$.unblockUI()},1500);parent.\$('.blockOverlay').click(parent.\$.unblockUI); </script>";
				exit( $msg );
				
				
}elseif($step == "send" && $sendtype == "cron"){
	#[分批次發送]＃＃＃＃＃＃
	$msql->query( "select body from {P}_paper_con where id='{$paperid}' " );
if ( $msql->next_record( ) ){
				$paperbody = $msql->f( "body" );			
				$paperbody = path2url( $paperbody );
}
	$fromtitle = htmlspecialchars($_POST['fromtitle']);
	$fromemail = $_POST['fromemail'];
	/*$paperbody = str_replace("\r\n","",$paperbody);
	$paperbody = str_replace("\r","",$paperbody);
	$paperbody = str_replace("\n","",$paperbody);*/
	$message = $paperbody;


	//處理寄發目標
	list($tomode,$toobj) = explode("_",$_POST['mambertypeid']);
	
	switch($tomode){
		case "all":
				if($toobj == "ok"){
					$scl = "and is_order='1'";
				}elseif($toobj == "no"){
					$scl = "and is_order='0'";
				}else{
					$scl = "";
				}
			break;
		case "ok":
				if($toobj == "mem"){
					$scl = "and is_member='1' and is_order='1'";
				}elseif($toobj == "notmem"){
					$scl = "and is_member='0' and is_order='1'";
				}else{
					$memtype = $toobj;
					$scl = "and is_member='1' and member_type='{$memtype}' and is_order='1'";
				}
			break;
		case "no":
				if($toobj == "mem"){
					$scl = "and is_member='0' and is_order='0'";
				}elseif($toobj == "notmem"){
					$scl = "and is_member='0' and is_order='0'";
				}else{
					$memtype = $toobj;
					$scl = "and is_member='0' and member_type='{$memtype}' and is_order='0'";
				}
			break;
		default:
					$scl = "";	
	}
	
$allmail = array();
$msql->query( "select order_cat,email from {P}_paper_order where email<>'' {$scl} " );
while( $msql->next_record( ) ){
	$email = $msql->f( "email" );
	$ordercat = $msql->f( "order_cat" );
	$cats = explode(",",$ordercat);
	if($ordercat=="all" || in_array($papercat,$cats)){
		if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		}else{
			$allmail[] = $email;
		}
		/*if(preg_match("/^[A-Za-z0-9\.|-|_]*[@]{1}[A-Za-z0-9\.|-|_]*[.]{1}[a-z]{2,5}$/", $email)){
			$allmail[] = $email;
		}*/
	}
}
			$msg = "無電子報信件發送！";

			$allmail = array_unique($allmail);
			$allmailcon = count($allmail);
			$nu = ceil($allmailcon/$cronitems);
			$dtime=time();
			$ifsend = "1";
			//array_slice 取出一段陣列
			//虛擬網站信箱
			//$fromemail = "".$sitename."<system@donot.replay>";
			$fromemail = $GLOBALS['CONF']['owner_m_mail'];
			//虛擬一個收件人
			$toemail = "".$sitename."會員<members@donot.replay>";
			//寫入批次記錄
			if($nu>0){
				$sendnums = $cronitems < $allmailcon? $cronitems:$allmailcon;
				$msql->query( "INSERT INTO {P}_paper_cron SET pid='{$paperid}',cat='{$fromtitle}',items='{$cronitems}',nums='{$allmailcon}',sendnums='{$sendnums}',dtime='{$dtime}'" );
				$getinto = $msql->instid();
				$np = 0;
				$t = 1;
				for($p=1; $p<=$nu; $p++){
						$bccs = "";
						if($p>1){
							$dtime = "0";
							$ifsend = "0";
							$sendnums = "0";
						}
						if($p==$nu){
							$cronitems = $allmailcon-$np;
						}
						$getbcc = array_slice($allmail,$np,$cronitems);
						//前 $cronitems封，第一次發送
						if($p==1){
							ebmails( $toemail, $fromemail, $fromtitle, $message, $getbcc, 0);
						}
						foreach($getbcc AS $mvs){
							$bccs .= $bccs? ",".$mvs:$mvs;
						}
						$msql->query( "INSERT INTO {P}_paper_cronjobs SET pid='{$getinto}',email='{$bccs}',alltimes='{$nu}',nowtimes='{$t}',ifsend='{$ifsend}',dtime='{$dtime}'" );
						$np = $np + $cronitems;
						$t++;
				}
				
				if($nu>1){
					//執行程式的路徑
					$thisminute = date("i")+1;
					//$thisminute = '*/1';
					$command = 'php '.$_SERVER["DOCUMENT_ROOT"].'/paper/cronjobs/cronjobs_'.$getinto.'.php'; 
					$args = array ( 'command' => $command, 
                		'day' => '*', 
                		'hour' => '*/1', 
                		'minute' => $thisminute, 
                		'month' => '*', 
                		'weekday' => '*', 
                	);
					$value = $xmlapi->api2_query($getUser, 'Cron','add_line', $args);
					$getSubValue=json_decode($value,TRUE);
					$linekey = $getSubValue["cpanelresult"]["data"]["0"]["linekey"];
					$msql->query( "UPDATE {P}_paper_cron SET linekey='{$linekey}' WHERE id='$getinto'" );
				
					@mkdir( "../cronjobs", 0755 );
					$fd = fopen( "../cronjobs/temp.php", "r" );
					$str = fread( $fd, "500000" );
					$str_html = str_replace( "DefaultPID", $getinto, $str );
					$str_html = str_replace( "DefaultSITENAME", $sitename, $str_html );
					fclose( $fd );
					$filename = '../cronjobs/cronjobs_'.$getinto.'.php';
					$fp = fopen( $filename, "w" );
					fwrite( $fp, $str_html );
					fclose( $fp );
					@chmod( $filename, 0664 );
				}else{
					$msql->query( "UPDATE {P}_paper_cron SET ifclose='2' WHERE id='$getinto'" );
				}
				$msg = "已經將 ".$allmailcon." 封電子報信件，分成 ".$nu." 批次，每小時發送！";
			}
			
	
	
	/*echo "<script>parent.\$.unblockUI();parent.\$.blockUI({message:'".$msg."',css:{width:'320px',top:'100px'}});setTimeout(function(){parent.\$.unblockUI()},1500);parent.\$('.blockOverlay').click(parent.\$.unblockUI); </script>";
				exit( );*/
				exit( $msg );

}

$msql->query( "select * from {P}_paper_con where id='{$paperid}' " );
if ( $msql->next_record( ) )
{
				$papertitle = $msql->f( "title" );
				$papercat= $msql->f( "catid" );
				$papermemo= $msql->f( "memo" );
				$papersrc = $msql->f( "src" );
				$paperauthor = $msql->f( "author" );
				$paperuptime = $msql->f( "uptime" );
}
?>
<div class="formzone">
<form method="post" action="paper_email.php">
<div class="namezone" >發送電子報</div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="6">   
    <tr> 
      <td width="125"  align="right">電子報標題 : </td>
      <td  > 
        <input type="text" name="fromtitle" size="66"  class="input" value="<?php echo $papertitle;?>" />
      </td>
    </tr>
    <tr> 
      <td width="125"  align="right">發送目標 : </td>
      <td  ><select name="mambertypeid" >
	<option value='all_ok'>全部訂閱名單(會員/非會員)</option>
	<option value='ok_mem'>---全部訂閱會員</option>	
	<option value='ok_notmem'>---全部訂閱非會員</option>
<?php
$fsql->query( "select * from {P}_member_type" );
while ( $fsql->next_record( ) )
{
				$membertypeid = $fsql->f( "membertypeid" );
				$membertype = $fsql->f( "membertype" );
				echo "<option value='ok_".$membertypeid."'>---訂閱會員類型：".$membertype."</option>";
				$nonetype .= "<option value='no_".$membertypeid."]'>---未訂閱會員類型：".$membertype."</option>";
}
?>
	<option value='all_no'>全部未訂閱名單(會員/非會員)</option>
	<option value='no_mem'>---全部未訂閱會員</option>
	<option value='no_notmem'>---全部未訂閱非會員</option>
	<?php echo $nonetype;?>
		
	<option value='all_all'>全部名單(會員/非會員，不管有無訂閱)</option>
      	</select></td></tr>
<?php
$fsql->query( "select * from {P}_paper_cron where ifclose='0'" );
if ( $fsql->next_record( ) )
{
	echo '<tr> 
      <td width="125"  align="right">寄發方式 : </td>
      <td  ><label><input type="radio" name="sendtype" value="cron" disabled>排程批次寄發</label> <label><input type="radio" name="sendtype" value="all">一次全部寄發</label>  </td></tr>';
    echo '<tr> 
      <td width="125"  align="right">批次參數 : </td>
      <td  >目前仍有排程進行中，無法新增新的寄信排程！</td></tr>';
}else{
	echo '<tr> 
      <td width="125"  align="right">寄發方式 : </td>
      <td  ><label><input type="radio" name="sendtype" value="cron" checked>排程批次寄發</label> <label><input type="radio" name="sendtype" value="all">一次全部寄發</label> </td></tr>';
	echo '<tr> 
      <td width="125"  align="right">批次參數 : </td>
      <td  >系統每小時寄發 <input class="input" name="cronitems" value="200" /> 封信件</td></tr>';
}
?>

</table>
</div>
<div class="adminsubmit">
        <input type="submit" name="Submit" value="發送電子報"  class="button" />
        <input type="hidden" name="paperid" value="<?php echo $paperid;?>" />
		<input type="hidden" name="papercat" value="<?php echo $papercat;?>" />
		<input type="hidden" name="fromemail" value="<?php echo $GLOBALS['CONF']['owner_m_mail'];?>" />
        <input type="hidden" name="step" value="send" />
</div>
</form>
</div>
</body>
</html>