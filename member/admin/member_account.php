<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/pages.inc.php" );
include( "language/".$sLan.".php" );
include( "func/member.inc.php" );
needauth( 70 );
$cmethod = $_REQUEST['cmethod'];
$ctype = $_REQUEST['ctype'];
$tp = $_REQUEST['tp'];
$fromM = $_REQUEST['fromM'];
$fromY = $_REQUEST['fromY'];
$fromD = $_REQUEST['fromD'];
$toM = $_REQUEST['toM'];
$toY = $_REQUEST['toY'];
$toD = $_REQUEST['toD'];
if ( $cmethod == "" )
{
		$cmethod = "all";
}
if ( $ctype == "" )
{
		$ctype = "all";
}
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
    <form method="get" action="member_account.php">
      <td colspan="2"><?php echo daylist( "fromY", "fromM", "fromD", $fromY, $fromM, $fromD ); ?> - <?php echo daylist( "toY", "toM", "toD", $toY, $toM, $toD ); ?>       
        
<select name="ctype" id="ctype">
          <option value="all"  <?php echo seld( $ctype, "all" ); ?>><?php echo $strAccAddMoney6; ?></option>
          <option value="<?php echo $strAccAddMoney1; ?>"  <?php echo seld( $ctype, $strAccAddMoney1 ); ?>><?php echo $strAccAddMoney1; ?></option>
          <option value="<?php echo $strAccAddMoney7; ?>"  <?php echo seld( $ctype, $strAccAddMoney7 ); ?>><?php echo $strAccAddMoney7; ?></option>
          <option value="<?php echo $strAccAddMoney8; ?>"  <?php echo seld( $ctype, $strAccAddMoney8 ); ?>><?php echo $strAccAddMoney8; ?></option>
		   <option value="<?php echo $strAccAddMoney9; ?>"  <?php echo seld( $ctype, $strAccAddMoney9 ); ?>><?php echo $strAccAddMoney9; ?></option>
       </select>

<select name="cmethod">
<option value="all"  <?php echo seld( $cmethod, "all" ); ?>><?php echo $strAccAddMoney2; ?></option>

<?php
$msql->query( "select * from {P}_member_paycenter where pcentertype!='2' order by xuhao" );
while ( $msql->next_record( ) )
{
		$method = $msql->f( "pcenter" );
		if ( $cmethod == $method )
		{
				echo "<option value={$method} selected>{$method}</option>";
		}
		else
		{
				echo "<option value={$method}>{$method}</option>";
		}
}
?>
		<option value="<?php echo $strAccAddMethod2; ?>"><?php echo $strAccAddMethod2; ?></option>
        </select>
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
      <td  class="biaoti" width="85">
<span class="title"><?php echo $strAccAddTime; ?></span></td> 
      <td width="70" height="28"  class="biaoti"><?php echo $strMemberUser; ?></td>
      <td width="130"  class="biaoti">
<span class="title"><?php echo $strMemberFrom23; ?></span></td>
      <td width="65" height="28"  class="biaoti">
<span class="title"><?php echo $strAccAddMoney6; ?></span></td>
      <td  class="biaoti" width="80">
<span class="title"><?php echo $strAccAddMoney2; ?></span></td>
      <td  class="biaoti" width="65">
<span class="title"><?php echo $strAccAddMoney3; ?></span></td>
      <td  class="biaoti" width="60">
<span class="title"><?php echo $strSalesname; ?></span></td>
      <td  class="biaoti" width="90">
<span class="title"><?php echo $strAccAddMoney5; ?></span></td>
      <td  class="biaoti">
<span class="title"><?php echo $strAccAddMoney4; ?></span></td>
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
if ( $cmethod != "" && $cmethod != "all" )
{
		$scl .= " and method='{$cmethod}' ";
}
if ( $ctype != "" && $ctype != "all" )
{
		$scl .= " and type='{$ctype}' ";
}
if ( $memberid != "" )
{
		$scl .= " and memberid='{$memberid}' ";
}
$scl .= " and addtime>={$fromtime} and addtime<={$totime} ";
$msql->query( "select * from {P}_member_pay where {$scl} order by id desc" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$memberid = $msql->f( "memberid" );
		$oof = $msql->f( "oof" );
		$method = $msql->f( "method" );
		$type = $msql->f( "type" );
		$addtime = $msql->f( "addtime" );
		$fpnum = $msql->f( "fpnum" );
		$memo = $msql->f( "memo" );
		$logname = $msql->f( "logname" );
		$addtime = date( "Y-m-d", $addtime );
		$total = $total + $oof;
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
  <td width=\"85\">".$addtime."</td> 
        <td width=\"70\"  > ".$user." </td>
        <td width=\"130\">".$showmyname."</td>
        <td width=\"65\"   height=\"26\">".$type."</td>
        <td width=\"80\">".$method."</td>
        <td width=\"65\">".$oof."</td>
        <td width=\"60\">".$salesname."</td>
        <td width=\"90\">".$fpnum."</td>
        <td>".$memo."</td></tr>";
}
$total = number_format( $total, 2, ".", "" );
?>
 
 <tr>
   <td  class="biaoti1" width="3">&nbsp;</td>
      <td  class="biaoti1" width="85">
<span class="title"><?php echo $strHeji; ?></span></td> 
      <td width="70" height="28"  class="biaoti1">-</td>
      <td width="130"  class="biaoti1">-</td>
      <td width="65" height="28"  class="biaoti1">
<span class="title">-</span></td>
      <td  class="biaoti1" width="80">
<span class="title">-</span></td>
      <td  class="biaoti1" width="65">
<span class="title"><?php echo $total; ?></span></td>
      <td  class="biaoti1" width="60">
<span class="title">-</span></td>
      <td  class="biaoti1" width="90">
<span class="title">-</span></td>
      <td  class="biaoti1">
<span class="title">-</span></td>
    </tr>
  </table>
</div>
<br /><br /><br />
</body>
</html>