<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/adminpages.inc.php" );
include( "language/".$sLan.".php" );
needauth( 122 );
#---------------------------------------------#

$pid = $_REQUEST['pid'];
$page = $_REQUEST['page'];
$step = $_REQUEST['step'];
$id = $_REQUEST['id'];
$title = $_REQUEST['title'];
$xuhao = $_REQUEST['xuhao'];
$tj = $_REQUEST['tj'];
$iffb = $_REQUEST['iffb'];
$ifbold = $_REQUEST['ifbold'];
$ifred = $_REQUEST['ifred'];
$key = $_REQUEST['key'];
$secure = $_REQUEST['secure'];
$showtj = $_REQUEST['showtj'];
$showfb = $_REQUEST['showfb'];
$shownum = $_REQUEST['shownum'];
$sc = $_REQUEST['sc'];
$ord = $_REQUEST['ord'];
$bg = $_REQUEST['bg'];
if ( !isset( $pid ) || $pid == "" )
{
		$pid = "all";
}
if ( !isset( $shownum ) || $shownum < 10 )
{
		$shownum = 10;
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

<?php
if ( $step == "setfb" )
{
		trylimit( "_news_con", 200, "id" );
		$dall = $_POST['dall'];
		$nums = sizeof( $dall );
		$iffb = $_POST['iffb'];
		
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_news_con set iffb='{$iffb}' where id='{$ids}'" );
		}
}
if ( $step == "settj" )
{
		trylimit( "_news_con", 200, "id" );
		$dall = $_POST['dall'];
		$tj = $_POST['tj'];
		$nums = sizeof( $dall );
		
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_news_con set tj='{$tj}' where id='{$ids}'" );
		}
}
if ( $step == "setsecure" )
{
		trylimit( "_news_con", 200, "id" );
		$dall = $_POST['dall'];
		$secure = $_POST['secure'];
		$nums = sizeof( $dall );
		
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_news_con set secure='{$secure}' where id='{$ids}'" );
		}
}
if ( $step == "setbold" )
{
		trylimit( "_news_con", 200, "id" );
		$dall = $_POST['dall'];
		$bold = $_POST['bold'];
		$nums = sizeof( $dall );
		
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_news_con set ifbold='{$bold}' where id='{$ids}'" );
		}
}
if ( $step == "setcolor" )
{
		trylimit( "_news_con", 200, "id" );
		$dall = $_POST['dall'];
		$nums = sizeof( $dall );
		$nowcolor = $_POST['nowcolor'];
		
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_news_con set ifred='{$nowcolor}' where id='{$ids}'" );
		}
}
if ( $step == "delall" )
{
		trylimit( "_news_con", 200, "id" );
		$dall = $_POST['dall'];
		$nums = sizeof( $dall );
		
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "select src from {P}_news_con where id='{$ids}'" );
				if ( $msql->next_record( ) )
				{
						$src = $msql->f( "src" );
						$srcs = thumb($src);
						if ( file_exists( ROOTPATH.$src ) && $src != "" )
						{
								@unlink( ROOTPATH.$src );
								@unlink( ROOTPATH.$srcs );
						}
				}
				$msql->query( "select fileurl from {P}_news_con where id='{$ids}'" );
				if ( $msql->next_record( ) )
				{
						$src = $msql->f( "fileurl" );
						if ( file_exists( ROOTPATH.$src ) && $src != "" && !strstr( $src, "http://" ) )
						{
								@unlink( ROOTPATH.$src );
						}
				}
				$msql->query( "delete from {P}_news_pages where newsid='{$ids}'" );
				//$msql->query( "delete from {P}_comment where catid='1' and rid='{$ids}'" );
				$msql->query( "delete from {P}_news_con where id='{$ids}'" );
				
				$msql->query( "delete from {P}_news_pages_translate where pid='{$ids}'" );
				$msql->query( "delete from {P}_news_con_translate where pid='{$ids}'" );
		}
}
if ( $step == "refresh" )
{
		$newtime = time( );
		$msql->query( "update {P}_news_con set uptime='{$newtime}' where id='{$id}'" );
}

if ( !isset( $ord ) || $ord == "" )
{
		$ord = "id";
}
if ( !isset( $sc ) || $sc == "" )
{
		$sc = "desc";
}
$scl = "  id!='0' ";
if ( $key != "" )
{
		$scl .= " and (title regexp '{$key}' or body regexp '{$key}') ";
}
if ( $showtj != "" && $showtj != "all" )
{
		$scl .= " and tj='{$showtj}' ";
}
if ( $showfb != "" && $showfb != "all" )
{
		$scl .= " and iffb='{$showfb}' ";
}
if ( $pid != "" && $pid != "all" )
{
		if ( $pid == "0" )
		{
				$scl .= " and catid='0' ";
		}
		else
		{
				$fmdpath = fmpath( $pid );
				$scl .= " and catpath regexp '{$fmdpath}' ";
		}
}
$totalnums = tblcount( "_news_con", "id", $scl );
$pages = new pages( );
$pages->setvar( array(
		"shownum" => $shownum,
		"pid" => $pid,
		"sc" => $sc,
		"ord" => $ord,
		"showtj" => $showtj,
		"showfb" => $showfb,
		"key" => $key
) );
$pages->set( $shownum, $totalnums );
$pagelimit = $pages->limit( );
?>
<div class="row">
	<div class="col-lg-12">									
		<div class="portlet">
			<div id="f-1" class="panel-collapse collapse in">
				<div class="portlet-body">
					<form method="get" action="index.php" class="form-inline pull-left" role="form">
						<div class="form-group">
							<select name="pid" class="form-control">
								<option value='all'><?php echo $strNewsSelCat; ?></option>
								<!--option value='0' <?php echo seld( $pid, "0" ); ?>><?php echo $strNewsBlog; ?></option-->
								<?php
								$fsql->query( "select * from {P}_news_cat order by catpath" );
								while ( $fsql->next_record( ) )
								{
										$lpid = $fsql->f( "pid" );
										$lcatid = $fsql->f( "catid" );
										$cat = $fsql->f( "cat" );
										$catpath = $fsql->f( "catpath" );
										$lcatpath = explode( ":", $catpath );
										$i = 0;
										for ( ;	$i < sizeof( $lcatpath ) - 2;	$i++	)
										{
												$tsql->query( "select catid,cat from {P}_news_cat where catid='{$lcatpath[$i]}'" );
												if ( $tsql->next_record( ) )
												{
														$ncatid = $tsql->f( "cat" );
														$ncat = $tsql->f( "cat" );
														$ppcat .= $ncat."/";
												}
										}
										if ( $pid == $lcatid )
										{
												echo "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
										}
										else
										{
												echo "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
										}
										
										$catlist[$lcatid] = $ppcat.$cat;
										
										$ppcat = "";
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<select name="showtj" class="form-control">
								<option value="all" ><?php echo $strNewsSelTj; ?></option>
								<option value="1"  <?php echo seld( $showtj, "1" ); ?>><?php echo $strNewsSelTjYes; ?></option>
								<option value="0" <?php echo seld( $showtj, "0" ); ?>><?php echo $strNewsSelTjNo; ?></option>
							</select>
						</div>
						<div class="form-group">
							<select name="showfb" class="form-control">
								<option value="all" ><?php echo $strNewsSelFb; ?></option>
								<option value="1"  <?php echo seld( $showfb, "1" ); ?>><?php echo $strNewsSelFbYes; ?></option>
								<option value="0" <?php echo seld( $showfb, "0" ); ?>><?php echo $strNewsSelFbNo; ?></option>
							</select>
						</div>
						<div class="form-group">
							<select name="shownum" class="form-control">
								<option value="10"  <?php echo seld( $shownum, "10" ); ?>><?php echo $strNewsSelNum10; ?></option>
								<option value="20" <?php echo seld( $shownum, "20" ); ?>><?php echo $strNewsSelNum20; ?></option>
								<option value="30" <?php echo seld( $shownum, "30" ); ?>><?php echo $strNewsSelNum30; ?></option>
								<option value="50" <?php echo seld( $shownum, "50" ); ?>><?php echo $strNewsSelNum50; ?></option>
							</select>
						</div>
						<div class="input-group">
							<input type="text" name="key" size="16" class="form-control search-query" value="<?php echo $key; ?>" />       
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary" title="<?php echo $strSearchTitle; ?>">
									<i class="fa fa-search icon-only"></i>
								</button>
							</span>
						</div>
					</form>
	
					<div class="pull-right">
						<button type="button" onClick="window.location='news_conadd.php'" class="btn btn-primary btn-line" <?php echo $buttondis; ?> /><i class="fa fa-plus"></i><?php echo $strNewsAddButton; ?></button>
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
		<form class="form-horizontal" name="delfm" method="post" action="index.php">
			<table class="table table-bordered table-hover tc-table tc-gallery">
				<thead>
		  			<tr> 
					    <th class="col-mini center"><?php echo $strSel; ?></th>
					    <th class="col-small center" style="cursor:pointer" onClick="ordsc('id','<?php echo $sc; ?>')"><?php echo $strNewsList2; ordsc( $ord, "id", $sc );?></th>
					    <th class="col-mini center hidden-xs"><?php echo $strNewsList3; ?> </th>
					    <th class="col-width center" style="cursor:pointer" onClick="ordsc('title','<?php echo $sc; ?>')"><?php echo $strNewsList4; ordsc( $ord, "title", $sc );?></th>
					    <th class="col-medium center hidden-xs"><?php echo $strNewsCatTitle; ?></th>
					    <th class="col-medium center hidden-xs"><?php echo $strNewsFBR; ?></th>
					    <th class="col-medium center hidden-xs" style="cursor:pointer" onClick="ordsc('dtime','<?php echo $sc; ?>')"><?php echo $strFbtime; ordsc( $ord, "dtime", $sc );?></td>
					    <th class="col-mini center hidden-xs"><?php echo $strNewsCheck; ?></th>
					    <th class="col-mini center hidden-xs"><?php echo $strNewsList6; ?></th>
					    <th class="col-mini center hidden-xs"><?php echo $strNewsList7; ?></th>
					    <th class="col-mini center hidden-xs"><?php echo $strSecure; ?></th>
					    <th class="col-mini center hidden-xs" style="cursor:pointer" onclick="ordsc('xuhao','<?php echo $sc; ?>')"><?php echo $strXuhao; ordsc( $ord, "xuhao", $sc );?></th>
					    <th class="col-mini center hidden-xs"><?php echo $strReflesh; ?></th>
					    <th class="col-mini center"><?php echo $strNewsList9; ?></th>
				    </tr>
				</thead>
				<tbody>
    
<?php
$msql->query( "select * from {P}_news_con where {$scl}  order by {$ord} {$sc}  limit {$pagelimit}" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$catid = $msql->f( "catid" );
		$memberid = $msql->f( "memberid" );
		$title = $msql->f( "title" );
		$xuhao = $msql->f( "xuhao" );
		$cl = $msql->f( "cl" );
		$tj = $msql->f( "tj" );
		$ifbold = $msql->f( "ifbold" );
		$ifred = $msql->f( "ifred" );
		$iffb = $msql->f( "iffb" );
		$author = $msql->f( "author" );
		$src = $msql->f( "src" );
		$type = $msql->f( "type" );
		$secure = $msql->f( "secure" );
		$uptime = $msql->f( "uptime" );
		$dtime = $msql->f( "dtime" );
		$uptime = date( "Y/m/d", $uptime );
		$dtime = date( "Y/m/d", $dtime );
		if ( $ifred == "0" )
		{
				$tcolor = "#555";
		}
		else
		{
				$tcolor = $ifred;
		}
		if ( $ifbold == "0" )
		{
				$tbold = "nomal";
		}
		else
		{
				$tbold = "bold";
		}
		if ( $catid == "0" )
		{
				$cat = $strNewsBlog;
		}
		else
		{
				/*$fsql->query( "select cat from {P}_news_cat where catid='{$catid}'" );
				if ( $fsql->next_record( ) )
				{
						$cat = $fsql->f( "cat" );
				}*/
				
				$cat = $catlist[$catid];
		}
		$browseurl = ROOTPATH."news/html/?".$id.".html";
		echo " 
    <tr> 
      <td class=\"col-mini center\">
      		<label class=\"tcb-inline\" style=\"margin-right:0;\">
				<input type=\"checkbox\" class=\"tc\" name=\"dall[]\" value=\"".$id."\"><span class=\"labels\"></span>
			</label>
      </td>
      <td class=\"col-small center\"> ".$id." </td>
      <td class=\"col-mini center hidden-xs\">";
		if ( $src == "" )
		{
			echo "<img src='images/noimage.gif' >";
		}
		else
		{
			echo "<a href=\"\" onclick=\"callcolorbox('".ROOTPATH.$src."'); return false;\" ><img src='images/image.gif' ></a>";
		}
		echo " 
      </td>
      <td class=\"col-width center\"><a href=\"".$browseurl."\" target=\"_blank\" style=\"color:".$tcolor.";font-weight:".$tbold."\">".$title."</a></td>
      <td class=\"col-medium center hidden-xs\">".$cat."</td>
      <td class=\"col-medium center hidden-xs\">".$author."</td>
      <td class=\"col-medium center hidden-xs\">".$dtime."</td>
      <td class=\"col-mini center hidden-xs\">";
		showyn( $iffb );
		echo "</td>
      <td class=\"col-mini center hidden-xs\"> ";
		showyn( $tj );
		echo " </td>
      <td class=\"col-mini center hidden-xs\"> ";
		showyn( $ifbold );
		echo " </td>
      <td class=\"col-mini center hidden-xs\"> ".$secure."</td>
      <td class=\"col-mini center hidden-xs\">".$xuhao." </td>
      <td class=\"col-mini center hidden-xs\"><img src=\"images/update.png\"  style=\"cursor:pointer\" onclick=\"self.location='index.php?step=refresh&id=".$id."'\" /> </td>
      <td class=\"col-mini center\"><img src=\"images/edit.png\" style=\"cursor:pointer\"  onclick=\"window.location='news_conmod.php?id=".$id."&pid=".$pid."&page=".$page."'\" /></td>
      </tr>
    ";
}
?>
</tbody>
<tfoot>
<tr>
	<td colspan="20" class="footable-visible">
				<div class="tcb">
					<label class="tcb-inline">
						<input type="checkbox" class="tc" name="SELALL" value="1" onClick="SelAll(this.form)"><span class="labels"> <?php echo $strSelAll; ?></span>
					</label>
					<label class="tcb-inline">
						<input type="radio" class="tc" name="step" value="delall"><span class="labels"> <?php echo $strDelete; ?></span>
					</label>
					<label class="tcb-inline"><input type="radio" class="tc" name="step" value="setfb" checked><span class="labels"></span>
						<select name="iffb" id="iffb">
							<option value="1"><?php echo $strNewsFb; ?></option>
							<option value="0"><?php echo $strNewsNotFb; ?></option>
						</select>
					</label>
					<label class="tcb-inline"><input type="radio" class="tc" name="step" value="settj"><span class="labels"></span>
						<select name="tj" id="tj">
							<option value="1"><?php echo $strNewsTj; ?></option>
							<option value="0"><?php echo $strNewsNotTj; ?></option>
						</select>
					</label>
					<label class="tcb-inline"><input type="radio" class="tc" name="step" value="setsecure"><span class="labels"></span>
						<select name="secure" id="secure">
							<option value="0"><?php echo $strSecure1; ?></option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
						</select>
					</label>
					<label class="tcb-inline"><input type="radio" class="tc" name="step" value="setbold"><span class="labels"></span>
						<select name="bold" id="bold">
							<option value="1"><?php echo $strNewsBold; ?></option>
							<option value="0"><?php echo $strNewsNotBold; ?></option>
						</select>
					</label>
					<label class="tcb-inline"><input type="radio" class="tc" name="step" value="setcolor"><span class="labels"> <?php echo $strDefColor; ?></span>  
						<select name="nowcolor" id="nowcolor">
							<option value="0"><?php echo $strDefColor; ?></option>
							<option value="#ff0000" style="background:#ff0000">&nbsp;</option>
							<option value="#ff6600" style="background:#ff6600">&nbsp;</option>
							<option value="#0080c0" style="background:#0080c0">&nbsp;</option>
							<option value="#008000" style="background:#008000">&nbsp;</option>
							<option value="#ffcc00" style="background:#ffcc00">&nbsp;</option>
							<option value="#800080" style="background:#800080">&nbsp;</option>
							<option value="#804040" style="background:#804040">&nbsp;</option>
							<option value="#ff00ff" style="background:#ff00ff">&nbsp;</option>
							<option value="#80ffff" style="background:#80ffff">&nbsp;</option>
							<option value="#000000" style="background:#000000">&nbsp;</option>
						</select>
					</label>
					<input class="btn btn-sm btn-inverse" type="button" value="<?php echo $strSubmit; ?>" onClick="delfm.submit()">
					<input type="hidden" name="page" size="3" value="<?php echo $page; ?>" />
					<input type="hidden" name="ord" size="3" value="<?php echo $ord; ?>" />
					<input type="hidden" name="sc" size="3" value="<?php echo $sc; ?>" />
					<input type="hidden" name="key" size="3" value="<?php echo $key; ?>" />
					<input type="hidden" name="showtj" value="<?php echo $showtj; ?>" />
					<input type="hidden" name="showfb" value="<?php echo $showfb; ?>" />
					<input type="hidden" name="pid" value="<?php echo $pid; ?>" />
					<input type="hidden" name="shownum" value="<?php echo $shownum; ?>" /> 
					</td>
				</tr>
			</table>
  		</form>
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
	<script src="../../base/admin/assets/js/plugins/colorBox/jquery.colorbox-min.js"></script>

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
			$('#pagetitle', window.parent.document).html('文章管理 <span class="sub-title" id="subtitle">文章列表</span>');
			//呼叫左側功能選單
			$().getMenuGroup('news');
		});
	</script>
		
	<script>
        $(document).ready(function() {
			$("td").on("click",function () {
        		var tt = $("#right-wrapper").outerHeight()+ 230;
				$('#mainframe', window.parent.document).height(tt);
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
		}//colorbox end
		
		$('#nowcolor').ek_colorpicker();

		
    </script>
    
	<script>
	function Dpop(url,w,h){
		res = showModalDialog(url, null, 'dialogWidth: '+w+'px; dialogHeight: '+h+'px; center: yes; resizable: no; scroll: no; status: no;');
	 	if(res=="ok"){window.location.reload();}
	 
	}
	function ordsc(nn,sc){
	if(nn!='<?php echo $ord; ?>'){
		window.location='index.php?page=<?php echo $page; ?>&sc=<?php echo $sc; ?>&pid=<?php echo $pid; ?>&showtj=<?php echo $showtj; ?>&showfb=<?php echo $showfb; ?>&shownum=<?php echo $shownum; ?>&ord='+nn;
	}else{
		if(sc=='asc' || sc==''){
		window.location='index.php?page=<?php echo $page; ?>&sc=desc&pid=<?php echo $pid; ?>&showtj=<?php echo $showtj; ?>&showfb=<?php echo $showfb; ?>&shownum=<?php echo $shownum; ?>&ord='+nn;
		}else{
		window.location='index.php?page=<?php echo $page; ?>&sc=asc&pid=<?php echo $pid; ?>&showtj=<?php echo $showtj; ?>&showfb=<?php echo $showfb; ?>&shownum=<?php echo $shownum; ?>&ord='+nn;
		}
	}
	}

	function SelAll(theForm){
			for ( i = 0 ; i < theForm.elements.length ; i ++ )
			{
				if ( theForm.elements[i].type == "checkbox" && theForm.elements[i].name != "SELALL" )
				{
					theForm.elements[i].checked = ! theForm.elements[i].checked ;
				}
			}
	}

	</script>
</body>
</html>