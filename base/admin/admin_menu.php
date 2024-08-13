<?php

define( "ROOTPATH", "../../" );

include( ROOTPATH."includes/admin.inc.php" );

include( "language/".$sLan.".php" );

needauth( 8 );

$step = $_REQUEST['step'];

$menu = $_REQUEST['menu'];

$url = $_REQUEST['url'];

$id = $_REQUEST['id'];

$xuhao = $_REQUEST['xuhao'];

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

<SCRIPT>

function cm(nn){

	qus=confirm("<?php echo $strDeleteConfirm; ?>")

	if(qus!=0){

	window.location='admin_menu.php?step=del&id='+nn;

	}

}



</SCRIPT>

</head>

<body>



<?php

if ( $step == "mod" )

{

		$fsql->query( "update {P}_base_adminmenu set menu='{$menu}',url='{$url}',xuhao='{$xuhao}' where  id='{$id}'" );

		echo "<script>self.location='admin_menu.php'</script>";

}

if ( $step == "submodi" )

{

		$submenu = $_REQUEST['submenu'];

		$subid = $_REQUEST['subid'];

		$subxuhao = $_REQUEST['subxuhao'];

		$suburl = $_REQUEST['suburl'];

		$fsql->query( "update {P}_base_adminmenu set menu='{$submenu}',url='{$suburl}',xuhao='{$subxuhao}' where  id='{$subid}'" );

		echo "<script>self.location='admin_menu.php'</script>";

}

if ( $step == "del" )

{

		$fsql->query( "select * from {P}_base_adminmenu where pid='{$id}'" );

		if ( $fsql->next_record( ) )

		{

				err( $strAdminMenuNtc1, "admin_menu.php", "" );

		}

		$fsql->query( "delete from {P}_base_adminmenu where id='{$id}'" );

		echo "<script>self.location='admin_menu.php'</script>";

}

if ( $step == "add" )

{

		$bmenu = $_REQUEST['bmenu'];

		$burl = $_REQUEST['burl'];

		if ( $bmenu == "" )

		{

				err( $strAdminMenuNtc2, "admin_menu.php", "" );

		}

		$msql->query( "select max(xuhao) from {P}_base_adminmenu where pid='0'" );

		if ( $msql->next_record( ) )

		{

				$xuhao = $msql->f( "max(xuhao)" ) + 1;

		}

		$msql->query( "insert into {P}_base_adminmenu set

	pid='0',

	menu='{$bmenu}',

	url='{$burl}',

	xuhao='{$xuhao}'

	" );

		echo "<script>self.location='admin_menu.php'</script>";

}

if ( $step == "addsub" )

{

		$pid = $_REQUEST['pid'];

		$msql->query( "select max(xuhao) from {P}_base_adminmenu where pid='{$pid}'" );

		if ( $msql->next_record( ) )

		{

				$subxuhao = $msql->f( "max(xuhao)" ) + 1;

		}

		$msql->query( "insert into {P}_base_adminmenu set

	pid='{$pid}',

	menu='{$strAdminMenuName}',

	xuhao='{$subxuhao}'

	" );

		echo "<script>self.location='admin_menu.php'</script>";

}

?>

<div class="formzone">

<div class="namezone"><?php echo $strSetMenu2; ?></div>

<div class="tablezone">



<table width="100%" border="0" cellspacing="0" cellpadding="6" align="center">

  <tr>

    <td  class="innerbiaoti" height="28" align="center" width="50"><?php echo $strAdminMenuXuhao; ?></td>

    <td height="28"  class="innerbiaoti"><?php echo $strAdminMenu; ?> / <?php echo $strAdminMenuUrl; ?></td>

    </tr>



<?php

$msql->query( "select * from {P}_base_adminmenu where pid='0' order by xuhao " );

while ( $msql->next_record( ) )

{

		$id = $msql->f( "id" );

		$menu = $msql->f( "menu" );

		$xuhao = $msql->f( "xuhao" );

		$url = $msql->f( "url" );

		echo "  

<form method=\"post\" action=\"admin_menu.php\" id=\"bform_".$id."\">

  <tr class=\"list\">

    <td  height=\"26\"  align=\"center\"> 

        <input type=\"text\" name=\"xuhao\" size=\"3\"  class=\"input\" value=\"".$xuhao."\">

      </td>

      <td   height=\"26\" > 

        <input type=\"text\" name=\"menu\" size=\"25\"  class=\"input\" value=\"".$menu."\" maxlength=\"16\">

        <input name=\"url\" type=\"text\"  class=\"input\" id=\"url\" value=\"".$url."\" size=\"50\" />

        <input type=\"hidden\" name=\"step\" value=\"mod\" />

        <input type=\"hidden\" name=\"id\" value=\"".$id."\" /> 

		 <a href=\"#\" class=\"catmodi\"  onClick=\"document.getElementById('bform_".$id."').submit();\">".$strModify."</a> &nbsp;

        <a href=\"#\" class=\"catmodi\"  onClick=\"cm('".$id."')\">".$strDelete."</a> &nbsp;		

		</td>     

  </tr> 

  </form>

  		";

		$fsql->query( "select * from {P}_base_adminmenu where pid='{$id}' order by xuhao " );

		while ( $fsql->next_record( ) )

		{

				$subid = $fsql->f( "id" );

				$submenu = $fsql->f( "menu" );

				$subxuhao = $fsql->f( "xuhao" );

				$suburl = $fsql->f( "url" );

				echo "

<form method=\"post\" action=\"admin_menu.php\" id=\"sform_".$subid."\">

  <tr class=\"list\">

    <td  height=\"26\"  align=\"center\">&nbsp; 

      </td>

      <td   height=\"26\" > 

        <input type=\"text\" name=\"subxuhao\" size=\"3\"  class=\"input\" value=\"".$subxuhao."\" />

        <input type=\"text\" name=\"submenu\" size=\"15\"  class=\"input\" value=\"".$submenu."\" maxlength=\"16\" />

        <input name=\"suburl\" type=\"text\"  class=\"input\" id=\"suburl\" value=\"".$suburl."\" size=\"50\" />

        <input type=\"hidden\" name=\"step\" value=\"submodi\" />

        <input type=\"hidden\" name=\"subid\" value=\"".$subid."\" /> 

		 <a href=\"#\" class=\"catmodi\"  onClick=\"document.getElementById('sform_".$subid."').submit();\">".$strModify."</a> &nbsp;

        <a href=\"#\" class=\"catmodi\"  onClick=\"cm('".$subid."')\">".$strDelete."</a>

		</td>     

  </tr> 

  </form>

";

		}		

}

?>

<form name="form1" action="admin_menu.php">

 <tr class="list">

 

    <td  height="26"  align="center">

        	</td>

    <td   height="26" >

	<input name="bmenu" type="text"  class="input" value="<?php echo $strAdminMenuName; ?>" size="25" maxlength="16">

	<input name="burl" type="text"  class="input" id="burl" size="50" />

        <input type="submit" name="Submit22" class=button value="<?php echo $strAdminMenuAdd; ?>">

        <input type="hidden" name="step" value="add">



	</td>

  </tr> 

  </form>

</table>

</div>

</div>

</body>

</html>