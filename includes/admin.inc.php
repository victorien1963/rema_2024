<?php
function get_client_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function adminlog( ){	
	global $msql;	
	$postlog = $getlog = $value_p = $value_g = "";
	
	if( strpos($_SERVER['PHP_SELF'],"admin.php") === false ){
			needauth(0);
		}
	$sysuser = $_COOKIE["SYSUSER"];
	$pre_url = explode("/",$_SERVER['HTTP_REFERER']);
	$coltype = $pre_url[3];
		
	if( $_POST ){
		foreach($_POST AS $key_p=>$value_p ){
			if(is_array($value_p)){
				$value_p = implode("|",$value_p);
			}
			$postlog .= $postlog? ",[".$key_p.":".$value_p."]":"[".$key_p.":".$value_p."]";
		}
	}elseif( $_GET ){
		foreach($_GET AS $key_g=>$value_g ){
			if(is_array($value_g)){
				$value_g = implode("|",$value_g);
			}
			$getlog .= $getlog? ",[".$key_g.":".$value_g."]":"[".$key_g.":".$value_g."]";
		}
	}elseif( $_RERQUEST ){
		foreach($_RERQUEST AS $key_g=>$value_g ){
			if(is_array($value_g)){
				$value_g = implode("|",$value_g);
			}
			$reqlog .= $getlog? ",[".$key_g.":".$value_g."]":"[".$key_g.":".$value_g."]";
		}
	}
	if( $postlog || $getlog ){
		$logtime = time();
		$time = date("Y-m-d H:i:s");
		$ip = get_client_ip();

		$msql->query( "INSERT INTO {P}_base_adminlog SET coltype='{$coltype}',sysuser='{$sysuser}',postlog='{$postlog}',getlog='{$getlog}',reqlog='{$reqlog}',logtime='{$logtime}',time='{$time}',ip='{$ip}' " );
	}
}
function needauth( $au, $showhtml="1" )
{
				global $msql;
				global $strAdminNoright;
				
				$strAdminNoright =  '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="'.ROOTPATH.'base/admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="'.ROOTPATH.'base/admin/assets/css/fonts.css">
	<link rel="stylesheet" href="'.ROOTPATH.'base/admin/assets/font-awesome/css/font-awesome.min.css">
	<link id="qstyle" rel="stylesheet" href="'.ROOTPATH.'base/admin/assets/css/themes/style.css">
    <!--[if lt IE 9]>
    <script src="'.ROOTPATH.'base/admin/assets/js/html5shiv.js"></script>
    <script src="'.ROOTPATH.'base/admin/assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body  style="background-color:#f5f5f5;">
  	  <div class="error-container" style="margin-top:0;">
			<div class="container" style="padding-top:50px; max-width:670px;">
				<div class="error-box">
					<h1 class="error-code"><i class="fa fa-exclamation-triangle smaller-50"></i> Error <small></small></h1>
					<h3>'.$strAdminNoright.'</h3>
								
					<div class="space-12"></div>
				</div>
			</div>
		</div>
    <script src="'.ROOTPATH.'base/admin/assets/js/jquery.min.js"></script>
    <script src="'.ROOTPATH.'base/admin/assets/js/bootstrap.min.js"></script>
	<script src="'.ROOTPATH.'base/admin/assets/js/plugins/iframeautoheight/jquery.autoheight.js"></script>
	<script>
		$(document).ready(function(){
			$(\'#sidemenu, #topmenu\', window.parent.document).removeClass(\'in\');
		});
	</script>
  </body>
</html>';
				
				if ( !isset( $_COOKIE['SYSUSER'] ) || $_COOKIE['SYSUSER'] == "" )
				{
								echo "<script>top.location='".ROOTPATH."admin.php'</script>";
								exit( );
				}
				$msql->query( "select * from {P}_base_admin where user='".$_COOKIE['SYSUSER']."'" );
				if ( $msql->next_record( ) )
				{
								$psd = $msql->f( "password" );
								$needmd5 = md5( $_COOKIE['SYSUSER']."l0aZXUYJ876Mn5rQoL55B".$psd.$_COOKIE['SYSTM'] );
								if ( $needmd5 != $_COOKIE['SYSZC'] )
								{
												if($showhtml == 1){
													echo $strAdminNoright;
													exit( );
												}else{
													return false;
													exit( );
												}
								}
								if ( $au != "0" )
								{
												$msql->query( "select * from {P}_base_adminrights where user='".$_COOKIE['SYSUSER']."' and auth='{$au}'" );
												if ( $msql->next_record( ) )
												{
												}
												else
												{
															if($showhtml == 1){
																echo $strAdminNoright;
																exit( );
															}else{
																return false;
																exit( );
															}
												}
								}
				}
				else
				{
								if($showhtml == 1){
									echo $strAdminNoright;
									exit( );
								}else{
									return false;
									exit( );
								}
				}
}

function showauth( $au, $style="1" )
{
				global $tsql;
				global $strAdminNoright;
				
				
				
				if ( !is_array($au) )
				{
					$tsql->query( "select * from {P}_base_adminrights where user='".$_COOKIE['SYSUSER']."' and auth='{$au}'" );
					if ( $tsql->next_record( ) )
					{
						return "";
					}
					else
					{
						if($style == "1"){
							return "style=\"display:none;\"";
						}else{
							return "display:none;";
						}
					}
				}else{
					$aus = implode(",",$au);
					$tsql->query( "select COUNT(*) from {P}_base_adminrights where user='".$_COOKIE['SYSUSER']."' and auth IN (".$aus.")" );
					if ( $tsql->next_record( ) )
					{
						if ( $tsql->f('COUNT(*)') > 0 )
						{
							return "";
						}
						else
						{
							if($style == "1"){
								return "style=\"display:none;\"";
							}else{
								return "display:none;";
							}
						}
					}
				}
}

function readconfig( )
{
				global $msql;
				$msql->query( "select * from {P}_base_config" );
				while ( $msql->next_record( ) )
				{
					$variable = $msql->f( "variable" );
					$value = $msql->f( "value" );
					$GLOBALS['GLOBALS']['CONF'][$variable] = $value;
				}
}

function tblcount( $tbl, $id, $scl )
{
				global $msql;
				$msql->query( "select count(".$id.") from {P}".$tbl." where {$scl}" );
				if ( $msql->next_record( ) )
				{
								$totalnums = $msql->f( "count(".$id.")" );
				}
				return $totalnums;
}

function fmpath( $catid )
{
				if ( strlen( $catid ) == 1 )
				{
								$pathid = "000".$catid;
				}
				else if ( strlen( $catid ) == 2 )
				{
								$pathid = "00".$catid;
				}
				else if ( strlen( $catid ) == 3 )
				{
								$pathid = "0".$catid;
				}
				else if ( 4 <= strlen( $catid ) )
				{
								$pathid = $catid;
				}
				return $pathid;
}

function popback( $reson, $self )
{
				echo "<script>alert(\"{$reson}\");
	self.location='".$self."';
	</script>";
				exit( );
}

function coltype2sname( $coltype )
{
				global $tsql;
				$tsql->query( "select sname from {P}_base_coltype where coltype='{$coltype}'" );
				if ( $tsql->next_record( ) )
				{
								$sname = $tsql->f( "sname" );
				}
				return $sname;
}

function coltype2colname( $coltype )
{
				global $fsql;
				$fsql->query( "select colname from {P}_base_coltype where coltype='{$coltype}'" );
				if ( $fsql->next_record( ) )
				{
								$colname = $fsql->f( "colname" );
				}
				return $colname;
}

function cat2catpath( $tbl, $catid )
{
				global $msql;
				$msql->query( "select catpath from {$tbl} where catid='{$catid}'" );
				if ( $msql->next_record( ) )
				{
								$catpath = $msql->f( "catpath" );
				}
				return $catpath;
}

function trylimit( $tbl, $n, $i )
{

}

function tryfunc( )
{

}

function showauthtype( )
{
				global $msql;
				if ( $msql->dbrecord( ) )
				{
								return "非商業授權";
				}
				else
				{
								return "商業授權";
				}
}

function csubstr( $str, $start, $len )
{
				preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/",$str,$ar);
				$x = 1;
				$i = 0;
				for ( ;	$i < sizeof( $ar[0] );	$i++	)
				{
								if ( $len < $i )
								{
												break;
								}
								if ( ord( $ar[0][$i] ) < 128 )
								{
												if ( $x == 2 )
												{
																$len = $len + 1;
																$x = 0;
												}
												$x++;
								}
				}
				return join( "", array_slice( $ar[0], $start, $len ) );
}

function seld( $t, $z )
{
				if ( $t == $z )
				{
								$ret = " selected";
				}
				else
				{
								$ret = " ";
				}
				return $ret;
}

function err( $say, $url, $link )
{
				global $strBack;
				if ( $url == "" )
				{
								$url = "Javascript:history.back();";
				}
				if ( $link == "" )
				{
								$link = $strBack;
				}
				echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="'.ROOTPATH.'base/admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="'.ROOTPATH.'base/admin/assets/css/fonts.css">
	<link rel="stylesheet" href="'.ROOTPATH.'base/admin/assets/font-awesome/css/font-awesome.min.css">
	<link id="qstyle" rel="stylesheet" href="'.ROOTPATH.'base/admin/assets/css/themes/style.css">
    <!--[if lt IE 9]>
    <script src="'.ROOTPATH.'base/admin/assets/js/html5shiv.js"></script>
    <script src="'.ROOTPATH.'base/admin/assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body  style="background-color:#f5f5f5;">
  	  <div class="error-container" style="margin-top:0;">
			<div class="container" style="padding-top:50px; max-width:670px;">
				<div class="error-box">
					<h1 class="error-code"><i class="fa fa-exclamation-triangle smaller-50"></i> Error <small></small></h1>
					<h3>'.$say.'</h3>
								
					<div class="space-12"></div>
								
					<a href="'.$url.'" class="btn btn-primary">'.$link.'</a>
				</div>
			</div>
		</div>
    <script src="'.ROOTPATH.'base/admin/assets/js/jquery.min.js"></script>
    <script src="'.ROOTPATH.'base/admin/assets/js/bootstrap.min.js"></script>
	<script src="'.ROOTPATH.'base/admin/assets/js/plugins/iframeautoheight/jquery.autoheight.js"></script>
	
  </body>
</html>';
				exit( );
}

function sayok( $say, $url, $link )
{
				global $strBack;
				if ( $url == "" )
				{
								$url = "Javascript:history.back();";
				}
				if ( $link == "" )
				{
								$link = $strBack;
				}
				
				echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="'.ROOTPATH.'base/admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="'.ROOTPATH.'base/admin/assets/css/fonts.css">
	<link rel="stylesheet" href="'.ROOTPATH.'base/admin/assets/font-awesome/css/font-awesome.min.css">
	<link id="qstyle" rel="stylesheet" href="'.ROOTPATH.'base/admin/assets/css/themes/style.css">
    <!--[if lt IE 9]>
    <script src="'.ROOTPATH.'base/admin/assets/js/html5shiv.js"></script>
    <script src="'.ROOTPATH.'base/admin/assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body  style="background-color:#f5f5f5;">
  	  <div class="success-container" style="margin-top:0;">
			<div class="container" style="padding-top:50px; max-width:670px;">
				<div class="success-box">
					<h1 class="success-code"><i class="fa fa-check-circle smaller-50"></i> Success <small></small></h1>
					<h3>'.$say.'</h3>
								
					<div class="space-12"></div>
								
					<a href="'.$url.'" class="btn btn-success" style="color: #fff;">'.$link.'</a>
				</div>
			</div>
		</div>
    <script src="'.ROOTPATH.'base/admin/assets/js/jquery.min.js"></script>
    <script src="'.ROOTPATH.'base/admin/assets/js/bootstrap.min.js"></script>
	<script src="'.ROOTPATH.'base/admin/assets/js/plugins/iframeautoheight/jquery.autoheight.js"></script>
	
  </body>
</html>';
				
				/*echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'><br><br><table width=366 border=0 cellspacing=2 cellpadding=6 align=center bgcolor=#FFFFFF background=images/err.gif height=199>
  <tr align=center> 
    <td height=80 valign=bottom><img src=images/ok.gif></td>
  </tr>
  <tr> 
    <td > 
      <div align=center> 
        <p>".$say." </p>
      </div>
    </td>
  </tr>
  <tr> 
    <td height=50 align=center><a href=".$url.">[".$link."]</a></td>
  </tr>
</table>";*/
				exit( );
}

function checked( $t, $z )
{
				if ( $t == $z )
				{
								$ret = " checked";
				}
				else
				{
								$ret = " ";
				}
				return $ret;
}

function switchdis( $n )
{
				if ( file_exists( ROOTPATH."base/catch/temp" ) )
				{
								$fp = fopen( ROOTPATH."base/catch/temp", "r" );
								$xnums = fread( $fp, 10 );
								fclose( $fp );
								if ( $n < $xnums )
								{
												return " disabled='true' ";
								}
								else
								{
												return "";
								}
				}
				else
				{
								return "";
				}
}

function showtypeimage( $src, $type, $width, $height, $border )
{
				if ( $width != "" && $width != "0" )
				{
								$wstr = " width=".$width." ";
				}
				if ( $height != "" && $height != "0" )
				{
								$hstr = " height=".$height." ";
				}
				if ( substr( $src, 0 - 4 ) == ".swf" )
				{
								$ImageStr = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\"  ".$wstr." ".$hstr."  border=".$border."><param name=movie value=\"".$src."\"><param name=quality value=high><embed src=\"".$src."\"  pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\"  ".$wstr." ".$hstr."  border=".$border." style='max-width: 100%;'></embed></object>";
				}
				else
				{
								$ImageStr = "<img src='".$src."' ".$wstr." ".$hstr."  border='".$border."' style='max-width: 100%;'>";
				}
				return $ImageStr;
}

function url2path( $string )
{
				global $SiteUrl;
				$string = str_replace( $SiteUrl, "[ROOTPATH]", $string );
				return $string;
}

function path2url( $string )
{
				global $SiteUrl;
				$string = str_replace( "[ROOTPATH]", $SiteUrl, $string );
				return $string;
}

function tblinsert( $tbl, $vars )
{
				global $msql;
				$scl = "";
				while ( list( $key, $val ) = key )
				{
								$scl .= "`".$key."`='".$val."',";
				}
				$scl = substr( $scl, 0, 0 - 1 );
				$msql->query( "insert into {P}".$tbl." set {$scl}" );
}

function showyn( $str )
{
				if ( $str == "1" || $str == "yes" )
				{
								echo "<img src='images/toolbar_ok.gif'>";
				}
				else
				{
								echo "<img src='images/toolbar_no.gif'>";
				}
}

function showny( $str )
{
				if ( $str == "1" || $str == "yes" )
				{
								echo "<img src='images/toolbar_no.gif'>";
				}
				else
				{
								echo "<img src='images/toolbar_ok.gif'>";
				}
}

function cpfolder( $FromPath, $ToPath, $NoCopy=array() )
{
				if ( !is_writable( $ToPath ) )
				{
								echo "Error: Fold (".$ToPath.") is not writable";
								exit( );
				}
				if ( file_exists( $FromPath ) )
				{
								$handle = opendir( $FromPath );
								while ( $ifile = readdir( $handle ) )
								{
												$nowfile = $FromPath."/".$ifile;
												$tofile = $ToPath."/".$ifile;
												if ( $ifile != "." && $ifile != ".." && !in_array("".$ifile."",$NoCopy) )
												{
																if ( !is_dir( $nowfile ) )
																{
																				copy( $nowfile, $tofile );
																				chmod( $tofile, 493 );
																}
																else
																{
																				if ( !file_exists( $tofile ) )
																				{
																								mkdir( $tofile, 511 );
																				}
																				cpfolder( $nowfile, $tofile );
																}
												}
								}
								closedir( $handle );
				}
}

function delfold( $imagefold )
{
				if ( file_exists( $imagefold ) )
				{
								$handle = opendir( $imagefold );
								while ( $image_file = readdir( $handle ) )
								{
												$nowfile = $imagefold."/".$image_file;
												if ( $image_file != "." && $image_file != ".." )
												{
																if ( !is_dir( $nowfile ) )
																{
																				unlink( $nowfile );
																}
																else
																{
																				delfold( $nowfile );
																}
												}
								}
								closedir( $handle );
								rmdir( $imagefold );
				}
}

function ordsc( $ord, $need, $sc )
{
				if ( $ord == $need )
				{
								if ( $sc == "desc" || $sc == "" )
								{
												echo "<img src='images/arrowdown.gif'>";
								}
								else
								{
												echo "<img src='images/arrowup.gif'>";
								}
				}
}

/*寫入文件START*/
function filesave($filename,$data,$method='rb+',$iflock=1,$check=1,$chmod=1){
	$check && strpos($filename,'ROOTPATH')!==false && exit('Forbidden');
	touch($filename);
	$handle = fopen($filename,$method);
	$iflock && flock($handle,LOCK_EX);
	fwrite($handle,$data);
	$method=='rb+' && ftruncate($handle,strlen($data));
	fclose($handle);
	$chmod && @chmod($filename,0777);
}
/*寫入文件END*/

/*讀取log檔START*/
function logcovers($filename){
	$readb=array();
	$readb = file_getc($filename);	
	if($readb){
		$readb = str_replace("\n","\n<:wayhunt:>",$readb);
		$readb = explode("<:wayhunt:>",$readb);
		$count = count($readb);
		if ($readb[$count-1] == '' || $readb[$count-1] == "\r") {unset($readb[$count-1]);}
		if (empty($readb)) {$readb[0] = "";}
	}
	return $readb;
}
function file_getc($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; InfoPath.1; CIBA)");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);
	
	return $data;
}

function get_url( $url,  $javascript_loop = 0, $timeout = 5 )
{
    $url = str_replace( "&amp;", "&", urldecode(trim($url)) );

    $cookie = tempnam ("/tmp", "CURLCOOKIE");
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ch, CURLOPT_ENCODING, "" );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
    $content = curl_exec( $ch );
    $response = curl_getinfo( $ch );
    curl_close ( $ch );

    if ($response['http_code'] == 301 || $response['http_code'] == 302)
    {
        ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");

        if ( $headers = get_headers($response['url']) )
        {
            foreach( $headers as $value )
            {
                if ( substr( strtolower($value), 0, 9 ) == "location:" )
                    return get_url( trim( substr( $value, 9, strlen($value) ) ) );
            }
        }
    }

    if (    ( preg_match("/>[[:space:]]+window\.location\.replace\('(.*)'\)/i", $content, $value) || preg_match("/>[[:space:]]+window\.location\=\"(.*)\"/i", $content, $value) ) &&
            $javascript_loop < 5
    )
    {
        return get_url( $value[1], $javascript_loop+1 );
    }
    else
    {
        return array( $content, $response );
    }
}

function curl_download($fileurl,$newfname){
	
    $cp = curl_init($fileurl); 
    $fp = fopen($newfname, "w"); 
    
    curl_setopt($cp, CURLOPT_FILE, $fp); 
    curl_setopt($cp, CURLOPT_HEADER, 0); 
    curl_exec($cp); 
    curl_close($cp); 
    fclose($fp); 
}

/*讀取log檔END*/

function createFolderdDIR($path){
	if(!is_dir($path)){
		createFolderdDIR(dirname($path));
		@mkdir($path);
		@chmod($path,0777);
	}
}

function adminshow($showstyle=1){
	
	if($_COOKIE["SYSUSER"] != "wayhunt"){
		$hideit = "style='display:none;'";
		$hideitno = "display:none;";
		$hideitfootable = "data-hide='all' data-ignore='true'";
	}
	
	if($showstyle==1){
		return $hideit;
	}elseif($showstyle==2){
		return $hideitfootable;
	}else{
		return $hideitno;
	}
}

function thumb($src){
	$srcs = dirname($src)."/sp_".basename($src);
	return $srcs;
}

function debug_to_console($data) {
    if(is_array($data) || is_object($data))
	{
		echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
	} else {
		echo("<script>console.log('PHP: ".$data."');</script>");
	}
}

error_reporting( E_ERROR | E_WARNING | E_PARSE );

include_once( ROOTPATH."config.inc.php" );
include_once( ROOTPATH."version.php" );
include( ROOTPATH."includes/nocatch.php" );
list($aaa, $lans) = explode("_",$sLan);
if(isset($_COOKIE["ADMINLANTYPE"])){
	$lantype = $_COOKIE["ADMINLANTYPE"];
}
if(isset($_GET['adminlan'])){
	if($_GET['adminlan'] == $lans){
		setcookie("ADMINLANTYPE","",time( ) - 86400);
		setcookie("ADMINLANTYPE","", time( ) - 86400,"/");
		$lantype = "";
	}else{
		setcookie("ADMINLANTYPE","_".$_GET['adminlan'], time( ) + 3600,"/");
		$lantype = "_".$_GET['adminlan'];
	}
}

include_once( ROOTPATH."includes/db.inc.php" );

readconfig( );
adminlog( );
?>