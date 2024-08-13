<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/upload.inc.php" );
include( "func/plus.inc.php" );
needauth( 5 );
$step = $_REQUEST['step'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
</head>
<body >

<?php
if ( $step == "add" )
{
		$uppic = $_FILES['jpg'];
		if ( 0 < $uppic['size'] )
		{
				$uppath = "effect/source/bg";
				$arr = newuploadimage( $uppic['tmp_name'], $uppic['type'], $uppic['size'], $uppath );
				$pic = $arr[3];
				echo "<script>parent.\$().pageBgimgList();parent.\$.unblockUI()</script>";
				exit( );
		}
		else
		{
				echo "<script>alert('".$strUploadNotice1."');</script>";
		}
}
?>
<form action="upload_bg.php" method="post" enctype="multipart/form-data" name="form" style="margin:0px">
		<table width="100%" height="100" border="0" cellpadding="0" cellspacing="0">
			<tr> 
              <td align="center" ><?php echo $strPlusPic; ?> &nbsp;
			    <input name="jpg" type="file" id="jpg" style='WIDTH:250px;' class="input" />
			   <input type="submit" name="submit"   value="<?php echo $strConfirm; ?>"  class="button"  />
			   <input name="step" type="hidden" id="step" value="add" />
              </td>
            </tr>
			   
</table>
</form>
</body>
</html>