<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
NeedAuth(0);
#---------------------------------------------#

$step=$_REQUEST["step"];
$nowplusid=$_REQUEST["nowplusid"];

if($step=="2"){
	$updatemode=$_POST["updatemode"];
	$body=$_POST["body"];
	
	/*if(strlen($body)>65000){
		err($strDiyBottomNotice3,"","");
		exit;
	}*/
	$body=Url2Path($body);
	
	if($updatemode=="all"){
		$msql->query("update {P}_base_plus set `body`='$body' where `pluslable`='modButtomInfo'");
		/*SayOk($strDiyBottomNotice4,"plus_bottomedit.php","");
		exit;*/
	}else{
		$msql->query("update {P}_base_plus set `body`='$body' where `pluslable`='modButtomInfo' and id='$nowplusid'");
		/*SayOk($strDiyBottomNotice5,"plus_bottomedit.php?nowplusid=".$nowplusid,"");
		exit;*/
	}
	
	//記錄多國翻譯資料
	$langlist = $_POST['langlist'];
	if($langlist != ""){
		$sbody = $_POST['sbody'];
		
		$lans = explode(",",$langlist);
		foreach($lans AS $ks=>$vs){
			//擷取各語言資料並寫入
			$body = $sbody[$vs];
			
				//getupdate 資料若存在則更新，否則新增
				if($updatemode=="all"){
					$fsql->query("SELECT id FROM {P}_base_plus WHERE `pluslable`='modButtomInfo'");
					while($fsql->next_record()){
						$ggid = $fsql->f("id");
						$msql->getupdate(
							"SELECT id FROM {P}_base_plus_translate WHERE `pluslable`='modButtomInfo' AND pid='{$ggid}' AND langcode='{$vs}'",
							"UPDATE {P}_base_plus_translate SET 
							body='{$body}' 
							WHERE `pluslable`='modButtomInfo' AND pid='{$ggid}' AND langcode='{$vs}'",
							"INSERT INTO {P}_base_plus_translate SET 
							pid='{$ggid}',
							langcode='{$vs}',
							pluslable='modButtomInfo',
							body='{$body}'"
						);
					}
				}else{
					$msql->getupdate(
						"SELECT id FROM {P}_base_plus_translate WHERE `pluslable`='modButtomInfo' AND pid='{$nowplusid}' AND langcode='{$vs}'",
						"UPDATE {P}_base_plus_translate SET 
						body='{$body}' 
						WHERE `pluslable`='modButtomInfo' AND pid='{$nowplusid}' AND langcode='{$vs}'",
						"INSERT INTO {P}_base_plus_translate SET 
						pid='{$nowplusid}',
						langcode='{$vs}',
						pluslable='modButtomInfo',
						body='{$body}'"
					);
				}
		}
		
		if($updatemode=="all"){
			SayOk($strDiyBottomNotice4,"plus_bottomedit.php","");
			exit;
		}else{
			SayOk($strDiyBottomNotice5,"plus_bottomedit.php?nowplusid=".$nowplusid,"");
			exit;
		}
	}
	//記錄多國翻譯資料 END
	
}

//空時取第一個
if($nowplusid==""){
	$msql->query("select id from {P}_base_plus where `pluslable`='modButtomInfo' and `plustype`='index' and `pluslocat`='index'  limit 0,1");
	if($msql->next_record()){
		$nowplusid=$msql->f('id');
	}else{
		$fsql->query("select id from {P}_base_plus where `pluslable`='modButtomInfo' order by plustype limit 0,1");
		if($fsql->next_record()){
			$nowplusid=$fsql->f('id');
		}
	}
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
<div class="tc-tabs">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" class="tab" data-toggle="tab"><i class="fa fa-pencil bigger-130"></i> <?php echo $strDiyBottomEdit; ?></a></li>
		<li><a href="#tab2" class="tab" data-toggle="tab"><i class="fa fa-exchange bigger-130"></i> 多國翻譯</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<!-- Tab1 開始 -->
  		<form  name="selpluslocat" method="get" action="" class="form-horizontal" role="form">
<div class="form-group">
	<div class="col-sm-3">
			<select name="pp" class="form-control" onchange="self.location=this.options[this.selectedIndex].value" >
	        <?php
			  
				$msql->query("select * from {P}_base_plus where `pluslable`='modButtomInfo' order by plustype");
				while($msql->next_record()){
					$plusid=$msql->f('id');
					$plustype=$msql->f('plustype');
					$pluslocat=$msql->f('pluslocat');
					
					//獲取對應模組名稱
					$fsql->query("select `colname` from {P}_base_coltype where `coltype`='$plustype' limit 0,1");
					if($fsql->next_record()){
						$colname=$fsql->f('colname');
					}
					
					//獲取對應頁面名稱
					$fsql->query("select `name` from {P}_base_pageset where `coltype`='$plustype' and `pagename`='$pluslocat' limit 0,1");
					if($fsql->next_record()){
						$pagecname=$fsql->f('name');
					}
					
					if($nowplusid==$plusid){
						echo "<option value='plus_bottomedit.php?nowplusid=".$plusid."' selected>".$colname." |- ".$pagecname."</option>";
					}else{
						echo "<option value='plus_bottomedit.php?nowplusid=".$plusid."'>".$colname." |- ".$pagecname."</option>";
					}
				}
			 ?>
			</select>
	</div>
				 <div class="clearfix"></div>
</div>
		</form>

<form  method="post" action="plus_bottomedit.php" enctype="multipart/form-data" name="form" id="modiEditForm"  class="form-horizontal" role="form">
<div class="form-group">
	<div class="col-sm-8">
	<?php
		$msql->query("select `body` from {P}_base_plus where `id`='$nowplusid' limit 0,1");
			if($msql->next_record()){
				$body=$msql->f('body');
				//$body=htmlspecialchars($body);
				$body=Path2Url($body);
			}else{
				err($strDiyBottomNotice1,"","");
			}
	?>
			<textarea id="body" name="body" style="width:100%;height:400px;visibility:hidden;"><?php echo $body; ?></textarea>
			<script type="text/javascript" src="../../kedit/kindeditor-min.js"></script>
			<script charset="utf-8" src="../../kedit/lang/zh_TW.js"></script>
			<script>
				KindEditor.ready(function(K) {
					var editor = K.create('textarea[name="body"]', {
						uploadJson : '../../kedit/php/upload_json.php?attachPath=base/pics/',
						fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=base/pics/',
						allowFlashUpload : false,
						allowMediaUpload : false,
						allowFileManager : true,
						langType : 'zh_TW',
						filterMode: false,
						afterBlur: function () { editor.sync(); }
					});
				});
		     </script>
				<input type="hidden" name="step" value="2" />
				<input type="hidden" name="nowplusid" value="<?php echo $nowplusid; ?>" />
	</div>
</div>


			<div class="clearfix"></div>
			<!-- Tab1 結束 -->
		</div>
		<div class="tab-pane" id="tab2">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php
	$langlist = "";
	$msql->query( "SELECT * FROM {P}_base_language WHERE ifshow='1' AND ifdefault='0' ORDER BY xuhao asc" );
	while ( $msql->next_record( ) )
	{
		$lid = $msql->f( "id" );
		$ltitle = $msql->f( "title" );
		$langcode = $msql->f( "langcode" );
		$src = ROOTPATH.$msql->f( "src" );
		$langlist .= $langlist? ",".$langcode:$langcode;
		
		//依表擷取語言檔內容
		$langs = $fsql->getone( "SELECT * FROM {P}_base_plus_translate WHERE `pluslable`='modButtomInfo' AND pid='{$nowplusid}' AND langcode='{$langcode}'" );
?>
<!-- 依表列出語言檔內容 -->
				<div class="portlet no-border">
					<div class="portlet-heading">
						<div class="portlet-title">
							<h4><img src="<?php echo $src; ?>" height="20"/> <?php echo $ltitle; ?></h4>
						</div>
						<div class="portlet-widgets">
							<a data-toggle="collapse" data-parent="#accordion" href="#no-<?php echo $lid; ?>"><i class="fa fa-chevron-down"></i></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<div id="no-<?php echo $lid; ?>" class="panel-collapse collapse in">
						<div class="portlet-body">
							<div class="form-group">
								<div class="col-sm-8">
									<script>
										KindEditor.ready(function(K) {
											var editor<?php echo $lid; ?> = K.create('#sbody_<?php echo $langcode; ?>', {
												uploadJson : '../../kedit/php/upload_json.php?attachPath=base/pics/',
												fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=base/pics/',
												allowFlashUpload : false,
												allowMediaUpload : false,
												allowFileManager : true,
												langType : 'zh_TW',
												filterMode: false,
												afterBlur: function () { editor<?php echo $lid; ?>.sync(); }
											});
										});
									</script>
									<textarea name="sbody[<?php echo $langcode; ?>]" id="sbody_<?php echo $langcode; ?>" style="width:100%;height:400px;visibility:hidden;"><?php echo $langs['body']; ?></textarea>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</div>
<?php
	}
?>
				<!---->
			</div>
			<div class="clearfix"></div>
			<!-- Tab2 結束 -->
		</div>
				
<div class="form-actions">
	<div class="form-group">
		<div class="col-sm-offset-1 col-sm-10">
			<input type="submit" name="submit" value="<?php echo $strSubmit; ?>" class="btn btn-primary"  />
			<?php echo $strDiyBottomEdit2; ?>
			<label class="tcb-inline" style="margin-right:0;">
				<input type="checkbox" class="tc" name="updatemode" id="updatemode" value="all" checked="checked"><span class="labels"></span>
			</label>
			<input type="hidden" name="langlist" value="<?php echo $langlist; ?>" />
		</div>
	</div>
</div>
		</form>
	<div class="clearfix"></div>
	</div>
</div>

<!-- END MAIN PAGE CONTENT -->
</div>
	<!-- core JavaScript -->
    <script src="../../base/admin/assets/js/jquery.min.js"></script>
    <script src="../../base/admin/assets/js/bootstrap.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/pace/pace.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/iframeautoheight/jquery.autoheight.js"></script>

		
	<!-- Themes Core Scripts -->	
	<script src="../../base/admin/assets/js/main.js"></script>
		
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
		
	<!-- wayhunt & module -->
	<script src="../../base/js/form.js"></script>
	<script src="../../base/js/custom.js"></script>
	<script src="js/frame.js"></script>
		
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>網頁</li>');
			$('#pagetitle', window.parent.document).html('網頁管理 <span class="sub-title" id="subtitle">底部資訊編輯</span>');
			//呼叫左側功能選單
			$().getMenuGroup('page');
		});
	</script>
		
	<script>
        $(document).ready(function() {
			$("td").on("click",function () {
        		var tt = $("#right-wrapper").outerHeight()+ 230;
				$('#mainframe', window.parent.document).height(tt);
        	});
		    $(".tab").click(function () {
        		setTimeout(function () {
                     window.parent.doIframe();
                 }, 0);
        	});
		});
    </script>
  </body>
</html>