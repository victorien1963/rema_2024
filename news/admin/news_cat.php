<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
NeedAuth(121);
#---------------------------------------------#
$pid=$_REQUEST["pid"];
$step=$_REQUEST["step"];
$cc=$_REQUEST["cc"];

if(!isset($pid) || $pid==""){
$pid=0;
}


if($step=="add" && $_REQUEST["cat"]!="" && $_REQUEST["cat"]!=" "){
	$cat= $_REQUEST["cat"];
	$cat=htmlspecialchars($cat);
	

	if($pid!="0"){
		$msql->query("select catpath from {P}_news_cat where catid='$pid'");
		if($msql->next_record()){
			$pcatpath=$msql->f('catpath');
		}
	}

	$msql->query("select max(xuhao) from {P}_news_cat where pid='$pid'");
		if($msql->next_record()){
			$maxxuhao=$msql->f('max(xuhao)');
			$nowxuhao=$maxxuhao+1;
		}

	$msql->query("insert into {P}_news_cat set
	`pid`='$pid',
	`cat`='$cat',
	`xuhao`='$nowxuhao',
	`catpath`='$catpath',
	`nums`='0',
	`tj`='0',
	`hide`='0',
	`ifchannel`='0'
	");

    $nowcatid=$msql->instid();
	$nowpath=fmpath($nowcatid);
	$catpath=$pcatpath.$nowpath.":";

	$msql->query("update {P}_news_cat set catpath='$catpath' where catid='$nowcatid'");

}
if($step=="del"){

	$catid=$_GET["catid"];
	$pid=$_GET["pid"];
	

	$msql->query("select id from {P}_news_con where catid='$catid' ");
	if($msql->next_record()){
		err($strNewsNotice1,"","");
		exit;
	}
	$msql->query("select catid from {P}_news_cat where pid='$catid'");
	if($msql->next_record()){
		err($strNewsNotice2,"","");
		exit;
	}

	$msql->query("select ifchannel from {P}_news_cat where catid='$catid'");
	if($msql->next_record()){
		$ifchannel=$msql->f('ifchannel');
	}
	if($ifchannel!=0){
		err($strNewsNotice9,"","");
		exit;
	}
	
	$msql->query("delete from {P}_news_cat where catid='$catid'");
	$msql->query("delete from {P}_news_cat_translate where pid='$catid'");
	//刪除參數(含多語言)
	$msql->query("select * from {P}_news_prop where catid='$catid'");
	while($msql->next_record()){
		$ppid=$msql->f('id');
		$fsql->query("delete from {P}_news_prop_translate where pid='$ppid'");
	}
	$msql->query("delete from {P}_news_prop where catid='$catid'");
}


if($step=="modi"){
	
	$cat=$_GET["cat"];
	$catid=$_GET["catid"];
	$pid=$_GET["pid"];
	$xuhao=$_GET["xuhao"];
	$hide=$_GET["hide"];
	
	$tj=$_GET["tj"];
	$cat=htmlspecialchars($cat);

	$msql->query("update {P}_news_cat set cat='$cat',xuhao='$xuhao',hide='$hide' where catid='$catid' ");
	$msql->query("update {P}_news_cat set tj='$tj' where catpath regexp '".fmpath($catid)."' ");
	
	//記錄多國翻譯資料
	$langlist = $_REQUEST['langlist'];
	if($langlist != ""){			
		$scat = $_REQUEST['scat'];
		$lans = explode(",",$langlist);
		foreach($lans AS $ks=>$vs){
			//擷取各語言資料並寫入
			$cats = htmlspecialchars($scat[$vs]);
				//getupdate 資料若存在則更新，否則新增
				$msql->getupdate(
					"SELECT id FROM {P}_news_cat_translate WHERE pid='{$catid}' AND langcode='{$vs}'",
					"UPDATE {P}_news_cat_translate SET 
					cat='{$cats}' WHERE pid='{$catid}' AND langcode='{$vs}'",
					"INSERT INTO {P}_news_cat_translate SET 
					pid='{$catid}',
					langcode='{$vs}',
					cat='{$cats}'"
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
					<form id="selgroup" name="selgroup" method="get" action="" class="form-inline pull-left" role="form">
						<div class="form-group">
							<select name="pid" class="form-control" onChange="self.location=this.options[this.selectedIndex].value">
							  <option value='news_cat.php'><?php echo $strNewsSelCat; ?></option>
						         <?php
										$fsql -> query ("select * from {P}_news_cat order by catpath");
										while ($fsql -> next_record ()) {
											$lpid = $fsql -> f ("pid");
											$lcatid = $fsql -> f ("catid");
											$cat = $fsql -> f ("cat");
											$catpath = $fsql -> f ("catpath");
											$lcatpath = explode (":", $catpath);
											
											for ($i = 0; $i < sizeof ($lcatpath)-2; $i ++) {
												$tsql->query("select catid,cat from {P}_news_cat where catid='$lcatpath[$i]'");
												if($tsql->next_record()){
													$ncatid=$tsql->f('cat');
													$ncat=$tsql->f('cat');
													$ppcat.=$ncat."/";
												}
											}
											
											if($pid==$lcatid){
												echo "<option value='news_cat.php?pid=".$lcatid."' selected>".$ppcat.$cat."</option>";
											}else{
												echo "<option value='news_cat.php?pid=".$lcatid."'>".$ppcat.$cat."</option>";
											}
											$ppcat="";
										}
								 ?>
						        </select>
						</div>
					</form>
	
					<div class="pull-right">
						<form name="addcat" method="get" action="news_cat.php" class="form-horizontal" onSubmit="return catCheckform(this)">
						<input type="hidden" name="step" value="add" />
						<div class="fleft">
							<select name="pid" id="pid" class="form-control">
								<option value='0'><?php echo $strCatTopAdd; ?></option>
								<?php
									$fsql -> query ("select * from {P}_news_cat order by catpath");
									while ($fsql -> next_record ()) {
										$lpid = $fsql -> f ("pid");
										$lcatid = $fsql -> f ("catid");
										$cat = $fsql -> f ("cat");
										$catpath = $fsql -> f ("catpath");
										$lcatpath = explode (":", $catpath);
										for ($i = 0; $i < sizeof ($lcatpath)-2; $i ++) {
											$tsql->query("select catid,cat from {P}_news_cat where catid='$lcatpath[$i]'");
											if($tsql->next_record()){
												$ncatid=$tsql->f('cat');
												$ncat=$tsql->f('cat');
												$ppcat.=$ncat."&gt;";
											}
										}
										
										if($pid==$lcatid){
											echo "<option value='".$lcatid."' selected>".$strCatLocat1.$ppcat.$cat."</option>";
										}else{
											echo "<option value='".$lcatid."'>".$strCatLocat1.$ppcat.$cat."</option>";
										}
										$ppcat="";
									}
								?>
							</select>
						</div>
						<div class="fleft" style="margin: 0 5px;">
							<input name="cat" type="text" class="form-control" placeholder="<?php echo $strNewsCatName; ?>" value="" />
						</div>
						<div class="fleft">
							<button type="submit" class="btn btn-primary btn-line" <?php echo $buttondis; ?>  /><i class="fa fa-plus"></i><?php echo $strCatAdd; ?></button>
						</div>
						</form>
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
				<!---->
				<table class="table table-bordered table-hover tc-table tc-gallery">
					<thead>
						<tr>
							<th class="col-mini center"><?php echo $strNumber; ?></th> 
							<th class="col-mini center"><?php echo $strXuhao; ?></th>
							<th class="col-width center"><?php echo $strCat; ?> </th>
							<th class="col-mini center"><?php echo $strNewsList6; ?></th>
							<th class="col-mini center">隱藏</th>
							<th class="col-mini center"><?php echo $strModify; ?></th>
							<th class="col-small center"><?php echo $strCatTemp; ?></th>
							<th class="col-mini center"><?php echo $strZl; ?></th>
							<th class="col-large center"><?php echo $strZlUrl; ?></th>
							<th class="col-mini center"><?php echo $strZlEdit; ?></th>
							<th class="col-small center"><?php echo $strColProp; ?></th>
							<th class="col-mini center"><?php echo $strDelete; ?></th>
						</tr>
					</thead>
					<tbody>
<?php
	$msql->query("select * from {P}_news_cat where  pid='$pid' order by xuhao");
	while($msql->next_record()){
		$catid=$msql->f("catid");
		$cat=$msql->f("cat");
		$xuhao=$msql->f("xuhao");
		$pid=$msql->f("pid");
		$tj=$msql->f("tj");
		$hide=$msql->f("hide");
		$catpath=$msql->f("catpath");
		$ifchannel=$msql->f("ifchannel");
		$ifcattemp = $msql->f( "cattemp" );

		if($ifchannel=="1"){
			$href="../class/".$catid."/";
			$url="news/class/".$catid."/";
		}else{
			$href="../class/?".$catid.".html";;
			$url="news/class/?".$catid.".html";
		}
?> 
						<tr>
							<form method="get" action="news_cat.php" class="form-horizontal">
								<td class="col-mini center">
									<?php echo $catid; ?>
								</td> 
								<td class="col-mini center">
									<input type="text" name="xuhao" size="3" value="<?php echo $xuhao; ?>" class="form-control" />
								</td>
								<td class="col-width">
									<div class="form-group">
									<label class="row col-sm-2 control-label text-right">預設：</label>
										<div class="row col-sm-9">
											<input type="text" name="cat" value="<?php echo $cat; ?>" id="cat_<?php echo $catid; ?>" class="form-control" />
										</div>
										<div class="portlet-widgets pull-right" style="margin-right:10px;">
											<a data-toggle="collapse" data-parent="#accordion_<?php echo $catid; ?>" href="#l_<?php echo $catid; ?>"><i class="fa fa-chevron-up"> 多語言</i></a>
										</div>
										<div class="clearfix"></div>
									</div>
										<div id="l_<?php echo $catid; ?>" class="panel-collapse collapse">
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
													$langs = $tsql->getone( "SELECT * FROM {P}_news_cat_translate WHERE pid='{$catid}' AND langcode='{$langcode}'" );
											?>
												<div class="form-group">
													<label class="row col-sm-2 control-label text-right"><?php echo $ltitle; ?>：</label>
													<div class="row col-sm-9">
														<input type="text" class="form-control" name="scat[<?php echo $langcode; ?>]" id="scat_<?php echo $langs['id']; ?>" value="<?php echo $langs['cat']; ?>">
													</div>
													<div class="clearfix"></div>
												</div>
											<?php
												}
											?>
											<input type="hidden" name="catid" value="<?php echo $catid; ?>" />
											<input type="hidden" name="step" value="modi" />
											<input type="hidden" name="pid" value="<?php echo $pid; ?>" />
									        <input type="hidden" name="langlist" value="<?php echo $langlist; ?>" />
										<div>
								</td>
								<td class="col-mini center">
									<label class="tcb-inline" style="margin-right:0;">
										<input type="checkbox" class="tc" name="tj" value="1" <?php echo checked($tj,"1"); ?>><span class="labels"></span>
									</label>
								</td>
								<td class="col-mini center">
									<label class="tcb-inline" style="margin-right:0;">
										<input type="checkbox" class="tc" name="hide" value="1" <?php echo checked($hide,"1"); ?>><span class="labels"></span>
									</label>
								</td>
								<td class="col-mini center">
									<input type="image"  name="imageField" src="images/modi.png" width="24" height="24" />
								</td>
								<td class="col-small center">
									<label class="tcb-inline" style="margin-right:0;">
										<input type="checkbox" id="setcattemp_<?php echo $catid; ?>" name="setcattemp" value="<?php echo $cat; ?>" <?php echo checked( $ifcattemp, "1" ); ?> class="tc setcattemp"><span class="labels"></span>
									</label>
									
								</td>
								<td class="col-mini center">
									<label class="tcb-inline" style="margin-right:0;">
										<input type="checkbox" id="setchannel_<?php echo $catid; ?>" name="setchannel" value="<?php echo $cat; ?>" <?php echo checked($ifchannel,"1"); ?> class="tc setchannel"><span class="labels"></span>
									</label>
									<input id="href_<?php echo $catid; ?>" type="hidden" name="href" value="<?php echo $href; ?>"  />
								</td>
								<td class="col-large center" id="url_<?php echo $catid; ?>">
									<a href='<?php echo $href; ?>' target='_blank'><?php echo $url; ?></a>
								</td>
								<td class="col-mini center">
									<img id='pr_<?php echo $catid; ?>' class='pr_enter' src="images/edit.png"  style="cursor:pointer"  border="0" />
								</td>
								<td class="col-small center">
									<img src="images/prop.png" border=0 style="cursor:pointer;display:<?php echo $listdis; ?>" onClick="callcolorbox('../../news/admin/prop_frame.php?catid=<?php echo $catid; ?>&pid=<?php echo $pid; ?>')">
								</td>
								<td class="col-mini center">
									<img src="images/delete.png"  style="cursor:pointer"  border=0 onClick="self.location='news_cat.php?step=del&catid=<?php echo $catid; ?>&pid=<?php echo $pid; ?>'">
								</td>
							</form>
						</tr>
<?php
	}
?> 
					<tbody>
				</table>
				<!---->
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
			$('#pagetitle', window.parent.document).html('文章管理 <span class="sub-title" id="subtitle">文章分類管理</span>');
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
		//colorbox function
		function callcolorbox(href){
			var $overflow = '';
				var colorbox_params = {
				href: href,
				scrolling:true,
				iframe:true,
				close:'<i class="fa fa-times text-primary"></i>',
				width:'80%',
				height:'80%',
				onOpen:function(){
					$overflow = parent.document.body.style.overflow;
					parent.document.body.style.overflow = 'hidden';
				},
				onClosed:function(){
					parent.document.body.style.overflow = $overflow;
				}
			};
			window.parent.$.colorbox(colorbox_params);
		}//colorbox end
    </script>
  </body>
</html>