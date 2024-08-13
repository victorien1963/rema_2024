<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
NeedAuth(186);
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

</head>

<body >
    
<?php

$id=$_REQUEST["id"];
$pid=$_REQUEST["pid"];

$msql->query("select * from {P}_product_con where  id='$id'");
if($msql->next_record()){
$id=$msql->f('id');
$catid=$msql->f('catid');
$title=$msql->f('title');
$memo=$msql->f('memo');
$body=$msql->f('body');
$xuhao=$msql->f('xuhao');
$cl=$msql->f('cl');
$tj=$msql->f('tj');
$ifnew=$msql->f('ifnew');
$ifred=$msql->f('ifred');
$iffb=$msql->f('iffb');
$src=$msql->f('src');
$type=$msql->f('type');
$author=$msql->f('author');
$source=$msql->f('source');
$secure=$msql->f('secure');
$oldproj=$msql->f('proj');
$oldcatid=$msql->f('catid');
$oldcatpath=$msql->f('catpath');
$tags=$msql->f('tags');
$srcb = ROOTPATH.$msql->f('srcb');
$srct = ROOTPATH.$msql->f('srct');
$body=htmlspecialchars($body);
$body=Path2Url($body);


$dtime=date("Y-m-d H:i:s",$msql->f('dtime'));
$uptime=date("Y-m-d H:i:s",$msql->f('uptime'));

$tags=explode(",",$tags);

}

?> 

<form id="productForm" name="form" action="" method="post" enctype="multipart/form-data">
<div class="formzone">
<div class="namezone">
<?php echo $strProductModify; ?>
</div>
<div class="tablezone">
<div  id="notice" class="noticediv"></div>
      <table class="productmodizone" width="100%" cellpadding="2" align="center"  border="0" cellspacing="0">
         
		  <tr> 
            <td height="30" width="100" align="center" ><?php echo $strSetMenu3; ?></td>
            <td height="30" > 
              <select id="selcatid" name="catid" >
                <?php		

				//非公共区域
					if($catid=="0"){
						echo "<option value='0' selected>".$strPersonPic."</option>";
					}

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
							
							if($catid==$lcatid){
								echo "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
							}else{
								echo "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
							}
							$ppcat="";
						}
						
					
				
?> 
              </select>
            </td>
          </tr>
		   <tr> 
            <td height="30" width="100" align="center" ><?php echo $strProductAddTitle; ?></td>
            <td height="30" > 
              <input type="text" id="title" name="title" style='WIDTH: 499px;' maxlength="200" class="input" value="<?php echo $title; ?>" />
              <font color="#FF0000">*</font> </td>
          </tr>
      </table>
		   <table width="100%"   border="0" align="center"  cellpadding="2" cellspacing="0" >

  			
		  <tr> 
            <td height="30" width="100" align="center" ><?php echo $strProductAddImg; ?><br />布料：195*152<br />坐墊：321x161px</td>
            <td height="30" > 
              <input id="uppic" type="file" name="jpg" class="input" style='WIDTH: 499px;' />
			  <input  type='submit' name='modi' onClick="KindSubmit();" value='<?php echo $strProductUpload; ?>' class='savebutton' style="display:none;" />
		    </td>
          </tr>
		  
		   <tr style="display:none;">
		     <td height="30" align="center" >&nbsp;</td>
		     <td height="30"><div id="productpages"></div></td>
        </tr>
		<tr>
		     <td align="center" ></td>
		     <td ><img id="picpriview" src="images/loading.gif" /></td>
		     </tr>
		       <?php
					if( $pid < 2 ){	
				?>
		<tr> 
            <td height="30" width="100" align="center" ><?php echo $strProductAddImgTitleForShop; ?><br />布料：高度15<br />坐墊不需上傳</td>
            <td height="30" > 
              <input id="uppict" type="file" name="jpgt" class="input" style='WIDTH: 499px;' />
		    </td>
          </tr>
		<tr>
		     <td align="center" ></td>
		     <td ><img id="picpriviewt" src="<?php echo $srct; ?>" onerror="this.src='images/loading.gif'" /></td>
		     </tr>
		<tr> 
            <td height="30" width="100" align="center" ><?php echo $strProductAddImgForShop; ?><br />布料：264*161<br />坐墊不需上傳</td>
            <td height="30" > 
              <input id="uppicb" type="file" name="jpgb" class="input" style='WIDTH: 499px;' />
		    </td>
          </tr>
		<tr>
		     <td align="center" ></td>
		     <td ><img id="picpriviewb" src="<?php echo $srcb; ?>" onerror="this.src='images/loading.gif'" /></td>
		     </tr>
		     <?php
				}
			?>
      </table>
	<div id="proplist" class="productmodizone">
	</div>
		 
         <table class="productmodizone" width="100%"   border="0" align="center"  cellpadding="2" cellspacing="0" >
		 <tr>
            <td width="100" height="30" align="center" ><?php echo $strProductMemo; ?></td>
            <td height="30" ><textarea name="memo" style="WIDTH: 499px;" class="textarea" rows="5"><?php echo $memo; ?></textarea>
            </td>
          </tr>
		  
		  <tr>
      <td height="30" width="100" align="center" ><?php echo $strProductAddCon; ?></td><br />布料：圖寬800，圖高不限<br />坐墊：</td>
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
	  	<input name="tags[]" type="text" class="input" id="tags"  value="<?php echo $tags[0]; ?>" size="10" />
        <input name="tags[]" type="text" class="input" id="tags"  value="<?php echo $tags[1]; ?>" size="10" />
        <input name="tags[]" type="text" class="input" id="tags"  value="<?php echo $tags[2]; ?>" size="10" />
        <input name="tags[]" type="text" class="input" id="tags"  value="<?php echo $tags[3]; ?>" size="10" />
        <input name="tags[]" type="text" class="input" id="tags"  value="<?php echo $tags[4]; ?>" size="10" /></td>
    </tr>
		  <tr> 
            <td height="30" width="100" align="center" ><?php echo $strProductAddProj; ?></td>
            <td height="30" ><?php
			$catstr.="<SCRIPT language=javascript src='js/multicat.js'></SCRIPT>";
			$catstr.="<table cellspacing=0 cellpadding=0><tr><td ><select style='WIDTH: 239px;' multiple size=5 name=spe_funct>";
			$fsql -> query ("select * from {P}_product_proj order by id desc");
			while ($fsql -> next_record ()) {
				$projid = $fsql -> f ("id");
				$project = $fsql -> f ("project");
				$NowPath=fmpath($projid);
				$catstr.="<option value=".$NowPath.">".$project."</option>";
				$ppcat="";
			}

$catstr.="</select></td><td width=20>
<input style='width:20px;height=37px;border:1px outset;' onClick=\"JavaScript:AddItem('spe_funct', 'spe_selec[]')\" type=button value='+' name='Input'>
<input style='width:20px;height=37px;border:1px outset;' onClick=\"JavaScript:DelItem('spe_selec[]')\" type=button value='-' name='Input'>
				</td>
				<td>
				  <select  style='WIDTH: 239px;font-size:12px' multiple size='5' name='spe_selec[]'>";
					$arrs = explode (":",$oldproj);
					for ($k = 0; $k < sizeof ($arrs)-1; $k ++) {
						$projid=$arrs[$k]+0;
						$tsql->query("select project from {P}_product_proj where id='$projid'");
						if($tsql->next_record()){
							$project=$tsql->f('project');
						}
						$catstr.="<option value=".$arrs[$k].">".$project."</option>";
					}
		$catstr.="</select></td><td valign=bottom></td><td width=20 align=center  valign=bottom></td></tr></table>";
		echo $catstr;
?> </td>
          </tr>
          <tr> 
            <td height="30" width="100" align="center" ><?php echo $strFbtime; ?></td>
            <td height="30" ><?php echo $dtime; ?></td>
          </tr>
          <tr> 
            <td height="30" width="100" align="center" ><?php echo $strUptime; ?></td>
            <td height="30" ><?php echo $uptime; ?> </td>
          </tr>
          
          
        
      </table>
	 
</div>  
<div class="adminsubmit">
<input id="adminsubmit" type="submit" name="modi" onClick="KindSubmit();"  value="<?php echo $strSave; ?>" class="button" />
<input type="hidden" id="act" name="act" value="productmodify" />
<input type="hidden" id="nowid" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="oldcatid" value="<?php echo $oldcatid; ?>" />
<input type="hidden" name="oldcatpath" value="<?php echo $oldcatpath; ?>" />
<input type="hidden" name="pid" value="<?php echo $pid; ?>" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
<input type="hidden" name="source" value="<?php echo $source; ?>" />
<input type="hidden" name="author"  value="<?php echo $author; ?>" />
</div> 
</div>
</form>
<script>
$().getPropList();
$().getProductPages(0);
$().getContent(0);
</script>
</body>
</html>
