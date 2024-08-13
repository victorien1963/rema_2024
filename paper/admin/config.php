<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
NeedAuth(817);
#-------------------------------------------------#

$step=$_REQUEST["step"];

if($step=="modify"){
	$var=$_POST["var"];
	while (list($key,$val)=each($var)){
		$msql->query("update {P}_paper_config set value='$val' where variable='$key'");
	}
	
	//記錄多國翻譯資料
	$langlist = $_REQUEST['langlist'];
	if($langlist != ""){		
		$lans = explode(",",$langlist);
		foreach($lans AS $ks=>$vs){
			$glan = "var_".$vs;
			$var=$_POST[$glan];
			while (list($key,$val)=each($var)){
				//擷取各語言資料並寫入
				$msql->query("update {P}_paper_config_translate set value='$val' where variable='$key' and langcode='{$vs}'");
			}
		}
	}//多國
	
	SayOk($strConfigOk,"config.php","");
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
<div class="tc-tabs">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" class="tab" data-toggle="tab"><i class="fa fa-pencil bigger-130"></i> 預設參數</a></li>
			<!-- 擷取語言表 -->
			<?php
				$tb = "2";
				$msql->query( "SELECT * FROM {P}_base_language WHERE ifshow='1' AND ifdefault='0' ORDER BY xuhao asc" );
				while ( $msql->next_record( ) )
				{
					$lid = $msql->f( "id" );
					$ltitle = $msql->f( "title" );
					$langcode = $msql->f( "langcode" );
					$src = ROOTPATH.$msql->f( "src" );
			?>
				<li><a href="#tab<?php echo $tb; ?>" class="tab" data-toggle="tab"><img src="<?php echo $src; ?>" height="18"/> <?php echo $ltitle; ?>參數</a></li>
			<?php
				$tb++;
			}
			?>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
		<!-- Tab1 開始 -->
		
<div class="row">
	<div class="col-lg-12">
		<div class="portlet">

			<div id="f-1" class="panel-collapse collapse in">
				<div  class="portlet-body no-padding">
					<form name="form1" method="post" action="config.php">
						<table class="table table-bordered table-striped table-hover tc-table table-primary footable" data-page-size="50">
							<thead>
								<tr>
									<td class="center" data-sort-ignore="true"><?php echo $strConfigName; ?></td>
									<td class="center col-sm-4" data-sort-ignore="true"><?php echo $strConfigSet; ?></td>
								</tr>
							</thead>
							<tbody>
           
<?php
$msql->query("select * from {P}_paper_config  order by xuhao");
	while($msql->next_record()){
		$variable=$msql->f('variable');
		$value=$msql->f('value');
		$vname=$msql->f('vname');
		$settype=$msql->f('settype');
		$colwidth=$msql->f('colwidth');
		$intro=$msql->f('intro');
		$intro=str_replace("\n","<br>",$intro);
?> 
	<tr> 
		<td>
			<strong><?php echo $vname; ?> : </strong><br /><?php echo $intro; ?>
		</td>
		<td   width="300" height="20">
			<?php
				if($settype=="YN"){
					echo '
					<input type="radio" class="tc" name="var['.$variable.']" value="1" '.checked($value,"1").'><span class="labels">'.$strYes.' </span>
					<input type="radio" class="tc" name="var['.$variable.']" value="0" '.checked($value,"0").'><span class="labels">'.$strNo.' </span>
					';
				}elseif($settype=="textarea"){
					echo '
					<textarea name="var['.$variable.']" cols="'.$colwidth.'" rows="5" class="form-control textarea" >'.$value.'</textarea>
					';
				}elseif($settype=="pass"){
					echo '
					<input  type="password" name="var['.$variable.']"   value="'.$value.'" size="'.$colwidth.'" class="form-control" />
					';
				}else{
					echo '
					<input  type="text" name="var['.$variable.']"   value="'.$value.'" size="'.$colwidth.'" class="form-control" />
					';
			}
			?>
		</td>
	</tr>
<?php
	}
?> 
						</tbody>
						<tfoot>
							<tr>
								<td colspan="7">
									<input name="cc2" type="submit" id="cc" value="<?php echo $strSubmit; ?>" class="btn btn-inverse pull-right" />
									<input type="hidden" name="step" value="modify" />
								</td>
							</tr>
						</tfoot>
    </table>
				</div>
			</div>
		</div>
	</div>
</div>
	
			<!-- Tab1 結束 -->
		</div>
			<!-- 擷取語言表 -->
			<?php
				$tbs = "2";
				$msql->query( "SELECT * FROM {P}_base_language WHERE ifshow='1' AND ifdefault='0' ORDER BY xuhao asc" );
				while ( $msql->next_record( ) )
				{
					$lid = $msql->f( "id" );
					$ltitle = $msql->f( "title" );
					$langcode = $msql->f( "langcode" );
					$src = ROOTPATH.$msql->f( "src" );
					$langlist .= $langlist? ",".$langcode:$langcode;
			?>
				<div class="tab-pane" id="tab<?php echo $tbs; ?>">
					<!-- Tab<?php echo $tbs; ?> 開始 -->
						<table class="table table-bordered table-striped table-hover tc-table table-primary footable" data-page-size="50">
							<thead>
								<tr>
									<td class="center" data-sort-ignore="true"><?php echo $strConfigName; ?></td>
									<td class="center col-sm-4" data-sort-ignore="true"><?php echo $strConfigSet; ?></td>
								</tr>
							</thead>
							<tbody>
           
<?php
$fsql->query("select * from {P}_paper_config_translate where langcode='{$langcode}'");
if(!$fsql->next_record()){
	//複製多語言使用之設置參數
	$tsql->query("INSERT INTO {P}_paper_config_translate (xuhao, vname, settype, colwidth, variable, value, intro, langcode) 
    SELECT xuhao, vname, settype, colwidth, variable, value, intro, '{$langcode}'
    FROM {P}_paper_config 
    WHERE variable='ChannelName'");
}
$fsql->query("select * from {P}_paper_config_translate where langcode='{$langcode}' order by xuhao");
while($fsql->next_record()){
	$variable=$fsql->f('variable');
	$value=$fsql->f('value');
	$vname=$fsql->f('vname');
	$settype=$fsql->f('settype');
	$colwidth=$fsql->f('colwidth');
	$intro=$fsql->f('intro');
	$intro=str_replace("\n","<br>",$intro);
?> 
	<tr> 
		<td>
			<strong><?php echo $vname; ?> : </strong><br /><?php echo $intro; ?>
		</td>
		<td   width="300" height="20">
			<?php
				if($settype=="YN"){
					echo '
					<input type="radio" class="tc" name="var_'.$langcode.'['.$variable.']" value="1" '.checked($value,"1").'><span class="labels"> '.$strYes.' </span> 
					<input type="radio" class="tc" name="var_'.$langcode.'['.$variable.']" value="0" '.checked($value,"0").'><span class="labels"> '.$strNo.' </span>
					';
				}elseif($settype=="textarea"){
					echo '
					<textarea name="var_'.$langcode.'['.$variable.']" cols="'.$colwidth.'" rows="5" class="form-control textarea" >'.$value.'</textarea>
					';
				}else{
					echo '
					<input  type="text" name="var_'.$langcode.'['.$variable.']"   value="'.$value.'" size="'.$colwidth.'" class="form-control" />
					';
			}
			?>
		</td>
	</tr>
<?php
	}
?> 
						</tbody>
						<tfoot>
							<tr>
								<td colspan="7">
									<input type="hidden" name="langlist" value="<?php echo $langlist; ?>" />
									<input name="cc2" type="submit" value="<?php echo $strSubmit; ?>" class="btn btn-inverse pull-right" />
								</td>
							</tr>
						</tfoot>
    				</table>
					<!-- Tab<?php echo $tbs; ?> 結束 -->
				</div>
			<?php
				$tbs++;
			}
			?>

					</form>
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
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>電子報</li>');
			$('#pagetitle', window.parent.document).html('電子報管理 <span class="sub-title" id="subtitle">模組設置</span>');
			//呼叫左側功能選單
			$().getMenuGroup('paper');
		});
	</script>
	<script>
        $(document).ready(function() {
        	$(".tab").click(function () {
        		setTimeout(function () {
                     window.parent.doIframe();
                 }, 0);
        	});
		});
    </script>
  </body>
</html>