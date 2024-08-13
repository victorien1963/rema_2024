<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/upload.inc.php" );
needauth( 0 );
#---------------------------------------------#

$id = $_REQUEST['id'];
$step = $_REQUEST['step'];
$groupid = $_REQUEST['groupid'];
if ( $step == "2" )
{
		$id = $_POST['id'];
		$title = htmlspecialchars( $_POST['title'] );
		$pagefolder = htmlspecialchars( $_POST['pagefolder'] );
		$old_pagefolder = htmlspecialchars( $_POST['old_pagefolder'] );
		$old_groupid = $_POST['old_groupid'];
		$url = htmlspecialchars( $_POST['url'] );
		$memo = htmlspecialchars( $_POST['memo'] );
		$body = $_POST['body'];
		$xuhao = $_POST['xuhao'];
		$pic = $_FILES['jpg'];
		
		if ( $title == "" )
		{
				err( $strHtmNotice1, "", "" );
		}
		if ( 200 < strlen( $title ) )
		{
				err( $strHtmNotice2, "", "" );
		}
		/*if ( 65000 < strlen( $body ) )
		{
				err( $strHtmNotice3, "", "" );
		}*/
		$body = url2path( $body );
		if ( $groupid != $old_groupid && $pagefolder != $old_pagefolder )
		{
				err( $strHtmNotice14, "", "" );
		}
		if ( 0 < $pic['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "page/pics/".$nowdate;
				$arr = newuploadimage( $pic['tmp_name'], $pic['type'], $pic['size'], $uppath);
				if ( $arr[0] != "err" )
				{
						$src = $arr[3];
				}
				else
				{
						err( $arr[1], "", "" );
				}
				$msql->query( "select src from {P}_page where id='{$id}'" );
				if ( $msql->next_record( ) )
				{
						$oldsrc = $msql->f( "src" );
				}
				if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )
				{
						@unlink( ROOTPATH.$oldsrc );
						$getpic = basename($oldsrc);
						$getpicpath = dirname($oldsrc);
						@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
				}
				$msql->query( "update {P}_page set src='{$src}'  where id='{$id}'" );
		}
		if ( $pagefolder != "" && $old_pagefolder != $pagefolder )
		{
				if ( strlen( $pagefolder ) < 1 || 16 < strlen( $pagefolder ) )
				{
						err( $strHtmNotice11, "", "" );
				}
				if ( !eregi( "^[0-9a-z]{0,16}\$", $pagefolder ) )
				{
						err( $strHtmNotice11, "", "" );
				}
				if ( strstr( $pagefolder, "/" ) || strstr( $pagefolder, "." ) )
				{
						err( $strHtmNotice11, "", "" );
				}
				$arr = array( "index", "main", "default", "detail", "admin", "images", "includes", "language", "module", "page", "templates", "js", "css" );
				if ( in_array( $pagefolder, $arr ) == true )
				{
						err( $strHtmNotice12, "", "" );
				}
				$fsql->query( "select id from {P}_page where groupid='{$groupid}' and pagefolder='{$pagefolder}' and id!='{$id}'" );
				if ( $fsql->next_record( ) )
				{
						err( $strHtmNotice13, "", "" );
				}
				$fsql->query( "select folder from {P}_page_group where id='{$groupid}'" );
				if ( $fsql->next_record( ) )
				{
						$folder = $fsql->f( "folder" );
				}
				$pagename = $folder."_".$pagefolder;
				$fd = fopen( "../temp.php", "r" );
				$str = fread( $fd, "2000" );
				$str = str_replace( "TEMP", $pagename, $str );
				fclose( $fd );
				$filename = "../".$folder."/".$pagefolder.".php";
				$fp = fopen( $filename, "w" );
				fwrite( $fp, $str );
				fclose( $fp );
				@chmod( $filename, 493 );
				@unlink( "../".$folder."/".$old_pagefolder.".php" );
				$oldpagename = $folder."_".$old_pagefolder;
				if ( $old_pagefolder == "" )
				{
						$msql->query( "insert into {P}_base_pageset set 
							`name`='{$title}',
							`coltype`='page',
							`pagename`='{$pagename}',
							`buildhtml`='0'
						" );
				}
				else
				{
						$msql->query( "update {P}_base_pageset set pagename='{$pagename}' where coltype='page' and pagename='{$oldpagename}'" );
				}
				$msql->query( "update {P}_base_plus set pluslocat='{$pagename}' where plustype='page' and pluslocat='{$oldpagename}'" );
				$msql->query( "update {P}_base_plusplan set pluslocat='{$pagename}' where plustype='page' and pluslocat='{$oldpagename}'" );
		}
		if ( $old_pagefolder != "" && $pagefolder == "" )
		{
				$fsql->query( "select folder from {P}_page_group where id='{$groupid}'" );
				if ( $fsql->next_record( ) )
				{
						$folder = $fsql->f( "folder" );
				}
				@unlink( "../".$folder."/".$old_pagefolder.".php" );
				$oldpagename = $folder."_".$old_pagefolder;
				$msql->query( "delete from {P}_base_pageset where coltype='page' and pagename='{$oldpagename}'" );
				$msql->query( "delete from {P}_base_plus where plustype='page' and pluslocat='{$oldpagename}'" );
				$msql->query( "delete from {P}_base_plusplan where plustype='page' and pluslocat='{$oldpagename}'" );
		}
		if ( $groupid != $old_groupid && $pagefolder == $old_pagefolder && $pagefolder != "" )
		{
				$fsql->query( "select folder from {P}_page_group where id='{$groupid}'" );
				if ( $fsql->next_record( ) )
				{
						$folder = $fsql->f( "folder" );
				}
				$fsql->query( "select folder from {P}_page_group where id='{$old_groupid}'" );
				if ( $fsql->next_record( ) )
				{
						$oldfolder = $fsql->f( "folder" );
				}
				$filename = "../".$folder."/".$pagefolder.".php";
				$oldfilename = "../".$oldfolder."/".$pagefolder.".php";
				$pagename = $folder."_".$pagefolder;
				$fd = fopen( "../temp.php", "r" );
				$str = fread( $fd, "2000" );
				$str = str_replace( "TEMP", $pagename, $str );
				fclose( $fd );
				$fp = fopen( $filename, "w" );
				fwrite( $fp, $str );
				fclose( $fp );
				@chmod( $filename, 493 );
				@unlink( $oldfilename );
				$oldpagename = $oldfolder."_".$pagefolder;
				$msql->query( "update {P}_base_pageset set pagename='{$pagename}' where coltype='page' and pagename='{$oldpagename}'" );
				$msql->query( "update {P}_base_plus set pluslocat='{$pagename}' where plustype='page' and pluslocat='{$oldpagename}'" );
				$msql->query( "update {P}_base_plusplan set pluslocat='{$pagename}' where plustype='page' and pluslocat='{$oldpagename}'" );
		}
		$msql->query( "update {P}_page set 
			title='{$title}',
			xuhao='{$xuhao}',
			memo='{$memo}',
			url='{$url}',
			groupid='{$groupid}',
			pagefolder='{$pagefolder}',
			body='{$body}'
			where id='{$id}'
	" );
	
	//記錄多國翻譯資料
	$langlist = $_POST['langlist'];
	if($langlist != ""){			
		$stitle = $_POST['stitle'];
		$surl = $_POST['surl'];
		$smemo = $_POST['smemo'];
		$sbody = $_POST['sbody'];
		$spic = $_FILES['sjpg'];
		$soldsrc = $_POST['oldsrc'];
		
		$lans = explode(",",$langlist);
		foreach($lans AS $ks=>$vs){
			//擷取各語言資料並寫入
			$title = htmlspecialchars($stitle[$vs]);
			$url = htmlspecialchars($surl[$vs]);
			$memo = htmlspecialchars($smemo[$vs]);
			$body = $sbody[$vs];
			$oldsrc = $soldsrc[$vs];
			
			if ( 0 < $spic['size'][$vs] )
			{
					$nowdate = date( "Ymd", time( ) );
					$picpath = "../pics/".$nowdate;
					@mkdir( $picpath, 511 );
					$uppath = "page/pics/".$nowdate;
					$arr = newuploadimage( $spic['tmp_name'][$vs], $spic['type'][$vs], $spic['size'][$vs], $uppath);
					if ( $arr[0] != "err" )
					{
							$src = $arr[3];
					}
					else
					{
							err( $arr[1]."[".$vs."]", "", "" );
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
			
				//getupdate 資料若存在則更新，否則新增
				$msql->getupdate(
					"SELECT id FROM {P}_page_translate WHERE pid='{$id}' AND langcode='{$vs}'",
					"UPDATE {P}_page_translate SET 
					title='{$title}',
					memo='{$memo}',
					url='{$url}',
					body='{$body}',
					src='{$src}'
					WHERE pid='{$id}' AND langcode='{$vs}'",
					"INSERT INTO {P}_page_translate SET 
					pid='{$id}',
					langcode='{$vs}',
					title='{$title}',
					memo='{$memo}',
					url='{$url}',
					body='{$body}',
					src='{$src}'"
				);
		}
	}
	//記錄多國翻譯資料 END
	
		sayok( $strHtmNotice6, "index.php?groupid=".$groupid, "" );
}

$msql->query( "select * from {P}_page where  id='{$id}'" );
if ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$body = $msql->f( "body" );
		$title = $msql->f( "title" );
		$xuhao = $msql->f( "xuhao" );
		$groupid = $msql->f( "groupid" );
		$pagefolder = $msql->f( "pagefolder" );
		$url = $msql->f( "url" );
		$memo = $msql->f( "memo" );
}

$body = path2url( $body );
if ( $pagefolder == "" )
{
		$showtr = "style='display:none'";
		$modiselmodle = "0";
}
else
{
		$showtr = "";
		$modiselmodle = "1";
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

<div class="tc-tabs">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" class="tab" data-toggle="tab"><i class="fa fa-pencil bigger-130"></i> 網頁編輯</a></li>
		<li><a href="#tab2" class="tab" data-toggle="tab"><i class="fa fa-exchange bigger-130"></i> 多國翻譯</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<!-- Tab1 開始 -->
			
<form  method="post" action="page_edit.php" enctype="multipart/form-data" name="form" id="modiPageForm" class="form-horizontal" role="form">
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strIdx; ?></label>
		<div class="col-sm-6">
			<input type="text" name="xuhao" placeholder="<?php echo $strIdx; ?>" value="<?php echo $xuhao; ?>" class="form-control" maxlength="9">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strGroupSel1; ?></label>
		<div class="col-sm-6">
			<select class="form-control" name="groupid" id="groupid">
				<?php
				$msql->query( "select * from {P}_page_group" );
				while ( $msql->next_record( ) )
				{
						$lgroupid = $msql->f( "id" );
						$groupname = $msql->f( "groupname" );
						if ( $groupid == $lgroupid )
						{
								echo "<option value='".$lgroupid."' selected>".$groupname."</option>";
						}
						else
						{
								echo "<option value='".$lgroupid."'>".$groupname."</option>";
						}
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strPagePbModle; ?></label>
		<div class="col-sm-6">
			<select class="form-control" name="modiselmodle" id="modiselmodle">
				<option value="1" <?php echo seld( $modiselmodle, "1" ); ?>><?php echo $strPageFolderS2; ?></option>
            	<option value="0" <?php echo seld( $modiselmodle, "0" ); ?>><?php echo $strPageFolderS1; ?></option>
			</select>
		</div>
	</div>
	<div class="form-group" id="tr_fold" <?php echo $showtr; ?>>
		<label class="col-sm-1 control-label"><font color="#FF0000">*</font><?php echo $strPagePbName; ?></label>
		<div class="col-sm-6">
			<div class="col-sm-12 input-group">
				<input type="text" name="pagefolder" id="pagefolder" placeholder="<?php echo $strPagePbName; ?>" value="<?php echo $pagefolder; ?>" class="form-control" maxlength="30">
				<span class="input-group-addon">.php</span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><font color="#FF0000">*</font><?php echo $strPageTitle; ?></label>
		<div class="col-sm-6">
			<input type="text" name="title" id="title" placeholder="<?php echo $strPageTitle; ?>" value="<?php echo $title; ?>" class="form-control" maxlength="200">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strPagePicSrc; ?></label>
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
				if ( $src== "" )
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
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strPageCon; ?></label>
		<div class="col-sm-8">
			<script src="../../kedit/kindeditor_up.js"></script>
			<script charset="utf-8" src="../../kedit/lang/zh_TW.js"></script>
			<textarea name="body" style="width:100%;height:400px;visibility:hidden;"><?php echo $body; ?></textarea>
			<input type="hidden" name="step" value="2" />
			<input type="hidden" name="id" value="<?php echo $id; ?>" />
			<input name="old_groupid" type="hidden" id="old_groupid" value="<?php echo $groupid; ?>" />
			<input name="old_pagefolder" type="hidden" id="old_pagefolder" value="<?php echo $pagefolder; ?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strPageMemo; ?></label>
		<div class="col-sm-6">
			<textarea name="memo" id="memo" rows="5" class="form-control" id="memo"><?php echo $memo; ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-1 control-label"><?php echo $strPageToUrl; ?></label>
		<div class="col-sm-6">
			<input type="text" name="url" id="url" placeholder="請輸入連結網址" value="<?php echo $url; ?>" class="form-control" maxlength="200">
		</div>
	</div>
	<div class="form-actions">
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-10">
				<button type="submit" name="submit" class="btn btn-primary"  <?php echo switchdis( 120 ); ?>><?php echo $strSubmit; ?></button>
			</div>
		</div>
	</div>
			<!-- Tab1 結束 -->
		</div>
		<div class="tab-pane" id="tab2">
			<!-- Tab2 開始 -->
			<!-- 擷取語言表 -->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php
	$langlist = "";
	$msql->query( "SELECT * FROM {P}_base_language WHERE ifshow='1' AND ifdefault='0' ORDER BY xuhao asc" );
	while ( $msql->next_record( ) )
	{
		$lid = $msql->f( "id" );
		$ltitle = $msql->f( "title" );
		$langcode = $msql->f( "langcode" );
		$src = ROOTPATH.$msql->f( "src" );
		$langlist .= $langlist? ",".$langcode:$langcode;
		
		//依表擷取語言檔內容
		$langs = $fsql->getone( "SELECT * FROM {P}_page_translate WHERE pid='{$id}' AND langcode='{$langcode}'" );
?>
<!-- 依表列出語言檔內容 -->
				<div class="portlet no-border">
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
								<label class="col-sm-1 control-label"><?php echo $strPageTitle; ?></label>
								<div class="col-sm-6">
									<input type="text" name="stitle[<?php echo $langcode; ?>]" placeholder="<?php echo $strPageTitle; ?>" value="<?php echo $langs['title']; ?>" class="form-control" maxlength="200">
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-1 control-label"><?php echo $strPagePicSrc; ?></label>
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
								<label class="col-sm-1 control-label"><?php echo $strPageCon; ?></label>
								<div class="col-sm-8">
									<script>
										KindEditor.ready(function(K) {
											var editor<?php echo $lid; ?> = K.create('#sbody_<?php echo $langcode; ?>', {
												uploadJson : '../../kedit/php/upload_json.php?attachPath=page/pics/',
												fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=page/pics/',
												allowFlashUpload : false,
												allowMediaUpload : false,
												allowFileManager : true,
												langType : 'zh_TW',
												filterMode: false,
												afterBlur: function () { editor<?php echo $lid; ?>.sync(); }
											});
										});
									</script>
									<textarea name="sbody[<?php echo $langcode; ?>]" id="sbody_<?php echo $langcode; ?>" style="width:100%;height:400px;visibility:hidden;"><?php echo $langs['body']; ?></textarea>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-1 control-label"><?php echo $strPageMemo; ?></label>
								<div class="col-sm-6">
									<textarea name="smemo[<?php echo $langcode; ?>]" rows="5" class="form-control"><?php echo $langs['memo']; ?></textarea>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-1 control-label"><?php echo $strPageToUrl; ?></label>
								<div class="col-sm-6">
									<input type="text" name="surl[<?php echo $langcode; ?>]" placeholder="請輸入連結網址" value="<?php echo $langs['url']; ?>" class="form-control" maxlength="200">
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
										<button type="submit" name="submit" class="btn btn-primary"  <?php echo switchdis( 120 ); ?>><?php echo $strSubmit; ?></button>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<input type="hidden" name="langlist" value="<?php echo $langlist; ?>" />
</form>
			</div>
			<div class="clearfix"></div>
			<!-- Tab2 結束 -->
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
	<script>
		KindEditor.ready(function(K) {
			var editor = K.create('textarea[name="body"]', {
				uploadJson : '../../kedit/php/upload_json.php?attachPath=page/pics/',
				fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=page/pics/',
				allowFlashUpload : false,
				allowMediaUpload : false,
				allowFileManager : true,
				designMode : false,
				langType : 'zh_TW',
				filterMode: false,
				afterBlur: function () { editor.sync(); }

			});
		});
	</script>
	<script src="js/page.js"></script>
		
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>網頁</li>');
			$('#pagetitle', window.parent.document).html('<?php echo $strHtmEdit;?> <span class="sub-title" id="subtitle"><?php echo $title;?></span>');
			//呼叫左側功能選單
			$().getMenuGroup('page');
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
			}
    </script>
  </body>
</html>