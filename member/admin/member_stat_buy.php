<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/pages.inc.php" );
include( "language/".$sLan.".php" );
include( "func/member.inc.php" );
needauth( 70 );
$tp = $_REQUEST['tp'];
$fromM = $_REQUEST['fromM'];
$fromY = $_REQUEST['fromY'];
$fromD = $_REQUEST['fromD'];
$toM = $_REQUEST['toM'];
$toY = $_REQUEST['toY'];
$toD = $_REQUEST['toD'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
</head>
<body >

<div class="searchzone">
<table width="100%" border="0" cellspacing="0" cellpadding="6" align="center" height="29">
  <tr>
    <form method="get" action="member_stat_buy.php">
      <td colspan="2"><?php echo daylist( "fromY", "fromM", "fromD", $fromY, $fromM, $fromD ); ?> - <?php echo daylist( "toY", "toM", "toD", $toY, $toM, $toD ); ?>       
        <input type="submit" name="Submit" value="<?php echo $strSearchTitle; ?>" class=button>
        
          <input type="hidden" name="tp" value="search">
          <input type="hidden" name="memberid" value="<?php echo $memberid; ?>">
      </td> </form>
  </tr>
</table>

</div>


<?php
if ( $tp == "search" )
{
		trylimit( "_member", 200, "memberid" );
}
?>
<div class="listzone">

  <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
    <tr>
      <td  class="biaoti" width="3">&nbsp;</td>
      <td  class="biaoti" width="85"><span class="title"><?php echo $strAccBuyTime; ?></span></td> 
      <td width="70" height="28"  class="biaoti"><?php echo $strMemberUser; ?></td>
      <td  class="biaoti"><span class="title"><?php echo $strMemberFrom23; ?></span></td>
      <td width="95" height="28"  class="biaoti"><span class="title"><?php echo $strAccBuyPaytype; ?></span></td>
      <td  class="biaoti" width="65"><span class="title"><?php echo $strAccBuyFrom; ?></span></td>
      <td  class="biaoti" width="65"><span class="title"><?php echo $strAccBuyJine; ?></span></td>
      <td  class="biaoti" width="70"><span class="title"><?php echo $strAccBuyOrder; ?></span></td>
      <td  class="biaoti" width="60"><span class="title"><?php echo $strSalesname; ?></span></td>
      <td width="80"  class="biaoti"><span class="title"><?php echo $strLogName; ?></span></td>
    </tr>

<?php
if ( $fromM == "" || $toM == "" )
{
		$fromY = date( "Y", time( ) );
		$fromM = date( "n", time( ) );
		$fromD = date( "j", time( ) );
		$toY = date( "Y", time( ) );
		$toM = date( "n", time( ) );
		$toD = date( "j", time( ) );
}
$fromtime = mktime( 0, 0, 0, $fromM, $fromD, $fromY );
$totime = mktime( 23, 59, 59, $toM, $toD, $toY );
$scl = " id!='0' ";
if ( $memberid != "" )
{
		$scl .= " and memberid='{$memberid}' ";
}
$scl .= " and daytime>={$fromtime} and daytime<={$totime} ";
$msql->query( "select * from {P}_member_buylist where {$scl} order by id desc" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$memberid = $msql->f( "memberid" );
		$orderid = $msql->f( "orderid" );
		$buyfrom = $msql->f( "buyfrom" );
		$paytype = $msql->f( "paytype" );
		$daytime = $msql->f( "daytime" );
		$paytotal = $msql->f( "paytotal" );
		$ip = $msql->f( "ip" );
		$OrderNo = $msql->f( "OrderNo" );
		$logname = $msql->f( "logname" );
		$daytime = date( "Y-m-d", $daytime );
		$total = $total + $paytotal;
		$fsql->query( "select * from {P}_member where memberid='{$memberid}'" );
		if ( $fsql->next_record( ) )
		{
				$mymembergroupid = $fsql->f( "membergroupid" );
				$membertypeid = $fsql->f( "membertypeid" );
				$user = $fsql->f( "user" );
				$name = $fsql->f( "name" );
				$salesname = $fsql->f( "salesname" );
				$company = $fsql->f( "company" );
		}
		switch ( $mymembergroupid )
		{
		case "2" :
				$showmyname = $company;
				break;
		default :
				$showmyname = $name;
				break;
		}
		echo " <tr class=\"list\">
  <td width=\"3\">&nbsp;</td>
  <td width=\"85\">".$daytime."</td> 
        <td width=\"70\"  > ".$user." </td>
        <td>".$showmyname."</td>
        <td width=\"95\"   height=\"26\">".$paytype."</td>
        <td width=\"65\">".$buyfrom."</td>
        <td width=\"65\">".$paytotal."</td>
        <td width=\"70\">".$OrderNo."</td>
        <td width=\"60\">".$salesname."</td>
        <td width=\"80\">".$logname."</td>
</tr>

    ";
}
$total = number_format( $total, 2, ".", "" );
?>
 
 <tr>
   <td  class="biaoti1" width="3">&nbsp;</td>
      <td  class="biaoti1" width="85">
<span class="title"><?php echo $strHeji; ?></span></td> 
      <td width="70" height="28"  class="biaoti1">-</td>
      <td  class="biaoti1">-</td>
      <td width="95" height="28"  class="biaoti1">
<span class="title">-</span></td>
      <td  class="biaoti1" width="65">
<span class="title">-</span></td>
      <td  class="biaoti1" width="65">
<span class="title"><?php echo $total; ?></span></td>
      <td  class="biaoti1" width="70">
<span class="title">-</span></td>
      <td  class="biaoti1" width="60">
<span class="title">-</span></td>
      <td width="80"  class="biaoti1">
<span class="title">-</span></td>
    </tr>
  </table>
</div>
<br /><br /><br />
</body>
</html>