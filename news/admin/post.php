<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/upload.inc.php" );
needauth( 0 );
$act = $_POST['act'];
switch ( $act )
{
	//讀取左側選單組
	case "menugrouplist" :
		$coltype = $_POST['coltype'];
		$pathcoltype = $coltype;
		$basecoltype = array("home","config");
		if(in_array($coltype, $basecoltype)){
			$pathcoltype = "base";
		}
		$str="<li><h4>功能目錄</h4></li>";
		$i=1;
		$msql->query("select g.id,m.* from {P}_adminmenu_group g LEFT JOIN {P}_adminmenu m ON g.id=m.groupid where g.coltype='$coltype' order by xuhao");
		while($msql->next_record()){
			$groupid=$msql->f('id');
			$menu=$msql->f('menu');
			$url=$msql->f('url');
			//$str.="<li><a id='m".$i."' class='menulist' href='".ROOTPATH.$pathcoltype."/admin/".$url."' target='mainframe'><i class='fa fa-dashboard'></i> ".$menu."</a></li>";
			$authuser=explode(",",$msql->f('authuser'));
			if($ifshow == "0"){
				if(in_array($_COOKIE['SYSUSERID'],$authuser)){
					$str.="<li><a id='m".$i."' class='menulist' href='".ROOTPATH.$pathcoltype."/admin/".$url."' target='mainframe'><i class='fa fa-dashboard'></i> ".$menu."</a></li>";
				}
			}else{
				$str.="<li><a id='m".$i."' class='menulist' href='".ROOTPATH.$pathcoltype."/admin/".$url."' target='mainframe'><i class='fa fa-dashboard'></i> ".$menu."</a></li>";
			}
			$i++;
		}
		echo $str;
		exit();
		break;
case "proplist" :
		$catid = $_POST['catid'];
		$nowid = $_POST['nowid'];
		if ( $nowid != "" && $nowid != "0" )
		{
				$msql->query( "select * from {P}_news_con where  id='{$nowid}'" );
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
						$prop17 = $msql->f( "prop17" );
						$prop18 = $msql->f( "prop18" );
						$prop19 = $msql->f( "prop19" );
						$prop20 = $msql->f( "prop20" );
				}
		}
		$i = 1;
		$msql->query( "select * from {P}_news_prop where catid='{$catid}' order by xuhao" );
		while ( $msql->next_record( ) )
		{
				$propname = $msql->f( "propname" );
				$pn = "prop".$i;
				if(strpos($propname,"|")!==false){
					list($propname, $type, $selects) = explode("|",$propname);
					$selectlists = explode(",",$selects);
					$str .= "<div class='form-group'>";
					$str .= "<label class='col-sm-1 control-label'>".$propname."</label>";
					$str .= "<div class='col-sm-6'>";
					
					if($type == "radio"){
						foreach($selectlists AS $radios){
							list($ranme, $rselect) = explode("^",$radios);
							if( $$pn == $rselect){
								$str .= "<label class='tcb-inline'><input type='radio' class='tc' name='".$pn."' value='".$rselect."' checked /><span class='labels'></span> ".$ranme."</label> ";
							}else{
								$str .= "<label class='tcb-inline'><input type='radio' class='tc' name='".$pn."' value='".$rselect."' /><span class='labels'></span> ".$ranme."</label> ";
							}
						}
					}elseif($type == "checkbox"){
						foreach($selectlists AS $radios){
							list($ranme, $rselect) = explode("^",$radios);
							if( stripos($$pn,$rselect) !== false ){
								$str .= "<label class='tcb-inline'><input type='checkbox' class='tc' name='".$pn."[]' value='".$rselect."' checked /><span class='labels'></span> ".$ranme."</label> ";
							}else{
								$str .= "<label class='tcb-inline'><input type='checkbox' class='tc' name='".$pn."[]' value='".$rselect."' /><span class='labels'></span> ".$ranme."</label> ";
							}
						}
					}

					$str .= "</div>";
					$str .= "</div>";
				}else{
					$str .= "<div class='form-group'>";
					$str .= "<label class='col-sm-1 control-label'>".$propname."</label>";
					$str .= "<div class='col-sm-6'>";
					$str .= "<input type='text' name='".$pn."' value='".$$pn."' class='form-control' />";
					$str .= "</div>";
					$str .= "</div>";
				}
				$i++;
		}
		echo $str;
		exit( );
		break;
case "lanproplist" :
		$catid = $_POST['catid'];
		$nowid = $_POST['nowid'];
		$lang = $_POST['lang'];
		if ( $nowid != "" && $nowid != "0" )
		{
				$msql->query( "select * from {P}_news_con_translate where pid='{$nowid}' and langcode='{$lang}'" );
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
						$prop17 = $msql->f( "prop17" );
						$prop18 = $msql->f( "prop18" );
						$prop19 = $msql->f( "prop19" );
						$prop20 = $msql->f( "prop20" );
				}
		}
		$i = 1;
		$msql->query( "select * from {P}_news_prop where catid='{$catid}' order by xuhao" );
		while ( $msql->next_record( ) )
		{
				$oripropname = $msql->f( "propname" );
				$getid = $msql->f( "id" );
				$getprop = $fsql->getone( "select * from {P}_news_prop_translate where pid='{$getid}' and langcode='{$lang}'" );
				$propname = $getprop["propname"];
				if( $propname == "" ){
					$propname = $oripropname;
				}
				
				$pn = "prop".$i;
				if(strpos($propname,"|")!==false){
					list($propname, $type, $selects) = explode("|",$propname);
					$selectlists = explode(",",$selects);
					$str .= "<div class='form-group'>";
					$str .= "<label class='col-sm-1 control-label'>".$propname."</label>";
					$str .= "<div class='col-sm-6'>";
					
					if($type == "radio"){
						foreach($selectlists AS $radios){
							list($ranme, $rselect) = explode("^",$radios);
							if( $$pn == $rselect){
								$str .= "<label class='tcb-inline'><input type='radio' class='tc' name='s".$pn."[".$lang."]' value='".$rselect."' checked /><span class='labels'></span> ".$ranme."</label> ";
							}else{
								$str .= "<label class='tcb-inline'><input type='radio' class='tc' name='s".$pn."[".$lang."]' value='".$rselect."' /><span class='labels'></span> ".$ranme."</label> ";
							}
						}
					}elseif($type == "checkbox"){
						foreach($selectlists AS $radios){
							list($ranme, $rselect) = explode("^",$radios);
							if( stripos($$pn,$rselect) !== false ){
								$str .= "<label class='tcb-inline'><input type='checkbox' class='tc' name='s".$pn."[".$lang."][]' value='".$rselect."' checked /><span class='labels'></span> ".$ranme."</label> ";
							}else{
								$str .= "<label class='tcb-inline'><input type='checkbox' class='tc' name='s".$pn."[".$lang."][]' value='".$rselect."' /><span class='labels'></span> ".$ranme."</label> ";
							}
						}
					}
					$str .= "</div>";
					$str .= "<div class='clearfix'></div></div>";
				}else{
					$str .= "<div class='form-group'>";
					$str .= "<label class='col-sm-1 control-label'>".$propname."</label>";
					$str .= "<div class='col-sm-6'>";
					$str .= "<input type='text' name='s".$pn."[".$lang."]' value='".$$pn."' class='form-control' />";
					$str .= "</div>";
					$str .= "<div class='clearfix'></div></div>";
				}
				$i++;
		}
		$strs = "var M={LANG:'".$lang."', STR:'".addslashes($str)."'}";
		echo $strs;
		exit( );
		break;
case "addpage" :
		$nowid = $_POST['nowid'];
		$xuhao = 0;
		if ( $nowid != "" && $nowid != "0" )
		{
				$msql->query( "select max(xuhao) from {P}_news_pages where newsid='{$nowid}'" );
				if ( $msql->next_record( ) )
				{
						$xuhao = $msql->f( "max(xuhao)" );
				}
				$xuhao = $xuhao + 1;
				$msql->query( "insert into {P}_news_pages set newsid='{$nowid}',xuhao='{$xuhao}' " );
		}
		echo "OK";
		exit( );
		break;
case "newspageslist" :
		$nowid = $_POST['nowid'];
		$pageinit = $_POST['pageinit'];
		$str = "<div class='btn-group'>";
		$str .= "<button id='p_0' type='button' class='btn btn-inverse pages'>1</button>";
		$i = 2;
		$id = 0;
		$msql->query( "select id from {P}_news_pages where newsid='{$nowid}' order by xuhao" );
		while ( $msql->next_record( ) )
		{
				$id = $msql->f( "id" );
				$str .= "<button id='p_".$id."' type='button' class='btn btn-inverse pages'>".$i."</button>";
				$i++;
		}
		if ( $pageinit != "new" )
		{
				$id = $pageinit;
		}
		$str .= "</div>";
		$str .= "<div class='btn-group'><button id='addpage' type='button' class='btn btn-inverse'>".$strNewsPagesAdd."</button></div>";
		if ( $pageinit != "0" )
		{
				$str .= "<div class='btn-group'><button id='pagedelete' type='button' class='btn btn-inverse'>".$strNewsPagesDel."</button>";
				$str .= "<button id='backtomodi' type='button' class='btn btn-inverse'>".$strBack."</button></div>";
		}
		$str .= "</div><div class='btn-group'><button type='submit' name='modi' class='btn btn-primary'>".$strSave."</button>";
		$str .= "<input id='newspagesid' name='newspagesid' type='hidden' value='".$id."'>";
		$str .= "</div>";
		echo $str;
		exit( );
		break;
case "getcontent" :
		$nowid = $_POST['nowid'];
		$newspageid = $_POST['newspageid'];
		if ( $newspageid == "-1" )
		{
				$body = "";
		}
		else if ( $newspageid == "0" )
		{
				$msql->query( "select body from {P}_news_con where id='{$nowid}'" );
				if ( $msql->next_record( ) )
				{
						$body = $msql->f( "body" );
				}
		}
		else
		{
				$msql->query( "select body from {P}_news_pages where id='{$newspageid}'" );
				if ( $msql->next_record( ) )
				{
						$body = $msql->f( "body" );
				}
				else
				{
						$body = "";
				}
		}
		$body = path2url( $body );
		$body = html_entity_decode($body, ENT_QUOTES);
		echo $body;
		exit( );
		break;
case "getlancontent" :
		$nowid = $_POST['nowid'];
		$newspageid = $_POST['newspageid'];
		$lang = $_POST['lang'];
		if ( $newspageid == "-1" )
		{
				$body = "";
		}
		else if ( $newspageid == "0" )
		{
				$msql->query( "select body from {P}_news_con_translate where pid='{$nowid}' and langcode='{$lang}'" );
				if ( $msql->next_record( ) )
				{
						$body = $msql->f( "body" );
				}
		}
		else
		{
				$msql->query( "select body from {P}_news_pages_translate where pid='{$newspageid}' and langcode='{$lang}'" );
				if ( $msql->next_record( ) )
				{
						$body = $msql->f( "body" );
				}
				else
				{
						$body = "";
				}
		}
		$body = path2url( $body );
		//echo $body;
		$body = html_entity_decode($body, ENT_QUOTES);
		$str = "var M={LANG:'".$lang."', STR:'".addslashes($body)."'}";
		echo $str;
		exit( );
		break;
case "newsmodify" :
		$id = $_POST['id'];
		$pid = $_POST['pid'];
		$catid = $_POST['catid'];
		$page = $_POST['page'];
		$title = htmlspecialchars( $_POST['title'] );
		$author = htmlspecialchars( $_POST['author'] );
		$source = htmlspecialchars( $_POST['source'] );
		$tourl = trim( htmlspecialchars( $_POST['tourl'] ) );
		$xuhao = htmlspecialchars( $_POST['xuhao'] );
		//$body = $_POST['body'];
		$memo = $_POST['memo'];
		$fbtime = $_POST['fbtime'];
		$htime = $_POST['htime'];
		$oldcatid = $_POST['oldcatid'];
		$oldcatpath = $_POST['oldcatpath'];
		$prop1 = is_array($_POST['prop1'])? implode(",",$_POST['prop1']):htmlspecialchars( $_POST['prop1'] );		
		$prop2 = is_array($_POST['prop2'])? implode(",",$_POST['prop2']):htmlspecialchars( $_POST['prop2'] );
		$prop3 = is_array($_POST['prop3'])? implode(",",$_POST['prop3']):htmlspecialchars( $_POST['prop3'] );
		$prop4 = is_array($_POST['prop4'])? implode(",",$_POST['prop4']):htmlspecialchars( $_POST['prop4'] );
		$prop5 = is_array($_POST['prop5'])? implode(",",$_POST['prop5']):htmlspecialchars( $_POST['prop5'] );
		$prop6 = is_array($_POST['prop6'])? implode(",",$_POST['prop6']):htmlspecialchars( $_POST['prop6'] );
		$prop7 = is_array($_POST['prop7'])? implode(",",$_POST['prop7']):htmlspecialchars( $_POST['prop7'] );
		$prop8 = is_array($_POST['prop8'])? implode(",",$_POST['prop8']):htmlspecialchars( $_POST['prop8'] );
		$prop9 = is_array($_POST['prop9'])? implode(",",$_POST['prop9']):htmlspecialchars( $_POST['prop9'] );
		$prop10 = is_array($_POST['prop10'])? implode(",",$_POST['prop10']):htmlspecialchars( $_POST['prop10'] );
		$prop11 = is_array($_POST['prop11'])? implode(",",$_POST['prop11']):htmlspecialchars( $_POST['prop11'] );
		$prop12 = is_array($_POST['prop12'])? implode(",",$_POST['prop12']):htmlspecialchars( $_POST['prop12'] );
		$prop13 = is_array($_POST['prop13'])? implode(",",$_POST['prop13']):htmlspecialchars( $_POST['prop13'] );
		$prop14 = is_array($_POST['prop14'])? implode(",",$_POST['prop14']):htmlspecialchars( $_POST['prop14'] );
		$prop15 = is_array($_POST['prop15'])? implode(",",$_POST['prop15']):htmlspecialchars( $_POST['prop15'] );
		$prop16 = is_array($_POST['prop16'])? implode(",",$_POST['prop16']):htmlspecialchars( $_POST['prop16'] );
		$prop17 = is_array($_POST['prop17'])? implode(",",$_POST['prop17']):htmlspecialchars( $_POST['prop17'] );
		$prop18 = is_array($_POST['prop18'])? implode(",",$_POST['prop18']):htmlspecialchars( $_POST['prop18'] );
		$prop19 = is_array($_POST['prop19'])? implode(",",$_POST['prop19']):htmlspecialchars( $_POST['prop19'] );
		$prop20 = is_array($_POST['prop20'])? implode(",",$_POST['prop20']):htmlspecialchars( $_POST['prop20'] );
		$downcentid = htmlspecialchars( $_POST['downcentid'] );
		$downcent = htmlspecialchars( $_POST['downcent'] );
		$tags = $_POST['tags'];
		$spe_selec = $_POST['spe_selec'];
		$pic = $_FILES['jpg'];
		$file = $_FILES['file'];
		$fileurl = $_POST['fileurl'];
		
		$body = $_FILES['body'];
		
		if ( 0 < $pic['size'] || 0 < $file['size'] )
		{
				$Meta = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		}
		if ( 0 < $body['size'] )
		{
				$Meta = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		}
		if ( $title == "" )
		{
				echo $Meta.$strNewsNotice6;
				exit( );
		}
		if ( 200 < strlen( $title ) )
		{
				echo $Meta.$strNewsNotice7;
				exit( );
		}
		/*if ( 65000 < strlen( $body ) )
		{
				echo $Meta.$strNewsNotice5;
				exit( );
		}*/
		if ( strstr( $tourl, "." ) )
		{
				echo $Meta.$strNewsNotice15;
				exit( );
		}
		$timearr = explode( "-", $fbtime );
		$htimearr = explode( "-", $htime );
		$yy = $timearr[0];
		$mm = $timearr[1];
		$dd = $timearr[2];
		$hh = $htimearr[0];
		$ii = $htimearr[1];
		$ss = $htimearr[2];
		$dtime = mktime( $hh, $ii, $ss, $mm, $dd, $yy );
		$uptime = time( );
		//$body = url2path( $body );
		$title = str_replace( "{#", "", $title );
		$title = str_replace( "#}", "", $title );
		$memo = str_replace( "{#", "", $memo );
		$memo = str_replace( "#}", "", $memo );
		/*$body = str_replace( "{#", "{ #", $body );
		$body = str_replace( "#}", "# }", $body );*/
		$msql->query( "select catpath from {P}_news_cat where catid='{$catid}'" );
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

		if ( 0 < $file['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../upload/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "news/upload/".$nowdate;
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
				$msql->query( "select fileurl from {P}_news_con where id='{$id}'" );
				if ( $msql->next_record( ) )
				{
						$oldfileurl = $msql->f( "fileurl" );
				}
				if ( file_exists( ROOTPATH.$oldfileurl ) && $oldfileurl != "" && !strstr( $oldfileurl, "../" ) )
				{
						unlink( ROOTPATH.$oldfileurl );
				}
		}
		$msql->query( "select * from {P}_news_config where `variable`='PhotoBWH'" );
		if ( $msql->next_record( ) )
		{
				list($PhotoBW,$PhotoBH) = explode("|",$msql->f( "value" ));
		}
		$msql->query( "select * from {P}_news_config where `variable`='PhotoSWH'" );
		if ( $msql->next_record( ) )
		{
				list($PhotoSW,$PhotoSH) = explode("|",$msql->f( "value" ));
		}
		if ( 0 < $pic['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "news/pics/".$nowdate;
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
				$msql->query( "select src from {P}_news_con where id='{$id}'" );
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
				$msql->query( "update {P}_news_con set src='{$src}' where id='{$id}'" );
		}
		
		if ( 0 < $body['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 0777 );
				$uppath = "news/pics/".$nowdate;
				$arr = newuploadimage( $body['tmp_name'], $body['type'], $body['size'], $uppath, $PhotoBW, $PhotoBH, $PhotoSW, $PhotoSH );
				if ( $arr[0] != "err" )
				{
						$src = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
				$msql->query( "select body from {P}_news_con where id='{$id}'" );
				if ( $msql->next_record( ) )
				{
						$oldbody = $msql->f( "body" );
				}
				if ( file_exists( ROOTPATH.$oldbody ) && $oldbody != "" && !strstr( $oldbody, "../" ) )
				{
						unlink( ROOTPATH.$oldbody );
						$getpic = basename($oldbody);
						$getpicpath = dirname($oldbody);
						@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
				}
				$msql->query( "update {P}_news_con set body='{$src}' where id='{$id}'" );
		}
		
		/*for ( $t = 0;	$t < sizeof( $tags );	$t++	)
		{
				if ( $tags[$t] != "" )
				{
						$tagstr .= $tags[$t].",";
				}
		}*/
		$tagstr = $tags;
		$msql->query( "update {P}_news_con set 
			title='{$title}',
			memo='{$memo}',
			fileurl='{$fileurl}',
			catid='{$catid}',
			catpath='{$catpath}',
			dtime='{$dtime}',
			uptime='{$uptime}',
			xuhao='{$xuhao}',
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
			prop20='{$prop20}',
			downcentid='{$downcentid}',
			downcent='{$downcent}',
			tourl='{$tourl}' 
			where id='{$id}'
		" );
		
	//記錄多國翻譯資料
	$langlist = $_POST['langlist'];
	if($langlist != ""){			
		$stitle = $_POST['stitle'];
		$stourl = $_POST['stourl'];
		$smemo = $_POST['smemo'];
		$sbody = $_POST['sbody'];
		$spic = $_FILES['sjpg'];
		$soldsrc = $_POST['oldsrc'];			
		$sprop1 = $_POST['sprop1'];
		$sprop2 = $_POST['sprop2'];
		$sprop3 = $_POST['sprop3'];
		$sprop4 = $_POST['sprop4'];
		$sprop5 = $_POST['sprop5'];
		$sprop6 = $_POST['sprop6'];
		$sprop7 = $_POST['sprop7'];
		$sprop8 = $_POST['sprop8'];
		$sprop9 = $_POST['sprop9'];
		$sprop10 = $_POST['sprop10'];
		$sprop11 = $_POST['sprop11'];
		$sprop12 = $_POST['sprop12'];
		$sprop13 = $_POST['sprop13'];
		$sprop14 = $_POST['sprop14'];
		$sprop15 = $_POST['sprop15'];
		$sprop16 = $_POST['sprop16'];
		$sprop17 = $_POST['sprop17'];
		$sprop18 = $_POST['sprop18'];
		$sprop19 = $_POST['sprop19'];
		$sprop20 = $_POST['sprop20'];
		
		$lans = explode(",",$langlist);
		foreach($lans AS $ks=>$vs){
			//擷取各語言資料並寫入
			$title = htmlspecialchars($stitle[$vs]);
			$tourl = htmlspecialchars($stourl[$vs]);
			$memo = htmlspecialchars($smemo[$vs]);
			$body = $sbody[$vs];
			$oldsrc = $soldsrc[$vs];
			$prop1 = is_array($sprop1[$vs])? implode(",", $sprop1[$vs]):$sprop1[$vs];
			$prop2 = is_array($sprop2[$vs])? implode(",", $sprop2[$vs]):$sprop2[$vs];
			$prop3 = is_array($sprop3[$vs])? implode(",", $sprop3[$vs]):$sprop3[$vs];
			$prop4 = is_array($sprop4[$vs])? implode(",", $sprop4[$vs]):$sprop4[$vs];
			$prop5 = is_array($sprop5[$vs])? implode(",", $sprop5[$vs]):$sprop5[$vs];
			$prop6 = is_array($sprop6[$vs])? implode(",", $sprop6[$vs]):$sprop6[$vs];
			$prop7 = is_array($sprop7[$vs])? implode(",", $sprop7[$vs]):$sprop7[$vs];
			$prop8 = is_array($sprop8[$vs])? implode(",", $sprop8[$vs]):$sprop8[$vs];
			$prop9 = is_array($sprop9[$vs])? implode(",", $sprop9[$vs]):$sprop9[$vs];
			$prop10 = is_array($sprop10[$vs])? implode(",", $sprop10[$vs]):$sprop10[$vs];
			$prop11 = is_array($sprop11[$vs])? implode(",", $sprop11[$vs]):$sprop11[$vs];
			$prop12 = is_array($sprop12[$vs])? implode(",", $sprop12[$vs]):$sprop12[$vs];
			$prop13 = is_array($sprop13[$vs])? implode(",", $sprop13[$vs]):$sprop13[$vs];
			$prop14 = is_array($sprop14[$vs])? implode(",", $sprop14[$vs]):$sprop14[$vs];
			$prop15 = is_array($sprop15[$vs])? implode(",", $sprop15[$vs]):$sprop15[$vs];
			$prop16 = is_array($sprop16[$vs])? implode(",", $sprop16[$vs]):$sprop16[$vs];
			$prop17 = is_array($sprop17[$vs])? implode(",", $sprop17[$vs]):$sprop17[$vs];
			$prop18 = is_array($sprop18[$vs])? implode(",", $sprop18[$vs]):$sprop17[$vs];
			$prop19 = is_array($sprop19[$vs])? implode(",", $sprop19[$vs]):$sprop19[$vs];
			$prop20 = is_array($sprop10[$vs])? implode(",", $sprop10[$vs]):$sprop20[$vs];
			
			if ( 0 < $spic['size'][$vs] )
			{
					$nowdate = date( "Ymd", time( ) );
					$picpath = "../pics/".$nowdate;
					@mkdir( $picpath, 511 );
					$uppath = "news/pics/".$nowdate;
					$arr = newuploadimage( $spic['tmp_name'][$vs], $spic['type'][$vs], $spic['size'][$vs], $uppath);
					if ( $arr[0] != "err" )
					{
							$src = $arr[3];
					}
					else
					{
							err( $arr[1]."[".$vs."]", "", "" );
					}
					if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )
					{
							@unlink( ROOTPATH.$oldsrc );
							$getpic = basename($oldsrc);
							$getpicpath = dirname($oldsrc);
							@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
					}
			}else{
				$src = $oldsrc;
			}
			
				//getupdate 資料若存在則更新，否則新增
				$msql->getupdate(
					"SELECT id FROM {P}_news_con_translate WHERE pid='{$id}' AND langcode='{$vs}'",
					"UPDATE {P}_news_con_translate SET 
					title='{$title}',
					memo='{$memo}',
					tourl='{$tourl}',
					body='{$body}',
					src='{$src}',
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
					WHERE pid='{$id}' AND langcode='{$vs}'",
					"INSERT INTO {P}_news_con_translate SET 
					pid='{$id}',
					langcode='{$vs}',
					title='{$title}',
					memo='{$memo}',
					tourl='{$tourl}',
					body='{$body}',
					src='{$src}',
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
					prop20='{$prop20}'"
				);
		}
	}
	//記錄多國翻譯資料 END
		
		echo "OK";
		exit( );
		break;
case "contentmodify" :
		$newspagesid = $_POST['newspagesid'];
		$body = $_FILES['bodys'];
		
		if ( 0 < $body['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 0777 );
				$uppath = "news/pics/".$nowdate;
				$msql->query( "select * from {P}_news_config where `variable`='PhotoBWH'" );
				if ( $msql->next_record( ) )
				{
						list($PhotoBW,$PhotoBH) = explode("|",$msql->f( "value" ));
				}
				$msql->query( "select * from {P}_news_config where `variable`='PhotoSWH'" );
				if ( $msql->next_record( ) )
				{
						list($PhotoSW,$PhotoSH) = explode("|",$msql->f( "value" ));
				}
				$arr = newuploadimage( $body['tmp_name'], $body['type'], $body['size'], $uppath, $PhotoBW, $PhotoBH, $PhotoSW, $PhotoSH );
				if ( $arr[0] != "err" )
				{
						$src = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
				$msql->query( "select body from {P}_news_pages where id='{$newspagesid}'" );
				if ( $msql->next_record( ) )
				{
						$oldbody = $msql->f( "body" );
				}
				if ( file_exists( ROOTPATH.$oldbody ) && $oldbody != "" && !strstr( $oldbody, "../" ) )
				{
						unlink( ROOTPATH.$oldbody );
						$getpic = basename($oldbody);
						$getpicpath = dirname($oldbody);
						@unlink( ROOTPATH.$getpicpath."/sp_".$getpic );
				}
				$msql->query( "update {P}_news_pages set body='{$src}' where id='{$newspagesid}'" );
		}
		
		//exit("bodys:".$body);
		
		/*if ( 6500000 < strlen( $body ) )
		{
				echo $strNewsNotice5;
				exit( );
		}*/
		//$body = url2path( $body );
		//$msql->query( "update {P}_news_pages set body='{$body}' where id='{$newspagesid}'" );
		
//記錄多國翻譯資料
	$langlist = $_POST['langlist'];
	if($langlist != ""){			
		$sbodys = $_POST['sbodys'];
		
		
		$lans = explode(",",$langlist);
		foreach($lans AS $ks=>$vs){
			//擷取各語言資料並寫入
			$body = $sbodys[$vs];
			
				//getupdate 資料若存在則更新，否則新增
				$msql->getupdate(
					"SELECT id FROM {P}_news_pages_translate WHERE pid='{$newspagesid}' AND langcode='{$vs}'",
					"UPDATE {P}_news_pages_translate SET 
					body='{$body}' 
					WHERE pid='{$newspagesid}' AND langcode='{$vs}'",
					"INSERT INTO {P}_news_pages_translate SET 
					pid='{$newspagesid}',
					langcode='{$vs}',
					body='{$body}'"
				);
		}
	}
	//記錄多國翻譯資料 END
		
		echo "OK";
		exit( );
		break;
case "newsadd" :
		$catid = $_POST['catid'];
		$body = $_POST['body'];
		$title = htmlspecialchars( $_POST['title'] );
		$author = htmlspecialchars( $_POST['author'] );
		$source = htmlspecialchars( $_POST['source'] );
		$tourl = trim( htmlspecialchars( $_POST['tourl'] ) );
		$memo = $_POST['memo'];
		$fbtime = $_POST['fbtime'];	
		$prop1 = is_array($_POST['prop1'])? implode(",",$_POST['prop1']):htmlspecialchars( $_POST['prop1'] );
		$prop2 = is_array($_POST['prop2'])? implode(",",$_POST['prop2']):htmlspecialchars( $_POST['prop2'] );
		$prop3 = is_array($_POST['prop3'])? implode(",",$_POST['prop3']):htmlspecialchars( $_POST['prop3'] );
		$prop4 = is_array($_POST['prop4'])? implode(",",$_POST['prop4']):htmlspecialchars( $_POST['prop4'] );
		$prop5 = is_array($_POST['prop5'])? implode(",",$_POST['prop5']):htmlspecialchars( $_POST['prop5'] );
		$prop6 = is_array($_POST['prop6'])? implode(",",$_POST['prop6']):htmlspecialchars( $_POST['prop6'] );
		$prop7 = is_array($_POST['prop7'])? implode(",",$_POST['prop7']):htmlspecialchars( $_POST['prop7'] );
		$prop8 = is_array($_POST['prop8'])? implode(",",$_POST['prop8']):htmlspecialchars( $_POST['prop8'] );
		$prop9 = is_array($_POST['prop9'])? implode(",",$_POST['prop9']):htmlspecialchars( $_POST['prop9'] );
		$prop10 = is_array($_POST['prop10'])? implode(",",$_POST['prop10']):htmlspecialchars( $_POST['prop10'] );
		$prop11 = is_array($_POST['prop11'])? implode(",",$_POST['prop11']):htmlspecialchars( $_POST['prop11'] );
		$prop12 = is_array($_POST['prop12'])? implode(",",$_POST['prop12']):htmlspecialchars( $_POST['prop12'] );
		$prop13 = is_array($_POST['prop13'])? implode(",",$_POST['prop13']):htmlspecialchars( $_POST['prop13'] );
		$prop14 = is_array($_POST['prop14'])? implode(",",$_POST['prop14']):htmlspecialchars( $_POST['prop14'] );
		$prop15 = is_array($_POST['prop15'])? implode(",",$_POST['prop15']):htmlspecialchars( $_POST['prop15'] );
		$prop16 = is_array($_POST['prop16'])? implode(",",$_POST['prop16']):htmlspecialchars( $_POST['prop16'] );
		$prop17 = is_array($_POST['prop17'])? implode(",",$_POST['prop17']):htmlspecialchars( $_POST['prop17'] );
		$prop18 = is_array($_POST['prop18'])? implode(",",$_POST['prop18']):htmlspecialchars( $_POST['prop18'] );
		$prop19 = is_array($_POST['prop19'])? implode(",",$_POST['prop19']):htmlspecialchars( $_POST['prop19'] );
		$prop20 = is_array($_POST['prop20'])? implode(",",$_POST['prop20']):htmlspecialchars( $_POST['prop20'] );
		$downcentid = htmlspecialchars( $_POST['downcentid'] );
		$downcent = htmlspecialchars( $_POST['downcent'] );
		$tags = $_POST['tags'];
		trylimit( "_news_con", 100, "id" );
		$fileurl = $_POST['fileurl'];
		$pic = $_FILES['jpg'];
		$file = $_FILES['file'];
		$spe_selec = $_POST['spe_selec'];
		if ( 0 < $pic['size'] || 0 < $file['size'] )
		{
				$Meta = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
		}
		if ( $title == "" )
		{
				echo $Meta.$strNewsNotice6;
				exit( );
		}
		if ( 200 < strlen( $title ) )
		{
				echo $Meta.$strNewsNotice7;
				exit( );
		}
		if ( 65000 < strlen( $body ) )
		{
				echo $Meta.$strNewsNotice5;
				exit( );
		}
		if ( strstr( $tourl, "." ) )
		{
				echo $Meta.$strNewsNotice15;
				exit( );
		}
		$timearr = explode( "-", $fbtime );
		$yy = $timearr[0];
		$mm = $timearr[1];
		$dd = $timearr[2];
		$hh = date( "H", time( ) );
		$ii = date( "i", time( ) );
		$ss = date( "s", time( ) );
		$dtime = mktime( $hh, $ii, $ss, $mm, $dd, $yy );
		$uptime = $dtime;
		$msql->query( "select catpath from {P}_news_cat where catid='{$catid}'" );
		if ( $msql->next_record( ) )
		{
				$catpath = $msql->f( "catpath" );
		}
		$body = url2path( $body );
		$title = str_replace( "{#", "", $title );
		$title = str_replace( "#}", "", $title );
		$memo = str_replace( "{#", "", $memo );
		$memo = str_replace( "#}", "", $memo );
		$body = str_replace( "{#", "{ #", $body );
		$body = str_replace( "#}", "# }", $body );
		$msql->query( "select * from {P}_news_config where `variable`='PhotoBWH'" );
		if ( $msql->next_record( ) )
		{
				list($PhotoBW,$PhotoBH) = explode("|",$msql->f( "value" ));
		}
		$msql->query( "select * from {P}_news_config where `variable`='PhotoSWH'" );
		if ( $msql->next_record( ) )
		{
				list($PhotoSW,$PhotoSH) = explode("|",$msql->f( "value" ));
		}
		if ( 0 < $pic['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "news/pics/".$nowdate;
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
		if ( 0 < $file['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../upload/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "news/upload/".$nowdate;
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
		}
		$count_pro = count( $spe_selec );
		
		for ( $i = 0;	$i < $count_pro;	$i++	)
		{
				$projid = $spe_selec[$i];
				$projpath .= $projid.":";
		}
		
		/*for ( $t = 0;	$t < sizeof( $tags );	$t++	)
		{
				if ( $tags[$t] != "" )
				{
						$tagstr .= $tags[$t].",";
				}
		}*/
		$tagstr = $tags;
		$msql->query( "insert into {P}_news_con set
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
		uptime='{$uptime}',
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
		prop20='{$prop20}',
		downcentid='{$downcentid}',
		downcent='{$downcent}',
		tourl='{$tourl}',
		fileurl='{$fileurl}'
		" );
		echo "OK";
		exit( );
		break;
case "pagedelete" :
		$delpagesid = $_POST['delpagesid'];
		$nowid = $_POST['nowid'];
		$i = 0;
		$msql->query( "select id from {P}_news_pages where newsid='{$nowid}' order by xuhao" );
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
		$msql->query( "delete from {P}_news_pages where id='{$delpagesid}'" );
		//刪除多語言
		$msql->query( "delete from {P}_news_pages_translate where pid='{$delpagesid}'" );
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
		$arr = array( "main", "html", "class", "detail", "query", "index", "admin", "newsgl", "newsfabu", "newsmodify", "newscat", "news" );
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
		$msql->query( "select id from {P}_news_proj where folder='{$folder}'" );
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
		$msql->query( "insert into {P}_news_proj set 
			`project`='{$project}',
			`folder`='{$folder}'
		" );
		$msql->query( "insert into {P}_base_pageset set 
			`name`='{$project}',
			`coltype`='news',
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
		$msql->query( "select cat from {P}_news_cat where catid='{$catid}'" );
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
		$msql->query( "update {P}_news_cat set `ifchannel`='1' where catid='{$catid}'" );
		$msql->query( "select id from {P}_base_pageset where coltype='news' and pagename='{$pagename}'" );
		if ( $msql->next_record( ) )
		{
		}
		else
		{
				$fsql->query( "insert into {P}_base_pageset set 
			`name`='{$cat}',
			`coltype`='news',
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
		$msql->query( "select catid from {P}_news_cat where catid='{$catid}'" );
		if ( $msql->next_record( ) )
		{
		}
		else
		{
				echo $strZlNTC2;
				exit( );
		}
		$pagename = "class_".$catid;
		$msql->query( "delete from {P}_base_pageset where coltype='news' and pagename='{$pagename}'" );
		$msql->query( "delete from {P}_base_plus where plustype='news' and pluslocat='{$pagename}'" );
		$msql->query( "update {P}_news_cat set `ifchannel`='0' where catid='{$catid}'" );
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
				$msql->query( "update {P}_news_cat set `cattemp`='1' where catid='{$catid}'" );
				$chgdb= array('query','detail');
				foreach($chgdb AS $chgname){
				$msql->query( "select * from {P}_base_pageset where coltype='news' and pagename='{$chgname}'" );
				if ( $msql->next_record( ) )
				{
					$fsql->query( "insert into {P}_base_pageset (`id`, `name`, `coltype`, `pagename`, `th`, `ch`, `bh`, `pagetitle`, `metakey`, `metacon`, `bgcolor`, `bgimage`, `bgposition`, `bgrepeat`, `bgatt`, `containwidth`, `containbg`, `containimg`, `containmargin`, `containpadding`, `containcenter`, `topbg`, `topwidth`, `contentbg`, `contentwidth`, `contentmargin`, `bottombg`, `bottomwidth`, `buildhtml`, `xuhao`) VALUES (NULL,'{$msql->f('name')}','{$msql->f('coltype')}','{$chgname}_{$catid}','{$msql->f('th')}','{$msql->f('ch')}','{$msql->f('bh')}','{$msql->f('pagetitle')}','{$msql->f('metakey')}','{$msql->f('metacon')}','{$msql->f('bgcolor')}','{$msql->f('bgimage')}','{$msql->f('bgposition')}','{$msql->f('bgrepeat')}','{$msql->f('bgatt')}','{$msql->f('containwidth')}','{$msql->f('containbg')}','{$msql->f('containimg')}','{$msql->f('containmargin')}','{$msql->f('containpadding')}','{$msql->f('containcenter')}','{$msql->f('topbg')}','{$msql->f('topwidth')}','{$msql->f('contentbg')}','{$msql->f('contentwidth')}','{$msql->f('contentmargin')}','{$msql->f('bottombg')}','{$msql->f('bottomwidth')}','{$msql->f('buildhtml')}','{$msql->f('xuhao')}') " );
				}
				else
				{
								echo $strZlNTC2;
								exit( );
				}
				
				$msql->query( "select * from {P}_base_plusdefault where coltype='news' and pluslocat='{$chgname}'" );
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
				$msql->query( "select catid from {P}_news_cat where catid='{$catid}'" );
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
				$msql->query( "delete from {P}_base_pageset where coltype='news' and pagename='{$pagename}'" );
				$msql->query( "delete from {P}_base_plusdefault where plustype='news' and pluslocat='{$pagename}'" );
				$msql->query( "delete from {P}_base_plus where plustype='news' and pluslocat='{$pagename}'" );
				$msql->query( "update {P}_news_cat set `cattemp`='0' where catid='{$catid}'" );
				}
				echo "OK";
				exit( );
				break;
}
?>