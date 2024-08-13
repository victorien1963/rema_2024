<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/pages.inc.php" );
include( "language/".$sLan.".php" );
include( "func/member.inc.php" );
needauth( 68 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
</head>
<body >

<?php
$step = $_REQUEST['step'];
$memberid = $_REQUEST['memberid'];
$id = $_REQUEST['id'];
if ( $memberid == "" )
{
		echo "ERROR:NO MEMBERID";
		exit( );
}
$scl = " memberid='{$memberid}' ";
$totalnums = tblcount( "_member_buylist", "id", $scl );
$pages = new pages( );
$pages->setvar( array(
		"memberid" => $memberid
) );
$pages->set( 20, $totalnums );
$pagelimit = $pages->limit( );
?>
<div class="formzone">
<div class="namezone" ><?php echo $strAccBuyList; ?> - [ <?php echo memberid2user( $memberid ); ?> ]</div>

<div class="tablezone">

  <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
    <tr> 
      <td width="160" height="28"  class="innerbiaoti">
<span class="title"><?php echo $strAccBuyTime; ?></span></td>
      <td  class="innerbiaoti" width="120">
<span class="title"><?php echo $strAccBuyPaytype; ?></span></td>
      <td  class="innerbiaoti" height="28">
<span class="title"><?php echo $strAccBuyJine; ?></span></td>
      <td  class="innerbiaoti" width="90">
<span class="title"><?php echo $strAccBuyFrom; ?></span></td>
      <td  class="innerbiaoti" width="100">
<span class="title"><?php echo $strAccBuyOrder; ?></span></td>
      <td  class="innerbiaoti" width="80">
<span class="title"><?php echo $strLogName; ?></span></td>
      </tr>

<?php
$msql->query( "select * from {P}_member_buylist where {$scl} order by id desc limit {$pagelimit}" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$payid = $msql->f( "payid" );
		$paytype = $msql->f( "paytype" );
		$buyfrom = $msql->f( "buyfrom" );
		$paytotal = $msql->f( "paytotal" );
		$daytime = $msql->f( "daytime" );
		$ip = $msql->f( "ip" );
		$orderid = $msql->f( "orderid" );
		$OrderNo = $msql->f( "OrderNo" );
		$logname = $msql->f( "logname" );
		$daytime = date( "Y-n-j H:i:s", $daytime );
		echo "<tr class=\"list\"> 
        <td width=\"160\"  > ".$daytime." </td>
        <td width=\"120\">".$paytype."</td>
        <td   height=\"26\">".$paytotal."</td>
        <td width=\"90\">".$buyfrom."</td>
        <td width=\"100\">".$OrderNo."</td>
        <td width=\"80\">".$logname."</td>
      </tr>
    ";
}
?>
 
  </table>
  </div>
<?php $pagesinfo = $pages->shownow( ); ?>
<div id="showpages">
	  <div id="pagesinfo"><?php echo $strPagesTotalStart.$totalnums.$strPagesTotalEnd; ?> <?php echo $strPagesMeiye.$pagesinfo['shownum'].$strPagesTotalEnd; ?> <?php echo $strPagesYeci; ?> <?php echo $pagesinfo['now']."/".$pagesinfo['total']; ?></div>
	  <div id="pages"><?php echo $pages->output( 1 ); ?></div>
</div>
</div>
</body>
</html>