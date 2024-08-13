<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include( ROOTPATH."includes/pages.inc.php" );
include("language/".$sLan.".php");
include("func/upload.inc.php");
NeedAuth(0);

$step=$_REQUEST["step"];
$id=$_REQUEST["id"];
$page=$_REQUEST["page"];
$key=$_POST["key"];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>

 <SCRIPT>
function cm(nn){
qus=confirm("確定要刪除？")
	if(qus!=0){
		window.location='black.php?step=del&id='+nn;
	}
}
</SCRIPT>
</head>

<body>
<?php

$addr=$_POST["addr"];
$name=$_POST["name"];
$mobi=$_POST["mobi"];
$memberid=$_POST["memberid"];
$notice=$_POST["notice"];

if($step=="add"){
	
	if($addr=="" && $name=="" && $mobi=="" && $memberid==""){
		err("至少輸入一項資訊","","");
	}

	$addr=htmlspecialchars($addr);
	$name=htmlspecialchars($name);
	$mobi=htmlspecialchars($mobi);
	$memberid = htmlspecialchars($memberid);
	$notice = htmlspecialchars($notice);
	
	/*會員編號重複*/
	$msql->query("SELECT memberid FROM {P}_member_black WHERE memberid='$memberid'");
	if($msql->next_record()){
		err("會員編號已經存在","","");
		exit();
	}

	$msql->query("insert into {P}_member_black set
	memberid='$memberid',
	name='$name',
	phone='$mobi',
	addr='$addr',
	notice='$notice'
	");

	echo "<script>self.location='black.php?page=".$page."'</script>";

}

if($step=="modify"){

	if($addr=="" && $name=="" && $mobi=="" && $memberid==""){
		err("至少輸入一項資訊","","");
	}

	$addr=htmlspecialchars($addr);
	$name=htmlspecialchars($name);
	$mobi=htmlspecialchars($mobi);
	$memberid = htmlspecialchars($memberid);
	$notice = htmlspecialchars($notice);
	
	$msql->query("update {P}_member_black set memberid='$memberid',name='$name',phone='$mobi',addr='$addr',notice='{$notice}' where id='$id' ");
}


if($step=="del"){

	$msql->query("delete from {P}_member_black where id='$id'");
}

/**/
$scl = "  id!='0' "; 

if( $key ){
	$scl .= " and (memberid regexp '{$key}' or name regexp '{$key}' or phone regexp '{$key}' or addr regexp '{$key}')  ";
}

if ( !isset( $shownum ) || $shownum < 20 ){
		$shownum = 20;
}

$totalnums = tblcount( "_member_black", "id", $scl );
$pages = new pages( );
$pages->setvar( array(
		"shownum" => $shownum,
		"key" => $key
) );
$pages->set( $shownum, $totalnums );
$pagelimit = $pages->limit( );

?>
<div class="searchzone">
<form method="post" action="black.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="30">
  <tr>                   
      <td  height="30">  <form method="get" action="black.php" >
		<input type="text" name="key" size="30" value="<?php echo $key; ?>" class="input" />
		 <input type="submit" name="Submit" value="搜尋" class="button" />       
      </form>           
      </td>
  </tr>
</table>
</div>
<div class="formzone">
<div class="namezone">新增黑名單</div>
<form method="post" action="black.php" enctype="multipart/form-data" >
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" height="22">
   
      <tr> 
        <td  height="26" width="80">會員編號</td>
        <td  height="24" width="80"><input type="text" name="memberid" size="5" class="input" /></td>
        <td  height="26" width="30">姓名</td>
        <td  height="24" width="150"><input type="text" name="name" size="20" class="input" /></td>          	
        <td  height="24" width="30">手機</td>        
        <td  height="24" width="150"><input type="text" name="mobi" value="" size="20" class="input" /></td>         
        <td  height="26" width="30">地址</td>
        <td  height="24" width="150"><input type="text" name="addr" size="40" class="input" /></td>
        <td  height="26" width="30">原因</td>
        <td  height="24" width="150"><input type="text" name="notice" size="40" class="input" /></td>
        <td  height="24" ><input type="submit" name="Submit" value="<?php echo $strAdd; ?>"  class="button" />
          <input type="hidden" name="step" value="add" />
          <input type="hidden" name="page" value="<?php echo $page; ?>" />
          <input type="hidden" name="id" value="<?php echo $id; ?>" /></td>
      </tr>
  </table>

</div>
</form>

<div class="namezone">購物黑名單列表</div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr > 
      <td width="54" height="24"   class="innerbiaoti"><?php echo $strXuhao; ?></td>
      <td width="100" class="innerbiaoti">會員編號</td>
      <td width="100" class="innerbiaoti">姓名</td>
      <td width="100" height="24" class="innerbiaoti">手機</td>
      <td width="150" height="24"  class="innerbiaoti">地址</td>
      <td width="150" height="24"  class="innerbiaoti">原因</td>
      <td height="24"  class="innerbiaoti" width="60"> <?php echo $strModify; ?></td>
      <td  class="innerbiaoti" height="24" width="60"> <?php echo $strDelete; ?></td>
    </tr>
    <?php 


$msql->query("select * from {P}_member_black where {$scl} limit {$pagelimit}");


while($msql->next_record()){
$id=$msql->f('id');
$memberid=$msql->f('memberid');
$name=$msql->f('name');
$mobi=$msql->f('phone');
$addr=$msql->f('addr');
$notice=$msql->f('notice');

?> 
    <form action="black.php" method="post" enctype="multipart/form-data" >
      <tr class="list"> 
        <td height="45"   width="30">
    		<?php echo $id; ?>
        </td>
        <td width="100"><input type="text" name="memberid" size="5" value="<?php echo $memberid; ?>" maxlength="200" class="input" />
        </td>
        <td width="100"><input type="text" name="name" size="10" value="<?php echo $name; ?>" maxlength="200" class="input" />
        </td>
        <td  width="100" height="45"> 
          
            <input type="text" name="mobi" size="30" value="<?php echo $mobi; ?>" class="input">
          
        </td>
        <td height="45"><input type="text" size="40" name="addr" value="<?php echo $addr;?>" class="input" /></td>
        <td height="45"><input type="text" size="40" name="notice" value="<?php echo $notice;?>" class="input" /></td>
        <td height="45"  width="60"> 
          <div align="left"> 
            <input type="hidden" name="step" value="modify">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="page" value="<?php echo $page; ?>" />
<input type="submit" name="cc" value="<?php echo $strModify; ?>" class="button" />
          </div>
        </td>
        <td width="60" height="45"> 
          <div align="left"> 
            <input type="button" name="cc" value="<?php echo $strDelete; ?>" onClick="cm(<?php echo $id; ?>)"  class="button">
          </div>
        </td>
      </tr>
    </form>
    <?php
}
?> 
</table>
</div>
</div>
	<?php
$pagesinfo = $pages->shownow( );
?>
<div id="showpages">
	  <div id="pagesinfo"><?php echo $strPagesTotalStart.$totalnums.$strPagesTotalEnd;?> <?php echo $strPagesMeiye.$pagesinfo['shownum'].$strPagesTotalEnd;?> <?php echo $strPagesYeci;?> <?php echo $pagesinfo['now']."/".$pagesinfo['total'];?></div>
	  <div id="pages"><?php echo $pages->output( 1 );?></div>
</div>
</body>
</html>
