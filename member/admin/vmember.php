<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 58 );
$memberid = $_GET['memberid'];
$id = $_GET['id'];
$tourl = $_GET['tourl'];
if ( $id != "" )
{
		$tourl = $tourl."?id=".$id;
}
//$msql->query( "select * from {P}_member where memberid='{$memberid}'" );
$msql->query( "SELECT *
									FROM (
										SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member 
										UNION ALL 
										SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member_offline
									) AS U
									where memberid='{$memberid}'" );
if ( $msql->next_record( ) )
{
		$user = $msql->f( "user" );
		$checked = $msql->f( "checked" );
		$exptime = $msql->f( "exptime" );
		$memberid = $msql->f( "memberid" );
		$membertypeid = $msql->f( "membertypeid" );
		$pname = $msql->f( "pname" );
		$name = $msql->f( "name" );
		$email = $msql->f( "email" );
		$nowtime = time( );
		$fsql->query( "select membertype from {P}_member_type where membertypeid='{$membertypeid}'" );
		if ( $fsql->next_record( ) )
		{
				$membertype = $fsql->f( "membertype" );
		}
		$fsql->query( "select * from {P}_member_rights where memberid='{$memberid}' and securetype='con'" );
		if ( $fsql->next_record( ) )
		{
				$consecure = $fsql->f( "secureset" );
		}
		$md5 = md5( $user."76|01|14".$memberid.$membertype.$consecure );
		setcookie( "MUSER", $user, time( ) + 3600, "/" );
		setcookie( "MEMBERPNAME", $name, time( ) + 3600, "/" );
		setcookie( "MEMBERID", $memberid, time( ) + 3600, "/" );
		setcookie( "MEMBERTYPE", $membertype, time( ) + 3600, "/" );
		setcookie( "MEMBERTYPEID", $membertypeid, time( ) + 3600, "/" );
		setcookie( "ZC", $md5, time( ) + 3600, "/" );
		setcookie( "SE", $consecure, time( ) + 3600, "/" );
		
?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $strVmember; ?></title>
</head>
<body>
	
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center" style="color:#555555;font-size:12px"><br>
  <br><?php echo $strVmember; ?>...</p>
<table width="252" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#999999" height="8">
  <tr bgcolor="#FFFFFF"> 
    <td>
      <table border="0" cellspacing="0" cellpadding="0" bgcolor="#999999" width="1" height="6" id="tbl">
        <tr>
          <td></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<p align="center" style="color:#555555;font-size:12px"><br>
</p>

<script>
window.focus();
setTimeout("tbl.style.width=30",200);
setTimeout("tbl.style.width=60",400);
setTimeout("tbl.style.width=90",600);
setTimeout("tbl.style.width=120",800);
setTimeout("tbl.style.width=150",1000);
setTimeout("tbl.style.width=180",1200);
setTimeout("tbl.style.width=210",1400);
setTimeout("tbl.style.width=250",1600);
setTimeout("window.location='../../<?php echo $tourl; ?>'",1700)</script>
<?php } ?>
</body></html>