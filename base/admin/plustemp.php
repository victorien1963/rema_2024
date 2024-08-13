<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 6 );
$pluslable = $_GET['pluslable'];
if ( $pluslable == "" )
{
		exit( );
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="js/module.js"></script>
</head>
<body>

<div class="formzone">
<div class="rightzone"><?php echo $strTempName; ?>
 <input type="text" id="addtempcname" class="input" size="30"  <?php echo switchdis( 100 ); ?> /> &nbsp;<?php echo $strTempFile; ?>
 <input type="text" id="addtempname" class="input" size="30"  <?php echo switchdis( 100 ); ?> />
<input type="hidden" id="addtemppluslable" value="<?php echo $pluslable; ?>" />
<input type="button" id="addtemp" name="addtemp" value="<?php echo $strTempAdd; ?>" class="button"   <?php echo switchdis( 100 ); ?> />
</div>
<div class="namezone"><?php echo $strColTempGl; ?></div>
<div class="tablezone">    
      <table width="100%" border="0" cellspacing="0" cellpadding="6" id="plustemplist">
        <tr > 
          <td height="28" class="innerbiaoti"> <?php echo $strPlusLable; ?> </td>
          <td height="28" class="innerbiaoti"> <?php echo $strTempName; ?> </td>
          <td class="innerbiaoti"> <?php echo $strTempFile; ?> </td>
          <td width="60" height="28" class="innerbiaoti"> <?php echo $strDelete; ?> </td>
        </tr>
<?php
$msql->query( "select tempname from {P}_base_plusdefault where pluslable='{$pluslable}' limit 0,1" );
if ( $msql->next_record( ) )
{
		$tempname = $msql->f( "tempname" );
}
?>
      
  <tr > 
            <td height="22"> <?php echo $pluslable; ?> </td>
            <td height="22"> <?php echo $strTempFileDef; ?> </td>
            <td> <?php echo $tempname; ?> </td>
            <td width="60" height="22"  >---              
            </td>
        </tr>

<?php
$msql->query( "select * from {P}_base_plustemp where pluslable='{$pluslable}' order by id" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$pluslable = $msql->f( "pluslable" );
		$cname = $msql->f( "cname" );
		$tempname = $msql->f( "tempname" );
		echo " 
          <tr id=\"tr_".$id."\"> 
            <td height=\"22\"> ".$pluslable." 
            </td>
            <td height=\"22\">  ".$cname."</td>
            <td>".$tempname."</td>
            <td width=\"60\" height=\"22\"  ><img id=\"del_".$id."\" src=\"images/delete.png\" width=\"24\" height=\"24\" class=\"tempdel\" /> 
             
            </td>
          </tr>
        ";
}
?> 
    </table>
</div>
</div>
</body>
</html>