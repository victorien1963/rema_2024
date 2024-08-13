<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/pages.inc.php" );
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
<SCRIPT>
function cm(nn){
qus=confirm("<?php echo $strDeleteConfirm; ?>")
if(qus!=0){
window.location='member_notice.php?step=del&id='+nn;
}
}
</SCRIPT>
</head>
<body>

<?php
$step = $_REQUEST['step'];
$title = $_REQUEST['title'];
$xuhao = $_REQUEST['xuhao'];
$ifnew = $_REQUEST['ifnew'];
$ifred = $_REQUEST['ifred'];
$id = $_REQUEST['id'];
$page = $_REQUEST['page'];
$pid = $_REQUEST['pid'];
$key = $_REQUEST['key'];
if ( $step == "mod" )
{
		$msql->query( "update {P}_member_notice set xuhao='{$xuhao}',ifnew='{$ifnew}',ifred='{$ifred}' where id='{$id}'  " );
}
if ( $step == "del" )
{
		$msql->query( "delete from {P}_member_notice where id='{$id}' " );
}
?>
<div class="formzone">
<div class="namezone"><?php echo $strMemberNCManage; ?></div>
<div class="tablezone">
<?php
$scl = " id!='' ";
$totalnums = tblcount( "_member_notice", "id", $scl );
$pages = new pages( );
$pages->setvar( array(
		"key" => $key
) );
$pages->set( 10, $totalnums );
$pagelimit = $pages->limit( );
?>
<table width="100%" border="0" cellspacing="0" cellpadding="6" align="center">
  <tr> 
    <td width="60" height="28"  class="innerbiaoti"><?php echo $strXuhao; ?></td>
    <td height="28" class="innerbiaoti" width="120"><?php echo $strMemberNCTo; ?></td>
    <td height="28" class="innerbiaoti"><?php echo $strMemberNCTitle; ?></td>
    <td height="28" width="50"  class="innerbiaoti"><?php echo $strMemberNCBrowse; ?></td>
    <td height="28" width="50"  class="innerbiaoti"><?php echo $strMemberNCNew; ?></td>
    <td height="28" width="50"  class="innerbiaoti"><?php echo $strMemberNCRed; ?></td>
    <td height="28" width="32"  class="innerbiaoti"><?php echo $strModify; ?></td>
    <td height="28" width="32"  class="innerbiaoti"> 
      <div align="center"><?php echo $strEdit; ?></div>
    </td>
    <td height="28" width="32"  class="innerbiaoti"> 
      <div align="center"><?php echo $strDelete; ?></div>
    </td>
  </tr>
  
<?php
$msql->query( "select * from {P}_member_notice where {$scl} order by id desc  limit {$pagelimit}" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$membertypeid = $msql->f( "membertypeid" );
		$title = $msql->f( "title" );
		$xuhao = $msql->f( "xuhao" );
		$cl = $msql->f( "cl" );
		$ifnew = $msql->f( "ifnew" );
		$ifred = $msql->f( "ifred" );
		echo " 
  <form action=\"member_notice.php\" method=\"get\">
    <tr class=\"list\"> 
      <td width=\"60\"  > 
        <input type=\"text\" name=\"xuhao\" size=\"3\" value=\"".$xuhao."\" class=input>
      </td>
      <td  width=\"120\">".membertypeid2membertype( $membertypeid )."</td>
      <td > 
       ".$title."        <input type=\"hidden\" name=\"id\" value=\"".$id."\">
        <input type=\"hidden\" name=\"page\" value=\"".$page."\">
        <input type=\"hidden\" name=\"pid\" value=\"".$pid."\">
        <input type=\"hidden\" name=\"key\" value=\"".$key."\">
        </td>
      <td width=\"50\" >".$cl."</td>
      <td width=\"50\" > 
        <select name=\"ifnew\">
          <option value=\"1\" ".seld( $ifnew, "1" ).">".$strYes."</option>
          <option value=\"0\" ".seld( $ifnew, "0" ).">".$strNo."</option>
        </select>
      </td>
      <td width=\"50\" > 
        <select name=\"ifred\">
          <option value=\"1\" ".seld( $ifred, "1" ).">".$strYes."</option>
          <option value=\"0\" ".seld( $ifred, "0" ).">".$strNo."</option>
        </select>
      </td>
      <td width=\"32\" >  
        <input type=\"hidden\" name=\"step\" value=\"mod\">
         
        <input type=\"image\" border=\"0\" name=\"imageField\" src=\"images/modi.png\">
      </td>
      <td width=\"32\" > 
        <div align=\"center\"> <img src=\"images/edit.png\" style=\"cursor:pointer\"  onClick=\"window.location='member_notice_mod.php?id=".$id."'\"> 
        </div>
      </td>
      <td width=\"32\"  align=\"center\"> <img src=\"images/delete.png\"  style=\"cursor:pointer\"  onClick=\"cm('".$id."')\"> 
      </td>
    </tr>
  </form>
  ";
}
?> 
</table>
</div>
</div>
<?php $pagesinfo = $pages->shownow( ); ?>
<div id="showpages">
	  <div id="pagesinfo"><?php echo $strPagesTotalStart.$totalnums.$strPagesTotalEnd; ?> <?php echo $strPagesMeiye.$pagesinfo['shownum'].$strPagesTotalEnd; ?> <?php echo $strPagesYeci; ?> <?php echo $pagesinfo['now']."/".$pagesinfo['total']; ?></div>
	  <div id="pages"><?php echo $pages->output( 1 ); ?></div>
</div>
</body>
</html>