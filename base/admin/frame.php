<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 0 );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script  language="javascript">
	var PDV_RP="<?php echo ROOTPATH;?>";
</script>
<script  language="javascript" src="../js/base.js"></script>
<script  language="javascript" src="js/frame.js"></script>
</head>
<body class="framebody">

<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="150" valign="top">
			<div class="frameleft">
				<ul class="menulist">
					<li id="m0" class="menulist"><?php echo $strSetMenu0; ?></li>
				</ul>
				<ul class="menulist">
<?php
$i = 1;
$msql->query( "select * from {P}_base_adminmenu where pid='0' order by xuhao " );
while ( $msql->next_record( ) )
{
		$menu = $msql->f( "menu" );
		$xuhao = $msql->f( "xuhao" );
		$url = $msql->f( "url" );
		echo "<li id='gm".$i."' class='menulist' onClick=\"document.getElementById('framecon').src='".ROOTPATH.$url."'\">".$menu."</li>";
		$i++;
}
?>  
				</ul>
				<ul class="menulist">
					<li id="m3" class="menulist">
						<?php echo $strSetMenu3; ?>
					</li>
					<li id="pdv_logout" class="menulist">
						<?php echo $strAdminLogout; ?>
					</li>
				</ul>
			</div>
		</td>
		<td valign="top">
			<div class="framemain">
				<iframe id="framecon" src='main.php'  name='con' width='100%' height='100%' scrolling='yes' marginheight='0'  frameborder='0'>IE</iframe> 
			</div>
		</td>
	</tr>
</table>	

</body>
</html>