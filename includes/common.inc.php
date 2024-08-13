<?php
/*�h��y���ഫ*/
function getDefaultLan()
{
				global $dsql;
				
				$arraySQL = $dsql->getone( "SELECT * FROM {P}_base_language WHERE `ifdefault`='1' limit 0,1");
				return $arraySQL["langcode"];
}
function getUseLan($lantype)
{
				global $dsql;
				if($lantype !=""){
					$arraySQL = $dsql->getone( "SELECT * FROM {P}_base_language WHERE `langcode`='$lantype' limit 0,1");
				}else{
					$arraySQL = $dsql->getone( "SELECT * FROM {P}_base_language WHERE `ifdefault`='1' limit 0,1");
				}
				
				return $arraySQL;
}
function strTranslate($sql, $pid, $column="*", $lan="")
{
				global $dsql,$lantype;
			
				if($lantype != "" || $lan !=""){
					$getlanstr = $lan? $lan:$lantype;
					$arraySQL = $dsql->getone( "SELECT {$column} FROM {P}_{$sql}_translate WHERE `langcode`='$getlanstr' and `pid`='$pid' limit 0,1");
					return $arraySQL;
				}
}
function getDefaultSyb()
{
				global $dsql;
				
				$arraySQL = $dsql->getone( "SELECT * FROM {P}_base_currency WHERE `ifdefault`='1' limit 0,1");
				return $arraySQL["pricesymbol"].",".$arraySQL["pricecode"].",".$arraySQL["rate"].",".$arraySQL["point"].",".$arraySQL["id"].",".$arraySQL["title"].",".$arraySQL["showtitle"].",".$arraySQL["langcode"];
}
function getSyb($id,$isHK="",$isMY="")
{
				global $dsql;
				
				if(is_numeric($id)){
					$scl = "`id`='$id'";
				}else{
					if($isHK == "hk"){
						$id = "zh_hk";
					}elseif($isMY == "my"){
						$id = "my";
					}
					$scl = "(`langcode`='$id' || `pricecode`='$id')";
				}
				
				$arraySQL = $dsql->getone( "SELECT * FROM {P}_base_currency WHERE `ifshow`='1' AND  $scl limit 0,1");
				if($arraySQL["pricesymbol"]){
					
					list($title, $lantitle) = explode(",",$arraySQL["title"]);
					list($showtitle, $lanshowtitle) = explode(",",$arraySQL["showtitle"]);
					
					if($arraySQL["langcode"] != "zh_tw"){
						$title = $lantitle? $lantitle:$title;
						$showtitle = $lanshowtitle? $lanshowtitle:$showtitle;
					}
					
					$gets = $arraySQL["pricesymbol"].",".$arraySQL["pricecode"].",".$arraySQL["rate"].",".$arraySQL["point"].",".$arraySQL["id"].",".$title.",".$showtitle.",".$arraySQL["langcode"];
				}else{
					$gets = getDefaultSyb();
				}
				return $gets;
}

function get_naps_bot() {
    $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if (strpos($useragent, 'googlebot') !== false){
        return 'Googlebot';
    }
    if (strpos($useragent, 'msnbot') !== false){
        return 'MSNbot';
    }
    if (strpos($useragent, 'slurp') !== false){
        return 'Yahoobot';
    }
    if (strpos($useragent, 'baiduspider') !== false){
        return 'Baiduspider';
    }
    if (strpos($useragent, 'sohu-search') !== false){
        return 'Sohubot';
    }
    if (strpos($useragent, 'lycos') !== false){
        return 'Lycos';
    }
    if (strpos($useragent, 'robozilla') !== false){
        return 'Robozilla';
    }
    return false;
}
function userLanguage($aLanList){
	preg_match('/^([a-z\-]+)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches);
	$acclang = strtolower($matches[1]);
	
	$useragent = $_SERVER ['HTTP_USER_AGENT'];

	if (!empty($_SERVER["HTTP_CLIENT_IP"])){
    	$ip = $_SERVER["HTTP_CLIENT_IP"];
	}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
	    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}else{
	    $ip = $_SERVER["REMOTE_ADDR"];
	}
	
	//$data = file_get_contents("https://www.geoplugin.net/json.gp?ip=" . $ip);
	$data = json_decode($data);
	$lang = strtolower($data->geoplugin_countryCode);
	
	if($acclang=="" || $acclang=="zh-tw" || $lang == "tw" || $lang == "hk" ||  $lang == "mo"){
		$uselang = "zh_tw";
	}elseif($lang == "cn" || $lang == "my"){
		$uselang = "zh_cn";
	}else{
		$uselang = "en";
	}
	
	if(get_naps_bot() == "Googlebot"){
		$uselang = "zh_tw";
	}elseif(get_naps_bot() == "Baiduspider"){
		$uselang = "zh_cn";
	}
	
	
	if($lang == "hk" || $lang == "mo"){
		$isHK = "hk";
	}elseif($lang == "my"){
		$isMY = "my";
	}

	return $uselang.",".$isHK.",".$isMY;
}

/**/
function readconfig( )
{
				global $msql,$lantype;
				
				if($lantype != ""){
					$msql->query( "select * from {P}_base_config_translate WHERE langcode='$lantype'" );
					while ( $msql->next_record( ) )
					{
								$variable = $msql->f( "variable" );
								$value = $msql->f( "value" );
								$arraySQL[$variable] = $value;
					}
				}
				
				$msql->query( "select * from {P}_base_config" );
				while ( $msql->next_record( ) )
				{
								$variable = $msql->f( "variable" );
								$value = $arraySQL[$variable]? $arraySQL[$variable]:$msql->f( "value" );
								$GLOBALS['GLOBALS']['CONF'][$variable] = $value;
				}
				if ( admincheckmodle( ) )
				{
								$GLOBALS['GLOBALS']['CONF']['CatchOpen'] = "0";
				}
}

function pageset( $coltype, $pagename )
{

				global $msql;
				$msql->query( "select * from {P}_base_pageset where  coltype='{$coltype}' and pagename='{$pagename}'" );
				while ( $msql->next_record( ) )
				{
    							$GLOBALSS = $GLOBALS['GLOBALS']['CONF'];
    							$metakey = $msql->f("metakey")? $msql->f("metakey"):$GLOBALSS['SiteKeywords'];
    							$metacon = $msql->f("metacon")? $msql->f("metacon"):$GLOBALSS['SiteInfo'];
    							$addmeta = $GLOBALSS['AddMETA'];
    							$addbtscript = $GLOBALSS['BTSCRIPT'];
								$GLOBALS['GLOBALS']['PSET'] = array(
												"id" => $msql->f( "id" ),
												"name" => $msql->f( "name" ),
												"coltype" => $msql->f( "coltype" ),
												"pagename" => $msql->f( "pagename" ),
												"pagetitle" => $msql->f( "pagetitle" ),
									            "metakey" => $metakey,
            									"metacon" => $metacon,
            									"addmeta" => $addmeta,
            									"addbtscript" => $addbtscript,
            									"metaimage" => $metaimage,
            									"fbtrack" => $fbtrack,
												"bgcolor" => $msql->f( "bgcolor" ),
												"bgimage" => $msql->f( "bgimage" ),
												"bgposition" => $msql->f( "bgposition" ),
												"bgrepeat" => $msql->f( "bgrepeat" ),
												"bgatt" => $msql->f( "bgatt" ),
												"containwidth" => $msql->f( "containwidth" ),
												"containbg" => $msql->f( "containbg" ),
												"containmargin" => $msql->f( "containmargin" ),
												"containpadding" => $msql->f( "containpadding" ),
												"containcenter" => $msql->f( "containcenter" ),
												"topbg" => $msql->f( "topbg" ),
												"topbgout" => $msql->f( "topbgout" ),
												"topwidth" => $msql->f( "topwidth" ),
												"contentbg" => $msql->f( "contentbg" ),
												"contentbgout" => $msql->f( "contentbgout" ),
												"contentwidth" => $msql->f( "contentwidth" ),
												"contentmargin" => $msql->f( "contentmargin" ),
												"bottombg" => $msql->f( "bottombg" ),
												"bottombgout" => $msql->f( "bottombgout" ),
												"bottomwidth" => $msql->f( "bottomwidth" ),
												"th" => $msql->f( "th" ),
												"ch" => $msql->f( "ch" ),
												"bh" => $msql->f( "bh" ),
												"buildhtml" => $msql->f( "buildhtml" ),
												"diypage" => $msql->f( "diypage" )
								);
				}
}

function pagedef( $diy, $set )
{
				if ( $set != "" && $set != "0" )
				{
								return $set;
				}
				else
				{
								return $diy;
				}
}

function loadtemp( $tpl )
{
				global $strTempNotexists;
				global $lantype;
				if($lantype){
					list($tplname, $tplext) = explode(".",$tpl);
					$newtpl = $tplname."_".$lantype.".".$tplext;
				}
				
				$CP = $GLOBALS['PLUSVARS']['pluscoltype'];
				if ( $CP != "" )
				{
								$CP = ROOTPATH.$CP."/";
				}
				else
				{
								$CP = ROOTPATH;
				}
		if(substr( $tpl,4,2) == "p_"){
				list($gettpl) = explode(".",$tpl);
				$fold = substr( $gettpl,6 );
				if(file_exists( $CP."templates/add/".$fold."/".$tpl)){
					
					if ( $newtpl && file_exists( $CP."templates/add/".$fold."/".$newtpl ) )
					{
						$tpl = $newtpl;
					}
        				$fd = fopen( $CP."templates/add/".$fold."/".$tpl,r);
        				$p = fread( $fd, 300000 );
        				fclose( $fd );
        				
        				$p = str_replace( "=\"images/", "=\"".$CP."templates/images/", $p );
        				$p = str_replace( "=\"css/", "=\"".$CP."templates/css/", $p );
        				$p = str_replace( "{#MYIMAGES#}", $CP."templates/add/".$fold."/images/", $p );
        				$p = str_replace( "{#MYCSS#}", $CP."templates/add/".$fold."/css/", $p );
        				$p = str_replace( "{#RP#}", ROOTPATH, $p );
        				$p = str_replace( "{#CP#}", $CP, $p );
        				return $p;

				}else{

        				$str = $strTempNotexists."(".$CP."templates/add/".$fold."/".$tpl.")";
        				return $str;
				}
		}else{
				if ( file_exists( $CP."templates/".$tpl ) )
				{
					if ( $newtpl && file_exists( $CP."templates/".$newtpl ) )
					{
						$tpl = $newtpl;
					}
					
								$fd = fopen( $CP."templates/".$tpl, r );
								$p = fread( $fd, 300000 );
								fclose( $fd );
								$p = str_replace( "=\"images/", "=\"".$CP."templates/images/", $p );
        						$p = str_replace( "=\"css/", "=\"".$CP."templates/css/", $p );
								$p = str_replace( "{#RP#}", ROOTPATH, $p );
								$p = str_replace( "{#CP#}", $CP, $p );
								return $p;
				}
				else
				{
								$str = $strTempNotexists."(".$CP."templates/".$tpl.")";
								return $str;
				}
		}
}

function loadbasetemp( $tpl )
{
				global $strTempNotexists;
				global $lantype;
				if($lantype){
					list($tplname, $tplext) = explode(".",$tpl);
					$newtpl = $tplname."_".$lantype.".".$tplext;
					if ( file_exists( ROOTPATH."base/templates/".$newtpl ) )
					{
						$tpl = $newtpl;
					}
				}
				
				if ( file_exists( ROOTPATH."base/templates/".$tpl ) )
				{
								$fd = fopen( ROOTPATH."base/templates/".$tpl, r );
								$p = fread( $fd, 300000 );
								fclose( $fd );
								if ( $GLOBALS['PSET']['bgimage'] != "" && $GLOBALS['PSET']['bgimage'] != "none" )
								{
												$bgimage = str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['bgimage'] );
												$p = str_replace( "{#background#}", "style='background:".$GLOBALS['PSET']['bgcolor']." ".$bgimage." ".$GLOBALS['PSET']['bgrepeat']." ".$GLOBALS['PSET']['bgatt']." ".$GLOBALS['PSET']['bgposition']."'", $p );
								}
								else
								{
												$p = str_replace( "{#background#}", "style='background:".$GLOBALS['PSET']['bgcolor']."'", $p );
								}
								$p = str_replace( "{#RP#}", ROOTPATH, $p );
								$p = str_replace( "{#CP#}", $CP, $p );
								return $p;
				}
				else
				{
								$str = $strTempNotexists."(".ROOTPATH."base/templates/".$tpl.")";
								return $str;
				}
}
/*20150204*/
function loadcoltypetemp( $tpl, $coltype, $themes="default")
{
				global $strTempNotexists;
				global $lantype;
				if($lantype){
					list($tplname, $tplext) = explode(".",$tpl);
					$newtpl = $tplname."_".$lantype.".".$tplext;
				}
				
				if(substr( $tpl,4,2) == "p_"){
					list($gettpl) = explode(".",$tpl);
					$fold = substr( $gettpl,6 );
					$custemp = "/add/".$fold;
				}
				
				if ( file_exists( ROOTPATH.$coltype."/templates".$custemp."/".$tpl ) )
				{
					
					if ( $newtpl && file_exists( ROOTPATH.$coltype."/templates".$custemp."/".$newtpl ) )
					{
						$tpl = $newtpl;
					}
					
								$fd = fopen( ROOTPATH.$coltype."/templates".$custemp."/".$tpl, r );
								$p = fread( $fd, 300000 );
								fclose( $fd );
								$p = str_replace( "{#RP#}", ROOTPATH, $p );
								$p = str_replace( "{#CP#}", $coltype, $p );
								$p = str_replace( "{#TM#}", ROOTPATH."base/templates/themes/".$themes."/", $p );
								return $p;
				}
				else
				{
								$str = $strTempNotexists."(".ROOTPATH.$coltype."/templates".$custemp."/".$tpl.")";
								return $str;
				}
}

/*20140426*/
function loadcustemp( $tpl ,$themes="default")
{
				global $strTempNotexists;
				global $lantype;
				
				if($lantype){
					list($tplname, $tplext) = explode(".",$tpl);
					$newtpl = $tplname."_".$lantype.".".$tplext;
					if ( file_exists( ROOTPATH."base/templates/themes/".$themes."/".$newtpl ) )
					{
						$tpl = $newtpl;
					}
				}
								
				if ( file_exists( ROOTPATH."base/templates/themes/".$themes."/".$tpl ) )
				{
								$fd = fopen( ROOTPATH."base/templates/themes/".$themes."/".$tpl, r );
								$p = fread( $fd, 300000 );
								fclose( $fd );
								if ( $GLOBALS['PSET']['bgimage'] != "" && $GLOBALS['PSET']['bgimage'] != "none" )
								{
												$bgimage = str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['bgimage'] );
												$p = str_replace( "{#background#}", "style='background:".$GLOBALS['PSET']['bgcolor']." ".$bgimage." ".$GLOBALS['PSET']['bgrepeat']." ".$GLOBALS['PSET']['bgatt']." ".$GLOBALS['PSET']['bgposition']."'", $p );
								}
								else
								{
												$p = str_replace( "{#background#}", "style='background:".$GLOBALS['PSET']['bgcolor']."'", $p );
								}
								$p = str_replace( "{#RP#}", ROOTPATH, $p );
								$p = str_replace( "{#CP#}", $CP, $p );
								$p = str_replace( "{#TM#}", ROOTPATH."base/templates/themes/".$themes."/", $p );
								return $p;
				}
				else
				{
								$str = $strTempNotexists."(".ROOTPATH."base/templates/themes/".$themes."/".$tpl.")";
								return $str;
				}
}

function loadcustemp_m( $tpl ,$themes="default")
{
				global $strTempNotexists;
				global $lantype;
				if($lantype){
					list($tplname, $tplext) = explode(".",$tpl);
					$newtpl = $tplname."_".$lantype.".".$tplext;
					if ( file_exists( ROOTPATH."base/templates/themes/".$themes."/mobi/".$newtpl ) )
					{
						$tpl = $newtpl;
					}
				}
				
				if ( file_exists( ROOTPATH."base/templates/themes/".$themes."/mobi/".$tpl ) )
				{
								$fd = fopen( ROOTPATH."base/templates/themes/".$themes."/mobi/".$tpl, r );
								$p = fread( $fd, 300000 );
								fclose( $fd );
								if ( $GLOBALS['PSET']['bgimage'] != "" && $GLOBALS['PSET']['bgimage'] != "none" )
								{
												$bgimage = str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['bgimage'] );
												$p = str_replace( "{#background#}", "style='background:".$GLOBALS['PSET']['bgcolor']." ".$bgimage." ".$GLOBALS['PSET']['bgrepeat']." ".$GLOBALS['PSET']['bgatt']." ".$GLOBALS['PSET']['bgposition']."'", $p );
								}
								else
								{
												$p = str_replace( "{#background#}", "style='background:".$GLOBALS['PSET']['bgcolor']."'", $p );
								}
								$p = str_replace( "{#RP#}", ROOTPATH, $p );
								$p = str_replace( "{#CP#}", $CP, $p );
								$p = str_replace( "{#TM#}", ROOTPATH."base/templates/themes/".$themes."/mobi/", $p );
								return $p;
				}
				else
				{
								$str = $strTempNotexists."(".ROOTPATH."base/templates/themes/".$themes."/mobi/".$tpl.")";
								return $str;
				}
}

function loadbordertemp( $fold )
{
				global $strTempNotexists;
	if (substr( $fold,1,2) == "p_"){
        		$fold = substr( $fold,0,1).substr( $fold,3);
				if ($fold == "1000"){
        			$path = ROOTPATH."base/border/add/".$fold."/tpl.htm";
        			$imgpath = ROOTPATH."base/border/add/".$fold."/images/";
				}else if (substr( $fold,1,1) == "0"){
        			$path = ROOTPATH."base/border/add/".substr($fold,1)."/".substr( $fold,0,1).".htm";
        			$imgpath = ROOTPATH."base/border/add/".substr($fold,1)."/images/";
				}else{
        			$path = ROOTPATH."base/border/add/".substr($fold,1)."/tpl.htm";
        			$imgpath = ROOTPATH."base/border/add/".substr($fold,1)."/images/";
				}
	}else{
				if ( $fold == "1000" )
				{
								$path = ROOTPATH."base/border/".$fold."/tpl.htm";
								$imgpath = ROOTPATH."base/border/".$fold."/images/";
				}
				else if ( substr( $fold, 1, 1 ) == "0" )
				{
								$path = ROOTPATH."base/border/".substr( $fold, 1 )."/".substr( $fold, 0, 1 ).".htm";
								$imgpath = ROOTPATH."base/border/".substr( $fold, 1 )."/images/";
				}
				else
				{
								$path = ROOTPATH."base/border/".substr( $fold, 1 )."/tpl.htm";
								$imgpath = ROOTPATH."base/border/".substr( $fold, 1 )."/images/";
				}
	}
				if ( file_exists( $path ) )
				{
								$fd = fopen( $path, r );
								$p = fread( $fd, 300000 );
								fclose( $fd );
								$p = str_replace( "{#RP#}", ROOTPATH, $p );
								$p = str_replace( "images/", $imgpath, $p );
								return $p;
				}
				else
				{
								$str = "<!-start-><div class='pdv_border' style='border:0'><!-start-><!-end-></div><!-end->";
								return $str;
				}
}

function loadcommontemp( $tpl )
{
				global $strTempNotexists;
				global $lantype;
				if($lantype){
					list($tplname, $tplext) = explode(".",$tpl);
					$newtpl = $tplname."_".$lantype.".".$tplext;
					if ( file_exists( "templates/".$newtpl ) )
					{
						$tpl = $newtpl;
					}
				}
				
				if ( file_exists( "templates/".$tpl ) )
				{
								$fd = fopen( "templates/".$tpl, r );
								$p = fread( $fd, 300000 );
								fclose( $fd );
								return $p;
				}
				else
				{
								$str = $strTempNotexists."(templates/".$tpl.")";
								return $str;
				}
}

function loadmembertemp( $RP, $tpl )
{
				global $strTempNotexists;
				global $lantype;
				if($lantype){
					list($tplname, $tplext) = explode(".",$tpl);
					$newtpl = $tplname."_".$lantype.".".$tplext;
					if ( file_exists( ROOTPATH."member/templates/".$newtpl ) )
					{
						$tpl = $newtpl;
					}
				}
				
				if ( file_exists( ROOTPATH."member/templates/".$tpl ) )
				{
								$fd = fopen( ROOTPATH."member/templates/".$tpl, r );
								$p = fread( $fd, 300000 );
								fclose( $fd );
								$p = str_replace( "images/", $RP."member/templates/images/", $p );
								$p = str_replace( "css/", $RP."member/templates/css/", $p );
								$p = str_replace( "{#RP#}", $RP, $p );
								return $p;
				}
				else
				{
								$str = $strTempNotexists."(templates/".$tpl.")";
								return $str;
				}
}

function loadnormaltemp( $tpl )
{
				global $strTempNotexists;
				global $lantype;
				if($lantype){
					list($tplname, $tplext) = explode(".",$tpl);
					$newtpl = $tplname."_".$lantype.".".$tplext;
					if ( file_exists( ROOTPATH."base/templates/".$newtpl ) )
					{
						$tpl = $newtpl;
					}
				}
				if ( file_exists( ROOTPATH."base/templates/".$tpl ) )
				{
								$fd = fopen( ROOTPATH."base/templates/".$tpl, r );
								$p = fread( $fd, 300000 );
								fclose( $fd );
								return $p;
				}
				else
				{
								$str = $strTempNotexists."(".ROOTPATH."base/templates/".$tpl.")";
								return $str;
				}
}

function admincheckauth( )
{
				global $msql;
				global $fsql;
				if ( !isset( $_COOKIE['SYSUSER'] ) || $_COOKIE['SYSUSER'] == "" )
				{
								return false;
				}
				$msql->query( "select * from {P}_base_admin where user='".$_COOKIE['SYSUSER']."'" );
				if ( $msql->next_record( ) )
				{
								$psd = $msql->f( "password" );
								$needmd5 = md5( $_COOKIE['SYSUSER']."l0aZXUYJ876Mn5rQoL55B".$psd.$_COOKIE['SYSTM'] );
								if ( $needmd5 == $_COOKIE['SYSZC'] )
								{
												$fsql->query( "select id from {P}_base_adminrights where user='".$_COOKIE['SYSUSER']."' and auth='5'" );
												if ( $fsql->next_record( ) )
												{
																return true;
												}
												else
												{
																return false;
												}
								}
								else
								{
												return false;
								}
				}
				else
				{
								return false;
				}
}

function admincheckmodle( )
{
				if ( isset( $_COOKIE['SYSUSER'] ) && $_COOKIE['SYSUSER'] != "" )
				{
								return true;
				}
				else
				{
								return false;
				}
}

function adminmenu( )
{
				global $strAdminModle;
				
				/*����˴�*/
				include_once(ROOTPATH."includes/Mobile_Detect.php");
				$detect = new Mobile_Detect();
				/**/

				if ( admincheckauth( ) )
				{
								if ( $_COOKIE['PLUSADMIN'] == "SET" )
								{
												$adminMenu = "\n\n<!-- ".$strAdminModle." -->\n\n";
												$adminMenu .= "<link href='".ROOTPATH."base/templates/css/pe.css' rel='stylesheet' type='text/css' />\n";
												if($detect->isMobile() && !$detect->isTablet() || $_GET["mobi"]){
													$adminMenu .= "<script type='text/javascript' src='".ROOTPATH."base/js/mplusadmin.js'></script>\n";
												}else{
													$adminMenu .= "<script type='text/javascript' src='".ROOTPATH."base/js/plusadmin.js'></script>\n";
												}
								}
								else if ( $_COOKIE['PLUSADMIN'] == "READY" )
								{
												$adminMenu = "\n\n<!-- ".$strAdminModle." -->\n\n";
												$adminMenu .= "<link href='".ROOTPATH."base/templates/css/pe.css' rel='stylesheet' type='text/css' />\n";
												$adminMenu .= "<script type='text/javascript' src='".ROOTPATH."base/js/plusenter.js'></script>\n";
								}
				}
				else
				{
								$adminMenu = "";
				}
				return $adminMenu;
}

function printpage( )
{
				global $msql;
				global $fsql;
				global $tsql;
				global $reload;
				global $adminMenu;
				global $strMore;
				global $lantype;
				if ( $_POST['act'] == "plusset" )
				{
								return printplus( );
								exit( );
				}
				
				/*�����O�_����*/
				if($GLOBALS['GLOBALS']['CONF']['UnderConstruction'] !="" && !$_COOKIE['SYSUSER']){
					return comprintpage( $GLOBALS['GLOBALS']['CONF']['UnderConstruction'], 1 );
					exit( );
				}
				
				list($diypagename,$istb,$ismobi,$ismobi_add,$addpage) = explode(",",$GLOBALS['PSET']['diypage']);
				if( $diypagename ){		
					
					list($diypagename, $themes) = explode("|",$diypagename);
					list($addpage, $addthemes) = explode("|",$addpage);
					$gtpl = explode(".",$diypagename);
					$diypagename = $gtpl[0].".".$gtpl[1];
					$themes = $themes!=""? $themes:"default";
					$addthemes = $addthemes!=""? $addthemes:"default";
					
						if( $ismobi ){
							return comprintpage_m( $diypagename, $istb, $themes );
						}elseif($ismobi_add){
							/*����˴�*/
							include_once(ROOTPATH."includes/Mobile_Detect.php");
							$detect = new Mobile_Detect();
							/**/
							if($detect->isMobile() && !$detect->isTablet() || $_GET["mobi"]){
								pageset( $GLOBALS['PSET']['coltype'], $GLOBALS['PSET']['pagename']."_m" );
								
								if($addpage){
									return comprintpage_m( $addpage, $istb, $addthemes );
								}else{
									return comprintpage_m( $diypagename, $istb, $themes );
								}
								
								exit( );
							}else{
								
								return comprintpage( $diypagename, $istb, $themes );
								exit( );
							}
						}else{
							
							return comprintpage( $diypagename, $istb, $themes );
							exit( );
						}
				}elseif($ismobi_add){
					/*����˴�*/
					include_once(ROOTPATH."includes/Mobile_Detect.php");
					$detect = new Mobile_Detect();
					/**/
					if($addpage != ""){
						list($addpage, $addthemes) = explode("|",$addpage);
						$addthemes = $addthemes!=""? $addthemes:"default";
							if($detect->isMobile() && !$detect->isTablet() || $_GET["mobi"]){
								pageset( $GLOBALS['PSET']['coltype'], $GLOBALS['PSET']['pagename']."_m" );
								return comprintpage_m( $addpage, $istb, $addthemes );
								exit( );
							}
					}else{
							if($detect->isMobile() && !$detect->isTablet() || $_GET["mobi"]){
								pageset( $GLOBALS['PSET']['coltype'], $GLOBALS['PSET']['pagename']."_m" );
								$usemobi = true;
							}
					}
				}
				
				$coltype = $GLOBALS['PSET']['coltype'];
				$pagename = $GLOBALS['PSET']['pagename'];
				$adminMenu = adminmenu( );				
				$str = $usemobi? loadbasetemp( "mheader.htm" ):loadbasetemp( "header.htm" );				
				$str .= "\n<script>\n";
				$str .= "var PDV_PAGEID='".$GLOBALS['PSET']['id']."'; \nvar PDV_RP='".ROOTPATH."'; \nvar PDV_COLTYPE='".$GLOBALS['PSET']['coltype']."'; \nvar PDV_PAGENAME='".$GLOBALS['PSET']['pagename']."'; \n";
				$str .= "</script>\n";
				
				$i = 1;
				$msql->query( "select * from {P}_base_plus where plustype='".$coltype."' and pluslocat='".$pagename."' and display!='none' order by zindex" );
				while ( $msql->next_record( ) )
				{
								$pdv[$i] = $msql->f( "id" );
								$ModArr[$i] = $msql->f( "modno" );
								$display[$i] = $msql->f( "display" );
								$w[$i] = $msql->f( "width" );
								$h[$i] = $msql->f( "height" );
								$t[$i] = $msql->f( "top" );
								$l[$i] = $msql->f( "left" );
								$z[$i] = $msql->f( "zindex" );
								$pluslable[$i] = $msql->f( "pluslable" );
								$plusname[$i] = $msql->f( "plusname" );
								$showborder[$i] = $msql->f( "showborder" );
								$coltitle[$i] = $msql->f( "title" );
								$padding[$i] = $msql->f( "padding" );
								$catid[$i] = $msql->f( "catid" );
								$tempname[$i] = $msql->f( "tempname" );
								$tempcolor[$i] = $msql->f( "tempcolor" );
								$shownums[$i] = $msql->f( "shownums" );
								$ord[$i] = $msql->f( "ord" );
								$sc[$i] = $msql->f( "sc" );
								$showtj[$i] = $msql->f( "showtj" );
								$cutword[$i] = $msql->f( "cutword" );
								$cutbody[$i] = $msql->f( "cutbody" );
								$picw[$i] = $msql->f( "picw" );
								$pich[$i] = $msql->f( "pich" );
								$fittype[$i] = $msql->f( "fittype" );
								$target[$i] = $msql->f( "target" );
								$body[$i] = $msql->f( "body" );
								if( $lantype !="" && $pluslable[$i] == "modButtomInfo" || $pluslable[$i] == "modEdit"){
									$getlanbody = $fsql->getonelan( "select body from {P}_base_plus where id='$pdv[$i]'" );
									$body[$i] = $getlanbody["body"];
								}
								$pic[$i] = $msql->f( "pic" );
								$attach[$i] = $msql->f( "attach" );
								$text[$i] = $msql->f( "text" );
								$link[$i] = $msql->f( "link" );
								$piclink[$i] = $msql->f( "piclink" );
								$word[$i] = $msql->f( "word" );
								$word1[$i] = $msql->f( "word1" );
								$word2[$i] = $msql->f( "word2" );
								$word3[$i] = $msql->f( "word3" );
								$word4[$i] = $msql->f( "word4" );
								$text1[$i] = $msql->f( "text1" );
								$code[$i] = $msql->f( "code" );
								$link1[$i] = $msql->f( "link1" );
								$link2[$i] = $msql->f( "link2" );
								$link3[$i] = $msql->f( "link3" );
								$link4[$i] = $msql->f( "link4" );
								$tags[$i] = $msql->f( "tags" );
								$movi[$i] = $msql->f( "movi" );
								$sourceurl[$i] = $msql->f( "sourceurl" );
								$overflow[$i] = $msql->f( "overflow" );
								$bodyzone[$i] = $msql->f( "bodyzone" );
								$groupid[$i] = $msql->f( "groupid" );
								$projid[$i] = $msql->f( "projid" );
								$bordercolor[$i] = $msql->f( "bordercolor" );
								$backgroundcolor[$i] = $msql->f( "backgroundcolor" );
								$borderwidth[$i] = $msql->f( "borderwidth" );
								$borderstyle[$i] = $msql->f( "borderstyle" );
								$borderlable[$i] = $msql->f( "borderlable" );
								$borderroll[$i] = $msql->f( "borderroll" );
								$showbar[$i] = $msql->f( "showbar" );
								$barbg[$i] = $msql->f( "barbg" );
								$barcolor[$i] = $msql->f( "barcolor" );
								$morelink[$i] = $msql->f( "morelink" );
								$pluscoltype[$i] = $msql->f( "coltype" );
								$i++;
				}
				
				for ( $p = 1;	$p < $i;	$p++	)
				{
								if ( $overflow[$p] != "visible" )
								{
												$FlowHeight = "height:100%";
								}
								else
								{
												$FlowHeight = "";
								}
								if ( $pluscoltype[$p] != "menu" && $pluscoltype[$p] != "effect" )
								{
												$divTitle = "title='".$coltitle[$p]."'";
								}
								else
								{
												$divTitle = "";
								}
								$bodyArr[$bodyzone[$p]] .= "\n\n<!-- ".$plusname[$p]." -->\n";
								if($usemobi){
									$bodyArr[$bodyzone[$p]] .= "\n<div id='pdv_".$pdv[$p]."' class='pdv_class'  ".$divTitle." style='width:100%;height:auto;left:0px; z-index:".$p."'>";
									$bodyArr[$bodyzone[$p]] .= "\n<div id='spdv_".$pdv[$p]."' class='pdv_".$bodyzone[$p]."' style='overflow:".$overflow[$p].";width:100%;height:auto;'>";
								}else{
									$bodyArr[$bodyzone[$p]] .= "\n<div id='pdv_".$pdv[$p]."' class='pdv_class'  ".$divTitle." style='width:".$w[$p]."px;height:".$h[$p]."px;top:".$t[$p]."px;left:".$l[$p]."px; z-index:".$p."'>";
									$bodyArr[$bodyzone[$p]] .= "\n<div id='spdv_".$pdv[$p]."' class='pdv_".$bodyzone[$p]."' style='overflow:".$overflow[$p].";width:100%;".$FlowHeight."'>";
								}
								$BorederArr = splittbltemp( loadbordertemp( $showborder[$p] ) );
								if ( $morelink[$p] == "" || $morelink[$p] == "http://" || $morelink[$p] == "-1" )
								{
												$showmore = "none";
								}
								else
								{
												$showmore = "inline";
								}
								$var = array(
												"pdvid" => $pdv[$p],
												"coltitle" => $coltitle[$p],
												"padding" => $padding[$p],
												"morelink" => $morelink[$p],
												"showmore" => $showmore,
												"borderwidth" => $borderwidth[$p],
												"bordercolor" => $bordercolor[$p],
												"borderstyle" => $borderstyle[$p],
												"borderlable" => $borderlable[$p],
												"borderroll" => $borderroll[$p],
												"backgroundcolor" => $backgroundcolor[$p],
												"showbar" => $showbar[$p],
												"barbg" => $barbg[$p],
												"barcolor" => $barcolor[$p]
								);
								$bodyArr[$bodyzone[$p]] .= showtpltemp( $BorederArr['start'], $var );
								if ( substr( $pluslable[$p], 0, 3 ) == "mod" )
								{
												$ModName = substr( $pluslable[$p], 3 );
												$ModFile = $ModName.".php";
												$ModNo = $ModArr[$p];
												$ModPath = ROOTPATH.$pluscoltype[$p]."/module/".$ModFile;
												if ( file_exists( $ModPath ) && !strstr( $ModFile, "/" ) )
												{
																include_once( $ModPath );
																$func = $ModName;
																if ( function_exists( $func ) )
																{
																				$GLOBALS['GLOBALS']['PLUSVARS'] = array(
																								"pagename" => $GLOBALS['PSET']['pagename'],
																								"pdv" => $pdv[$p],
																								"tempname" => $tempname[$p],
																								"tempcolor" => $tempcolor[$p],
																								"pluscoltype" => $pluscoltype[$p],
																								"coltitle" => $coltitle[$p],
																								"morelink" => $morelink[$p],
																								"cutbody" => $cutbody[$p],
																								"picw" => $picw[$p],
																								"pich" => $pich[$p],
																								"fittype" => $fittype[$p],
																								"shownums" => $shownums[$p],
																								"ord" => $ord[$p],
																								"sc" => $sc[$p],
																								"showtj" => $showtj[$p],
																								"cutword" => $cutword[$p],
																								"target" => $target[$p],
																								"pic" => $pic[$p],
																								"attach" => $attach[$p],
																								"text" => $text[$p],
																								"link" => $link[$p],
																								"piclink" => $piclink[$p],
																								"word" => $word[$p],
																								"word1" => $word1[$p],
																								"word2" => $word2[$p],
																								"word3" => $word3[$p],
																								"word4" => $word4[$p],
																								"text1" => $text1[$p],
																								"code" => $code[$p],
																								"link1" => $link1[$p],
																								"link2" => $link2[$p],
																								"link3" => $link3[$p],
																								"link4" => $link4[$p],
																								"tags" => $tags[$p],
																								"movi" => $movi[$p],
																								"sourceurl" => $sourceurl[$p],
																								"w" => $w[$p],
																								"h" => $h[$p],
																								"l" => $l[$p],
																								"t" => $t[$p],
																								"z" => $z[$p],
																								"showborder" => $showborder[$p],
																								"padding" => $padding[$p],
																								"groupid" => $groupid[$p],
																								"projid" => $projid[$p],
																								"body" => $body[$p],
																								"catid" => $catid[$p],
																								"morelink" => $morelink[$p]
																				);
																				$bodyArr[$bodyzone[$p]] .= $func( );
																}
																else
																{
																				$bodyArr[$bodyzone[$p]] .= "module function not exist";
																}
												}
												else
												{
																$bodyArr[$bodyzone[$p]] .= "module file (".$ModPath.") not exist ";
												}
								}
								else
								{
												$bodyArr[$bodyzone[$p]] .= "plus not a module";
								}
								$bodyArr[$bodyzone[$p]] .= $BorederArr['end'];
								$bodyArr[$bodyzone[$p]] .= "\n</div>";
								$bodyArr[$bodyzone[$p]] .= "\n</div>";
				}
				if($GLOBALS['PSET']['containcenter'] == "0px"){
					$pageLeft = "margin-left:0px;";
				}else{
					$pageLeft = "";
				}
				$str .= "\n<div id='contain' style='width:100%;";
				$str .= "background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['containbg'] ).";margin:".$GLOBALS['PSET']['containmargin']."px ".$GLOBALS['PSET']['containcenter'].";padding:".$GLOBALS['PSET']['containpadding']."px'>\n\n";
				if($usemobi){
					$str .= "<div id='topbgout' style='width:100%;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['topbgout'] ).";-moz-background-size: cover;background-size: cover;'>\n";
					$str .= "<div id='top' style='width:100%;height:auto;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['topbg'] ).";-moz-background-size: cover;background-size: cover;".$pageLeft."'>\n";
				}else{
					$str .= "<div id='topbgout' style='width:100%;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['topbgout'] ).";'>\n";
					$str .= "<div id='top' style='width:".$GLOBALS['PSET']['containwidth']."px;height:".$GLOBALS['PSET']['th']."px;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['topbg'] ).";".$pageLeft."'>\n";
				}
				$str .= $bodyArr['top'];
				$str .= "\n</div>\n";
				$str .= "\n</div>\n";
				if($usemobi){
					$str .= "<div id='contentbgout' style='width:100%; height:100%;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['contentbgout'] ).";-moz-background-size: cover;background-size: cover;overflow:hidden; zoom:1;'>\n";
					$str .= "<div id='content' style='width:100%;height:auto;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['contentbg'] ).";-moz-background-size: cover;background-size: cover;margin:".$GLOBALS['PSET']['contentmargin']."px auto;".$pageLeft."'>\n";
				}else{
					$str .= "<div id='contentbgout' style='width:100%; height:100%;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['contentbgout'] ).";overflow:hidden; zoom:1;'>\n";
					$str .= "<div id='content' style='width:".$GLOBALS['PSET']['containwidth']."px;height:".$GLOBALS['PSET']['ch']."px;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['contentbg'] ).";margin:".$GLOBALS['PSET']['contentmargin']."px auto;".$pageLeft."'>\n";
				}
				$str .= $bodyArr['content'];
				$str .= "\n</div>\n";
				$str .= "\n</div>\n";
				if($usemobi){
					$str .= "<div id='bottombgout' style='width:100%;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['bottombgout'] ).";-moz-background-size: cover;background-size: cover;'>\n";
					$str .= "<div id='bottom' style='width:100%;height:auto;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['bottombg'] ).";-moz-background-size: cover;background-size: cover;".$pageLeft."'>\n";
				}else{
					$str .= "<div id='bottombgout' style='width:100%;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['bottombgout'] ).";'>\n";
					$str .= "<div id='bottom' style='width:".$GLOBALS['PSET']['containwidth']."px;height:".$GLOBALS['PSET']['bh']."px;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['bottombg'] ).";".$pageLeft."'>\n";
				}
				
				$str .= $bodyArr['bottom'];
				$str .= "\n</div>\n";
				$str .= "\n</div>\n";
				$str .= "</div>";
				$str .= "<div id='bodyex'>\n";
				$str .= $bodyArr['bodyex'];
				$str .= "\n</div>\n";
				$GLOBALS['GLOBALS']['PLUSVARS'] = "";
				$str .= $usemobi? loadbasetemp( "mfoot.htm" ):loadbasetemp( "foot.htm" );
				if ( $GLOBALS['PSET']['pagetitle'] != "" )
				{
								$GLOBALS['GLOBALS']['pagetitle'] = $GLOBALS['PSET']['pagetitle'];
				}
				if ( $GLOBALS['GLOBALS']['metakey'] =="" && $GLOBALS['PSET']['metakey'] != "" )
				{
								$GLOBALS['GLOBALS']['metakey'] = $GLOBALS['PSET']['metakey'];
				}
				if ( $GLOBALS['GLOBALS']['metacon'] == "" && $GLOBALS['PSET']['metacon'] != "" )
				{
								$GLOBALS['GLOBALS']['metacon'] = $GLOBALS['PSET']['metacon'];
				}
				if ( $GLOBALS['GLOBALS']['metaimage'] == "" && $GLOBALS['PSET']['metaimage'] != "" )
				{
								$GLOBALS['GLOBALS']['metaimage'] = $GLOBALS['PSET']['metaimage'];
				}
				if ( $GLOBALS['GLOBALS']['fbtrack'] == "" && $GLOBALS['PSET']['fbtrack'] != "" )
				{
								$GLOBALS['GLOBALS']['fbtrack'] = $GLOBALS['PSET']['fbtrack'];
				}
				$GLOBALS['GLOBALS']['addmeta'] = $GLOBALS['PSET']['addmeta'];
				$GLOBALS['GLOBALS']['addbtscript'] = $GLOBALS['PSET']['addbtscript'];
				
				$str = showactive( $str );
				echo $str;
				if ( $GLOBALS['PSET']['buildhtml'] != "" && $GLOBALS['PSET']['buildhtml'] != "0" )
				{
								switch ( $GLOBALS['PSET']['buildhtml'] )
								{
								case "index" :
												buildhtml( "index", $str );
												break;
								default :
												buildhtml( "id", $str );
												break;
								}
				}
}
/*������*/
function comprintpage($normaltemp,$istb=1,$themes="default")
{
				global $msql;
				global $fsql;
				global $tsql;
				global $reload;
				global $adminMenu;
				global $strMore;
				global $lantype;
				
				if ( $_POST['act'] == "plusset" )
				{
								return printplus( );
								exit( );
				}
				$coltype = $GLOBALS['PSET']['coltype'];
				$pagename = $GLOBALS['PSET']['pagename'];
				$adminMenu = adminmenu( );
				if ( admincheckauth( ) && ($_COOKIE['PLUSADMIN'] == "SET" || $_COOKIE['PLUSADMIN']=="READY") ){
					$str = loadbasetemp( "adminheader.htm" );
				}else{
					$str = $istb? "":loadcustemp( "top.htm", $themes );
				}
				
				$addstr = "\n<script>\n";
				$addstr .= "var PDV_PAGEID='".$GLOBALS['PSET']['id']."'; \nvar PDV_RP='".ROOTPATH."'; \nvar PDV_COLTYPE='".$GLOBALS['PSET']['coltype']."'; \nvar PDV_PAGENAME='".$GLOBALS['PSET']['pagename']."'; \nvar PDV_TMRP='".ROOTPATH."base/templates/themes/".$themes."/'; \nvar PDV_LAN='".$lantype."'; \n";
				$addstr .= "</script>\n";
				
				$strcon = loadcustemp( $normaltemp, $themes );
				
				$btstr = $istb? "":loadcustemp( "bottom.htm", $themes );
				
				if(!$istb || admincheckauth( ) && ($_COOKIE['PLUSADMIN'] == "SET" || $_COOKIE['PLUSADMIN']=="READY")){
					$str = str_replace("{#addscript#}",$addstr,$str, $gcon);
					if(!$gcon){
						$str .= $addstr;
					}
					$strcon = $str.$strcon.$btstr;
				}elseif($istb){
					$strcon = str_replace("{#addscript#}",$addstr,$strcon);
				}
				
				$i = 1;
				
				$msql->query( "select * from {P}_base_plus where plustype='".$coltype."' and pluslocat='".$pagename."' and display!='none' order by zindex" );
				while ( $msql->next_record( ) )
				{
								$pdv[$i] = $msql->f( "id" );
								$ModArr[$i] = $msql->f( "modno" );
								$display[$i] = $msql->f( "display" );
								$w[$i] = $msql->f( "width" );
								$h[$i] = $msql->f( "height" );
								$t[$i] = $msql->f( "top" );
								$l[$i] = $msql->f( "left" );
								$z[$i] = $msql->f( "zindex" );
								$pluslable[$i] = $msql->f( "pluslable" );
								$plusname[$i] = $msql->f( "plusname" );
								$showborder[$i] = $msql->f( "showborder" );
								$coltitle[$i] = $msql->f( "title" );
								$padding[$i] = $msql->f( "padding" );
								$catid[$i] = $msql->f( "catid" );
								$tempname[$i] = $msql->f( "tempname" );
								$tempcolor[$i] = $msql->f( "tempcolor" );
								$shownums[$i] = $msql->f( "shownums" );
								$ord[$i] = $msql->f( "ord" );
								$sc[$i] = $msql->f( "sc" );
								$showtj[$i] = $msql->f( "showtj" );
								$cutword[$i] = $msql->f( "cutword" );
								$cutbody[$i] = $msql->f( "cutbody" );
								$picw[$i] = $msql->f( "picw" );
								$pich[$i] = $msql->f( "pich" );
								$fittype[$i] = $msql->f( "fittype" );
								$target[$i] = $msql->f( "target" );
								$body[$i] = $msql->f( "body" );
								if( $lantype !="" && $pluslable[$i] == "modButtomInfo" || $pluslable[$i] == "modEdit"){
									$getlanbody = $fsql->getonelan( "select body from {P}_base_plus where id='$pdv[$i]'" );
									$body[$i] = $getlanbody["body"];
								}
								$pic[$i] = $msql->f( "pic" );
								$attach[$i] = $msql->f( "attach" );
								$text[$i] = $msql->f( "text" );
								$link[$i] = $msql->f( "link" );
								$piclink[$i] = $msql->f( "piclink" );
								$word[$i] = $msql->f( "word" );
								$word1[$i] = $msql->f( "word1" );
								$word2[$i] = $msql->f( "word2" );
								$word3[$i] = $msql->f( "word3" );
								$word4[$i] = $msql->f( "word4" );
								$text1[$i] = $msql->f( "text1" );
								$code[$i] = $msql->f( "code" );
								$link1[$i] = $msql->f( "link1" );
								$link2[$i] = $msql->f( "link2" );
								$link3[$i] = $msql->f( "link3" );
								$link4[$i] = $msql->f( "link4" );
								$tags[$i] = $msql->f( "tags" );
								$movi[$i] = $msql->f( "movi" );
								$sourceurl[$i] = $msql->f( "sourceurl" );
								$overflow[$i] = $msql->f( "overflow" );
								$bodyzone[$i] = $msql->f( "bodyzone" );
								$groupid[$i] = $msql->f( "groupid" );
								$projid[$i] = $msql->f( "projid" );
								$bordercolor[$i] = $msql->f( "bordercolor" );
								$backgroundcolor[$i] = $msql->f( "backgroundcolor" );
								$borderwidth[$i] = $msql->f( "borderwidth" );
								$borderstyle[$i] = $msql->f( "borderstyle" );
								$borderlable[$i] = $msql->f( "borderlable" );
								$borderroll[$i] = $msql->f( "borderroll" );
								$showbar[$i] = $msql->f( "showbar" );
								$barbg[$i] = $msql->f( "barbg" );
								$barcolor[$i] = $msql->f( "barcolor" );
								$morelink[$i] = $msql->f( "morelink" );
								$pluscoltype[$i] = $msql->f( "coltype" );
								$i++;
				}
				
				for ( $p = 1;	$p < $i;	$p++	)
				{
					
								if ( $overflow[$p] != "visible" )
								{
												$FlowHeight = "height:100%";
								}
								else
								{
												$FlowHeight = "";
								}
								if ( $pluscoltype[$p] != "menu" && $pluscoltype[$p] != "effect" )
								{
												$divTitle = "title='".$coltitle[$p]."'";
								}
								else
								{
												$divTitle = "";
								}
								$bodyArr[$bodyzone[$p]] .= "\n\n<!-- ".$plusname[$p]." -->\n";
								$bodyArr[$bodyzone[$p]] .= "\n<div id='pdv_".$pdv[$p]."' class='pdv_class'  ".$divTitle." style='width:".$w[$p]."px;height:".$h[$p]."px;top:".$t[$p]."px;left:".$l[$p]."px; z-index:".$p."'>";
								$bodyArr[$bodyzone[$p]] .= "\n<div id='spdv_".$pdv[$p]."' class='pdv_".$bodyzone[$p]."' style='overflow:".$overflow[$p].";width:100%;".$FlowHeight."'>";
								
								$BorederArr = splittbltemp( loadbordertemp( $showborder[$p] ) );
								
								if ( $morelink[$p] == "" || $morelink[$p] == "http://" || $morelink[$p] == "-1" )
								{
												$showmore = "none";
								}
								else
								{
												$showmore = "inline";
								}
								$var = array(
												"pdvid" => $pdv[$p],
												"coltitle" => $coltitle[$p],
												"padding" => $padding[$p],
												"morelink" => $morelink[$p],
												"showmore" => $showmore,
												"borderwidth" => $borderwidth[$p],
												"bordercolor" => $bordercolor[$p],
												"borderstyle" => $borderstyle[$p],
												"borderlable" => $borderlable[$p],
												"borderroll" => $borderroll[$p],
												"backgroundcolor" => $backgroundcolor[$p],
												"showbar" => $showbar[$p],
												"barbg" => $barbg[$p],
												"barcolor" => $barcolor[$p]
								);
								
								$bodyArr[$bodyzone[$p]] .= showtpltemp( $BorederArr['start'], $var );
								if ( substr( $pluslable[$p], 0, 3 ) == "mod" )
								{
												
												$ModName = substr( $pluslable[$p], 3 );
												
												$ModFile = $ModName.".php";
												$ModNo = $ModArr[$p];
												$ModPath = ROOTPATH.$pluscoltype[$p]."/module/".$ModFile;
												
												if ( file_exists( $ModPath ) && !strstr( $ModFile, "/" ) )
												{
																include_once( $ModPath );
																$func = $ModName;
																
																if ( function_exists( $func ) )
																{
																				$GLOBALS['GLOBALS']['PLUSVARS'] = array(
																								"pagename" => $GLOBALS['PSET']['pagename'],
																								"pdv" => $pdv[$p],
																								"tempname" => $tempname[$p],
																								"tempcolor" => $tempcolor[$p],
																								"pluscoltype" => $pluscoltype[$p],
																								"coltitle" => $coltitle[$p],
																								"morelink" => $morelink[$p],
																								"cutbody" => $cutbody[$p],
																								"picw" => $picw[$p],
																								"pich" => $pich[$p],
																								"fittype" => $fittype[$p],
																								"shownums" => $shownums[$p],
																								"ord" => $ord[$p],
																								"sc" => $sc[$p],
																								"showtj" => $showtj[$p],
																								"cutword" => $cutword[$p],
																								"target" => $target[$p],
																								"pic" => $pic[$p],
																								"attach" => $attach[$p],
																								"text" => $text[$p],
																								"link" => $link[$p],
																								"piclink" => $piclink[$p],
																								"word" => $word[$p],
																								"word1" => $word1[$p],
																								"word2" => $word2[$p],
																								"word3" => $word3[$p],
																								"word4" => $word4[$p],
																								"text1" => $text1[$p],
																								"code" => $code[$p],
																								"link1" => $link1[$p],
																								"link2" => $link2[$p],
																								"link3" => $link3[$p],
																								"link4" => $link4[$p],
																								"tags" => $tags[$p],
																								"movi" => $movi[$p],
																								"sourceurl" => $sourceurl[$p],
																								"w" => $w[$p],
																								"h" => $h[$p],
																								"l" => $l[$p],
																								"t" => $t[$p],
																								"z" => $z[$p],
																								"showborder" => $showborder[$p],
																								"padding" => $padding[$p],
																								"groupid" => $groupid[$p],
																								"projid" => $projid[$p],
																								"body" => $body[$p],
																								"catid" => $catid[$p],
																								"morelink" => $morelink[$p]
																				);
																				$bodyArr[$bodyzone[$p]] .= $getfunc = $func( );
																				// 重點修改模板的地方 寫的有夠爛的
																				
																				$strcon = str_replace("{#".$coltitle[$p]."#}",$getfunc,$strcon);
																}
																else
																{
																				$bodyArr[$bodyzone[$p]] .= "module function not exist";
																				$strcon = str_replace("{#".$coltitle[$p]."#}","module function not exist",$strcon);
																}
												}
												else
												{
																$bodyArr[$bodyzone[$p]] .= "module file (".$ModPath.") not exist ";
																$strcon = str_replace("{#".$coltitle[$p]."#}","module file (".$ModPath.") not exist",$strcon);
												}
								}
								else
								{
												$bodyArr[$bodyzone[$p]] .= "plus not a module";
												$strcon = str_replace("{#".$coltitle[$p]."#}","plus not a module",$strcon);
								}
								
								$bodyArr[$bodyzone[$p]] .= $BorederArr['end'];
								$bodyArr[$bodyzone[$p]] .= "\n</div>";
								$bodyArr[$bodyzone[$p]] .= "\n</div>";

				}
				
				if ( admincheckauth( ) && ($_COOKIE['PLUSADMIN'] == "SET" || $_COOKIE['PLUSADMIN']=="READY") ){
					$str .= "\n<div id='contain' style='width:100%;";
				$str .= "background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['containbg'] ).";margin:".$GLOBALS['PSET']['containmargin']."px ".$GLOBALS['PSET']['containcenter'].";padding:".$GLOBALS['PSET']['containpadding']."px'>\n\n";
				$str .= "<div id='topbgout' style='width:100%;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['topbgout'] )."'>\n";
				$str .= "<div id='top' style='width:".$GLOBALS['PSET']['containwidth']."px;height:".$GLOBALS['PSET']['th']."px;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['topbg'] ).";".$pageLeft."'>\n";
				$str .= $bodyArr['top'];
				$str .= "\n</div>\n";
				$str .= "\n</div>\n";
				$str .= "<div id='contentbgout' style='width:100%; height:100%;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['contentbgout'] ).";overflow:hidden; zoom:1;'>\n";
				$str .= "<div id='content' style='width:".$GLOBALS['PSET']['containwidth']."px;height:".$GLOBALS['PSET']['ch']."px;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['contentbg'] ).";margin:".$GLOBALS['PSET']['contentmargin']."px auto;".$pageLeft."'>\n";
				$str .= $bodyArr['content'];
				$str .= "\n</div>\n";
				$str .= "\n</div>\n";
				$str .= "<div id='bottombgout' style='width:100%;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['bottombgout'] )."'>\n";
				$str .= "<div id='bottom' style='width:".$GLOBALS['PSET']['containwidth']."px;height:".$GLOBALS['PSET']['bh']."px;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['bottombg'] ).";".$pageLeft."'>\n";
				$str .= $bodyArr['bottom'];
				$str .= "\n</div>\n";
				$str .= "\n</div>\n";
				$str .= "</div>";
				$str .= "<div id='bodyex'>\n";
				$str .= $bodyArr['bodyex'];
				$str .= "\n</div>\n";
				
				}else{
					if($istb){
						$str .= $strcon;
					}else{
						$str = $strcon;
					}
				}
				
				$GLOBALS['GLOBALS']['PLUSVARS'] = "";
				if ( admincheckauth( ) && ($_COOKIE['PLUSADMIN'] == "SET" || $_COOKIE['PLUSADMIN']=="READY") ){
					$str .= loadbasetemp( "adminfoot.htm" );
				}
				
				if ( $GLOBALS['PSET']['pagetitle'] != "" )
				{
								$GLOBALS['GLOBALS']['pagetitle'] = $GLOBALS['PSET']['pagetitle'];
				}
				if ( $GLOBALS['GLOBALS']['metakey'] =="" && $GLOBALS['PSET']['metakey'] != "" )
				{
								$GLOBALS['GLOBALS']['metakey'] = $GLOBALS['PSET']['metakey'];
				}
				if ( $GLOBALS['GLOBALS']['metacon'] == "" && $GLOBALS['PSET']['metacon'] != "" )
				{
								$GLOBALS['GLOBALS']['metacon'] = $GLOBALS['PSET']['metacon'];
				}
				if ( $GLOBALS['GLOBALS']['metaimage'] == "" && $GLOBALS['PSET']['metaimage'] != "" )
				{
								$GLOBALS['GLOBALS']['metaimage'] = $GLOBALS['PSET']['metaimage'];
				}
				if ( $GLOBALS['GLOBALS']['fbtrack'] == "" && $GLOBALS['PSET']['fbtrack'] != "" )
				{
								$GLOBALS['GLOBALS']['fbtrack'] = $GLOBALS['PSET']['fbtrack'];
				}
				$GLOBALS['GLOBALS']['addmeta'] = $GLOBALS['PSET']['addmeta'];
				$GLOBALS['GLOBALS']['addbtscript'] = $GLOBALS['PSET']['addbtscript'];

				
				$str = showactive( $str, $themes );
				
				echo $str/*.round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL*/;
				
				if ( $GLOBALS['PSET']['buildhtml'] != "" && $GLOBALS['PSET']['buildhtml'] != "0" )
				{
								switch ( $GLOBALS['PSET']['buildhtml'] )
								{
								case "index" :
												buildhtml( "index", $str );
												break;
								default :
												buildhtml( "id", $str );
												break;
								}
				}
}
/**/
/*�����*/
function comprintpage_m($mobitemp,$istb=1,$themes="default")
{
				global $msql;
				global $fsql;
				global $tsql;
				global $reload;
				global $adminMenu;
				global $strMore;
				global $lantype;
				
				if ( $_POST['act'] == "plusset" )
				{
								return printplus( );
								exit( );
				}
				$coltype = $GLOBALS['PSET']['coltype'];
				$pagename = $GLOBALS['PSET']['pagename'];
				$adminMenu = adminmenu( );
				if ( admincheckauth( ) && ($_COOKIE['PLUSADMIN'] == "SET" || $_COOKIE['PLUSADMIN']=="READY") ){
					$str = loadbasetemp( "adminheader.htm" );
				}else{
					$str = $istb? "":loadcustemp_m( "top.htm", $themes );
				}
				$addstr = "\n<script>\n";
				$addstr .= "var PDV_PAGEID='".$GLOBALS['PSET']['id']."'; \nvar PDV_RP='".ROOTPATH."'; \nvar PDV_COLTYPE='".$GLOBALS['PSET']['coltype']."'; \nvar PDV_PAGENAME='".$GLOBALS['PSET']['pagename']."'; \nvar PDV_TMRP='".ROOTPATH."base/templates/themes/".$themes."/mobi/'; \nvar PDV_LAN='".$lantype."'; \n";
				$addstr .= "</script>\n";
				
				$strcon = loadcustemp_m( $mobitemp, $themes );
				$btstr = $istb? "":loadcustemp_m( "bottom.htm", $themes );
				
				if(!$istb || admincheckauth( ) && ($_COOKIE['PLUSADMIN'] == "SET" || $_COOKIE['PLUSADMIN']=="READY")){
					$str = str_replace("{#addscript#}",$addstr,$str, $gcon);
					if(!$gcon){
						$str .= $addstr;
					}
					$strcon = $str.$strcon.$btstr;
				}elseif($istb){
					$strcon = str_replace("{#addscript#}",$addstr,$strcon);
				}
				$i = 1;
				$msql->query( "select * from {P}_base_plus where plustype='".$coltype."' and pluslocat='".$pagename."' and display!='none' order by zindex" );
				while ( $msql->next_record( ) )
				{
								$pdv[$i] = $msql->f( "id" );
								$ModArr[$i] = $msql->f( "modno" );
								$display[$i] = $msql->f( "display" );
								$w[$i] = $msql->f( "width" );
								$h[$i] = $msql->f( "height" );
								$t[$i] = $msql->f( "top" );
								$l[$i] = $msql->f( "left" );
								$z[$i] = $msql->f( "zindex" );
								$pluslable[$i] = $msql->f( "pluslable" );
								$plusname[$i] = $msql->f( "plusname" );
								$showborder[$i] = $msql->f( "showborder" );
								$coltitle[$i] = $msql->f( "title" );
								$padding[$i] = $msql->f( "padding" );
								$catid[$i] = $msql->f( "catid" );
								$tempname[$i] = $msql->f( "tempname" );
								$tempcolor[$i] = $msql->f( "tempcolor" );
								$shownums[$i] = $msql->f( "shownums" );
								$ord[$i] = $msql->f( "ord" );
								$sc[$i] = $msql->f( "sc" );
								$showtj[$i] = $msql->f( "showtj" );
								$cutword[$i] = $msql->f( "cutword" );
								$cutbody[$i] = $msql->f( "cutbody" );
								$picw[$i] = $msql->f( "picw" );
								$pich[$i] = $msql->f( "pich" );
								$fittype[$i] = $msql->f( "fittype" );
								$target[$i] = $msql->f( "target" );
								$body[$i] = $msql->f( "body" );
								if( $lantype !="" && $pluslable[$i] == "modButtomInfo" || $pluslable[$i] == "modEdit"){
									$getlanbody = $fsql->getonelan( "select body from {P}_base_plus where id='$pdv[$i]'" );
									$body[$i] = $getlanbody["body"];
								}
								$pic[$i] = $msql->f( "pic" );
								$attach[$i] = $msql->f( "attach" );
								$text[$i] = $msql->f( "text" );
								$link[$i] = $msql->f( "link" );
								$piclink[$i] = $msql->f( "piclink" );
								$word[$i] = $msql->f( "word" );
								$word1[$i] = $msql->f( "word1" );
								$word2[$i] = $msql->f( "word2" );
								$word3[$i] = $msql->f( "word3" );
								$word4[$i] = $msql->f( "word4" );
								$text1[$i] = $msql->f( "text1" );
								$code[$i] = $msql->f( "code" );
								$link1[$i] = $msql->f( "link1" );
								$link2[$i] = $msql->f( "link2" );
								$link3[$i] = $msql->f( "link3" );
								$link4[$i] = $msql->f( "link4" );
								$tags[$i] = $msql->f( "tags" );
								$movi[$i] = $msql->f( "movi" );
								$sourceurl[$i] = $msql->f( "sourceurl" );
								$overflow[$i] = $msql->f( "overflow" );
								$bodyzone[$i] = $msql->f( "bodyzone" );
								$groupid[$i] = $msql->f( "groupid" );
								$projid[$i] = $msql->f( "projid" );
								$bordercolor[$i] = $msql->f( "bordercolor" );
								$backgroundcolor[$i] = $msql->f( "backgroundcolor" );
								$borderwidth[$i] = $msql->f( "borderwidth" );
								$borderstyle[$i] = $msql->f( "borderstyle" );
								$borderlable[$i] = $msql->f( "borderlable" );
								$borderroll[$i] = $msql->f( "borderroll" );
								$showbar[$i] = $msql->f( "showbar" );
								$barbg[$i] = $msql->f( "barbg" );
								$barcolor[$i] = $msql->f( "barcolor" );
								$morelink[$i] = $msql->f( "morelink" );
								$pluscoltype[$i] = $msql->f( "coltype" );
								$i++;
				}
				
				for ( $p = 1;	$p < $i;	$p++	)
				{
								if ( $overflow[$p] != "visible" )
								{
												$FlowHeight = "height:100%";
								}
								else
								{
												$FlowHeight = "";
								}
								if ( $pluscoltype[$p] != "menu" && $pluscoltype[$p] != "effect" )
								{
												$divTitle = "title='".$coltitle[$p]."'";
								}
								else
								{
												$divTitle = "";
								}
								$bodyArr[$bodyzone[$p]] .= "\n\n<!-- ".$plusname[$p]." -->\n";
								$bodyArr[$bodyzone[$p]] .= "\n<div id='pdv_".$pdv[$p]."' class='pdv_class'  ".$divTitle." style='width:".$w[$p]."px;height:".$h[$p]."px;top:".$t[$p]."px;left:".$l[$p]."px; z-index:".$p."'>";
								$bodyArr[$bodyzone[$p]] .= "\n<div id='spdv_".$pdv[$p]."' class='pdv_".$bodyzone[$p]."' style='overflow:".$overflow[$p].";width:100%;".$FlowHeight."'>";
								$BorederArr = splittbltemp( loadbordertemp( $showborder[$p] ) );
								if ( $morelink[$p] == "" || $morelink[$p] == "http://" || $morelink[$p] == "-1" )
								{
												$showmore = "none";
								}
								else
								{
												$showmore = "inline";
								}
								$var = array(
												"pdvid" => $pdv[$p],
												"coltitle" => $coltitle[$p],
												"padding" => $padding[$p],
												"morelink" => $morelink[$p],
												"showmore" => $showmore,
												"borderwidth" => $borderwidth[$p],
												"bordercolor" => $bordercolor[$p],
												"borderstyle" => $borderstyle[$p],
												"borderlable" => $borderlable[$p],
												"borderroll" => $borderroll[$p],
												"backgroundcolor" => $backgroundcolor[$p],
												"showbar" => $showbar[$p],
												"barbg" => $barbg[$p],
												"barcolor" => $barcolor[$p]
								);
								$bodyArr[$bodyzone[$p]] .= showtpltemp( $BorederArr['start'], $var );
								if ( substr( $pluslable[$p], 0, 3 ) == "mod" )
								{
												$ModName = substr( $pluslable[$p], 3 );
												$ModFile = $ModName.".php";
												$ModNo = $ModArr[$p];
												$ModPath = ROOTPATH.$pluscoltype[$p]."/module/".$ModFile;
												if ( file_exists( $ModPath ) && !strstr( $ModFile, "/" ) )
												{
																include_once( $ModPath );
																$func = $ModName;
																if ( function_exists( $func ) )
																{
																				$GLOBALS['GLOBALS']['PLUSVARS'] = array(
																								"pagename" => $GLOBALS['PSET']['pagename'],
																								"pdv" => $pdv[$p],
																								"tempname" => $tempname[$p],
																								"tempcolor" => $tempcolor[$p],
																								"pluscoltype" => $pluscoltype[$p],
																								"coltitle" => $coltitle[$p],
																								"cutbody" => $cutbody[$p],
																								"picw" => $picw[$p],
																								"pich" => $pich[$p],
																								"fittype" => $fittype[$p],
																								"shownums" => $shownums[$p],
																								"ord" => $ord[$p],
																								"sc" => $sc[$p],
																								"showtj" => $showtj[$p],
																								"cutword" => $cutword[$p],
																								"target" => $target[$p],
																								"pic" => $pic[$p],
																								"attach" => $attach[$p],
																								"text" => $text[$p],
																								"link" => $link[$p],
																								"piclink" => $piclink[$p],
																								"word" => $word[$p],
																								"word1" => $word1[$p],
																								"word2" => $word2[$p],
																								"word3" => $word3[$p],
																								"word4" => $word4[$p],
																								"text1" => $text1[$p],
																								"code" => $code[$p],
																								"link1" => $link1[$p],
																								"link2" => $link2[$p],
																								"link3" => $link3[$p],
																								"link4" => $link4[$p],
																								"tags" => $tags[$p],
																								"movi" => $movi[$p],
																								"sourceurl" => $sourceurl[$p],
																								"w" => $w[$p],
																								"h" => $h[$p],
																								"l" => $l[$p],
																								"t" => $t[$p],
																								"z" => $z[$p],
																								"showborder" => $showborder[$p],
																								"padding" => $padding[$p],
																								"groupid" => $groupid[$p],
																								"projid" => $projid[$p],
																								"body" => $body[$p],
																								"catid" => $catid[$p],
																								"morelink" => $morelink[$p]
																				);
																				$bodyArr[$bodyzone[$p]] .= $getfunc = $func( );
																				$strcon = str_replace("{#".$coltitle[$p]."#}",$getfunc,$strcon);
																}
																else
																{
																				$bodyArr[$bodyzone[$p]] .= "module function not exist";
																				$strcon = str_replace("{#".$coltitle[$p]."#}","module function not exist",$strcon);
																}
												}
												else
												{
																$bodyArr[$bodyzone[$p]] .= "module file (".$ModPath.") not exist ";
																$strcon = str_replace("{#".$coltitle[$p]."#}","module file (".$ModPath.") not exist",$strcon);
												}
								}
								else
								{
												$bodyArr[$bodyzone[$p]] .= "plus not a module";
												$strcon = str_replace("{#".$coltitle[$p]."#}","plus not a module",$strcon);
								}
								$bodyArr[$bodyzone[$p]] .= $BorederArr['end'];
								$bodyArr[$bodyzone[$p]] .= "\n</div>";
								$bodyArr[$bodyzone[$p]] .= "\n</div>";

				}
				if ( admincheckauth( ) && ($_COOKIE['PLUSADMIN'] == "SET" || $_COOKIE['PLUSADMIN']=="READY") ){
					$str .= "\n<div id='contain' style='width:100%;";
				$str .= "background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['containbg'] ).";margin:".$GLOBALS['PSET']['containmargin']."px ".$GLOBALS['PSET']['containcenter'].";padding:".$GLOBALS['PSET']['containpadding']."px'>\n\n";
				$str .= "<div id='topbgout' style='width:100%;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['topbgout'] )."'>\n";
				$str .= "<div id='top' style='width:".$GLOBALS['PSET']['containwidth']."px;height:".$GLOBALS['PSET']['th']."px;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['topbg'] ).";".$pageLeft."'>\n";
				$str .= $bodyArr['top'];
				$str .= "\n</div>\n";
				$str .= "\n</div>\n";
				$str .= "<div id='contentbgout' style='width:100%; height:100%;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['contentbgout'] ).";overflow:hidden; zoom:1;'>\n";
				$str .= "<div id='content' style='width:".$GLOBALS['PSET']['containwidth']."px;height:".$GLOBALS['PSET']['ch']."px;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['contentbg'] ).";margin:".$GLOBALS['PSET']['contentmargin']."px auto;".$pageLeft."'>\n";
				$str .= $bodyArr['content'];
				$str .= "\n</div>\n";
				$str .= "\n</div>\n";
				$str .= "<div id='bottombgout' style='width:100%;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['bottombgout'] )."'>\n";
				$str .= "<div id='bottom' style='width:".$GLOBALS['PSET']['containwidth']."px;height:".$GLOBALS['PSET']['bh']."px;background:".str_replace( "url(effect/", "url(".ROOTPATH."effect/", $GLOBALS['PSET']['bottombg'] ).";".$pageLeft."'>\n";
				$str .= $bodyArr['bottom'];
				$str .= "\n</div>\n";
				$str .= "\n</div>\n";
				$str .= "</div>";
				$str .= "<div id='bodyex'>\n";
				$str .= $bodyArr['bodyex'];
				$str .= "\n</div>\n";
				}else{
					if($istb){
						$str .= $strcon;
					}else{
						$str = $strcon;
					}
				}
				$GLOBALS['GLOBALS']['PLUSVARS'] = "";
				if ( admincheckauth( ) && ($_COOKIE['PLUSADMIN'] == "SET" || $_COOKIE['PLUSADMIN']=="READY") ){
					$str .= loadbasetemp( "adminfoot.htm" );
				}
				
				if ( $GLOBALS['PSET']['pagetitle'] != "" )
				{
								$GLOBALS['GLOBALS']['pagetitle'] = $GLOBALS['PSET']['pagetitle'];
				}
				if ( $GLOBALS['GLOBALS']['metakey'] =="" && $GLOBALS['PSET']['metakey'] != "" )
				{
								$GLOBALS['GLOBALS']['metakey'] = $GLOBALS['PSET']['metakey'];
				}
				if ( $GLOBALS['GLOBALS']['metacon'] == "" && $GLOBALS['PSET']['metacon'] != "" )
				{
								$GLOBALS['GLOBALS']['metacon'] = $GLOBALS['PSET']['metacon'];
				}
				if ( $GLOBALS['GLOBALS']['metaimage'] == "" && $GLOBALS['PSET']['metaimage'] != "" )
				{
								$GLOBALS['GLOBALS']['metaimage'] = $GLOBALS['PSET']['metaimage'];
				}
				if ( $GLOBALS['GLOBALS']['fbtrack'] == "" && $GLOBALS['PSET']['fbtrack'] != "" )
				{
								$GLOBALS['GLOBALS']['fbtrack'] = $GLOBALS['PSET']['fbtrack'];
				}
				$GLOBALS['GLOBALS']['addmeta'] = $GLOBALS['PSET']['addmeta'];
				$GLOBALS['GLOBALS']['addbtscript'] = $GLOBALS['PSET']['addbtscript'];
				$str = showactive( $str, $themes."/mobi" );
				echo $str;
				if ( $GLOBALS['PSET']['buildhtml'] != "" && $GLOBALS['PSET']['buildhtml'] != "0" )
				{
								switch ( $GLOBALS['PSET']['buildhtml'] )
								{
								case "index" :
												buildhtml( "index", $str );
												break;
								default :
												buildhtml( "id", $str );
												break;
								}
				}
}
/**/
function printplus( )
{
				global $msql;
				global $fsql;
				global $strMore;
				$pdvid = $_POST['pdvid'];
				$plusid = substr( $pdvid, 4 );
				$i = 1;
				$msql->query( "select * from {P}_base_plus where id='{$plusid}'" );
				if ( $msql->next_record( ) )
				{
								$pdv[$i] = $msql->f( "id" );
								$ModArr[$i] = $msql->f( "modno" );
								$display[$i] = $msql->f( "display" );
								$w[$i] = $msql->f( "width" );
								$h[$i] = $msql->f( "height" );
								$t[$i] = $msql->f( "top" );
								$l[$i] = $msql->f( "left" );
								$z[$i] = $msql->f( "zindex" );
								$pluslable[$i] = $msql->f( "pluslable" );
								$plusname[$i] = $msql->f( "plusname" );
								$showborder[$i] = $msql->f( "showborder" );
								$coltitle[$i] = $msql->f( "title" );
								$padding[$i] = $msql->f( "padding" );
								$catid[$i] = $msql->f( "catid" );
								$tempname[$i] = $msql->f( "tempname" );
								$tempcolor[$i] = $msql->f( "tempcolor" );
								$shownums[$i] = $msql->f( "shownums" );
								$ord[$i] = $msql->f( "ord" );
								$sc[$i] = $msql->f( "sc" );
								$showtj[$i] = $msql->f( "showtj" );
								$cutword[$i] = $msql->f( "cutword" );
								$cutbody[$i] = $msql->f( "cutbody" );
								$picw[$i] = $msql->f( "picw" );
								$pich[$i] = $msql->f( "pich" );
								$fittype[$i] = $msql->f( "fittype" );
								$target[$i] = $msql->f( "target" );
								$body[$i] = $msql->f( "body" );
								if( $lantype !="" && $pluslable[$i] == "modButtomInfo" || $pluslable[$i] == "modEdit"){
									$getlanbody = $fsql->getonelan( "select body from {P}_base_plus where id='$pdv[$i]'" );
									$body[$i] = $getlanbody["body"];
								}
								$pic[$i] = $msql->f( "pic" );
								$attach[$i] = $msql->f( "attach" );
								$text[$i] = $msql->f( "text" );
								$link[$i] = $msql->f( "link" );
								$piclink[$i] = $msql->f( "piclink" );
								$word[$i] = $msql->f( "word" );
								$word1[$i] = $msql->f( "word1" );
								$word2[$i] = $msql->f( "word2" );
								$word3[$i] = $msql->f( "word3" );
								$word4[$i] = $msql->f( "word4" );
								$text1[$i] = $msql->f( "text1" );
								$code[$i] = $msql->f( "code" );
								$link1[$i] = $msql->f( "link1" );
								$link2[$i] = $msql->f( "link2" );
								$link3[$i] = $msql->f( "link3" );
								$link4[$i] = $msql->f( "link4" );
								$tags[$i] = $msql->f( "tags" );
								$movi[$i] = $msql->f( "movi" );
								$sourceurl[$i] = $msql->f( "sourceurl" );
								$overflow[$i] = $msql->f( "overflow" );
								$bodyzone[$i] = $msql->f( "bodyzone" );
								$groupid[$i] = $msql->f( "groupid" );
								$projid[$i] = $msql->f( "projid" );
								$bordercolor[$i] = $msql->f( "bordercolor" );
								$backgroundcolor[$i] = $msql->f( "backgroundcolor" );
								$borderwidth[$i] = $msql->f( "borderwidth" );
								$borderstyle[$i] = $msql->f( "borderstyle" );
								$borderlable[$i] = $msql->f( "borderlable" );
								$borderroll[$i] = $msql->f( "borderroll" );
								$showbar[$i] = $msql->f( "showbar" );
								$barbg[$i] = $msql->f( "barbg" );
								$barcolor[$i] = $msql->f( "barcolor" );
								$morelink[$i] = $msql->f( "morelink" );
								$pluscoltype[$i] = $msql->f( "coltype" );
								$i++;
				}
				
				for ( $p = 1;	$p < $i;	$p++	)
				{
								if ( $overflow[$p] != "visible" )
								{
												$FlowHeight = "height:100%;";
								}
								else
								{
												$FlowHeight = "";
								}
								if ( $pluscoltype[$p] != "menu" && $pluscoltype[$p] != "effect" )
								{
												$divTitle = "title='".$coltitle[$p]."'";
								}
								else
								{
												$divTitle = "";
								}
								$str .= "\n<div id='pdv_".$pdv[$p]."' class='pdv_class'  ".$divTitle." style='width:".$w[$p]."px;height:".$h[$p]."px;top:".$t[$p]."px;left:".$l[$p]."px; z-index:90'>";
								$str .= "<div id='spdv_".$pdv[$p]."' class='pdv_".$bodyzone[$p]."' style='overflow:".$overflow[$p].";width:100%;".$FlowHeight."'>";
								$BorederArr = splittbltemp( loadbordertemp( $showborder[$p] ) );
								if ( $morelink[$p] == "" || $morelink[$p] == "http://" || $morelink[$p] == "-1" )
								{
												$showmore = "none";
								}
								else
								{
												$showmore = "inline";
								}
								$var = array(
												"pdvid" => $pdv[$p],
												"coltitle" => $coltitle[$p],
												"padding" => $padding[$p],
												"morelink" => $morelink[$p],
												"showmore" => $showmore,
												"borderwidth" => $borderwidth[$p],
												"bordercolor" => $bordercolor[$p],
												"borderstyle" => $borderstyle[$p],
												"borderlable" => $borderlable[$p],
												"borderroll" => $borderroll[$p],
												"backgroundcolor" => $backgroundcolor[$p],
												"showbar" => $showbar[$p],
												"barbg" => $barbg[$p],
												"barcolor" => $barcolor[$p]
								);
								$str .= showtpltemp( $BorederArr['start'], $var );
								if ( substr( $pluslable[$p], 0, 3 ) == "mod" )
								{
												$ModName = substr( $pluslable[$p], 3 );
												$ModFile = $ModName.".php";
												$ModNo = $ModArr[$p];
												if ( $pluscoltype[$p] != "" )
												{
																$ModPath = ROOTPATH.$pluscoltype[$p]."/module/".$ModFile;
												}
												else
												{
																$ModPath = ROOTPATH."module/".$ModFile;
												}
												if ( file_exists( $ModPath ) && !strstr( $ModFile, "/" ) )
												{
																include_once( $ModPath );
																$func = $ModName;
																if ( function_exists( $func ) )
																{
																				$GLOBALS['GLOBALS']['PLUSVARS'] = array(
																								"pagename" => $GLOBALS['PSET']['pagename'],
																								"pdv" => $pdv[$p],
																								"tempname" => $tempname[$p],
																								"tempcolor" => $tempcolor[$p],
																								"pluscoltype" => $pluscoltype[$p],
																								"coltitle" => $coltitle[$p],
																								"cutbody" => $cutbody[$p],
																								"picw" => $picw[$p],
																								"pich" => $pich[$p],
																								"fittype" => $fittype[$p],
																								"shownums" => $shownums[$p],
																								"ord" => $ord[$p],
																								"sc" => $sc[$p],
																								"showtj" => $showtj[$p],
																								"cutword" => $cutword[$p],
																								"target" => $target[$p],
																								"pic" => $pic[$p],
																								"attach" => $attach[$p],
																								"text" => $text[$p],
																								"link" => $link[$p],
																								"piclink" => $piclink[$p],
																								"word" => $word[$p],
																								"word1" => $word1[$p],
																								"word2" => $word2[$p],
																								"word3" => $word3[$p],
																								"word4" => $word4[$p],
																								"text1" => $text1[$p],
																								"code" => $code[$p],
																								"link1" => $link1[$p],
																								"link2" => $link2[$p],
																								"link3" => $link3[$p],
																								"link4" => $link4[$p],
																								"tags" => $tags[$p],
																								"movi" => $movi[$p],
																								"sourceurl" => $sourceurl[$p],
																								"w" => $w[$p],
																								"h" => $h[$p],
																								"l" => $l[$p],
																								"t" => $t[$p],
																								"z" => $z[$p],
																								"showborder" => $showborder[$p],
																								"padding" => $padding[$p],
																								"groupid" => $groupid[$p],
																								"projid" => $projid[$p],
																								"body" => $body[$p],
																								"catid" => $catid[$p],
																								"morelink" => $morelink[$p]
																				);
																				$str .= $func( );
																}
																else
																{
																				$str .= "module function not exist";
																}
												}
												else
												{
																$str .= "module file (".$ModPath.") not exist ";
												}
								}
								else
								{
												$str .= "plus not a module";
								}
								$str .= $BorederArr['end'];
								$str .= "</div>";
								$str .= "</div>";
				}
				$str = str_replace( "\r", "", $str );
				$str = str_replace( "\n", "", $str );
				$str = showactive( $str );
				echo $str;
				exit( );
}

function showactive( $EditCon, $themes="" )
{
	
				$EditCon = str_replace( "{#sitename#}", $GLOBALS['CONF']['SiteName'], $EditCon );
				$EditCon = str_replace( "[ROOTPATH]", ROOTPATH, $EditCon );
				$EditCon = str_replace( "{#RP#}", ROOTPATH, $EditCon );
				if($themes) $EditCon = str_replace( "{#TM#}", ROOTPATH."base/templates/themes/".$themes."/", $EditCon );
				$array = explode( "{#", $EditCon );
				$EditCon = $array[0];
				$t = 1;
				for ( ;	$t < sizeof( $array );	$t++	)
				{
								$arrayx = explode( "#}", $array[$t] );
								if ( isset( $GLOBALS[$arrayx[0]] ) )
								{
												$CodeString = $GLOBALS[$arrayx[0]];
								}
								else
								{
												$CodeString = "";
								}
								
								$EditCon .= $CodeString;
								$EditCon .= $arrayx[1];
								
				}
				
				return $EditCon;
}

function showtpltemp( $EditCon, $var )
{
				$array = explode( "{#", $EditCon );
				$EditCon = $array[0];
				$t = 1;
				for ( ;	$t < sizeof( $array );	$t++	)
				{
								$arrayx = explode( "#}", $array[$t] );
								if ( isset( $var[$arrayx[0]] ) )
								{
												$CodeString = $var[$arrayx[0]];
								}
								else
								{
												$CodeString = "{#".$arrayx[0]."#}";
								}
								$EditCon .= $CodeString;
								$EditCon .= $arrayx[1];
				}
				return $EditCon;
}

function splittbltemp( $Temp )
{
				$arr = explode( "<!-start->", $Temp );
				$TempArr['start'] = $arr[1];
				$arr = explode( "<!-rowstart->", $Temp );
				$TempArr['rowstart'] = $arr[1];
				$arr = explode( "<!-menu->", $Temp );
				$TempArr['menu'] = $arr[1];
				$arr = explode( "<!-menunow->", $Temp );
				$TempArr['menunow'] = $arr[1];
				$arr = explode( "<!-secondmenu->", $Temp );
				$TempArr['secondmenu'] = $arr[1];
				$arr = explode( "<!-input->", $Temp );
				$TempArr['input'] = $arr[1];
				$arr = explode( "<!-textarea->", $Temp );
				$TempArr['textarea'] = $arr[1];
				$arr = explode( "<!-rowend->", $Temp );
				$TempArr['rowend'] = $arr[1];
				$arr = explode( "<!-end->", $Temp );
				$TempArr['end'] = $arr[1];
				$arr = explode( "<!-list->", $Temp );
				$TempArr['list'] = $arr[1];
				$arr = explode( "<!-con->", $Temp );
				$TempArr['con'] = $arr[1];
				$arr = explode( "<!-col->", $Temp );
				$TempArr['col'] = $arr[1];
				$arr = explode( "<!-text->", $Temp );
				$TempArr['text'] = $arr[1];
				$arr = explode( "<!-link->", $Temp );
				$TempArr['link'] = $arr[1];
				$arr = explode( "<!-form->", $Temp );
				$TempArr['form'] = $arr[1];
				$arr = explode( "<!-notice->", $Temp );
				$TempArr['notice'] = $arr[1];
				$arr = explode( "<!-more->", $Temp );
				$TempArr['more'] = $arr[1];
				$arr = explode( "<!-m0->", $Temp );
				$TempArr['m0'] = $arr[1];
				$arr = explode( "<!-m1->", $Temp );
				$TempArr['m1'] = $arr[1];
				$arr = explode( "<!-m2->", $Temp );
				$TempArr['m2'] = $arr[1];
				$arr = explode( "<!-m3->", $Temp );
				$TempArr['m3'] = $arr[1];
				$arr = explode( "<!-m4->", $Temp );
				$TempArr['m4'] = $arr[1];
				$arr = explode( "<!-ok1->", $Temp );
				$TempArr['ok1'] = $arr[1];
				$arr = explode( "<!-ok2->", $Temp );
				$TempArr['ok2'] = $arr[1];
				$arr = explode( "<!-err1->", $Temp );
				$TempArr['err1'] = $arr[1];
				$arr = explode( "<!-err2->", $Temp );
				$TempArr['err2'] = $arr[1];
				$arr = explode( "<!-err3->", $Temp );
				$TempArr['err3'] = $arr[1];
				$arr = explode( "<!-err4->", $Temp );
				$TempArr['err4'] = $arr[1];
				$arr = explode( "<!-err5->", $Temp );
				$TempArr['err5'] = $arr[1];
				$arr = explode( "<!-menu1->", $Temp );
				$TempArr['menu1'] = $arr[1];
				$arr = explode( "<!-menu2->", $Temp );
				$TempArr['menu2'] = $arr[1];
				$arr = explode( "<!-menu3->", $Temp );
				$TempArr['menu3'] = $arr[1];
				$arr = explode( "<!-menu4->", $Temp );
				$TempArr['menu4'] = $arr[1];
				return $TempArr;
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

function buildhtml( $htmltype, $PageAll )
{				
	
				if ( admincheckmodle( ) )
				{
								return "";
				}
				if ( strstr( $_SERVER['QUERY_STRING'], ".html" ) )
				{
								$arr = explode( ".html", $_SERVER['QUERY_STRING'] );
								$htmlid = $arr[0];
								if ( $htmlid != "" && ( $_SERVER['QUERY_STRING'] == $htmlid.".html" || $_GET['htmlversion'] != "" ) )
								{
												$ifbuild = "yes";
								}
								else
								{
												return "";
								}
				}
				else if ( $htmltype == "index" )
				{
								$htmlid = "index";
								$ifbuild = "yes";
				}
				else
				{
								return "";
				}
				if ( $GLOBALS['CONF']['CatchOpen'] != "1" || 0 < $GLOBALS['consecure'] )
				{
								if ( file_exists( "./".$htmlid.".html" ) )
								{
												@unlink( "./".$htmlid.".html" );
								}
								return "";
				}
				if ( $ifbuild == "yes" )
				{
								$vertime = time( );
								$CatchTime = $GLOBALS['CONF']['CatchTime'];
								$reload = "<script>BuildHtml('".ROOTPATH."','".$vertime."','".$CatchTime."','".$htmlid."');</script>";
								$PageAll = str_replace( "<!-reload-!>", $reload, $PageAll );
								if ( !is_writable( "./" ) )
								{
												echo "Error: Fold (./) is not writable";
												exit( );
								}
								$fd = fopen( "./".$htmlid.".html", w );
								fwrite( $fd, $PageAll, 300000 );
								fclose( $fd );
				}
}

function delfold( $imagefold )
{
				if ( file_exists( $imagefold ) )
				{
								$handle = opendir( $imagefold );
								while ( $image_file = readdir( $handle ) )
								{
												$nowfile = "{$imagefold}/{$image_file}";
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

function fmpath( $catid )
{
				$pathid = str_pad($catid, 4, "0", STR_PAD_LEFT);
				return $pathid;
}

function tblcount( $tbl, $id, $scl )
{
				global $fsql;
				$fsql->query( "select count(".$id.") from {P}".$tbl." where {$scl}" );
				if ( $fsql->next_record( ) )
				{
								$totalnums = $fsql->f( "count(".$id.")" );
				}
				return $totalnums;
}

function csubstr( $str, $start, $len )
{		preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/",$str,$ar);
				$x = 1;
				for ( $i = 0; $i < sizeof( $ar[0] ); $i++ )
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

function saytemp( $say, $link, $url, $Temp )
{
				$Temp = str_replace( "{#url#}", $url, $Temp );
				$Temp = str_replace( "{#link#}", $link, $Temp );
				$Temp = str_replace( "{#say#}", $say, $Temp );
				return $Temp;
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
				$string = loadtemp( "tpl_err.htm" );
				$string = saytemp( $say, $link, $url, $string );
				return $string;
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
				$string = loadtemp( "tpl_ok.htm" );
				$string = saytemp( $say, $link, $url, $string );
				return $string;
}

function islogin( )
{
				if ( isset( $_COOKIE['MUSER'], $_COOKIE['MEMBERID'] ) && isset( $_COOKIE['ZC'] ) && $_COOKIE['MEMBERID'] != "" && $_COOKIE['MUSER'] != "" && $_COOKIE['ZC'] != "" )
				{
								$md5 = md5( $_COOKIE['MUSER']."76|01|14".$_COOKIE['MEMBERID'].$_COOKIE['MEMBERTYPE'].$_COOKIE['SE'] );
								if ( $_COOKIE['ZC'] == $md5 )
								{
												return true;
								}
								else
								{
												return false;
								}
				}
				else
				{
								return false;
				}
}

//�|���ϥ[�K����
function SecureMember(){


	if(!isset($_COOKIE["MUSER"])  || !isset($_COOKIE["ZC"]) || $_COOKIE["MUSER"]=="" || $_COOKIE["ZC"]=="" || $_COOKIE["MEMBERTYPEID"]==""){
		echo "<script>top.location='".ROOTPATH."'</script>";
		exit;

	}else{
			$md5=md5($_COOKIE["MUSER"]."76|01|14".$_COOKIE["MEMBERID"].$_COOKIE["MEMBERTYPE"].$_COOKIE["SE"]);
			if($_COOKIE["ZC"]!=$md5){
					echo "<script>top.location='".ROOTPATH."'</script>";
					exit;
			}

		
			
	}

}


//�\��ާ@�v������
function SecureFunc($secureid){

	global $fsql;

	$memberid=$_COOKIE["MEMBERID"];
	$memberid=htmlspecialchars($memberid);

	$fsql->query("select id from {P}_member_rights where memberid='$memberid' and secureid='$secureid'");
	if($fsql->next_record()){

		return true;
	}else{
		
		return false;
	}
}


//�����ާ@�v������
function SecureClass($secureid){

	global $fsql;

	$memberid=$_COOKIE["MEMBERID"];
	$memberid=htmlspecialchars($memberid);

	$fsql->query("select secureset from {P}_member_rights where memberid='$memberid' and secureid='$secureid'");
	if($fsql->next_record()){
		$secureset=$fsql->f('secureset');
		return $secureset;
	}else{
		return "0";
	}
}


//���D���e�޲z�v������
function SecureBanzhu($secureid){

	global $fsql;

	$memberid=$_COOKIE["MEMBERID"];
	$memberid=htmlspecialchars($memberid);

	$fsql->query("select secureset from {P}_member_rights where memberid='$memberid' and secureid='$secureid'");
	if($fsql->next_record()){
		$secureset=$fsql->f('secureset');
		return $secureset;
	}else{
		return "0";
	}
}

//�n���p��
function MemberCentUpdate($memberid,$event){

	global $tsql;
	if($memberid=="" || $memberid=="0" || $memberid=="-1"){
		return false;
	}

	$tsql->query("select * from {P}_member_centrule where event='$event'");
	if($tsql->next_record()){
		$cent1=$tsql->f('cent1');
		$cent2=$tsql->f('cent2');
		$cent3=$tsql->f('cent3');
		$cent4=$tsql->f('cent4');
		$cent5=$tsql->f('cent5');
	}
	
	$tsql->query("update {P}_member set
	`cent1`=cent1+$cent1,
	`cent2`=cent2+$cent2,
	`cent3`=cent3+$cent3,
	`cent4`=cent4+$cent4,
	`cent5`=cent5+$cent5
	where memberid='$memberid'");

	$now=time();

	$tsql->query("insert into {P}_member_centlog set
	`memberid`='$memberid',
	`dtime`='$now',
	`event`='$event',
	`cent1`='$cent1',
	`cent2`='$cent2',
	`cent3`='$cent3',
	`cent4`='$cent4',
	`cent5`='$cent5'
	 ");


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


function inject_check($sql_str) {
   if(@preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile|<script>|alert/i', $sql_str)){
    return true;
   };
  
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

error_reporting( E_ERROR | E_WARNING | E_PARSE );

if ( $_GET['htmlversion'] != "" && $_GET['htmlcatchtime'] != "" )
{
				$exp = $_GET['htmlversion'] + $_GET['htmlcatchtime'];
				$now = time( );
				if ( $now <= $exp )
				{
								echo "0";
								exit( );
				}
				if ( admincheckmodle( ) )
				{
								echo "NOCATCH";
								exit( );
				}
}

/*include_once ROOTPATH."wayhunt/config.php";
include_once ROOTPATH."wayhunt/project-security.php";*/

include_once( ROOTPATH."config.inc.php" );
include_once( ROOTPATH."version.php" );
include_once( ROOTPATH."includes/db.inc.php" );
/**/
//�P�_��O

$lans = $_COOKIE["DLAN"];
$pricesyb = $_COOKIE["DPSYB"];
$orilans = getDefaultLan();
$sLan = "zh_tw";

if(!isset($_COOKIE["USERLANS"])){
	list($userlans,$isHK,$isMY) = explode(",",userLanguage($aLanList));
	setcookie("USERLANS",$userlans.",".$isHK.",".$isMY, time( ) + 10800,"/");
}else{
	list($userlans,$isHK,$isMY) = explode(",",$_COOKIE["USERLANS"]);
	$lantype = $userlans;
	$sLan = $lantype;
}

if(isset($_COOKIE["LANTYPE"])){
	$lantype = $_COOKIE["LANTYPE"];
	$sLan = $lantype;
}elseif(!isset($_COOKIE["LANTYPE"])){
	setcookie("LANTYPE",$userlans, time( ) + 10800,"/");
	$lantype = $userlans;
	$sLan = $lantype;
}

if(isset($_COOKIE["PSYB"])){
	$sybtype = $_COOKIE["PSYB"];
}

if(!isset($_COOKIE["DLAN"])){
	setcookie("DLAN", $orilans, time( ) + 86400,"/");
}
if(!isset($_COOKIE["DPSYB"])){
	list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",getDefaultSyb());
	setcookie("DPSYB", $getpriceid, time( ) + 86400,"/");
}

if(isset($_GET['lan']) && in_array(strtolower($_GET['lan']), $aLanList)){
		setcookie("LANTYPE",$_GET['lan'], time( ) + 10800,"/");
		$lantype = $_GET['lan'];
		$sLan = $lantype;
}

if(isset($_GET['syb'])){
		setcookie("PSYB",getSyb($_GET['syb']), time( ) + 10800,"/");
		$sybtype = getSyb($_GET['syb']);
}elseif(!isset($_COOKIE["PSYB"])){

	setcookie("PSYB",getSyb($userlans,$isHK,$isMY), time( ) + 10800,"/");
	$sybtype = getSyb($userlans,$isHK,$isMY);
}

	if($_COOKIE["SYSUSER"] == "wayhunt"){
		/*preg_match('/^([a-z\-]+)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches);
		$acclang = strtolower($matches[1]);
		echo var_dump($acclang);*/
		//echo var_dump($_COOKIE);
		//echo var_dump(getSyb($_GET['syb']));

		/*setcookie("LANTYPE","",time( ) - 86400);
		setcookie("LANTYPE","", time( ) - 86400,"/");
		setcookie("PSYB","", time( ) - 86400);
		setcookie("PSYB","", time( ) - 86400,"/");
		setcookie("DLAN", "", time( ) - 86400);
		setcookie("DLAN", "", time( ) - 86400,"/");
		setcookie("DPSYB", "", time( ) - 86400);
		setcookie("DPSYB", "", time( ) - 86400,"/");
		setcookie("USERLANS", "", time( ) - 86400);
		setcookie("USERLANS", "", time( ) - 86400,"/");*/
	}

/**/
@include_once( ROOTPATH."base/language/".$sLan.".php" );
readconfig( );

?>