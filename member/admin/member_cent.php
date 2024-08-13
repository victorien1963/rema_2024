<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 63 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
</head>
<body>

<?php
$step = $_REQUEST['step'];
if ( $step == "modi" )
{
		$cent1 = $_REQUEST['cent1'];
		$cent2 = $_REQUEST['cent2'];
		$cent3 = $_REQUEST['cent3'];
		$cent4 = $_REQUEST['cent4'];
		$cent5 = $_REQUEST['cent5'];
		$id = $_REQUEST['id'];
		$msql->query( "update {P}_member_centrule set 
	`cent1`='{$cent1}',
	`cent2`='{$cent2}',
	`cent3`='{$cent3}',
	`cent4`='{$cent4}',
	`cent5`='{$cent5}'
	 where id='{$id}'" );
}
if ( $step == "centset" )
{
		$centname1 = $_REQUEST['centname1'];
		$centname2 = $_REQUEST['centname2'];
		$centname3 = $_REQUEST['centname3'];
		$centname4 = $_REQUEST['centname4'];
		$centname5 = $_REQUEST['centname5'];
		$msql->query( "update {P}_member_centset set 
	`centname1`='{$centname1}',
	`centname2`='{$centname2}',
	`centname3`='{$centname3}',
	`centname4`='{$centname4}',
	`centname5`='{$centname5}' 
	" );
}
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
 
<div class="formzone">
<div class="namezone">
<?php echo $strCentAutoSet; ?></div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
 <form action="member_cent.php" method="get" >
  <tr>
    <td  class="innerbiaoti" width="50"><?php echo $strColType; ?></td>
    <td  class="innerbiaoti" width="50"><?php echo $strCentList0; ?></td>
    <td width="150"  class="innerbiaoti"><?php echo $strCentEvent; ?></td>
    <td  class="innerbiaoti" width="50"><input name="centname1" type="text"  value="<?php echo $centname1; ?>" size="3" class="input" />      </td>
    <td  class="innerbiaoti" width="50"><input name="centname2" type="text"  value="<?php echo $centname2; ?>" size="3" class="input" /></td>
    <td  class="innerbiaoti" width="50"><input name="centname3" type="text"  value="<?php echo $centname3; ?>" size="3" class="input" /></td>
    <td  class="innerbiaoti" width="50"><input name="centname4" type="text"  value="<?php echo $centname4; ?>" size="3" class="input" /></td>
    <td  class="innerbiaoti" height="28"><input name="centname5" type="text"  value="<?php echo $centname5; ?>" size="3" class="input" />
      <input type="hidden" name="step" value="centset" /></td>
    <td  class="innerbiaoti" height="28" width="80"><input name="cc1" type="submit" id="cc" value="<?php echo $strModify; ?>" class="button" /></td>
  </tr>
	</form>
  
<?php
$msql->query( "select * from {P}_member_centrule order by event" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$coltype = $msql->f( "coltype" );
		$name = $msql->f( "name" );
		$event = $msql->f( "event" );
		$cent1 = $msql->f( "cent1" );
		$cent2 = $msql->f( "cent2" );
		$cent3 = $msql->f( "cent3" );
		$cent4 = $msql->f( "cent4" );
		$cent5 = $msql->f( "cent5" );
		echo "  <form action=\"member_cent.php\" method=\"get\" >
    <tr>
      <td   width=\"50\" class=\"list\">".coltype2sname( $coltype )."</td>
      <td   width=\"50\" class=\"list\">".$event."</td>
      <td   width=\"150\">".$name."<input type=\"hidden\" name=\"step\" value=\"modi\" /> <input type=\"hidden\" name=\"id\" value=\"".$id."\" /></td>
      <td   width=\"50\"><input name=\"cent1\" type=\"text\" id=\"cent1\" value=\"".$cent1."\" size=\"3\" class=\"input\" /></td>
      <td   width=\"50\"><input name=\"cent2\" type=\"text\" id=\"cent2\" value=\"".$cent2."\" size=\"3\" class=\"input\" /></td>
      <td   width=\"50\"><input name=\"cent3\" type=\"text\" id=\"cent3\" value=\"".$cent3."\" size=\"3\" class=\"input\" /></td>
      <td   width=\"50\"><input name=\"cent4\" type=\"text\" id=\"cent4\" value=\"".$cent4."\" size=\"3\" class=\"input\" /></td>
      <td   height=\"26\"><input name=\"cent5\" type=\"text\" id=\"cent5\" value=\"".$cent5."\" size=\"3\" class=\"input\" /></td>
      <td   height=\"26\" width=\"80\"><input name=\"cc2\" type=\"submit\" id=\"cc\" value=\"".$strModify."\" class=\"button\" /></td>
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