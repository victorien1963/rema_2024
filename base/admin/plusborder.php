<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 6 );
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
	<div class="rightzone"><?php echo $strPlusBorderNo; ?>
		<input type="text" class="input" id="bordertempid" size="4" maxlength="4" /> &nbsp;<?php echo $strPlusBorderName; ?>
		<input type="text" id="bordertempname" class="input" size="25" />
			<select name="bordertype" id="bordertype">
  				<option value="border"><?php echo $strPlusBorderType1; ?></option>
  				<option value="lable"><?php echo $strPlusBorderType2; ?></option>
			</select>
			<select name="borderselcolor" id="borderselcolor">
  				<option value="no"><?php echo $strPlusBorderNoColor; ?></option>
  				<option value="yes"><?php echo $strPlusBorderSelColor; ?></option>
			</select>
		<input type="button" id="addborder" name="addborder" value="<?php echo $strPlusBorderAdd; ?>" class="button" />
	</div>
	<div class="namezone"><?php echo $strPlusBorderGl; ?></div>
	<div class="tablezone">    
      <table width="100%" border="0" cellspacing="0" cellpadding="6" id="borderlist">
        <tr > 
          <td height="28" class="innerbiaoti"> <?php echo $strPlusBorderType; ?> </td>
          <td height="28" class="innerbiaoti"> <?php echo $strPlusBorderNo; ?> </td>
          <td class="innerbiaoti"> <?php echo $strPlusBorderName; ?> </td>
          <td width="60" height="28" class="innerbiaoti"> <?php echo $strDelete; ?> </td>
        </tr>
<?php
$msql->query( "select * from {P}_base_border order by tempid" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$bordertype = $msql->f( "bordertype" );
		$tempid = $msql->f( "tempid" );
		$tempname = $msql->f( "tempname" );
		if ( $bordertype == "lable" )
		{
				$btype = $strPlusBorderType2;
		}
		else
		{
				$btype = $strPlusBorderType1;
		}
		echo " 
          <tr id=\"tr_".$tempid."\" > 
            <td height=\"22\" > ".$btype." </td>
            <td height=\"22\"> ".$tempid."</td>
            <td>".$tempname."</td>
            <td width=\"60\" height=\"22\"  ><img id=\"del_".$tempid."\" src=\"images/delete.png\" width=\"24\" height=\"24\" class=\"borderdel\" /></td>
          </tr>
        ";
}
?>
      </table>
	</div>
</div>
</body>
</html>