<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");;
include("func/upload.inc.php");
NeedAuth(313);
#---------------------------------------------#
$pid = $_REQUEST['pid'];
$step = $_REQUEST['step'];
$cc = $_REQUEST['cc'];
$catid = $_REQUEST['id'];
$chgcat = $_REQUEST['chgcat'];

if(!isset($pid) || $pid==""){
	$pid=0;
}

if ( $step == "delall" )
{
				$msql->query( "SELECT * FROM {P}_shop_con" );
				if($msql->next_record()){
					echo "<SCRIPT>alert(\"".$strDelAllMust."\");</SCRIPT>";
				}else{
				$msql->query( "TRUNCATE TABLE {P}_shop_cat" );
				$msql->query( "TRUNCATE TABLE {P}_shop_prop" );
				}

}
if ( $catid !="" && $chgcat !="" )
{
	if($chgcat == "0"){
								$msql->query( "select catpath from {P}_shop_cat where catid='{$catid}'" );
								if ( $msql->next_record( ) )
								{
												$pcatpath = $msql->f( "catpath" );
								}
	$nowpath = fmpath( $catid );
	$catpath = $nowpath.":";
	$msql->query( "update {P}_shop_cat set pid='0',catpath='{$catpath}' where catid='{$catid}'" );
	$msql->query( "UPDATE {P}_shop_con SET catpath='{$catpath}' WHERE catid='{$catid}'" );
								$msql->query( "select catid,catpath from {P}_shop_cat where pid>='{$catid}' AND catpath regexp '^{$pcatpath}.*' " );
								while ( $msql->next_record( ) )
								{
										$subcatpath = $msql->f( "catpath" );
										$subid = $msql->f( "catid" );
										$subcatpath = str_replace($pcatpath,$catpath,$subcatpath);
										$fsql->query( "update {P}_shop_cat set catpath='{$subcatpath}' where catid='{$subid}'" );
										$fsql->query( "UPDATE {P}_shop_con SET catpath='{$subcatpath}' WHERE catid='{$subid}'" );
								}
	}else{
								$msql->query( "select catpath from {P}_shop_cat where catid='{$catid}'" );
								if ( $msql->next_record( ) )
								{
												$gcatpath = $msql->f( "catpath" );
								}
	$nowpath = fmpath( $catid );
								$msql->query( "select catpath from {P}_shop_cat where catid='{$chgcat}'" );
								if ( $msql->next_record( ) )
								{
												$pcatpath = $msql->f( "catpath" );
												if(strpos($pcatpath,$nowpath) !== FALSE){
													err($strShopNotice16,"","");
													exit();
												}
								}
	$catpath = $pcatpath.$nowpath.":";
	$msql->query( "update {P}_shop_cat set pid='{$chgcat}',catpath='{$catpath}' where catid='{$catid}'" );
	$msql->query( "UPDATE {P}_shop_con SET catpath='{$catpath}' WHERE catid='{$catid}'" );
	
								$msql->query( "select catid,catpath from {P}_shop_cat where catpath regexp '^{$gcatpath}.*' " );
								while ( $msql->next_record( ) )
								{
										$subcatpath = $msql->f( "catpath" );
										$subid = $msql->f( "catid" );
										$subcatpath = str_replace($gcatpath,$catpath,$subcatpath);
										$fsql->query( "update {P}_shop_cat set catpath='{$subcatpath}' where catid='{$subid}'" );
										$fsql->query( "UPDATE {P}_shop_con SET catpath='{$subcatpath}' WHERE catid='{$subid}'" );
								}
	}
}

if ( $step == "add" && $_REQUEST['cat'] != "" && $_REQUEST['cat'] != " " )
{
		$cat = $_REQUEST['cat'];
		$cat = htmlspecialchars( $cat );
		if ( $pid != "0" )
		{
				$msql->query( "select catpath from {P}_shop_cat where catid='{$pid}'" );
				if ( $msql->next_record( ) )
				{
						$pcatpath = $msql->f( "catpath" );
				}
		}
		$msql->query( "select max(xuhao) from {P}_shop_cat where pid='{$pid}'" );
		if ( $msql->next_record( ) )
		{
				$maxxuhao = $msql->f( "max(xuhao)" );
				$nowxuhao = $maxxuhao + 1;
		}
		$msql->query( "insert into {P}_shop_cat set
	`pid`='{$pid}',
	`cat`='{$cat}',
	`xuhao`='{$nowxuhao}',
	`catpath`='{$catpath}',
	`nums`='0',
	`tj`='0',
	`ifchannel`='0'
	" );
		$nowcatid = $msql->instid( );
		$nowpath = fmpath( $nowcatid );
		$catpath = $pcatpath.$nowpath.":";
		$msql->query( "update {P}_shop_cat set catpath='{$catpath}' where catid='{$nowcatid}'" );
}
if($step=="del"){

	$catid = $_REQUEST['catid'];
	$pid = $_REQUEST['pid'];
	$msql->query( "select id from {P}_shop_con where catid='{$catid}' " );
	if ( $msql->next_record( ) )
	{
			err( $strShopNotice1, "", "" );
			exit( );
	}
	$msql->query( "select catid from {P}_shop_cat where pid='{$catid}'" );
	if ( $msql->next_record( ) )
	{
			err( $strShopNotice2, "", "" );
			exit( );
	}
	$msql->query( "select ifchannel from {P}_shop_cat where catid='{$catid}'" );
	if ( $msql->next_record( ) )
	{
			$ifchannel = $msql->f( "ifchannel" );
	}
	if ( $ifchannel != 0 )
	{
			err( $strShopNotice9, "", "" );
			exit( );
	}
	$msql->query( "delete from {P}_shop_brandcat where  catid='{$catid}'" );
	$msql->query( "delete from {P}_shop_cat where catid='{$catid}'" );
	
	$msql->query( "delete from {P}_shop_brandcat_translate where pid='{$catid}'" );
	$msql->query("delete from {P}_shop_cat_translate where pid='$catid'");
	//刪除參數(含多語言)
	$msql->query("select * from {P}_shop_prop where catid='$catid'");
	while($msql->next_record()){
		$ppid=$msql->f('id');
		$fsql->query("delete from {P}_shop_prop_translate where pid='$ppid'");
	}
	$msql->query("delete from {P}_shop_prop where catid='$catid'");
}


if($step=="modi"){
	
	$cat = $_POST['cat'];
	$memo = $_POST['memo'];
		$catid = $_POST['catid'];
		$pid = $_POST['pid'];
		$xuhao = $_POST['xuhao'];
		$tj = $_POST['tj'];
		$hide = $_POST['hide'];
		$cat = htmlspecialchars( $cat );
		
		$pic = $_FILES['jpg'];
		$delcatimg = $_POST['delcatimg'];
		
		$pic2 = $_FILES['jpg2'];
		$delcatimg2 = $_POST['delcatimg2'];
		
		$msql->query( "update {P}_shop_cat set cat='{$cat}',memo='{$memo}',xuhao='{$xuhao}',ifhide='{$hide}' where catid='{$catid}' " );
		$msql->query( "update {P}_shop_cat set tj='{$tj}' where catpath regexp '".fmpath( $catid )."' " );
		
		if ( 0 < $pic['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "shop/pics/".$nowdate;
				$arr = newuploadimage( $pic['tmp_name'], $pic['type'], $pic['size'], $uppath );
				if ( $arr[0] != "err" )
				{
						$src = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
				$msql->query( "select src from {P}_shop_cat where catid='{$catid}'" );
				if ( $msql->next_record( ) )
				{
						$oldsrc = $msql->f( "src" );
				}
				if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )
				{
						unlink( ROOTPATH.$oldsrc );
						$getpic = basename($oldsrc);
						$getpicpath = dirname($oldsrc);
						@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
				}
				$msql->query( "update {P}_shop_cat set src='{$src}' where catid='{$catid}'" );
		}
		
		if($delcatimg == "1"){
				$msql->query( "select src from {P}_shop_cat where catid='{$catid}'" );
				if ( $msql->next_record( ) )
				{
						$oldsrc = $msql->f( "src" );
				}
				if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )
				{
						unlink( ROOTPATH.$oldsrc );
						$getpic = basename($oldsrc);
						$getpicpath = dirname($oldsrc);
						@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
				}
				$msql->query( "update {P}_shop_cat set src='' where catid='{$catid}'" );
		}
		
		if ( 0 < $pic2['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "shop/pics/".$nowdate;
				$arr2 = newuploadimage( $pic2['tmp_name'], $pic2['type'], $pic2['size'], $uppath );
				if ( $arr2[0] != "err" )
				{
						$src2 = $arr2[3];
				}
				else
				{
						echo $Meta.$arr2[1];
						exit( );
				}
				$msql->query( "select src2 from {P}_shop_cat where catid='{$catid}'" );
				if ( $msql->next_record( ) )
				{
						$oldsrc = $msql->f( "src2" );
				}
				if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )
				{
						unlink( ROOTPATH.$oldsrc );
						$getpic = basename($oldsrc);
						$getpicpath = dirname($oldsrc);
						@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
				}
				$msql->query( "update {P}_shop_cat set src2='{$src2}' where catid='{$catid}'" );
		}
		
		if($delcatimg2 == "1"){
				$msql->query( "select src2 from {P}_shop_cat where catid='{$catid}'" );
				if ( $msql->next_record( ) )
				{
						$oldsrc2 = $msql->f( "src2" );
				}
				if ( file_exists( ROOTPATH.$oldsrc2 ) && $oldsrc != "" && !strstr( $oldsrc2, "../" ) )
				{
						unlink( ROOTPATH.$oldsrc2 );
						$getpic = basename($oldsrc2);
						$getpicpath = dirname($oldsrc2);
						@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
				}
				$msql->query( "update {P}_shop_cat set src2='' where catid='{$catid}'" );
		}
	
	//記錄多國翻譯資料
	$langlist = $_REQUEST['langlist'];
	if($langlist != ""){			
		$scat = $_REQUEST['scat'];
		$smemo = $_REQUEST['smemo'];
		$lans = explode(",",$langlist);
		foreach($lans AS $ks=>$vs){
			//擷取各語言資料並寫入
			$cats = htmlspecialchars($scat[$vs]);
			$memos = htmlspecialchars($smemo[$vs]);
				//getupdate 資料若存在則更新，否則新增
				$msql->getupdate(
					"SELECT id FROM {P}_shop_cat_translate WHERE pid='{$catid}' AND langcode='{$vs}'",
					"UPDATE {P}_shop_cat_translate SET 
					cat='{$cats}',memo='{$memos}' WHERE pid='{$catid}' AND langcode='{$vs}'",
					"INSERT INTO {P}_shop_cat_translate SET 
					pid='{$catid}',
					langcode='{$vs}',
					cat='{$cats}',
					memo='{$memos}'"
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
							  <option value='shop_cat.php'><?php echo $strShopSelCat; ?></option>
						         <?php
										$fsql -> query ("select * from {P}_shop_cat order by catpath");
										while ($fsql -> next_record ()) {
											$lpid = $fsql -> f ("pid");
											$lcatid = $fsql -> f ("catid");
											$cat = $fsql -> f ("cat");
											$catpath = $fsql -> f ("catpath");
											$lcatpath = explode (":", $catpath);
											
											for ($i = 0; $i < sizeof ($lcatpath)-2; $i ++) {
												$tsql->query("select catid,cat from {P}_shop_cat where catid='$lcatpath[$i]'");
												if($tsql->next_record()){
													$ncatid=$tsql->f('cat');
													$ncat=$tsql->f('cat');
													$ppcat.=$ncat."/";
												}
											}
											
											if($pid==$lcatid){
												echo "<option value='shop_cat.php?pid=".$lcatid."' selected>".$ppcat.$cat."</option>";
											}else{
												echo "<option value='shop_cat.php?pid=".$lcatid."'>".$ppcat.$cat."</option>";
											}
											$ppcat="";
										}
								 ?>
						        </select>
						</div>
					</form>
	
					<div class="pull-right">
						<form name="addcat" method="get" action="shop_cat.php" class="form-horizontal" onSubmit="return catCheckform(this)">
						<input type="hidden" name="step" value="add" />
						<div class="fleft">
							<select name="pid" id="pid" class="form-control">
								<option value='0'><?php echo $strCatTopAdd; ?></option>
								<?php
									$fsql -> query ("select * from {P}_shop_cat order by catpath");
									while ($fsql -> next_record ()) {
										$lpid = $fsql -> f ("pid");
										$lcatid = $fsql -> f ("catid");
										$cat = $fsql -> f ("cat");
										$catpath = $fsql -> f ("catpath");
										$lcatpath = explode (":", $catpath);
										for ($i = 0; $i < sizeof ($lcatpath)-2; $i ++) {
											$tsql->query("select catid,cat from {P}_shop_cat where catid='$lcatpath[$i]'");
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
							<input name="cat" type="text" class="form-control" placeholder="<?php echo $strShopCatName; ?>" value="" />
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
							<th class="col-mini center"><?php echo $strCatTrn; ?></th>
							<th class="col-mini center"><?php echo $strXuhao; ?></th>
							<th class="col-width center"><?php echo $strCat; ?> </th>
							<th class="col-mini center"><?php echo $strShopList6; ?></th>
						    <th class="col-mini center"><?php echo $strShopList3; ?></td>
						    <th class="col-width center"><?php echo $strShopUpload; ?></td>
						    <th class="col-mini center"><?php echo 手機; ?></td>
						    <th class="col-width center"><?php echo $strShopUpload; ?></td>
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
	$msql->query("select * from {P}_shop_cat where  pid='$pid' order by xuhao");
	while($msql->next_record()){
		$catid=$msql->f("catid");
		$cat=$msql->f("cat");
		$memo=$msql->f("memo");
		$xuhao=$msql->f("xuhao");
		$pid=$msql->f("pid");
		$tj=$msql->f("tj");
		$catpath=$msql->f("catpath");
		$ifchannel=$msql->f("ifchannel");
		$ifcattemp = $msql->f( "cattemp" );
		$catsrc = $msql->f( "src" );
		$catsrc2 = $msql->f( "src2" );
		
		if($ifchannel=="1"){
			$href="../class/".$catid."/";
			$url="shop/class/".$catid."/";
		}else{
			$href="../class/?".$catid.".html";;
			$url="shop/class/?".$catid.".html";
		}
?> 
						<tr>
							<form method="post" action="shop_cat.php" enctype="multipart/form-data">
								<td class="col-mini center">
									<?php echo $catid; ?>
								</td> 
								<td class="col-mini center">
									<label class="tcb-inline" style="margin-right:0;">
										<input type="checkbox" id="setcat_<?php echo $catid; ?>" class="tc" name="setcat" onclick="abgne(this, chgcat_<?php echo $catid; ?>);"><span class="labels"></span>
									</label>
									<div id="chgcat_<?php echo $catid; ?>" name="chgcat" style="display:none">
										<select name="pid" onChange="self.location=this.options[this.selectedIndex].value" class="form-control" style="min-width:110px;">
											<option value='0'><?php echo $strShopSelCat; ?></option>
											<option value='shop_cat.php?chgcat=0&id=".$catid."'><?php echo $strMainCat; ?></option>
<?php 
$fsql->query( "select * from {P}_shop_cat order by catpath" );
while ( $fsql->next_record( ) )
{
				$lpid = $fsql->f( "pid" );
				$lcatid = $fsql->f( "catid" );
				$cats = $fsql->f( "cat" );
				$catpath = $fsql->f( "catpath" );
				$lcatpath = explode( ":", $catpath );
				
				for ( $i = 0;	$i < sizeof( $lcatpath ) - 2;	$i++	)
				{
								$tsql->query( "select catid,cat from {P}_shop_cat where catid='{$lcatpath[$i]}'" );
								if ( $tsql->next_record( ) )
								{
												$ncatid = $tsql->f( "cat" );
												$ncat = $tsql->f( "cat" );
												$ppcat .= $ncat."/";
								}
				}

								echo "<option value='?chgcat=".$lcatid."&id=".$catid."'>".$ppcat.$cats."</option>";
				$ppcat = "";
}
?>
										</select>
									</div>
								</td>
								<td class="col-mini center">
									<input type="text" name="xuhao" size="3" value="<?php echo $xuhao; ?>" class="form-control" />
								</td>
								<td class="col-width">
									<div class="form-group form-inline portlet-widgets">
										<label class="control-label text-right">預設：</label>
										<input type="text" name="cat" value="<?php echo $cat; ?>" id="cat_<?php echo $catid; ?>" class="form-control" />
										<textarea class="form-control" name="memo" id="memo_<?php echo $catid; ?>"><?php echo $memo; ?></textarea>
										<a data-toggle="collapse" data-parent="#accordion_<?php echo $catid; ?>" href="#l_<?php echo $catid; ?>"><i class="fa fa-chevron-up"> 多語言</i></a>
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
													$langs = $tsql->getone( "SELECT * FROM {P}_shop_cat_translate WHERE pid='{$catid}' AND langcode='{$langcode}'" );
											?>
												<div class="form-group form-inline portlet-widgets">
													<label class="control-label text-right"><?php echo $ltitle; ?>：</label>
													<input type="text" class="form-control" name="scat[<?php echo $langcode; ?>]" id="scat_<?php echo $langs['id']; ?>" value="<?php echo $langs['cat']; ?>">
													<textarea class="form-control" name="smemo[<?php echo $langcode; ?>]" id="smemo_<?php echo $langs['id']; ?>"><?php echo $langs['memo']; ?></textarea>
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
		<?php
			if ( $catsrc == "" )
			{
				echo "<img src='images/noimage.gif' >";
			}
			else
			{
				echo "<a href=\"\" onclick=\"callcolorbox_p('".ROOTPATH.$catsrc."'); return false;\" ><img src='images/image.gif' ></a>";
			}
		?>
      </td>
      <td class="col-width">
      		<div class="col-sm-12 input-group">
	  			<span class="input-group-btn">
					<span class="btn btn-file">
						瀏覽 <input type="file" name="jpg" id="jpg" multiple="">
					</span>
				</span>
				<input type="text" class="form-control" readonly="" style="min-width:150px;">
			</div>
      		<label class="tcb-inline" style="margin-right:0;">
				<input type="checkbox" class="tc" name="delcatimg" value="1" ><span class="labels"> <?php echo $strDelete; ?></span>
			</label>
      </td>
	<td class="col-mini center">
		<?php
			if ( $catsrc2 == "" )
			{
				echo "<img src='images/noimage.gif' >";
			}
			else
			{
				echo "<a href=\"\" onclick=\"callcolorbox_p('".ROOTPATH.$catsrc2."'); return false;\" ><img src='images/image.gif' ></a>";
			}
		?>
      </td>
      <td class="col-width">
      		<div class="col-sm-12 input-group">
	  			<span class="input-group-btn">
					<span class="btn btn-file">
						瀏覽 <input type="file" name="jpg2" id="jpg2" multiple="">
					</span>
				</span>
				<input type="text" class="form-control" readonly="" style="min-width:150px;">
			</div>
      		<label class="tcb-inline" style="margin-right:0;">
				<input type="checkbox" class="tc" name="delcatimg2" value="1" ><span class="labels"> <?php echo $strDelete; ?></span>
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
									<img src="images/prop.png" border=0 style="cursor:pointer;display:<?php echo $listdis; ?>" onClick="callcolorbox('../../shop/admin/prop_frame.php?catid=<?php echo $catid; ?>&pid=<?php echo $pid; ?>')">
								</td>
								<td class="col-mini center">
									<img src="images/delete.png"  style="cursor:pointer"  border=0 onClick="self.location='shop_cat.php?step=del&catid=<?php echo $catid; ?>&pid=<?php echo $pid; ?>'">
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
	<script src="js/shop.js"></script>
		
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>購物</li>');
			$('#pagetitle', window.parent.document).html('購物管理 <span class="sub-title" id="subtitle">商品分類管理</span>');
			//呼叫左側功能選單
			$().getMenuGroup('shop');
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
		
		//colorbox function
		function callcolorbox_p(href){
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
		function abgne(c, o){
			o.style.display = c.checked?"block":"none";
		}
		function cm(nn){
			qus=confirm("<?php echo $strDelAll;?>")
			if(qus!=0){
			window.location='shop_cat.php?step=delall';
			}
		}
    </script>
  </body>
</html>