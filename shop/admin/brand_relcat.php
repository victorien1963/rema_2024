<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 0 );
#---------------------------------------------#
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
<form id="brcForm" action="" method="post">
<div class="row">
	<div class="col-lg-12">									
		<div class="portlet">
			<div id="f-1" class="panel-collapse collapse in">
				<div class="portlet-body">
					<div class="pull-left">
						<label class="tcb-inline" style="margin-right:0;">
							<input type="checkbox" class="tc" name="selall" id="selall"  value="1"><span class="labels"> <?php echo $strSelAll;?></span>
							<div  id="notice" class="noticediv"></div>
						</label>
					</div>
					<div class="pull-right">
						<button type="submit" id="saverelcat" name="saverelcat" class="btn btn-primary btn-line" /><i class="fa fa-plus"></i><?php echo $strSave; ?></button>
  						<input type="button" id="closerelcat" class="btn btn-primary btn-line" value="<?php echo $strClose;?>" />
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>
	  
	  

<div class="selall">

	<div class="dd">
		<ol class="dd-list">
			
<?php
$brandid = $_REQUEST['brandid'];
$msql->query( "select * from {P}_shop_cat order by catpath" );
while ( $msql->next_record( ) )
{
		$catid = $msql->f( "catid" );
		$cat = $msql->f( "cat" );
		$catpath = $msql->f( "catpath" );
		$padding = strlen( $catpath ) * 4;
		
		$nestable = strlen( $catpath )/5;
		
		$idpath = substr( str_replace( ":", "_", $catpath ), 0, 0 - 1 );
		$fsql->query( "select id from {P}_shop_brandcat where `brandid`='{$brandid}' and `catid`='{$catid}' limit 0,1" );
		if ( $fsql->next_record( ) )
		{
				$chkstr = "checked";
		}
		else
		{
				$chkstr = "";
		}
		
		if($nestable == 1){
			echo "<li class=\"dd-item dd-colored\" data-id=\"".$catid."\">
					<div class=\"dd-handle dd2-handle btn-success\">
						<label class=\"tcb-inline\" style=\"margin-right:0;\">
							<input name=\"c[]\" type=\"checkbox\" id=\"_".$idpath."\" class=\"tc relcheck\" value=\"".$catid."\"  ".$chkstr." /><span class=\"labels\"></span>
						</label>
					</div>
					<div class=\"dd2-content btn-success\">
						".$cat."
					</div>
				</li>";
		}else{
			echo "<li class=\"dd-item dd2-item\" data-id=\"".$catid."\" style=\"padding-left:".($padding+(($nestable-2)*10))."px;\">
					<div class=\"dd-handle dd2-handle btn-white\"  style=\"left: auto;\">
						<label class=\"tcb-inline\" style=\"margin-right:0;\">
							<input name=\"c[]\" type=\"checkbox\" id=\"_".$idpath."\" class=\"tc relcheck\" value=\"".$catid."\"  ".$chkstr." /><span class=\"labels\"></span>
						</label>
					</div>
					<div class=\"dd2-content btn-white\">
						".$cat."
					</div>
				</li>";
		}
		/*echo "<div style=\"height:22px;padding-left:".$padding."px\">
	<input name=\"c[]\" type=\"checkbox\" id=\"_".$idpath."\" class=\"relcheck\" value=\"".$catid."\"  ".$chkstr." /> ".$cat."	</div>";*/
}
?>
<input name="brandid" type="hidden" id="brandid" value="<?php echo $brandid;?>" />
<input name="act" type="hidden" id="act" value="setbrandrelcat" />
</form>
	</ol>
</div>

<!-- END MAIN PAGE CONTENT -->
</div>
	<!-- core JavaScript -->
    <script src="../../base/admin/assets/js/jquery.min.js"></script>
    <script src="../../base/admin/assets/js/bootstrap.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/pace/pace.min.js"></script>
	<script src="../../base/admin/assets/js/plugins/iframeautoheight/jquery.autoheight.js"></script>
	
	<!-- PAGE LEVEL PLUGINS JS -->
	<script src="../../base/admin/assets/js/plugins/jquery-nestable/jquery.nestable.js"></script>
		
	<!-- Themes Core Scripts -->	
	<script src="../../base/admin/assets/js/main.js"></script>
	<script src="../../base/admin/assets/js/plugins/colorBox/jquery.colorbox-min.js"></script>
		
	<!-- wayhunt & module -->
	<script src="../../base/js/form.js"></script>
	<script src="../../base/js/custom.js"></script>
	<script src="js/brand.js"></script>
		

  </body>
</html>