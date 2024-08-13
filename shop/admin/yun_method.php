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
<title><?php echo $strAdminTitle;?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="../../base/js/form.js"></script>
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script type="text/javascript" src="js/yun.js"></script>
</head>
<body >

<?php
$id = $_REQUEST['id'];
$step = $_REQUEST['step'];
if ( $step == "del" )
{
		//$msql->query( "delete from {P}_shop_yun where id='{$id}'" );
}
?>
<div class="formzone">
<div class="tabtopzone">
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr> 
      <td> 
<div class="namezone">
<?php echo $strYunMethodSet;?></div>
      </td>
    <td width="100" align="right"><input type="button" name="Submit" value="<?php echo $strYunMethodAdd;?>" class="button" onClick="self.location='yun_add.php'"></td>
  </tr>
</table>
 </div>

<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr>
    <td width="39" height="26" class="innerbiaoti"><?php echo $strNumber;?></td>
    <td width="50" height="26" class="innerbiaoti"><?php echo $strIdx1;?></td>
    <td width="135" height="26"  class="innerbiaoti"><?php echo $strYunMethod;?></td>
    <td  class="innerbiaoti"><?php echo $strYunSpec;?></td>
    <td width="115" height="26"  class="innerbiaoti"><?php echo $strYunGs;?></td>
    <td width="39" height="26"  class="innerbiaoti"><?php echo $strYunBaojiax;?></td>
    <td width="65"  class="innerbiaoti"><?php echo $strYunBaofei;?> </td>
    <td width="39" height="26" align="center"  class="innerbiaoti"><?php echo $strModify;?></td>
    <!--td width="39" height="26" align="center"  class="innerbiaoti"><?php echo $strDelete;?></td-->
    </tr>
  
<?php
$msql->query( "select * from {P}_shop_yun order by xuhao" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$xuhao = $msql->f( "xuhao" );
		$yunname = $msql->f( "yunname" );
		$dinge = $msql->f( "dinge" );
		$yunfei = $msql->f( "yunfei" );
		$hbcode = $msql->f( "hbcode" );
		$gs = $msql->f( "gs" );
		$baojia = $msql->f( "baojia" );
		$baofei = $msql->f( "baofei" );
		$memo = $msql->f( "memo" );
		$spec = $msql->f( "spec" );
		if ( $dinge == "0" )
		{
				$saygs = $strYunGs2;
		}
		else if ( $dinge == "1" )
		{
				$saygs = $strYunGs1;
		}
		else if ( $dinge == "3" )
		{
				$saygs = $strYunGs4;
		}
		else
		{
				$saygs = $strYunGs3;
		}
		if ( $baojia == "1" )
		{
				$showbaofei = $baofei."%";
		}
		else
		{
				$showbaofei = "-----";
		}
		echo "<tr class=\"list\">
    <td width=\"39\" >".$id."</td>
      <td width=\"50\" >".$xuhao." </td>
      <td width=\"135\" > ".$yunname."</td>
      <td >".$spec."</td>
      <td width=\"115\"  >".$saygs."</td>
      <td width=\"39\"  >";
		showyn( $baojia );
		echo "</td>
      <td width=\"65\"  >".$showbaofei."</td>
      <td width=\"39\" align=\"center\"  > 
          <img src=\"images/edit.png\"  style=\"cursor:hand\" width=\"24\" height=\"24\"  border=0 onClick=\"self.location='yun_modify.php?id=".$id."'\"> 
      </td>
      <!--td width=\"39\" align=\"center\"  ><img src=\"images/delete.png\"  style=\"cursor:hand\" width=\"24\" height=\"24\"  border=0 onClick=\"self.location='yun_method.php?step=del&id=".$id."'\"> 
      </td-->
  </tr>";
}
?>
 
</table>
</div>
</div>
</body>
</html>