<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
NeedAuth(0);
#---------------------------------------------#
$step=$_REQUEST["step"];
$groupid=$_REQUEST["groupid"];


if($step=="del"){
	$id=$_REQUEST["id"];
	$msql->query("select id from {P}_menu where  pid='$id'");
	if($msql->next_record()){
		err($strColNotice25,"","");
		exit;
	}
	

	$msql->query("delete from {P}_menu where id='$id'");
	$msql->query("delete from {P}_menu_translate where pid='$id'");
}


if($step=="modi"){
	$id=$_REQUEST["id"];
	$menu=htmlspecialchars($_REQUEST["menu"]);
	$xuhao=htmlspecialchars($_REQUEST["xuhao"]);
	$target=$_REQUEST["target"];
	$ifshow=$_REQUEST["ifshow"];
	$folder=htmlspecialchars($_REQUEST["folder"]);
	$url=htmlspecialchars($_REQUEST["url"]);
	$selcoltype=$_REQUEST["selcoltype"];
	
	$m_id=$_REQUEST["m_id"];
	$m_class=$_REQUEST["m_class"];
	
	switch($selcoltype){
		case "1" :
			$linktype="1";
		break;
		case "2" :
			$linktype="2";
		break;
		case "3" :
			$linktype="3";
		break;
		case "4" :
			$linktype="4";
		break;
		default :
			$linktype="0";
			$coltype=$selcoltype;
		break;
	
	}
	
	$msql->query("update {P}_menu set 
	menu='$menu',
	target='$target',
	xuhao='$xuhao',
	folder='$folder',
	url='$url',
	coltype='$coltype',
	linktype='$linktype',
	ifshow='$ifshow'
	where  id='$id'");
	
	
	//記錄多國翻譯資料
	$langlist = $_REQUEST['langlist'];
	if($langlist != ""){			
		$smenu = $_REQUEST['smenu'];
		$lans = explode(",",$langlist);
		foreach($lans AS $ks=>$vs){
			//擷取各語言資料並寫入
			$menus = htmlspecialchars($smenu[$vs]);
				//getupdate 資料若存在則更新，否則新增
				$msql->getupdate(
					"SELECT id FROM {P}_menu_translate WHERE pid='{$id}' AND langcode='{$vs}'",
					"UPDATE {P}_menu_translate SET 
					menu='{$menus}' WHERE pid='{$id}' AND langcode='{$vs}'",
					"INSERT INTO {P}_menu_translate SET 
					pid='{$id}',
					langcode='{$vs}',
					menu='{$menus}'"
				);
				
		}
	}//多國
}



//新增
if($step=="add"){
	$pid=htmlspecialchars($_REQUEST["pid"]);
	
	$msql->query("select max(xuhao) from {P}_menu where pid='$pid' and groupid='$groupid'");
	if($msql->next_record()){
		$newxuhao=$msql->f('max(xuhao)')+1;
	}


	$msql->query("insert into {P}_menu set 
	groupid='$groupid',
	pid='$pid',
	menu='$strColMenuName',
	target='_self',
	xuhao='$newxuhao',
	coltype='index',
	linktype='0',
	url='http://',
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
<?php

if($step=="chgname"){
	$groupname = $_REQUEST["chgname"];
	$msql->query("update {P}_menu_group set groupname='$groupname' where id='$groupid' ");
}

if($groupid==""){
	$msql->query("select * from {P}_menu_group limit 0,1");
}else{
	$msql->query("select * from {P}_menu_group where id='$groupid'");
}
	if($msql->next_record()){
		$groupid=$msql->f('id');
		$groupname=$msql->f('groupname');
		$moveable=$msql->f('moveable');
		if($moveable=="0"){
			$buttondis=" style='display:none' ";
		}
	}

?>
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
					<form id="addgroup" name="addgroup" method="post" action="" class="form-inline pull-left" role="form">
						<div class="form-group">
							<label class="sr-only"><?php echo $strGroupAddName; ?></label>
							<input type="text" class="form-control" name="groupname" placeholder="<?php echo $strGroupAddName; ?>">
						</div>
						<input type="hidden" name="act" value="addgroup" />
						<button type="submit" class="btn btn-primary btn-line"><i class="fa fa-plus"></i>新　增</button>
						<div class="pull-right">
							<input type="hidden" id="gid" value="<?php echo $groupid; ?>" />
						</div>
					</form>
	
					<form id="delgroup" method="post" action="" class="pull-right">
						<input type="hidden" name="groupid" value="<?php echo $groupid; ?>" />
						<input type="hidden" name="act" value="delgroup" />
						<input type="submit" name="Submit" value="<?php echo $strGroupDel; ?>" class="btn btn-inverse" <?php echo $buttondis; ?>  /> 
					</form>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="portlet">
			<div id="f-2" class="panel-collapse collapse in">
				
				<div class="portlet-body">
					<form class="form-inline clearfix" role="form" action="index.php">

						<button type="button" class="btn btn-success" onClick="window.location='index.php?step=add&groupid=<?php echo $groupid; ?>&pid=0'"><i class="fa fa-pencil-square"></i> <?php echo $strColAdd; ?></button>

						<div class="pull-right">
							<div class="form-group">
								<label class="sr-only"><?php echo $strGroupAddName; ?></label>
								<input type="text" class="form-control" placeholder="<?php echo $strGroupAddName; ?>" name="chgname" value="<?php echo $groupname;?>">
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
										<th class="center" data-sort-ignore="true"><?php echo $strXuhao; ?></th>
										<th data-sort-ignore="true"><?php echo $strColMenuName; ?></th>
										<th data-hide="phone,tablet" data-sort-ignore="true"><?php echo $strColOpen; ?></th>
										<th data-hide="phone,tablet" data-sort-ignore="true"><?php echo $strColShow; ?></th>
										<th data-hide="phone,tablet" data-sort-ignore="true"><?php echo $strColTo; ?></th>
										<th data-hide="phone,tablet" data-sort-ignore="true">&nbsp;</th>
										<th data-sort-ignore="true" class="col-medium center">動　 作</th>
										<th data-hide="phone,tablet" class="col-medium center">新增二級選單</th>
									</tr>
								</thead>
								<tbody>
  <?php 
$msql->query("select * from {P}_menu where groupid='$groupid' and pid='0' order by xuhao");
while($msql->next_record()){
$id=$msql->f('id');
$pid=$msql->f('pid');
$menu=$msql->f('menu');
$linktype=$msql->f('linktype');
$coltype=$msql->f('coltype');
$folder=$msql->f('folder');
$url=$msql->f('url');
$xuhao=$msql->f('xuhao');
$target=$msql->f('target');
$ifshow=$msql->f('ifshow');
$m_id=$msql->f('m_id');
$m_class=$msql->f('m_class');
?> 
									<form id="form_<?php echo $id; ?>" method="get" action="index.php" name="colset_<?php echo $id; ?>" >
										<tr>
										<td class="center"><input type="text" class="form-control input-mini" name="xuhao" id="xuhao_<?php echo $id; ?>" value="<?php echo $xuhao; ?>"></td>
										<td>
											<div class="form-group">
												<label class="row col-sm-3 control-label text-right">預設：</label>
												<div class="row col-sm-8">
													<input type="text" class="form-control" name="menu" id="menu_<?php echo $id; ?>" value="<?php echo $menu; ?>">
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
													$langs = $tsql->getone( "SELECT * FROM {P}_menu_translate WHERE pid='{$id}' AND langcode='{$langcode}'" );
											?>
												<div class="form-group">
													<label class="row col-sm-3 control-label text-right"><?php echo $ltitle; ?>：</label>
													<div class="row col-sm-8">
														<input type="text" class="form-control" name="smenu[<?php echo $langcode; ?>]" id="smenu_<?php echo $langs['id']; ?>" value="<?php echo $langs['menu']; ?>">
													</div>
													<div class="clearfix"></div>
												</div>
											<?php
												}
											?>
												<div>
											</div>
										</td>
										<td>
	    									<select class="form-control" name="target" id="target_<?php echo $id; ?>" <?php echo switchDis(120); ?> >
												<option value="_self" <?php echo seld($target,'_self'); ?>><?php echo $strSelf; ?></option>
												<option value="_blank" <?php echo seld($target,'_blank'); ?>><?php echo $strBlank; ?></option>
											</select>
          								</td>
										<td>
	    									<select class="form-control" name="ifshow" id="ifshow_<?php echo $id; ?>" <?php echo switchDis(120); ?> >
												<option value="1" <?php echo seld($ifshow,'1'); ?>><?php echo $strShow; ?></option>
          										<option value="0" <?php echo seld($ifshow,'0'); ?>><?php echo $strHidden; ?></option>
											</select>
										</td>
										<td>
											<select id="selcoltype_<?php echo $id; ?>" name="selcoltype" class="form-control selcoltype"  <?php echo switchDis(120); ?>>
											<?php
												$fsql->query("select * from {P}_base_coltype where ifchannel='1'");
												while($fsql->next_record()){
													$scoltype=$fsql->f('coltype');
													$colname=$fsql->f('colname');
													if($linktype=="0" && $coltype==$scoltype){
														echo "<option value='".$scoltype."' selected>".$colname."</option>";
													}else{
														echo "<option value='".$scoltype."'>".$colname."</option>";
													}

												}
												if($linktype=="1"){
													echo "<option value='1' selected>".$strColInner."</option>";
													echo "<option value='2'>".$strColDiy."</option>";
													echo "<option value='3'>模組選單(模組名稱,id)</option>";
													echo "<option value='4'>模組選單(模組名稱,id)</option>";
												}elseif($linktype=="2"){
													echo "<option value='1'>".$strColInner."</option>";
													echo "<option value='2' selected>".$strColDiy."</option>";
													echo "<option value='3'>模組選單(模組名稱,id)</option>";
													echo "<option value='4'>模組選單(模組名稱,id)</option>";
												}elseif($linktype=="3"){
													echo "<option value='1'>".$strColInner."</option>";
													echo "<option value='2'>".$strColDiy."</option>";
													echo "<option value='3' selected>模組選單(模組名稱,id)</option>";
													echo "<option value='4'>模組選單(模組名稱,id)</option>";
												}elseif($linktype=="4"){
													echo "<option value='1'>".$strColInner."</option>";
													echo "<option value='2'>".$strColDiy."</option>";
													echo "<option value='3'>模組選單(模組名稱,id)</option>";
													echo "<option value='4' selected>模組選單(模組名稱,id)</option>";
												}else{
													echo "<option value='1'>".$strColInner."</option>";
													echo "<option value='2'>".$strColDiy."</option>";
													echo "<option value='3'>模組選單(模組名稱,id)</option>";
													echo "<option value='4'>模組選單(模組名稱,id)</option>";
												}
											?>
											</select>
										</td>
										<td>
											<input name="url" type="text" id="url_selcoltype_<?php echo $id; ?>" value="<?php echo $url; ?>" style="display:none;margin-right:10px;width: 100%;"  <?php echo switchDis(120); ?> />
											<input name="folder" type="text" id="folder_selcoltype_<?php echo $id; ?>" value="<?php echo $folder; ?>" style="display:none;margin-right:10px;width: 100%;"  <?php echo switchDis(120); ?> />
										</td>
										<td class="col-medium center">
											<div class="btn-group btn-group-sm ">
												<button type="button" class="btn btn-inverse sub" title="<?php echo $strModify; ?>" onClick="javascript:submitMenu('<?php echo $id; ?>')"><i class="fa fa-pencil icon-only"></i></button>
												<button type="button" class="btn btn-danger" title="<?php echo $strDelete; ?>" onClick="window.location='index.php?step=del&groupid=<?php echo $groupid; ?>&id=<?php echo $id; ?>'"><i class="fa fa-times icon-only"></i></button>
											</div>
											<input type="hidden" name="id" value="<?php echo $id; ?>" />
											<input type="hidden" name="groupid" id="groupid_<?php echo $id; ?>" value="<?php echo $groupid; ?>" />
									        <input type="hidden" name="step" value="modi" />
									        <input type="hidden" name="langlist" value="<?php echo $langlist; ?>" />
										</td>
										<td>
											<div class="btn-group btn-group-sm ">
												<button type="button" class="btn btn-primary btn-line" onClick="window.location='index.php?step=add&groupid=<?php echo $groupid; ?>&pid=<?php echo $id; ?>'"><i class="fa fa-plus"></i>新增</button>
											</div>	
											<div class="portlet-widgets pull-right" style="margin-right:10px;">
												<a data-toggle="collapse" data-parent="#accordion" href="#s_<?php echo $id; ?>"><i class="fa fa-chevron-down"></i></a>
											</div>
										</td>
									</tr>
									</form>
									<tr id="s_<?php echo $id; ?>"  class="panel-collapse collapse in"><td></td><td colspan="7" class="row">
<table class="table table-striped">
<?php
$fsql->query("select * from {P}_menu where groupid='$groupid' and pid='$id' order by xuhao");
while($fsql->next_record()){
$subid=$fsql->f('id');
$subpid=$fsql->f('pid');
$submenu=$fsql->f('menu');
$sublinktype=$fsql->f('linktype');
$subcoltype=$fsql->f('coltype');
$subfolder=$fsql->f('folder');
$suburl=$fsql->f('url');
$subxuhao=$fsql->f('xuhao');
$subtarget=$fsql->f('target');
$subifshow=$fsql->f('ifshow');
$subm_id=$fsql->f('m_id');
$subm_class=$fsql->f('m_class');


$newsubxuhao=0;

?>
<form id="form_<?php echo $subid; ?>" method="get" action="index.php" name="colset" >
<tr>
	<td class="center">
		<input type="text" name="xuhao" value="<?php echo $subxuhao; ?>" id="xuhao_<?php echo $subid; ?>" class="form-control input-mini"  <?php echo switchDis(120); ?> />
	</td>
	<td>
		<div class="form-group">
			<label class="row col-sm-3 control-label text-right">預設：</label>
			<div class="row col-sm-8">
				<input type="text" name="menu"  value="<?php echo $submenu; ?>" id="menu_<?php echo $subid; ?>" class="form-control" <?php echo switchDis(120); ?> />
			</div>
			<div class="portlet-widgets pull-right" style="margin-right:10px;">
				<a data-toggle="collapse" data-parent="#accordion_<?php echo $subid; ?>" href="#l_<?php echo $subid; ?>"><i class="fa fa-chevron-up"> 多語言</i></a>
			</div>
			<div class="clearfix"></div>
		</div>
		<div id="l_<?php echo $subid; ?>" class="panel-collapse collapse">
		<!-- 擷取語言表 -->
		<?php
			$tsql->query( "SELECT * FROM {P}_base_language WHERE ifshow='1' AND ifdefault='0' ORDER BY xuhao asc" );
			while ( $tsql->next_record( ) )
			{
				$lid = $tsql->f( "id" );
				$ltitle = $tsql->f( "title" );
				$langcode = $tsql->f( "langcode" );
				$src = ROOTPATH.$tsql->f( "src" );
				$langlist .= $langlist? ",".$langcode:$langcode;
				//依表擷取語言檔內容
				$langs = $wsql->getone( "SELECT * FROM {P}_menu_translate WHERE pid='{$subid}' AND langcode='{$langcode}'" );
		?>
			<div class="form-group">
				<label class="row col-sm-3 control-label text-right"><?php echo $ltitle; ?>：</label>
				<div class="row col-sm-8">
					<input type="text" class="form-control" name="smenu[<?php echo $langcode; ?>]" id="smenu_<?php echo $langs['id']; ?>" value="<?php echo $langs['menu']; ?>">
				</div>
				<div class="clearfix"></div>
			</div>
		<?php
			}
		?>
			<div>
		</div>
	</td>
	<td>
      <select name="target" class="form-control" id="target_<?php echo $subid; ?>" <?php echo switchDis(120); ?>>
          <option value="_self" <?php echo seld($subtarget,'_self'); ?>><?php echo $strSelf; ?></option>
          <option value="_blank" <?php echo seld($subtarget,'_blank'); ?>><?php echo $strBlank; ?></option>
        </select>
	</td>
	<td>
        <select name="ifshow" class="form-control" id="ifshow_<?php echo $subid; ?>" <?php echo switchDis(120); ?>>
          <option value="1" <?php echo seld($subifshow,'1'); ?>><?php echo $strShow; ?></option>
          <option value="0" <?php echo seld($subifshow,'0'); ?>><?php echo $strHidden; ?></option>
        </select>
	</td>
	<td>
	  <select id="selcoltype_<?php echo $subid; ?>" name="selcoltype" class="selcoltype form-control"  <?php echo switchDis(120); ?>>
		<?php
			$tsql->query("select * from {P}_base_coltype where ifchannel='1'");
			while($tsql->next_record()){
				$scoltype=$tsql->f('coltype');
				$colname=$tsql->f('colname');
				if($sublinktype=="0" && $subcoltype==$scoltype){
					echo "<option value='".$scoltype."' selected>".$colname."</option>";
				}else{
					echo "<option value='".$scoltype."'>".$colname."</option>";
				}
			}
			if($sublinktype=="1"){
				 echo "<option value='1' selected>".$strColInner."</option>";
				 echo "<option value='2'>".$strColDiy."</option>";
				 echo "<option value='3'>模組選單(模組名稱,id)</option>";
			}elseif($sublinktype=="2"){
				 echo "<option value='1'>".$strColInner."</option>";
				 echo "<option value='2' selected>".$strColDiy."</option>";
				 echo "<option value='3'>模組選單(模組名稱,id)</option>";
			}elseif($sublinktype=="3"){
				 echo "<option value='1'>".$strColInner."</option>";
				 echo "<option value='2'>".$strColDiy."</option>";
				 echo "<option value='3' selected>模組選單(模組名稱,id)</option>";
			}else{
				echo "<option value='1'>".$strColInner."</option>";
				echo "<option value='2'>".$strColDiy."</option>";
				echo "<option value='3'>模組選單(模組名稱,id)</option>";
			}
		?>
      </select>
	</td>
	<td>
	  <input name="url" type="text" class="form-control" id="url_selcoltype_<?php echo $subid; ?>" value="<?php echo $suburl; ?>" size="22" style="display:none;margin-right:10px"  <?php echo switchDis(120); ?> />
	  <input name="folder" type="text" class="form-control" id="folder_selcoltype_<?php echo $subid; ?>" value="<?php echo $subfolder; ?>" size="22" style="display:none;margin-right:10px"  <?php echo switchDis(120); ?> />
	</td>
	<td>
		<div class="btn-group btn-group-sm ">
			<button type="button" class="btn btn-inverse sub" title="<?php echo $strModify; ?>" onClick="javascript:submitMenu('<?php echo $subid; ?>')"><i class="fa fa-pencil icon-only"></i></button>
			<button type="button" class="btn btn-danger" title="<?php echo $strDelete; ?>" onClick="window.location='index.php?step=del&groupid=<?php echo $groupid; ?>&id=<?php echo $subid; ?>'"><i class="fa fa-times icon-only"></i></button>
		</div>
		<input type="hidden" name="id" value="<?php echo $subid; ?>" />
		<input type="hidden" name="groupid" id="groupid_<?php echo $subid; ?>" value="<?php echo $groupid; ?>" />
		<input type="hidden" name="step" value="modi" />
		<input type="hidden" name="langlist" value="<?php echo $langlist; ?>" />
	</td>
</tr>
      </form>

<?php
}
//二級選單結束

?>
</table>	
</td></tr>
<?php
}
 //一級選單結束
?>
</tbody>
	
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
	<script src="js/menu.js?1"></script>
		
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>選單</li>');
			$('#pagetitle', window.parent.document).html('網站選單管理 <span class="sub-title" id="subtitle"><?php echo $groupname;?></span>');
			//呼叫左側功能選單
			$().getMenuGroup('<?php echo $groupid;?>');
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