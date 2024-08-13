<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/member.inc.php" );
needauth( 50 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title> 
<SCRIPT>
function cm(nn){
qus=confirm("<?php echo $strMemberTypeNotice1; ?>")
if(qus!=0){
window.location='member_type.php?step=del&membertypeid='+nn;
}
}
</SCRIPT>
</head>
<body >

<?php
$step = $_REQUEST['step'];
$membertypeid = $_REQUEST['membertypeid'];
if ( $step == "del" )
{
		$msql->query( "select * from {P}_member where membertypeid='{$membertypeid}'" );
		if ( $msql->next_record( ) )
		{
				err( $strMemberTypeNotice2, "", "" );
		}
		$msql->query( "delete from {P}_member_notice where  membertypeid='{$membertypeid}'" );
		$msql->query( "delete from {P}_member_defaultrights where  membertypeid='{$membertypeid}'" );
		$msql->query( "delete from {P}_member_regstep where  membertypeid='{$membertypeid}'" );
		$msql->query( "delete from {P}_member_type where  membertypeid='{$membertypeid}'" );
		sayok( $strMemberTypeNotice3, "member_type.php", "" );
}
?>
<div class="formzone">
<div class="namezone" style="float:left;margin:10px 10px 0px 10px"><?php echo $strSetMenu2; ?></div>
<div style="float:right;margin-right:3px;margin-top:5px">
<input type="button" name="Submit" value="<?php echo $strMemberTypeAdd; ?>"  class="button" onclick="window.location='member_type_add.php'" />
 </div>
<div class="tablezone" style="clear:both;">
  <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
    <tr> 
      <td width="120" height="28"  class="innerbiaoti"><?php echo $strMemberGroup; ?></td>
      <td  class="innerbiaoti"><?php echo $strMemberType; ?></td>
      <td  class="innerbiaoti" width="100"><?php echo $strMemberTypeRegAllow; ?></td>
      <td  class="innerbiaoti" height="28" width="70"><?php echo $strMemberTypeCs; ?></td>
      <td  class="innerbiaoti" height="28" width="70"><?php echo $strMemberTypeRight; ?></td>
      <td  class="innerbiaoti" height="28" width="70"><?php echo $strDelete; ?></td>
    </tr>
    
<?php
$msql->query( "select * from {P}_member_type order by membertypeid" );
while ( $msql->next_record( ) )
{
		$membertypeid = $msql->f( "membertypeid" );
		$membertype = $msql->f( "membertype" );
		$membergroupid = $msql->f( "membergroupid" );
		$ifcanreg = $msql->f( "ifcanreg" );
		$ifchecked = $msql->f( "ifchecked" );
		$fsql->query( "select * from {P}_member_group where id='{$membergroupid}'" );
		if ( $fsql->next_record( ) )
		{
				$membergroup = $fsql->f( "membergroup" );
		}
		echo "<tr class=\"list\"> 
        <td width=\"120\"  > ".$membergroup."        </td>
        <td>".$membertype."</td>
        <td width=\"100\">";
		showyn( $ifcanreg );
		echo "</td>
        <td   height=\"26\" width=\"70\"><a href=\"member_type_setup.php?membertypeid=".$membertypeid."\"><img src=\"images/set.png\"  border=\"0\"></a></td>
        <td   height=\"26\" width=\"70\"><a href=\"member_type_rights.php?membertypeid=".$membertypeid."\"><img src=\"images/auth.png\"  border=\"0\"></a></td>
        <td   height=\"26\" width=\"70\"><img src=\"images/delete.png\"  style=\"cursor:pointer\"  onClick=\"cm('".$membertypeid."')\"></td>
      </tr>
    ";
}
?>
 
  </table>
  </div>
</div>
</body>
</html>