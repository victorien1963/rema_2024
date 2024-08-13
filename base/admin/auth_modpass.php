<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 2 );
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head >
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<link  href=\"css/style.css\" type=\"text/css\" rel=\"stylesheet\">
<title>";
echo $strAdminTitle;
echo "</title>
</head>

<body>


";
$step = $_REQUEST['step'];
$user = $_REQUEST['user'];
$newpass = $_REQUEST['newpass'];
$repass = $_REQUEST['repass'];
$password = $_REQUEST['password'];
if ( $step == "modify" )
{
    if ( $newpass !== $repass )
    {
        err( $strPasswdNTC1, "", "" );
    }
    $oldmd = md5( $password );
    $newmd = md5( $newpass );
    $msql->query( "select * from {P}_base_admin where user='{$user}' and password='{$oldmd}'" );
    if ( $msql->next_record( ) )
    {
        $fsql->query( "update {P}_base_admin set password='{$newmd}'  where user='{$user}' and password='{$oldmd}'" );
        if ( $user == $_COOKIE['SYSUSER'] )
        {
            sayok( $strPasswdNTC2, ROOTPATH."admin.php", $strPasswdNTC3 );
        }
        else
        {
            sayok( $strPasswdNTC4, "", "" );
        }
    }
    else
    {
        err( $strPasswdNTC5, "", "" );
    }
}
else
{
    echo "<div class=\"formzone\">
<form method=\"post\" action=\"auth_modpass.php\">
<div class=\"namezone\">
";
    echo $strSetMenu3;
    echo "</div>
<div class=\"tablezone\">
<table width=\"480\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">
    <tr> 
      <td height=\"25\" width=\"125\" > 
        <div align=\"right\">";
    echo $strPasswdModiUser;
    echo "</div>
      </td>
      <td height=\"25\" > 
        <input type=\"text\" name=\"user\" class=input style=\"width:150px\" />
      </td>
    </tr>
    <tr> 
      <td height=\"25\" width=\"125\" > 
        <div align=\"right\">";
    echo $strPasswdModiOld;
    echo "</div>
      </td>
      <td height=\"25\" > 
        <input type=\"password\" name=\"password\" value=\"\" class=input style=\"width:150px\" />
      </td>
    </tr>
    <tr> 
      <td height=\"25\" width=\"125\" > 
        <div align=\"right\">";
    echo $strPasswdModiNew;
    echo "</div>
      </td>
      <td height=\"25\" > 
        <input type=\"password\" name=\"newpass\" class=input style=\"width:150px\" />
      </td>
    </tr>
    <tr> 
      <td height=\"25\" width=\"125\" > 
        <div align=\"right\">";
    echo $strPasswdModiRe;
    echo "</div>
      </td>
      <td height=\"25\" > 
        <input type=\"password\" name=\"repass\" class=input style=\"width:150px\" />
      </td>
    </tr>
    <tr> 
      <td height=\"25\" > 
        <div align=\"right\"><font color=\"#FFFFFF\"></font></div>
        <div align=\"center\">        </div>
      </td>
    <td height=\"25\" ><input type=\"submit\" name=\"cc\" value=\"";
    echo $strSubmit;
    echo "\" class=\"button\" />
      <input type=\"hidden\" name=\"step\" value=\"modify\" /></td>
    </tr>

</table>
</div>
</form>
</div>
";
}
echo " 
</body>
</html>
";
?>
