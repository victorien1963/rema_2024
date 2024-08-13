<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "func/upload.inc.php" );
include( "language/".$sLan.".php" );
needauth( 3 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="../js/base.js"></script>
<script type="text/javascript" src="../js/form.js"></script>
<script type="text/javascript" src="js/comm.js"></script>
<title><?php echo $strAdminTitle; ?></title>
</head>
<body >

<?php
$user = $_REQUEST['user']? $_REQUEST['user']:$_COOKIE['SYSUSER'];
$step = $_REQUEST['step'];
if ( $step == "modify" )
{
		$msql->query( "delete from {P}_base_adminrights where user='{$user}'" );
		$msql->query( "select * from {P}_base_adminauth" );
		while ( $msql->next_record( ) )
		{
				$auth_auth = $msql->f( "auth" );
				$vStr = "a"."{$auth_auth}";
				if ( $_POST[$vStr] == "1" )
				{
						$fsql->query( "insert into {P}_base_adminrights values(0,'{$auth_auth}','{$user}')" );
				}
		}
		$adminname = $_REQUEST['name'];
		$adminjob = $_REQUEST['job'];
		$adminjobid = $_REQUEST['jobid'];
		$pic = $_FILES['jpg'];
		if ( 0 < $pic['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "base/pics/".$nowdate;
				$arr = newuploadimage( $pic['tmp_name'], $pic['type'], $pic['size'], $uppath);
				if ( $arr[0] != "err" )
				{
						$src = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
				$msql->query( "select src from {P}_base_admin where user='{$user}'" );
				if ( $msql->next_record( ) )
				{
						$oldsrc = $msql->f( "src" );
				}
				if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )
				{
						unlink( ROOTPATH.$oldsrc );
						$getpic = basename($oldsrc);
						$getpicpath = dirname($oldsrc);
						@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
				}
				$msql->query( "update {P}_base_admin set src='{$src}' where user='{$user}'" );
		}
		$msql->query( "update {P}_base_admin set name='{$adminname}',job='{$adminjob}',jobid='{$adminjobid}' where user='{$user}'" );
		sayok( $strAuthModifyOk, "auth_modauth.php", "" );
}
else
{
		$msql->query( "select * from {P}_base_admin where user='{$user}'" );
		if ( $msql->next_record( ) )
		{
				$adminname = $msql->f( "name" );
				$adminjob = $msql->f( "job" );
				$adminjobid = $msql->f( "jobid" );
		}
		$msql->query( "select * from {P}_base_adminrights where user='{$user}'" );
		$i = 0;
		while ( $msql->next_record( ) )
		{
				$AuthArr[$i] = $msql->f( "auth" );
				$i++;
		}
		$nums = $i - 1;
		echo "
<div class=\"formzone\">
<form method=\"post\" action=\"auth_modauth1.php\" enctype=\"multipart/form-data\">

<div class=\"namezone\">".$strAuthModi2."</div>
<div class=\"tablezone\">


  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
    <tr>
      <td width=\"70\"  ><div align=\"right\">".$strAuthUserName."</div></td>
      <td  ><input type=\"text\" name=\"name\" class=\"input\" style=\"width:200px\"  value=\"".$adminname."\" />
      </td>
    </tr>
    <tr>
      <td  ><div align=\"right\">".$strAuthJob."</div></td>
      <td  ><input name=\"job\" type=\"text\" class=\"input\" id=\"job\" style=\"width:200px\" value=\"".$adminjob."\" />
      </td>
    </tr>
    <tr> 
      <td width=\"70\"  > 
        <div align=\"right\">".$strAuthJobId."</div>
      </td>
      <td  > 
        <input name=\"jobid\" type=\"text\" class=\"input\" id=\"jobid\" style=\"width:200px\" value=\"".$adminjobid."\" />
      </td>
    </tr>
    <tr>
	  <td width=\"70\"  > 
        <div align=\"right\">管理員頭像</div>
      </td>
      <td  > 
        <input name=\"jpg\" type=\"file\" class=input id=\"jpg\" style=\"width:200px\" />
	  </td>
    </tr>
  </table>
  </div>
<div class=\"namezone\">".$strAuthModi." - ".$user."</div>
<div class=\"tablezone\">
      
      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"6\" align=\"center\">
        <tr> 
          <td width=\"50\"  class=\"innerbiaoti\">".$strAuth."</td>
          <td  class=\"innerbiaoti\" width=\"80\">".$strNumber."</td>
          <td  class=\"innerbiaoti\" width=\"180\">".$strAuthGroup."</td>
          <td  class=\"innerbiaoti\">".$strAuthName."</td>         
        </tr>       
";
		$msql->query( "select * from {P}_base_adminauth order by auth" );
		while ( $msql->next_record( ) )
		{
				$auth_auth = $msql->f( "auth" );
				$auth_name = $msql->f( "name" );
				$auth_intro = $msql->f( "intro" );
				$auth_pname = $msql->f( "pname" );
				$coltype = $msql->f( "coltype" );
				$ifcheck = "";
				$n = 0;
				for ( ;	$n <= $nums;	$n++	)
				{
						if ( $AuthArr[$n] == $auth_auth )
						{
								$ifcheck = " checked ";
						}
				}
				echo " 
          <tr class=\"list\"> 
            <td width=\"50\"> 
              <input type=\"checkbox\" name=\"a".$auth_auth."\" value=\"1\" ".$ifcheck."  class=\"authcheckbox\" />
            </td>
            <td width=\"80\">".$auth_auth."</td>
            <td   width=\"180\">".coltype2sname( $coltype )."</td>
            <td>".$auth_name."</td>            
          </tr>
          ";
		}
		echo " 
           <tr class=\"list\">
            <td height=\"23\" colspan=\"2\">
              <input id=\"selAll\" type=\"checkbox\" name=\"\" value=\"1\" />".$strSelAll."</td>
            <td height=\"23\">&nbsp;</td>
            <td height=\"23\">&nbsp;</td>
        </tr>		  
		  <tr> 
            <td colspan=\"5\"  class=\"innerbiaoti\">               
            </td>
          </tr>       
    </table>
	
    </div>
	  <div class=\"adminsubmit\"> 
                <input type=\"submit\" name=\"cc\" value=\"".$strModify."\" class=button>
                <input type=\"hidden\" name=\"step\" value=\"modify\">
                <input type=\"hidden\" name=\"user\" value=\"".$user."\">
     </div>
	   </form>	   
</div>
      ";
}
?>
	</body>
</html>