<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/adminpages.inc.php" );
include( "language/".$sLan.".php" );
NeedAuth(313);
#---------------------------------------------#
$step = $_REQUEST['step'];
$page = $_REQUEST['page'];
if ( $step == "del" )
{
		$id = $_REQUEST['id'];
		$msql->query( "select logo from {P}_shop_brand where id='{$id}'" );
		if ( $msql->next_record( ) )
		{
				$src = $msql->f( "logo" );
				if ( file_exists( ROOTPATH.$src ) && $src != "" )
				{
						unlink( ROOTPATH.$src );
				}
		}
		$msql->query( "delete from {P}_shop_brandcat where  brandid='{$id}'" );
		$msql->query( "delete from {P}_shop_brand where  id='{$id}'" );
}
$scl = " id!='0' ";
$totalnums = tblcount( "_shop_brand", "id", $scl );
$pages = new pages( );
$pages->setvar( array(
		"key" => $key
) );
$pages->set( 10, $totalnums );
$pagelimit = $pages->limit( );
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
			<div id="f-1" class="panel-collapse collapse in">
				<div class="portlet-body">
					<div class="pull-right">
						<button type="button" onClick="self.location='brandadd.php'" class="btn btn-primary btn-line" /><i class="fa fa-plus"></i><?php echo $strBrandAdd; ?></button>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="portlet table-responsive">
			<div class="portlet-body no-padding">
				<table class="table table-bordered table-hover tc-table tc-gallery">
					<thead>
			  			<tr>
							<th class="col-mini center"><?php echo $strNumber; ?></th>
							<th class="col-mini center hidden-xs"><?php echo $strXuhao; ?></th>
							<th class="col-mini center hidden-xs"><?php echo $strBrandLogo1; ?> </th>
							<th class="col-medium center"><?php echo $strBrandName; ?> </th>
							<th class="col-width center"><?php echo $strBrandUrl; ?> </th>
							<th class="col-mini center hidden-xs"><?php echo $strShopTj;?></th>
							<th class="col-mini center hidden-xs"><?php echo $strRelation; ?></th>
							<th class="col-mini center"><?php echo $strModify; ?></th>
							<th class="col-mini center"><?php echo $strDelete; ?></th>
						</tr>
					</thead>
					<tbody>
<?php
$msql->query( "select * from {P}_shop_brand where {$scl} order by xuhao limit {$pagelimit}" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$brand = $msql->f( "brand" );
		$logo = $msql->f( "logo" );
		$url = $msql->f( "url" );
		$intro = $msql->f( "intro" );
		$xuhao = $msql->f( "xuhao" );
		$tj = $msql->f( "tj" );
		echo " 
  <tr> 
    <td class=\"col-mini center\"> ".$id." </td>
    <td class=\"col-mini center hidden-xs\">".$xuhao." </td>
    <td class=\"col-mini center hidden-xs\">";
		if ( $logo == "" )
		{
				echo "<img src='images/noimage.gif' >";
		}
		else
		{
				echo "<a href=\"\" onclick=\"callcolorbox('".ROOTPATH.$logo."'); return false;\" ><img src='images/image.gif' ></a>";
		}
	echo "</td>
    <td class=\"col-medium center\">".$brand."</td>
    <td class=\"col-width\"><a href='".$url."' target='_blank'>".$url."</a></td>
    <td class=\"col-mini center hidden-xs\">";
		showyn( $tj );
		echo " </td>
    <td class=\"col-mini center hidden-xs\"><img src=\"images/set.png\" class=\"brandrelset\" id=\"brandrelset_".$id."\" width=\"24\" height=\"24\"  style=\"cursor:pointer\" /> </td>
    <td class=\"col-mini center\"><img src=\"images/edit.png\" width=\"24\" height=\"24\"  style=\"cursor:pointer\" onclick=\"window.location='brandmodify.php?id=".$id."'\" /> </td>
    <td class=\"col-mini center\"><img src=\"images/delete.png\"  style=\"cursor:pointer\" onClick=\"window.location='brand.php?step=del&id=".$id."&page=".$page."'\"></td>
  </tr>
  ";
}
?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
$pagesinfo = $pages->shownow( );
?>
<div class="row">
	<div class="col-sm-12">
		<div class="pull-left">
			<div class="dataTables_info">
				<?php echo $strPagesTotalStart.$totalnums.$strPagesTotalEnd; ?> <?php echo $strPagesMeiye.$pagesinfo['shownum'].$strPagesTotalEnd; ?> <?php echo $strPagesYeci; ?> <?php echo $pagesinfo['now']."/".$pagesinfo['total']; ?>
			</div>
		</div>
		<div class="pull-right">
			<div class="dataTables_paginate paging_bootstrap">
				<?php echo $pages->output( 1 ); ?>
			</div>
		</div>
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
		
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>購物</li>');
			$('#pagetitle', window.parent.document).html('購物管理 <span class="sub-title" id="subtitle">商品品牌管理</span>');
			//呼叫左側功能選單
			$().getMenuGroup('shop');
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
		
		$('#nowcolor').ek_colorpicker();

		
    </script>
    
	
</body>
</html>