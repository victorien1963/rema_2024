<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 0 );
$coltype = $_GET['coltype'];
if ( $coltype == "" )
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
<script type="text/javascript" src="../../base/js/form.js"></script>
<script type="text/javascript" src="js/module.js"></script>
</head>
<body>

<div class="formzone">
	<div class="rightzone">
		<div id="notice" style="display:none"></div>
		<form action="" method="post" enctype="multipart/form-data" name="plusInput" id="plusInput" >
  			<input type="file" name="datafile" id="datafile" size="35" class="input"  <?php echo switchdis( 100 ); ?>  />
  			<input type="submit" id="addplus" name="addplus" value="<?php echo $strPlusInput; ?>" class="button"  <?php echo switchdis( 100 ); ?>  />
  			<input name="act" type="hidden" id="act" value="plusinput" />
		</form>
	</div>
	<div class="namezone"><?php echo $strColPlusGl; ?></div>
	<div class="tablezone">    
      <table width="100%" border="0" cellspacing="0" cellpadding="6" >
        <tr > 
          <td height="28" class="innerbiaoti"> <?php echo $strPlusName; ?> / <?php echo $strPlusLable; ?> </td>
          <td width="110" class="innerbiaoti"><?php echo $strPlusLocat; ?> </td>
          <td width="39" class="innerbiaoti" ><?php echo $strTempNum; ?> </td>
          <td width="150" class="innerbiaoti"><?php echo $strTempFileDef; ?> </td>
          <td width="68" class="innerbiaoti"><?php echo $strPlusOutput; ?> </td>
          <td width="55" height="28" class="innerbiaoti"><?php echo $strColTempGl; ?> </td>
        </tr> 
<?php
$msql->query( "select * from {P}_base_plusdefault where coltype='{$coltype}' order by id" );
while ( $msql->next_record( ) )
{
		$pluslable = $msql->f( "pluslable" );
		$plusname = $msql->f( "plusname" );
		$tempname = $msql->f( "tempname" );
		$plustype = $msql->f( "plustype" );
		$pluslocat = $msql->f( "pluslocat" );
		$tempnum = 0;
		$fsql->query( "select count(id) from {P}_base_plustemp where pluslable='{$pluslable}'" );
		if ( $fsql->next_record( ) )
		{
				$tempnum = $fsql->f( "count(id)" );
		}
		$tempnum = $tempnum + 1;
		echo " 
          <tr class=\"list\"> 
            <td height=\"22\"> ".$plusname."<br /> ".$pluslable."</td>
            <td width=\"110\"  >".$plustype."/".$pluslocat."</td>
            <td width=\"39\"  >".$tempnum." </td>
            <td width=\"150\"  >".$tempname." </td>
            <td width=\"68\"  ><input type=\"button\" id='po_".$pluslable."' name=\"plusoutput\" value=\"".$strPlusOutput1."\" class=\"plusoutput\" ".switchdis( 100 )."  />
            </td>
            <td width=\"55\" height=\"22\"  >              
                <input type=\"button\" name=\"Button22\" value=\"".$strColTempGl."\" class=\"button\" onClick=\"self.location='plustemp.php?pluslable=".$pluslable."'\" ".switchdis( 100 )."  />
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