<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include_once( ROOTPATH."includes/data.inc.php" );
include( "language/".$sLan.".php" );
needauth( 2 );
$sourcefold = ROOTPATH.'/cache/datasql/';
$delsql = $_GET[delsql];
$insertsql = $_GET[insertsql];
if($delsql){
@unlink($sourcefold.$delsql);
sayok( $strDataBackDel, "", "" );
}
if($insertsql){
	$sql_file = $sourcefold.$insertsql;
	$tablepre = $TablePre;
	if ( file_exists( $sql_file ) ) {
					$sql_query = fread( fopen( $sql_file, "r" ), filesize( $sql_file ) );
					if ( get_magic_quotes_runtime( ) == 1 )
					{
						$sql_query = stripslashes( $sql_query );
					}
					$sql_query = trim( $sql_query );
					$sql_query = remove_remarks( $sql_query );
					$pieces = split_sql_file( $sql_query, ";" );
					$pieces_count = count( $pieces );
					$i = 0;
					for ( ;	$i < $pieces_count;	++$i	)
					{
						$a_sql_query = trim( $pieces[$i] );
						if ( !empty( $a_sql_query ) && $a_sql_query[0] != "#" )
							{
								//$a_sql_query = str_replace( "dev_", $tablepre."_", $a_sql_query );
								$result = mysql_query( $a_sql_query );
					}
					}

	}else{err( $strPlusNotice5, "", "" );}


sayok( $strDataUseOk, "", "" );
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
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fonts.css">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
	
	<!-- PAGE LEVEL PLUGINS STYLES -->
	<link rel="stylesheet" href="assets/css/plugins/footable/footable.min.css">
		
	<!-- REQUIRE FOR SPEECH COMMANDS -->
	<link rel="stylesheet" type="text/css" href="assets/css/plugins/gritter/jquery.gritter.css" />	

    <!-- Tc core CSS -->
	<link id="qstyle" rel="stylesheet" href="assets/css/themes/style.css">	
	
    <!-- Add custom CSS here -->

	<!-- End custom CSS here -->
	
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
    
    <script>
		function cm(nn){
			var qus=confirm("<?php echo $strDeleteConfirm; ?>")
			if(qus!=0){
				window.location='database.php?delsql='+nn;
			}
		}
		function cmstyle(ss){
			var qus=confirm("<?php echo $strDataConfirm; ?>")
			if(qus!=0){
				window.location='database.php?insertsql='+ss;
			}
		}
	</script>
    
  </head>

  <body style="background-color:#f5f5f5;">
	<div id="right-wrapper">
<!-- START MAIN PAGE CONTENT -->

<?php
$sourcefold = ROOTPATH.'/cache/datasql/';
$style_backup = scandir( $sourcefold );
array_shift($style_backup);array_shift($style_backup);

				echo "<div class=\"formzone\">
<div class=\"namezone\" style=\"float:left\">".$strDataBackUp."</div><div class=\"addnew\" onClick=\"window.location='database_modbackup.php'\" id=\"addsubbutton\">".$strDataBackUp."</div>
<div class=\"tablezone\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" >
  <tr> 
    <td class=\"innerbiaoti\" align=\"center\" height=\"28\" width=\"15%\" >".$strNumber."</td><td class=\"innerbiaoti\" align=\"center\" height=\"28\" width=\"20%\" >".$strBpname."</td><td class=\"innerbiaoti\" align=\"center\" height=\"28\" width=\"30%\" >".$strBptime."</td><td class=\"innerbiaoti\" align=\"center\" height=\"28\" width=\"20%\" >".$strDataUse."</td><td class=\"innerbiaoti\" align=\"center\" height=\"28\" width=\"15%\" >".$strDelete."</td>";
				if($style_backup){
				foreach($style_backup as $key=>$s){
					$key = $key+1;
					$sname[$key] = substr($s,11,9);
					$stime[$key] =  date('Y/m/d H:i:s',substr($s,0,10));
	echo "<tr class=\"list\"><td  height=\"26\" width=\"15%\" align=\"center\">".$key."</td><td  height=\"26\"  width=\"20%\" align=\"center\">".$sname[$key]."</td><td  height=\"26\" width=\"30%\" align=\"center\">".$stime[$key]."</td><td  height=\"26\" width=\"20%\" align=\"center\"><img id='insert_sql' class='pdv_enter' src=\"images/update.png\"  style=\"cursor:pointer\"  border=\"0\"  onClick=\"cmstyle('".$s."')\"/></td><td  height=\"26\" width=\"15%\" align=\"center\"><img src=\"images/delete.png\"  style=\"cursor:pointer\" onClick=\"cm('".$s."')\" /> 
<td></tr>";
}}
echo "</table>";
?>

<!-- END MAIN PAGE CONTENT -->
	</div> 
	
	
	<!-- core JavaScript -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/js/plugins/pace/pace.min.js"></script>
	<script src="assets/js/plugins/iframeautoheight/jquery.autoheight.js"></script>

		
	<!-- Themes Core Scripts -->	
	<script src="assets/js/main.js"></script>
		
	<!-- wayhunt & module -->
	<script src="../../base/js/form.js"></script>
	<script src="js/frame.js"></script>
	<script>
		$(document).ready(function(){
			//載入時隱藏已跳出之選單(手機模式)
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="index.php">Home</a></li><li class="active">設置</li>');
			$('#pagetitle', window.parent.document).html('系統設置 <span class="sub-title" id="subtitle">資料庫備份</span>');
			//呼叫左側功能選單-參數帶入模組英文名稱
			$().getMenuGroup("config");
		});
	</script>
	<!-- PAGE LEVEL PLUGINS JS -->
	<script src="assets/js/plugins/footable/footable.min.js"></script>
	
	<script src="assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="assets/js/plugins/datatables/datatables.js"></script>
	<script src="assets/js/plugins/datatables/datatables.responsive.js"></script>
	
	<!-- REQUIRE FOR SPEECH COMMANDS -->
	<script src="assets/js/speech-commands.js"></script>
	<script src="assets/js/plugins/gritter/jquery.gritter.min.js"></script>		

	<!-- initial page level scripts for examples -->
	<script src="assets/js/plugins/slimscroll/jquery.slimscroll.init.js"></script>
	<script src="assets/js/plugins/footable/footable.init.js"></script>
	<script src="assets/js/plugins/datatables/datatables.init.js"></script>
		
	<script type="text/javascript">

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
	</script>

		
  </body>
</html>