<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/member.inc.php" );
needauth( 57 );
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
$step = $_REQUEST['step'];
if ( $step == "add" )
{
		$body = $_POST['body'];
		$title = $_POST['title'];
		$membertypeid = $_POST['membertypeid'];
		if ( 65000 < strlen( $body ) )
		{
				err( $strMemberNC3, "", "" );
		}
		if ( $title == "" )
		{
				err( $strMemberNC1, "", "" );
		}
		if ( 200 < strlen( $title ) )
		{
				err( $strMemberNC2, "", "" );
		}
		$title = htmlspecialchars( $title );
		$body = url2path( $body );
		$dtime = time( );
		$msql->query( "insert into {P}_member_notice values(
	0,
	'{$membertypeid}',
	'{$title}',
	'{$body}',
	'{$dtime}',
	'0',
	'0',
	'0',
	'0'

	)" );
		sayok( $strMemberNCPubok, "member_notice.php", $strMemberNCList );
}
?>
 
<div class="formzone">
<form name="form" action="member_notice_add.php" method="post" enctype="multipart/form-data" >

<div class="namezone"><?php echo $strMemberNCPub; ?></div>
<div class="tablezone">
<table width="100%" cellpadding="5" align="center"  style="border-collapse: collapse" border="0" cellspacing="0">
        
<tr>
          <td height="30" width="120" align="right" ><?php echo $strMemberNCTo; ?> :</td>
          <td height="30" >
            
<select name="membertypeid" >
              
<option value='0'><?php echo $strMemberAll; ?></option>
<?php
$fsql->query( "select * from {P}_member_type  order by membertypeid" );
while ( $fsql->next_record( ) )
{
		$lmembertypeid = $fsql->f( "membertypeid" );
		$lmembertype = $fsql->f( "membertype" );
		echo "<option value='".$lmembertypeid."'>".$lmembertype."</option>";
}
?> 
            </select>
          </td>
        </tr>
          <tr> 
            <td height="30" width="120" align="right" ><?php echo $strMemberNCTitle; ?> :</td>
            <td height="30" > 
              <input type="text" name="title" size="60" maxlength="200" class=input>
              <font color="#FF0000">*</font> </td>
          </tr>
          <tr> 
            <td width="120" height="18" align="right">
<span ><?php echo $strMemberNCCon; ?></span>  :             
            </td>
          <td height="18"><input  name="body" type="hidden" />		  
<script type="text/javascript" src="../../kedit/KindEditor.js"></script>            
<script type="text/javascript">
            var editor = new KindEditor("editor");
            editor.hiddenName = "body";
            editor.editorWidth = "700px";
            editor.editorHeight = "250px";
            editor.skinPath = "../../kedit/skins/default/";
			editor.uploadPath = "../../kedit/upload_cgi/upload.php";
			editor.imageAttachPath="member/pics/";
            editor.iconPath = "../../kedit/icons/";
            editor.show();
            function KindSubmit() {
	          editor.data();
            }
             </script>
		  </td>
          </tr>         
      </table>
</div>
<div class="adminsubmit"> 
<input type="submit" name="submit"  onClick="KindSubmit();" value="<?php echo $strSubmit; ?>" class="button">
<input type="hidden" name="step" value="add">
</div>
 </form>
</div>
</body>
</html>