<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/pages.inc.php" );
include( "language/".$sLan.".php" );
include( "func/paper.inc.php" );
include( ROOTPATH."api/xmlapi.php" );
needauth( 0 );

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

$step = $_REQUEST['step'];
$page = $_REQUEST['page'];
$sc = $_REQUEST['sc'];
$ord = $_REQUEST['ord'];
$membertypeid = $_REQUEST['membertypeid'];
$memberid = $_REQUEST['memberid'];
$key = $_REQUEST['key'];
$user = $_REQUEST['user'];
$shownum = $_REQUEST['shownum'];
$showcheck = $_REQUEST['showcheck'];
$showrz = $_REQUEST['showrz'];
$newtypeid = $_REQUEST['newtypeid'];
$searchmodle = $_REQUEST['searchmodle'];

if ( !isset( $shownum ) || $shownum < 10 )
{
		$shownum = 10;
}
if ( !isset( $searchmodle ) || $searchmodle == "" )
{
		$searchmodle = "common";
}

/*$pid = 1067;
$msql->query( "SELECT b.*,b.id as bid,p.pid as ppid FROM {P}_paper_cronjobs b LEFT JOIN {P}_paper_cron p ON b.pid=p.id WHERE b.pid='$pid' and b.ifsend='1'" );
while ( $msql->next_record( ) ){
			$totalemail .= $totalemail? ",".$msql->f( "email" ):$msql->f( "email" );
}

$totalemails = explode(",",$totalemail);
$alle = count($totalemails);

//echo "共有".$alle."封信件";

foreach($totalemails AS $eee){
	echo $eee."<br />";
}*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="../../base/js/form.js"></script>
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script type="text/javascript" src="js/paper.js"></script>
<title><?php echo $strAdminTitle; ?></title>
<SCRIPT>
function ordsc(nn,sc){
if(nn!='<?php echo $ord; ?>'){
	window.location='member_common.php?page=<?php echo $page; ?>&sc=<?php echo $sc; ?>&shownum=<?php echo $shownum; ?>&showcheck=<?php echo $showcheck; ?>&showrz=<?php echo $showrz; ?>&membertypeid=<?php echo $membertypeid; ?>&searchmodle=<?php echo $searchmodle; ?>&ord='+nn;
}else{
	if(sc=='asc' || sc==''){
	window.location='member_common.php?page=<?php echo $page; ?>&shownum=<?php echo $shownum; ?>&showcheck=<?php echo $showcheck; ?>&showrz=<?php echo $showrz; ?>&sc=desc&membertypeid=<?php echo $membertypeid; ?>&searchmodle=<?php echo $searchmodle; ?>&ord='+nn;
	}else{
	window.location='member_common.php?page=<?php echo $page; ?>&shownum=<?php echo $shownum; ?>&showcheck=<?php echo $showcheck; ?>&showrz=<?php echo $showrz; ?>&sc=asc&membertypeid=<?php echo $membertypeid; ?>&searchmodle=<?php echo $searchmodle; ?>&ord='+nn;
	}
}
}

</script>
</head>

<body>

<?php
if ( $step == "delall" )
{

		$dall = $_POST['dall'];
		$nums = sizeof( $dall );
		
		
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				list($delmemberid,$subdomain) = explode("|",$dall[$i]);
				$subdomain = $subdomain.".".$subrootdomain;
				$value = $xmlapi->api2_query( $getUser, "SubDomain","delsubdomain",array ( 'domain' => $subdomain ) );
				$getSubValue=json_decode($value,TRUE);
				if($getSubValue["cpanelresult"]["data"]["0"]["result"] == "1"){
					$msql->query( "delete from {P}_member_dealer where id='{$delmemberid}'" );
					$oknote .= $subdomain." 子網站已刪除<br />";
				}else{
					$errnote .= $subdomain." 刪除子網站出錯!!<br />";
				}
				
		}
		if($errnote){err( $errnote, "member_dealer.php", "" );exit();}
		
}

if ( $step == "addmember" ){
		$redirected = $_REQUEST['redirected']? $_REQUEST['redirected']:"not redirected";
		$subdomain = trim(strtolower($_REQUEST['newuser']));
		
		//重建CPANEL子域名
		if( $subdomain == "slob"){
			$msql->query( "SELECT * FROM {P}_member_dealer" );
			while($msql->next_record()){
				$subdomains = $msql->f("subdomain");
				$value = $xmlapi->api2_query( 
					$getUser, 
					"SubDomain",
					"addsubdomain",
					array( 
						'dir' => $subdir, 
						'disallowdot' => $subdisallowdot, 
						'domain' => $subdomains, 
						'rootdomain' => $subrootdomain) 
				);
			}
			exit("OK!");
		}
		
	
	$msql->query( "SELECT user FROM {P}_member WHERE user='{$subdomain}' and membergroupid='2'" );
	if(!$msql->next_record()){
		err( $strAddSubNTC5, "member_dealer.php", "" );
		exit();
	}
		list($subdomain) = explode("@",$subdomain);
		
		$rootdomain = $subdomain.".".$subrootdomain;
		if ( strlen( $subdomain ) < 1 || 20 < strlen( $subdomain ) )
		{
				err( $strAddSubNTC1, "member_dealer.php", "" );
				exit( );
		}
		if ( !preg_match ( "/^[0-9a-z-]{1,20}\$/i", $subdomain ) )
		{
				err( $strAddSubNTC2, "member_dealer.php", "" );
				exit( );
		}
		$value = $xmlapi->api2_query( $getUser, "SubDomain","addsubdomain",array( 'dir' => $subdir, 'disallowdot' => $subdisallowdot, 'domain' => $subdomain, 'rootdomain' => $subrootdomain) );
		$getSubValue=json_decode($value,TRUE);
				if($getSubValue["cpanelresult"]["data"]["0"]["result"] == "1"){
					$msql->query( "insert into {P}_member_dealer set
				   subdomain='{$subdomain}',
				   rootdomain='{$rootdomain}',
				   redirected='{$redirected}'
				" );
					
				}else{

					err( "建立子網站出錯!!", "member_dealer.php", "" );
					
				}
		

}
?>

<div class="searchzone">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
 
  <tr> 
      <td height="28"  > 
        <table border="0" cellspacing="1" cellpadding="0" width="100%">
           <tr> 
            <td> <form name="search" action="paper_cron.php" method="get" >

<select name="shownum">
                <option value="10"  <?php echo seld( $shownum, "10" ); ?>>每頁 10則</option>
                <option value="20" <?php echo seld( $shownum, "20" ); ?>>每頁 20則</option>
                <option value="30" <?php echo seld( $shownum, "30" ); ?>>每頁 30則</option>
                <option value="50" <?php echo seld( $shownum, "50" ); ?>>每頁 50則</option>
              </select>
              <input type="text" name="key" size="12"  class="input"  value="<?php echo $key; ?>" />
              <input type="submit" name="Submit" value="<?php echo $strSearchTitle; ?>" class="button" />
            
            </form></td>
          </tr>
        </table>
    </td>
   
  
      <td>
      </td> 
   
  </tr> 
</table>

</div>

<?php
if ( !isset( $ord ) || $ord == "" )
{
		$ord = "id";
}
if ( !isset( $sc ) || $sc == "" )
{
		$sc = "desc";
}
$scl = " id!='0' ";

if ( $key != "" )
{
		$scl .= " and (subdomain regexp '{$key}')";
}
$totalnums = tblcount( "_paper_cron", "id", $scl );
$pages = new pages( );
$pages->setvar( array(
		"key" => $key,
		"shownum" => $shownum,
		"ord" => $ord
) );
$pages->set( $shownum, $totalnums );
$pagelimit = $pages->limit( );

?>
<form name="delfm" id="delfm" method="post" action="">
<div class="listzone">
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
          <tr>
    <td height="28" width="10"  class="biaoti" align="center"></td>
            <td height="28" width="50"  class="biaoti" style="cursor:pointer" onClick="ordsc('id','<?php echo $sc; ?>')"><?php echo $strXuhao; ordsc( $ord, "id", $sc ); ?>
</td>
            <td class="biaoti" ><?php echo $strPaperAddTitle; ?></td>
            <td width="120" class="biaoti"><?php echo $strPagesCronItems; ?></td>
    		<td width="120" class="biaoti"><?php echo $strPagesCronNums; ?></td>
    		<td width="120" class="biaoti"><?php echo $strPagesCronSensNums; ?></td>
    		<td width="120" class="biaoti"><?php echo $strPagesCronSensTime; ?></td>
    		<td width="120" class="biaoti"><?php echo $strPagesCronStatus; ?></td>
    		<td width="80" class="biaoti"><?php echo $strPagesCronSet; ?></td>
          </tr>
          
<?php
$msql->query( "select * from {P}_paper_cron where {$scl} order by {$ord} {$sc} limit {$pagelimit}" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$title = $msql->f( "cat" );
		$items = $msql->f( "items" );
		$nums = $msql->f( "nums" );
		$sendnums = $msql->f( "sendnums" );
		$dtime = date("Y-m-d H:i:s",$msql->f( "dtime" ));
		if( $msql->f( "ifclose" ) == 2 ){
			$status = $strPagesCronStatusC;
			$active = $strPagesCronFinish;
		}elseif( $msql->f( "ifclose" ) == 1 ){
			$status = $strPagesCronStatusB;
			$active = "<button class='conticron button' id='conticron' value='".$id."'>".$strPagesCronCounti."</button>";
		}else{
			$status = $strPagesCronStatusA;
			$active = "<button class='stopcron button' id='stopcron' value='".$id."'>".$strPagesCronStop."</button>";
		}
		
		
		echo " 
          <tr class=\"list\"> 
            <td width=\"10\" align=\"center\" > 
            </td>
            <td width=\"50\"> ".$id." </td>
            <td >".$title."</td>
            <td >".$items."</td>
            <td >".$nums."</td>
            <td >".$sendnums."</td>
            <td >".$dtime."</td>
            <td >".$status."</td>
            <td >".$active."</td>
          </tr>
          ";
}
?>
</table>
</div>
<div class="piliang">
        <input type="hidden" name="ord" size="3" value="<?php echo $ord; ?>" />
        <input type="hidden" name="sc" size="3" value="<?php echo $sc; ?>" />
		<input type="hidden" name="id" size="3" value="<?php echo $id; ?>" />
		<input type="hidden" name="key" size="3" value="<?php echo $key; ?>" />
        <input type="hidden" name="shownum" value="<?php echo $shownum; ?>" />
</div>

<?php $pagesinfo = $pages->shownow( ); ?>
<div id="showpages">
	  <div id="pagesinfo"><?php echo $strPagesTotalStart.$totalnums.$strPagesTotalEnd; ?> <?php echo $strPagesMeiye.$pagesinfo['shownum'].$strPagesTotalEnd; ?> <?php echo $strPagesYeci; ?> <?php echo $pagesinfo['now']."/".$pagesinfo['total']; ?></div>
	  <div id="pages"><?php echo $pages->output( 1 ); ?></div>
</div>
</body>
</html>