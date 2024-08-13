<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH . "includes/admin.inc.php" );
include( "language/" . $sLan . ".php" );
include( "func/paper.inc.php" );
include( ROOTPATH."api/xmlapi.php" );
needauth( 0 );

//CPANEL START
$getUser=$GLOBALS["PAPERCONF"]["CpanelUser"];
$ip = $_SERVER["SERVER_ADDR"];
$root_pass = $GLOBALS["PAPERCONF"]["CpanelPasswd"];
$root_port = $GLOBALS["PAPERCONF"]["CpanelPort"];
$xmlapi = new xmlapi($ip);
$xmlapi->password_auth($getUser,$root_pass);
$xmlapi->set_port($root_port);
$xmlapi->set_output('json');
$xmlapi->set_debug(0);
$sitename = $GLOBALS['GLOBALS']['CONF'][SiteName];
//CPANEL END

$act = $_POST['act'];
switch ( $act ) {
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
	//工作排程
    case "conticron":
		//CPANEL START
		$getUser=$GLOBALS["PAPERCONF"]["CpanelUser"];
		$ip = $_SERVER["SERVER_ADDR"];
		$root_pass = $GLOBALS["PAPERCONF"]["CpanelPasswd"];
		$root_port = $GLOBALS["PAPERCONF"]["CpanelPort"];
		$xmlapi = new xmlapi($ip);
		$xmlapi->password_auth($getUser,$root_pass);
		$xmlapi->set_port($root_port);
		$xmlapi->set_output('json');
		$xmlapi->set_debug(0);
		$sitename = $GLOBALS['GLOBALS']['CONF'][SiteName];
		//CPANEL END
    	$cid = $_POST['cid'];
    	
    	$fsql->query( "select * from {P}_paper_cron where ifclose='0'" );
		if ( $fsql->next_record( ) )
		{
			echo "1001";
			exit();
		}
		
		$getcid = $fsql->getone( "select pid from {P}_paper_cron where id='{$cid}'" );
    	$fsql->query( "select * from {P}_paper_con where id='{$getcid[pid]}'" );
		if ( !$fsql->next_record( ) )
		{
			echo "1002";
			exit();
		}
		//執行程式寄信通知的信箱，留空則不通知
		$args = array ( 'email' => '' ); 
		$xmlapi->api2_query($getUser, 'Cron','set_email', $args);
		
       
    
        //執行程式的路徑
        			$thisminute = date("i")+1;
					$command = 'php '.$_SERVER["DOCUMENT_ROOT"].'/paper/cronjobs/cronjobs_'.$cid.'.php'; 
					$args = array ( 'command' => $command, 
                		'day' => '*', 
                		//'hour' => '*/1', 
                		//'minute' => $thisminute, 
                		'hour' => '*', 
                		'minute' => '*/3', 
                		'month' => '*', 
                		'weekday' => '*', 
                	);
					$value = $xmlapi->api2_query($getUser, 'Cron','add_line', $args);
					$getSubValue=json_decode($value,TRUE);
					$linekey = $getSubValue["cpanelresult"]["data"]["0"]["linekey"];
					$msql->query( "UPDATE {P}_paper_cron SET ifclose='0',linekey='{$linekey}' WHERE id='$cid'" );
				
					@mkdir( "../cronjobs", 0755 );
					$fd = fopen( "../cronjobs/temp.php", "r" );
					$str = fread( $fd, "50000" );
					$str_html = str_replace( "DefaultPID", $cid, $str );
					$str_html = str_replace( "DefaultSITENAME", $sitename, $str_html );
					fclose( $fd );
					$filename = '../cronjobs/cronjobs_'.$cid.'.php';
					$fp = fopen( $filename, "w" );
					fwrite( $fp, $str_html );
					fclose( $fp );
					@chmod( $filename, 0664 );
        echo "OK";
        exit();
        break;
    case "stopcron":
        $cid = $_POST['cid'];
    	$filename = "cronjobs_".$cid.".php";
    	
			//列出排程表
			$value = $xmlapi->api2_query($getUser, 'Cron','listcron');
			$getSubValue=json_decode($value,TRUE);
			$takevalue = $getSubValue["cpanelresult"]["data"];
			//尋找排程命令中的檔案名稱與本排程相符，則刪除
			foreach($takevalue AS $key=>$cronvalue){
				if( strpos($cronvalue["command"],$filename) !== FALSE){
					//刪除排程
					$linekey = $cronvalue["count"];
					$args = array ( 'line' => $linekey );
					$xmlapi->api2_query($getUser, 'Cron','remove_line', $args);
					$msql->query( "UPDATE {P}_paper_cron SET ifclose='1' WHERE id='$cid'" );
					echo "OK";
        			exit();
				}
			}
		$msql->query( "UPDATE {P}_paper_cron SET ifclose='1' WHERE id='$cid'" );
        echo "1001";
        exit();
        break;
case "proplist" :
		$catid = $_POST['catid'];
		$nowid = $_POST['nowid'];
		if ( $nowid != "" && $nowid != "0" )
		{
				$msql->query( "select * from {P}_paper_con where  id='{$nowid}'" );
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
		$msql->query( "select * from {P}_paper_prop where catid='{$catid}' order by xuhao" );
		while ( $msql->next_record( ) )
		{
				$propname = $msql->f( "propname" );
				$pn = "prop".$i;
				if(strpos($propname,"|")!==false){
					list($propname, $selects) = explode("|",$propname);
					$selectlists = explode(",",$selects);
					$str .= "<div class='form-group'>";
					$str .= "<label class='col-sm-1 control-label'>".$propname."</label>";
					$str .= "<div class='col-sm-6'>";
					
					foreach($selectlists AS $radios){
						list($ranme, $rselect) = explode("^",$radios);
						if( $$pn == $rselect){
							$str .= "<label class='tcb-inline'><input type='radio' class='tc' name='".$pn."' value='".$rselect."' checked /><span class='labels'></span> ".$ranme."</label> ";
						}else{
							$str .= "<label class='tcb-inline'><input type='radio' class='tc' name='".$pn."' value='".$rselect."' /><span class='labels'></span> ".$ranme."</label> ";
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
				$msql->query( "select * from {P}_paper_con_translate where pid='{$nowid}' and langcode='{$lang}'" );
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
		$msql->query( "select * from {P}_paper_prop where catid='{$catid}' order by xuhao" );
		while ( $msql->next_record( ) )
		{
				$oripropname = $msql->f( "propname" );
				$getid = $msql->f( "id" );
				$getprop = $fsql->getone( "select * from {P}_paper_prop_translate where pid='{$getid}' and langcode='{$lang}'" );
				$propname = $getprop["propname"];
				if( $propname == "" ){
					$propname = $oripropname;
				}
				
				$pn = "prop".$i;
				if(strpos($propname,"|")!==false){
					list($propname, $selects) = explode("|",$propname);
					$selectlists = explode(",",$selects);
					$str .= "<div class='form-group'>";
					$str .= "<label class='col-sm-1 control-label'>".$propname."</label>";
					$str .= "<div class='col-sm-6'>";
					
					foreach($selectlists AS $radios){
						list($ranme, $rselect) = explode("^",$radios);
						if( $$pn == $rselect){
							$str .= "<label class='tcb-inline'><input type='radio' class='tc' name='s".$pn."[".$lang."]' value='".$rselect."' checked /><span class='labels'></span> ".$ranme."</label> ";
						}else{
							$str .= "<label class='tcb-inline'><input type='radio' class='tc' name='s".$pn."[".$lang."]' value='".$rselect."' /><span class='labels'></span> ".$ranme."</label> ";
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
    case "addpage":
        $nowid = $_POST['nowid'];
        $xuhao = 0;
        if ( $nowid != "" && $nowid != "0" ) {
            $msql->query( "select max(xuhao) from {P}_paper_pages where paperid='{$nowid}'" );
            if ( $msql->next_record() ) {
                $xuhao = $msql->f( "max(xuhao)" );
            }
            $xuhao = $xuhao + 1;
            $msql->query( "insert into {P}_paper_pages set paperid='{$nowid}',xuhao='{$xuhao}' " );
        }
        echo "OK";
        exit();
        break;
    case "paperpageslist":
        $nowid    = $_POST['nowid'];
        $pageinit = $_POST['pageinit'];
        $str      = "<ul>";
        $str .= "<li id='p_0' class='pages'>1</li>";
        $i  = 2;
        $id = 0;
        $msql->query( "select id from {P}_paper_pages where paperid='{$nowid}' order by xuhao" );
        while ( $msql->next_record() ) {
            $id = $msql->f( "id" );
            $str .= "<li id='p_" . $id . "' class='pages'>" . $i . "</li>";
            $i++;
        }
        if ( $pageinit != "new" ) {
            $id = $pageinit;
        }
        $str .= "<li id='addpage' class='addbutton'>" . $strPaperPagesAdd . "</li>";
        if ( $pageinit != "0" ) {
            $str .= "<li id='pagedelete' class='addbutton'>" . $strPaperPagesDel . "</li>";
            $str .= "<li id='backtomodi' class='addbutton'>" . $strBack . "</li>";
        }
        $str .= "<input  type='submit' name='modi'  onClick='KindSubmit();' value='" . $strSave . "' class='savebutton' />";
        $str .= "</ul><input id='paperpagesid' name='paperpagesid' type='hidden' value='" . $id . "'>";
        echo $str;
        exit();
        break;
    case "getcontent":
        $nowid       = $_POST['nowid'];
        $paperpageid = $_POST['paperpageid'];
        if ( $paperpageid == "-1" ) {
            $body = "";
        } else if ( $paperpageid == "0" ) {
            $msql->query( "select body from {P}_paper_con where id='{$nowid}'" );
            if ( $msql->next_record() ) {
                $body = $msql->f( "body" );
            }
        } else {
            $msql->query( "select body from {P}_paper_pages where id='{$paperpageid}'" );
            if ( $msql->next_record() ) {
                $body = $msql->f( "body" );
            } else {
                $body = "";
            }
        }
        $body = path2url( $body );
        echo $body;
        exit();
        break;
    case "papermodify":
        $id         = $_POST['id'];
        $pid        = $_POST['pid'];
        $catid      = $_POST['catid'];
        $page       = $_POST['page'];
        $title      = htmlspecialchars( $_POST['title'] );
        $author     = htmlspecialchars( $_POST['author'] );
        $source     = htmlspecialchars( $_POST['source'] );
        $tourl      = trim( htmlspecialchars( $_POST['tourl'] ) );
        $xuhao      = htmlspecialchars( $_POST['xuhao'] );
        $body       = $_POST['body'];
        $memo       = $_POST['memo'];
        $fbtime     = $_POST['fbtime'];
        $htime      = $_POST['htime'];
        $oldcatid   = $_POST['oldcatid'];
        $oldcatpath = $_POST['oldcatpath'];
        $prop1      = htmlspecialchars( $_POST['prop1'] );
        $prop2      = htmlspecialchars( $_POST['prop2'] );
        $prop3      = htmlspecialchars( $_POST['prop3'] );
        $prop4      = htmlspecialchars( $_POST['prop4'] );
        $prop5      = htmlspecialchars( $_POST['prop5'] );
        $prop6      = htmlspecialchars( $_POST['prop6'] );
        $prop7      = htmlspecialchars( $_POST['prop7'] );
        $prop8      = htmlspecialchars( $_POST['prop8'] );
        $prop9      = htmlspecialchars( $_POST['prop9'] );
        $prop10     = htmlspecialchars( $_POST['prop10'] );
        $prop11     = htmlspecialchars( $_POST['prop11'] );
        $prop12     = htmlspecialchars( $_POST['prop12'] );
        $prop13     = htmlspecialchars( $_POST['prop13'] );
        $prop14     = htmlspecialchars( $_POST['prop14'] );
        $prop15     = htmlspecialchars( $_POST['prop15'] );
        $prop16     = htmlspecialchars( $_POST['prop16'] );
        $prop17     = htmlspecialchars( $_POST['prop17'] );
        $prop18     = htmlspecialchars( $_POST['prop18'] );
        $prop19     = htmlspecialchars( $_POST['prop19'] );
        $prop20     = htmlspecialchars( $_POST['prop20'] );
        $downcentid = htmlspecialchars( $_POST['downcentid'] );
        $downcent   = htmlspecialchars( $_POST['downcent'] );
        $tags       = $_POST['tags'];
        $spe_selec  = $_POST['spe_selec'];
        $pic        = $_FILES['jpg'];
        if ( 0 < $pic['size'] || 0 < $file['size'] ) {
            $Meta = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
        }
        if ( $title == "" ) {
            echo $Meta . $strPaperNotice6;
            exit();
        }
        if ( 200 < strlen( $title ) ) {
            echo $Meta . $strPaperNotice7;
            exit();
        }
        if ( 65000 < strlen( $body ) ) {
            echo $Meta . $strPaperNotice5;
            exit();
        }
        if ( strstr( $tourl, "../" ) ) {
            echo $Meta . $strPaperNotice15;
            exit();
        }
        $timearr  = explode( "-", $fbtime );
        $htimearr = explode( "-", $htime );
        $yy       = $timearr[0];
        $mm       = $timearr[1];
        $dd       = $timearr[2];
        $hh       = $htimearr[0];
        $ii       = $htimearr[1];
        $ss       = $htimearr[2];
        $dtime    = mktime( $hh, $ii, $ss, $mm, $dd, $yy );
        $uptime   = time();
        $body     = url2path( $body );
        $title    = str_replace( "{#", "", $title );
        $title    = str_replace( "#}", "", $title );
        $memo     = str_replace( "{#", "", $memo );
        $memo     = str_replace( "#}", "", $memo );
        $body     = str_replace( "{#", "{ #", $body );
        $body     = str_replace( "#}", "# }", $body );
        $msql->query( "select catpath from {P}_paper_cat where catid='{$catid}'" );
        if ( $msql->next_record() ) {
            $catpath = $msql->f( "catpath" );
        }
        $count_pro = count( $spe_selec );
        for ( $i = 0; $i < $count_pro; $i++ ) {
            $projid = $spe_selec[$i];
            $projpath .= $projid . ":";
        }
        if ( 0 < $pic['size'] ) {
            $nowdate = date( "Ymd", time() );
            $picpath = "../pics/" . $nowdate;
            @mkdir( $picpath, 511 );
            $uppath = "paper/pics/" . $nowdate;
            $arr    = newuploadimage( $pic['tmp_name'], $pic['type'], $pic['size'], $uppath );
            if ( $arr[0] != "err" ) {
                $src = $arr[3];
            } else {
                echo $Meta . $arr[1];
                exit();
            }
            $msql->query( "select src from {P}_paper_con where id='{$id}'" );
            if ( $msql->next_record() ) {
                $oldsrc = $msql->f( "src" );
            }
            if ( file_exists( ROOTPATH . $oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) ) {
                unlink( ROOTPATH . $oldsrc );
            }
            $msql->query( "update {P}_paper_con set src='{$src}' where id='{$id}'" );
        }
        /*for ( $t = 0; $t < sizeof( $tags ); $t++ ) {
            if ( $tags[$t] != "" ) {
                $tagstr .= $tags[$t] . ",";
            }
        }*/
        $tagstr = $tags;
        $msql->query( "update {P}_paper_con set 
			title='{$title}',
			memo='{$memo}',
			catid='{$catid}',
			catpath='{$catpath}',
			dtime='{$dtime}',
			uptime='{$uptime}',
			xuhao='{$xuhao}',
			author='{$author}',
			source='{$source}',
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
			body='{$body}'
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
			$prop1 = $sprop1[$vs];
			$prop2 = $sprop2[$vs];
			$prop3 = $sprop3[$vs];
			$prop4 = $sprop4[$vs];
			$prop5 = $sprop5[$vs];
			$prop6 = $sprop6[$vs];
			$prop7 = $sprop7[$vs];
			$prop8 = $sprop8[$vs];
			$prop9 = $sprop9[$vs];
			$prop10 = $sprop10[$vs];
			$prop11 = $sprop11[$vs];
			$prop12 = $sprop12[$vs];
			$prop13 = $sprop13[$vs];
			$prop14 = $sprop14[$vs];
			$prop15 = $sprop15[$vs];
			$prop16 = $sprop16[$vs];
			$prop17 = $sprop17[$vs];
			$prop18 = $sprop17[$vs];
			$prop19 = $sprop19[$vs];
			$prop20 = $sprop20[$vs];
			
			if ( 0 < $spic['size'][$vs] )
			{
					$nowdate = date( "Ymd", time( ) );
					$picpath = "../pics/".$nowdate;
					@mkdir( $picpath, 511 );
					$uppath = "paper/pics/".$nowdate;
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
					"SELECT id FROM {P}_paper_con_translate WHERE pid='{$id}' AND langcode='{$vs}'",
					"UPDATE {P}_paper_con_translate SET 
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
					"INSERT INTO {P}_paper_con_translate SET 
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
        exit();
        break;
    case "contentmodify":
        $paperpagesid = $_POST['paperpagesid'];
        $body         = $_POST['body'];
        if ( 65000 < strlen( $body ) ) {
            echo $strPaperNotice5;
            exit();
        }
        $body = url2path( $body );
        $msql->query( "update {P}_paper_pages set body='{$body}' where id='{$paperpagesid}'" );
        echo "OK";
        exit();
        break;
    case "paperadd":
        $catid      = $_POST['catid'];
        $body       = $_POST['body'];
        $title      = htmlspecialchars( $_POST['title'] );
        $author     = htmlspecialchars( $_POST['author'] );
        $source     = htmlspecialchars( $_POST['source'] );
        $tourl      = trim( htmlspecialchars( $_POST['tourl'] ) );
        $memo       = $_POST['memo'];
        $fbtime     = $_POST['fbtime'];
        $prop1      = htmlspecialchars( $_POST['prop1'] );
        $prop2      = htmlspecialchars( $_POST['prop2'] );
        $prop3      = htmlspecialchars( $_POST['prop3'] );
        $prop4      = htmlspecialchars( $_POST['prop4'] );
        $prop5      = htmlspecialchars( $_POST['prop5'] );
        $prop6      = htmlspecialchars( $_POST['prop6'] );
        $prop7      = htmlspecialchars( $_POST['prop7'] );
        $prop8      = htmlspecialchars( $_POST['prop8'] );
        $prop9      = htmlspecialchars( $_POST['prop9'] );
        $prop10     = htmlspecialchars( $_POST['prop10'] );
        $prop11     = htmlspecialchars( $_POST['prop11'] );
        $prop12     = htmlspecialchars( $_POST['prop12'] );
        $prop13     = htmlspecialchars( $_POST['prop13'] );
        $prop14     = htmlspecialchars( $_POST['prop14'] );
        $prop15     = htmlspecialchars( $_POST['prop15'] );
        $prop16     = htmlspecialchars( $_POST['prop16'] );
        $prop17     = htmlspecialchars( $_POST['prop17'] );
        $prop18     = htmlspecialchars( $_POST['prop18'] );
        $prop19     = htmlspecialchars( $_POST['prop19'] );
        $prop20     = htmlspecialchars( $_POST['prop20'] );
        $downcentid = htmlspecialchars( $_POST['downcentid'] );
        $downcent   = htmlspecialchars( $_POST['downcent'] );
        $tags       = $_POST['tags'];
        trylimit( "_paper_con", 100, "id" );
        $fileurl   = $_POST['fileurl'];
        $pic       = $_FILES['jpg'];
        $file      = $_FILES['file'];
        $spe_selec = $_POST['spe_selec'];
        if ( 0 < $pic['size'] || 0 < $file['size'] ) {
            $Meta = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
        }
        if ( $title == "" ) {
            echo $Meta . $strPaperNotice6;
            exit();
        }
        if ( 200 < strlen( $title ) ) {
            echo $Meta . $strPaperNotice7;
            exit();
        }
        if ( 65000 < strlen( $body ) ) {
            echo $Meta . $strPaperNotice5;
            exit();
        }
        if ( strstr( $tourl, "../" ) ) {
            echo $Meta . $strPaperNotice15;
            exit();
        }
        $timearr = explode( "-", $fbtime );
        $yy      = $timearr[0];
        $mm      = $timearr[1];
        $dd      = $timearr[2];
        $hh      = date( "H", time() );
        $ii      = date( "i", time() );
        $ss      = date( "s", time() );
        $dtime   = mktime( $hh, $ii, $ss, $mm, $dd, $yy );
        $uptime  = $dtime;
        $msql->query( "select catpath from {P}_paper_cat where catid='{$catid}'" );
        if ( $msql->next_record() ) {
            $catpath = $msql->f( "catpath" );
        }
        $body  = url2path( $body );
        $title = str_replace( "{#", "", $title );
        $title = str_replace( "#}", "", $title );
        $memo  = str_replace( "{#", "", $memo );
        $memo  = str_replace( "#}", "", $memo );
        $body  = str_replace( "{#", "{ #", $body );
        $body  = str_replace( "#}", "# }", $body );
        if ( 0 < $pic['size'] ) {
            $nowdate = date( "Ymd", time() );
            $picpath = "../pics/" . $nowdate;
            @mkdir( $picpath, 511 );
            $uppath = "paper/pics/" . $nowdate;
            $arr    = newuploadimage( $pic['tmp_name'], $pic['type'], $pic['size'], $uppath );
            if ( $arr[0] != "err" ) {
                $src = $arr[3];
            } else {
                echo $Meta . $arr[1];
                exit();
            }
        }
        if ( 0 < $file['size'] ) {
            $nowdate = date( "Ymd", time() );
            $picpath = "../upload/" . $nowdate;
            @mkdir( $picpath, 511 );
            $uppath  = "paper/upload/" . $nowdate;
            $filearr = newuploadfile( $file['tmp_name'], $file['type'], $file['name'], $file['size'], $uppath );
            if ( $filearr[0] != "err" ) {
                $fileurl = $filearr[3];
            } else {
                echo $Meta . $filearr[1];
                exit();
            }
        }
        $count_pro = count( $spe_selec );
        for ( $i = 0; $i < $count_pro; $i++ ) {
            $projid = $spe_selec[$i];
            $projpath .= $projid . ":";
        }
        /*for ( $t = 0; $t < sizeof( $tags ); $t++ ) {
            if ( $tags[$t] != "" ) {
                $tagstr .= $tags[$t] . ",";
            }
        }*/
        $tagstr = $tags;
        $msql->query( "insert into {P}_paper_con set
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
		downcent='{$downcent}'
		" );
        echo "OK";
        exit();
        break;
    case "pagedelete":
        $delpagesid = $_POST['delpagesid'];
        $nowid      = $_POST['nowid'];
        $i          = 0;
        $msql->query( "select id from {P}_paper_pages where paperid='{$nowid}' order by xuhao" );
        while ( $msql->next_record() ) {
            $id[$i] = $msql->f( "id" );
            if ( $id[$i] == $delpagesid ) {
                if ( $i == 0 ) {
                    $lastid = 0;
                } else {
                    $lastid = $id[$i - 1];
                }
            }
            $i++;
        }
        if ( $lastid == 0 && 1 < $i ) {
            $lastid = $id[1];
        }
        $msql->query( "delete from  {P}_paper_pages where id='{$delpagesid}'" );
        echo $lastid;
        exit();
        break;
    case "addproj":
        $project = htmlspecialchars( $_POST['project'] );
        $folder  = htmlspecialchars( $_POST['folder'] );
        if ( $project == "" ) {
            echo $strProjNTC1;
            exit();
        }
        if ( strlen( $folder ) < 2 || 16 < strlen( $folder ) ) {
            echo $strProjNTC2;
            exit();
        }
        if ( !eregi( "^[0-9a-z]{1,16}\$", $folder ) ) {
            echo $strProjNTC3;
            exit();
        }
        if ( strstr( $folder, "/" ) || strstr( $folder, "." ) ) {
            echo $strProjNTC3;
            exit();
        }
        $arr = array(
             "main",
            "html",
            "class",
            "detail",
            "query",
            "index",
            "admin",
            "papergl",
            "paperfabu",
            "papermodify",
            "papercat",
            "paper" 
        );
        if ( in_array( $folder, $arr ) == true ) {
            echo $strProjNTC4;
            exit();
        }
        if ( file_exists( "../project/" . $folder ) ) {
            echo $strProjNTC4;
            exit();
        }
        $msql->query( "select id from {P}_paper_proj where folder='{$folder}'" );
        if ( $msql->next_record() ) {
            echo $strProjNTC4;
            exit();
        }
        $pagename = "proj_" . $folder;
        @mkdir( "../project/" . $folder, 511 );
        $fd  = fopen( "../project/temp.php", "r" );
        $str = fread( $fd, "2000" );
        $str = str_replace( "TEMP", $pagename, $str );
        fclose( $fd );
        $filename = "../project/" . $folder . "/index.php";
        $fp       = fopen( $filename, "w" );
        fwrite( $fp, $str );
        fclose( $fp );
        @chmod( $filename, 493 );
        $msql->query( "insert into {P}_paper_proj set 
			`project`='{$project}',
			`folder`='{$folder}'
		" );
        $msql->query( "insert into {P}_base_pageset set 
			`name`='{$project}',
			`coltype`='paper',
			`pagename`='{$pagename}',
			`pagetitle`='{$project}',
			`buildhtml`='index'
		" );
        echo "OK";
        exit();
        break;
    case "addzl":
        $catid = htmlspecialchars( $_POST['catid'] );
        if ( $catid == "" ) {
            echo $strZlNTC1;
            exit();
        }
        $msql->query( "select cat from {P}_paper_cat where catid='{$catid}'" );
        if ( $msql->next_record() ) {
            $cat = $msql->f( "cat" );
            $cat = str_replace( "'", "", $cat );
        } else {
            echo $strZlNTC2;
            exit();
        }
        $pagename = "class_" . $catid;
        @mkdir( "../class/" . $catid, 511 );
        $fd  = fopen( "../class/temp.php", "r" );
        $str = fread( $fd, "2000" );
        $str = str_replace( "TEMP", $pagename, $str );
        fclose( $fd );
        $filename = "../class/" . $catid . "/index.php";
        $fp       = fopen( $filename, "w" );
        fwrite( $fp, $str );
        fclose( $fp );
        @chmod( $filename, 493 );
        $msql->query( "update {P}_paper_cat set `ifchannel`='1' where catid='{$catid}'" );
        $msql->query( "select id from {P}_base_pageset where coltype='paper' and pagename='{$pagename}'" );
        if ( $msql->next_record() ) {
        } else {
            $fsql->query( "insert into {P}_base_pageset set 
			`name`='{$cat}',
			`coltype`='paper',
			`pagename`='{$pagename}',
			`pagetitle`='{$cat}',
			`buildhtml`='index'
			" );
        }
        echo "OK";
        exit();
        break;
    case "delzl":
        $catid = htmlspecialchars( $_POST['catid'] );
        if ( $catid == "" ) {
            echo $strZlNTC1;
            exit();
        }
        $msql->query( "select catid from {P}_paper_cat where catid='{$catid}'" );
        if ( $msql->next_record() ) {
        } else {
            echo $strZlNTC2;
            exit();
        }
        $pagename = "class_" . $catid;
        $msql->query( "delete from {P}_base_pageset where coltype='paper' and pagename='{$pagename}'" );
        $msql->query( "delete from {P}_base_plus where plustype='paper' and pluslocat='{$pagename}'" );
        $msql->query( "update {P}_paper_cat set `ifchannel`='0' where catid='{$catid}'" );
        if ( $catid != "" && 1 <= strlen( $catid ) && !strstr( $catid, "." ) && !strstr( $catid, "/" ) ) {
            delfold( "../class/" . $catid );
        }
        echo "OK";
        exit();
        break;
case "addcattemp" :
				$catid = htmlspecialchars( $_POST['catid'] );
				if ( $catid == "" )
				{
								echo $strZlNTC1;
								exit( );
				}
				$msql->query( "update {P}_paper_cat set `cattemp`='1' where catid='{$catid}'" );
				$chgdb= array('query','detail');
				foreach($chgdb AS $chgname){
				$msql->query( "select * from {P}_base_pageset where coltype='paper' and pagename='{$chgname}'" );
				if ( $msql->next_record( ) )
				{
					$fsql->query( "insert into {P}_base_pageset (`id`, `name`, `coltype`, `pagename`, `th`, `ch`, `bh`, `pagetitle`, `metakey`, `metacon`, `bgcolor`, `bgimage`, `bgposition`, `bgrepeat`, `bgatt`, `containwidth`, `containbg`, `containimg`, `containmargin`, `containpadding`, `containcenter`, `topbg`, `topwidth`, `contentbg`, `contentwidth`, `contentmargin`, `bottombg`, `bottomwidth`, `buildhtml`, `xuhao`) VALUES (NULL,'{$msql->f('name')}','{$msql->f('coltype')}','{$chgname}_{$catid}','{$msql->f('th')}','{$msql->f('ch')}','{$msql->f('bh')}','{$msql->f('pagetitle')}','{$msql->f('metakey')}','{$msql->f('metacon')}','{$msql->f('bgcolor')}','{$msql->f('bgimage')}','{$msql->f('bgposition')}','{$msql->f('bgrepeat')}','{$msql->f('bgatt')}','{$msql->f('containwidth')}','{$msql->f('containbg')}','{$msql->f('containimg')}','{$msql->f('containmargin')}','{$msql->f('containpadding')}','{$msql->f('containcenter')}','{$msql->f('topbg')}','{$msql->f('topwidth')}','{$msql->f('contentbg')}','{$msql->f('contentwidth')}','{$msql->f('contentmargin')}','{$msql->f('bottombg')}','{$msql->f('bottomwidth')}','{$msql->f('buildhtml')}','{$msql->f('xuhao')}') " );
				}
				else
				{
								echo $strZlNTC2;
								exit( );
				}
				
				$msql->query( "select * from {P}_base_plusdefault where coltype='paper' and pluslocat='{$chgname}'" );
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
				$msql->query( "select catid from {P}_paper_cat where catid='{$catid}'" );
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
				$msql->query( "delete from {P}_base_pageset where coltype='paper' and pagename='{$pagename}'" );
				$msql->query( "delete from {P}_base_plusdefault where plustype='paper' and pluslocat='{$pagename}'" );
				$msql->query( "delete from {P}_base_plus where plustype='paper' and pluslocat='{$pagename}'" );
				$msql->query( "update {P}_paper_cat set `cattemp`='0' where catid='{$catid}'" );
				}
				echo "OK";
				exit( );
				break;
}
?>
