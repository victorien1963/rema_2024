<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
needauth( 0 );
#---------------------------------------------#

$step=$_REQUEST["step"];
$id=$_REQUEST["id"];


if($step=="del"){

	$msql->query("select src from {P}_advs_logo where id='$id'");
	if($msql->next_record()){
		$src=$msql->f('src');
	}
   	if(file_exists(ROOTPATH.$src) && $src!=""){
		unlink(ROOTPATH.$src);
	}
	$msql->query("delete from {P}_advs_logo where id='$id'");
	
	//刪除多語言
	$msql->query("select src from {P}_advs_logo_translate where pid='$id'");
	while($msql->next_record()){
		$src=$msql->f('src');
		if(file_exists(ROOTPATH.$src) && $src!=""){
			unlink(ROOTPATH.$src);
		}
	}
	$msql->query("delete from {P}_advs_logo_translate where pid='$id'");
	//刪除 END

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
<div class="row">
	<div class="col-lg-12">
		<div class="portlet">
			<div id="f-2" class="panel-collapse collapse in">
				<div class="portlet-body">
					<button type="button" class="btn btn-success" onClick="window.location='advs_logo_modi.php?id=0'">
						<i class="fa fa-pencil-square"></i> <?php echo $strAdvsLogoAdd; ?>
					</button>
				</div>
				<div class="portlet-body no-padding">
					<table class="table table-bordered table-striped table-hover tc-table table-primary footable" data-page-size="50">
						<thead>
							<tr>
								<th class="col-medium center" data-hide="phone,tablet" data-sort-ignore="true"><?php echo $strNumber; ?></th>
								<th class="col-large center" data-sort-ignore="true"><?php echo $strAdvsLogoName; ?></th>
								<th class="col-medium center" data-hide="phone,tablet" data-sort-ignore="true"><?php echo $strAdvsPic; ?></th>
								<th data-hide="phone,tablet" data-sort-ignore="true"><?php echo $strUrl; ?></th>
								<th class="col-mini center" data-sort-ignore="true"><?php echo $strModify; ?></th>
								<th class="col-mini center" data-sort-ignore="true" <?php echo adminshow(2); ?>><?php echo $strDelete; ?></th>
							</tr>
						</thead>
						<tbody>
<?php 
	$msql -> query ("select * from {P}_advs_logo order by id desc");
	while ($msql -> next_record ()) {
		$id = $msql -> f ('id');
		$groupname = $msql -> f ('groupname');
		$url = $msql -> f ('url');
		$src = $msql -> f ('src');
?> 
  <tr> 
    <td class="col-medium center"><?php echo $id; ?> </td>
    <td class="col-large center"><?php echo $groupname; ?></td>
    <td class="col-medium center">
		<?php
		if($src==""){
			echo "<img src=\"images/noimage.gif\" >";
		}else{
			$showsrc=ROOTPATH.$src;
			echo "<a href=\"\" onclick=\"callcolorbox('".$showsrc."'); return false;\" ><img src=\"images/image.gif\" /></a>";
		}
		?>
	</td>
    <td><?php echo $url; ?></td>
    <td class="col-mini center"> <img src="images/edit.png"  style="cursor:pointer" onClick="window.location='advs_logo_modi.php?id=<?php echo $id; ?>'"></td>
    <td class="col-mini center"> <img src="images/delete.png"  style="cursor:pointer" onClick="window.location='advs_logo.php?step=del&id=<?php echo $id; ?>'"></td>
  </tr>
  <?php
}
?> 
</tbody>
</table>
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
        $(document).ready(function() {
			$("td").on("click",function () {
        		var tt = $("#right-wrapper").outerHeight()+ 230;
				$('#mainframe', window.parent.document).height(tt);
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