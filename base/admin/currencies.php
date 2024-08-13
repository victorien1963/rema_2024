<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
include( "func/upload.inc.php" );
NeedAuth(0);

#---------------------------------------------#

$step=$_REQUEST["step"];

//新增
if($step=="add"){
	
	$msql->query("select max(xuhao) from {P}_base_currency");
	if($msql->next_record()){
		$newxuhao=$msql->f('max(xuhao)')+1;
	}

	$msql->query("insert into {P}_base_currency set 
	title='新貨幣',
	showtitle='顯示貨幣名稱',
	pricesymbol='貨幣符號',
	pricecode='貨幣代號',
	langcode='搭配語言',
	rate='1',
	point='0',
	xuhao='$newxuhao',
	ifshow='1'
	");
}

//修改
if($step=="modi"){
	
	$id=$_REQUEST["id"];
	$xuhao=htmlspecialchars($_REQUEST["xuhao"]);
	$title=htmlspecialchars($_REQUEST["title"]);
	$showtitle=htmlspecialchars($_REQUEST["showtitle"]);
	$pricesymbol=htmlspecialchars($_REQUEST["pricesymbol"]);
	$pricecode=htmlspecialchars($_REQUEST["pricecode"]);
	$langcode=htmlspecialchars($_REQUEST["langcode"]);
	$rate=htmlspecialchars($_REQUEST["rate"]);
	$point=htmlspecialchars($_REQUEST["point"]);
	$ifshow=$_REQUEST["ifshow"];
	$ifdefault=$_REQUEST["ifdefault"];
	$oldsrc=$_REQUEST["oldsrc"];
	
	
	//如果是預設值，則其他語言先改為非預設
	if($ifdefault=="1"){
		$msql->query("update {P}_base_currency SET ifdefault='0' WHERE ifdefault='1'");
	}else{
		$getd = $msql->getone("SELECT id FROM {P}_base_currency WHERE ifdefault='1' AND id!='{$id}'");
		if(!$getd["id"]){
			$ifdefault="1";
		}
	}
	
	
	$msql->query("update {P}_base_currency set 
	title='$title',
	showtitle='$showtitle',
	pricesymbol='$pricesymbol',
	pricecode='$pricecode',
	langcode='$langcode',
	ifshow='$ifshow',
	xuhao='$xuhao',
	rate='$rate',
	point='$point',
	ifdefault='$ifdefault' 
	where id='$id'");
	
	exit();
}

//刪除
if($step=="del"){
	$id=$_REQUEST["id"];
	$msql->query("delete from {P}_base_currency where id='$id'");
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

<div class="row">
	<div class="col-lg-12">									
		<div class="portlet">
			<div class="portlet-heading dark">
				<div class="portlet-title">
					<h4>多國貨幣設置</h4>
				</div>
				<div class="portlet-widgets">
					<a data-toggle="collapse" data-parent="#accordion" href="#f-2"><i class="fa fa-chevron-down"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div id="f-2" class="panel-collapse collapse in">
				<div class="portlet-body">
						<button type="button" class="btn btn-success" onClick="window.location='currencies.php?step=add&groupid=<?php echo $groupid; ?>&pid=0'"><i class="fa fa-pencil-square"></i> 新增貨幣</button>
							<input type="hidden" name="step" value="chgname" />
							<input type="hidden" name="groupid" value="<?php echo $groupid; ?>" />
				</div>
				<div class="portlet-body no-padding">
					<div id="basic" class="panel-collapse collapse in">
						<div class="portlet-body no-padding">
							<table class="table table-bordered table-striped table-hover tc-table table-primary footable" data-page-size="50" data-editable="true">
								<thead>
									<tr>
										<th data-sort-ignore="true" class="center">序號</th>
										<th data-sort-ignore="true">貨幣國家</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">前台顯示名稱</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">貨幣符號</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">貨幣代號</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">搭配語言</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">匯率</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">小數點後幾位</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">是否啟用</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">預設貨幣</th>
										<th data-sort-ignore="true" class="col-medium center">動　 作</th>
									</tr>
								</thead>
								<tbody>
<?php 
	//選單開始
	$cc=0;
	$msql->query("select * from {P}_base_currency order by xuhao");
	while($msql->next_record()){
		$id=$msql->f('id');
		$xuhao=$msql->f('xuhao');
		$title=$msql->f('title');
		$showtitle=$msql->f('showtitle');
		$pricesymbol=$msql->f('pricesymbol');
		$pricecode=$msql->f('pricecode');
		$langcode=$msql->f('langcode');
		$rate=$msql->f('rate');
		$point=$msql->f('point');
		$ifshow=$msql->f('ifshow');
		$ifdefault=$msql->f('ifdefault');
?> 
										<form id="form_<?php echo $id; ?>" class="form" method="post" action="currencies.php" enctype="multipart/form-data" name="colset_<?php echo $id; ?>">
									<tr>
										<td class="center">
										<input type="text" class="form-control input-mini" name="xuhao" value="<?php echo $xuhao; ?>"></td>
										<td><input type="text" class="form-control" name="title" value="<?php echo $title; ?>"></td>
										<td><input type="text" class="form-control" name="showtitle" id="showtitle_<?php echo $id; ?>" value="<?php echo $showtitle; ?>"></td>
										<td><input type="text" class="form-control input-small" name="pricesymbol" id="pricesymbol_<?php echo $id; ?>" value="<?php echo $pricesymbol; ?>"></td>
										<td><input type="text" class="form-control input-small" name="pricecode" id="pricecode_<?php echo $id; ?>" value="<?php echo $pricecode; ?>"></td>
										<td><input type="text" class="form-control input-small" name="langcode" id="langcode_<?php echo $id; ?>" value="<?php echo $langcode; ?>"></td>
										<td><input type="text" class="form-control input-small" name="rate" id="rate_<?php echo $id; ?>" value="<?php echo $rate; ?>"></td>
										<td><input type="text" class="form-control input-small" name="point" value="<?php echo $point; ?>"></td>
										<td>
											<select class="form-control" name="ifshow" id="ifshow_<?php echo $id; ?>">
												<option value="1" <?php echo seld($ifshow,'1'); ?>><?php echo $strShow; ?></option>
	          									<option value="0" <?php echo seld($ifshow,'0'); ?>><?php echo $strHidden; ?></option>
          									</select>
          								</td>
										<td>
											<label>
												<input id="ifdefault_<?php echo $id; ?>" class="tc tc-switch tc-switch-6" type="checkbox" <?php echo checked($ifdefault,'1'); ?>/>
												<span class="labels"></span>
											</label>
											<input type="hidden" id="getdefault_<?php echo $id; ?>" name="ifdefault" value="<?php echo $ifdefault; ?>" />
          								</td>
										<td class="col-medium center">
											<div class="btn-group btn-group-sm ">
												<button type="button" id="btn_<?php echo $id; ?>_<?php echo $cc; ?>" class="btn btn-inverse sub" title="<?php echo $strModify; ?>"><i class="fa fa-pencil icon-only"></i></button>
												<a href="javascript:;" class="btn btn-danger" title="<?php echo $strDelete; ?>" onClick="window.location='currencies.php?step=del&groupid=<?php echo $groupid; ?>&id=<?php echo $id; ?>&oldsrc=<?php echo $src; ?>'"><i class="fa fa-times icon-only"></i></a>
											</div>	
										<input type="hidden" name="id" value="<?php echo $id; ?>" />
								        <input type="hidden" name="step" value="modi" />
										</td>
									</tr>
										</form>
<?php
	$cc++;
	}
	//選單結束
?> 
								</tbody>
								<tfoot>
									<tr>
										<td colspan="7">
											<ul class="hide-if-no-paging pagination pagination-centered pull-right"></ul>
											<div class="clearfix"></div>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
									
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
		
	<!-- Themes Core Scripts -->	
	<script src="../../base/admin/assets/js/main.js"></script>
		
	<!-- wayhunt & module -->
	<script src="../../base/js/form.js"></script>
	<script src="js/frame.js"></script>
		
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="index.php">Home</a></li><li class="active">設置</li>');
			$('#pagetitle', window.parent.document).html('系統設置 <span class="sub-title" id="subtitle">多國貨幣設置</span>');
			//呼叫左側功能選單
			$().getMenuGroup('config');
		});
	</script>
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
		
	<script>
		$(document).ready(function() {
        	/*$("td").on("click",function () {
        		setTimeout(function () {
                     window.parent.doIframe();
                 }, 0);
        	});*/
        	
        	$(".tc-switch").click(function () {
        		var swid = this.id.substr(10);
        		var gg = $(this).prop("checked");
        		if(gg){
        			$("#getdefault_"+swid).val(1);
        		}else{
        			$("#getdefault_"+swid).val(0);
        		}
	        });
	        
	        	$('.sub').click(function(){ 
	        		var gid = this.id.substr(4);
	        		var idarr = gid.split("_");
	        		var getid = idarr[0];
	        		var cc = idarr[1];
	        		var showtitle = $('#showtitle_'+getid).val();
	        		var pricesymbol = $('#pricesymbol_'+getid).val();
	        		var pricecode = $('#pricecode_'+getid).val();
	        		var langcode = $('#langcode_'+getid).val();
	        		var rate = $('#rate_'+getid).val();
	        		var ifshow = $('#ifshow_'+getid).val();
	        		var ifdefault = $('#getdefault_'+getid).val();
	        		
	        		var formData = new FormData($('form')[cc]);
	        		formData.append("showtitle", showtitle);
	        		formData.append("pricesymbol", pricesymbol);
	        		formData.append("pricecode", pricecode);
	        		formData.append("langcode", langcode);
	        		formData.append("rate", rate);
	        		formData.append("ifshow", ifshow);
	        		formData.append("ifdefault", ifdefault);
	        		
	        		
				    $.ajax({
				        url: 'currencies.php',
				        type: 'POST',
				        data: formData,
				        cache: false,
				        contentType: false,
				        processData: false,
						success: function(msg) {
							self.location='currencies.php';
						}
				    });
	        		
	        		
					/*$('#form_'+getid).ajaxSubmit({
						url: 'currencies.php?showtitle='+showtitle+'&pricecode='+pricecode+'&ifshow='+ifshow+'&ifdefault='+ifdefault,
						type: 'POST',
						success: function(msg) {
							self.location='currencies.php';
						}
					}); */
			       return false; 
			   }); 
	        
		});
	</script>
	
	<script src="assets/js/plugins/iframeautoheight/iframeResizer.contentWindow.min.js"></script>
  </body>
</html>