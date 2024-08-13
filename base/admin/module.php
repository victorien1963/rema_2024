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
<script type="text/javascript" src="../../base/js/base132.js"></script>
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script type="text/javascript" src="js/module.js"></script>
</head>
<body>

<div class="formzone">
<div class="rightzone">
<div id="notice" style="display:none"></div>
<form action="" method="post"  name="getNewCol" id="getNewCol">   

   <input name="phpwebUser" type="hidden" id="phpwebUser" value="<?php echo $GLOBALS['CONF']['phpwebUser']; ?>" />
  <select name="instcoltype" id="instcoltype" style="width: 150px;">
   	<option value="advs">廣告管理模組</option>
   	<option value="member">會員管理模組</option>
   	<option value="news">文章管理模組</option>
   	<option value="shop">商品購物模組</option>
   	<option value="paper">電子報模組</option>
   	<option value="feedback">表單模組</option>
  </select>
  <input type="button" id="instbutton" name="instbutton" value="<?php echo $strColInstall; ?>" class="button" />
</form>
</div>
<div class="namezone"><?php echo $strSetMenu6; ?></div>

<div class="tablezone">    
      <table width="100%" border="0" cellspacing="0" cellpadding="6" >
        <tr > 
          <td width="110" height="28" class="innerbiaoti"> <?php echo $strColName; ?> </td>
          <td width="110" height="28" class="innerbiaoti"> <?php echo $strColSName; ?> </td>
          <td width="110" class="innerbiaoti"> <?php echo $strColType; ?> </td>
          <td class="innerbiaoti"> <?php echo $strColPlusNum; ?> </td>
          <td width="80" class="innerbiaoti"> <?php echo $strColIU; ?> </td>
          <td width="80" height="28" class="innerbiaoti" style="display:none;"> <?php echo $strColPlusGl; ?> </td>
        </tr>
<?php
$msql->query( "select * from {P}_base_coltype order by moveable asc,id asc" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$coltype = $msql->f( "coltype" );
		$colname = $msql->f( "colname" );
		$sname = $msql->f( "sname" );
		$moveable = $msql->f( "moveable" );
		$installed = $msql->f( "installed" );
		$fsql->query( "select count(id) from {P}_base_plusdefault where coltype='{$coltype}'" );
		if ( $fsql->next_record( ) )
		{
				$plusnum = $fsql->f( "count(id)" );
		}
		echo " 
          <tr class=\"list\" id=\"tr_".$coltype."\"> 
            <td width=\"110\" height=\"22\"> ".$colname." 
            </td>
            <td width=\"110\" height=\"22\"> <input id=\"siten_".$id."\" class=\"modiname\" value=\"".$sname."\" style=\"height:18px;width:60%\" readonly /></td>
            <td width=\"110\">".$coltype." </td>
            <td>".$plusnum." </td>
            <td width=\"80\">
			";
		if ( $moveable == "1" )
		{
				echo "<input type=\"button\" id=\"uninstall_".$coltype."\" name=\"Button11\" value=\"".$strColUnInstall."\" class=\"uninstall\"  ".switchdis( 100 )." />";
		}
		else
		{
				echo "<input type=\"button\"  name=\"Button11\" value=\"".$strColUnInstall."\" class=\"nouninstall\" disabled=\"true\" />";
		}
		echo "</td>
            <td width=\"80\" height=\"22\"  style=\"display:none;\">";
		if ( $coltype == "base" )
		{
				echo "<input type=\"button\" name=\"Button22\" value=\"".$strPlusBorderGl."\" class=\"button1\" onClick=\"self.location='plusborder.php'\" ".switchdis( 100 )."  style=\"display:none;\"/>";
		}
		else
		{
				echo "<input type=\"button\" name=\"Button22\" value=\"".$strColPlusGl."\" class=\"button\" onClick=\"self.location='plus.php?coltype=".$coltype."'\"  ".switchdis( 100 )."   style=\"display:none;\"/>";
		}
		echo "</td> </tr>";
}
?>
    			</table>
			</div>
		</div>
	</body>
</html>