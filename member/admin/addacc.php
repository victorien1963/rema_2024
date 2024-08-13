<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/member.inc.php" );
needauth( 67 );
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
	//$fsql->query( "update {P}_member set account=account+1616 where memberid='{$_REQUEST['memberid']}'" );
$step = $_REQUEST['step'];
$memberid = $_REQUEST['memberid'];
$payid = $_REQUEST['payid'];
$oof = $_REQUEST['oof'];
$method = $_REQUEST['method'];
$type = $_REQUEST['type'];
$memo = $_REQUEST['memo'];
$ip = $_SERVER['REMOTE_ADDR'];

//取出目前帳戶資訊
$msql->query("select * from {P}_member where memberid='".$memberid."'");
if($msql->next_record()){
	$account=$msql->f('account');
}

if ( $step == "add" )
{
		trylimit( "_member_pay", 50, "id" );
		if ( $oof == "" )
		{
				err( $strAccAddNTC1, "", "" );
		}
		else
		{
				$daytime = time( );
				$ip = $_SERVER['REMOTE_ADDR'];
				$logname = $_COOKIE['SYSNAME'];
				$msql->query( "insert into {P}_member_pay set 
					`memberid`='{$memberid}',
					`payid`='{$payid}',
					`oof`='{$oof}',
					`method`='{$method}',
					`type`='{$strAccAddMoney1}',
					`addtime`='{$daytime}',
					`fpnum`='',
					`memo`='{$memo}',
					`ip`='{$ip}',
					`logname`='{$logname}',
					`thisaccount`='{$account}'
				" );
				$msql->query( "update {P}_member set account=account+{$oof},paytotal=paytotal+{$oof} where memberid='{$memberid}'" );
				sayok( $strAccAddNTC2, "index.php?searchmodle=account", "" );
		}
}
?>
<div class="formzone">
<div class="namezone"><?php echo $strAccAddMoney; ?></div>
<div class="tablezone">
  <table width="100%" border="0" cellspacing="0" cellpadding="4" align="center">
    <form action="addacc.php" method="post" name="form1" id="form1">
      <tr>
        <td height="8" colspan="2"  class="con"></td>
      </tr>
      <tr>
        <td width="125" height="25" align="center" class="con"><?php echo $strMemberUser; ?></td>
        <td  class="con" height="25"><?php echo memberid2user( $memberid ); ?></td>
      </tr>
      <tr>
        <td class="con" height="25" width="125" align="center"><?php echo $strAccAddMoney2; ?></td>
        <td  class="con" height="25">
<select name="method">            
            
<?php
$msql->query( "select * from {P}_member_paycenter order by xuhao" );
while ( $msql->next_record( ) )
{
		$method = $msql->f( "pcenter" );
		echo "<option value='".$method."'>".$method."</option>";
}
?>
            <option value="<?php echo $strAccAddMethod2; ?>"><?php echo $strAccAddMethod2; ?></option>
          </select>
        </td>
      </tr>
      <tr>
        <td class="con" height="25" width="125" align="center"><?php echo $strAccAddMoney3; ?></td>
        <td  class="con" height="25"><input type="text" name="oof" size="8" class="input" />
            </td>
      </tr>
      <tr>
        <td class="con" height="25" width="125" align="center"><?php echo $strAccAddMoney4; ?></td>
        <td  class="con" height="25"><input type="text" name="memo" size="50" class="input" />
            <input type="hidden" name="memberid" value="<?php echo $memberid; ?>" />
            <input type="hidden" name="step" value="add" />
        </td>
      </tr>
      <tr>
        <td class="con" height="32" align="center">&nbsp;</td>
      <td class="con" height="32"><input type="submit" name="Submit" value="<?php echo $strMemberAddAcc; ?>" />
        <input type="button" name="Submit2" value="<?php echo $strCancel; ?>" onclick="self.location='index.php?searchmodle=account'" /></td>
      </tr>
    </form>
  </table>
</div>
</div>
</body>
</html>