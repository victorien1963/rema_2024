<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 311 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="../../base/js/form.js"></script>
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script type="text/javascript" src="js/yun.js"></script>
</head>
<body >
<div class="formzone">
<div class="namezone">
<?php echo $strYunZoneSet; ?></div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr>
   <td width="50" class="innerbiaoti"><?php echo $strXuhao; ?></td>
    <td class="innerbiaoti"><?php echo $strYunZone; ?></td>
    <td class="innerbiaoti">&nbsp;</td>
    <td class="innerbiaoti">&nbsp;</td>
  </tr>
  </table>
<div id="bigcatall">

<?php
$newxuhao = 1;
$msql->query( "select * from {P}_shop_yunzone where pid=0 order by xuhao" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$zone = $msql->f( "zone" );
		$xuhao = $msql->f( "xuhao" );
		echo " 
<div class=\"bigcat\" id=\"bigcat_".$id."\">
        <input id=\"xuhao_".$id."\" type=\"text\" size=\"3\" value=\"".$xuhao."\" class=\"input\" />
        <input id=\"zone_".$id."\" type=\"text\" size=\"39\" value=\"".$zone."\" class=\"input\" />
     	 <input type=\"button\" class=\"button_zone_modify\" id=\"topZoneModi_".$id."\" value=\"".$strModify."\">
		 <input type=\"button\" class=\"button_zone_del\" id=\"topZoneDel_".$id."\" value=\"".$strDelete."\">
		 <input type=\"button\" class=\"button_zone_open\" id=\"topZoneOpen_".$id."\" value=\"".$strYunZoneOpen."\">
</div>
";
		$newxuhao = $xuhao + 1;
}
?>
 

</div>
<br />
<div class="bigcat" id="addnewcat">
        <input id="newxuhao" type="text" size="3" value="<?php echo $newxuhao; ?>" class="input" />
        <input id="newzone" type="text" size="39" value="<?php echo $strYunNTC2; ?>" class="input" onFocus="this.value=''" />
     	 <input type="button" id="addYunZone" value="<?php echo $strYunZoneAdd; ?>" class="button" />
</div>

</div>
</div>
</body>
</html>