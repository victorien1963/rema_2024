<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 3 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script>
	function cm(nn){
		qus=confirm("<?php echo $strDeleteConfirm; ?>")
		if(qus!=0){
			window.location='auth_modauth.php?step=del&user='+nn;
		}
	}
</script>
</head>
<body>

<?php
$step = $_REQUEST['step'];
if ( $step == "del" )
{
		$user = $_REQUEST['user'];
		$msql->query( "select moveable from {P}_base_admin where user='{$user}'" );
		if ( $msql->next_record( ) )
		{
				$moveable = $msql->f( "moveable" );
		}
		if ( $moveable != "1" )
		{
				err( $strAuthDelNTC1, "", "" );
		}
		$msql->query( "delete from {P}_base_adminrights where user='{$user}'" );
		$msql->query( "delete from {P}_base_admin where user='{$user}'" );
		echo "<script>window.location='auth_modauth.php'</script>";
}
?>

<div class="formzone">
<div class="namezone"><?php echo $strSetMenu5; ?></div>
<div class="tablezone">    
      <table width="100%" border="0" cellspacing="0" cellpadding="6" >
        <tr > 
          <td height="28" class="innerbiaoti"><?php echo $strAuthUser; ?></td>
          <td height="28" class="innerbiaoti"><?php echo $strAuthUserName; ?></td>
          <td class="innerbiaoti"><?php echo $strAuthJob; ?></td>
          <td class="innerbiaoti"><?php echo $strAuthJobId; ?></td>
          <td height="28" width="100" class="innerbiaoti"><?php echo $strAuthModify; ?></td>
        <td width="100" class="innerbiaoti"><?php echo $strDeleteAcc; ?></td>
        </tr>       
        
<?php
if($_COOKIE["SYSUSER"] == "wayhunt"){
	$msql->query( "select * from {P}_base_admin order by id" );
}else{
	$msql->query( "select * from {P}_base_admin WHERE user!='wayhunt'order by id" );
}

while ( $msql->next_record( ) )
{
		$user = $msql->f( "user" );
		$name = $msql->f( "name" );
		$job = $msql->f( "job" );
		$jobid = $msql->f( "jobid" );
		$moveable = $msql->f( "moveable" );
		if ( $moveable != "1" )
		{
				$dis = " disabled ";
				$discss = " style='display:none;' ";
		}
		else
		{
				$dis = "";
				$discss = "";
		}
		echo " 
        <form method=\"post\" action=\"auth_modauth1.php\">
          <tr class=\"list\"> 
            <td height=\"22\"> ".$user." <input type=\"hidden\" name=\"user\" value=\"".$user."\">             
            </td>
            <td height=\"22\"> ".$name." </td>
            <td>".$job." </td>
            <td>".$jobid." </td>
            <td height=\"22\" width=\"100\"  >              
                <input type=\"submit\" name=\"Button22\" value=\"".$strAuthModify."\" class=button>              
            </td>
          <td width=\"100\"  ><input type=\"button\" name=\"Button22\" value=\"".$strDeleteAcc."\" onClick=\"cm('".$user."'); return false;\" class=\"button\" ".$dis." ".$discss."/></td>
          </tr>
        </form>
        ";
}
?> 
    			</table>
			</div>
		</div>
	</body>
</html>