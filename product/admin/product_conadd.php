<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
include("func/upload.inc.php");
NeedAuth(185);

$pid=$_REQUEST["pid"];
if(!isset($pid) || $pid==""){
$pid=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="../../base/js/form.js"></script>
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script type="text/javascript" src="js/product.js"></script>
<script>
	function showin(){
			var gvalue = $('#selcatid').val();
			if( gvalue == 1 ){
				$('#showin')[0].style.display='block';
			}else{
				$('#showin')[0].style.display='none';
			}

	}
</script>
</head>
<body >

<form id="productAddForm" name="form" action="" method="post" enctype="multipart/form-data">

<div class="formzone">

<div class="namezone">
<?php echo $strProductFabu; ?>
</div>
<div class="tablezone">
<div  id="notice" class="noticediv"></div>

<table width="100%"   border="0" align="center"  cellpadding="2" cellspacing="0" >
    <tr> 
      <td height="30" width="100" align="center" ><?php echo $strSetMenu3; ?></td>
      <td height="30" > 
        <select id="selcatid" name="catid" onChange="javascript:showin();">
          <?php		

					$fsql -> query ("select * from {P}_product_cat order by catpath");
					while ($fsql -> next_record ()) {
						$lpid = $fsql -> f ("pid");
						$lcatid = $fsql -> f ("catid");
						$cat = $fsql -> f ("cat");
						$catpath = $fsql -> f ("catpath");
						$lcatpath = explode (":", $catpath);


						
						
							for ($i = 0; $i < sizeof ($lcatpath)-2; $i ++) {
								$tsql->query("select catid,cat from {P}_product_cat where catid='$lcatpath[$i]'");
								if($tsql->next_record()){
									$ncatid=$tsql->f('cat');
									$ncat=$tsql->f('cat');
									$ppcat.=$ncat."/";
								}
							}
							
							if($pid==$lcatid){
								echo "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
							}else{
								echo "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
							}
							$ppcat="";
						
						
					}

				
?> 
        </select>        </td>
    </tr>
	 <tr> 
      <td height="30" width="100" align="center" ><?php echo $strProductAddTitle; ?></td>
      <td height="30" > 
        <input type="text" name="title" style='WIDTH: 499px;font-size:12px;' maxlength="200" class="input" />
        <span class="style1">* </span> </td>
    </tr>
	
	 <tr> 
      <td height="30" width="100" align="center" ><?php echo $strProductAddImg; ?><br />布料：195*152<br />坐墊：321x161</td>
      <td height="30" > 
        <input type="file" name="jpg" class="input" style="WIDTH: 499px;" />
        <span class="style1">        </span> </td>
    </tr>
   	</table>
   	<table width="100%"   border="0" align="center"  cellpadding="2" cellspacing="0" id="showin">
   	 <tr> 
      <td height="30" width="100" align="center" ><?php echo $strProductAddImgTitleForShop; ?><br />布料：高度15<br />坐墊不需上傳</td>
      <td height="30" > 
        <input type="file" name="jpgt" class="input" style="WIDTH: 499px;" />
        <span class="style1">        </span> </td>
    </tr>
   	 <tr> 
      <td height="30" width="100" align="center" ><?php echo $strProductAddImgForShop; ?><br />布料：264*161<br />坐墊不需上傳</td>
      <td height="30" > 
        <input type="file" name="jpgb" class="input" style="WIDTH: 499px;" />
        <span class="style1">        </span> </td>
    </tr>
	</table>
	<div id="proplist">
	
	</div>
	<table width="100%"   border="0" align="center"  cellpadding="2" cellspacing="0" >
    <tr>
      <td width="100" height="30" align="center" ><?php echo $strProductMemo; ?></td>
      <td height="30" ><textarea name="memo" style="WIDTH: 499px;font-size:12px;" class="textarea" rows="5"></textarea>
      </td>
    </tr>
	
	<tr>
      <td height="30" width="100" align="center" ><?php echo $strProductAddCon; ?><br />布料：圖寬800，圖高不限<br />坐墊：</td>
      <td height="30" > 
         <textarea name="body" style="width:680px;height:400px;visibility:hidden;"><?php echo $body; ?></textarea>         
<script type="text/javascript" src="../../kedit/kindeditor-min.js"></script>
<script charset="utf-8" src="../../kedit/lang/zh_TW.js"></script>
	<script>
		KindEditor.ready(function(K) {
			var editor = K.create('textarea[name="body"]', {
				uploadJson : '../../kedit/php/upload_json.php?attachPath=product/pics/',
				fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=product/pics/',
				allowFlashUpload : false,
				allowMediaUpload : false,
				allowFileManager : true,
				langType : 'zh_TW',
				syncType: '',
				afterBlur: function () { editor.sync(); }

			});
		});
	</script>
       </td>
    </tr>
    <tr>
      <td height="30" align="center" ><?php echo $strProductTag; ?></td>
      <td height="30" >
	  <input name="tags[]" type="text" class="input" id="tags"  value="" size="10" />
        <input name="tags[]" type="text" class="input" id="tags"  value="" size="10" />
        <input name="tags[]" type="text" class="input" id="tags"  value="" size="10" />
        <input name="tags[]" type="text" class="input" id="tags"  value="" size="10" />
        <input name="tags[]" type="text" class="input" id="tags"  value="" size="10" /></td>
    </tr>
    
	<tr> 
      <td height="30" width="100" align="center" ><?php echo $strProductAddProj; ?></td>
      <td height="30" ><?php

			$catstr.="<SCRIPT language=javascript src='js/multicat.js'></SCRIPT>";
			$catstr.="<table cellspacing=0 cellpadding=0><tr><td ><select style='WIDTH: 239px;font-size:12px;' multiple size=5 name=spe_funct>";
			
			$fsql -> query ("select * from {P}_product_proj order by id desc");
			while ($fsql -> next_record ()) {
				$projid = $fsql -> f ("id");
				$project = $fsql -> f ("project");

				$NowPath=fmpath($projid);
				
				$catstr.="<option value=".$NowPath.">".$project."</option>";
				$ppcat="";
				
				
			}

		$catstr.="</select></td><td width=20>
<input style='width:20px;height=37px;font-size:12px;border:1px outset;' onClick=\"JavaScript:AddItem('spe_funct', 'spe_selec[]')\" type=button value='+' name='Input'>
<input style='width:20px;height=37px;font-size:12px;border:1px outset;' onClick=\"JavaScript:DelItem('spe_selec[]')\" type=button value='-' name='Input'>
				</td>
				<td>
				  <select  style='WIDTH: 239px;font-size:12px' multiple size=5 name=spe_selec[]>";
	
				
		$catstr.="</select></td><td valign=bottom></td><td width=20 align=center  valign='bottom'></td></tr></table>";
		echo $catstr;
?></td>
    </tr>
  
   

</table>
</div>
<div class="adminsubmit">
<input type="submit" name="cc"  onClick="KindSubmit();" value="<?php echo $strSubmit; ?>" class="button" />
<input type="hidden" name="act" value="productadd">
<input type="hidden" name="pid" value="<?php echo $pid; ?>">
<input type="hidden" id="nowid"  value="" />
<input type="hidden" name="author"  value="<?php echo $_COOKIE['SYSNAME']; ?>" />
<input type="hidden" name="source"  value="" />
</div>

</div>
</form>
<script>
$().getPropList();
</script>
</body>
</html>
