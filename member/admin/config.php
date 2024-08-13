<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 51 );
$step = $_REQUEST['step'];
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
if ( $step == "modify" )
{
		$var = $_POST['var'];
		while ( list( $key, $val ) = each($var) )
		{
				$msql->query( "update {P}_member_config set value='{$val}' where variable='{$key}'" );
		}
		sayok( $strConfigOk, "config.php", "" );
}
?>
<div class="formzone">
<form name="form1" method="post" action="config.php">
<div class="namezone">
<?php echo $strNewsSet; ?></div>
<div class="tablezone">
          <table width="100%" border="0" align="center" cellpadding="8" cellspacing="0">
            <tr> 
              <td class="innerbiaoti"><strong><?php echo $strConfigName; ?></strong></td>
              <td class="innerbiaoti"  width="300" height="28">
<strong><?php echo $strConfigSet; ?></strong></td>
            </tr>            
<?php
$msql->query( "select * from {P}_member_config  order by xuhao" );
while ( $msql->next_record( ) )
{
		$variable = $msql->f( "variable" );
		$value = $msql->f( "value" );
		$vname = $msql->f( "vname" );
		$settype = $msql->f( "settype" );
		$colwidth = $msql->f( "colwidth" );
		$intro = $msql->f( "intro" );
		$intro = str_replace( "\n", "<br>", $intro );
		echo " 
            <tr class=\"list\"> 
              <td style=\"line-height:20px;padding-right:30px\">";
		echo "<strong>".$vname." : </strong><br> ".$intro."</td>
              <td width=\"300\" height=\"20\"> ";
		if ( $settype == "YN" )
		{
				echo "<input type=\"radio\" name=\"var[".$variable."]\" value=\"1\" ".checked( $value, "1" ).">".$strYes."<input type=\"radio\" name=\"var[".$variable."]\" value=\"0\" ".checked( $value, "0" ).">".$strNo." ";
		}
		else if ( $settype == "MTYPE" )
		{
				echo "<select name=\"var[".$variable."]\" >";
				$msql->query( "select * from {P}_member_type" );
				while ( $msql->next_record( ) )
				{
						if ( $value == $msql->f( "membertypeid" ) )
						{
								echo "<option value='".$msql->f( "membertypeid" )."' selected>".$msql->f( "membertype" )."</option>";
						}
						else
						{
								echo "<option value='".$msql->f( "membertypeid" )."'>".$msql->f( "membertype" )."</option>";
						}
				}
				echo "</select>";
		}
		else
		{
				echo "<input  type=\"text\" name=\"var[".$variable."]\"   value=\"".$value."\" size=\"".$colwidth."\" class=\"input\" />";
		}
		echo "</td></tr>";
}
?>
            
    </table>
</div>
<div class="adminsubmit">
  <input name="cc2" type="submit" id="cc" value="<?php echo $strSubmit; ?>" class="button" />
  <input type="hidden" name="step" value="modify" />
</div>

</form>
</div>
</body>
</html>