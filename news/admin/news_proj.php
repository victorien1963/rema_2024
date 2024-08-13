<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include_once(ROOTPATH."includes/adminpages.inc.php");
include("language/".$sLan.".php");
NeedAuth(123);
#---------------------------------------------#

$step=$_REQUEST["step"];
$key=$_REQUEST["key"];

if($step=="del"){
	$id=$_GET["id"];
	$fmpath=fmpath($id).":";
	$msql->query("select id from {P}_news_con where proj regexp '$fmpath' ");
	if($msql->next_record()){
		err($strProjNTC5,"","");
		exit;
	}
	
	$msql->query("select folder from {P}_news_proj where id='$id'");
	if($msql->next_record()){
		$delfolder=$msql->f('folder');
	}else{
		err($strProjNTC6,"","");
		exit;
	}
	
	$pagename="proj_".$delfolder;
	
	//刪除頁面記錄
	$msql->query("delete from {P}_base_pageset where coltype='news' and pagename='$pagename'");
	
	//刪除元件記錄
	$msql->query("delete from {P}_base_plus where plustype='news' and pluslocat='$pagename'");
	
	//刪除專題
	$msql->query("delete from {P}_news_proj where id='$id'");
	$msql->query("delete from {P}_news_proj_translate where pid='$id'");
	
	//刪除文件和目錄
	if($delfolder!="" && strlen($delfolder)>1 && !strstr($delfolder,".") && !strstr($delfolder,"/")){
		DelFold("../project/".$delfolder);
	}	
	
}

if($step=="modi"){
	
	$id=$_GET["id"];
	$proj=htmlspecialchars($_GET["proj"]);

	$msql->query("update {P}_news_proj set project='$proj' where id='$id' ");
	
	//記錄多國翻譯資料
	$langlist = $_REQUEST['langlist'];
	if($langlist != ""){			
		$sproj = $_REQUEST['sproj'];
		$lans = explode(",",$langlist);
		foreach($lans AS $ks=>$vs){
			//擷取各語言資料並寫入
			$projs = htmlspecialchars($sproj[$vs]);
				//getupdate 資料若存在則更新，否則新增
				$msql->getupdate(
					"SELECT id FROM {P}_news_proj_translate WHERE pid='{$id}' AND langcode='{$vs}'",
					"UPDATE {P}_news_proj_translate SET 
					project='{$projs}' WHERE pid='{$id}' AND langcode='{$vs}'",
					"INSERT INTO {P}_news_proj_translate SET 
					pid='{$id}',
					langcode='{$vs}',
					project='{$projs}'"
				);
				
		}
	}//多國
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
<div class="row">
	<div class="col-lg-12">									
		<div class="portlet">
			<div id="f-1" class="panel-collapse collapse in">
				<div class="portlet-body">
					<form method="get" action="news_proj.php" class="form-inline pull-left" role="form">
						<div class="input-group">
							<input type="text" name="key" class="form-control search-query" value="<?php echo $key; ?>" />       
							<span class="input-group-btn">
								<button type="submit" name="Submit2" class="btn btn-primary" title="<?php echo $strSearchTitle; ?>">
									<i class="fa fa-search icon-only"></i>
								</button>
							</span>
						</div>
					</form>
	
					<div class="pull-right">
						<form id="addProjForm" method="post" action="" class="form-horizontal">
						<div class="fleft">
							<input name="act" type="hidden" id="act" value="addproj" />
							<input type="text" name="project" placeholder="<?php echo $strProjName; ?>" class="form-control" />
						</div>
						<div class="fleft" style="margin: 0 5px;">
					        <input name="folder" type="text" placeholder="<?php echo $strProjFolder; ?>" class="form-control" id="newfolder" maxlength="16" />
						</div>
						<div class="fleft">
							<button type="submit" name="cd" class="btn btn-primary btn-line"><i class="fa fa-plus"></i><?php echo $strProjNew; ?></button>
						</div>
						</form>
					</div>
					<div  id="notice" class="noticediv"></div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$scl="  id!='0' ";
	if($key!=""){
		$scl.=" and project regexp '$key'  ";
	}
	$totalnums=TblCount("_news_proj","id",$scl);
	$pages = new pages;		
	$pages->setvar(array("key" => $key));
	$pages->set(10,$totalnums);
	$pagelimit=$pages->limit();
?>
<div class="row">
	<div class="col-lg-12">
		<div class="portlet table-responsive">
			<div class="portlet-body no-padding">
				<table class="table table-bordered table-hover tc-table tc-gallery">
					<tr>
						<th class="col-mini center"><?php echo $strNumber; ?></th>
						<th class="col-width"><?php echo $strProjName; ?></th>
						<th class="col-mini center"><?php echo $strModify; ?></th>
						<th class="col-medium center"><?php echo $strProjFolder; ?></th>
						<th class="col-large center"><?php echo $strProjUrl; ?></th>
						<th class="col-mini center"><?php echo $strProjEdit; ?></th>
						<th class="col-mini center"><?php echo $strDelete; ?></th>
					</tr>
<?php
$msql->query("select * from {P}_news_proj where $scl order by id desc limit $pagelimit");
while($msql->next_record()){
	$id=$msql->f("id");
	$project=$msql->f("project");
	$folder=$msql->f("folder");
	$url="news/project/".$folder."/";
	$href="../project/".$folder."/";
?>
	<tr>
		<form method="get" action="news_proj.php" class="form-horizontal">
		<td class="col-mini center"><?php echo $id; ?></td>
		<td class="col-width">
			<div class="form-group">
				<label class="row col-sm-2 control-label text-right" style="width:10%;">預設：</label>
				<div class="row col-sm-10">
					<input type="text" name="proj" value="<?php echo $project; ?>" id="proj_<?php echo $id; ?>" class="form-control" />
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
						$langs = $tsql->getone( "SELECT * FROM {P}_news_proj_translate WHERE pid='{$id}' AND langcode='{$langcode}'" );
				?>
					<div class="form-group">
						<label class="row col-sm-2 control-label text-right" style="width:10%;"><?php echo $ltitle; ?>：</label>
						<div class="row col-sm-10">
							<input type="text" class="form-control" name="sproj[<?php echo $langcode; ?>]" id="sproj_<?php echo $langs['id']; ?>" value="<?php echo $langs['project']; ?>">
						</div>
						<div class="clearfix"></div>
					</div>
				<?php
					}
				?>
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="step" value="modi" />
		        <input type="hidden" name="langlist" value="<?php echo $langlist; ?>" />
			<div>
		</td>
		<th class="col-mini center"><input type="image"  name="imageField" src="images/modi.png" /></th>
		<td class="col-medium center"><?php echo $folder; ?></td>
		<td class="col-large center"><a href='<?php echo $href; ?>' target='_blank'><?php echo $url; ?></a></td>
		<td class="col-mini center"><img id='pr_<?php echo $folder; ?>' class='pdv_enter' src="images/edit.png"  style="cursor:pointer"  border="0" /></td>
		<td class="col-mini center"><img src="images/delete.png"  style="cursor:pointer"   onclick="self.location='news_proj.php?step=del&id=<?php echo $id; ?>'" /></td>
		</form>
	</tr>
<?php
}
?> 
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
			$('#pagetitle', window.parent.document).html('文章管理 <span class="sub-title" id="subtitle">專題管理</span>');
			//呼叫左側功能選單
			$().getMenuGroup('news');
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