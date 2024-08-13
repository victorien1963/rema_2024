<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
include("func/upload.inc.php");
NeedAuth(96);

$step=$_REQUEST["step"];
$id=$_REQUEST["id"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>

 <SCRIPT>
function checkform(theform){

  	if(theform.groupname.value.length < 1 || theform.groupname.value=='<?php echo $strGroupAddName; ?>'){
    	alert("<?php echo $strGroupAddName; ?>");
    	theform.groupname.focus();
    	return false;
	}  
	return true;

}  

function checkMainform(theform){

  	if(theform.name.value.length < 1){
    	alert("<?php echo $strTagNTC1; ?>");
    	theform.name.focus();
    	return false;
	}  
	return true;

}  


</SCRIPT>
</head>

<body>
<?php

$url=$_POST["url"];
$name=$_POST["name"];
$pic=$_FILES["suo"];
$xuhao=$_POST["xuhao"];

if($step=="add"){
	if($name==""){
		err($strTagNTC1,"","");
	}


	$url=htmlspecialchars($url);
	$name=htmlspecialchars($name);

	if ($pic["size"] > 0)  {


		$nowdate=date("Ymd",time());
		$picpath=ROOTPATH."shop/pics/".$nowdate;
		@mkdir($picpath,0777);
		$uppath="shop/pics/".$nowdate;

		$arr=NewUploadImage($pic["tmp_name"],$pic["type"],$pic["size"],$uppath);
		$src=$arr[3];
		
	}


	$msql->query("insert into {P}_shop_tag set
	name='$name',
	xuhao='0',
	src='$src'
	");

	echo "<script>self.location='sale_tag.php'</script>";


}




if($step=="modify"){
	if($name==""){
		err($strTagNTC1,"","");

	}

	$url=htmlspecialchars($url);
	$name=htmlspecialchars($name);
	$src = $_POST['oldsrc'];
	
	if ($pic["size"] > 0)  {

		$nowdate=date("Ymd",time());
		$picpath=ROOTPATH."shop/pics/".$nowdate;
		@mkdir($picpath,0777);
		$uppath="shop/pics/".$nowdate;

		$arr=NewUploadImage($pic["tmp_name"],$pic["type"],$pic["size"],$uppath);
		$src=$arr[3];
		
	$msql->query("select src from {P}_shop_tag where id='$id'");
	if($msql->next_record()){
		$oldsrc=$msql->f('src');
		$oldsrc_a=dirname($msql->f('src'));
		$oldsrc_b=basename($msql->f('src'));
		$oldsrcs = $oldsrc_a."/sp_".$oldsrc_b;
	}
	$fname=ROOTPATH.$oldsrc;
	$fnames=ROOTPATH.$oldsrcs;
	if(file_exists($fname) && $oldsrc!=""){
		unlink($fname);
		$msql->query("select * from {P}_shop_con where saletag='{$oldsrc}'");
		while($msql->next_record()){
			$fsql->query("update {P}_shop_con set saletag='{$src}' where id='{$msql->f(id)}' ");
		}
	}
	if(file_exists($fnames) && $oldsrc!=""){
		unlink($fnames);
	}
		
	}
	$msql->query("update {P}_shop_tag set name='$name',xuhao='$xuhao',src='$src' where id='$id' ");
}


if($step=="del"){
	$msql->query("select src from {P}_shop_tag where id='$id'");
	if($msql->next_record()){
		$oldsrc=$msql->f('src');
		$oldsrc_a=dirname($msql->f('src'));
		$oldsrc_b=basename($msql->f('src'));
		$oldsrcs = $oldsrc_a."/sp_".$oldsrc_b;
	}
	$fname=ROOTPATH.$oldsrc;
	$fnamse=ROOTPATH.$oldsrcs;
	if(file_exists($fname) && $oldsrc!=""){
		unlink($fname);
	}
	if(file_exists($fnames) && $oldsrc!=""){
		unlink($fnames);
	}

	$msql->query("delete from {P}_shop_tag where id='$id'");
}
?>
<div class="formzone">
<div class="namezone"><?php echo $strLinkAdd; ?></div>
<form method="post" action="sale_tag.php" enctype="multipart/form-data" onSubmit="return checkMainform(this)" >
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" height="22">
   
      <tr> 

        <td  height="26" width="80"><?php echo $strTagName; ?> 
        </td>
        <td  height="24" width="230"><input type="text" name="name" size="26" class="input" />
          <span style="color:#ff0000">*</span> </td>
        <td  height="26" width="80"><?php echo $strTagPicUp; ?></td>
        <td  height="24" valign="top"><input type="file" name="suo" size="60" class="input" />        </td>
        <td  height="24" colspan="2" valign="top"><input type="submit" name="Submit" value="<?php echo $strAdd; ?>"  class="button" />
          <input type="hidden" name="step" value="add" />
        </tr>
    
  </table>

</div>
</form>

<div class="namezone"><?php echo $strTagSys; ?></div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr > 
      <td width="54" height="24"   class="innerbiaoti"> <?php echo $strXuhao; ?></td>
      <td width="150" class="innerbiaoti"><?php echo $strTagName; ?></td>
      <td height="24"  class="innerbiaoti"> <?php echo $strTagPic; ?></td>
      <td height="24"  class="innerbiaoti" width="60"> <?php echo $strModify; ?></td>
      <td  class="innerbiaoti" height="24" width="60"> <?php echo $strDelete; ?></td>
    </tr>
    <?php 


$msql->query("select * from {P}_shop_tag order by xuhao asc,id desc");


while($msql->next_record()){
$id=$msql->f('id');
$name=$msql->f('name');
$xuhao=$msql->f('xuhao');
$src=$msql->f('src');
?> 
    <form action="sale_tag.php" method="post" enctype="multipart/form-data" >
      <tr class="list"> 
        <td height="45"   width="54"> 
          
            <input type="text" name="xuhao" size="2" value="<?php echo $xuhao; ?>" class="input">
         
        </td>
        <td width="150"><input type="text" name="name" size="20" value="<?php echo $name; ?>" maxlength="200" class="input" />
        </td>
        <td height="45"><input type="file" name="suo" size="60" value="" class="input"><input type="hidden" name="oldsrc" value="<?php echo $src;?>" /> <?php 
if($src!=""){
$src=ROOTPATH.$src;
echo ShowTypeImage($src,$type,"","",0);

}else{
echo " ";
}
?></td>
        <td height="45"  width="60"> 
          <div align="center"> 
            <input type="hidden" name="step" value="modify">
            <input type="hidden" name="groupid" value="<?php echo $groupid; ?>" />
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="submit" name="cc" value="<?php echo $strModify; ?>" class="button" />
          </div>
        </td>
        <td width="60" height="45"> 
          <div align="center"> 
            <input type="button" name="cc" value="<?php echo $strDelete; ?>" onClick="self.location='sale_tag.php?step=del&id=<?php echo $id; ?>'"  class="button">
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
</body>
</html>