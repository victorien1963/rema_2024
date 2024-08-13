<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
include( "func/upload.inc.php" );
NeedAuth(0);

#---------------------------------------------#

$step=$_REQUEST["step"];


//新增
if($step=="add"){
	
	$msql->query("select max(xuhao) from {P}_base_language");
	if($msql->next_record()){
		$newxuhao=$msql->f('max(xuhao)')+1;
	}

	$msql->query("insert into {P}_base_language set 
	title='新語言',
	showtitle='顯示語言名稱',
	langcode='語言代碼',
	src='',
	xuhao='$newxuhao',
	ifshow='1'
	");
}

//修改
if($step=="modi"){
	
	$id=$_REQUEST["id"];
	$xuhao=htmlspecialchars($_REQUEST["xuhao"]);
	$title=htmlspecialchars($_REQUEST["title"]);
	$showtitle=htmlspecialchars($_REQUEST["showtitle"]);
	$langcode=htmlspecialchars($_REQUEST["langcode"]);
	$ifshow=$_REQUEST["ifshow"];
	$ifdefault=$_REQUEST["ifdefault"];
	$oldsrc=$_REQUEST["oldsrc"];
	$orilan = $_REQUEST["orilan"];
	
	
	//如果是預設值，則其他語言先改為非預設
	if($ifdefault=="1"){
		$msql->query("update {P}_base_language SET ifdefault='0' WHERE ifdefault='1'");
				/*修改 config.inc.php預設語言檔*/
					/*$filename = ROOTPATH."config.inc.php";
					$handle = fopen($filename,"r");
					while (!feof($handle)) {
						$data .= fgets($handle);
			        }
			        fclose($handle);
			        $handle = fopen($filename,"w");
			        $data = str_replace($orilan,$langcode,$data);
					$iflock && flock($handle,LOCK_EX);
					fwrite($handle,$data);
					fclose($handle);
					$chmod && @chmod($filename,0777);*/
					
					/*修改預設語言檔檔名*/
					if($orilan != $langcode){
						$fileList=glob(ROOTPATH."*");
						for ($i=0; $i<count($fileList); $i++) {
							if(is_dir($fileList[$i])){
								$gg = glob($fileList[$i]."/*");
								foreach($gg AS $islan){
									if(strpos($islan,"language") !== false){
										@rename($islan."/".$orilan.".php",$islan."/".$langcode.".php");
									}
									if(strpos($islan,"admin") !== false){
										@rename($islan."/language/".$orilan.".php",$islan."/language/".$langcode.".php");
									}
								}
							}
						}
					}
					$newlan = $langcode;
					$dlang = $langcode;
					/**/
					
	}else{
		$getd = $msql->getone("SELECT id FROM {P}_base_language WHERE ifdefault='1' AND id!='{$id}'");
		if(!$getd["id"]){
			$ifdefault="1";
		}
	}
	
	/*複製新語言檔*/
		$fileList=glob(ROOTPATH."*");
		for ($i=0; $i<count($fileList); $i++) {
			if(is_dir($fileList[$i])){
				$gg = glob($fileList[$i]."/*");
				foreach($gg AS $islan){
					if(strpos($islan,"language") !== false){
							if(!is_file($islan."/".$langcode.".php")){
								@copy($islan."/".$orilan.".php",$islan."/".$langcode.".php");
							}
					}
					if(strpos($islan,"admin") !== false){
							if(!is_file($islan."/language/".$langcode.".php")){
								@copy($islan."/language/".$orilan.".php",$islan."/language/".$langcode.".php");
							}
					}
					if($islan == ROOTPATH."base/templates"){
							if(!is_file($islan."/header_".$langcode.".htm")){
								@copy($islan."/header.htm",$islan."/header_".$langcode.".htm");
							}
							if(!is_file($islan."/foot_".$langcode.".htm")){
								@copy($islan."/foot.htm",$islan."/foot_".$langcode.".htm");
							}
					}
				}
			}
		}
	/**/
	
	
	$msql->query("update {P}_base_language set 
	title='$title',
	showtitle='$showtitle',
	langcode='$langcode',
	ifshow='$ifshow',
	xuhao='$xuhao',
	ifdefault='$ifdefault' 
	where id='$id'");
	
				$file = $_FILES['file'];
				if ( 0 < $file['size'] )
				{
								$Meta = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
								$picpath = ROOTPATH."images/flags/";
								createFolderdDIR( $picpath );
								$uppath = "images/flags";
								$filearr = newuploadfile( $file['tmp_name'], $file['type'], $file['name'], $file['size'], $uppath );
								if ( $filearr[0] != "err" )
								{
												$fileurl = $filearr[3];
								}
								else
								{
												echo $Meta.$filearr[1];
												exit( );
								}
								if ( file_exists( $oldsrc ) )
								{
												unlink( $oldsrc );
								}
				$msql->query( "UPDATE {P}_base_language SET src='{$fileurl}' WHERE id='$id'" );
				}
				
				$msql->query( "SELECT langcode FROM {P}_base_language WHERE ifshow='1'" );
				while( $msql->next_record() ){
					$sLanList .= $sLanList?  ',"'.$msql->f(langcode).'"':'"'.$msql->f(langcode).'"';
				}
				$sLanList .= ',""';
	
}

//刪除
if($step=="del"){
	$id=$_REQUEST["id"];
	$oldsrc = $_REQUEST["oldsrc"];
	if ( file_exists( $oldsrc ) )
	{
		unlink( $oldsrc );
	}
	$getmod = $msql->getone("SELECT langcode FROM {P}_base_language WHERE id='$id'");
	
	$msql->query("delete from {P}_base_language where id='$id'");
	
	$langcode = $getmod["langcode"];
	/*刪除相關語言檔*/
		$fileList=glob(ROOTPATH."*");
		for ($i=0; $i<count($fileList); $i++) {
			if(is_dir($fileList[$i])){
				$gg = glob($fileList[$i]."/*");
				foreach($gg AS $islan){
					if(strpos($islan,"language") !== false){
							if(is_file($islan."/".$langcode.".php")){
								@unlink($islan."/".$langcode.".php");
							}
					}
					if(strpos($islan,"admin") !== false){
							if(is_file($islan."/language/".$langcode.".php")){
								@unlink($islan."/language/".$langcode.".php");
							}
					}
					if($islan == ROOTPATH."base/templates"){
							if(is_file($islan."/header_".$langcode.".htm")){
								@unlink($islan."/header_".$langcode.".htm");
							}
							if(is_file($islan."/foot_".$langcode.".htm")){
								@unlink($islan."/foot_".$langcode.".htm");
							}
					}
				}
			}
		}
	/**/
	
	$msql->query( "SELECT langcode FROM {P}_base_language WHERE ifshow='1'" );
	while( $msql->next_record() ){
		$sLanList .= $sLanList?  ',"'.$msql->f(langcode).'"':'"'.$msql->f(langcode).'"';
	}
	$sLanList .= ',""';
}

if($step && $step!="add"){
	//修改配置文件
	
	$ConFile = ROOTPATH."config.inc.php";
	$SysConfigFile = "func/inc.php";

	
	//$siteurl="http://".$_SERVER["HTTP_HOST"]."/";
	if($dlang){
		$DefaultsLan = $dlang;
	}else{
		$DefaultsLan = $sLan;
	}
	
	$filestr = fread(fopen($SysConfigFile, 'r'),30000);
	$filestr=str_replace(" ","",$filestr);
	$filestr=str_replace("DefaultDbHost",$dbHost,$filestr);
	$filestr=str_replace("DefaultDbName",$dbName,$filestr);
	$filestr=str_replace("DefaultDbUser",$dbUser,$filestr);
	$filestr=str_replace("DefaultDbPass",$dbPass,$filestr);
	$filestr=str_replace("DefaultsLan",$DefaultsLan,$filestr);
	$filestr=str_replace("DefaultTablePre",$TablePre,$filestr);
	$filestr=str_replace("DefaultSiteUrl",$SiteUrl,$filestr);
	$filestr=str_replace("DefaultaLanList",$sLanList,$filestr);

	fwrite(fopen($ConFile,"w"),$filestr,30000);
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $strAdminTitle; ?></title>
	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../../base/admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../base/admin/assets/css/fonts.css">
	<link rel="stylesheet" href="../../base/admin/assets/font-awesome/css/font-awesome.min.css">
	
	<!-- PAGE LEVEL PLUGINS STYLES -->
	<link rel="stylesheet" href="../../base/admin/assets/css/plugins/footable/footable.min.css">
	<link rel="stylesheet" href="../../base/admin/assets/css/plugins/select2/select2.css">
	<link rel="stylesheet" href="../../base/admin/assets/css/plugins/bootstrap-select/bootstrap-select.min.css">
	<link rel="stylesheet" href="../../base/admin/assets/css/plugins/bootstrap-wysihtml/bootstrap-wysihtml5.css">
	<link rel="stylesheet" href="../../base/admin/assets/css/plugins/datetime/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="../../base/admin/assets/css/plugins/bootstrap-datepicker/datepicker.css">
		
	<!-- REQUIRE FOR SPEECH COMMANDS -->
	<link rel="stylesheet" type="text/css" href="../../base/admin/assets/css/plugins/gritter/jquery.gritter.css" />	

    <!-- Tc core CSS -->
	<link id="qstyle" rel="stylesheet" href="../../base/admin/assets/css/themes/style.css">	
	
    <!-- Add custom CSS here -->

	<!-- End custom CSS here -->
	
    <!--[if lt IE 9]>
    <script src="../../base/admin/assets/js/html5shiv.js"></script>
    <script src="../../base/admin/assets/js/respond.min.js"></script>
    <![endif]-->
    
  </head>

  <body style="background-color:#f5f5f5;">
	<div id="right-wrapper">
<!-- START MAIN PAGE CONTENT -->

<div class="row">
	<div class="col-lg-12">									
		<div class="portlet">
			<div class="portlet-heading dark">
				<div class="portlet-title">
					<h4>多國語言設置</h4>
				</div>
				<div class="portlet-widgets">
					<a data-toggle="collapse" data-parent="#accordion" href="#f-2"><i class="fa fa-chevron-down"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div id="f-2" class="panel-collapse collapse in">
				<div class="portlet-body">
						<button type="button" class="btn btn-success" onClick="window.location='multilang.php?step=add&groupid=<?php echo $groupid; ?>&pid=0'"><i class="fa fa-pencil-square"></i> 新增語言</button>
							<input type="hidden" name="step" value="chgname" />
							<input type="hidden" name="groupid" value="<?php echo $groupid; ?>" />
				</div>
				<div class="portlet-body no-padding">
					<div id="basic" class="panel-collapse collapse in">
						<div class="portlet-body no-padding">
							<table class="table table-bordered table-striped table-hover tc-table table-primary footable" data-page-size="50" data-editable="true">
								<thead>
									<tr>
										<th data-sort-ignore="true" class="center">序號</th>
										<th data-sort-ignore="true">語言名稱</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">前台顯示名稱</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">語言(檔)代碼</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">語言(國家)圖片</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">圖片上傳</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">是否啟用</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">預設語言</th>
										<th data-sort-ignore="true" class="col-medium center">動　 作</th>
									</tr>
								</thead>
								<tbody>
<?php 
	//選單開始
	$cc=0;
	$msql->query("select * from {P}_base_language order by xuhao");
	while($msql->next_record()){
		$id=$msql->f('id');
		$xuhao=$msql->f('xuhao');
		$title=$msql->f('title');
		$showtitle=$msql->f('showtitle');
		$langcode=$msql->f('langcode');
		$src=$msql->f('src');
		$ifshow=$msql->f('ifshow');
		$ifdefault=$msql->f('ifdefault');
		if($src){
			$src = ROOTPATH.$src;
		}else{
			$src = "http://placehold.it/120x50/#ffffff/#000000";
		}
		if($ifdefault == "1"){
			$orilan = "<input type='hidden' name='orilan' id='orilan' value='".$langcode."' />";
		}else{
			$orilan = "";
		}
?> 
										<form id="form_<?php echo $id; ?>" class="form" method="post" action="multilang.php" enctype="multipart/form-data" name="colset_<?php echo $id; ?>">
									<tr>
										<td class="center">
										<input type="text" class="form-control input-mini" name="xuhao" value="<?php echo $xuhao; ?>"></td>
										<td><input type="text" class="form-control" name="title" value="<?php echo $title; ?>"></td>
										<td><input type="text" class="form-control" name="showtitle" id="showtitle_<?php echo $id; ?>" value="<?php echo $showtitle; ?>"></td>
										<td><input type="text" class="form-control" name="langcode" id="langcode_<?php echo $id; ?>" value="<?php echo $langcode; ?>"></td>
										<td align="absmiddle"><img src="<?php echo $src; ?>" style="max-width:120px;" /></td>
										<td style="max-width:150px;">
											<div class="input-group">
												<span class="input-group-btn">
													<span class="btn btn-file" > 瀏覽檔案<input type="file" name="file" id="file_<?php echo $id; ?>" /></span>
												</span>
												<input type="text" class="form-control" readonly="">
											</div>
										</td>
										<td>
											<select class="form-control" name="ifshow" id="ifshow_<?php echo $id; ?>">
												<option value="1" <?php echo seld($ifshow,'1'); ?>><?php echo $strShow; ?></option>
	          									<option value="0" <?php echo seld($ifshow,'0'); ?>><?php echo $strHidden; ?></option>
          									</select>
          								</td>
										<td>
											<label>
												<input id="ifdefault_<?php echo $id; ?>" class="tc tc-switch tc-switch-6" type="checkbox" <?php echo checked($ifdefault,'1'); ?>/>
												<span class="labels"></span>
											</label>
											<input type="hidden" id="getdefault_<?php echo $id; ?>" name="ifdefault" value="<?php echo $ifdefault; ?>" />
          								</td>
										<td class="col-medium center">
											<div class="btn-group btn-group-sm ">
												<button type="button" id="btn_<?php echo $id; ?>_<?php echo $cc; ?>" class="btn btn-inverse sub" title="<?php echo $strModify; ?>"><i class="fa fa-pencil icon-only"></i></button>
												<a href="javascript:;" class="btn btn-danger" title="<?php echo $strDelete; ?>" onClick="window.location='multilang.php?step=del&groupid=<?php echo $groupid; ?>&id=<?php echo $id; ?>&oldsrc=<?php echo $src; ?>'"><i class="fa fa-times icon-only"></i></a>
											</div>	
										<input type="hidden" name="id" value="<?php echo $id; ?>" />
								        <input type="hidden" name="step" value="modi" />
										<input type="hidden" name="oldsrc" value="<?php echo $src; ?>" />
										<?php echo $orilan; ?>
										</td>
									</tr>
										</form>
<?php
	$cc++;
	}
	//選單結束
?> 
								</tbody>
								<tfoot>
									<tr>
										<td colspan="7">
											<ul class="hide-if-no-paging pagination pagination-centered pull-right"></ul>
											<div class="clearfix"></div>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
									
				</div>
			</div>
		</div>
	</div>
</div>
	
<!-- END MAIN PAGE CONTENT -->
	</div> 
	
	<!-- core JavaScript -->
    <script src="../../base/admin/assets/js/jquery.min.js"></script>
    <script src="../../base/admin/assets/js/bootstrap.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/pace/pace.min.js"></script>

		
	<!-- Themes Core Scripts -->	
	<script src="../../base/admin/assets/js/main.js"></script>
		
	<!-- wayhunt & module -->
	<script src="../../base/js/form.js"></script>
	<script src="js/frame.js"></script>
		
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="index.php">Home</a></li><li class="active">設置</li>');
			$('#pagetitle', window.parent.document).html('系統設置 <span class="sub-title" id="subtitle">多國語言設置</span>');
			//呼叫左側功能選單
			$().getMenuGroup('config');
		});
	</script>
	<!-- PAGE LEVEL PLUGINS JS -->
	<script src="../../base/admin/assets/js/plugins/footable/footable.min.js"></script>
	
	<script src="../../base/admin/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/datatables/datatables.js"></script>
	<script src="../../base/admin/assets/js/plugins/datatables/datatables.responsive.js"></script>
	
	<script src="../../base/admin/assets/js/plugins/duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/select2/select2.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/bootstrap-select/bootstrap-select.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/masked-input/jquery.maskedinput.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/bootstrap-wysihtml/wysihtml.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/bootstrap-wysihtml/bootstrap-wysihtml.js"></script>
	<script src="../../base/admin/assets/js/plugins/bootstrap-markdown/markdown.js"></script>
	<script src="../../base/admin/assets/js/plugins/bootstrap-markdown/bootstrap-markdown.js"></script>	
	<script src="../../base/admin/assets/js/plugins/bootbox/bootbox.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/bootstrap-wysiwyg/jquery.hotkeys.js"></script>
	<script src="../../base/admin/assets/js/plugins/bootstrap-wysiwyg/bootstrap-wysiwyg.js"></script>
	<script src="../../base/admin/assets/js/plugins/bootstrap-wysiwyg/ek-wysiwyg.js"></script>
	<script src="../../base/admin/assets/js/plugins/datetime/bootstrap-datetimepicker.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../base/admin/assets/js/plugins/fuelux/spinner.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/bootstrap-touchspin/bootstrap.touchspin.js"></script>
	<script src="../../base/admin/assets/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/jquery-knob/jquery.knob.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/colorpickers/bootstrap-colorpicker.js"></script>
	<script src="../../base/admin/assets/js/plugins/colorpickers/ek-colorpicker.js"></script>
	
	<!-- REQUIRE FOR SPEECH COMMANDS -->
	<script src="../../base/admin/assets/js/speech-commands.js"></script>
	<script src="../../base/admin/assets/js/plugins/gritter/jquery.gritter.min.js"></script>		

	<!-- initial page level scripts for examples -->
	<script src="../../base/admin/assets/js/plugins/slimscroll/jquery.slimscroll.init.js"></script>
	<script src="../../base/admin/assets/js/plugins/footable/footable.init.js"></script>
	<script src="../../base/admin/assets/js/plugins/datatables/datatables.init.js"></script>
		
	<script>
		$(document).ready(function() {
        	/*$("td").on("click",function () {
        		setTimeout(function () {
                     window.parent.doIframe();
                 }, 0);
        	});*/
        	
        	$(".tc-switch").click(function () {
        		var swid = this.id.substr(10);
        		var gg = $(this).prop("checked");
        		if(gg){
        			$("#getdefault_"+swid).val(1);
        		}else{
        			$("#getdefault_"+swid).val(0);
        		}
	        });
	        
	        	$('.sub').click(function(){ 
	        		var gid = this.id.substr(4);
	        		var idarr = gid.split("_");
	        		var getid = idarr[0];
	        		var cc = idarr[1];
	        		var showtitle = $('#showtitle_'+getid).val();
	        		var langcode = $('#langcode_'+getid).val();
	        		var ifshow = $('#ifshow_'+getid).val();
	        		var ifdefault = $('#getdefault_'+getid).val();
	        		var orilan = $('#orilan').val();
	        		
	        		var formData = new FormData($('form')[cc]);
	        		formData.append("showtitle", showtitle);
	        		formData.append("langcode", langcode);
	        		formData.append("ifshow", ifshow);
	        		formData.append("ifdefault", ifdefault);
	        		formData.append("orilan", orilan);
	        		
	        		$.each($('#file_'+getid)[0].files, function(i, file) {
					    formData.append('file', file);
					});
	        		
	        		
				    $.ajax({
				        url: 'multilang.php',
				        type: 'POST',
				        data: formData,
				        cache: false,
				        contentType: false,
				        processData: false,
						success: function(msg) {
							self.location='multilang.php';
						}
				    });
	        		
	        		
					/*$('#form_'+getid).ajaxSubmit({
						url: 'multilang.php?showtitle='+showtitle+'&langcode='+langcode+'&ifshow='+ifshow+'&ifdefault='+ifdefault,
						type: 'POST',
						success: function(msg) {
							self.location='multilang.php';
						}
					}); */
			       return false; 
			   }); 
	        
		});
	</script>
	<script src="assets/js/plugins/iframeautoheight/iframeResizer.contentWindow.min.js"></script>
  </body>
</html>