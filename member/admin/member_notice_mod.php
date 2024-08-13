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
$body = $_REQUEST['body'];
$title = $_POST['title'];
$id = $_REQUEST['id'];
if ( $step == "2" )
{
		if ( $title == "" )
		{
				err( $strMemberNC1, "", "" );
		}
		if ( 200 < strlen( $title ) )
		{
				err( $strMemberNC2, "", "" );
		}
		if ( 65000 < strlen( $body ) )
		{
				err( $strMemberNC3, "", "" );
		}
		$body = url2path( $body );
		$title = htmlspecialchars( $title );
		$msql->query( "update {P}_member_notice set body='{$body}',title='{$title}' where id='{$id}' " );
		sayok( $strModifyOk, "member_notice.php", "" );
}
$msql->query( "select * from {P}_member_notice where id='{$id}'" );
if ( $msql->next_record( ) )
{
		$body = $msql->f( "body" );
		$title = $msql->f( "title" );
		$id = $msql->f( "id" );
		$body = htmlspecialchars( $body );
		$body = path2url( $body );
}
?>
<div class="formzone">
<form name="form" action="member_notice_mod.php" method="post" enctype="multipart/form-data">

<div class="namezone">
<?php echo $strMemberNCEdit; ?></div>
<div class="tablezone">
  <table width="100%" cellpadding="6" align="center" border="0" cellspacing="0">
    <tr>
      <td width="120" height="30" align="right" ><?php echo $strMemberNCTitle; ?> : </td>
      <td height="30" ><input name="title" type="text" class="input" value="<?php echo $title; ?>" size="60" maxlength="200" />
          <font color="#FF0000">*</font> </td>
    </tr>
    <tr>
      <td width="120" align="right"><?php echo $strMemberNCCon; ?> :  </td>
      <td height="18"><input  name="body" type="hidden" value="<?php echo $body; ?>" />
	  
<script type="text/javascript" src="../../kedit/KindEditor.js"></script>
            
<script type="text/javascript">
            var editor = new KindEditor("editor");
            editor.hiddenName = "body";
            editor.editorWidth = "700px";
            editor.editorHeight = "300px";
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
<input type="submit" name="submit"   value="<?php echo $strSubmit; ?>" class="button" onClick="KindSubmit();" />
<input type="hidden" name="step" value="2" />
<input type="hidden" name="id" value="<?php echo $id; ?>" />
</div>
</form>

</div>
</body>
</html>