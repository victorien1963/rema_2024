<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 6 );
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head >\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<link  href=\"css/style.css\" type=\"text/css\" rel=\"stylesheet\">\r\n<title>";
echo $strAdminTitle;
echo "</title>\r\n";
echo "<script type=\"text/javascript\" src=\"../../base/js/base.js\"></script>\r\n";
echo "<script type=\"text/javascript\" src=\"js/module.js\"></script>";
echo "<script type=\"text/javascript\" src=\"../../base/js/blockui.js\"></script>";
echo "\r\n</head>\r\n<body>\r\n\r\n<div class=\"formzone\">\r\n<div class=\"namezone\">\r\n";
echo $strPlusBorderGl;
echo "</div>\r\n<div class=\"tablezone\">\r\n    \r\n      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"6\" id=\"borderlist\">\r\n        <tr > \r\n          <td height=\"28\" class=\"innerbiaoti\"> \r\n           ";
echo $strPlusBorderType;
echo "          </td>\r\n          <td height=\"28\" class=\"innerbiaoti\"> \r\n            ";
echo $strPlusBorderNo;
echo " </td>\r\n          <td class=\"innerbiaoti\"> ";
echo $strPlusBorderName;
echo "</td>\r\n          <td width=\"60\" height=\"28\" class=\"innerbiaoti\"> \r\n           ";
echo $strBorderReviewPic;
echo "</td>\r\n          <td width=\"60\" height=\"28\" class=\"innerbiaoti\"> \r\n           ";
echo $strBorderCopyPic;
echo "</td>\r\n          <td width=\"60\" height=\"28\" class=\"innerbiaoti\"> \r\n           ";
echo $strEdit;
echo "</td>\r\n          <td width=\"60\" height=\"28\" class=\"innerbiaoti\"> \r\n           ";
echo $strDelete;
echo "          </td>\r\n        </tr>\r\n\r\n";
			
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
				$isadd = substr( $tempid,0,2) == "p_" ? "1":"0";
				echo " \r\n          <tr id=\"tr_";
				echo $tempid;
				echo "\" > \r\n            <td height=\"22\" > ";
				echo $btype;
				echo " \r\n            </td>\r\n            <td height=\"22\">  ";
				echo $tempid;
				echo "</td>\r\n            <td>";
				echo $tempname;
				echo "</td>\r\n            <td width=\"60\" height=\"22\"  ><img id=\"prev_";
				echo $tempid;
				echo "\" src=\"images/look.png\" width=\"24\" height=\"24\" class=\"borderprev\" />";
				echo "</td>\r\n            <td width=\"60\" height=\"22\"  ><img id=\"copy_";
				echo $tempid;
				echo "\" src=\"images/edit.png\" width=\"24\" height=\"24\" name=\"".$bordertype."\" class=\"bordercopy\" />";
				echo "</td>\r\n            <td width=\"60\" height=\"22\"  >";
				if($isadd){
				echo "<img id=\"modi_";
				echo $tempid;
				echo "\" src=\"images/modi.png\" width=\"24\" height=\"24\" class=\"bordermodi\" />";
				echo "</td>\r\n            <td width=\"60\" height=\"22\"  ><img id=\"del_";
				echo $tempid;
				echo "\" src=\"images/delete.png\" width=\"24\" height=\"24\" class=\"bordercopydel\" />";
				}else{									echo "<img id=\"modi_";
				echo $tempid;
				echo "\" src=\"images/modi.png\" width=\"24\" height=\"24\" class=\"sysbordermodi\" />";
				echo "</td>\r\n<td width=\"60\" height=\"22\"  >---";
				}
				echo " \r\n\r\n</td>\r\n          </tr>\r\n        ";
}
echo " \r\n    </table>\r\n     \r\n     \r\n</div>\r\n</div>\r\n</body>\r\n</html>\r\n";
?>