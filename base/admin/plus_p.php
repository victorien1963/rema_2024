<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 6 );
$coltype = $_GET['coltype'];
$pluslable = $_GET['pluslable'];
$global = $_GET['global'];
if ( $coltype == "" )
{
				exit( );
}elseif($coltype && $pluslable && $global){
	
	$msql->query( "UPDATE {P}_base_plusdefault SET setglobal='{$global}' WHERE coltype='{$coltype}' and pluslable='{$pluslable}' " );
}
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head >
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<link  href=\"css/style.css\" type=\"text/css\" rel=\"stylesheet\">
<title>";
echo $strAdminTitle;
echo "</title>";
echo "<script type=\"text/javascript\" src=\"../../base/js/base.js\"></script>";
echo "<script type=\"text/javascript\" src=\"../../base/js/form.js\"></script>";
echo "<script type=\"text/javascript\" src=\"../../base/js/blockui.js\"></script>
	<script type=\"text/javascript\" src=\"js/module.js\"></script></head><body>
<div class=\"formzone\">
<div class=\"rightzone\">
<div id=\"notice\" style=\"display:none\"></div>
		<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"plusInput\" id=\"plusInput\" >
  			<input type=\"file\" name=\"datafile\" id=\"datafile\" size=\"35\" class=\"input\"  ".switchdis( 100 )."  />
  			<input type=\"submit\" id=\"addplus\" name=\"addplus\" value=\"".$strPlusInput."\" class=\"button\"  ".switchdis( 100 )."  />
  			<input name=\"act\" type=\"hidden\" id=\"act\" value=\"plusinput\" />
		</form>
</div>

<div class=\"namezone\">";
echo $strColPlusGl." - <a href=\"".ROOTPATH."editpro/ref.php?mode=../".$coltype."/&indir=templates\" target=\"_blank\">模板FTP</a>";
echo "</div><div class=\"tablezone\">    
      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"6\" >
        <tr > 
          <td height=\"28\" class=\"innerbiaoti\">";
echo $strPlusName;
echo " / ";
echo $strPlusLable;
echo " </td>
          <td width=\"110\" class=\"innerbiaoti\">";
echo $strPlusLocat;
echo "</td>
          <td width=\"39\" class=\"innerbiaoti\" >";
echo $strTempNum;
echo " </td>
          <td width=\"150\" class=\"innerbiaoti\">";
echo $strTempFileDef;
echo " </td>
	<td width=\"68\" class=\"innerbiaoti\">";
echo $strPlusOutput;
echo " </td>
          <td width=\"55\" height=\"28\" class=\"innerbiaoti\"> 
           ";
echo $strColTempGl;
echo "</td>
        </tr>
       
        ";
$msql->query( "select * from {P}_base_plusdefault where coltype='{$coltype}' order by id" );
while ( $msql->next_record( ) )
{
				$pluslable = $msql->f( "pluslable" );
				$coltype = $msql->f( "coltype" );
				$plusname = $msql->f( "plusname" );
				$tempname = $msql->f( "tempname" );
				$plustype = $msql->f( "plustype" );
				$pluslocat = $msql->f( "pluslocat" );
				$setglobal = $msql->f( "setglobal" )>0? "<font color='blue'>可</font>設置到全站同一位置":"<font color='red'>不可</font>設置到全站";

				if($plustype=="all" && $pluslocat=="all"){
				$changeglobal = $msql->f( "setglobal" )>0? "<form name=\"form_".$pluslable."\" action=\"plus_p.php?coltype=".$coltype."&pluslable=".$pluslable."&global=-1\" method=\"post\"><input type=\"submit\" value=\"切換不可全站設置\" class=\"button\" /></form>":"<form name=\"form_".$pluslable."\" action=\"plus_p.php?coltype=".$coltype."&pluslable=".$pluslable."&global=1\" method=\"post\"><input type=\"submit\" value=\"切換可全站設置\" class=\"button\" /></form>";
				}else{
				$changeglobal = "";
				}
				
				$tempnum = 0;
				$fsql->query( "select count(id) from {P}_base_plustemp where pluslable='{$pluslable}'" );
				if ( $fsql->next_record( ) )
				{
								$tempnum = $fsql->f( "count(id)" );
				}
				$tempnum = $tempnum + 1;
				echo " 
          <tr class=\"list\"> 
            <td height=\"22\"> ";
				echo $plusname;
				echo "(".$setglobal.") <img src=\"images/str.gif\" class=\"setmoduleedit\" id=\"".$coltype."_".$pluslable."\" style=\"cursor:pointer\"/> <img src=\"images/li.gif\" class=\"setmoduleconfig\" id=\"modid_".$msql->f( "id" )."\" style=\"cursor:pointer\"/><br />
            ";
				echo $pluslable;
				echo "".$changeglobal."</td><td width=\"110\"  >";
				echo $plustype;
				echo "/";
				echo $pluslocat;
				echo "</td>
            <td width=\"39\"  >";
				echo $tempnum;
				echo " </td>
            <td width=\"150\"  >";
				echo $tempname;
				echo " </td><td width=\"68\"  ><input type=\"button\" id='po_".$pluslable."' name=\"plusoutput\" value=\"".$strPlusOutput1."\" class=\"plusoutput\" ".switchdis( 100 )."  />
            </td><td width=\"55\" height=\"22\"  > <input type=\"button\" name=\"Button22\" value=\"";
				echo $strColTempGl;
				echo "\" class=\"button\" onClick=\"self.location='plustemp_p.php?coltype=".$coltype."&pluslable=";
				echo $pluslable;
				echo "'\"   ";
				echo switchdis( 100 );
				echo "  />
              
            </td>
          </tr>
        ";
}
echo " 
    </table>
     
     
</div>
</div>
</body>
</html>
";
?>