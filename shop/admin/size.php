<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
include("func/upload.inc.php");
NeedAuth(313);

$strLinkSys="連結廣告管理";
$strLinkNTC1="請填寫連結網址";
$strLinkNTC2="請填寫連結名稱";
$strLinkNTC3="您選擇的是圖片連結,必須上傳圖片";
$strLinkNTC4="對不起，圖片不能大於100KB";
$strLinkNTC5="連結添加成功";
$strLinkAdd="添加尺寸對照內容";

$strGroupSel="尺寸表組：";
$strGroupDel="刪除尺寸表";
$strGroupAddName="請輸入尺寸表名稱";
$strGroupAdd="新增尺寸表";
$strGroupNTC2="確定刪除目前尺寸表嗎?";
#---------------------------------------------#

$step=$_REQUEST["step"];
$id=$_REQUEST["id"];
$groupid=$_REQUEST["groupid"];


if($step=="addgroup" && $_REQUEST["groupname"]!=""){
	$groupname=$_REQUEST["groupname"];
	$msql->query("insert into {P}_shop_sizegroup set
		`groupname`='$groupname',
		`xuhao`='1',
		`moveable`='1'
	");
	$groupid=$msql->instid();
	
	echo "<script>self.location='size.php?groupid=".$groupid."'</script>";

}

if($step=="delgroup" && $_REQUEST["groupid"]!="" && $_REQUEST["groupid"]!="0"){

	$msql->query("select * from {P}_shop_size where  groupid='".$_REQUEST["groupid"]."' ");
	while($msql->next_record()){
		$lbid=$msql->f('id');
		$oldsrc=$msql->f('src');
		if(file_exists(ROOTPATH.$oldsrc) && $oldsrc!=""){
			unlink(ROOTPATH.$oldsrc);
		}
		
	}
	$fsql->query("delete from {P}_shop_size where groupid='".$_REQUEST["groupid"]."' ");
	$msql->query ("delete from {P}_shop_sizegroup where id='".$_REQUEST["groupid"]."'");

	echo "<script>self.location='size.php'</script>";

}


if($groupid==""){
	$msql->query("select * from {P}_shop_sizegroup limit 0,1");
}else{
	$msql->query("select * from {P}_shop_sizegroup where id='$groupid'");
}
	if($msql->next_record()){
		$groupid=$msql->f('id');
		$moveable=$msql->f('moveable');
		if($moveable=="0"){
			$buttondis=" style='display:none' ";
		}
	}
	 

$tall=$_POST["tall"];
$weight=$_POST["weight"];
$sizetype=$_POST["sizetype"];
$waist=$_POST["waist"];
$chest=$_POST["chest"];
$hips=$_POST["hips"];

if($step=="add"){

	if($tall==""){
		err("請輸入身高","","");
	}
	if($weight==""){
		err("請輸入體重","","");
	}


	$msql->query("insert into {P}_shop_size set
	groupid='$groupid',
	tall='$tall',
	weight='$weight',
	sizetype='$sizetype',
	chest='$chest',
	waist='$waist',
	hips='$hips'
	");

	//echo "<script>self.location='size.php?groupid=".$groupid."'</script>";
	/*產生文件檔*/
		$data =  "<?php\r\n";
		$fsql->query("select * from {P}_shop_size where groupid='$groupid' order by tall asc,weight asc");
		while($fsql->next_record()){
			list($tall_a, $tall_b) = explode("-",$fsql->f( "tall" ));
			list($weight_a, $weight_b) = explode("-",$fsql->f( "weight" ));
			list($chest_a, $chest_b) = explode("-",$fsql->f( "chest" ));
			list($waist_a, $waist_b) = explode("-",$fsql->f( "waist" ));
			list($hips_a, $hips_b) = explode("-",$fsql->f( "hips" ));
			$size = $fsql->f( "sizetype" );
			
			for($o=$tall_a; $o<=$tall_b; $o++){
				for($t=$weight_a; $t<=$weight_b; $t++){
					$showsize[$o][$t] = $showsize[$o][$t] && stripos($showsize[$o][$t],"/")===FALSE && $showsize[$o][$t]!=$size? $showsize[$o][$t]."/".$size:$size;//身高體重
					
					$data = str_replace("\r\n\$showsize['".$o."']['".$t."']='".$lastsize."';","",$data);
					$data .= "\r\n\$showsize['".$o."']['".$t."']='".$showsize[$o][$t]."';";
					
					if(!$showOnesize || $showOnesize ==""){
						$showOnesize = $size;//最小型號
						$data .= "\r\n\$showOnesize = '".$showOnesize."';";
					}
				}
			}
			
			if($chest_a){
				for($o=$chest_a; $o<=$chest_b; $o++){
					if( stripos($showchest[$o],"/".$size) === FALSE){
						$data .= $showchest[$o]? "\r\n\$showchest['".$o."'] = '".$showchest[$o]."/".$size."';" : "\r\n\$showchest['".$o."'] = '/".$size."';";
						$showchest[$o] .= "/".$size;
					}
				}
			}
			if($waist_a){
				for($o=$waist_a; $o<=$waist_b; $o++){
					if( stripos($showwaist[$o],"/".$size) === FALSE){
						$data .= $showwaist[$o]? "\r\n\$showwaist['".$o."'] = '".$showwaist[$o]."/".$size."';" : "\r\n\$showwaist['".$o."'] = '/".$size."';";
						$showwaist[$o] .= "/".$size;
					}
				}
			}
			if($hips_a){
				for($o=$hips_a; $o<=$hips_b; $o++){
					if( stripos($showhips[$o],"/".$size) === FALSE){
						$data .= $showhips[$o]? "\r\n\$showhips['".$o."'] = '".$showhips[$o]."/".$size."';" : "\r\n\$showhips['".$o."'] = '/".$size."';";
						$showhips[$o] .= "/".$size;
					}
				}
			}
			
			$lastsize = $size;
		}
		
		$data .=  "\r\n?>";
		filesave("../cache/".$groupid.".php",$data,'rb+');
	/*產生文件檔*/
}



if($step=="modify"){

	if($tall==""){
		err("請輸入身高","","");
	}
	if($weight==""){
		err("請輸入體重","","");
	}
	$msql->query("update {P}_shop_size set 
		tall='$tall',
		weight='$weight',
		sizetype='$sizetype',
		chest='$chest',
		waist='$waist',
		hips='$hips'
		 where id='$id' ");
		
	/*產生文件檔*/
		$data =  "<?php\r\n";
		$fsql->query("select * from {P}_shop_size where groupid='$groupid' order by tall asc,weight asc");
		while($fsql->next_record()){
			list($tall_a, $tall_b) = explode("-",$fsql->f( "tall" ));
			list($weight_a, $weight_b) = explode("-",$fsql->f( "weight" ));
			list($chest_a, $chest_b) = explode("-",$fsql->f( "chest" ));
			list($waist_a, $waist_b) = explode("-",$fsql->f( "waist" ));
			list($hips_a, $hips_b) = explode("-",$fsql->f( "hips" ));
			$size = $fsql->f( "sizetype" );
			
			for($o=$tall_a; $o<=$tall_b; $o++){
				for($t=$weight_a; $t<=$weight_b; $t++){
					$showsize[$o][$t] = $showsize[$o][$t] && stripos($showsize[$o][$t],"/")===FALSE && $showsize[$o][$t]!=$size? $showsize[$o][$t]."/".$size:$size;//身高體重
					$data = str_replace("\r\n\$showsize['".$o."']['".$t."']='".$lastsize."';","",$data);
					$data .= "\r\n\$showsize['".$o."']['".$t."']='".$showsize[$o][$t]."';";
					
					if(!$showOnesize || $showOnesize ==""){
						$showOnesize = $size;//最小型號
						$data .= "\r\n\$showOnesize = '".$showOnesize."';";
					}
				}
			}
			
			if($chest_a){
				for($o=$chest_a; $o<=$chest_b; $o++){
					if( stripos($showchest[$o],"/".$size) === FALSE){
						$data .= $showchest[$o]? "\r\n\$showchest['".$o."'] = '".$showchest[$o]."/".$size."';" : "\r\n\$showchest['".$o."'] = '/".$size."';";
						$showchest[$o] .= "/".$size;
					}
				}
			}
			if($waist_a){
				for($o=$waist_a; $o<=$waist_b; $o++){
					if( stripos($showwaist[$o],"/".$size) === FALSE){
						$data .= $showwaist[$o]? "\r\n\$showwaist['".$o."'] = '".$showwaist[$o]."/".$size."';" : "\r\n\$showwaist['".$o."'] = '/".$size."';";
						$showwaist[$o] .= "/".$size;
					}
				}
			}
			if($hips_a){
				for($o=$hips_a; $o<=$hips_b; $o++){
					if( stripos($showhips[$o],"/".$size) === FALSE){
						$data .= $showhips[$o]? "\r\n\$showhips['".$o."'] = '".$showhips[$o]."/".$size."';" : "\r\n\$showhips['".$o."'] = '/".$size."';";
						$showhips[$o] .= "/".$size;
					}
				}
			}
			
			$lastsize = $size;
		}
		
		$data .=  "\r\n?>";
		filesave("../cache/".$groupid.".php",$data,'rb+');
	/*產生文件檔*/
}


if($step=="del"){
	$msql->query("delete from {P}_shop_size where id='$id'");
	//刪除 END
}

if($step=="chgname"){
	$groupname = $_REQUEST["chgname"];
	$msql->query("update {P}_shop_sizegroup set groupname='$groupname' where id='$groupid' ");
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
			<div id="f-1" class="panel-collapse collapse in">
				<div class="portlet-body">
					<form id="selgroup" name="selgroup" method="get" action="size.php" class="form-inline pull-left" role="form">
						<div class="form-group">
							<select name="pp" class="form-control" onchange="self.location=this.options[this.selectedIndex].value">
					          <?php
								$msql->query("select * from {P}_shop_sizegroup");
								while($msql->next_record()){
									$lgroupid=$msql->f('id');
									$groupname=$msql->f('groupname');
										
									if($groupid==$lgroupid){
										echo "<option value='size.php?groupid=".$lgroupid."' selected>".$strGroupSel.$groupname."</option>";
										$thisgroupname = $groupname;
									}else{
										echo "<option value='size.php?groupid=".$lgroupid."'>".$strGroupSel.$groupname."</option>";
									}
											
								}
							 ?>
						        </select>
						        <button type="button" class="btn btn-primary" <?php echo $buttondis; ?> onClick="cm('<?php echo $groupid; ?>')"><i class="fa fa-trash"></i><?php echo $strGroupDel; ?></button>
								<input type="text" name="chgname" value="<?php echo $thisgroupname;?>" class="form-control" /> <input type="submit" value="<?php echo $strModify; ?>" class="btn btn-warning" />
								<input type="hidden" name="step" value="chgname" />
								<input type="hidden" name="groupid" value="<?php echo $groupid; ?>" />
						</div>
					</form>
	
					<div class="pull-right">
						<form name="addform" method="get" action="size.php" class="form-horizontal" onSubmit="return checkform(this)">
						<input type="hidden" name="step" value="addgroup" />						
						<div class="fleft" style="margin: 0 5px;">
							<input name="groupname" type="text" class="form-control" placeholder="<?php echo $strGroupAddName; ?>" value="" />
						</div>
						<div class="fleft">
							<button type="submit" class="btn btn-primary btn-line"><i class="fa fa-plus"></i><?php echo $strGroupAdd; ?></button>
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
		<div class="portlet">
			<div class="portlet-heading dark">
				<div class="portlet-title">
					<h4><?php echo $strLinkAdd; ?></h4>
				</div>
				<div class="portlet-widgets">
					<a data-toggle="collapse" data-parent="#accordion" href="#f-2"><i class="fa fa-chevron-down"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div id="f-2" class="panel-collapse collapse in">
				<div class="portlet-body">
					<form method="post" action="size.php" enctype="multipart/form-data" onSubmit="return checkMainform(this)" class="form-inline" role="form" >
						<div class="form-group">
							<label class="control-label"><font color="#FF3300">* </font>身高：</label>
							<input type="text" class="form-control" name="tall" placeholder="輸入範圍，例：165-169">
						</div>
						<div class="form-group">
							<label class="control-label"><font color="#FF3300">* </font>體重：</label>
							<input type="text" class="form-control input-large" name="weight" value="" placeholder="輸入範圍，例：53-59" >
						</div>
						<div class="form-group">
							<label class="control-label"><font color="#FF3300"></font>型號：</label>
							<select name="sizetype" class="form-control select">
								<option value="xs">XS</option>
								<option value="s">S</option>
								<option value="m">M</option>
								<option value="l">L</option>
								<option value="xl">XL</option>
								<option value="xxl">XXL</option>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label"><font color="#FF3300">  </font>胸圍：</label>
							<input type="text" class="form-control" name="chest" placeholder="輸入範圍，例：28-30" >
						</div>
						<div class="form-group">
							<label class="control-label"><font color="#FF3300">  </font>腰圍：</label>
							<input type="text" class="form-control" name="waist" placeholder="輸入範圍，例：28-30" >
						</div>
						<div class="form-group">
							<label class="control-label"><font color="#FF3300">  </font>臀圍：</label>
							<input type="text" class="form-control" name="hips" placeholder="輸入範圍，例：30-33" >
						</div>
						<div class="form-group">
							<input type="submit" name="Submit" value="<?php echo $strAdd; ?>"  class="btn btn-primary" />
							<input type="hidden" name="step" value="add" />
							<input type="hidden" name="groupid" value="<?php echo $groupid; ?>" />
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
			<div id="f-2" class="panel-collapse collapse in">
				<div class="portlet-body no-padding">
					<div id="basic" class="panel-collapse collapse in">
						<div class="portlet-body no-padding">
							<table class="table table-bordered table-striped table-hover tc-table table-primary footable" data-page-size="50">
								<thead>
									<tr>
										<th data-sort-ignore="true">身高</th>
										<th data-sort-ignore="true">體重</th>
										<th data-sort-ignore="true">型號</th>
										<th data-sort-ignore="true">胸圍</th>
										<th data-sort-ignore="true">腰圍</th>
										<th data-sort-ignore="true">臀圍</th>
										<th data-sort-ignore="true" class="col-small center"><?php echo $strModify; ?></th>
										<th data-hide="phone,tablet" class="col-small center"><?php echo $strDelete; ?></th>
									</tr>
								</thead>
								<tbody>
<?php 
$msql->query("select * from {P}_shop_size where groupid='$groupid' order by tall asc,id asc");
while($msql->next_record()){
	$id=$msql->f('id');
	$gtall=$msql->f('tall');
	$gweight=$msql->f('weight');
	$gsizetype=$msql->f('sizetype');
	$gchest=$msql->f('chest');
	$gwaist=$msql->f('waist');
	$ghips=$msql->f('hips');
?>
	<form action="size.php" method="post" enctype="multipart/form-data" >
		<tr>
			<td>
				<div class="form-group">
					<input type="text" name="tall" value="<?php echo $gtall; ?>" class="form-control">
				</div>
			</td>
			<td>
				<div class="form-group">
					<input type="text" name="weight" value="<?php echo $gweight; ?>" class="form-control">
				</div>
			</td>
			<td>
				<div class="form-group">
					<select name="sizetype" class="form-control select">
						<option value="xs" <?php echo seld($gsizetype,"xs");?>>XS</option>
						<option value="s" <?php echo seld($gsizetype,"s");?>>S</option>
						<option value="m" <?php echo seld($gsizetype,"m");?>>M</option>
						<option value="l" <?php echo seld($gsizetype,"l");?>>L</option>
						<option value="xl" <?php echo seld($gsizetype,"xl");?>>XL</option>
						<option value="xxl" <?php echo seld($gsizetype,"xxl");?>>XXL</option>
					</select>
				</div>
			</td>
			<td>
				<div class="form-group">
					<input type="text" name="chest" value="<?php echo $gchest; ?>" class="form-control">
				</div>
			</td>
			<td>
				<div class="form-group">
					<input type="text" name="waist" value="<?php echo $gwaist; ?>" class="form-control">
				</div>
			</td>
			<td>
				<div class="form-group">
					<input type="text" name="hips" value="<?php echo $ghips; ?>" class="form-control">
				</div>
			</td>
			<td class="col-small center">
				<div class="form-group">
					<input type="hidden" name="step" value="modify">
		            <input type="hidden" name="groupid" value="<?php echo $groupid; ?>" />
		            <input type="hidden" name="id" value="<?php echo $id; ?>" />
					<input type="hidden" name="langlist" value="<?php echo $langlist; ?>" />
					<button type="submit" class="btn btn-inverse"><i class="fa fa-pencil icon-only"></i></button>
				</div>
			</td>
			<td class="col-small center">
				<div class="form-group">
					<button type="button" class="btn btn-danger" onClick="self.location='size.php?step=del&groupid=<?php echo $groupid; ?>&id=<?php echo $id; ?>'"><i class="fa fa-times icon-only"></i></button>
				</div>
			</td>
		</tr>
	</form>
<?php
}//end while
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
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>購物</li>');
			$('#pagetitle', window.parent.document).html('尺寸建議表管理 <span class="sub-title" id="subtitle"><?php echo $strSetMenu8; ?></span>');
			//呼叫左側功能選單
			$().getMenuGroup('shop');
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
			
			$('.MySpinner').spinner();

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
	<script>

		function cm(nn){
			$().confirmwindow("<?php echo $strGroupNTC2; ?>", function(result) {
				window.location='size.php?step=delgroup&groupid='+nn;
			});
				return false;
		}

		function checkform(theform){
			if(theform.groupname.value.length < 1 || theform.groupname.value=='<?php echo $strAdvsGroupAddName; ?>'){
			    $().alertwindow("<?php echo $strAdvsGroupAddName; ?>","");
			    theform.groupname.focus();
			    return false;
			}  
			return true;
		}  
		
		function checkMainform(theform){
		  	if(theform.name.value.length < 1){
		    	$().alertwindow("<?php echo $strLinkNTC2; ?>","");
		    	theform.name.focus();
		    	return false;
			}  
			if(theform.url.value.length < 1){
		    	$().alertwindow("<?php echo $strLinkNTC1; ?>","");
		    	theform.url.focus();
		    	return false;
			}  
			return true;
		}
	</script>
</body>
</html>