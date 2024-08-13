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
<script type="text/javascript" src="../js/base.js"></script>
<script type="text/javascript" src="../js/form.js"></script>
<script type="text/javascript" src="js/comm.js"></script>
<title><?php echo $strAdminTitle; ?></title>
</head>
<body>

<?php
$step = $_REQUEST['step'];
$user = $_REQUEST['user'];
$password = $_REQUEST['password'];
$name = $_REQUEST['name'];
$job = $_REQUEST['job'];
$jobid = $_REQUEST['jobid'];
if ( $step == "add" )
{
		trylimit( "_base_admin", 2, "id" );
		if ( $user != "" && $password != "" )
		{
				$msql->query( "select * from {P}_base_admin where user='{$user}'" );
				if ( $msql->next_record( ) )
				{
						err( $strAuthNTC1, "", "" );
				}
				$mdpass = md5( $password );
				$msql->query( "insert into {P}_base_admin set
		`user`='{$user}',
		`password`='{$mdpass}',
		`name`='{$name}',
		`job`='{$job}',
		`jobid`='{$jobid}',
		`moveable`='1'
		" );
				$msql->query( "delete from {P}_base_adminrights where user='{$user}'" );
				$msql->query( "select * from {P}_base_adminauth" );
				while ( $msql->next_record( ) )
				{
						$auth_auth = $msql->f( "auth" );
						$vStr = "a".$auth_auth;
						if ( $_POST[$vStr] == "1" )
						{
								$fsql->query( "insert into {P}_base_adminrights values(0,'{$auth_auth}','{$user}')" );
						}
				}
				sayok( $strAuthNTC2, "", "" );
		}
		else
		{
				err( $strAuthNTC3, "", "" );
		}
}
else
{
		echo " 
<form method=\"post\" action=\"auth_addauth.php\">

<div class=\"formzone\">
<div class=\"namezone\">".$strSetMenu4."</div>
<div class=\"tablezone\">

  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
    <tr> 
      <td width=\"70\"  > 
        <div align=\"right\">".$strAuthUser."</div>
      </td>
      <td  > 
        <input type=\"text\" name=\"user\" class=\"input\" style=\"width:200px\">
      </td>
    </tr>
    <tr> 
      <td width=\"70\"  > 
        <div align=\"right\">".$strAuthPass."</div>
      </td>
      <td  > 
        <input type=\"password\" name=\"password\" class=\"input\" style=\"width:200px\">
      </td>
    </tr>
    <tr>
      <td width=\"70\"  ><div align=\"right\">".$strAuthUserName."</div></td>
      <td  ><input type=\"text\" name=\"name\" class=\"input\" style=\"width:200px\" />
      </td>
    </tr>
    <tr>
      <td  ><div align=\"right\">".$strAuthJob."</div></td>
      <td  ><input name=\"job\" type=\"text\" class=\"input\" id=\"job\" style=\"width:200px\" />
      </td>
    </tr>
    <tr> 
      <td width=\"70\"  > 
        <div align=\"right\">".$strAuthJobId."</div>
      </td>
      <td  > 
        <input name=\"jobid\" type=\"text\" class=input id=\"jobid\" style=\"width:200px\" />
</td>
    </tr>
  </table>
  </div>
<div class=\"namezone\">".$strAuthSet."</div>
<div class=\"tablezone\">

  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
   <tr>           
      <td class=\"innerbiaoti\" width=\"50\" height=\"28\">".$strAuth."</td>          
      <td  class=\"innerbiaoti\" width=\"80\" height=\"28\">".$strNumber."</td>          
      <td  class=\"innerbiaoti\" width=\"180\" height=\"28\">".$strAuthGroup."</td>          
      <td class=\"innerbiaoti\" height=\"28\">".$strAuthName."</td>          
        </tr>";
		$msql->query( "select * from {P}_base_adminauth order by auth" );
		while ( $msql->next_record( ) )
		{
				$auth_auth = $msql->f( "auth" );
				$auth_name = $msql->f( "name" );
				$auth_intro = $msql->f( "intro" );
				$auth_pname = $msql->f( "pname" );
				$coltype = $msql->f( "coltype" );
				echo " 
          <tr class=\"list\">             
      <td width=\"50\" height=\"23\"> 
        <input type=\"checkbox\" name=\"a". $auth_auth."\" value=\"1\"  class=\"authcheckbox\" />
            </td>
      <td   width=\"80\" height=\"23\">". $auth_auth."</td>
      <td   width=\"180\" height=\"23\">".coltype2sname( $coltype )."</td>            
      <td height=\"23\">".$auth_name."</td>            
          </tr>";
		}
		echo " 
 <tr class=\"list\">
            <td height=\"23\" colspan=\"2\">
              <input id=\"selAll\" type=\"checkbox\" name=\"\" value=\"1\" />".$strSelAll."</td>
            <td height=\"23\">&nbsp;</td>
            <td height=\"23\">&nbsp;</td>
        </tr>
    <tr> 
      <td colspan=\"5\" >          
          <input type=\"hidden\" name=\"step\" value=\"add\" />        
      </td>
    </tr>
  </table>
  </div>
<div class=\"adminsubmit\">
<input type=\"submit\" name=\"cc\" value=\"".$strSubmit."\" class=\"button\" />
</div>
</div>
</form>";
}
?>
	</body>
</html>