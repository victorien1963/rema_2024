<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/upload.inc.php" );
needauth( 1 );


#-------------------------------------------------#

$step = $_REQUEST['step'];

if ( $step == "modify" )
{
		//上傳網站地圖
		$file = $_FILES['file'];
		$fileurl = $_POST['fileurl'];
		$oldfileurl = $fileurl;
		if ( 0 < $file['size'] )
		{
						$Meta = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
						$picpath = ROOTPATH."sitemaps";
						createFolderdDIR( $picpath );
						$uppath = "sitemaps";
						$filearr = newuploadfile( $file['tmp_name'], $file['type'], $file['name'], $file['size'], $uppath );
						if ( $filearr[0] != "err" )
						{
										$fileurl = $filearr[3];
						}
						else
						{
										echo $Meta.$filearr[1];
										exit( );
						}
						if ( file_exists( ROOTPATH.$oldfileurl ) && $oldfileurl != "" && !strstr( $oldfileurl, "../" ) )
						{
										unlink( ROOTPATH.$oldfileurl );
						}
		}
		$msql->query( "UPDATE {P}_base_config SET value='{$fileurl}' WHERE  variable='SiteMap'" );

		$var = $_POST['var'];
		while ( list( $key, $val ) = each($var) )
		{
			
				//$val = addslashes($val);
				
				//FTP POS 上傳
				/*if( $key == "ftpConnect"){
					$val == "0";
				}*/
				
				if ( $key === 'BTSCRIPT' ) {
					// echo '[Test]' . $val . '<br>' . $key;
				}
				else {
					$msql->query( "UPDATE {P}_base_config SET value='{$val}' WHERE variable='{$key}'" );
				}
				
				//FTP POS 上傳
				if( $key == "ftpConnect" && $val == "1"){
					//$cbnsg = updateposdata();
					if($cbnsg == true){
						$strConfigOk .= "銷退貨 上傳FTP 成功 SUCCESS！";
					}else{
						$strConfigOk .= "銷退貨 上傳FTP 失敗 ERROR(".$cbnsg.")！";
					}
				}
				
				
				//記錄多國翻譯資料
				$langlist = $_REQUEST['langlist'];
				if($langlist != ""){		
					$lans = explode(",",$langlist);
					foreach($lans AS $ks=>$vs){
						$glan = "var_".$vs;
						$vars=$_POST[$glan];
						while (list($key,$val)=each($vars)){
							//擷取各語言資料並寫入
							$msql->query("update {P}_base_config_translate set value='$val' where variable='$key' and langcode='{$vs}'");
						}
					}
				}//多國
				
				//修改 config.inc.php預設語言檔
				/*if($key == "LANTYPE"){
					$orilan = $_POST["orilan"];
					$filename = ROOTPATH."config.inc.php";
					$handle = fopen($filename,"r");
					while (!feof($handle)) {
						$data .= fgets($handle);
			        }
			        fclose($handle);
			        $handle = fopen($filename,"w");
			        $data = str_replace("zh_".$orilan."","zh_".$val."",$data);
					$iflock && flock($handle,LOCK_EX);
					fwrite($handle,$data);
					fclose($handle);
					$chmod && @chmod($filename,0777);
					
					//修改預設語言檔檔名/
					if($orilan != $val){
						$fileList=glob(ROOTPATH."*");
						for ($i=0; $i<count($fileList); $i++) {
							if(is_dir($fileList[$i])){
								$gg = glob($fileList[$i]."/*");
								foreach($gg AS $islan){
									if(strpos($islan,"language") !== false){
										@rename($islan."/zh_".$orilan.".php",$islan."/zh_".$val.".php");
									}
									if(strpos($islan,"admin") !== false){
										@rename($islan."/language/zh_".$orilan.".php",$islan."/language/zh_".$val.".php");
									}
								}
							}
						}
					}
					$newlan = $val;
				}*/
				
				//複製新語言檔
				/*if($key == "OTHLANTYPE" && $val){
					$arrlan = explode(",",$val);
					$fileList=glob(ROOTPATH."*");
					for ($i=0; $i<count($fileList); $i++) {
						if(is_dir($fileList[$i])){
							$gg = glob($fileList[$i]."/*");
							foreach($gg AS $islan){
								if(strpos($islan,"language") !== false){
									foreach($arrlan AS $getlan){
										if(!is_file($islan."/zh_".$getlan.".php")){
											@copy($islan."/zh_".$newlan.".php",$islan."/zh_".$getlan.".php");
										}
									}
									
								}
								if(strpos($islan,"admin") !== false){
									foreach($arrlan AS $getlan){
										if(!is_file($islan."/language/zh_".$getlan.".php")){
											@copy($islan."/language/zh_".$newlan.".php",$islan."/language/zh_".$getlan.".php");
										}
									}
								}
								if($islan == ROOTPATH."base/templates"){
									foreach($arrlan AS $getlan){
										if(!is_file($islan."/header_".$getlan.".htm")){
											copy($islan."/header.htm",$islan."/header_".$getlan.".htm");
										}
										if(!is_file($islan."/foot_".$getlan.".htm")){
											copy($islan."/foot.htm",$islan."/foot_".$getlan.".htm");
										}
									}
								}
							}
						}
					}
				}*/
			
		}
		
		sayok( $strConfigOk, "config.php", "" );
}
if ( $msql->dbencode( ) )
{
		$msql->query( "update {P}_base_config set value='' where variable='safecode'" );
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
					<form name="form1" method="post" enctype="multipart/form-data" action="config.php">
						<table class="table table-bordered table-striped table-hover tc-table table-primary footable" data-page-size="50">
    							<thead>
									<tr>
										<th class="center" data-sort-ignore="true"><?php echo $strConfigName; ?></th>
										<th class="center col-sm-4" data-sort-ignore="true"><?php echo $strConfigSet; ?></th>
									</tr>
								</thead>
								<tbody> 
<?php
$msql->query( "select * from {P}_base_config where settype!='code' AND variable!='SiteMap' order by xuhao" );
while ( $msql->next_record( ) )
{
		$variable = $msql->f( "variable" );
		$value = $msql->f( "value" );
		$vname = $msql->f( "vname" );
		$settype = $msql->f( "settype" );
		$colwidth = $msql->f( "colwidth" );
		$intro = $msql->f( "intro" );
		$intro = str_replace( "\n", "<br>", $intro );
		echo " 
            <tr class=\"list\"> 
              <td style=\"line-height:20px;padding-right:30px\">
             <strong>".$vname." : </strong><br>".$intro."</td>
              <td  style=\"max-width:450px;width:450px;\" height=\"20\"> 
        ";
		if ( $settype == "YN" )
		{
			if($variable != "ftpConnect"){
				echo " 
                <input type=\"radio\" name=\"var[".$variable."]\" value=\"1\" ".checked( $value, "1" )." class=\"tc\"><span class=\"labels\"> ".$strYes."</span> <input type=\"radio\" name=\"var[".$variable."]\" value=\"0\" ".checked( $value, "0" )." class=\"tc\"><span class=\"labels\"> ".$strNo."</span>";
            }else{
            	echo " 
                <input type=\"radio\" name=\"var[".$variable."]\" value=\"1\" ".checked( $value, "1" )." class=\"tc\"><span class=\"labels\"> 連接</span> <input type=\"radio\" name=\"var[".$variable."]\" value=\"0\" ".checked( $value, "0" )." class=\"tc\"><span class=\"labels\"> 關閉</span>";
            }
		}
		
		
		else if ( $settype == "ownersys" )
		{
				echo "
				  <select name=\"var[".$variable."]\" >
                  <option value=\"0\" ".seld( $value, 0 )." >".$strEmailSys0."</option>
				  <option value=\"1\" ".seld( $value, 1 )." >".$strEmailSys1."</option>
                  <option value=\"2\" ".seld( $value, 2 ).">".$strEmailSys2."</option>
               	  </select>
                ";
		}
		elseif ( $settype == "text" )
		{
				echo " <textarea name=\"var[".$variable."]\" cols=\"".$colwidth."\" rows=\"5\" class=\"form-control textarea\"/>".$value."</textarea>";
		}
		else
		{
				echo " 
                <input  type=\"text\" name=\"var[".$variable."]\"   value=\"".$value."\" size=\"".$colwidth."\" class=\"form-control\" />
                ";
                if($variable == "LANTYPE"){
                	echo "<input type=\"hidden\" name=\"orilan\" value=\"".$value."\" />";
                }
		}
		echo "</td></tr>";
}
?> 
            <tr class="list"> 
              <td   style="line-height:20px;padding-right:30px">
				<strong><?php echo $strSiteXML; ?> : </strong><br><?php echo $strSiteXMLNote; ?></td>
              <td  style="max-width:450px;width:450px;" height="20"> 
				<?php
				$msql->query( "select value from {P}_base_config where variable='SiteMap'" );
				if ( $msql->next_record( ) )
				{
					$fileurl = $msql->f( "value" );
				}
				?>
		<div class="input-group" id="divsuo" style='display:none'>
			<span class="input-group-btn">
				<span class="btn btn-file" > 瀏覽檔案<input type="file" name="file" /></span>
			</span>
			<input type="text" class="form-control" readonly="">
		</div>
					
		<input id="divurl" type="text" name="fileurl" value="<?php echo $fileurl; ?>" class="form-control" />
		<div class="space-4"></div>
		<label><input type="radio" name="addtype" class="tc" value="addurl" checked onClick="document.getElementById('divurl').style.display='inline';document.getElementById('divsuo').style.display='none';">
		<span class="labels"> <?php echo $strDownAddUrl; ?></span></label>
		<label><input type="radio" name="addtype" class="tc" value="addfile" onClick="document.getElementById('divurl').style.display='none';document.getElementById('divsuo').style.display='table';">
		<span class="labels"> <?php echo $strDownAddUpload; ?></span></label>
              </td>
            </tr>
						</tbody>
								<tfoot>
									<tr>
										<td colspan="7">
											<input name="cc2" type="submit" id="cc" value="<?php echo $strSubmit; ?>" class="btn btn-inverse pull-right" />
  											<input type="hidden" name="step" value="modify" />
										</td>
									</tr>
									<!--tr>
										<td colspan="7">
											<ul class="hide-if-no-paging pagination pagination-centered pull-right"></ul>
											<div class="clearfix"></div>
										</td>
									</tr-->
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
$fsql->query("select * from {P}_base_config_translate where langcode='{$langcode}'");
if(!$fsql->next_record()){
	//複製多語言使用之設置參數
	$tsql->query("INSERT INTO {P}_base_config_translate (xuhao, vname, settype, colwidth, variable, value, intro, langcode) 
    SELECT xuhao, vname, settype, colwidth, variable, value, intro, '{$langcode}'
    FROM {P}_base_config 
    WHERE variable='SiteName' 
    OR variable='SiteInfo' 
    OR variable='SiteKeywords' 
    ");
}
$fsql->query("select * from {P}_base_config_translate where langcode='{$langcode}' order by xuhao");
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
					<input type="radio" class="tc" name="var_'.$langcode.'['.$variable.']" value="1" '.checked($value,"1").'><span class="labels">'.$strYes.' </span>
					<input type="radio" class="tc" name="var_'.$langcode.'['.$variable.']" value="0" '.checked($value,"0").'><span class="labels">'.$strNo.' </span>
					';
				}elseif($settype=="text"){
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
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/js/plugins/pace/pace.min.js"></script>
		
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
			$('#pagetitle', window.parent.document).html('系統設置 <span class="sub-title" id="subtitle">網站參數設置</span>');
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
		
		/*$(document).ready(function() {
        	$(".tab").click(function () {
        		setTimeout(function () {
                     window.parent.doIframe();
                 }, 0);
        	});
		});*/
	</script>
	<script src="assets/js/plugins/iframeautoheight/iframeResizer.contentWindow.min.js"></script>
		
  </body>
</html>