<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/pages.inc.php" );
include( "language/".$sLan.".php" );
include( "func/member.inc.php" );
needauth( 70 );
$showmembertypeid = $_REQUEST['showmembertypeid'];
$showcent = $_REQUEST['showcent'];
$tp = $_REQUEST['tp'];
$fromM = $_REQUEST['fromM'];
$fromY = $_REQUEST['fromY'];
$fromD = $_REQUEST['fromD'];
$toM = $_REQUEST['toM'];
$toY = $_REQUEST['toY'];
$toD = $_REQUEST['toD'];
if ( !isset( $showcent ) || $showcent == "" )
{
		$showcent = "cent1";
}
$nowcentname = "centname".substr( $showcent, 4, 1 );
$msql->query( "select * from {P}_member_centset" );
if ( $msql->next_record( ) )
{
		$centname1 = $msql->f( "centname1" );
		$centname2 = $msql->f( "centname2" );
		$centname3 = $msql->f( "centname3" );
		$centname4 = $msql->f( "centname4" );
		$centname5 = $msql->f( "centname5" );
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
    <form method="get" action="member_ph_cent.php">
      <td colspan="2"><?php echo daylist( "fromY", "fromM", "fromD", $fromY, $fromM, $fromD ); ?> - <?php echo daylist( "toY", "toM", "toD", $toY, $toM, $toD ); ?>       
        
<select name="showmembertypeid" >
          <option value='0'><?php echo $strMemberTypeSel; ?></option>
          
<?php
$fsql->query( "select * from {P}_member_type  order by membertypeid" );
while ( $fsql->next_record( ) )
{
		$lmembertypeid = $fsql->f( "membertypeid" );
		$lmembertype = $fsql->f( "membertype" );
		if ( $showmembertypeid == $lmembertypeid )
		{
				echo "<option value='".$lmembertypeid."' selected>".$lmembertype."</option>";
		}
		else
		{
				echo "<option value='".$lmembertypeid."'>".$lmembertype."</option>";
		}
}
?>
        </select>
        
<select name="showcent" >
          <option value='cent1' <?php echo seld( $showcent, "cent1" ); ?>><?php echo $centname1; ?></option>
		  <option value='cent2' <?php echo seld( $showcent, "cent2" ); ?>><?php echo $centname2; ?></option>
		  <option value='cent3' <?php echo seld( $showcent, "cent3" ); ?>><?php echo $centname3; ?></option>
		  <option value='cent4' <?php echo seld( $showcent, "cent4" ); ?>><?php echo $centname4; ?></option>
		  <option value='cent5' <?php echo seld( $showcent, "cent5" ); ?>><?php echo $centname5; ?></option>
         
        </select>
        <input type="submit" name="Submit" value="<?php echo $strSearchTitle; ?>" class=button>
        
          <input type="hidden" name="tp" value="search">
        
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
$scl .= " and dtime>={$fromtime} and dtime<={$totime} ";
$arr = array( );
$msql->query( "select * from {P}_member_centlog where {$scl} order by id desc" );
while ( $msql->next_record( ) )
{
		$memberid = $msql->f( "memberid" );
		$oof = $msql->f( $showcent );
		$arr["m".$memberid]['total'] += $oof;
		$arr["m".$memberid]['mid'] = $memberid;
		$arr["m".$memberid]['paynum'] += 1;
}
rsort( $arr );
?>

  <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
    <tr>
      <td  class="biaoti" width="3">&nbsp;</td>
      <td  class="biaoti" width="70"><span class="title"><?php echo $strStatNums; ?></span></td> 
	   <td width="70" height="28"  class="biaoti"><span class="title"><?php echo $strMemberId; ?></span></td>
      <td width="80" height="28"  class="biaoti"><?php echo $strMemberUser; ?></td>
	   <td width="80"  class="biaoti"><span class="title"><?php echo $strMemberType; ?></span></td>
      <td  class="biaoti"><span class="title"><?php echo $strMemberFrom23; ?></span></td>
      <td width="70"  class="biaoti"><span class="title"><?php echo $$nowcentname; ?></span></td>
      <td  class="biaoti" width="55"><span class="title"><?php echo $strMemberPaynums; ?></span></td>
      <td  class="biaoti" width="50"><span class="title"><?php echo $strMemberDetail; ?></span></td>
    </tr>


<?php
$ph = 0;
for ( $i = 0;	$i < sizeof( $arr );	$i++	)
{
		$memberid = $arr[$i]['mid'];
		$paynums = $arr[$i]['paynum'];
		$total = $arr[$i]['total'];
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
		if ( $showmembertypeid == "0" || $showmembertypeid == "" || $showmembertypeid == $membertypeid )
		{
				$ph++;
				if ( 300 < $ph )
				{
						break;
				}
				echo " <tr class=\"list\">
  <td width=\"3\">&nbsp;</td>
  <td width=\"70\">".$ph."</td> 
         <td width=\"70\"   height=\"26\">".$memberid."</td>
		 <td width=\"80\"  > ".$user." </td>
        <td width=\"80\">".membertypeid2membertype( $membertypeid )."</td>
        <td>".$showmyname."</td>
        <td width=\"70\">".$total."</td>
        <td width=\"55\">".$paynums."</td>
        <td width=\"50\"><a href=\"member_centlog.php?memberid=".$memberid."\"><img src=\"images/look.png\"  border=\"0\" /></a></td>
</tr>

    ";
		}
}
?>
 
  </table>
</div>
<br /><br /><br />
</body>
</html>