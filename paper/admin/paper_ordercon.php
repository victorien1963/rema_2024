<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/adminpages.inc.php" );
include( "language/".$sLan.".php" );
needauth( 816 );
#---------------------------------------------#

$page = $_REQUEST['page'];
$step = $_REQUEST['step'];
$id = $_REQUEST['id'];
$key = $_REQUEST['key'];
$showorder = $_REQUEST['showorder'];
$showmem = $_REQUEST['showmem'];
$showmemtype = $_REQUEST['showmemtype'];
$shownum = $_REQUEST['shownum'];
$sc = $_REQUEST['sc'];
$ord = $_REQUEST['ord'];

if ( !isset( $showmem ) || $showmem == "" )
{
				$pid = "all";
}
if ( !isset( $shownum ) || $shownum < 10 )
{
				$shownum = 10;
}

if($step == "addmem"){
$msql->query( "select memberid,membertypeid,email from {P}_member where email<>'' " );
while( $msql->next_record( ) ){
	$email = $msql->f( "email" );
	$memberid = $msql->f( "memberid" );
	$membertypeid = $msql->f( "membertypeid" );
	$nowtime = time();
	$fsql->query( "select id,is_member,email,member_type from {P}_paper_order where email='{$email}'" );
	if($fsql->next_record( )){
		if( $fsql->f( "is_member" ) == "0" ){
			$fsql->query( "UPDATE {P}_paper_order SET is_member='1',member_id='{$memberid}',member_type='{$membertypeid}',order_cat='all',dtime='{$nowtime}' where email='{$email}'" );
		}elseif($fsql->f( "is_member" ) != $membertypeid){
			$fsql->query( "UPDATE {P}_paper_order SET member_type='{$membertypeid}' where email='{$email}'" );
		}
	}else{
			$fsql->query( "INSERT INTO {P}_paper_order SET is_member='1',member_id='{$memberid}',member_type='{$membertypeid}',order_cat='all',email='{$email}' ,dtime='{$nowtime}' " );
			}	
	}
}

if ( $step == "setorder" )
{
				trylimit( "_paper_order", 10, "id" );
				$dall = $_POST['dall'];
				$nums = sizeof( $dall );
				$isorder = $_POST['order'];
				for ( $i = 0;	$i < $nums;	$i++	)
				{
								$ids = $dall[$i];
								$nowtime = time();
								$getmid = $msql->getone( "SELECT member_id FROM {P}_paper_order where id='{$ids}'" );
								
								//exit("///".$getmid[member_id]);
								
								$msql->query( "update {P}_paper_order set is_order='{$isorder}',dtime='{$nowtime}' where id='{$ids}'" );
								$msql->query( "update {P}_member set order_epaper='{$isorder}' where memberid='{$getmid[member_id]}'" );
				}
}
if ( $step == "delall" )
{
				trylimit( "_paper_order", 10, "id" );
				$dall = $_POST['dall'];
				$nums = sizeof( $dall );
				for ( $i = 0;	$i < $nums;	$i++	)
				{
					$ids = $dall[$i];
					$msql->query( "delete from {P}_paper_order where id='{$ids}'" );
				}
				
				//載入 delemail.csv 刪除電子報寄送錯誤之信件 2019-11-07 11:30
				/*if( $nums == 0){
					$file = fopen("delemail.csv","r");
					while(! feof($file))
					{
						$getcsvs = fgetcsv($file);
					  	//var_dump($getcsvs[1]);
					  	if($getcsvs[1]){
					  		//刪除訂閱資料
					  		$msql->query( "delete from {P}_paper_order where email='{$getcsvs[1]}'" );
					  		//刪除會員資料
					  		$gmid = $msql->getone( "SELECT memberid from {P}_member where email='{$getcsvs[1]}'" );
					  		$delmemberid = $gmid["memberid"];
					  		//var_dump($delmemberid);
					  		$msql->query( "delete from {P}_member_rights where memberid='{$delmemberid}'" );
							$msql->query( "delete from {P}_member_nums where memberid='{$delmemberid}'" );
							$msql->query( "delete from {P}_member_fav where memberid='{$delmemberid}'" );
							$msql->query( "delete from {P}_member_pay where memberid='{$delmemberid}'" );
							$msql->query( "delete from {P}_member_buylist where memberid='{$delmemberid}'" );
							$msql->query( "delete from {P}_member where memberid='{$delmemberid}'" );
					  	}
					}
					fclose($file);
				}*/
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
				$scl .= " and (email regexp '{$key}') ";
}
if ( $showmemtype != "" && $showmemtype != "all" )
{
				$scl .= " and member_type='{$showmemtype}' ";
}
if ( $showmem != "" && $showmem != "all" )
{
				$scl .= " and is_member='{$showmem}' ";
}
if ( $showorder != "" && $showorder != "all" )
{
				$scl .= " and is_order='{$showorder}' ";
}

$totalnums = tblcount( "_paper_order", "id", $scl );
$pages = new pages( );
$pages->setvar( array(
				"shownum" => $shownum,
				"showmemtype" => $showmemtype,
				"sc" => $sc,
				"ord" => $ord,
				"showmem" => $showmem,
				"showorder" => $showorder,
				"key" => $key
) );
$pages->set( $shownum, $totalnums );
$pagelimit = $pages->limit( );
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
					<form method="get" action="paper_ordercon.php" class="form-inline pull-left" role="form">
						<div class="form-group">
							<select name="pid" class="form-control">
								<option value='all'><?php echo $strPaperSelMem;?></option>
								<option value="1" <?php echo seld( $showmem, "1" );?>><?php echo $strPaperIsMember;?></option>
          						<option value='0'<?php echo seld( $showmem, "0" );?>><?php echo $strPaperNoMember;?></option>
							</select>
						</div>
						<div class="form-group">
							<select name="showmemtype" class="form-control">
								<option value="all"><?php echo $strPaperSelMemType;?></option>
								<?php
								$fsql->query( "select membertypeid,membertype from {P}_member_type order by membertypeid" );
								while ( $fsql->next_record( ) )
								{
									$membertypeid = $fsql->f( "membertypeid" );
									$membertype = $fsql->f( "membertype" );

									if ( $showmemtype == $membertypeid )
									{
										echo "<option value='".$membertypeid."' selected>".$membertype."</option>";
									}
									else
									{
										echo "<option value='".$membertypeid."'>".$membertype."</option>";
									}
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<select name="showorder" class="form-control">
								<option value="all" ><?php echo $strPaperSelOrder; ?></option>
								<option value="1" <?php echo seld( $showorder, "1" );?>><?php echo $strPaperSelOrderYes;?></option>
          						<option value="0" <?php echo seld( $showorder, "0" );?>><?php echo $strPaperSelOrderNo;?></option>
							</select>
						</div>
						<div class="form-group">
							<select name="shownum" class="form-control">
								<option value="10"  <?php echo seld( $shownum, "10" ); ?>><?php echo $strPaperSelNum10; ?></option>
								<option value="20" <?php echo seld( $shownum, "20" ); ?>><?php echo $strPaperSelNum20; ?></option>
								<option value="30" <?php echo seld( $shownum, "30" ); ?>><?php echo $strPaperSelNum30; ?></option>
								<option value="50" <?php echo seld( $shownum, "50" ); ?>><?php echo $strPaperSelNum50; ?></option>
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
						<button type="button" onClick="window.location='paper_ordercon.php?step=addmem'" class="btn btn-primary btn-line" <?php echo $buttondis; ?> /><i class="fa fa-plus"></i><?php echo $strAddMember; ?></button>
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
		<form class="form-horizontal" name="delfm" method="post" action="paper_ordercon.php">
			<table class="table table-bordered table-hover tc-table tc-gallery">
				<thead>
		  			<tr> 
					    <th class="col-mini center"><?php echo $strSel; ?></th>
					    <th class="col-small center" style="cursor:pointer" onClick="ordsc('id','<?php echo $sc; ?>')"><?php echo $strPaperList2; ordsc( $ord, "id", $sc );?></th>
					    <th class="col-medium center" style="cursor:pointer" onClick="ordsc('is_member','<?php echo $sc; ?>')"><?php echo $strPaperMember;ordsc( $ord, "is_member", $sc );?></th>
					    <th class="col-medium center hidden-xs" style="cursor:pointer" onClick="ordsc('member_type','<?php echo $sc; ?>')"><?php echo $strPaperMemberType;ordsc( $ord, "member_type", $sc );?></th>
					    <th class="col-medium center hidden-xs"><?php echo $strPaperEmail; ?></th>
					    <th class="col-medium center hidden-xs" style="cursor:pointer" onClick="ordsc('dtime','<?php echo $sc; ?>')"><?php echo $strUptime; ordsc( $ord, "dtime", $sc );?></td>
					    <th class="col-small center hidden-xs"><?php echo $strPaperOkOrder;?></th>
				    </tr>
				</thead>
				<tbody>
<?php
$msql->query( "select * from {P}_paper_order where {$scl} order by {$ord} {$sc}  limit {$pagelimit}" );
while ( $msql->next_record( ) )
{
				$id = $msql->f( "id" );
				$ismember = $msql->f( "is_member" );
				$membertype = $msql->f( "member_type" );
				
								$fsql->query( "select membertype from {P}_member_type where membertypeid='{$membertype}'" );
								if ( $fsql->next_record( ) )
								{
												$membertype = $fsql->f( "membertype" );
								}else{
												$membertype = "---";
								}
				
				$memberid = $msql->f( "member_id" );
				$isorder = $msql->f( "is_order" );
				$email = $msql->f( "email" );
				$dtime = date( "Y/m/d H:i:s", $msql->f( "dtime" ) );
				echo " 
				<tr> 
					<td> 
						<input type=\"checkbox\" name=\"dall[]\" value=\"".$id."\" />
					</td>
					<td>".$id."</td>
					<td>";
				if ( $ismember == "0" )
				{
					echo "<img src='images/toolbar_no.gif' align='absmiddle' />&nbsp;".$strPaperNoMember;
				}
				else
				{
					echo "<img src='images/toolbar_ok.gif' align='absmiddle' />&nbsp;".$strPaperIsMember." (ID:".$memberid.")";
				}
				echo "</td>
					<td>".$membertype."</td>
					<td>".$email."</td>
					<td>".$dtime."</td>
					<td>";
      			showyn( $isorder );
      			echo "</td></tr>";
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
					<label class="tcb-inline"><input type="radio" class="tc" name="step" value="setorder" checked><span class="labels"></span>
						<select name="order" id="order">
							<option value="1"><?php echo $strPaperOkOrder;?></option>
           					<option value="0"><?php echo $strPaperNoOrder;?></option>
						</select>
					</label>
					<input class="btn btn-sm btn-inverse" type="button" value="<?php echo $strSubmit; ?>" onClick="delfm.submit()">
					<input type="hidden" name="page" size="3" value="<?php echo $page;?>" />
			        <input type="hidden" name="ord" size="3" value="<?php echo $ord;?>" />
			        <input type="hidden" name="sc" size="3" value="<?php echo $sc;?>" />
			        <input type="hidden" name="key" size="3" value="<?php echo $key;?>" />
			        <input type="hidden" name="showorder" value="<?php echo $showorder;?>" />
			        <input type="hidden" name="showmem" value="<?php echo $showmem;?>" />
			        <input type="hidden" name="showmemtype" value="<?php echo $showmemtype;?>" />
			        <input type="hidden" name="shownum" value="<?php echo $shownum;?>" />
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
	<script src="js/paper.js"></script>
		
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>電子報</li>');
			$('#pagetitle', window.parent.document).html('電子報管理 <span class="sub-title" id="subtitle">訂閱管理</span>');
			//呼叫左側功能選單
			$().getMenuGroup('paper');
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
		
				//colorbox function
		function callcolorboxhref(href){
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
		
		$('#nowcolor').ek_colorpicker();

		
    </script>
    
	<script>
	function Dpop(url,w,h){
		res = showModalDialog(url, null, 'dialogWidth: '+w+'px; dialogHeight: '+h+'px; center: yes; resizable: no; scroll: no; status: no;');
	 	if(res=="ok"){window.location.reload();}
	 
	}
	
	function ordsc(nn,sc){
		if(nn!='<?php echo $ord;?>'){
			window.location='paper_ordercon.php?page=<?php echo $page;?>&sc=<?php echo $sc;?>&showmem=<?php echo $showmem;?>&showmemtype=<?php echo $showmemtype;?>&showorder=<?php echo $showorder;?>&shownum=<?php echo $shownum;?>&ord='+nn;
		}else{
			if(sc=='asc' || sc==''){
			window.location='paper_ordercon.php?page=<?php echo $page;?>&sc=desc&showmem=<?php echo $showmem;?>&showmemtype=<?php echo $showmemtype;?>&showorder=<?php echo $showorder;?>&shownum=<?php echo $shownum;?>&ord='+nn;
			}else{
			window.location='paper_ordercon.php?page=<?php echo $page;?>&sc=asc&showmem=<?php echo $showmem;?>&showmemtype=<?php echo $showmemtype;?>&showorder=<?php echo $showorder;?>&shownum=<?php echo $shownum;?>&ord='+nn;
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