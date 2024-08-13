<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/upload.inc.php" );
needauth( 125 );
#---------------------------------------------#
$pid = $_REQUEST['pid'];
if ( !isset( $pid ) || $pid == "" )
{
		$pid = 0;
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
	<link rel="stylesheet" href="../../base/admin/assets/css/plugins/duallistbox/bootstrap-duallistbox.min.css">
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
		<li class="active"><a href="#tab1" class="tab" data-toggle="tab"><i class="fa fa-pencil bigger-130"></i> <?php echo $strNewsFabu; ?></a></li>
		<li><a href="#tab2" class="tab" data-toggle="tab"><i class="fa fa-exchange bigger-130"></i> 多國翻譯</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<!-- Tab1 開始 -->
			
<form id="newsAddForm" name="form" action="" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">

<div  id="notice" class="noticediv"></div>

	<div class="form-group">
		<label class="col-sm-1 control-label"><font color="#FF0000">*</font><?php echo $strNewsCatTitle; ?></label>
		<div class="col-sm-6">
			<select class="form-control" id="selcatid" name="catid">
				<!--option value="0"><?php echo $strNewsBlog; ?></option-->
				<?php
				$fsql->query( "select * from {P}_news_cat  order by catpath" );
				while ( $fsql->next_record( ) )
				{
						$lpid = $fsql->f( "pid" );
						$lcatid = $fsql->f( "catid" );
						$cat = $fsql->f( "cat" );
						$catpath = $fsql->f( "catpath" );
						$lcatpath = explode( ":", $catpath );
						
						for ( $i = 0;	$i < sizeof( $lcatpath ) - 2;	$i++	)
						{
								$tsql->query( "select catid,cat from {P}_news_cat where catid='{$lcatpath[$i]}'" );
								if ( $tsql->next_record( ) )
								{
										$ncatid = $tsql->f( "cat" );
										$ncat = $tsql->f( "cat" );
										$ppcat .= $ncat."/";
								}
						}
						if ( $pid == $lcatid )
						{
								echo "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
						}
						else
						{
								echo "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
						}
						$ppcat = "";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><font color="#FF0000">*</font><?php echo $strNewsAddTitle; ?></label>
		<div class="col-sm-6">
			<input type="text" name="title" id="title" placeholder="<?php echo $strNewsAddTitle; ?>" value="<?php echo $title; ?>" class="form-control" maxlength="200">
		</div>
	</div>

	<div id="proplist"></div>
		
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strMemo; ?></label>
		<div class="col-sm-6">
			<textarea name="memo" id="memo" rows="5" class="form-control" id="memo"><?php echo $memo; ?></textarea>
		</div>
	</div>
	<!--div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strNewsAddImg; ?></label>
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
	</div-->
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strNewsAddImg; ?><!--?php echo $strNewsAddCon; ?--></label>
		<div class="col-sm-6">
			<!--script src="../../kedit/kindeditor_up.js"></script>
			<script charset="utf-8" src="../../kedit/lang/zh_TW.js"></script>
			<script>
				KindEditor.ready(function(K) {
					var editor = K.create('textarea[name="body"]', {
						uploadJson : '../../kedit/php/upload_json.php?attachPath=news/pics/',
						fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=news/pics/',
						allowFlashUpload : false,
						allowMediaUpload : false,
						allowFileManager : true,
						langType : 'zh_TW',
						syncType: '',
						filterMode: false,
						afterBlur: function () { editor.sync(); }

					});
				});
			</script>
			<textarea name="body" style="width:100%;height:400px;visibility:hidden;"><?php echo $body; ?></textarea-->
			<div class="col-sm-12 input-group">
				<span class="input-group-btn">
					<span class="btn btn-file">
						瀏覽 <input type="file" name="body" id="body" multiple="">
					</span>
				</span>
				<input type="text" class="form-control" readonly="">
			</div>
			<input type="hidden" name="act" value="newsadd">
	        <input type="hidden" name="pid" value="<?php echo $pid; ?>">
			<input type="hidden" id="nowid"  value="" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strNewsTag; ?></label>
		<div class="col-sm-6">
			<input type="text" name="tags" id="tags" value="<?php echo $tags; ?>" class="form-control" data-role="tagsinput">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strNewsFileDown; ?></label>
		<div class="col-sm-6">
			<div class="input-group" id="divsuo" style='display:none'>
				<span class="input-group-btn">
					<span class="btn btn-file" > 瀏覽檔案<input type="file" name="file" /></span>
				</span>
				<input type="text" class="form-control" readonly="">
			</div>
			<input id="divurl" type="text" name="fileurl" value="http://" class="form-control" />
			<div class="space-4"></div>
			<label><input type="radio" name="addtype" class="tc" value="addurl" checked="checked" onClick="document.getElementById('divurl').style.display='inline';document.getElementById('divsuo').style.display='none';">
			<span class="labels"> <?php echo $strDownAddUrl; ?></span></label>
			<label><input type="radio" name="addtype" class="tc" value="addfile" onClick="document.getElementById('divurl').style.display='none';document.getElementById('divsuo').style.display='table';">
			<span class="labels"> <?php echo $strDownAddUpload; ?></span></label>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strNewsAddAuthor; ?></label>
		<div class="col-sm-2">
			<input type="text" name="author" id="author" placeholder="<?php echo $strNewsAddAuthor; ?>" value="<?php echo $_COOKIE['SYSNAME']; ?>" class="form-control" maxlength="200">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strNewsAddSource; ?></label>
		<div class="col-sm-6">
			<input type="text" name="source" id="source" placeholder="<?php echo $strNewsAddSource; ?>" value="" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strNewsAddProj; ?></label>
		<div class="col-sm-6">
			<select multiple="multiple" size="10" name="spe_selec[]" id="duallist">
				<?php
					$fsql->query( "select * from {P}_news_proj order by id desc" );
					while ( $fsql->next_record( ) )
					{
							$projid = $fsql->f( "id" );
							$project = $fsql->f( "project" );
							$NowPath = fmpath( $projid );
							echo "<option value=".$NowPath.">".$project."</option>";
							$ppcat = "";
					}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strDownCent; ?></label>
			<?php
			$msql->query( "select * from {P}_member_centset" );
			if ( $msql->next_record( ) )
			{
					$centname1 = $msql->f( "centname1" );
					$centname2 = $msql->f( "centname2" );
					$centname3 = $msql->f( "centname3" );
					$centname4 = $msql->f( "centname4" );
					$centname5 = $msql->f( "centname5" );
			}
			?>
		<div class="col-sm-2">
			<select class="form-control" name="downcentid">
			    <option value="1"><?php echo $centname1; ?></option>
				<option value="2"><?php echo $centname2; ?></option>
				<option value="3"><?php echo $centname3; ?></option>
				<option value="4"><?php echo $centname4; ?></option>
				<option value="5"><?php echo $centname5; ?></option>
			</select>
		</div>
		<div class="col-sm-1">
			<input name="downcent" type="text" class="form-control" id="downcent"  value="0" size="3" maxlength="5" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strFbtime; ?></label>
		<div class="col-sm-2">
			<?php
				$fbtime = date( "Y-m-d", time( ) );
			?>
			<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fbtime" data-link-format="yyyy-mm-dd">
				<span class="input-group-addon">
					<i class="glyphicon glyphicon-calendar"></i>
				</span>															
				<input class="form-control" value="<?php echo $fbtime; ?>"/>
			</div>
			<input type="hidden" name="fbtime" id="fbtime" value="<?php echo $fbtime; ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strNewsToUrl; ?></label>
		<div class="col-sm-6">
			<input type="text" name="tourl" id="tourl" value="http://" class="form-control">
			<?php echo $strNewsToUrlNTC; ?>
		</div>
	</div>
	<div class="form-actions">
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-10">
				<button type="submit" name="cc" class="btn btn-primary"><?php echo $strSubmit; ?></button>
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

	<!-- initial page level scripts for examples -->
	<script src="../../base/admin/assets/js/plugins/slimscroll/jquery.slimscroll.init.js"></script>
	<script src="../../base/admin/assets/js/plugins/footable/footable.init.js"></script>
	<script src="../../base/admin/assets/js/plugins/datatables/datatables.init.js"></script>
		
	<!-- wayhunt & module -->
	<script src="../../base/js/form.js"></script>
	<script src="../../base/js/custom.js"></script>
	<script src="js/frame.js"></script>
	<script src="js/news.js"></script>
		
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>文章</li>');
			$('#pagetitle', window.parent.document).html('文章管理 <span class="sub-title" id="subtitle">新增文章</span>');
			//呼叫左側功能選單
			$().getMenuGroup('news');
		});
	</script>
		
	<script>
		// Custome File Input
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
        	var demo1 = $('select[name="spe_selec[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-primary label-lg">已篩選</span>'});
			var container1 = demo1.bootstrapDualListbox('getContainer');
        	
        	$('.form_date').datetimepicker({
				weekStart: 1,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0,
				pickerPosition: "top-right"
			});
        	
        	$("*").click(function () {
        		setTimeout(function () {
                     window.parent.doIframe();
                 }, 0);
        	});
		});
		
		$().getPropList();
    </script>
  </body>
</html>