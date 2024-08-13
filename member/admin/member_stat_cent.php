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
    <form method="get" action="member_stat_cent.php">
      <td colspan="2"><?php echo daylist( "fromY", "fromM", "fromD", $fromY, $fromM, $fromD ); ?> - <?php echo daylist( "toY", "toM", "toD", $toY, $toM, $toD ); ?>       
        <input type="submit" name="Submit" value="<?php echo $strSearchTitle; ?>" class=button>        
          <input type="hidden" name="tp" value="search">
          <input type="hidden" name="memberid" value="<?php echo $memberid; ?>">
      </td> </form>
  </tr>
</table>
</div>

<?php
$msql->query( "select * from {P}_member_centset" );
if ( $msql->next_record( ) )
{
		$centname1 = $msql->f( "centname1" );
		$centname2 = $msql->f( "centname2" );
		$centname3 = $msql->f( "centname3" );
		$centname4 = $msql->f( "centname4" );
		$centname5 = $msql->f( "centname5" );
}

if ( $tp == "search" )
{
		trylimit( "_member", 200, "memberid" );
}
?>
<div class="listzone">
  <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
    <tr>
      <td  class="biaoti" width="3">&nbsp;</td>
      <td  class="biaoti" width="150">
<span class="title"><?php echo $strCentL3; ?></span></td> 
      <td width="70" height="28"  class="biaoti"><?php echo $strMemberUser; ?></td>
      <td  class="biaoti"><span class="title"><?php echo $strMemberFrom23; ?></span></td>
      <td width="120" height="28"  class="biaoti"><span class="title"><?php echo $strCentEvent; ?></span></td>
      <td  class="biaoti" width="50"><span class="title"><?php echo $centname1; ?></span></td>
      <td  class="biaoti" width="50"><span class="title"><?php echo $centname2; ?></span></td>
      <td  class="biaoti" width="50"><span class="title"><?php echo $centname3; ?></span></td>
      <td  class="biaoti" width="50"><span class="title"><?php echo $centname4; ?></span></td>
      <td width="50"  class="biaoti"><span class="title"><?php echo $centname5; ?></span></td>
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
$scl .= " and dtime>={$fromtime} and dtime<={$totime} ";
$msql->query( "select * from {P}_member_centlog where {$scl} order by id desc" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$memberid = $msql->f( "memberid" );
		$event = $msql->f( "event" );
		$dtime = $msql->f( "dtime" );
		$cent1 = $msql->f( "cent1" );
		$cent2 = $msql->f( "cent2" );
		$cent3 = $msql->f( "cent3" );
		$cent4 = $msql->f( "cent4" );
		$cent5 = $msql->f( "cent5" );
		$memo = $msql->f( "memo" );
		if ( $event == "0" )
		{
				$eventname = $memo;
		}
		else
		{
				$fsql->query( "select name from {P}_member_centrule where event='{$event}' " );
				if ( $fsql->next_record( ) )
				{
						$eventname = $fsql->f( "name" );
				}
		}
		$dtime = date( "Y-m-d H:i:s", $dtime );
		$totalcent1 = $totalcent1 + $cent1;
		$totalcent2 = $totalcent2 + $cent2;
		$totalcent3 = $totalcent3 + $cent3;
		$totalcent4 = $totalcent4 + $cent4;
		$totalcent5 = $totalcent5 + $cent5;
		$fsql->query( "select * from {P}_member where memberid='{$memberid}'" );
		if ( $fsql->next_record( ) )
		{
				$mymembergroupid = $fsql->f( "membergroupid" );
				$membertypeid = $fsql->f( "membertypeid" );
				$user = $fsql->f( "user" );
				$name = $fsql->f( "name" );
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
  <td width=\"150\">";
		echo $dtime;
		echo "</td> 
        <td width=\"70\"  > ".$user." </td>
        <td>".$showmyname."</td>
        <td width=\"120\"   height=\"26\">".$eventname."</td>
        <td width=\"50\">".$cent1."</td>
        <td width=\"50\">".$cent2."</td>
        <td width=\"50\">".$cent3."</td>
        <td width=\"50\">".$cent4."</td>
        <td width=\"50\">".$cent5."</td>
</tr>

    ";
}
?>
 
 <tr>
   <td  class="biaoti1" width="3">&nbsp;</td>
      <td  class="biaoti1" width="150"><span class="title"><?php echo $strHeji; ?></span></td> 
      <td width="70" height="28"  class="biaoti1">-</td>
      <td  class="biaoti1">-</td>
      <td width="120" height="28"  class="biaoti1"><span class="title">-</span></td>
      <td  class="biaoti1" width="50"><span class="title"><?php echo $totalcent1; ?></span></td>
      <td  class="biaoti1" width="50"><span class="title"><?php echo $totalcent2; ?></span></td>
      <td  class="biaoti1" width="50"><span class="title"><?php echo $totalcent3; ?></span></td>
      <td  class="biaoti1" width="50"><span class="title"><?php echo $totalcent4; ?></span></td>
      <td width="50"  class="biaoti1"><span class="title"><?php echo $totalcent5; ?></span></td>
    </tr>
  </table>
</div>
<br /><br /><br />
</body>
</html>