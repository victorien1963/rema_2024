<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
include("func/upload.inc.php");
NeedAuth(0);
#---------------------------------------------#

$step=$_REQUEST["step"];
$id=$_REQUEST["id"];
$groupid=$_REQUEST["groupid"];


if($step=="addgroup" && $_REQUEST["groupname"]!=""){
	$groupname=$_REQUEST["groupname"];
	$msql->query("insert into {P}_advs_linkgroup set
		`groupname`='$groupname',
		`xuhao`='1',
		`moveable`='1'
	");
	$groupid=$msql->instid();
	
	echo "<script>self.location='link.php?groupid=".$groupid."'</script>";

}

if($step=="delgroup" && $_REQUEST["groupid"]!="" && $_REQUEST["groupid"]!="0"){

	$msql->query("select * from {P}_advs_link where  groupid='".$_REQUEST["groupid"]."' ");
	while($msql->next_record()){
		$lbid=$msql->f('id');
		$oldsrc=$msql->f('src');
		if(file_exists(ROOTPATH.$oldsrc) && $oldsrc!=""){
			unlink(ROOTPATH.$oldsrc);
		}
		
	}
	$fsql->query("delete from {P}_advs_link where groupid='".$_REQUEST["groupid"]."' ");
	$msql->query ("delete from {P}_advs_linkgroup where id='".$_REQUEST["groupid"]."'");

	echo "<script>self.location='link.php'</script>";

}


if($groupid==""){
	$msql->query("select * from {P}_advs_linkgroup limit 0,1");
}else{
	$msql->query("select * from {P}_advs_linkgroup where id='$groupid'");
}
	if($msql->next_record()){
		$groupid=$msql->f('id');
		$moveable=$msql->f('moveable');
		if($moveable=="0"){
			$buttondis=" style='display:none' ";
		}
	}
	 

$url=$_POST["url"];
$name=$_POST["name"];
$pic=$_FILES["suo"];
$memo=$_POST["memo"];
$xuhao=$_POST["xuhao"];
$type=$_POST["type"]? $_POST["type"]:"_self";
$forcountry=$_POST["forcountry"];

if($step=="add"){
	/*if($url=="" || $url=="http://"){
		err($strLinkNTC1,"","");

	}*/
	if($name==""){
		err($strLinkNTC2,"","");

	}


	$url=htmlspecialchars($url);
	$name=htmlspecialchars($name);
	$memo=htmlspecialchars($memo);

	if ($pic["size"] > 0)  {


		$nowdate=date("Ymd",time());
		$picpath=ROOTPATH."advs/pics/".$nowdate;
		@mkdir($picpath,0777);
		$uppath="advs/pics/".$nowdate;

		$arr=NewUploadImage($pic["tmp_name"],$pic["type"],$pic["size"],$uppath);
		$src=$arr[3];
		
	}


	$msql->query("insert into {P}_advs_link set
	groupid='$groupid',
	name='$name',
	url='$url',
	xuhao='0',
	src='$src',
	memo='$memo',
	cl='0',
	type='_self'
	");

	echo "<script>self.location='link.php?groupid=".$groupid."'</script>";


}




if($step=="modify"){
	/*if($url=="" || $url=="http://"){
		err($strLinkNTC1,"","");

	}*/

	if($name==""){
		err($strLinkNTC2,"","");

	}

	$url=htmlspecialchars($url);
	$name=htmlspecialchars($name);
	$oldsrc = $_POST['oldsrc'];
	$memo=htmlspecialchars($memo);
	$forcountry=$_POST["forcountry"];
	$iffb=$_POST["iffb"];
	
	if ($pic["size"] > 0)  {

		$nowdate=date("Ymd",time());
		$picpath=ROOTPATH."advs/pics/".$nowdate;
		@mkdir($picpath,0777);
		$uppath="advs/pics/".$nowdate;

		$arr=NewUploadImage($pic["tmp_name"],$pic["type"],$pic["size"],$uppath);
		$src=$arr[3];
		if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )
		{
				@unlink( ROOTPATH.$oldsrc );
		}
		
	}else{
		$src = $oldsrc;
	}
	$msql->query("update {P}_advs_link set url='$url',name='$name',xuhao='$xuhao',src='$src',type='$type',memo='$memo',forcountry='$forcountry',iffb='$iffb' where id='$id' ");
	
	//記錄多國翻譯資料
	$langlist = $_REQUEST['langlist'];
	if($langlist != ""){			
		$sname = $_REQUEST['sname'];
		$smemo = $_REQUEST['smemo'];
		$spics = $_FILES['ssuo'];
		$soldsrc = $_POST['soldsrc'];
		$lans = explode(",",$langlist);
		foreach($lans AS $ks=>$vs){
			//擷取各語言資料並寫入
			$names = htmlspecialchars($sname[$vs]);
			$memos = htmlspecialchars($smemo[$vs]);
			$soldsrcs = $soldsrc[$vs];
			if ( 0 < $spics['size'][$vs] )
			{
					$nowdate = date( "Ymd", time( ) );
					$picpath = "../pics/".$nowdate;
					@mkdir( $picpath, 511 );
					$uppath = "advs/pics/".$nowdate;
					$arrb = newuploadimage( $spics['tmp_name'][$vs], $spics['type'][$vs], $spics['size'][$vs], $uppath);
					if ( $arrb[0] != "err" )
					{
							$src = $arrb[3];
					}
					else
					{
							err( $arrb[1]."[".$vs."]", "", "" );
					}
					if ( file_exists( ROOTPATH.$oldsrcs ) && $oldsrcs != "" && !strstr( $oldsrcs, "../" ) )
					{
							@unlink( ROOTPATH.$oldsrcs );
							$getpic = basename($oldsrcs);
							$getpicpath = dirname($oldsrcs);
							@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
					}
			}else{
				$src = $soldsrcs;
			}
			
				//getupdate 資料若存在則更新，否則新增
				$msql->getupdate(
					"SELECT id FROM {P}_advs_link_translate WHERE pid='{$id}' AND langcode='{$vs}'",
					"UPDATE {P}_advs_link_translate SET 
					name='{$names}',memo='{$memos}',src='{$src}' WHERE pid='{$id}' AND langcode='{$vs}'",
					"INSERT INTO {P}_advs_link_translate SET 
					pid='{$id}',
					langcode='{$vs}',
					name='{$names}',
					memo='{$memos}',
					src='{$src}'"
				);
				
		}
	}//多國
}


if($step=="del"){
	$msql->query("select src from {P}_advs_link where id='$id'");
	if($msql->next_record()){
		$oldsrc=$msql->f('src');
	}
	$fname=ROOTPATH.$oldsrc;
	if(file_exists($fname) && $oldsrc!=""){
		unlink($fname);
	}

	$msql->query("delete from {P}_advs_link where id='$id'");
	//刪除多語言
	$msql->query("select src from {P}_advs_link_translate where pid='$id'");
	while($msql->next_record()){
		$src=$msql->f('src');
		if(file_exists(ROOTPATH.$src) && $src!=""){
			unlink(ROOTPATH.$src);
		}
	}
	$msql->query("delete from {P}_advs_link_translate where pid='$id'");
	//刪除 END
}

if($step=="chgname"){
	$groupname = $_REQUEST["chgname"];
	$msql->query("update {P}_advs_linkgroup set groupname='$groupname' where id='$groupid' ");
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
					<form id="selgroup" name="selgroup" method="get" action="link.php" class="form-inline pull-left" role="form">
						<div class="form-group">
							<select name="pp" class="form-control" onchange="self.location=this.options[this.selectedIndex].value">
					          <?php
								$msql->query("select * from {P}_advs_linkgroup");
								while($msql->next_record()){
									$lgroupid=$msql->f('id');
									$groupname=$msql->f('groupname');
										
									if($groupid==$lgroupid){
										echo "<option value='link.php?groupid=".$lgroupid."' selected>".$strGroupSel.$groupname."</option>";
										$thisgroupname = $groupname;
									}else{
										echo "<option value='link.php?groupid=".$lgroupid."'>".$strGroupSel.$groupname."</option>";
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
						<form name="addform" method="get" action="link.php" class="form-horizontal" onSubmit="return checkform(this)">
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
					<form method="post" action="link.php" enctype="multipart/form-data" onSubmit="return checkMainform(this)" class="form-inline" role="form" >
						<div class="form-group input-group-sm">
							<label class="control-label"><font color="#FF3300">* </font><?php echo $strLinkName; ?>：</label>
							<input type="text" class="form-control" name="name" placeholder="<?php echo $strLinkName; ?>">
						</div>
						<div class="form-group">
							<label class="control-label"><font color="#FF3300">* </font><?php echo $strLinkUrl; ?>：</label>
							<input type="text" class="form-control input-large" name="url" value="http://" placeholder="<?php echo $strLinkUrl; ?>" >
						</div>
						<div class="form-group">
							<label class="control-label"><font color="#FF3300">  </font><?php echo $strAdvsLbPic; ?></label>
								<div class="input-group">
									<span class="input-group-btn">
										<span class="btn btn-file">
											瀏覽 <input type="file" name="suo" id="suo" multiple="">
										</span>
									</span>
									<input type="text" class="form-control" readonly="">
								</div>
						</div>
						<div class="form-group">
							<label class="control-label"><font color="#FF3300">  </font><?php echo $strLinkMemo; ?>：</label>
							<input type="text" class="form-control" name="memo" placeholder="<?php echo $strLinkMemo; ?>" >
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
										<th data-hide="phone,tablet" data-sort-ignore="true" class="col-small center"><?php echo $strXuhao; ?></th>
										<th data-sort-ignore="true"><?php echo $strLinkName; ?></th>
										<th data-sort-ignore="true">對應國家</th>
										<th data-sort-ignore="true"><?php echo $strLinkUrl; ?></th>
										<!--th data-hide="phone,tablet" data-sort-ignore="true"><?php echo $strLinkMemo; ?></th-->
										<th data-hide="phone,tablet" data-sort-ignore="true">顯示</th>
										<th data-hide="phone,tablet" data-sort-ignore="true"><?php echo $strLinkTarget; ?></th>
										<th data-hide="phone,tablet" data-sort-ignore="true"><?php echo $strLinkPic; ?></th>
										<th data-sort-ignore="true" class="col-small center"><?php echo $strModify; ?></th>
										<th data-hide="phone,tablet" class="col-small center"><?php echo $strDelete; ?></th>
									</tr>
								</thead>
								<tbody>
<?php 
$msql->query("select * from {P}_advs_link where groupid='$groupid' order by xuhao asc,id desc");
while($msql->next_record()){
	$id=$msql->f('id');
	$name=$msql->f('name');
	$url=$msql->f('url');
	$xuhao=$msql->f('xuhao');
	$src=$msql->f('src');
	$type=$msql->f('type');
	$memo=$msql->f('memo');
	$cid=$msql->f('forcountry');
	$iffb=$msql->f('iffb');
?>
	<form action="link.php" method="post" enctype="multipart/form-data" >
		<tr>
			<td>
				<div class="form-group">
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
			</td>
			<td>
				<div class="form-group form-inline portlet-widgets">
					<label class="control-label text-right">預設：</label>
					<input type="text" name="name" value="<?php echo $name; ?>" class="form-control">
						<a data-toggle="collapse" data-parent="#accordion_<?php echo $id; ?>" href=".l_<?php echo $id; ?>"><i class="fa fa-chevron-up"> 多語言</i></a>
				</div>
				<div id="l_<?php echo $id; ?>" class="panel-collapse collapse l_<?php echo $id; ?>">
					<!-- 擷取語言表 -->
					<?php
						$langlist = "";
						unset($show);
						$fsql->query( "SELECT * FROM {P}_base_language WHERE ifshow='1' AND ifdefault='0' ORDER BY xuhao asc" );
						while ( $fsql->next_record( ) )
						{
							$lid = $fsql->f( "id" );
							$ltitle = $fsql->f( "title" );
							$langcode = $fsql->f( "langcode" );
							$srcs = ROOTPATH.$fsql->f( "src" );
							$langlist .= $langlist? ",".$langcode:$langcode;
							
							//依表擷取語言檔內容
							$langs = $tsql->getone( "SELECT * FROM {P}_advs_link_translate WHERE pid='{$id}' AND langcode='{$langcode}'" );
							//其他欄位
							$show["memo"] .= '
							<div class="form-group  form-inline">
								<input type="text" class="form-control" name="smemo['.$langcode.']" id="smemo_'.$langs["id"].'" value="'.$langs["memo"].'">
							</div>';
							$show["file"] .= '
							<div class="form-group">
								<div class="col-sm-12 input-group">
									<span class="input-group-btn">
										<span class="btn btn-file">
											瀏覽 <input type="file" name="ssuo['.$langcode.']" id="ssuo_'.$langs["id"].'" multiple="">
										</span>
									</span>
									<input type="text" class="form-control" readonly="">
									<input type="hidden" name="soldsrc['.$langcode.']" value="'.$langs["src"].'" />
									<span class="input-group-addon">';
									if ( $langs["src"] == "" )
									{
										$show["file"] .= "<img src='images/noimage.gif' >";
									}
									else
									{
										$show["file"] .= "<a class='input-group' href=\"\" onclick=\"callcolorbox('".ROOTPATH.$langs["src"]."'); return false;\" ><img src='images/image.gif' ></a>";
									}
									$show["file"] .= '</span>
								</div>
							</div>';
					?>
							<div class="form-group  form-inline">
								<label class="control-label text-right"><?php echo $ltitle; ?>：</label>
								<input type="text" class="form-control" name="sname[<?php echo $langcode; ?>]" id="sname_<?php echo $langs['id']; ?>" value="<?php echo $langs['name']; ?>">
							</div>
					<?php
						}
					?>
				</div>
			</td>
			<td>
				<div class="form-group">
					<select name="forcountry" class="form-control select">
					<?php
						$fsql->query( "SELECT * FROM {P}_base_currency WHERE ifshow='1' ORDER BY xuhao asc" );
						while ( $fsql->next_record( ) )
						{
							$getcid = $fsql->f("id");
							$getcname = $fsql->f("title");
							if($getcid == $cid){
								echo '<option value="'.$getcid.'" selected>'.$getcname.'</option>';
							}else{
								echo '<option value="'.$getcid.'">'.$getcname.'</option>';
							}
						}
					?>
					</select>
				</div>
			</td>
			<td>
				<div class="form-group">
					<input type="text" name="url" value="<?php echo $url; ?>" class="form-control">
				</div>
			</td>
			<!--td>
				<div class="form-group">
					<input type="text" name="memo" value="<?php echo $memo; ?>" class="form-control">
				</div>
				<div id="l_<?php echo $id; ?>" class="panel-collapse collapse l_<?php echo $id; ?>">
					<?php echo $show["memo"]; ?>
				</div>
			</td-->
			<td>
				<div class="form-group">
					<select name="iffb" class="form-control select">
          				<option value="1" <?php echo seld($iffb,'1'); ?>>顯示</option>
          				<option value="0" <?php echo seld($iffb,'0'); ?>>隱藏</option>
        			</select>
				</div>
			</td>
			<td>
				<div class="form-group">
					<select name="type" class="form-control select">
          				<option value="_self" <?php echo seld($type,'_self'); ?>><?php echo $strSelf; ?></option>
          				<option value="_blank" <?php echo seld($type,'_blank'); ?>><?php echo $strBlank; ?></option>
        			</select>
				</div>
			</td>
			<td>
				<div class="form-group">
					<div class="col-sm-12 input-group">
						<span class="input-group-btn">
							<span class="btn btn-file">
								瀏覽 <input type="file" name="suo" id="suo" multiple="">
							</span>
						</span>
						<input type="text" class="form-control" readonly="">
						<input type="hidden" name="oldsrc" value="<?php echo $src;?>" />
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
				</div>
				<div id="l_<?php echo $id; ?>" class="panel-collapse collapse l_<?php echo $id; ?>">
					<?php echo $show["file"]; ?>
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
					<button type="button" class="btn btn-danger" onClick="self.location='link.php?step=del&groupid=<?php echo $groupid; ?>&id=<?php echo $id; ?>'"><i class="fa fa-times icon-only"></i></button>
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
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>廣告</li>');
			$('#pagetitle', window.parent.document).html('廣告管理 <span class="sub-title" id="subtitle"><?php echo $strSetMenu8; ?></span>');
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
			$().confirmwindow("<?php echo $strGroupNTC2; ?>", function(result) {
				window.location='link.php?step=delgroup&groupid='+nn;
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