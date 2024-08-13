<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/adminpages.inc.php" );
include( "language/".$sLan.".php" );
needauth( 0 );
#---------------------------------------------#
$step = $_REQUEST['step'];
$groupid = $_REQUEST['groupid'];
$page = $_REQUEST['page'];

if ( $step == "del" )
{
		$id = $_REQUEST['id'];
		$msql->query( "select * from {P}_page where  id='{$id}'" );
		if ( $msql->next_record( ) )
		{
				$groupid = $msql->f( "groupid" );
				$pagefolder = $msql->f( "pagefolder" );
		}
		if ( $pagefolder != "" && 0 < strlen( $pagefolder ) )
		{
				$fsql->query( "select folder from {P}_page_group where id='{$groupid}'" );
				if ( $fsql->next_record( ) )
				{
						$folder = $fsql->f( "folder" );
				}
				@unlink( "../".$folder."/".$pagefolder.".php" );
				$oldpagename = $folder."_".$pagefolder;
				$msql->query( "delete from {P}_base_pageset where coltype='page' and pagename='{$oldpagename}'" );
				$msql->query( "delete from {P}_base_plus where plustype='page' and pluslocat='{$oldpagename}'" );
				$msql->query( "delete from {P}_base_plusplan where plustype='page' and pluslocat='{$oldpagename}'" );
		}
		$msql->query( "delete from {P}_page where id='{$id}'" );
		$msql->query( "delete from {P}_page_translate where pid='{$id}'" );
}

$scl = " id!='0' ";

if ( $_REQUEST['groupid'] != "" )
{
		$scl .= " and groupid='".$_REQUEST['groupid']."' ";
}

$totalnums = tblcount( "_page", "id", $scl );
$pages = new pages( );
$pages->setvar( array(
		"groupid" => $groupid
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
					<h4><?php echo $strHtmAdd; ?></h4>
				</div>
				<div class="portlet-widgets">
					<a data-toggle="collapse" data-parent="#accordion" href="#f-1"><i class="fa fa-chevron-down"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div id="f-1" class="panel-collapse collapse in">
				<div class="portlet-body">
					<form id="selgroup" name="selgroup" method="get" action="" class="form-inline pull-left" role="form">
						<div class="form-group">
							<select name="pp" onchange="self.location=this.options[this.selectedIndex].value" >
								<?php
								$msql->query( "select * from {P}_page_group" );
								while ( $msql->next_record( ) )
								{
										$lgroupid = $msql->f( "id" );
										$groupname = $msql->f( "groupname" );
										if ( $groupid == $lgroupid )
										{
												echo "<option value='index.php?groupid=".$lgroupid."' selected>".$strGroupSel.$groupname."</option>";
										}
										else
										{
												echo "<option value='index.php?groupid=".$lgroupid."'>".$strGroupSel.$groupname."</option>";
										}
								}
								?>
							</select>
						</div>
					</form>
	
					<div class="pull-right">
						<button type="button" onClick="window.location='page_add.php?groupid=<?php echo $groupid; ?>'" class="btn btn-primary btn-line" <?php echo $buttondis; ?>  /><i class="fa fa-plus"></i><?php echo $strPageAdd; ?></button>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>
						
<div class="portlet"><!-- Portlet -->
	<div id="basic" class="panel-collapse collapse in">
		<div class="portlet-body no-padding">
			<table class="table table-bordered table-hover tc-table">
				<thead>
					<tr>
						<th class="col-medium center"><?php echo $strNumber; ?></th>
						<th><?php echo $strXuhao; ?></th>
						<th class="hidden-xs"><?php echo $strPagePicSrc1; ?></th>
						<th class="hidden-xs"><?php echo $strGroupNow; ?></th>
						<th class="hidden-xs"><?php echo $strPageTitle; ?></th>
						<th class="hidden-xs"><?php echo $strPageFolder; ?></th>
						<th class="col-medium center">動作</th>
					</tr>
				</thead>
				<tbody>
<?php
$msql->query( "select * from {P}_page where {$scl} order by xuhao limit {$pagelimit}" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$title = $msql->f( "title" );
		$xuhao = $msql->f( "xuhao" );
		$groupid = $msql->f( "groupid" );
		$pagefolder = $msql->f( "pagefolder" );
		$src = $msql->f( "src" );
		$fsql->query( "select * from {P}_page_group where id='{$groupid}'" );
		if ( $fsql->next_record( ) )
		{
				$groupname = $fsql->f( "groupname" );
				$folder = $fsql->f( "folder" );
		}
		if ( $pagefolder != "" && 0 < strlen( $pagefolder ) )
		{
				$browseurl = $folder."/".$pagefolder.".php";
				$pvdpath = $folder."/".$pagefolder.".php";
		}
		else
		{
				$browseurl = $folder."/?".$id.".html";
				$pvdpath = $folder;
		}
		echo " 
  <tr> 
    <td class=\"col-medium center\"> ".$id." </td>
    <td>".$xuhao."
		<ul class=\"table-mobile-ul visible-xs list-unstyled\">
			<li>".$title."</li>
			<li><a href=\"../".$browseurl."\" target=\"_blank\">".$strUrl."</a></li>
		</ul>
	</td>
    <td class=\"hidden-xs\">";
		if ( $src == "" )
		{
				echo "<img src='images/noimage.gif' >";
		}
		else
		{
				echo "<a href=\"\" onclick=\"callcolorbox_p('".ROOTPATH.$catsrc."'); return false;\" ><img src='images/image.gif' ></a>";
		}
		echo "
			</td>
		    <td class=\"hidden-xs\">".$groupname." </td>
		    <td class=\"hidden-xs\">".$title."</td>
		    <td class=\"hidden-xs\"><a href=\"../".$browseurl."\" target=\"_blank\">page/".$browseurl."</a></td>
		    <td class=\"col-medium center\">
				<div class=\"btn-group  btn-group-sm\">
					<a href=\"#\" class=\"btn btn-inverse\" title=\"".$strModify."\" onclick=\"window.location='page_edit.php?id=".$id."&groupid=".$groupid."'\"><i class=\"fa fa-pencil icon-only\"></i></a>
					<a href=\"#\" class=\"btn btn-danger\" title=\"".$strDelete."\" onClick=\"window.location='index.php?step=del&id=".$id."&groupid=".$_REQUEST['groupid']."&page=".$page."'\"><i class=\"fa fa-times icon-only\"></i></a>
					<a href=\"#\" class=\"btn btn-info pdv_enter\" id=\"pr_".$pvdpath."\" title=\"".$strGroupEdit."\" ".adminshow()."><i class=\"fa fa-puzzle-piece icon-only\"></i></a>
				</div>
		    </td>
		  </tr>";
}
?>
				</tbody>
			</table>												
		</div>
	</div>
</div><!-- /Portlet -->


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

	<!-- initial page level scripts for examples -->
	<script src="../../base/admin/assets/js/plugins/slimscroll/jquery.slimscroll.init.js"></script>
	<script src="../../base/admin/assets/js/plugins/footable/footable.init.js"></script>
	<script src="../../base/admin/assets/js/plugins/datatables/datatables.init.js"></script>
		
	<!-- wayhunt & module -->
	<script src="../../base/js/form.js"></script>
	<script src="../../base/js/custom.js"></script>
	<script src="js/frame.js"></script>
	<script src="js/page.js"></script>
		
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>網頁</li>');
			$('#pagetitle', window.parent.document).html('網頁管理 <span class="sub-title" id="subtitle"><?php echo $groupname;?></span>');
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