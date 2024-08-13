<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/upload.inc.php" );
needauth( 0 );
#---------------------------------------------#

$step = $_REQUEST['step'];
if ( $step == "add" )
{
		$brand = htmlspecialchars( $_POST['brand'] );
		$xuhao = htmlspecialchars( $_POST['xuhao'] );
		$url = htmlspecialchars( $_POST['url'] );
		$intro = $_POST['intro'];
		$tj = $_POST['tj'];
		$pic = $_FILES['jpg'];
		$intro = url2path( $intro );
		if ( $brand == "" )
		{
				err( $strBrandNotice1, "", "" );
		}
		if ( 50 < strlen( $brand ) )
		{
				err( $strBrandNotice2, "", "" );
		}
		if ( 65000 < strlen( $intro ) )
		{
				err( $strBrandNotice3, "", "" );
		}
		if ( 0 < $pic['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "shop/pics/".$nowdate;
				$arr = newuploadimage( $pic['tmp_name'], $pic['type'], $pic['size'], $uppath );
				if ( $arr[0] != "err" )
				{
						$src = $arr[3];
				}
				else
				{
						err( $arr[1], "", "" );
						exit( );
				}
		}
		$msql->query( "insert into {P}_shop_brand set 
	brand='{$brand}',
	url='{$url}',
	xuhao='{$xuhao}',
	intro='{$intro}',
	tj='{$tj}',
	logo='{$src}'
	" );
		sayok( $strBrandNotice4, "brand.php", "" );
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
		<li class="active"><a href="#tab1" class="tab" data-toggle="tab"><i class="fa fa-pencil bigger-130"></i> 品牌編輯</a></li>
		<li><a href="#tab2" class="tab" data-toggle="tab"><i class="fa fa-exchange bigger-130"></i> 多國翻譯</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<!-- Tab1 開始 -->
			
<form action="brandadd.php" method="post" enctype="multipart/form-data" name="form" id="addBrandForm" class="form-horizontal" role="form">
	<div class="form-group">
		<label class="col-sm-1 control-label"><font color="#FF0000">*</font><?php echo $strBrandName; ?></label>
		<div class="col-sm-6">
			<input type="text" name="brand" id="brand" placeholder="<?php echo $strBrandName; ?>" value="" class="form-control" maxlength="200">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strBrandLogo; ?></label>
		<div class="col-sm-6">
			<div class="col-sm-12 input-group">
				<span class="input-group-btn">
					<span class="btn btn-file">
						瀏覽 <input type="file" name="jpg" id="jpg" multiple="">
					</span>
				</span>
				<input type="text" class="form-control" readonly="">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><font color="#FF0000"></font><?php echo $strBrandUrl; ?></label>
		<div class="col-sm-6">
			<input type="text" name="url" id="url" placeholder="<?php echo $strBrandUrl; ?>" value="http://" class="form-control" maxlength="200">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strBrandIntro; ?></label>
		<div class="col-sm-8">
			<textarea name="intro" style="width:100%;height:400px;visibility:hidden;"><?php echo $intro; ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strPaiXuhao;?></label>
		<div class="col-sm-2">
			<input type="text" name="xuhao" id="xuhao" placeholder="<?php echo $strPaiXuhao;?>" value="0" class="form-control" maxlength="5">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strBrandTj;?></label>
		<div class="col-sm-2">
			<label class="tcb-inline" style="margin-right:0;">
				<input type="checkbox" class="tc" name="tj" id="tj" value="1"><span class="labels"></span>
			</label>
		</div>
	</div>
	<div class="form-actions">
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-10">
				<button type="submit" name="submit" class="btn btn-primary"  <?php echo switchdis( 120 ); ?>><?php echo $strSubmit; ?></button>
				<input type="hidden" name="step" value="add" />
			</div>
		</div>
	</div>

</form>
	
			<div class="clearfix"></div>
			<!-- Tab1 結束 -->
		</div>
		<div class="tab-pane" id="tab2">
			<div class="alert note note-info">
				<!--button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button-->
				<h4><i class="fa fa-tags"></i> 系統提醒</h4>
				<hr class="separator">
				<p>若要編輯多國翻譯，請送出新建資料後，再重新進入編輯。</p>
			</div>
			<div class="clearfix"></div>
			<!-- Tab2 結束 -->
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
	<script src="../../base/admin/assets/js/plugins/colorBox/jquery.colorbox-min.js"></script>

	<!-- initial page level scripts for examples -->
	<script src="../../base/admin/assets/js/plugins/slimscroll/jquery.slimscroll.init.js"></script>
	<script src="../../base/admin/assets/js/plugins/footable/footable.init.js"></script>
	<script src="../../base/admin/assets/js/plugins/datatables/datatables.init.js"></script>
		
	<!-- wayhunt & module -->
	<script src="../../base/js/form.js"></script>
	<script src="../../base/js/custom.js"></script>
	<script src="js/frame.js"></script>
	<script src="js/brand.js"></script>

	<script src="../../kedit/kindeditor_up.js"></script>
	<script charset="utf-8" src="../../kedit/lang/zh_TW.js"></script>
	<script>
		KindEditor.ready(function(K) {
			var editor = K.create('textarea[name="intro"]', {
				uploadJson : '../../kedit/php/upload_json.php?attachPath=shop/pics/',
				fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=shop/pics/',
				allowFlashUpload : false,
				allowMediaUpload : false,
				allowFileManager : true,
				langType : 'zh_TW',
				filterMode: false,
				afterBlur: function () { editor.sync(); }

			});
		});
	</script>
	
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>購物</li>');
			$('#pagetitle', window.parent.document).html('購物管理 <span class="sub-title" id="subtitle"><?php echo $strBrandAdd;?></span>');
			//呼叫左側功能選單
			$().getMenuGroup('shop');
		});
	</script>
		
	<script>
		/// Custome File Input
		$(document).on('change', '.btn-file :file', function() {
			var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			label = input.val().replace(/\\/g, '<?php echo $SiteUrl;?>').replace(/.*\//, '');
			input.trigger('fileselect', [numFiles, label]);
		});

		$(document).ready( function() {
			$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        
				var input = $(this).parents('.input-group').find(':text'),
				log = numFiles > 1 ? numFiles + ' files selected' : label;
        
				if( input.length ) {
					input.val(log);
				} else {
					if( log ) alert(log);
				}
        
			});
		});
        $(document).ready(function() {
        	$(".tab").click(function () {
        		setTimeout(function () {
                     window.parent.doIframe();
                 }, 0);
        	});
		});
		
    </script>
</body>
</html>