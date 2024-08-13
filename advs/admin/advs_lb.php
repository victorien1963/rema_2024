<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
include("func/upload.inc.php");
needauth( 0 );
#---------------------------------------------#

$groupid=$_REQUEST["groupid"];
$step=$_REQUEST["step"];
if($step=="addgroup" && $_REQUEST["groupname"]!=""){
	$groupname=$_REQUEST["groupname"];
	$msql->query("insert into {P}_advs_lbgroup set
		`groupname`='$groupname',
		`xuhao`='1',
		`moveable`='1'
	");
	$groupid=$msql->instid();
	
	echo "<script>self.location='advs_lb.php?groupid=".$groupid."'</script>";

}

if($step=="delgroup" && $_REQUEST["groupid"]!="" && $_REQUEST["groupid"]!="0"){

	$msql->query("select * from {P}_advs_lb where  groupid='".$_REQUEST["groupid"]."' ");
	while($msql->next_record()){
		$lbid=$msql->f('id');
		$oldsrc=$msql->f('src');
		$oldsrc1=$msql->f('src1');
		if(file_exists(ROOTPATH.$oldsrc) && $oldsrc!=""){
			unlink(ROOTPATH.$oldsrc);
		}
		if(file_exists(ROOTPATH.$oldsrc1) && $oldsrc1!=""){
			unlink(ROOTPATH.$oldsrc1);
		}
		
	}
	$fsql->query("delete from {P}_advs_lb where groupid='".$_REQUEST["groupid"]."' ");
	$msql->query ("delete from {P}_advs_lbgroup where id='".$_REQUEST["groupid"]."'");

	echo "<script>self.location='advs_lb.php'</script>";

}


if($groupid==""){
	$msql->query("select * from {P}_advs_lbgroup limit 0,1");
}else{
	$msql->query("select * from {P}_advs_lbgroup where id='$groupid'");
}
	if($msql->next_record()){
		$groupid=$msql->f('id');
		$moveable=$msql->f('moveable');
		if($moveable=="0"){
			$buttondis=" style='display:none' ";
		}
	}
	
$id=$_REQUEST["id"];

if($step=="del"){
	$msql->query("select * from {P}_advs_lb where  id='$id'");
	if($msql->next_record()){
		$oldsrc=$msql->f('src');
		$oldsrc1=$msql->f('src1');
	}
	if(file_exists(ROOTPATH.$oldsrc) && $oldsrc!=""){
		unlink(ROOTPATH.$oldsrc);
	}
	if(file_exists(ROOTPATH.$oldsrc1) && $oldsrc1!=""){
		unlink(ROOTPATH.$oldsrc1);
	}
	$msql->query("delete from {P}_advs_lb where id='$id'");
	//刪除多語言
	$msql->query("select src from {P}_advs_lb_translate where pid='$id'");
	while($msql->next_record()){
		$src=$msql->f('src');
		if(file_exists(ROOTPATH.$src) && $src!=""){
			unlink(ROOTPATH.$src);
		}
	}
	$msql->query("delete from {P}_advs_lb_translate where pid='$id'");
	//刪除 END
}

if($step=="modify"){

	$title=$_POST["title"];
	$memo=$_POST["memo"];
	$pic=$_FILES["jpg"];
	$spic=$_FILES["suo"];
	$url=$_POST["url"];
	$xuhao=$_POST["xuhao"];
	$type_name=$_POST["type_name"];
	$type_link=$_POST["type_link"];
	$position=$_POST["position"];
	$header_color=$_POST["header_color"];

	$msql->query("update {P}_advs_lb set title='$title',memo='{$memo}',url='$url',xuhao='$xuhao',type_name='$type_name',type_link='$type_link', position='$position', header_color='$header_color' where id='$id'");

	if($pic["size"]>0){
		
		$nowdate=date("Ymd",time());
		$picpath="../pics/".$nowdate;
		@mkdir($picpath,0777);
		$uppath="advs/pics/".$nowdate;

		$arr=NewUploadImage($pic["tmp_name"],$pic["type"],$pic["size"],$uppath);
		$src=$arr[3];

		$msql->query("select * from {P}_advs_lb where  id='$id'");
		if($msql->next_record()){
			$oldsrc=$msql->f('src');
		}
		if(file_exists(ROOTPATH.$oldsrc) && $oldsrc!=""){
			unlink(ROOTPATH.$oldsrc);
		}
		$msql->query("update {P}_advs_lb set src='$src' where id='$id'");

	}
	
	if($spic["size"]>0){
		
		$nowdate=date("Ymd",time());
		$picpath="../pics/".$nowdate;
		@mkdir($picpath,0777);
		$uppath="advs/pics/".$nowdate;

		$arr=NewUploadImage1($spic["tmp_name"],$spic["type"],$spic["size"],$uppath);
		$src1=$arr[3];

		$msql->query("select * from {P}_advs_lb where  id='$id'");
		if($msql->next_record()){
			$oldsrc1=$msql->f('src1');
		}
		if(file_exists(ROOTPATH.$oldsrc1) && $oldsrc1!=""){
			unlink(ROOTPATH.$oldsrc1);
		}
		$msql->query("update {P}_advs_lb set src1='$src1' where id='$id'");

	}
	
	//記錄多國翻譯資料
	$langlist = $_POST['langlist'];
	if($langlist != ""){			
		$stitle = $_POST['stitle'];
		$smemo = $_POST['smemo'];
		$surl = $_POST['surl'];
		$spic = $_FILES['sjpg'];
		$spics = $_FILES['ssuo'];
		$soldsrc = $_POST['oldsrc'];
		$soldsrcs = $_POST['oldsrcs'];
		
		$lans = explode(",",$langlist);
		foreach($lans AS $ks=>$vs){
			//擷取各語言資料並寫入
			$title = htmlspecialchars($stitle[$vs]);
			$memo = htmlspecialchars($smemo[$vs]);
			$url = htmlspecialchars($surl[$vs]);
			$oldsrc = $soldsrc[$vs];
			$oldsrcs = $soldsrcs[$vs];
			
			if ( 0 < $spic['size'][$vs] )
			{
					$nowdate = date( "Ymd", time( ) );
					$picpath = "../pics/".$nowdate;
					@mkdir( $picpath, 511 );
					$uppath = "advs/pics/".$nowdate;
					$arrb = newuploadimage( $spic['tmp_name'][$vs], $spic['type'][$vs], $spic['size'][$vs], $uppath);
					if ( $arrb[0] != "err" )
					{
							$src = $arrb[3];
					}
					else
					{
							err( $arrb[1]."[".$vs."]", "", "" );
					}
					if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )
					{
							@unlink( ROOTPATH.$oldsrc );
							$getpic = basename($oldsrc);
							$getpicpath = dirname($oldsrc);
							@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
					}
			}else{
				$src = $oldsrc;
			}
			if ( 0 < $spics['size'][$vs] )
			{
					$nowdate = date( "Ymd", time( ) );
					$picpath = "../pics/".$nowdate;
					@mkdir( $picpath, 511 );
					$uppath = "advs/pics/".$nowdate;
					$arrs = newuploadimage1( $spics['tmp_name'][$vs], $spics['type'][$vs], $spics['size'][$vs], $uppath);
					if ( $arrs[0] != "err" )
					{
							$srcs = $arrs[3];
					}
					else
					{
							err( $arrs[1]."[".$vs."]", "", "" );
					}
					if ( file_exists( ROOTPATH.$oldsrcs ) && $oldsrc != "" && !strstr( $oldsrcs, "../" ) )
					{
							@unlink( ROOTPATH.$oldsrcs );
							$getpic = basename($oldsrcs);
							$getpicpath = dirname($oldsrcs);
							@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
					}
			}else{
				$srcs = $oldsrcs;
			}
			
				//getupdate 資料若存在則更新，否則新增
				$msql->getupdate(
					"SELECT id FROM {P}_advs_lb_translate WHERE pid='{$id}' AND langcode='{$vs}'",
					"UPDATE {P}_advs_lb_translate SET 
					title='{$title}',
					memo='{$memo}',
					src='{$src}',
					src1='{$srcs}',
					url='{$url}'
					WHERE pid='{$id}' AND langcode='{$vs}'",
					"INSERT INTO {P}_advs_lb_translate SET 
					pid='{$id}',
					langcode='{$vs}',
					title='{$title}',
					memo='{$memo}',
					src='{$src}',
					src1='{$srcs}',
					url='{$url}'"
				);
		}
	}
	//記錄多國翻譯資料 END
	
}

if($step=="new"){
	
	$msql->query("insert into {P}_advs_lb set 
	groupid='$groupid',
	title='$strAdvsLbTitle',
	src='',
	url='http://',
	xuhao='1'
	");
}

if($step=="chgname"){
	$groupname = $_REQUEST["chgname"];
	$msql->query("update {P}_advs_lbgroup set groupname='$groupname' where id='$groupid' ");
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
					<form id="selgroup" name="selgroup" method="get" action="advs_lb.php" class="form-inline pull-left" role="form">
						<div class="form-group">
							<select name="pp" class="form-control" onchange="self.location=this.options[this.selectedIndex].value">
					          <?php
								$msql->query("select * from {P}_advs_lbgroup");
								while($msql->next_record()){
									$lgroupid=$msql->f('id');
									$groupname=$msql->f('groupname');
										
									if($groupid==$lgroupid){
										echo "<option value='advs_lb.php?groupid=".$lgroupid."' selected>".$strAdvsGroupSel.$groupname."</option>";
										$thisgroupname = $groupname;
									}else{
										echo "<option value='advs_lb.php?groupid=".$lgroupid."'>".$strAdvsGroupSel.$groupname."</option>";
									}
											
								}
							 ?>
						        </select>
						        <button type="button" class="btn btn-primary" <?php echo $buttondis; ?> onClick="cm('<?php echo $groupid; ?>')"><i class="fa fa-trash"></i><?php echo $strAdvsGroupDel; ?></button>
						        <input type="text" name="chgname" value="<?php echo $thisgroupname;?>" class="form-control" /> <input type="submit" value="<?php echo $strModify; ?>" class="btn btn-warning" />
								<input type="hidden" name="step" value="chgname" />
								<input type="hidden" name="groupid" value="<?php echo $groupid; ?>" />
						</div>
					</form>
	
					<div class="pull-right">
						<form name="addform" method="get" action="advs_lb.php" class="form-horizontal" onSubmit="return checkform(this)">
						<input type="hidden" name="step" value="addgroup" />						
						<div class="fleft" style="margin: 0 5px;">
							<input name="groupname" type="text" class="form-control" placeholder="<?php echo $strAdvsGroupAddName; ?>" value="" />
						</div>
						<div class="fleft">
							<button type="submit" class="btn btn-primary btn-line"><i class="fa fa-plus"></i><?php echo $strAdvsGroupAdd; ?></button>
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
			<div class="portlet-body">
				<button type="button" class="btn btn-success" style="margin-bottom:20px;" onClick="self.location='advs_lb.php?step=new&groupid=<?php echo $groupid; ?>'">
					<i class="fa fa-pencil-square"></i> <?php echo $strAdvsLbNew; ?>
				</button>
<?php
	$msql->query("select * from {P}_advs_lb where groupid='$groupid' order by xuhao");
	while($msql->next_record()){
		$id=$msql->f('id');
		$title=$msql->f('title');
		$memo=$msql->f('memo');
		$src=$msql->f('src');
		$src1=$msql->f('src1');
		$url=$msql->f('url');
		$xuhao=$msql->f('xuhao');
		$type_name=$msql->f('type_name');
		$type_link=$msql->f('type_link');
		$position=$msql->f('position');
		$header_color=$msql->f('header_color');
?>
		<div class="portlet" style="border:0;">
			<div class="portlet-heading bg-primary">
				<div class="portlet-title">
					<h4><?php echo $title; ?></h4>
				</div>
				<div class="portlet-widgets">
					<a data-toggle="collapse" data-parent="#accordion" href="#b-<?php echo $id; ?>"><i class="fa fa-chevron-down"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
	
			<div id="b-<?php echo $id; ?>" class="panel-collapse collapse in">
				
				<div class="tc-tabs">
					<ul class="nav nav-tabs tab-color-dark background-dark">
						<li class="active"><a href="#tab1_<?php echo $id; ?>" class="tab" data-toggle="tab"><i class="fa fa-pencil bigger-130"></i> <?php echo $strAdd.$strModify; ?></a></li>
						<li><a href="#tab2_<?php echo $id; ?>" class="tab" data-toggle="tab"><i class="fa fa-exchange bigger-130"></i> 多國翻譯</a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane active" id="tab1_<?php echo $id; ?>">
							<!-- Tab1 開始 -->
				<div class="portlet-body">
					<form action="advs_lb.php" method="post" enctype="multipart/form-data" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-1 control-label"><?php echo $strAdvsLbTitle; ?></label>
							<div class="col-sm-6">
								<input type="text" name="title" placeholder="<?php echo $strAdvsLbTitle; ?>" value="<?php echo $title; ?>" class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label">圖片說明</label>
							<div class="col-sm-6">
								<textarea name="memo" rows="5" cols="50" class="form-control textarea"><?php echo $memo; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label">標題位置</label>
							<div class="col-sm-6">
								<select name="position" class="form-control">
									<option value="0" <?php echo $position == 0 ? 'selected' : ''; ?>>置中</option>
									<option value="1" <?php echo $position == 1 ? 'selected' : ''; ?>>左下</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label">Header顏色</label>
							<div class="col-sm-6">
								<select name="header_color" class="form-control">
									<option value="0" <?php echo $header_color == 0 ? 'selected' : ''; ?>>黑色</option>
									<option value="1" <?php echo $header_color == 1 ? 'selected' : ''; ?>>白色</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label"><?php echo $strAdvsLbPic; ?></label>
							<div class="col-sm-6">
								<div class="col-sm-12 input-group">
									<span class="input-group-btn">
										<span class="btn btn-file">
											瀏覽 <input type="file" name="jpg" id="jpg" multiple="">
										</span>
									</span>
									<input type="text" class="form-control" readonly="">
									<span class="input-group-addon">
									<?php
									if ( $src == "" )
									{
										echo "<img src='images/noimage.gif' >";
									}
									else
									{
										echo "<a class=' input-group' href=\"\" onclick=\"callcolorbox('".ROOTPATH.$src."'); return false;\" ><img src='images/image.gif' ></a>";
									}
									?>
									</span>
								</div>
									<span class="help-block"><?php echo $strAdvsLbNTC; ?></span>
							</div>
						</div>
						<!--小圖-->
						<div class="form-group" style="display:none">
							<label class="col-sm-1 control-label"><?php echo $strAdvsLbPic1; ?></label>
							<div class="col-sm-6">
								<div class="col-sm-12 input-group">
									<span class="input-group-btn">
										<span class="btn btn-file">
											瀏覽 <input type="file" name="suo" id="suo" multiple="">
										</span>
									</span>
									<input type="text" class="form-control" readonly="">
									<span class="input-group-addon">
									<?php
									if ( $src1 == "" )
									{
										echo "<img src='images/noimage.gif' >";
									}
									else
									{
										echo "<a class=' input-group' href=\"\" onclick=\"callcolorbox('".ROOTPATH.$src1."'); return false;\" ><img src='images/image.gif' ></a>";
									}
									?>
									</span>
								</div>
									<span class="help-block"><?php echo $strAdvsLbNTC3; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label"><?php echo $strAdvsLbUrl; ?></label>
							<div class="col-sm-6">
								<input type="text" name="url" id="url" value="<?php echo $url; ?>" class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label">系列名稱</label>
							<div class="col-sm-6">
								<input type="text" name="type_name" placeholder="系列名稱" value="<?php echo $type_name; ?>" class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label">系列連結</label>
							<div class="col-sm-6">
								<input type="text" name="type_link" placeholder="系列連結" value="<?php echo $type_link; ?>" class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label"><?php echo $strAdvsLbXuhao; ?></label>
							<div class="col-sm-1">
								<div class="spinner MySpinner">
									<div class="input-group input-small">
										<input type="text" name="xuhao" class="spinner-input form-control" value="<?php echo $xuhao; ?>">
										<div class="spinner-buttons input-group-btn btn-group-vertical">
											<button type="button" class="btn spinner-up btn-xs">
												<i class="fa fa-chevron-up icon-only"></i>
											</button>
											<button type="button" class="btn spinner-down btn-xs">
												<i class="fa fa-chevron-down icon-only"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-actions newsmodizone">
							<div class="form-group">
								<div class="col-sm-offset-1 col-sm-10">
									<button type="submit" name="submit" class="btn btn-info"><?php echo $strModify; ?></button>
									<button type="button" name="submit2" class="btn btn-primary" onClick="window.location='advs_lb.php?step=del&groupid=<?php echo $groupid; ?>&id=<?php echo $id; ?>'"><?php echo $strDelete; ?></button>
									<input type="hidden" name="id" value="<?php echo $id; ?>">
									<input type="hidden" name="groupid" value="<?php echo $groupid; ?>" />
									<input type="hidden" name="step" value="modify">
								</div>
							</div>
						</div>
				</div>
			<div class="clearfix"></div>
			<!-- Tab1 結束 -->
		</div>
		<div class="tab-pane" id="tab2_<?php echo $id; ?>">
			<!-- Tab2 開始 -->
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
		$langs = $tsql->getone( "SELECT * FROM {P}_advs_lb_translate WHERE pid='{$id}' AND langcode='{$langcode}'" );
?>
<!-- 依表列出語言檔內容 -->
				<div class="portlet">
					<div class="portlet-heading">
						<div class="portlet-title">
							<h4><img src="<?php echo $src; ?>" height="20"/> <?php echo $ltitle; ?></h4>
						</div>
						<div class="portlet-widgets">
							<a data-toggle="collapse" data-parent="#accordion" href="#no-<?php echo $lid; ?>"><i class="fa fa-chevron-down"></i></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<div id="no-<?php echo $lid; ?>" class="panel-collapse collapse in">
						<div class="portlet-body">
							<!-- 語言<?php echo $title; ?> 開始 -->
							<div class="form-group">
								<label class="col-sm-1 control-label"><?php echo $strAdvsLbTitle; ?></label>
								<div class="col-sm-6">
									<input type="text" name="stitle[<?php echo $langcode; ?>]" value="<?php echo $langs['title']; ?>" class="form-control">
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-1 control-label">圖片說明</label>
								<div class="col-sm-6">
									<textarea name="smemo[<?php echo $langcode; ?>]" rows="5" cols="50" class="form-control textarea"><?php echo $langs['memo']; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-1 control-label"><?php echo $strAdvsLbPic; ?></label>
								<div class="col-sm-6">
									<div class="col-sm-12 input-group">
										<span class="input-group-btn">
											<span class="btn btn-file">
												瀏覽 <input type="file" name="sjpg[<?php echo $langcode; ?>]" multiple="">
											</span>
										</span>
										<input type="text" class="form-control" readonly="">
										<input type="hidden" name="oldsrc[<?php echo $langcode; ?>]" value="<?php echo $langs['src']; ?>">
										<span class="input-group-addon">
										<?php
										if ( $langs['src'] == "" )
										{
											echo "<img src='images/noimage.gif' >";
										}
										else
										{
											echo "<a class=' input-group' href=\"\" onclick=\"callcolorbox('".ROOTPATH.$langs[src]."'); return false;\" ><img src='images/image.gif' ></a>";
										}
										?>
										</span>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-1 control-label"><?php echo $strAdvsLbPic1; ?></label>
								<div class="col-sm-6">
									<div class="col-sm-12 input-group">
										<span class="input-group-btn">
											<span class="btn btn-file">
												瀏覽 <input type="file" name="ssuo[<?php echo $langcode; ?>]" multiple="">
											</span>
										</span>
										<input type="text" class="form-control" readonly="">
										<input type="hidden" name="oldsrcs[<?php echo $langcode; ?>]" value="<?php echo $langs['src1']; ?>">
										<span class="input-group-addon">
										<?php
										if ( $langs['src1'] == "" )
										{
											echo "<img src='images/noimage.gif' >";
										}
										else
										{
											echo "<a class=' input-group' href=\"\" onclick=\"callcolorbox('".ROOTPATH.$langs[src1]."'); return false;\" ><img src='images/image.gif' ></a>";
										}
										?>
										</span>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-1 control-label"><?php echo $strUrl; ?></label>
								<div class="col-sm-6">
									<input type="text" name="surl[<?php echo $langcode; ?>]" value="<?php echo $langs['url']; ?>" class="form-control">
								</div>
								<div class="clearfix"></div>
							</div>
							<!-- 語言<?php echo $title; ?> 結束 -->
						</div>
					</div>
				</div>
<?php
	}
?>
				<div class="form-actions">
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<button type="submit" name="submit" class="btn btn-info"><?php echo $strModify; ?></button>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<input type="hidden" name="langlist" value="<?php echo $langlist; ?>" />
			</form>
			<div class="clearfix"></div>
			<!-- Tab2 結束 -->
		</div>
	</div>
</div>
			
										
			</div>
		</div>
<?php
}
?> 

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
			$('#pagetitle', window.parent.document).html('廣告管理 <span class="sub-title" id="subtitle"><?php echo $strSetMenu4; ?></span>');
			//呼叫左側功能選單
			$().getMenuGroup('advs');
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
			$().confirmwindow("<?php echo $strAdvsLbNTC2; ?>", function(result) {
				window.location='advs_lb.php?step=delgroup&groupid='+nn
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
	</script>
</body>
</html>