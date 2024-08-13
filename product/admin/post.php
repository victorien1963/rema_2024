<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/upload.inc.php" );
needauth( 182 );
$act = $_POST['act'];
switch ( $act )
{
case "proplist" :
		$catid = $_POST['catid'];
		$nowid = $_POST['nowid'];
		if ( $nowid != "" && $nowid != "0" )
		{
				$msql->query( "select * from {P}_product_con where  id='{$nowid}'" );
				if ( $msql->next_record( ) )
				{
						$prop1 = $msql->f( "prop1" );
						$prop2 = $msql->f( "prop2" );
						$prop3 = $msql->f( "prop3" );
						$prop4 = $msql->f( "prop4" );
						$prop5 = $msql->f( "prop5" );
						$prop6 = $msql->f( "prop6" );
						$prop7 = $msql->f( "prop7" );
						$prop8 = $msql->f( "prop8" );
						$prop9 = $msql->f( "prop9" );
						$prop10 = $msql->f( "prop10" );
						$prop11 = $msql->f( "prop11" );
						$prop12 = $msql->f( "prop12" );
						$prop13 = $msql->f( "prop13" );
						$prop14 = $msql->f( "prop14" );
						$prop15 = $msql->f( "prop15" );
						$prop16 = $msql->f( "prop16" );
				}
		}
		$str = "<table width='100%'   border='0' align='center'  cellpadding='2' cellspacing='0' >";
		$i = 1;
		$msql->query( "select * from {P}_product_prop where catid='{$catid}' order by xuhao" );
		while ( $msql->next_record( ) )
		{
				$propname = $msql->f( "propname" );
				$pn = "prop".$i;
				$str .= "<tr>";
				$str .= "<td width='100' height='30' align='center' >".$propname."</td>";
				$str .= "<td height='30' >";
				$str .= "<input type='text' name='".$pn."' value='".$$pn."' class='input' style='width:499px;' />";
				$str .= "</td>";
				$str .= "</tr>";
				$i++;
		}
		$str .= "</table>";
		echo $str;
		exit( );
		break;
case "addpage" :
		$nowid = $_POST['nowid'];
		$xuhao = 0;
		if ( $nowid != "" && $nowid != "0" )
		{
				$msql->query( "select max(xuhao) from {P}_product_pages where productid='{$nowid}'" );
				if ( $msql->next_record( ) )
				{
						$xuhao = $msql->f( "max(xuhao)" );
				}
				$xuhao = $xuhao + 1;
				$msql->query( "insert into {P}_product_pages set productid='{$nowid}',xuhao='{$xuhao}' " );
		}
		echo "OK";
		exit( );
		break;
case "productpageslist" :
		$nowid = $_POST['nowid'];
		$pageinit = $_POST['pageinit'];
		$str = "<ul>";
		$str .= "<li id='p_0' class='pages'>1</li>";
		$i = 2;
		$id = 0;
		$msql->query( "select id from {P}_product_pages where productid='{$nowid}' order by xuhao" );
		while ( $msql->next_record( ) )
		{
				$id = $msql->f( "id" );
				$str .= "<li id='p_".$id."' class='pages'>".$i."</li>";
				$i++;
		}
		if ( $pageinit != "new" )
		{
				$id = $pageinit;
		}
		$str .= "<li id='addpage' class='addbutton'>".$strProductPagesAdd."</li>";
		if ( $pageinit != "0" )
		{
				$str .= "<li id='pagedelete' class='addbutton'>".$strProductPagesDel."</li>";
				$str .= "<li id='backtomodi' class='addbutton'>".$strBack."</li>";
		}
		$str .= "</ul><input id='productpagesid' name='productpagesid' type='hidden' value='".$id."'>";
		echo $str;
		exit( );
		break;
case "getcontent" :
		$nowid = $_POST['nowid'];
		$productpageid = $_POST['productpageid'];
		if ( $productpageid == "-1" )
		{
				$src = "";
		}
		else if ( $productpageid == "0" )
		{
				$msql->query( "select src from {P}_product_con where id='{$nowid}'" );
				if ( $msql->next_record( ) )
				{
						$src = $msql->f( "src" );
				}
		}
		else
		{
				$msql->query( "select src from {P}_product_pages where id='{$productpageid}'" );
				if ( $msql->next_record( ) )
				{
						$src = $msql->f( "src" );
				}
				else
				{
						$src = "";
				}
		}
		echo $src;
		exit( );
		break;
case "productmodify" :
		$id = $_POST['id'];
		$pid = $_POST['pid'];
		$catid = $_POST['catid'];
		$page = $_POST['page'];
		$body = $_POST['body'];
		$title = htmlspecialchars( $_POST['title'] );
		$author = htmlspecialchars( $_POST['author'] );
		$source = htmlspecialchars( $_POST['source'] );
		$memo = htmlspecialchars( $_POST['memo'] );
		$oldcatid = $_POST['oldcatid'];
		$oldcatpath = $_POST['oldcatpath'];
		$prop1 = htmlspecialchars( $_POST['prop1'] );
		$prop2 = htmlspecialchars( $_POST['prop2'] );
		$prop3 = htmlspecialchars( $_POST['prop3'] );
		$prop4 = htmlspecialchars( $_POST['prop4'] );
		$prop5 = htmlspecialchars( $_POST['prop5'] );
		$prop6 = htmlspecialchars( $_POST['prop6'] );
		$prop7 = htmlspecialchars( $_POST['prop7'] );
		$prop8 = htmlspecialchars( $_POST['prop8'] );
		$prop9 = htmlspecialchars( $_POST['prop9'] );
		$prop10 = htmlspecialchars( $_POST['prop10'] );
		$prop11 = htmlspecialchars( $_POST['prop11'] );
		$prop12 = htmlspecialchars( $_POST['prop12'] );
		$prop13 = htmlspecialchars( $_POST['prop13'] );
		$prop14 = htmlspecialchars( $_POST['prop14'] );
		$prop15 = htmlspecialchars( $_POST['prop15'] );
		$prop16 = htmlspecialchars( $_POST['prop16'] );
		$prop17 = htmlspecialchars( $_POST['prop17'] );
		$prop18 = htmlspecialchars( $_POST['prop18'] );
		$prop19 = htmlspecialchars( $_POST['prop19'] );
		$prop20 = htmlspecialchars( $_POST['prop20'] );
		$tags = $_POST['tags'];
		$spe_selec = $_POST['spe_selec'];
		$pic = $_FILES['jpg'];
		$picb = $_FILES['jpgb'];
		$pict = $_FILES['jpgt'];
		$body = url2path( $body );
		if ( 0 < $pic['size'] )
		{
				$Meta = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		}
		if ( 0 < $picb['size'] )
		{
				$Meta = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		}
		if ( $title == "" )
		{
				echo $Meta.$strProductNotice6;
				exit( );
		}
		if ( 200 < strlen( $title ) )
		{
				echo $Meta.$strProductNotice7;
				exit( );
		}
		if ( 65000 < strlen( $memo ) )
		{
				echo $Meta.$strProductNotice4;
				exit( );
		}
		if ( 65000 < strlen( $body ) )
		{
				echo $Meta.$strProductNotice5;
				exit( );
		}
		$uptime = time( );
		$msql->query( "select catpath from {P}_product_cat where catid='{$catid}'" );
		if ( $msql->next_record( ) )
		{
				$catpath = $msql->f( "catpath" );
		}
		$count_pro = count( $spe_selec );
		
		for ( $i = 0;	$i < $count_pro;	$i++	)
		{
				$projid = $spe_selec[$i];
				$projpath .= $projid.":";
		}
		$msql->query( "select * from {P}_product_config where `variable`='PhotoBWH'" );
		if ( $msql->next_record( ) )
		{
				list($PhotoBW,$PhotoBH) = explode("|",$msql->f( "value" ));
		}
		$msql->query( "select * from {P}_product_config where `variable`='PhotoSWH'" );
		if ( $msql->next_record( ) )
		{
				list($PhotoSW,$PhotoSH) = explode("|",$msql->f( "value" ));
		}
		if ( 0 < $pic['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "product/pics/".$nowdate;
				$arr = newuploadimage( $pic['tmp_name'], $pic['type'], $pic['size'], $uppath, $PhotoBW, $PhotoBH, $PhotoSW, $PhotoSH );
				if ( $arr[0] != "err" )
				{
						$src = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
				$msql->query( "select src from {P}_product_con where id='{$id}'" );
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
				$msql->query( "update {P}_product_con set src='{$src}' where id='{$id}'" );
		}
		if ( 0 < $picb['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "product/pics/".$nowdate;
				$arr = newuploadimage( $picb['tmp_name'], $picb['type'], $picb['size'], $uppath, $PhotoBW, $PhotoBH, $PhotoSW, $PhotoSH );
				if ( $arr[0] != "err" )
				{
						$srcb = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
				$msql->query( "select srcb from {P}_product_con where id='{$id}'" );
				if ( $msql->next_record( ) )
				{
						$oldsrcb = $msql->f( "srcb" );
				}
				if ( file_exists( ROOTPATH.$oldsrcb ) && $oldsrc != "" && !strstr( $oldsrcb, "../" ) )
				{
						unlink( ROOTPATH.$oldsrcb );
						$getpic = basename($oldsrcb);
						$getpicpath = dirname($oldsrcb);
						@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
				}
				$msql->query( "update {P}_product_con set srcb='{$srcb}' where id='{$id}'" );
		}
		if ( 0 < $pict['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "product/pics/".$nowdate;
				$arr = newuploadimage( $pict['tmp_name'], $pict['type'], $pict['size'], $uppath, $PhotoBW, $PhotoBH, $PhotoSW, $PhotoSH );
				if ( $arr[0] != "err" )
				{
						$srct = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
				$msql->query( "select srct from {P}_product_con where id='{$id}'" );
				if ( $msql->next_record( ) )
				{
						$oldsrct = $msql->f( "srct" );
				}
				if ( file_exists( ROOTPATH.$oldsrct ) && $oldsrc != "" && !strstr( $oldsrct, "../" ) )
				{
						unlink( ROOTPATH.$oldsrct );
						$getpic = basename($oldsrct);
						$getpicpath = dirname($oldsrct);
						@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
				}
				$msql->query( "update {P}_product_con set srct='{$srct}' where id='{$id}'" );
		}
		for ( $t = 0;	$t < sizeof( $tags );	$t++	)
		{
				if ( $tags[$t] != "" )
				{
						$tagstr .= $tags[$t].",";
				}
		}
		$msql->query( "update {P}_product_con set 
			title='{$title}',
			memo='{$memo}',
		    body='{$body}',
			catid='{$catid}',
			catpath='{$catpath}',
			uptime='{$uptime}',
			author='{$author}',
			source='{$source}',
			proj='{$projpath}',
			tags='{$tagstr}',
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
			prop20='{$prop20}'
			where id='{$id}'
		" );
		echo "OK";
		exit( );
		break;
case "contentmodify" :
		$productpagesid = $_POST['productpagesid'];
		$pic = $_FILES['jpg'];
		$Meta = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		if ( $pic['size'] <= 0 )
		{
				echo $Meta.$strProductNotice3;
				exit( );
		}
		$msql->query( "select * from {P}_product_config where `variable`='PhotoBWH'" );
		if ( $msql->next_record( ) )
		{
				list($PhotoBW,$PhotoBH) = explode("|",$msql->f( "value" ));
		}
		$msql->query( "select * from {P}_product_config where `variable`='PhotoSWH'" );
		if ( $msql->next_record( ) )
		{
				list($PhotoSW,$PhotoSH) = explode("|",$msql->f( "value" ));
		}
		if ( 0 < $pic['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "product/pics/".$nowdate;
				$arr = newuploadimage( $pic['tmp_name'], $pic['type'], $pic['size'], $uppath, $PhotoBW, $PhotoBH, $PhotoSW, $PhotoSH );
				if ( $arr[0] != "err" )
				{
						$src = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
				$msql->query( "select src from {P}_product_pages where id='{$productpagesid}'" );
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
				$msql->query( "update {P}_product_pages set src='{$src}' where id='{$productpagesid}'" );
		}
		echo "OK";
		exit( );
		break;
case "productadd" :
		$catid = $_POST['catid'];
		$body = $_POST['body'];
		$title = htmlspecialchars( $_POST['title'] );
		$author = htmlspecialchars( $_POST['author'] );
		$source = htmlspecialchars( $_POST['source'] );
		$memo = htmlspecialchars( $_POST['memo'] );
		$prop1 = htmlspecialchars( $_POST['prop1'] );
		$prop2 = htmlspecialchars( $_POST['prop2'] );
		$prop3 = htmlspecialchars( $_POST['prop3'] );
		$prop4 = htmlspecialchars( $_POST['prop4'] );
		$prop5 = htmlspecialchars( $_POST['prop5'] );
		$prop6 = htmlspecialchars( $_POST['prop6'] );
		$prop7 = htmlspecialchars( $_POST['prop7'] );
		$prop8 = htmlspecialchars( $_POST['prop8'] );
		$prop9 = htmlspecialchars( $_POST['prop9'] );
		$prop10 = htmlspecialchars( $_POST['prop10'] );
		$prop11 = htmlspecialchars( $_POST['prop11'] );
		$prop12 = htmlspecialchars( $_POST['prop12'] );
		$prop13 = htmlspecialchars( $_POST['prop13'] );
		$prop14 = htmlspecialchars( $_POST['prop14'] );
		$prop15 = htmlspecialchars( $_POST['prop15'] );
		$prop16 = htmlspecialchars( $_POST['prop16'] );
		$prop17 = htmlspecialchars( $_POST['prop17'] );
		$prop18 = htmlspecialchars( $_POST['prop18'] );
		$prop19 = htmlspecialchars( $_POST['prop19'] );
		$prop20 = htmlspecialchars( $_POST['prop20'] );
		$tags = $_POST['tags'];
		$pic = $_FILES['jpg'];
		$picb = $_FILES['jpgb'];
		$pict = $_FILES['jpgt'];
		$spe_selec = $_POST['spe_selec'];
		$body = url2path( $body );
		trylimit( "_product_con", 20, "id" );
		$Meta = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		if ( $title == "" )
		{
				echo $Meta.$strProductNotice6;
				exit( );
		}
		if ( 200 < strlen( $title ) )
		{
				echo $Meta.$strProductNotice7;
				exit( );
		}
		if ( 65000 < strlen( $memo ) )
		{
				echo $Meta.$strProductNotice4;
				exit( );
		}
		if ( 65000 < strlen( $body ) )
		{
				echo $Meta.$strProductNotice5;
				exit( );
		}
		$uptime = time( );
		$dtime = time( );
		$msql->query( "select catpath from {P}_product_cat where catid='{$catid}'" );
		if ( $msql->next_record( ) )
		{
				$catpath = $msql->f( "catpath" );
		}
		$msql->query( "select * from {P}_product_config where `variable`='PhotoBWH'" );
		if ( $msql->next_record( ) )
		{
				list($PhotoBW,$PhotoBH) = explode("|",$msql->f( "value" ));
		}
		$msql->query( "select * from {P}_product_config where `variable`='PhotoSWH'" );
		if ( $msql->next_record( ) )
		{
				list($PhotoSW,$PhotoSH) = explode("|",$msql->f( "value" ));
		}
		if ( 0 < $pic['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "product/pics/".$nowdate;
				$arr = newuploadimage( $pic['tmp_name'], $pic['type'], $pic['size'], $uppath, $PhotoBW, $PhotoBH, $PhotoSW, $PhotoSH );
				if ( $arr[0] != "err" )
				{
						$src = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
		}
		if ( 0 < $picb['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "product/pics/".$nowdate;
				$arr = newuploadimage( $picb['tmp_name'], $picb['type'], $picb['size'], $uppath, $PhotoBW, $PhotoBH, $PhotoSW, $PhotoSH );
				if ( $arr[0] != "err" )
				{
						$srcb = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
		}
		if ( 0 < $pict['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "product/pics/".$nowdate;
				$arr = newuploadimage( $pict['tmp_name'], $pict['type'], $pict['size'], $uppath, $PhotoBW, $PhotoBH, $PhotoSW, $PhotoSH );
				if ( $arr[0] != "err" )
				{
						$srct = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
		}
		$count_pro = count( $spe_selec );
		
		for ( $i = 0;	$i < $count_pro;	$i++	)
		{
				$projid = $spe_selec[$i];
				$projpath .= $projid.":";
		}
		
		for ( $t = 0;	$t < sizeof( $tags );	$t++	)
		{
				if ( $tags[$t] != "" )
				{
						$tagstr .= $tags[$t].",";
				}
		}
		$msql->query( "insert into {P}_product_con set
		catid='{$catid}',
		catpath='{$catpath}',
		title='{$title}',
		body='{$body}',
		dtime='{$dtime}',
		xuhao='0',
		cl='0',
		tj='0',
		iffb='1',
		ifbold='0',
		ifred='0',
		type='gif',
		src='{$src}',
		srct='{$srct}',
		srcb='{$srcb}',
		uptime='{$dtime}',
		author='{$author}',
		source='{$source}',
		memberid='0',
		proj='{$projpath}',
		tags='{$tagstr}',
		secure='0',
		memo='{$memo}',
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
		prop20='{$prop20}'
		" );
		echo "OK";
		exit( );
		break;
case "pagedelete" :
		$delpagesid = $_POST['delpagesid'];
		$nowid = $_POST['nowid'];
		$i = 0;
		$msql->query( "select id from {P}_product_pages where productid='{$nowid}' order by xuhao" );
		while ( $msql->next_record( ) )
		{
				$id[$i] = $msql->f( "id" );
				if ( $id[$i] == $delpagesid )
				{
						if ( $i == 0 )
						{
								$lastid = 0;
						}
						else
						{
								$lastid = $id[$i - 1];
						}
				}
				$i++;
		}
		if ( $lastid == 0 && 1 < $i )
		{
				$lastid = $id[1];
		}
		$msql->query( "select src from {P}_product_pages where id='{$delpagesid}'" );
		if ( $msql->next_record( ) )
		{
				$oldsrc = $msql->f( "src" );
				if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )
				{
						unlink( ROOTPATH.$oldsrc );
						$getpic = basename($oldsrc);
						$getpicpath = dirname($oldsrc);
						@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
				}
		}
		$msql->query( "delete from  {P}_product_pages where id='{$delpagesid}'" );
		echo $lastid;
		exit( );
		break;
case "addproj" :
		$project = htmlspecialchars( $_POST['project'] );
		$folder = htmlspecialchars( $_POST['folder'] );
		if ( $project == "" )
		{
				echo $strProjNTC1;
				exit( );
		}
		if ( strlen( $folder ) < 2 || 16 < strlen( $folder ) )
		{
				echo $strProjNTC2;
				exit( );
		}
		if ( !eregi( "^[0-9a-z]{1,16}\$", $folder ) )
		{
				echo $strProjNTC3;
				exit( );
		}
		if ( strstr( $folder, "/" ) || strstr( $folder, "." ) )
		{
				echo $strProjNTC3;
				exit( );
		}
		$arr = array( "main", "html", "class", "detail", "query", "index", "admin", "productgl", "productfabu", "productmodify", "productcat", "pics" );
		if ( in_array( $folder, $arr ) == true )
		{
				echo $strProjNTC4;
				exit( );
		}
		if ( file_exists( "../project/".$folder ) )
		{
				echo $strProjNTC4;
				exit( );
		}
		$msql->query( "select id from {P}_product_proj where folder='{$folder}'" );
		if ( $msql->next_record( ) )
		{
				echo $strProjNTC4;
				exit( );
		}
		$pagename = "proj_".$folder;
		@mkdir( "../project/".$folder, 511 );
		$fd = fopen( "../project/temp.php", "r" );
		$str = fread( $fd, "2000" );
		$str = str_replace( "TEMP", $pagename, $str );
		fclose( $fd );
		$filename = "../project/".$folder."/index.php";
		$fp = fopen( $filename, "w" );
		fwrite( $fp, $str );
		fclose( $fp );
		@chmod( $filename, 493 );
		$msql->query( "insert into {P}_product_proj set 
			`project`='{$project}',
			`folder`='{$folder}'
		" );
		$msql->query( "insert into {P}_base_pageset set 
			`name`='{$project}',
			`coltype`='product',
			`pagename`='{$pagename}',
			`pagetitle`='{$project}',
			`buildhtml`='index'
		" );
		echo "OK";
		exit( );
		break;
case "addzl" :
		$catid = htmlspecialchars( $_POST['catid'] );
		if ( $catid == "" )
		{
				echo $strZlNTC1;
				exit( );
		}
		$msql->query( "select cat from {P}_product_cat where catid='{$catid}'" );
		if ( $msql->next_record( ) )
		{
				$cat = $msql->f( "cat" );
				$cat = str_replace( "'", "", $cat );
		}
		else
		{
				echo $strZlNTC2;
				exit( );
		}
		$pagename = "class_".$catid;
		@mkdir( "../class/".$catid, 511 );
		$fd = fopen( "../class/temp.php", "r" );
		$str = fread( $fd, "2000" );
		$str = str_replace( "TEMP", $pagename, $str );
		fclose( $fd );
		$filename = "../class/".$catid."/index.php";
		$fp = fopen( $filename, "w" );
		fwrite( $fp, $str );
		fclose( $fp );
		@chmod( $filename, 493 );
		$msql->query( "update {P}_product_cat set `ifchannel`='1' where catid='{$catid}'" );
		$msql->query( "select id from {P}_base_pageset where coltype='product' and pagename='{$pagename}'" );
		if ( $msql->next_record( ) )
		{
		}
		else
		{
				$fsql->query( "insert into {P}_base_pageset set 
			`name`='{$cat}',
			`coltype`='product',
			`pagename`='{$pagename}',
			`pagetitle`='{$cat}',
			`buildhtml`='index'
			" );
		}
		echo "OK";
		exit( );
		break;
case "delzl" :
		$catid = htmlspecialchars( $_POST['catid'] );
		if ( $catid == "" )
		{
				echo $strZlNTC1;
				exit( );
		}
		$msql->query( "select catid from {P}_product_cat where catid='{$catid}'" );
		if ( $msql->next_record( ) )
		{
		}
		else
		{
				echo $strZlNTC2;
				exit( );
		}
		$pagename = "class_".$catid;
		$msql->query( "delete from {P}_base_pageset where coltype='product' and pagename='{$pagename}'" );
		$msql->query( "delete from {P}_base_plus where plustype='product' and pluslocat='{$pagename}'" );
		$msql->query( "update {P}_product_cat set `ifchannel`='0' where catid='{$catid}'" );
		if ( $catid != "" && 1 <= strlen( $catid ) && !strstr( $catid, "." ) && !strstr( $catid, "/" ) )
		{
				delfold( "../class/".$catid );
		}
		echo "OK";
		exit( );
		break;
case "addcattemp" :
				$catid = htmlspecialchars( $_POST['catid'] );
				if ( $catid == "" )
				{
								echo $strZlNTC1;
								exit( );
				}
				$msql->query( "update {P}_product_cat set `cattemp`='1' where catid='{$catid}'" );
				$chgdb= array('query','detail');
				foreach($chgdb AS $chgname){
				$msql->query( "select * from {P}_base_pageset where coltype='product' and pagename='{$chgname}'" );
				if ( $msql->next_record( ) )
				{
					$fsql->query( "insert into {P}_base_pageset (`id`, `name`, `coltype`, `pagename`, `th`, `ch`, `bh`, `pagetitle`, `metakey`, `metacon`, `bgcolor`, `bgimage`, `bgposition`, `bgrepeat`, `bgatt`, `containwidth`, `containbg`, `containimg`, `containmargin`, `containpadding`, `containcenter`, `topbg`, `topwidth`, `contentbg`, `contentwidth`, `contentmargin`, `bottombg`, `bottomwidth`, `buildhtml`, `xuhao`) VALUES (NULL,'{$msql->f('name')}','{$msql->f('coltype')}','{$chgname}_{$catid}','{$msql->f('th')}','{$msql->f('ch')}','{$msql->f('bh')}','{$msql->f('pagetitle')}','{$msql->f('metakey')}','{$msql->f('metacon')}','{$msql->f('bgcolor')}','{$msql->f('bgimage')}','{$msql->f('bgposition')}','{$msql->f('bgrepeat')}','{$msql->f('bgatt')}','{$msql->f('containwidth')}','{$msql->f('containbg')}','{$msql->f('containimg')}','{$msql->f('containmargin')}','{$msql->f('containpadding')}','{$msql->f('containcenter')}','{$msql->f('topbg')}','{$msql->f('topwidth')}','{$msql->f('contentbg')}','{$msql->f('contentwidth')}','{$msql->f('contentmargin')}','{$msql->f('bottombg')}','{$msql->f('bottomwidth')}','{$msql->f('buildhtml')}','{$msql->f('xuhao')}') " );
				}
				else
				{
								echo $strZlNTC2;
								exit( );
				}
				
				$msql->query( "select * from {P}_base_plusdefault where coltype='product' and pluslocat='{$chgname}'" );
				while ( $msql->next_record( ) )
				{
					$fsql->query( "INSERT INTO {P}_base_plusdefault (`id`, `coltype`, `pluslable`, `plusname`, `plustype`, `pluslocat`, `tempname`, `tempcolor`, `showborder`, `bordercolor`, `borderwidth`, `borderstyle`, `borderlable`, `borderroll`, `showbar`, `barbg`, `barcolor`, `backgroundcolor`, `morelink`, `width`, `height`, `top`, `left`, `zindex`, `padding`, `shownums`, `ord`, `sc`, `showtj`, `cutword`, `target`, `catid`, `cutbody`, `picw`, `pich`, `fittype`, `title`, `body`, `pic`, `piclink`, `attach`, `movi`, `sourceurl`, `word`, `word1`, `word2`, `word3`, `word4`, `text`, `text1`, `code`, `link`, `link1`, `link2`, `link3`, `link4`, `tags`, `groupid`, `projid`, `moveable`, `classtbl`, `grouptbl`, `projtbl`, `setglobal`, `overflow`, `bodyzone`, `display`, `ifmul`, `ifrefresh`) VALUES (NULL, '{$msql->f('coltype')}', '{$msql->f('pluslable')}', '{$msql->f('plusname')}', '{$msql->f('plustype')}', '{$chgname}_{$catid}', '{$msql->f('tempname')}', '{$msql->f('tempcolor')}', '{$msql->f('showborder')}', '{$msql->f('bordercolor')}', '{$msql->f('borderwidth')}', '{$msql->f('borderstyle')}', '{$msql->f('borderlable')}', '{$msql->f('borderroll')}', '{$msql->f('showbar')}', '{$msql->f('barbg')}', '{$msql->f('barcolor')}', '{$msql->f('backgroundcolor')}', '{$msql->f('morelink')}', '{$msql->f('width')}', '{$msql->f('height')}', '{$msql->f('top')}', '{$msql->f('left')}', '{$msql->f('zindex')}', '{$msql->f('padding')}', '{$msql->f('shownums')}', '{$msql->f('ord')}', '{$msql->f('sc')}', '{$msql->f('showtj')}', '{$msql->f('cutword')}', '{$msql->f('target')}', '{$msql->f('catid')}', '{$msql->f('cutbody')}', '{$msql->f('picw')}', '{$msql->f('pich')}', '{$msql->f('fittype')}', '{$msql->f('title')}', '{$msql->f('body')}', '{$msql->f('pic')}', '{$msql->f('piclink')}', '{$msql->f('attach')}', '{$msql->f('movi')}', '{$msql->f('sourceurl')}', '{$msql->f('word')}', '{$msql->f('word1')}', '{$msql->f('word2')}', '{$msql->f('word3')}', '{$msql->f('word4')}', '{$msql->f('text')}', '{$msql->f('text1')}', '{$msql->f('code')}', '{$msql->f('link')}', '{$msql->f('link1')}', '{$msql->f('link2')}', '{$msql->f('link3')}', '{$msql->f('link4')}', '{$msql->f('tags')}', '{$msql->f('groupid')}', '{$msql->f('projid')}', '{$msql->f('moveable')}', '{$msql->f('classtbl')}', '{$msql->f('grouptbl')}', '{$msql->f('projtbl')}', '{$msql->f('setglobal')}', '{$msql->f('overflow')}', '{$msql->f('bodyzone')}', '{$msql->f('display')}', '{$msql->f('ifmul')}', '{$msql->f('ifrefresh')}')" );
				}
				}								
				echo "OK";
				exit( );
				break;
case "delcattemp" :
				$catid = htmlspecialchars( $_POST['catid'] );
				if ( $catid == "" )
				{
								echo $strZlNTC1;
								exit( );
				}
				$msql->query( "select catid from {P}_product_cat where catid='{$catid}'" );
				if ( $msql->next_record( ) )
				{
				}
				else
				{
								echo $strZlNTC2;
								exit( );
				}
				$chgdb= array('query','detail');
				foreach($chgdb AS $chgname){
				$pagename = $chgname."_".$catid;
				$msql->query( "delete from {P}_base_pageset where coltype='product' and pagename='{$pagename}'" );
				$msql->query( "delete from {P}_base_plusdefault where plustype='product' and pluslocat='{$pagename}'" );
				$msql->query( "delete from {P}_base_plus where plustype='product' and pluslocat='{$pagename}'" );
				$msql->query( "update {P}_product_cat set `cattemp`='0' where catid='{$catid}'" );
				}
				echo "OK";
				exit( );
				break;
}
?>