<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/adminpages.inc.php" );
include( "func/upload.inc.php" );
include( "language/".$sLan.".php" );
NeedAuth(0);
/*if($_COOKIE["SYSUSER"] == "wayhunt"){
	$msql->query( "SELECT src FROM {P}_shop_pages where id>'1200' and id<='1300'" );
	while($msql->next_record()){
		$src = $msql->f("src");
		$srcs = dirname($src)."/sp_".basename($src);
		if($src){
			ImageResize(ROOTPATH.$src,ROOTPATH.$srcs,600,600,'100');
		}
	}
}*/

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

$isdiscshow = $_REQUEST['isdiscshow'];
$issubshow = $_REQUEST['issubshow'];

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
if($step != ""){
	NeedAuth(317);
}
if ( $step == "saletag" )
{
		trylimit( "_shop_con", 30, "id" );
		
		$_saletag = $_REQUEST['saletag'];
		foreach($_saletag as $keyr => $val){
			if($val != 0){}
				$msql->query( "update {P}_shop_con set saletag='{$val}' where id='{$keyr}'" );
		}
}
if ( $step == "setfb" )
{
		trylimit( "_shop_con", 30, "id" );
		$dall = $_POST['dall'];
		$nums = sizeof( $dall );
		$iffb = $_POST['iffb'];		
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_shop_con set iffb='{$iffb}' where id='{$ids}'" );
		}
}
if ( $step == "settj" )
{
		trylimit( "_shop_con", 30, "id" );
		$dall = $_POST['dall'];
		$tj = $_POST['tj'];
		$nums = sizeof( $dall );		
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_shop_con set tj='{$tj}' where id='{$ids}'" );
		}
}
if ( $step == "paixu" )
{
		trylimit( "_shop_con", 30, "id" );
		$dall = $_POST['dall'];
		$newxuhao = $_POST['newxuhao'];
		$nums = sizeof( $dall );		
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_shop_con set xuhao='{$newxuhao}' where id='{$ids}'" );
		}
}
if ( $step == "setbold" )
{
		trylimit( "_shop_con", 30, "id" );
		$dall = $_POST['dall'];
		$bold = $_POST['bold'];
		$nums = sizeof( $dall );		
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_shop_con set ifbold='{$bold}' where id='{$ids}'" );
		}
}
if ( $step == "setcolor" )
{
		trylimit( "_shop_con", 30, "id" );
		$dall = $_POST['dall'];
		$nums = sizeof( $dall );
		$nowcolor = $_POST['nowcolor'];		
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_shop_con set ifred='{$nowcolor}' where id='{$ids}'" );
		}
}
if ( $step == "delall" )
{
		//trylimit( "_shop_con", 30, "id" );
		$dall = $_POST['dall'];
		$nums = sizeof( $dall );		
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "select src,body,canshu from {P}_shop_con where id='{$ids}'" );
				if ( $msql->next_record( ) )
				{
						$src = $msql->f( "src" );
						$src1 = dirname($src);
						$src2 = basename($src);
						$srcs = $src1."/sp_".$src2;
						if ( file_exists( ROOTPATH.$src ) && $src != "" )
						{
								unlink( ROOTPATH.$src );
								unlink( ROOTPATH.$srcs );
						}
												$body = $msql->f( "body" );
						$body1 = dirname($body);
						$body2 = basename($body);
						$bodys = $body1."/sp_".$body2;
						if ( file_exists( ROOTPATH.$body ) && $body != "" )
						{
								unlink( ROOTPATH.$body );
								unlink( ROOTPATH.$bodys );
						}
												$canshu = $msql->f( "canshu" );
						$canshu1 = dirname($canshu);
						$canshu2 = basename($canshu);
						$canshus = $canshu1."/sp_".$canshu2;
						if ( file_exists( ROOTPATH.$canshu ) && $canshu != "" )
						{
								unlink( ROOTPATH.$canshu );
								unlink( ROOTPATH.$canshus );
						}
				}
				$msql->query( "select src from {P}_shop_pages where gid='{$ids}'" );
				while ( $msql->next_record( ) )
				{
						$src = $msql->f( "src" );
						$src1 = dirname($src);
						$src2 = basename($src);
						$srcs = $src1."/sp_".$src2;
						if ( file_exists( ROOTPATH.$src ) && $src != "" )
						{
								unlink( ROOTPATH.$src );
								unlink( ROOTPATH.$srcs );
						}
				}
				$msql->query( "delete from {P}_shop_pages where gid='{$ids}'" );
				//$msql->query( "delete from {P}_comment where catid='11' and rid='{$ids}'" );
				$msql->query( "delete from {P}_shop_memberprice where gid='{$ids}'" );
				$msql->query( "delete from {P}_shop_con where id='{$ids}'" );
				$msql->query( "delete from {P}_shop_conspec where gid='{$ids}'" );
		}
}
if ( $step == "refresh" )
{
		$newtime = time( );
		$msql->query( "update {P}_shop_con set uptime='{$newtime}' where id='{$id}'" );
}

if ( $step == "copy" )
{		
		$newtime = time( );
		$msql->query( "select * from {P}_shop_con where  id='{$id}'" );
		

		if ( $msql->next_record( ) )
		{
			$id = $msql->f("id");
			$catid = $msql->f("catid");
			$subcatid = $msql->f("subcatid");
			$thirdcatid = $msql->f("thirdcatid");
			$fourcatid = $msql->f("fourcatid");
			$title = $msql->f("title");
			$memo = $msql->f("memo");
			$memotext = $msql->f("memotext");
			$afterSalesService = $msql->f("after_sales_service");
			$body = $msql->f("body");
			$mbody = $msql->f("mbody");
			$canshu = $msql->f("canshu");
			$xuhao = $msql->f("xuhao");
			$temperature = $msql->f("temperature");
			$ambience = $msql->f("ambience");
			$cl = $msql->f("cl");
			$tj = $msql->f("tj");
			$ifnew = $msql->f("ifnew");
			$ifred = $msql->f("ifred");
			$iffb = $msql->f("iffb");
			$src = $msql->f("src");
			$type = $msql->f("type");
			$author = $msql->f("author");
			$source = $msql->f("source");
			$secure = $msql->f("secure");
			$oldcatid = $msql->f("catid");
			$oldcatpath = $msql->f("catpath");
			$tags = $msql->f("tags");
			// $bn = $msql->f("bn");
			$bn = "";
			$posbn = "";
			// $posbn = $msql->f("posbn");
			$weight = $msql->f("weight");
			// $kucun = $msql->f("kucun");
			$kucun = 0;
			$cent = $msql->f("cent");
			$price = $msql->f("price");
			$price0 = $msql->f("price0");
			$brandid = $msql->f("brandid");
			$danwei = $msql->f("danwei");
			$dtime = $msql->f("dtime");
			$uptime = $msql->f("uptime");
			$oldproj = $msql->f("proj");

			$sizeitem = $msql->f("sizeitem");
			$mainsizetype = $msql->f("mainsizetype");
			$sizetype = $msql->f("sizetype");
			$usepicsize = $msql->f("usepicsize");

			$prop1 = $msql->f('prop1');
			$prop2 = $msql->f('prop2');
			$prop3 = $msql->f('prop3');
			$prop4 = $msql->f('prop4');
			$prop5 = $msql->f('prop5');
			$prop6 = $msql->f('prop6');
			$prop7 = $msql->f('prop7');
			$prop8 = $msql->f('prop8');
			$prop9 = $msql->f('prop9');
			$prop10 = $msql->f('prop10');
			$prop11 = $msql->f('prop11');
			$prop12 = $msql->f('prop12');
			$prop13 = $msql->f('prop13');
			$prop14 = $msql->f('prop14');
			$prop15 = $msql->f('prop15');
			$prop16 = $msql->f('prop16');
			$prop17 = $msql->f('prop17');
			$prop18 = $msql->f('prop18');
			$prop19 = $msql->f('prop19');
			$prop20 = $msql->f('prop20');
			$a_body = $msql->f('a_body');
			$b_body = $msql->f('b_body');
			$c_body = $msql->f('c_body');
			$d_body = $msql->f('d_body');

			$colorname = $msql->f("colorname");
			$colorcode = $msql->f("colorcode");
			$colorpic = $msql->f("colorpic");
			$ifsub = $msql->f("ifsub");
			$subid = $msql->f("subid");

			$sizechart = $msql->f("sizechart");

			$ifpic = $msql->f("ifpic");
			$subpicid = $msql->f("subpicid");
			$starttime = $msql->f("starttime");
			$endtime = $msql->f("endtime");

			$desciption = $msql->f("desciption");
			$shape = $msql->f("shape");

		}
		$msql->query( "insert into {P}_shop_con set
			catid='{$catid}',
			catpath='{$catpath}',
			subcatid='{$subcatid}',
			subcatpath='{$subcatpath}',
			thirdcatid='{$thirdcatid}',
			thirdcatpath='{$thirdcatpath}',
			fourcatid='{$fourcatid}',
			fourcatpath='{$fourcatpath}',
			title='{$title}',
			body='{$body}',
			mbody='{$mbody}',
			canshu='{$canshu}',
			shape='{$shape}',
			dtime='{$dtime}',
			xuhao='{$xuhao}',
			cl='0',
			tj='0',
			iffb='1',
			ifbold='0',
			ifred='0',
			type='gif',
			src='{$src}',
			brandid='{$brandid}',
			bn='{$bn}',
			posbn='{$posbn}',
			price='{$price}',
			price0='{$price0}',
			danwei='{$danwei}',
			weight='{$weight}',
			kucun='{$kucun}',
			cent='{$cent}',
			uptime='{$dtime}',
			author='{$author}',
			source='{$source}',
			memberid='0',
			tags='{$tagstr}',
			secure='0',
			memo='{$memo}',
			memotext='{$memotext}',
			after_sales_service='{$afterSalesService}',
			temperature='{$temperature}',
			ambience='{$ambience}',
			prop1='{$prop1}',
			prop2='{$prop2}',
			prop3='{$prop3}',
			prop4='{$prop4}',
			prop5='{$prop5}',
			prop6='{$prop6}',
			prop7='{$prop7}',
			prop8='{$prop8}',
			prop9='{$prop9}',
			prop10='{$prop10}',
			prop11='{$prop11}',
			prop12='{$prop12}',
			prop13='{$prop13}',
			prop14='{$prop14}',
			prop15='{$prop15}',
			prop16='{$prop16}',
			prop17='{$prop17}',
			prop18='{$prop18}',
			prop19='{$prop19}',
			prop20='{$prop20}',
			proj='{$projpath}',
			isadd='{$isadd}',
			starttime='{$starttime}',
			endtime='{$endtime}',
			colorname='{$colorname}',
			colorcode='{$colorcode}',
			colorpic='{$src_colorpic}',
			ifsub='{$ifsub}',
			subid='{$subid}',
			ifpic='{$ifpic}',
			sizeitem='{$sizeitem}',
			sizetype='{$sizetypelist}',
			mainsizetype='{$mainsizetypelist}',
			subpicid='{$subpicid}',
			sizechart='{$sizechart}',
			usepicsize='{$usepicsize}',
			a_body='{$a_body}',
			b_body='{$b_body}',
			c_body='{$c_body}',
			d_body='{$d_body}',
			desciption='{$desciption}' 
		" );
		$gid = $msql->instid( );
		if($gid) {
			echo "<script>alert('複製成功編號:$gid');</script>";
		}
		
}

if ( $step == "setdiscon" )
{
		$dall = $_POST['dall'];
		$discon = $_POST['discon'];
		$nums = sizeof( $dall );
		for ( $i = 0;	$i < $nums;	$i++	)
		{
			$ids = $dall[$i];
			//先取出原價格
			$msql->query ("select * from {P}_shop_con where id='$ids'");
			if($msql->next_record()){
				$oriprice = $msql->f('price0')!="" && $msql->f('price0')>0? $msql->f('price0'):$msql->f('price');
				$disprice = round($oriprice*$discon,0);
				//設定新價格
				if($discon == '1' || $discon == '1.0'){
					$fsql->query ("UPDATE {P}_shop_con SET price='{$oriprice}',price0='' where id='$ids'");
					$fsql->query( "UPDATE {P}_shop_conspec SET `sprice`='{$oriprice}' WHERE gid='{$ids}'" );
				}else{
					$fsql->query ("UPDATE {P}_shop_con SET price='{$disprice}',price0='{$oriprice}' where id='$ids'");
					$fsql->query( "UPDATE {P}_shop_conspec SET `sprice`='{$disprice}' WHERE gid='{$ids}'" );
				}
			}
		}
}

if ( $step == "setdisc" )
{
		trylimit( "_shop_con", 30, "id" );
		$dall = $_POST['dall'];
		$disc = $_POST['disc'];
		if($disc>0){
			$msql -> query ("select * from {P}_shop_promote where id='$disc'");
			if ($msql -> next_record ()) {
				$id = $msql -> f ('id');
				$discat = $msql -> f ('groupid');
				$disnum = $msql -> f ('num');
				$disprice = $msql -> f ('multiprice');
				$disrate = $discat==1? $msql -> f ('pricerate'):"";
			}
			$isdisc =1;
		}else{
			$isdisc =0;
		}

		$nums = sizeof( $dall );
			for ( $i = 0;	$i < $nums;	$i++	)
			{
				$ids = $dall[$i];
				$msql->query( "update {P}_shop_con set isdisc='{$isdisc}',discat='{$discat}',distype='{$disc}',disnum='{$disnum}',disrate='{$disrate}',disprice='{$disprice}' where id='{$ids}'" );
			}

}
/**/
if ( !isset( $ord ) || $ord == "" )
{
		//$ord = "xuhao";
		
		$ord = "id";
}
if ( !isset( $sc ) || $sc == "" )
{
		//$sc = "asc";
		
		$sc = "desc";
}
$scl = "  id!='0' ";
if ( $key != "" )
{
		$scl .= " and (id regexp '{$key}' or title regexp '{$key}' or body regexp '{$key}' or bn regexp '{$key}' or id regexp '{$key}' or posbn regexp '{$key}') ";
}
if ( $showtj != "" && $showtj != "all" )
{
		$scl .= " and tj='{$showtj}' ";
}
if ( $isdiscshow == "" || $isdiscshow == "all")
{
	
}elseif($isdiscshow == "1"){
	$scl .= " and isdisc='1' ";
}

if ( $issubshow == "" || $issubshow == "all")
{
	
}elseif($issubshow == "0"){
	$scl .= " and ifsub='0' and ifpic='0' ";
}elseif($issubshow == "1"){
	$scl .= " and ifsub='1' and ifpic='0' ";
}elseif($issubshow == "2"){
	$scl .= " and ifpic='1' ";
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
				//$scl .= " and catpath regexp '{$fmdpath}' ";
				$scl .=" and (catpath regexp '$fmdpath' or subcatpath regexp '$fmdpath' or thirdcatpath regexp '$fmdpath' or fourcatpath regexp '$fmdpath') ";
		}
}
$totalnums = tblcount( "_shop_con", "id", $scl );
$pages = new pages( );
$pages->setvar( array(
		"shownum" => $shownum,
		"pid" => $pid,
		"sc" => $sc,
		"ord" => $ord,
		"showtj" => $showtj,
		"showfb" => $showfb,
		"key" => $key,
		"isdiscshow" => $isdiscshow,
		"issubshow" => $issubshow
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
          						<option value='all'><?php echo $strShopSelCat;?></option>		   
          
<?php
$fsql->query( "select * from {P}_shop_cat order by catpath" );
while ( $fsql->next_record( ) )
{
		$lpid = $fsql->f( "pid" );
		$lcatid = $fsql->f( "catid" );
		$cat = $fsql->f( "cat" );
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

		if($pid == "all"){
			$showsort = "style='display:none;'";
			$showsortno = "display:none;";
		}
?>
							</select>
						</div>
						<!--div class="form-group">
							<select name="isdiscshow" class="form-control">
								<option value="all" <?php echo seld( $isdiscshow, "all" );?>>顯示所有商品</option>
								<option value="1" <?php echo seld( $isdiscshow, "1" );?>>只顯示促銷產品</option>
							</select>
						</div-->
						<div class="form-group">
							<select name="issubshow" class="form-control">
								<option value="all" <?php echo seld( $issubshow, "all" );?>>顯示所有商品</option>
								<option value="0" <?php echo seld( $issubshow, "0" );?>>只顯示主商品</option>
								<option value="1" <?php echo seld( $issubshow, "1" );?>>只顯示附屬商品</option>
								<option value="2" <?php echo seld( $issubshow, "2" );?>>只顯示配圖商品</option>
							</select>
						</div>
						<div class="form-group">
							<select name="showtj" class="form-control">
								<option value="all" ><?php echo $strShopSelTj;?></option>
								<option value="1"  <?php echo seld( $showtj, "1" );?>><?php echo $strShopSelTjYes;?></option>
								<option value="0" <?php echo seld( $showtj, "0" );?>><?php echo $strShopSelTjNo;?></option>
							</select>
						</div>
						<div class="form-group">
							<select name="showfb" class="form-control">
								<option value="all" ><?php echo $strShopSelFb;?></option>
								<option value="1"  <?php echo seld( $showfb, "1" );?>><?php echo $strShopSelFbYes;?></option>
								<option value="0" <?php echo seld( $showfb, "0" );?>><?php echo $strShopSelFbNo;?></option>
							</select>
						</div>
						<div class="form-group">
							<select name="shownum" class="form-control">
								<option value="10"  <?php echo seld( $shownum, "10" );?>><?php echo $strShopSelNum10;?></option>
								<option value="20" <?php echo seld( $shownum, "20" );?>><?php echo $strShopSelNum20;?></option>
								<option value="30" <?php echo seld( $shownum, "30" );?>><?php echo $strShopSelNum30;?></option>
								<option value="50" <?php echo seld( $shownum, "50" );?>><?php echo $strShopSelNum50;?></option>
								<option value="100" <?php echo seld( $shownum, "100" );?>><?php echo $strShopSelNum100;?></option>
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
						<button type="button" onClick="window.location='shop_conadd.php'" class="btn btn-primary btn-line" /><i class="fa fa-plus"></i><?php echo $strShopAddButton; ?></button>
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
						<th class="col-small center" style="cursor:pointer" onClick="ordsc('id','<?php echo $sc; ?>')"><?php echo $strShopList2; ordsc( $ord, "id", $sc );?></th>
					    <th class="col-mini center" style="cursor:pointer" onClick="ordsc('fourcatid asc, thirdcatid asc, subcatid asc, catid asc, xuhao','<?php echo $sc; ?>')">基本<?php echo $strXuhao; ordsc( $ord, "fourcatid asc, thirdcatid asc, subcatid asc, catid asc, xuhao", $sc );?></th>
						<th class="col-mini center" <?php echo $showsort; ?>>分類序號</th>
						<th class="col-mini center hidden-xs"><?php echo $strShopList3; ?> </th>
						<th class="col-medium center hidden-xs"><?php echo $strShopCat; ?> </th>
						<th class="col-small center" style="cursor:pointer" onClick="ordsc('bn','<?php echo $sc; ?>')"><?php echo $strGoodsBn; ordsc( $ord, "bn", $sc );?></th>
					    <th class="col-width center" style="cursor:pointer" onClick="ordsc('title','<?php echo $sc; ?>')"><?php echo $strShopList4; ordsc( $ord, "title", $sc );?></th>
					    <th class="col-small center" style="cursor:pointer" onClick="ordsc('colorname','<?php echo $sc; ?>')">顏色<?php ordsc( $ord, "colorname", $sc );?></th>
					    <th class="col-medium center" style="cursor:pointer" onClick="ordsc('starttime','<?php echo $sc; ?>')"><?php echo $strShopList15; ordsc( $ord, "starttime", $sc );?></th>
					    <th class="col-medium center" style="cursor:pointer" onClick="ordsc('endtime','<?php echo $sc; ?>')"><?php echo $strShopList16; ordsc( $ord, "endtime", $sc );?></th>
					    <th class="col-small center" style="cursor:pointer" onClick="ordsc('price','<?php echo $sc; ?>')"><?php echo $strGoodsPrice; ordsc( $ord, "price", $sc );?></th>
					    <th class="col-mini center" style="cursor:pointer" onClick="ordsc('salenums','<?php echo $sc; ?>')"><?php echo $strSaleNums; ordsc( $ord, "salenums", $sc );?></th>
					    <th class="col-mini center" style="cursor:pointer" onClick="ordsc('kucun','<?php echo $sc; ?>')"><?php echo $strGoodsKucun; ordsc( $ord, "kucun", $sc );?></th>
						<th class="col-mini center hidden-xs"><?php echo $strShopList14; ?> </th>
						<th class="col-mini center hidden-xs"><?php echo $strShopList6; ?> </th>
						<th class="col-mini center hidden-xs">複製</th>
						<th class="col-mini center hidden-xs"><?php echo $strReflesh; ?> </th>
						<th class="col-mini center hidden-xs"><?php echo $strShopList9; ?> </th>
					</tr>
				</thead>
				<tbody>
<?php
$msql->query( "select * from {P}_shop_con where {$scl}  order by {$ord} {$sc}  limit {$pagelimit}" );
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
		$bn = $msql->f( "bn" );
		$weight = $msql->f( "weight" );
		$kucun = $msql->f( "kucun" );
		$cent = $msql->f( "cent" );
		$price = $msql->f( "price" );
		$price0 = $msql->f( "price0" );
		$brandid = $msql->f( "brandid" );
		$danwei = $msql->f( "danwei" );
		$salenums = $msql->f( "salenums" );
		$uptime = date( "y/m/d", $uptime );
		$saletag = $msql->f( "saletag" )? "&nbsp;<img src='".ROOTPATH.$msql->f( "saletag" )."' height=32 align=\"absmiddle\"/>":"&nbsp;";
		$saletag1= $msql->f( "saletag" );
		$isdisc = $msql->f("isdisc");
		$discat = $msql->f("discat");
		$distype = $msql->f("distype");
		$disnum = $msql->f("disnum");
		$disrate = ($msql->f("disrate")*10)."折";
		$disprice = $msql->f("disprice");
		
		$colorname=$msql->f("colorname");
		$ifsub = $msql->f("ifsub") == "0"? " <i class='fa fa-check-circle text-info'></i>":"";
		
		
		$ifpic = $msql->f("ifpic");
		$subpicid = $msql->f("subpicid");
		
		if($ifpic == "1"){
			$ifsub=" <span style='color: red;'>[配圖商品]</span>";
			$getpicshop = $tsql->getone("SELECT bn,title,colorname FROM {P}_shop_con where id='$subpicid'");
			$bn = $getpicshop["bn"];
			$title = $getpicshop["title"];
			$colorname = $getpicshop["colorname"];
		}
		
		
		if($msql->f( "starttime" )){
			$starttime = date( "Y-m-d", $msql->f( "starttime" ) );
		}else{
			$starttime = "";
		}
		if($msql->f( "endtime" )){
			$endtime = date( "Y-m-d", $msql->f( "endtime" ) );
		}else{
			$endtime = "";
		}
		
		if($discat == 1){
			$promote ="<span style=\"color:blue\">".$disrate."促銷</span>";
		}else{
			$promote ="<span style=\"color:red;\">".$disnum."件".$disprice."元</span>";
		}
		if($isdisc=="1"){
			$mainflag=$promote;
		}else{
			$mainflag="";
		}
		//加入促銷標籤
		$select_tag = '<select name="saletag['.$id.']" id="saletag">';
		if($saletag1=="0" || $saletag1==""){
			$select_tag.="<option value='0'>促銷標籤</option>";
		}else{
			$fsql->query( "select * from {P}_shop_tag where src='$saletag1' " );
			if($fsql->next_record()){
				$tagname=$fsql->f('name');			
			}
			$select_tag.="<option value='".$saletag1."'>".$tagname."</option><option value='0'>促銷標籤</option>";
		}
		
		
		$fsql->query( "select * from {P}_shop_tag order by id" );
		while($fsql->next_record()){
			$tag_src=$fsql->f('src');
			$tag_name=$fsql->f('name');
		
		$select_tag.="<option ".(($msql->f("saletag")=='$tag_src') ? ' selected ' : '' ). " value=".$tag_src.">".$tag_name."</option>";
		}
		
		$select_tag.="</select>";
		
		
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
		/*$fsql->query( "select cat from {P}_shop_cat where catid='{$catid}'" );
		if ( $fsql->next_record( ) )
		{
				$cat = $fsql->f( "cat" );
		}*/
		$cat = $catlist[$catid];
		$browseurl = ROOTPATH."shop/html/?".$id.".html";
		
		/*cat sort 2017-02-06*/
		$getsort = $fsql->getone( "select * from {P}_shop_sort where gid='$id' and catid='$pid'" );
		$sortid = $getsort['id'];
		$sortxuhao = $getsort['xuhao'];
		echo "
	<tr> 
		<td class=\"col-mini center\">
			<label class=\"tcb-inline\" style=\"margin-right:0;\">
				<input type=\"checkbox\" class=\"tc\" name=\"dall[]\" value=\"".$id."\"><span class=\"labels\"></span>
			</label>
		</td>
      <td class=\"col-small center\"> ".$id." </td>
      <td class=\"col-mini center\"> <input type='number' value='".$xuhao."' id='orixuhao_".$id."' class='form-control input-mini chgorixuhao'> </td>
      <td class=\"col-mini center\" ".$showsort."> <input type='number' value='".$sortxuhao."' id='sort_".$sortid."_".$id."_".$pid."' class='form-control input-mini chgsortxuhao'> </td>
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
      <td class=\"col-medium center\"> ".$cat." </td>
      <td class=\"col-small center\"> ".$bn." </td>
      <td class=\"col-width center\"><a href=\"".$browseurl."\" target=\"_blank\" style=\"color:".$tcolor.";font-weight:".$tbold."\">".$title.$ifsub."</a></td>
      <td class=\"col-small center\"> ".$colorname." </td>
      <td class=\"col-medium center hidden-xs\">".$starttime."</td>
      <td class=\"col-medium center hidden-xs\">".$endtime."</td>
      <td class=\"col-small center hidden-xs\">".(int)$price."</td>
      <td class=\"col-mini center\"> ".$salenums." </td>
      <td class=\"col-mini center\"> ".$kucun." </td>
      <td class=\"col-mini center hidden-xs\">";
		showyn( $iffb );
		echo "</td>
      <td class=\"col-mini center hidden-xs\"> ";
		showyn( $tj );
		echo " </td>
	  <td class=\"col-mini center hidden-xs\"><img src=\"images/copy.png\"  style=\"cursor:pointer;width:30px\" onclick=\"self.location='index.php?step=copy&id=".$id."'\" /> </td>	
      <td class=\"col-mini center hidden-xs\"><img src=\"images/update.png\"  style=\"cursor:pointer\" onclick=\"self.location='index.php?step=refresh&id=".$id."'\" /> </td>
      <td class=\"col-mini center\"><img src=\"images/edit.png\" style=\"cursor:pointer\"  onclick=\"window.location='shop_conmod.php?id=".$id."&pid=".$pid."&page=".$page."'\" /></td>
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
							<option value="1"><?php echo $strShopFb; ?></option>
							<option value="0"><?php echo $strShopNotFb; ?></option>
						</select>
					</label>
					<label class="tcb-inline"><input type="radio" class="tc" name="step" value="settj"><span class="labels"></span>
						<select name="tj" id="tj">
							<option value="1"><?php echo $strShopTj; ?></option>
							<option value="0"><?php echo $strShopNotTj; ?></option>
						</select>
					</label>
					<label class="tcb-inline"><input type="radio" class="tc" name="step" value="setbold"><span class="labels"></span>
						<select name="bold" id="bold">
							<option value="1"><?php echo $strShopBold; ?></option>
							<option value="0"><?php echo $strShopNotBold; ?></option>
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
					<label class="tcb-inline"><input type="radio" class="tc" name="step" value="paixu"><span class="labels"> <?php echo $strPaiXu;?></span>
						<input name="newxuhao" type="text" class="input" id="newxuhao" value="0" size="5" maxlength="5" />
					</label>
	
					<label class="tcb-inline"><input type="radio" class="tc" name="step" value="setdiscon"><span class="labels"> 折扣</span>
						<input name="discon" type="text" class="input" id="discon" value="0.9" size="5" maxlength="5" />
					</label>
		<input class="btn btn-sm btn-inverse" type="button" value="<?php echo $strSubmit;?>" onClick="delfm.submit()">
        <input type="hidden" name="page" size="3" value="<?php echo $page;?>" />
        <input type="hidden" name="ord" size="3" value="<?php echo $ord;?>" />
        <input type="hidden" name="sc" size="3" value="<?php echo $sc;?>" />
        <input type="hidden" name="key" size="3" value="<?php echo $key;?>" />
       
        <input type="hidden" name="showtj" value="<?php echo $showtj;?>" />
        <input type="hidden" name="showfb" value="<?php echo $showfb;?>" />
        <input type="hidden" name="pid" value="<?php echo $pid;?>" />
        <input type="hidden" name="shownum" value="<?php echo $shownum;?>" />
        <input type="hidden" name="isdiscshow" value="<?php echo $isdiscshow;?>" />
        <input type="hidden" name="issubshow" value="<?php echo $issubshow;?>" />
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
	<script src="js/shop_new.js"></script>
		
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>購物</li>');
			$('#pagetitle', window.parent.document).html('購物管理 <span class="sub-title" id="subtitle">商品列表</span>');
			//呼叫左側功能選單
			$().getMenuGroup('shop');
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
		if(nn!='<?php echo $ord;?>'){
			window.location='index.php?page=<?php echo $page;?>&sc=<?php echo $sc;?>&pid=<?php echo $pid;?>&showtj=<?php echo $showtj;?>&showfb=<?php echo $showfb;?>&shownum=<?php echo $shownum;?>&ord='+nn;
		}else{
			if(sc=='asc' || sc==''){
			window.location='index.php?page=<?php echo $page;?>&sc=desc&pid=<?php echo $pid;?>&showtj=<?php echo $showtj;?>&showfb=<?php echo $showfb;?>&shownum=<?php echo $shownum;?>&ord='+nn;
			}else{
			window.location='index.php?page=<?php echo $page;?>&sc=asc&pid=<?php echo $pid;?>&showtj=<?php echo $showtj;?>&showfb=<?php echo $showfb;?>&shownum=<?php echo $shownum;?>&ord='+nn;
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