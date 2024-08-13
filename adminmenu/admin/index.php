<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
NeedAuth(0);

#---------------------------------------------#

$step=$_REQUEST["step"];
$groupid=$_REQUEST["groupid"];

if($step=="chgname"){
	$groupname = $_REQUEST["chgname"];
	$coltypename = $_REQUEST["chgcoltype"];
	$msql->query("update {P}_adminmenu_group set groupname='$groupname',coltype='$coltypename' where id='$groupid' ");
}

if($groupid==""){
	$msql->query("select * from {P}_adminmenu_group limit 0,1");
}else{
	$msql->query("select * from {P}_adminmenu_group where id='$groupid'");
}

if($msql->next_record()){
	$groupid=$msql->f('id');
	$groupname=$msql->f('groupname');
	$coltype=$msql->f('coltype');
	$moveable=$msql->f('moveable');
	if($moveable=="0"){
		$buttondis=" style='display:none' ";
	}
}

if($step=="del"){
	$id=$_REQUEST["id"];
	$msql->query("delete from {P}_adminmenu where id='$id'");
}

if($step=="modi"){
	
	$id=$_REQUEST["id"];
	$menu=htmlspecialchars($_REQUEST["menu"]);
	$xuhao=htmlspecialchars($_REQUEST["xuhao"]);
	$ifshow=$_REQUEST["ifshow"];
	$url=htmlspecialchars($_REQUEST["url"]);
	$getauth=htmlspecialchars($_REQUEST["auth"]);
	$getauthuser=htmlspecialchars($_REQUEST["authuser"]);
	
	$msql->query("update {P}_adminmenu set 
	menu='$menu',
	xuhao='$xuhao',
	url='$url',
	ifshow='$ifshow',
	auth='$getauth',
	authuser='$getauthuser' 
	where  id='$id'");
}

//新增
if($step=="add"){
	
	$msql->query("select max(xuhao) from {P}_adminmenu where groupid='$groupid'");
	if($msql->next_record()){
		$newxuhao=$msql->f('max(xuhao)')+1;
	}

	$msql->query("insert into {P}_adminmenu set 
	groupid='$groupid',
	menu='$strColMenuName',
	xuhao='$newxuhao',
	url='',
	ifshow='1'
	");
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
					<h4><?php echo $strGroupAdd; ?></h4>
				</div>
				<div class="portlet-widgets">
					<a data-toggle="collapse" data-parent="#accordion" href="#f-1"><i class="fa fa-chevron-down"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div id="f-1" class="panel-collapse collapse in">
				<div class="portlet-body">
					<form id="addgroup" name="addgroup" method="post" action="" class="form-inline" role="form">
						<div class="form-group">
							<label class="sr-only"><?php echo $strGroupAddName; ?></label>
							<input type="text" class="form-control" name="groupname" placeholder="<?php echo $strGroupAddName; ?>">
						</div>
						<div class="form-group">
							<label class="sr-only"><?php echo $strColtypeAddName; ?></label>
							<input type="text" class="form-control" name="coltypename" placeholder="<?php echo $strColtypeAddName; ?>">
						</div>
						<input type="hidden" name="act" value="addgroup" />
						<button type="submit" class="btn btn-primary btn-line"><i class="fa fa-plus"></i>新　增</button>
						<div class="pull-right">
							<input type="hidden" id="gid" value="<?php echo $groupid; ?>" />
							<button type="button" id="btdelgroup" class="btn btn-inverse" <?php echo $buttondis; ?>><?php echo $strGroupDel; ?> <i class="fa fa-trash icon-on-right"></i></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
	
<div class="row">
	<div class="col-lg-12">									
		<div class="portlet">
			<div class="portlet-heading dark">
				<div class="portlet-title">
					<h4>自訂模組選單</h4>
				</div>
				<div class="portlet-widgets">
					<a data-toggle="collapse" data-parent="#accordion" href="#f-2"><i class="fa fa-chevron-down"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div id="f-2" class="panel-collapse collapse in">
				<div class="portlet-body">
					<form class="form-inline clearfix" role="form" action="index.php">

						<button type="button" class="btn btn-success" onClick="window.location='index.php?step=add&groupid=<?php echo $groupid; ?>&pid=0'"><i class="fa fa-pencil-square"></i> <?php echo $strColAdd; ?></button>

						<div class="pull-right">
							<div class="form-group">
								<label class="sr-only"><?php echo $strGroupAddName; ?></label>
								<input type="text" class="form-control" placeholder="<?php echo $strGroupAddName; ?>" name="chgname" value="<?php echo $groupname;?>">
							</div>
							<div class="form-group">
								<label class="sr-only"><?php echo $strColtypeAddName; ?></label>
								<input type="text" class="form-control" placeholder="<?php echo $strColtypeAddName; ?>" name="chgcoltype" value="<?php echo $coltype;?>">
							</div>
							<button type="submit" class="btn btn-primary btn-line"><i class="fa fa-pencil"></i>修　改</button>
						</div>
							<input type="hidden" name="step" value="chgname" />
							<input type="hidden" name="groupid" value="<?php echo $groupid; ?>" />
					</form>
				</div>
				<div class="portlet-body no-padding">
					<div id="basic" class="panel-collapse collapse in">
						<div class="portlet-body no-padding">
							<table class="table table-bordered table-striped table-hover tc-table table-primary footable" data-page-size="50">
								<thead>
									<tr>
										<th class="center" data-sort-ignore="true">序號</th>
										<th data-toggle="true" data-sort-ignore="true">選單名稱</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">權限編號</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">顯示方式</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">連結網址</th>
										<th data-hide="phone,tablet" data-sort-ignore="true">指定顯示給</th>
										<th data-sort-ignore="true" class="col-medium center">動　 作</th>
									</tr>
								</thead>
								<tbody>
<?php 
	//管理員列表
	$msql->query("select * from {P}_base_admin");
	while($msql->next_record()){
		$aid=$msql->f('id');
		$auser=$msql->f('user');
		$aname=$msql->f('name');
		$alist[$aid] = $auser."-".$aname;
	}
							
	//選單開始
	$msql->query("select * from {P}_adminmenu where groupid='$groupid' order by xuhao");
	while($msql->next_record()){
		$id=$msql->f('id');
		$auth=$msql->f('auth');
		$authuser=$msql->f('authuser');
		$menu=$msql->f('menu');
		$url=$msql->f('url');
		$xuhao=$msql->f('xuhao');
		$ifshow=$msql->f('ifshow');
		
		$authusers= explode(",",$authuser);
		$authuserlist = "";
		foreach($alist AS $kk => $vv){
			if(in_array($kk, $authusers)){
				$authuserlist .= "<option value='".$kk."' selected='selected'>".$vv."</option>";
			}else{
				$authuserlist .= "<option value='".$kk."'>".$vv."</option>";
			}
		}
?> 
									<form id="form_<?php echo $id; ?>" method="get" action="index.php" name="colset_<?php echo $id; ?>" >
									<tr>
										<td class="center"><input type="text" class="form-control input-mini" name="xuhao" id="xuhao_<?php echo $id; ?>" value="<?php echo $xuhao; ?>"></td>
										<td><input type="text" class="form-control" name="menu" id="menu_<?php echo $id; ?>" value="<?php echo $menu; ?>"></td>
										<td><input type="text" class="form-control" name="auth" id="auth_<?php echo $id; ?>" value="<?php echo $auth; ?>"></td>
										<td>
											<select class="form-control" name="ifshow" id="ifshow_<?php echo $id; ?>">
												<option value="1" <?php echo seld($ifshow,'1'); ?>><?php echo $strShow; ?></option>
	          									<option value="0" <?php echo seld($ifshow,'0'); ?>><?php echo $strHidden; ?></option>
          									</select>
          								</td>
										<td><input type="text" class="form-control" name="url" id="url_<?php echo $id; ?>" value="<?php echo $url; ?>"></td>
										<td>
												<div class="form-group">
													<div class="col-sm-5">
														<select class="form-control mus" id="authuser_<?php echo $id; ?>" name="authuser" multiple>
															<?php echo $authuserlist; ?>
														</select>
													</div>
												</div>
										</td>
										<td class="col-medium center">
											<div class="btn-group btn-group-sm ">
												<a href="javascript:;" class="btn btn-inverse sub" title="<?php echo $strModify; ?>" onClick="submitMenu('<?php echo $id; ?>')"><i class="fa fa-pencil icon-only"></i></a>
												<a href="javascript:;" class="btn btn-danger" title="<?php echo $strDelete; ?>" onClick="window.location='index.php?step=del&groupid=<?php echo $groupid; ?>&id=<?php echo $id; ?>'"><i class="fa fa-times icon-only"></i></a>
											</div>	
											<input type="hidden" name="id" value="<?php echo $id; ?>" />
											<input type="hidden" name="groupid" id="groupid_<?php echo $id; ?>" value="<?php echo $groupid; ?>" />
									        <input type="hidden" name="step" value="modi" />
										</td>
									</tr>
									</form>
<?php
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
	<script src="js/menu.js"></script>
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>模選</li>');
			$('#pagetitle', window.parent.document).html('網站模組選單 <span class="sub-title" id="subtitle"><?php echo $groupname;?></span>');
			//呼叫左側功能選單
			$().getMenuGroup('<?php echo $groupid;?>');
		});
	</script>
	
	<script>
        $(document).ready(function() {
			$(".mus").select2({
				placeholder: "請選擇指定顯示的管理員",
				width: 375,
				allowClear: true
			});
			
			/*$("td").on("click",function () {
        		setTimeout(function () {
                     window.parent.doIframe();
                 }, 0);
        	});*/
		});
    </script>
	<script src="assets/js/plugins/iframeautoheight/iframeResizer.contentWindow.min.js"></script>
  </body>
</html>