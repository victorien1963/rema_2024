<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 6 );

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head >
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<link  href=\"css/style.css\" type=\"text/css\" rel=\"stylesheet\">
<title>".$strAdminTitle."</title>
<script type=\"text/javascript\" src=\"../../base/js/base.js\"></script>
<script type=\"text/javascript\" src=\"../../base/js/blockui.js\"></script>
<script type=\"text/javascript\" src=\"js/module.js\"></script>
</head>
<body>
<div class=\"formzone\">
<div class=\"namezone\">".$strSetMenu10."</div>
<div class=\"tablezone\">    
      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"6\" >
        <tr > 
          <td width=\"110\" height=\"28\" class=\"innerbiaoti\">".$strColName."</td>
          <td width=\"110\" height=\"28\" class=\"innerbiaoti\">".$strColSName."</td>
          <td width=\"110\" class=\"innerbiaoti\">".$strColType."</td>
          <td class=\"innerbiaoti\">".$strColPlusNum."</td>
          <td width=\"80\" height=\"28\" class=\"innerbiaoti\">".$strColPlusGl."</td>
        </tr>";
$msql->query( "select * from {P}_base_coltype order by moveable asc,id asc" );
while ( $msql->next_record( ) )
{
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
            <td width=\"110\" height=\"22\">".$colname."</td>
            <td width=\"110\" height=\"22\">".$sname."</td>
            <td width=\"110\">".$coltype."</td>
            <td>".$plusnum."</td>
            <td width=\"80\" height=\"22\"  >";
				if ( $coltype == "base" )
				{
								echo "<input type=\"button\" name=\"Button22\" value=\"".$strPlusBorderGl."\" class=\"button1\" onClick=\"self.location='plusborder_p.php'\" ".switchdis( 100 )." />";
				}
				else
				{
								echo "<input type=\"button\" name=\"Button22\" value=\"".$strColPlusGl."\" class=\"button\" onClick=\"self.location='plus_p.php?coltype=".$coltype."'\"  ".switchdis( 100 )."  />";
				}
				echo "
            </td>
          </tr>";
}
echo "</table>
</div>
</div>
</body>
</html>";
?>