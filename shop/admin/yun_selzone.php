<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 311 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle;?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="../../base/js/form.js"></script>
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script type="text/javascript" src="js/selzone.js"></script>
</head>
<body>
<div class="popzone">
<div class="selall">
<div class="selsave">
  <input type="button" id="saveyunzone" class="graybutton" value="<?php echo $strSave;?>" />
   <input type="button" id="closeyunzone" class="graybutton" value="<?php echo $strClose;?>" />
</div>
	<input name="selall" type="checkbox" id="selall"  value="1" /> <?php echo $strSelAll;?></div>

<?php
$msql->query( "select * from {P}_shop_yunzone where pid='0' order by xuhao" );
while ( $msql->next_record( ) )
{
				$id = $msql->f( "id" );
				$zone = $msql->f( "zone" );
				echo "<div class=\"selbigzone\" id=\"selbigzone_".$id."\">
		<div class=\"togDiv\" id=\"togDiv_".$id."\">
			<div class=\"togDivImg_open\" id=\"togDivImg_".$id."\"></div>
		</div>
	<input name=\"z\" type=\"checkbox\" id=\"z_".$id."\" class=\"selbig\" value=\"".$id."\" /> ".$zone."</div>
	<div class=\"selsubzoneall\" id=\"selsubzoneall_".$id."\">";
				$fsql->query( "select * from {P}_shop_yunzone where pid='{$id}' order by xuhao" );
				while ( $fsql->next_record( ) )
				{
								$subid = $fsql->f( "id" );
								$subzone = $fsql->f( "zone" );
								echo "<div class=\"selsubzone\" id=\"selsubzone_".$subid."\">
			<input name=\"z\" type=\"checkbox\" id=\"s_".$subid."\" class=\"selsub_".$id."\" value=\"".$subid."\" /> ".$subzone."</div>";
				}
				echo "</div>";
}
?>
</div>
	</body>
	</html>