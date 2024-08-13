<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 6 );
$pluslable = $_GET['pluslable'];
$coltype = $_GET['coltype'];
if ( $pluslable == "" )
{
				exit( );
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
echo "<script type=\"text/javascript\" src=\"../../base/js/blockui.js\"></script>";
echo "<script type=\"text/javascript\" src=\"js/module.js\"></script>
</head>
<body>
<div class=\"formzone\">
<div class=\"rightzone\">
<div id=\"notice\" style=\"display:none\"></div><form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"plusTempInput\" id=\"plusTempInput\" >".$strTempName." &nbsp;<input type=\"text\" name=\"inputtempname\" id=\"inputtempname\" class=\"input\" size=\"30\" ".switchdis( 100 )." /> &nbsp;<input type=\"file\" name=\"datafile\" id=\"datafile\" size=\"35\" class=\"input\"  ".switchdis( 100 )."  /><input type=\"hidden\" name=\"addtemppluslable\" id=\"addtemppluslable\" value=\"".$pluslable."\" /><input type=\"submit\" id=\"addplustemp\" name=\"addplustemp\" value=\"".$strTempAdd."\" class=\"button\"  ".switchdis( 100 )."  /><input type=\"hidden\" name=\"coltype\" value=\"".$coltype."\" ><input type=\"hidden\" name=\"act\" id=\"act\" value=\"plustempinput\" /></form>&nbsp;&nbsp";
echo "</div><div class=\"namezone\">";
echo $strColTempGl;
echo "</div>
<div class=\"tablezone\">    
      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"6\" id=\"plustemplist\">
        <tr> 
          <td height=\"28\" class=\"innerbiaoti\"> ";
echo $strPlusLable;
echo "          </td>
          <td height=\"28\" class=\"innerbiaoti\">";
echo $strTempName;
echo " </td>
          <td class=\"innerbiaoti\"> ";
echo $strTempFile;
echo " </td>
          <td class=\"innerbiaoti\"> ";
echo $strTempCopy;
echo " </td>
          <td class=\"innerbiaoti\"> ";
echo $strEdit;
echo "</td>
          <td width=\"60\" height=\"28\" class=\"innerbiaoti\">";
echo $strDelete;
echo "          </td>
        </tr>";
$msql->query( "select tempname from {P}_base_plusdefault where pluslable='{$pluslable}' limit 0,1" );
if ( $msql->next_record( ) )
{
				$tempname = $msql->f( "tempname" );
}
echo "      
  <tr class=\"list\"> 
            <td height=\"22\"> ";
echo $pluslable;
echo "</td>
            <td height=\"22\">";
echo $strTempFileDef;
echo "</td>
            <td>";echo "<a href='../../".$coltype."/templates/".$tempname."' target='_blank'>".$tempname."</a>";
				echo "</td>
            <td width=\"60\" height=\"22\"  >";
				echo "<img id=\"copy_origin\" src=\"images/edit.png\" width=\"24\" height=\"24\" name=\"".$coltype."\" class=\"tempmycopy\" />";
				echo "</td>
            <td width=\"60\" height=\"22\"  >---";
echo "</td>
            <td width=\"60\" height=\"22\"  >--- 
            </td>
        </tr>";
$msql->query( "select * from {P}_base_plustemp where pluslable='{$pluslable}' order by id" );
while ( $msql->next_record( ) )
{				
$ismytemp = false;
$id = $msql->f( "id" );
				$pluslable = $msql->f( "pluslable" );
				$cname = $msql->f( "cname" );
				$tempname = $msql->f( "tempname" );
				echo "<tr id=\"tr_";
				echo $id;
				echo "\" class=\"list\"> 
            <td height=\"22\"> ";
				echo $pluslable;
				echo " 
            </td>
            <td height=\"22\">  ";
				echo $cname;
				if(substr( $tempname,4,2) == "p_"){
					$ismytemp = true;
					list($getfold)=explode(".",$tempname);
					$fold = substr( $getfold,6);
					echo " (自定元件模板)";
				}
				echo "</td><td>";
				if($ismytemp){
					echo "<a href='../../".$coltype."/templates/add/".$fold."/".$tempname."' target='_blank'>".$tempname."</a>";
				}else{
					echo "<a href='../../".$coltype."/templates/".$tempname."' target='_blank'>".$tempname."</a>";
				}
			echo "</td>
            <td width=\"60\" height=\"22\"  >";
				echo "<img id=\"copy_".$id."\" src=\"images/edit.png\" width=\"24\" height=\"24\" name=\"".$coltype."\" class=\"tempmycopy\" />";
				echo "</td>
            <td width=\"60\" height=\"22\"  >";
				if($ismytemp){
					echo "<img id=\"modi_".$id."\" src=\"images/modi.png\" width=\"24\" height=\"24\" name=\"".$coltype."\" class=\"tempmymodi\" />";
				}else{
					echo "---";
				}
			echo "</td>
            <td width=\"60\" height=\"22\"  >";
				if(substr( $tempname,4,2) == "p_"){
					echo "<img id=\"del_".$id."\" src=\"images/delete.png\" width=\"24\" height=\"24\" name=\"".$coltype."\" class=\"tempmydel\" />";
				}else{
					echo "---";
				}
				echo "
</td>
          </tr>";}
echo " 
    </table>     
</div>
</div>
</body>
</html>";
?>