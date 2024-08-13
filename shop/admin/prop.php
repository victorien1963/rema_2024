<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
NeedAuth(0);
#---------------------------------------------#

$step=$_REQUEST["step"];
$id=$_REQUEST["id"];
$propname=$_REQUEST["propname"];
$xuhao=$_REQUEST["xuhao"];
$catid=$_REQUEST["catid"];
$pid=$_REQUEST["pid"];

if($step=="copy"){
	
		$msql->query("delete from {P}_shop_prop where catid='$catid'");
		//多語言
		$fsql->query( "delete from {P}_shop_prop_translate where pid='{$catid}'" );
		$p=1;
		$msql->query("select * from {P}_shop_prop where catid='$pid'");
		while($msql->next_record()){
			$projid = $msql->f( "id" );
			$propname=$msql->f("propname");
			$xuhao=$msql->f("xuhao");

			$fsql->query("insert into {P}_shop_prop values(
			0,
			'$catid',
			'$propname',
			'$xuhao'
			)");
			//多語言
			$getprojid = $fsql->instid();
			$wsql->query( "select * from {P}_shop_prop_translate where pid='{$projid}'" );
			while ( $wsql->next_record( ) )
			{
				$propname = $wsql->f( "propname" );
				$langcode = $wsql->f( "langcode" );
				$fsql->query( "insert into {P}_shop_prop_translate values(
				0,
				'{$getprojid}',
				'{$langcode}',
				'{$propname}'
				)" );
			}
		$p++;
		}
	
}
if ( $step == "copytoall" )
{
				$msql->query( "select catid from {P}_shop_cat" );
				while ( $msql->next_record( ) )
				{
					$getcatid = $msql->f( "catid" );
					if($getcatid != $catid){
						$fsql->query( "delete from {P}_shop_prop where catid='{$getcatid}'" );
						//多語言
						$fsql->query( "delete from {P}_shop_prop_translate where pid='{$getcatid}'" );

						$tsql->query( "select * from {P}_shop_prop where catid='{$catid}'" );
						while ( $tsql->next_record( ) )
						{
								$projid = $tsql->f( "id" );
								$propname = $tsql->f( "propname" );
								$xuhao = $tsql->f( "xuhao" );
								$fsql->query( "insert into {P}_shop_prop values(
								0,
								'{$getcatid}',
								'{$propname}',
								'{$xuhao}'
								)" );
								//多語言
								$getprojid = $fsql->instid();
								$wsql->query( "select * from {P}_shop_prop_translate where pid='{$projid}'" );
								while ( $wsql->next_record( ) )
								{
									$propname = $wsql->f( "propname" );
									$langcode = $wsql->f( "langcode" );
									$fsql->query( "insert into {P}_shop_prop_translate values(
									0,
									'{$getprojid}',
									'{$langcode}',
									'{$propname}'
									)" );
								}
						}
					}
				}
}
if ( $step == "copytosub" )
{
		$msql->query( "select * from {P}_shop_prop where catid='{$catid}' order by xuhao" );
		while ( $msql->next_record( ) )
		{
				$arr['projid'][] = $msql->f( "id" );
				$arr['propname'][] = $msql->f( "propname" );
				$arr['xuhao'][] = $msql->f( "xuhao" );
		}
		$nums = sizeof( $arr['propname'] );
		$msql->query( "select * from {P}_shop_cat where pid='{$catid}'" );
		while ( $msql->next_record( ) )
		{
				$subcatid = $msql->f( "catid" );
				$fsql->query( "delete from {P}_shop_prop where catid='{$subcatid}'" );
				//多語言
				$fsql->query( "delete from {P}_shop_prop_translate where pid='{$catid}'" );
				$i = 0;
				for ( ;	$i < $nums;	$i++	)
				{
						$p = $arr['propname'][$i];
						$x = $arr['xuhao'][$i];
						$tsql->query( "insert into {P}_shop_prop set
							`catid`='{$subcatid}',
							`propname`='{$p}',
							`xuhao`='{$x}'
						" );
						//多語言
						$getprojid = $tsql->instid();
						$projid = $arr['projid'][$i];
						$wsql->query( "select * from {P}_shop_prop_translate where pid='{$projid}'" );
						while ( $wsql->next_record( ) )
						{
							$propname = $wsql->f( "propname" );
							$langcode = $wsql->f( "langcode" );
							$fsql->query( "insert into {P}_shop_prop_translate values(
							0,
							'{$getprojid}',
							'{$langcode}',
							'{$propname}'
							)" );
						}
				}
		}
}

if($step=="add"){
	$msql->query("select count(id) from {P}_shop_prop where catid='$catid'");
	if($msql->next_record()){
		$count=$msql->f('count(id)');
	}
	if($propname==""){
		PopBack($strColPropNotice1,"prop.php?catid=$catid&pid=$pid");
	}
	if($count>=20){
		PopBack($strColPropNotice2,"prop.php?catid=$catid&pid=$pid");
	}


	$msql->query("select max(xuhao) from {P}_shop_prop where catid='$catid' ");
	if($msql->next_record()){
		$max=$msql->f('max(xuhao)');
	}

	$max=$max+1;
	$msql->query("insert into {P}_shop_prop values(
	0,
	'$catid',
	'$propname',
	'$max'
	)");
}

if($step=="modify"){
	$msql->query("update {P}_shop_prop set propname='$propname',xuhao='$xuhao' where id='$id'");
//記錄多國翻譯資料
	$langlist = $_REQUEST['langlist'];
	if($langlist != ""){			
		$spropname = $_REQUEST['spropname'];
		$lans = explode(",",$langlist);
		foreach($lans AS $ks=>$vs){
			//擷取各語言資料並寫入
			$propnames = htmlspecialchars($spropname[$vs]);
				//getupdate 資料若存在則更新，否則新增
				$msql->getupdate(
					"SELECT id FROM {P}_shop_prop_translate WHERE pid='{$id}' AND langcode='{$vs}'",
					"UPDATE {P}_shop_prop_translate SET 
					propname='{$propnames}' WHERE pid='{$id}' AND langcode='{$vs}'",
					"INSERT INTO {P}_shop_prop_translate SET 
					pid='{$id}',
					langcode='{$vs}',
					propname='{$propnames}'"
				);
				
		}
	}//多國
}
if($step=="del"){
	$msql->query("delete from {P}_shop_prop where id='$id'");
	$msql->query("delete from {P}_shop_prop_translate where pid='$id'");
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
		<h5 class="heading text-uppercase"><i class="fa fa-th"></i> <?php echo $strColPropTitle; ?></h5>
		<div class="well white">
			<form method="get" action="prop.php" class="form-horizontal">
				<input type="hidden" name="catid" value="<?php echo $catid; ?>" />
				<input type="hidden" name="pid" value="<?php echo $pid; ?>" />
				<input type="hidden" name="step" value="add">
				<div class="form-group">
					<label class="row col-sm-2 control-label"><?php echo $strColPropAdd; ?>： </label>
					<div class="col-sm-10">
						<div class="col-xs-3">
							<input type="text" name="propname" size="20" class="form-control">
						</div>
						<input type="submit" name="Submit" value="<?php echo $strAdd; ?>" class="btn btn-primary">
				<?php
					if($pid!=0){
				?>
						<input type="button" name="cc2" value="<?php echo $strColPropCopy; ?>" onClick="self.location='prop.php?step=copy&pid=<?php echo $pid; ?>&catid=<?php echo $catid; ?>'" class="btn btn-info">
				<?php
					echo "<input class=\"btn btn-info\" type=\"button\" name=\"cc3\" value=\"複製到下一級分類\" onClick=\"self.location='prop.php?step=copytosub&pid=".$pid."&catid=".$catid."'\" class=\"button\">";
					echo "&nbsp;&nbsp;<input class=\"btn btn-success\" type=\"button\" name=\"cc3\" value=\"複製到所有分類\" onClick=\"self.location='prop.php?step=copytoall&pid=".$pid."&catid=".$catid."'\" class=\"button\">";
				}else
				{
					echo "<input class=\"btn btn-info\" type=\"button\" name=\"cc3\" value=\"複製到下一級分類\" onClick=\"self.location='prop.php?step=copytosub&pid=".$pid."&catid=".$catid."'\" class=\"button\">";
					echo "&nbsp;&nbsp;<input class=\"btn btn-success\" type=\"button\" name=\"cc3\" value=\"複製到所有分類\" onClick=\"self.location='prop.php?step=copytoall&pid=".$pid."&catid=".$catid."'\" class=\"button\">";
				}
				?>
					</div>
				</div>
			</form>
		</div>

		<div class="well white">
              <table width="98%" border="0" cellspacing="1" cellpadding="2" align="center" class="table table-hover tc-table tc-gallery">
                <tr> 
                  <th class="col-mini center"><?php echo $strNumber; ?></th>
                  <th class="col-mini center"><?php echo $strXuhao; ?></th>
                  <th class="col-width"><?php echo $strColPropName; ?></th>
                  <th class="col-mini center"><?php echo $strModify; ?></th>
                  <th class="col-mini center"><?php echo $strDelete; ?></th>
                </tr>
                <?php
					$msql->query("select * from {P}_shop_prop where catid='$catid' order by xuhao");
					$i=1;
					while($msql->next_record()){
						$id=$msql->f("id");
						$propname=$msql->f("propname");
						$xuhao=$msql->f("xuhao");
				?> 
				<tr> 
					<td class="col-mini center"><?php echo "$i"; ?></td>
					<form method="get" action="prop.php">
					<td class="col-mini center"> 
						<input type="text" name="xuhao" value="<?php echo $xuhao; ?>"  class="form-control">
					</td>
					<td class="col-width">
						<div class="form-group">
							<label class="row col-sm-2 control-label text-right" style="width:10%">預設：</label>
							<div class="row col-sm-10">
								<input type="text" name="propname" value="<?php echo $propname; ?>"  class="form-control">
							</div>
							<div class="portlet-widgets pull-right" style="margin-right:10px;">
								<a data-toggle="collapse" data-parent="#accordion_<?php echo $id; ?>" href="#l_<?php echo $id; ?>"><i class="fa fa-chevron-up"> 多語言</i></a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div id="l_<?php echo $id; ?>" class="panel-collapse collapse">
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
								$langs = $tsql->getone( "SELECT * FROM {P}_shop_prop_translate WHERE pid='{$id}' AND langcode='{$langcode}'" );
						?>
							<div class="form-group">
								<label class="row col-sm-2 control-label text-right" style="width:10%"><?php echo $ltitle; ?>：</label>
								<div class="row col-sm-10">
									<input type="text" class="form-control" name="spropname[<?php echo $langcode; ?>]" id="spropname_<?php echo $langs['id']; ?>" value="<?php echo $langs['propname']; ?>">
								</div>
								<div class="clearfix"></div>
							</div>
						<?php
							}
						?>
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<input type="hidden" name="catid" value="<?php echo $catid; ?>">
						<input type="hidden" name="pid" value="<?php echo $pid; ?>">
						<input type="hidden" name="step" value="modify">
						<input type="hidden" name="langlist" value="<?php echo $langlist; ?>" />
					</td>
					<td class="col-mini center"> 
						<div align="CENTER"> 
							<input type="submit" name="cc" value="<?php echo $strModify; ?>" class="btn btn-inverse">
						</div>
					</td>
					<td class="col-mini center"> 
						<input type="button" name="cc" value="<?php echo $strDelete; ?>" onClick="self.location='prop.php?step=del&pid=<?php echo $pid; ?>&catid=<?php echo $catid; ?>&id=<?php echo $id; ?>'" class="btn btn-danger">
					</td>
				</form>
				</tr>
                <?php
$i++;
}
?> 
              </table>
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

  </body>
</html>