<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/adminpages.inc.php" );
include( "language/".$sLan.".php" );
needauth( 0 );
#---------------------------------------------#
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


<?php
$step = $_REQUEST['step'];
$key = $_REQUEST['key'];
if ( $step == "del" )
{
		$id = $_GET['id'];
		$msql->query( "select id from {P}_page where groupid='{$id}'" );
		if ( $msql->next_record( ) )
		{
				err( $strGroupNTC4, "", "" );
				exit( );
		}
		$msql->query( "select * from {P}_page_group where id='{$id}'" );
		if ( $msql->next_record( ) )
		{
				$moveable = $msql->f( "moveable" );
				$delfolder = $msql->f( "folder" );
				$delfolder_main = $delfolder."_main";
		}
		else
		{
				err( $strGroupNTC3, "", "" );
				exit( );
		}
		if ( $moveable != "1" )
		{
				err( $strGroupNTC1, "", "" );
				exit( );
		}
		$msql->query( "delete from {P}_base_pageset where coltype='page' and pagename='{$delfolder}'" );
		$msql->query( "delete from {P}_base_pageset where coltype='page' and pagename='{$delfolder_main}'" );
		$msql->query( "delete from {P}_base_plus where plustype='page' and pluslocat='{$delfolder}'" );
		$msql->query( "delete from {P}_base_plus where plustype='page' and pluslocat='{$delfolder_main}'" );
		$msql->query( "delete from {P}_page where groupid='{$id}'" );
		$msql->query( "delete from {P}_page_group where id='{$id}'" );
		if ( $delfolder != "" && 1 < strlen( $delfolder ) && !strstr( $delfolder, "." ) && !strstr( $delfolder, "/" ) )
		{
				delfold( "../".$delfolder );
		}
}

if($step == "edit")
{
	$id = $_GET[id];
	$groupname = $_POST['groupname_'.$id.''];
	$msql->query( "UPDATE {P}_page_group SET groupname='{$groupname}' WHERE id='{$id}'" );
	//記錄多國翻譯資料
	$langlist = $_REQUEST['langlist'];
	if($langlist != ""){			
		$sgroupname = $_REQUEST['sgroupname'];
		$lans = explode(",",$langlist);
		foreach($lans AS $ks=>$vs){
			//擷取各語言資料並寫入
			$groupname = htmlspecialchars($sgroupname[$vs]);
			
				//getupdate 資料若存在則更新，否則新增
				$msql->getupdate(
					"SELECT id FROM {P}_page_group_translate WHERE pid='{$id}' AND langcode='{$vs}'",
					"UPDATE {P}_page_group_translate SET 
					groupname='{$groupname}' WHERE pid='{$id}' AND langcode='{$vs}'",
					"INSERT INTO {P}_page_group_translate SET 
					pid='{$id}',
					langcode='{$vs}',
					groupname='{$groupname}'"
				);
				
		}
	}
}
?>
 
<div class="searchzone">

			
<div class="row">
	<div class="col-lg-12">									
		<div class="portlet">
			<div class="portlet-heading dark">
				<div class="portlet-title">
					<h4><?php echo $strGroupAdd; ?></h4>
				</div>
				<div class="portlet-widgets">
					<a data-toggle="collapse" data-parent="#accordion" href="#f-1"><i class="fa fa-chevron-down"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div id="f-1" class="panel-collapse collapse in">
				<div class="portlet-body">
					<form method="get" action="group.php" class="form-inline pull-left">
						<div class="form-group">
							<input type="text" name="key" size="30" class="form-control" value="<?php echo $key; ?>" placeholder="請輸入關鍵字" />
							<input type="submit" name="Submit2" value="<?php echo $strSearchTitle; ?>" class="btn">
						</div>
					</form>
	
					<div class="pull-right">
						<form id="addGroupForm" method="post"  class="form-inline" action="">
							<div class="form-group">
								<?php echo $strGroupName; ?>&nbsp;
	        					<input type="text" name="groupname" class="form-control"/>&nbsp;
	        					<?php echo $strGroupFolder; ?>&nbsp;
	        					<input name="folder" type="text" class="form-control" id="newfolder" maxlength="16" />
	        					<input name="act" type="hidden" id="act" value="addgroup" />
								<button type="submit" class="btn btn-primary btn-line"><i class="fa fa-plus"></i><?php echo $strGroupAdd; ?></button>
							</div>
						</form>
						<div  id="notice" class="noticediv"></div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
$scl = "  id!='0' ";
if ( $key != "" )
{
		$scl .= " and groupname regexp '{$key}'  ";
}
$totalnums = tblcount( "_page_group", "id", $scl );
$pages = new pages( );
$pages->setvar( array("key" => $key) );
$pages->set( 10, $totalnums );
$pagelimit = $pages->limit( );
?>

<div class="portlet"><!-- Portlet -->
	<div id="basic" class="panel-collapse collapse in">
		<div class="portlet-body no-padding">
			<table class="table table-bordered table-hover tc-table">
				<thead>
					<tr>
						<th class="col-medium center"><?php echo $strNumber; ?></th>
						<th><?php echo $strGroupName; ?></th>
						<th class="hidden-xs"><?php echo $strModify; ?></th>
						<th class="hidden-xs"><?php echo $strGroupFolder; ?></th>
						<th class="hidden-xs"><?php echo $strGroupUrl; ?></th>
						<th class="col-medium center">動作</th>
					</tr>
				</thead>
				<tbody>
	
  
<?php
$msql->query( "select * from {P}_page_group where {$scl} order by id desc limit {$pagelimit}" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$groupname = $msql->f( "groupname" );
		$moveable = $msql->f( "moveable" );
		$folder = $msql->f( "folder" );
		$url = "page/".$folder."/";
		$href = "../".$folder."/";
		echo " 
<form name=\"mod_".$id."\" action=\"group.php?step=edit&id=".$id."\" method=\"post\">
  <tr>
    <td class=\"col-medium center\">".$id."</td>
      <td> ";
?>
		<div class="form-group">
			<label class="row col-sm-2 control-label">預設：</label>
			<div class="row col-sm-9">
       			<input type="text" name="groupname_<?php echo $id; ?>" value="<?php echo $groupname; ?>" class="form-control">
			</div>
			<div class="portlet-widgets pull-right" style="margin-right:10px;">
				<a data-toggle="collapse" data-parent="#accordion_<?php echo $id; ?>" href="#l_<?php echo $id; ?>"><i class="fa fa-chevron-up"> 多語言</i></a>
			</div>
			<div class="clearfix"></div>
		</div>
		<div id="l_<?php echo $id; ?>" class="panel-collapse collapse">
		<!-- 擷取語言表 -->
		<?php
			$langlist = "";
			$fsql->query( "SELECT * FROM {P}_base_language WHERE ifshow='1' AND ifdefault='0' ORDER BY xuhao asc" );
			while ( $fsql->next_record( ) )
			{
				$lid = $fsql->f( "id" );
				$ltitle = $fsql->f( "title" );
				$langcode = $fsql->f( "langcode" );
				$src = ROOTPATH.$fsql->f( "src" );
				$langlist .= $langlist? ",".$langcode:$langcode;
				
				//依表擷取語言檔內容
				$langs = $tsql->getone( "SELECT * FROM {P}_page_group_translate WHERE pid='{$id}' AND langcode='{$langcode}'" );
		?>
			<div class="form-group">
				<label class="row col-sm-2 control-label"><?php echo $ltitle; ?>：</label>
				<div class="row col-sm-9">
					<input type="text" class="form-control" name="sgroupname[<?php echo $langcode; ?>]" id="sgroupname_<?php echo $langs['id']; ?>" value="<?php echo $langs['groupname']; ?>">
				</div>
				<div class="clearfix"></div>
			</div>
		<?php
			}
		?>
			<input type="hidden" name="langlist" value="<?php echo $langlist; ?>" />
			<div>
		</div>
<?php
      echo "</td>
      <td class=\"hidden-xs\"><button type=\"submit\" class=\"btn btn-inverse\" title=\"".$strModify."\"><i class=\"fa fa-pencil icon-only\"></i></button></td>
      <td class=\"hidden-xs\">".$folder."</td>
      <td class=\"hidden-xs\"><a href='".$href."' target='_blank'>".$url."</a> </td>
      <td>";
		if ( $moveable == "1" )
		{
				echo "<a href=\"#\" class=\"btn btn-danger\" title=\"".$strDelete."\" onClick=\"self.location='group.php?step=del&id=".$id."'\"><i class=\"fa fa-times icon-only\"></i></a>";
		}
		echo "<a href=\"#\" class=\"btn btn-info pdv_enter\" id=\"pr_".$folder."\" title=\"".$strGroupEdit."\" ".adminshow()."><i class=\"fa fa-puzzle-piece icon-only\"></i></a></td></tr></form>";
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
			$('#pagetitle', window.parent.document).html('網頁管理 <span class="sub-title" id="subtitle"><?php echo $setMenu2;?></span>');
			//呼叫左側功能選單
			$().getMenuGroup('page');
		});
	</script>
		
	<script>
        $(document).ready(function() {
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
    </script>
  </body>
</html>