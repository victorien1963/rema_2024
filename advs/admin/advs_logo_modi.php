<?php

define("ROOTPATH", "../../");

include(ROOTPATH."includes/admin.inc.php");

include("language/".$sLan.".php");

include("func/upload.inc.php");

NeedAuth(0);

#---------------------------------------------#



$step=$_REQUEST["step"];

$id=$_REQUEST["id"];



if ($step == "add") { 



	$groupname=$_POST["groupname"];

	$url=$_POST["url"];

	$pic=$_FILES["pic"];



	if($groupname==""){

	err($strAdvsNotice1,"","");

	}







	if($pic["size"]>0){

			

		$nowdate=date("Ymd",time());

		$picpath="../pics/".$nowdate;

		@mkdir($picpath,0777);

		$uppath="advs/pics/".$nowdate;



		$arr=NewUploadImage($pic["tmp_name"],$pic["type"],$pic["size"],$uppath);

		$src=$arr[3];



		$msql -> query ("insert into {P}_advs_logo set

		groupname = '$groupname',

		src = '$src',

		url = '$url'

		");



		Sayok($strAddOk,"index.php","");







	}else{

	

		err($strAdvsNotice2,"","");



	}





	

}





if ($step == "modify") { 



	$groupname=$_POST["groupname"];

	$url=$_POST["url"];

	$pic=$_FILES["pic"];





	if($pic["size"]>0){

			

		$msql->query("select src from {P}_advs_logo where id='$id'");

		if($msql->next_record()){

			$src=$msql->f('src');

		}

		$fname=ROOTPATH.$src;

		if($src!="" && strlen($src)>9 && file_exists($fname)){

			@unlink($fname);

		}



		$nowdate=date("Ymd",time());

		$picpath="../pics/".$nowdate;

		@mkdir($picpath,0777);

		$uppath="advs/pics/".$nowdate;



		$arr=NewUploadImage($pic["tmp_name"],$pic["type"],$pic["size"],$uppath);

		$src=$arr[3];





		$msql -> query ("update {P}_advs_logo set

		groupname = '$groupname',

		src = '$src',

		url = '$url'

		where id = '$id'

		");



	}else{



		$msql -> query ("update {P}_advs_logo set

		groupname = '$groupname',

		url = '$url'

		where id = '$id' 

		");



	}

	//記錄多國翻譯資料

	$langlist = $_POST['langlist'];

	if($langlist != ""){			

		$sgroupname = $_POST['sgroupname'];

		$surl = $_POST['surl'];

		$spic = $_FILES['sjpg'];

		$soldsrc = $_POST['oldsrc'];

		

		$lans = explode(",",$langlist);

		foreach($lans AS $ks=>$vs){

			//擷取各語言資料並寫入

			$groupname = htmlspecialchars($sgroupname[$vs]);

			$url = htmlspecialchars($surl[$vs]);

			$oldsrc = $soldsrc[$vs];

			

			if ( 0 < $spic['size'][$vs] )

			{

					$nowdate = date( "Ymd", time( ) );

					$picpath = "../pics/".$nowdate;

					@mkdir( $picpath, 511 );

					$uppath = "advs/pics/".$nowdate;

					$arr = newuploadimage( $spic['tmp_name'][$vs], $spic['type'][$vs], $spic['size'][$vs], $uppath);

					if ( $arr[0] != "err" )

					{

							$src = $arr[3];

					}

					else

					{

							err( $arr[1]."[".$vs."]", "", "" );

					}

					if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )

					{

							@unlink( ROOTPATH.$oldsrc );

							$getpic = basename($oldsrc);

							$getpicpath = dirname($oldsrc);

							@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );

					}

			}else{

				$src = $oldsrc;

			}

			

				//getupdate 資料若存在則更新，否則新增

				$msql->getupdate(

					"SELECT id FROM {P}_advs_logo_translate WHERE pid='{$id}' AND langcode='{$vs}'",

					"UPDATE {P}_advs_logo_translate SET 

					groupname='{$groupname}',

					url='{$url}',

					src='{$src}'

					WHERE pid='{$id}' AND langcode='{$vs}'",

					"INSERT INTO {P}_advs_logo_translate SET 

					pid='{$id}',

					langcode='{$vs}',

					groupname='{$groupname}',

					url='{$url}',

					src='{$src}'"

				);

		}

	}

	//記錄多國翻譯資料 END

	

		Sayok($strModifyOk,"index.php","");



	

}



//NEW ADVS

if($id=="0" || $id==""){

		

		$groupname="";

		$url="http://";

		$src="";

		$nowstep="add";



	}else{



		$nowstep="modify";



		$msql -> query ("select * from {P}_advs_logo where id='$id'");

		if ($msql -> next_record ()) {

			$id = $msql -> f ('id');

			$groupname = $msql -> f ('groupname');

			$url = $msql -> f ('url');

			$src = $msql -> f ('src');

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

	<link rel="stylesheet" href="../../base/admin/assets/css/plugins/colorBox/colorbox.css">

		

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

		<li class="active"><a href="#tab1" class="tab" data-toggle="tab"><i class="fa fa-pencil bigger-130"></i> <?php echo $strAdd.$strModify; ?></a></li>

		<li><a href="#tab2" class="tab" data-toggle="tab"><i class="fa fa-exchange bigger-130"></i> 多國翻譯</a></li>

	</ul>



	<!-- Tab panes -->

	<div class="tab-content">

		<div class="tab-pane active" id="tab1">

			<!-- Tab1 開始 -->



<div class="row">

	<div class="col-lg-12">

		<div class="portlet">

			<div id="f-2" class="panel-collapse collapse in">

				<div class="portlet-body">

<form name="advs_logo_modi.php" class="form-horizontal" action="" method="post" enctype="multipart/form-data">

	<div class="form-group">

		<label class="col-sm-1 control-label"><font color="#FF3300">* </font><?php echo $strAdvsLogoName; ?></label>

		<div class="col-sm-6">

			<input type="text" name="groupname" value="<?php echo $groupname; ?>" class="form-control">

		</div>

	</div>

	<div class="form-group">

		<label class="col-sm-1 control-label"><?php echo $strUrl; ?></label>

		<div class="col-sm-6">

			<input type="text" name="url" value="<?php echo $url; ?>" class="form-control">

		</div>

	</div>

	<div class="form-group">

		<label class="col-sm-1 control-label"><font color="#FF3300">* </font><?php echo $strAdvsUpload; ?></label>

		<div class="col-sm-6">

			<div class="col-sm-12 input-group">

				<span class="input-group-btn">

					<span class="btn btn-file">

						瀏覽 <input type="file" name="pic" id="pic" multiple="">

					</span>

				</span>

				<input type="text" class="form-control" readonly="">

				<span class="input-group-addon">

				<?php

				if ( $src== "" )

				{

					echo "<img src='images/noimage.gif' >";

				}

				else

				{

					echo "<a class=' input-group' href=\"\" onclick=\"callcolorbox('".ROOTPATH.$src."'); return false;\" ><img src='images/image.gif' ></a>";

				}

				?>

				</span>

			</div>

		</div>

	</div>

	<div class="form-group">

		<label class="col-sm-1 control-label"></label>

		<div class="col-sm-2">

		<?php

			if($src!=""){

				$src=ROOTPATH.$src;

				echo ShowTypeImage($src,$type,$width,$height,$border);

			}

		?>

		</div>

	</div>

	<div class="form-actions">

		<div class="form-group">

			<div class="col-sm-offset-1 col-sm-10">

		        <input type="submit" name="Submit" value="<?php echo $strSubmit; ?>" class="btn btn-primary" />

		        <input type="button" name="Submit2" value="<?php echo $strBack; ?>" class="btn btn-default" onClick="self.location='index.php'" />

		        <input type="hidden" name="id" value="<?php echo $id; ?>" />

		        <input name="step" type="hidden" id="submit" value="<?php echo $nowstep; ?>" />

			</div>

		</div>

	</div>

	

				</div>

			</div>

		</div>

	</div>

</div>



			<div class="clearfix"></div>

			<!-- Tab1 結束 -->

		</div>

		<div class="tab-pane" id="tab2">

			<!-- Tab2 開始 -->

			<?php

				if($id == "0"){

			?>

				<div class="alert note note-info">

					<!--button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button-->

					<h4><i class="fa fa-tags"></i> 系統提醒</h4>

					<hr class="separator">

					<p>若要編輯多國翻譯，請送出新建資料後，再重新進入編輯。</p>

				</div>			

			<?php

				}else{

			?>

				<!-- 擷取語言表 -->

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

		$langs = $fsql->getone( "SELECT * FROM {P}_advs_logo_translate WHERE pid='{$id}' AND langcode='{$langcode}'" );

?>

<!-- 依表列出語言檔內容 -->

				<div class="portlet">

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

							<!-- 語言<?php echo $title; ?> 開始 -->

							<div class="form-group">

								<label class="col-sm-1 control-label"><?php echo $strAdvsLogoName; ?></label>

								<div class="col-sm-6">

									<input type="text" name="sgroupname[<?php echo $langcode; ?>]" value="<?php echo $langs['groupname']; ?>" class="form-control">

								</div>

								<div class="clearfix"></div>

							</div>

							<div class="form-group">

								<label class="col-sm-1 control-label"><?php echo $strUrl; ?></label>

								<div class="col-sm-6">

									<input type="text" name="surl[<?php echo $langcode; ?>]" value="<?php echo $langs['url']; ?>" class="form-control">

								</div>

								<div class="clearfix"></div>

							</div>

							<div class="form-group">

								<label class="col-sm-1 control-label"><?php echo $strAdvsUpload; ?></label>

								<div class="col-sm-6">

									<div class="col-sm-12 input-group">

										<span class="input-group-btn">

											<span class="btn btn-file">

												瀏覽 <input type="file" name="sjpg[<?php echo $langcode; ?>]" multiple="">

											</span>

										</span>

										<input type="text" class="form-control" readonly="">

										<input type="hidden" name="oldsrc[<?php echo $langcode; ?>]" value="<?php echo $langs['src']; ?>">

										<span class="input-group-addon">

										<?php

										if ( $langs['src'] == "" )

										{

											echo "<img src='images/noimage.gif' >";

										}

										else

										{

											echo "<a class=' input-group' href=\"\" onclick=\"callcolorbox('".ROOTPATH.$langs[src]."'); return false;\" ><img src='images/image.gif' ></a>";

										}

										?>

										</span>

									</div>

								</div>

								<div class="clearfix"></div>

							</div>

							<div class="form-group">

								<label class="col-sm-1 control-label"></label>

								<div class="col-sm-2">

								<?php

									if($langs['src']!=""){

										$src=ROOTPATH.$langs['src'];

										echo ShowTypeImage($src,$type,$width,$height,$border);

									}

								?>

								</div>

								<div class="clearfix"></div>

							</div>

							<!-- 語言<?php echo $title; ?> 結束 -->

						</div>

					</div>

				</div>

<?php

	}

?>

			

				<div class="form-actions">

					<div class="form-group">

						<div class="col-sm-offset-1 col-sm-10">

							<button type="submit" name="submit" class="btn btn-primary"  <?php echo switchdis( 120 ); ?>><?php echo $strSubmit; ?></button>

							<input type="button" name="Submit2" value="<?php echo $strBack; ?>" class="btn btn-default" onClick="self.location='index.php'" />

						</div>

					</div>

					<div class="clearfix"></div>

				</div>

				<input type="hidden" name="langlist" value="<?php echo $langlist; ?>" />

			</form>

			<?php

				}

			?>

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

		

	<script>

		$(document).ready(function(){

			//載入時隱藏選單

			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');

			//頁面麵包屑

			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>廣告</li>');

			$('#pagetitle', window.parent.document).html('廣告管理 <span class="sub-title" id="subtitle"><?php echo $strSetMenu7; ?></span>');

			//呼叫左側功能選單

			$().getMenuGroup('advs');

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

        	$(".tab").click(function () {

        		setTimeout(function () {

                     window.parent.doIframe();

                 }, 0);

        	});

        	$('.collapse').on('hidden.bs.collapse', function () {

        		setTimeout(function () {

                     window.parent.doIframe();

                 }, 0);

			});

        	$('.collapse').on('shown.bs.collapse', function () {

        		setTimeout(function () {

                     window.parent.doIframe();

                 }, 0);

			});

		});

		//colorbox function

		function callcolorbox(href){

			var $overflow = '';

				var colorbox_params = {

				rel: 'colorbox',

				href: href,

				reposition:true,

				scalePhotos:true,

				scrolling:false,

				previous:'<i class="fa fa-arrow-left text-gray"></i>',

				next:'<i class="fa fa-arrow-right text-gray"></i>',

				close:'<i class="fa fa-times text-primary"></i>',

				current:'{current} of {total}',

				maxWidth:'100%',

				maxHeight:'100%',

				onOpen:function(){

					$overflow = parent.document.body.style.overflow;

					parent.document.body.style.overflow = 'hidden';

				},

				onClosed:function(){

					parent.document.body.style.overflow = $overflow;

				},

				onComplete:function(){

					parent.$.colorbox.resize();

				}

			};

			window.parent.$.colorbox(colorbox_params);

		}//colorbox end

		

    </script>

    

</body>

</html>