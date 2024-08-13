<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( ROOTPATH."includes/data.inc.php" );
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
			$ifshow=$msql->f('ifshow');
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
		/*if($coltype == "config"){
			$str.="<li><a id='m".$i."' class='menulist' href='".ROOTPATH."remawik/' target='_blank'><i class='fa fa-dashboard'></i> 網站統計</a></li>";
		}*/
		echo $str;
		exit;

	break;
	//修改模組簡稱
	case "modiname" :
		$id=$_POST["id"];
		$nowname=strtolower(trim($_POST["nowname"]));
		$issetup = $msql->query("UPDATE {P}_base_coltype SET sname='{$nowname}' WHERE id='{$id}' ");
		if($issetup){
			echo "OK";
			exit;
		}else{
			echo "查無模組，簡稱更新失敗";
			exit;
		}
	break;
case "getbordertemplist" :
		needauth( 5 );
		$pluslable = $_POST['pluslable'];
		if ( $pluslable == "modGroupLable" )
		{
				$sql = " where bordertype='lable' ";
		}
		else
		{
				$sql = " where bordertype='border' ";
		}
		$str = "";
		$msql->query( "select * from {P}_base_border ".$sql." order by tempid" );
		while ( $msql->next_record( ) )
		{
				$tempid = $msql->f( "tempid" );
				$btempname = $msql->f( "tempname" );
				$str .= "<div id='bt_".$tempid."' class='bordtemplist'>".$tempid." ".$btempname."</div>";
		}
		echo $str;
		exit( );
		break;
case "previewborder" :
		needauth( 5 );
		$borderid = $_POST['borderid'];
		$coltitle = $_POST['coltitle'];
		$borderwidth = $_POST['borderwidth'];
		$bordercolor = $_POST['bordercolor'];
		$borderstyle = $_POST['borderstyle'];
		$backgroundcolor = $_POST['backgroundcolor'];
		$showbar = $_POST['showbar'];
		$barbg = $_POST['barbg'];
		$barcolor = $_POST['barcolor'];
		
	if (substr( $borderid,1,2) == "p_"){
        	$borderid = substr( $borderid,0,1).substr( $borderid,3);
				if ( $borderid == "1000" )
				{
        	$path = ROOTPATH."base/border/add/".$borderid."/tpl.htm";
        	$imgpath = ROOTPATH."base/border/add/".$borderid."/images/";
				}
				else if ( substr( $borderid, 1, 1 ) == "0" )
				{
        	$path = ROOTPATH."base/border/add/".substr($borderid,1)."/".substr( $borderid,0,1).".htm";
        	$imgpath = ROOTPATH."base/border/add/".substr($borderid,1)."/images/";
				}
				else
				{
        	$path = ROOTPATH."base/border/add/".substr($borderid,1)."/tpl.htm";
        	$imgpath = ROOTPATH."base/border/add/".substr($borderid,1)."/images/";
        		}

	}else{
		if ( $borderid == "1000" )
		{
				$path = ROOTPATH."base/border/".$borderid."/tpl.htm";
				$imgpath = ROOTPATH."base/border/".$borderid."/images/";
		}
		else if ( substr( $borderid, 1, 1 ) == "0" )
		{
				$path = ROOTPATH."base/border/".substr( $borderid, 1 )."/".substr( $borderid, 0, 1 ).".htm";
				$imgpath = ROOTPATH."base/border/".substr( $borderid, 1 )."/images/";
		}
		else
		{
				$path = ROOTPATH."base/border/".substr( $borderid, 1 )."/tpl.htm";
				$imgpath = ROOTPATH."base/border/".substr( $borderid, 1 )."/images/";
		}
	}
	
		if ( file_exists( $path ) )
		{
				$fd = fopen( $path, r );
				$str = fread( $fd, 300000 );
				fclose( $fd );
				$str = str_replace( "{#RP#}", ROOTPATH, $str );
				$str = str_replace( "images/", $imgpath, $str );
				$str = str_replace( "{#coltitle#}", $coltitle, $str );
				$str = str_replace( "{#morelink#}", "#", $str );
				$str = str_replace( "{#showmore#}", "block", $str );
				$str = str_replace( "{#borderwidth#}", $borderwidth, $str );
				$str = str_replace( "{#bordercolor#}", $bordercolor, $str );
				$str = str_replace( "{#borderstyle#}", $borderstyle, $str );
				$str = str_replace( "{#backgroundcolor#}", $backgroundcolor, $str );
				$str = str_replace( "{#showbar#}", $showbar, $str );
				$str = str_replace( "{#barbg#}", $barbg, $str );
				$str = str_replace( "{#barcolor#}", $barcolor, $str );
				$arr = explode( "<!-start->", $str );
				$TempArr['start'] = $arr[1];
				$arr = explode( "<!-end->", $str );
				$TempArr['end'] = $arr[1];
				$str = $TempArr['start']."<img src='images/plusborder.gif' border='0' width='100%' />".$TempArr['end'];
		}
		else
		{
				$str = $strBorderNotExist;
		}
		echo $str;
		exit( );
		break;
case "getplustemplist" :
		needauth( 5 );
		$pluslable = $_POST['pluslable'];
		$set_tempname = $_POST['set_tempname'];
		$tempname = $_POST['tempname'];
		$str = "";
		if ( $tempname == $set_tempname )
		{
				$str .= "<div id='pt_0' class='plustemplist' style='border-color:#d8f0fa;background:#f4fafd' title='".$set_tempname."'>".$strTempDef." (".$set_tempname.")</div>";
		}
		else
		{
				$str .= "<div id='pt_0' class='plustemplist' title='".$set_tempname."'>".$strTempDef." (".$set_tempname.")</div>";
		}
		$fsql->query( "select * from {P}_base_plustemp where pluslable='{$pluslable}'  order by id" );
		while ( $fsql->next_record( ) )
		{
				$tempid = $fsql->f( "id" );
				$cname = $fsql->f( "cname" );
				$ctempname = $fsql->f( "tempname" );
				if ( $tempname == $ctempname )
				{
						$str .= "<div id='pt_".$tempid."' class='plustemplist' style='border-color:#d8f0fa;background:#f4fafd' title='".$ctempname."'>".$cname." (".$ctempname.")</div>";
				}
				else
				{
						$str .= "<div id='pt_".$tempid."' class='plustemplist' title='".$ctempname."'>".$cname." (".$ctempname.")</div>";
				}
		}
		echo $str;
		exit( );
		break;
case "getpicsource" :
		needauth( 5 );
		$sourcename = $_POST['sourcename'];
		$sourcefolder = $_POST['sourcefolder'];
		$sourcefold = ROOTPATH."effect/source/".$sourcefolder;
		$handle = opendir( $sourcefold );
		$i = 0;
		while ( $image_file = readdir( $handle ) )
		{
				$nowfile = $sourcefold."/".$image_file;
				if ( $image_file != "." && $image_file != ".." && $image_file != "_notes" && !strstr( $image_file, "/" ) )
				{
						$sourcesizearr = getimagesize( $nowfile );
						if ( $sourcesizearr[1] <= $sourcesizearr[0] )
						{
								if ( 80 < $sourcesizearr[0] )
								{
										$sourcewidth = 80;
								}
								else
								{
										$sourcewidth = $sourcesizearr[0];
								}
								$str .= "<div class='sourcediv' title='".$image_file."'><div class='sourcepic'><img src='".$nowfile."' border='0' width='".$sourcewidth."'></div><div class='sourcememo'>".$sourcesizearr[0]."x".$sourcesizearr[1]."</div></div>";
						}
						else
						{
								if ( 80 < $sourcesizearr[1] )
								{
										$sourceheight = 80;
								}
								else
								{
										$sourceheight = $sourcesizearr[0];
								}
								$str .= "<div class='sourcediv' title='".$image_file."'><div class='sourcepic'><img src='".$nowfile."' border='0' height='".$sourceheight."'></div><div class='sourcememo'>".$sourcesizearr[0]."x".$sourcesizearr[1]."</div></div>";
						}
				}
				$i++;
		}
		closedir( $handle );
		echo $str;
		exit( );
		break;
case "tempdel" :
		needauth( 6 );
		$tempid = $_POST['tempid'];
		$msql->query( "delete from {P}_base_plustemp where id='{$tempid}'" );
		echo "OK";
		exit( );
		break;
case "tempmydel" :
				needauth( 6 );
				$tempid = $_POST['tempid'];
				$coltype = $_POST['coltype'];
				$msql->query( "SELECT tempname from {P}_base_plustemp where id='{$tempid}'" );
				if($msql->next_record()){
					$oritempname = $msql->f('tempname');
				}
				$msql->query( "SELECT tempname from {P}_base_plus where tempname='{$oritempname}'" );
				if($msql->next_record()){
						echo "1001";
						exit( );
				}
				$msql->query( "delete from {P}_base_plustemp where id='{$tempid}'" );
				delfold(ROOTPATH.$coltype."/templates/add/".$pathname."/".$file_path."/".$tempid);
				echo "OK";
				exit( );
				break;
case "tempadd" :
		needauth( 6 );
		$pluslable = $_POST['pluslable'];
		$cname = $_POST['cname'];
		$tempname = $_POST['tempname'];
		$msql->query( "insert into {P}_base_plustemp set 
			pluslable='{$pluslable}',
			cname='{$cname}',
			tempname='{$tempname}'
		" );
		$tempid = $msql->instid( );
		$str = "<tr id='tr_".$tempid."'> <td height='22'>".$pluslable."</td><td>".$cname."</td><td>".$tempname."</td><td width='60'><img id='del_".$tempid."' src='images/delete.png' width='24' height='24' class='tempdel' /></td></tr>";
		echo $str;
		exit( );
		break;
/*匯入模板 plustempinput*/
case "plustempinput" :
		needauth( 6 );
		$pluslable = $_POST['addtemppluslable'];
		$cname = $_POST['inputtempname'];
		$file = $_FILES['datafile'];
		$arr = explode( ".", $file['name'] );
		$modf = ROOTPATH."base/admin/upmod/".$arr[0];
		$coltype = $_POST['coltype'];

		/*是否為壓縮檔*/
		$az =array("application/zip", "application/x-zip", "application/x-zip-compressed", "application/octet-stream");
		if ( $arr[1] != "zip" || in_array($file['type'],$az) === FALSE )
		{
				echo "ZIP";
				exit( );
		}
		/*解壓縮*/
		copy($file['tmp_name'],ROOTPATH."base/admin/".$file['name']);
		include(ROOTPATH."includes/pclzip.lib.php");
		$archive = new PclZip(ROOTPATH."base/admin/".$file['name']);
		$archive->extract(PCLZIP_OPT_PATH, $modf);
		@unlink(ROOTPATH."base/admin/".$file['name']);
		/*偵測.htm*/
		$gethtm = glob($modf."/*.htm");
		if ( !$gethtm )
		{
				echo "1001";
				delfold($modf);
				exit( );
		}
		if ( $gethtm[1] )
		{
				echo "1002";
				delfold($modf);
				exit( );
		}
		/*抓取下個ID，修改.htm為tmp_p_ID開頭*/
				$msql->query( "SHOW TABLE STATUS LIKE '{P}_base_plustemp' ");
				$msql->next_record();
				$tempid = $msql->f('Auto_increment');
				$tempname = "tpl_p_".$tempid.".htm";
				rename($gethtm[0],$modf."/".$tempname);
		/*複製檔案至自建資料夾*/
				@mkdir(ROOTPATH.$coltype."/templates/add");
				@mkdir(ROOTPATH.$coltype."/templates/add/".$tempid);
				cpfolder($modf, ROOTPATH.$coltype."/templates/add/".$tempid);
				delfold($modf);

		$msql->query( "insert into {P}_base_plustemp set 
			pluslable='{$pluslable}',
			cname='{$cname}',
			tempname='{$tempname}'
		" );
		$str = "<tr id='tr_".$tempid."'> <td height='22'>".$pluslable."</td><td>".$cname." (自定元件模板)</td><td>".$tempname."</td><td width='60'>---</td><td width='60'>---</td><td width='60'><img id='del_".$tempid."' src='images/delete.png' name=\"".$coltype."\" width='24' height='24' class='tempmydel' /></td></tr>";
		echo $str;
		exit( );
		break;
case "getmytempid" :
				$msql->query( "SHOW TABLE STATUS LIKE '{P}_base_plustemp' ");
				$msql->next_record();
				$str = $msql->f('Auto_increment');
				echo $str;
				exit( );
				break;
case "mytempadd" :
				needauth( 6 );
				$pluslable = $_POST['pluslable'];
				$cname = $_POST['cname'];
				$tempname = $_POST['tempname'];
				$cname = $_POST['cname'];
				$coltype = $_POST['coltype'];
				$oritempid = $_POST['tempid'];
				
				$msql->query( "insert into {P}_base_plustemp set 
			pluslable='{$pluslable}',
			cname='{$cname}',
			tempname='{$tempname}'
		" );
				$tempid = $msql->instid( );
				$str = "<tr id='tr_".$tempid."'> <td height='22'>".$pluslable."</td><td>".$cname." (自定元件模板)</td><td>".$tempname."</td><td width='60'>---</td><td width='60'>---</td><td width='60'><img id='del_".$tempid."' src='images/delete.png' name=\"".$coltype."\" width='24' height='24' class='tempmydel' /></td></tr>";
				if($oritempid == "origin"){
				$msql->query( "select tempname from {P}_base_plusdefault where pluslable='{$pluslable}' limit 0,1" );
					if ( $msql->next_record( ) )
					{
							$oritempname = $msql->f( "tempname" );
					}
				}else{
				$msql->query( "select tempname from {P}_base_plustemp where id='{$oritempid}' limit 0,1" );
					if ( $msql->next_record( ) )
					{
							$oritempname = $msql->f( "tempname" );
					}				
				}
				if(!file_exists(ROOTPATH.$coltype."/templates/".$oritempname)){
				@mkdir(ROOTPATH.$coltype."/templates/add/".$tempid);
				cpfolder(ROOTPATH.$coltype."/templates/add/".$oritempid, ROOTPATH.$coltype."/templates/add/".$tempid);
				rename(ROOTPATH.$coltype."/templates/add/".$tempid."/".$oritempname,ROOTPATH.$coltype."/templates/add/".$tempid."/".$tempname);
				}else{
				@mkdir(ROOTPATH.$coltype."/templates/add");
				@mkdir(ROOTPATH.$coltype."/templates/add/".$tempid);
				@mkdir(ROOTPATH.$coltype."/templates/add/".$tempid."/images");
				@mkdir(ROOTPATH.$coltype."/templates/add/".$tempid."/css");
				copy(ROOTPATH.$coltype."/templates/".$oritempname, ROOTPATH.$coltype."/templates/add/".$tempid."/".$tempname);
				}
				echo $str;
				exit( );
				break;
case "plusinput" :
		//tryfunc( );
		needauth( 6 );
		$file = $_FILES['datafile'];
		$arr = explode( ".", $file['name'] );
		$modf = ROOTPATH."base/admin/upmod/".$arr[0];
		/*是否為壓縮檔*/
		$az =array("application/zip", "application/x-zip", "application/x-zip-compressed", "application/octet-stream");
		if ( $arr[1] != "zip" || in_array($file['type'],$az) === FALSE )
		{
				echo "ZIP";
				exit( );
		}
		/*解壓縮*/
		copy($file['tmp_name'],ROOTPATH."base/admin/".$file['name']);
		include(ROOTPATH."includes/pclzip.lib.php");
		$archive = new PclZip(ROOTPATH."base/admin/".$file['name']);
		$archive->extract(PCLZIP_OPT_PATH, $modf);
		@unlink(ROOTPATH."base/admin/".$file['name']);
		
		/**/
		
		if ( !file_exists( $modf."/".$arr[0].".dat" ) )
		{
				echo "1001";
				delfold($modf);
				exit( );
		}
		$f = $modf."/".$arr[0].".dat";
		$fd = fopen( $f, "r" );
		$str = fread( $fd, 1000000 );
		fclose( $fd );
		$str = str_replace( "\n", "", $str );
		$arr = explode( ",", $str );
		for ( $i = 0;	$i < sizeof( $arr );	$i++	)
		{
				if ( $arr[$i] != "" )
				{
						$arrs = explode( "=", trim( $arr[$i] ) );
						$data[$arrs[0]] = $arrs[1];
				}
		}
		$nums = sizeof( $data );
		if ( $nums < 68 || 100 < $nums )
		{
				echo "1002";
				delfold($modf);
				exit( );
		}
		if ( $data['pluslable'] == "" || $data['coltype'] == "" || $data['plusname'] == "" )
		{
				echo "1002";
				delfold($modf);
				exit( );
		}
		$msql->query( "select id from {P}_base_plusdefault where pluslable='".$data['pluslable']."'" );
		if ( $msql->next_record( ) )
		{
				echo "1003";
				delfold($modf);
				exit( );
		}
		$scl = "";
		while ( list( $key, $val ) = each($data) )
		{
				$scl .= "`".$key."`='".$val."',";
		}
		$scl = substr( $scl, 0, 0 - 1 );
		$msql->query( "insert into {P}_base_plusdefault set {$scl}" );
		unlink($f);
		/*複製新元件檔案至模組*/
		$single = glob($modf."./*");			
		cpfolder( $modf."/".$single[0], ROOTPATH );
		/*刪除上傳的mod*/
		delfold($modf);
		echo "OK";
		exit( );
		break;
case "borderadd" :
		//tryfunc( );
		needauth( 6 );
		$tempid = $_POST['tempid'];
		$bordertype = $_POST['bordertype'];
		$tempname = $_POST['tempname'];
		$msql->query( "select id from {P}_base_border where tempid='{$tempid}'" );
		if ( $msql->next_record( ) )
		{
				echo "1001";
				exit( );
		}
		$msql->query( "insert into {P}_base_border set 
			tempid='{$tempid}',
			bordertype='{$bordertype}',
			tempname='{$tempname}'
		" );
		echo "OK";
		exit( );
		break;
case "bordercopy" :
				needauth( 6 );				
				$bordertype = $_POST['bordertype'];
				$tempname = $_POST['tempname'];
				$tempid = "p_".$_POST['tempid'];
				$copyid = $_POST['copyid'];
				if(!$tempname || !$bordertype || !$_POST['tempid'] || !$copyid){
				echo "您傳輸的資料不完整";
				exit();
				}
				$msql->query( "select id from {P}_base_border where tempid='{$tempid}'" );
				if ( $msql->next_record( ) )
				{
								echo "1001";
								exit( );
				}
				$msql->query( "insert into {P}_base_border set 
					tempid='{$tempid}',
					bordertype='{$bordertype}',
					tempname='{$tempname}'
				" );
				@mkdir(ROOTPATH."base/border/add",0777);
				@mkdir(ROOTPATH."base/border/add/".$_POST['tempid'],0777);
				if(substr($copyid,0,2) == "p_"){$copyid = "add/".substr($copyid,2);}
				cpfolder(ROOTPATH."base/border/".$copyid,ROOTPATH."base/border/add/".$_POST['tempid']);
				echo "OK";
				exit( );
				break;
case "bordercopydel" :
				needauth( 6 );
				$tempid = $_POST['tempid'];
				if(substr( $tempid,0,2) == "p_"){
				$msql->query( "select id from {P}_base_plus where showborder REGEXP '[A-Z]{$tempid}'" );
				if ( $msql->next_record( ) )
				{
								echo "1001";
								exit( );
				}
				$msql->query( "delete from {P}_base_border where tempid='{$tempid}'" );
					$tempid = substr( $tempid,2);
				delfold(ROOTPATH."base/border/add/".$tempid);
				echo "OK";
				exit( );
				}else{
				echo "ERROR";
				exit( );
				}
				break;
case "borderdel" :
		needauth( 6 );
		$tempid = $_POST['tempid'];
		$msql->query( "delete from {P}_base_border where tempid='{$tempid}'" );
		echo "OK";
		exit( );
		break;
case "chkPwCode" :
		include( ROOTPATH."base/nusoap/nusoap.php" );
		$server = "http://www.wayhunt.com/webservice/soapserver.php";
		$customer = new soapclientx( $server );
		$r_params = array(
				"siteurl" => $SiteUrl,
				"domain" => $_SERVER['HTTP_HOST'],
				"user" => $GLOBALS['CONF']['phpwebUser'],
				"version" => PHPWEB_VERSION
		);
		$lic = $customer->call( "chkPwCode", $r_params );
		if ( $err = $customer->geterror( ) )
		{
				exit( );
		}
		if ( $lic[0] == "1" )
		{
				$msql->query( "update {P}_base_config set value='{$lic['1']}' where variable='safecode'" );
		}
		//寫入網站到期時間		
		filesave(ROOTPATH."times.php","<?php \$times='".$lic[2]."'; ?>");
		break;
case "uninstall" :
		needauth( 9 );
		$coltype = $_POST['coltype'];
		if ( strlen( $coltype ) < 1 )
		{
				echo "0000";
				exit( );
		}
		$msql->query( "select moveable from {P}_base_coltype where coltype='{$coltype}'" );
		if ( $msql->next_record( ) )
		{
				$moveable = $msql->f( "moveable" );
		}
		else
		{
				echo "1000";
				exit( );
		}
		if ( $moveable != "1" )
		{
				echo "1001";
				exit( );
		}
		$sql_file = ROOTPATH.$coltype."/install/uninstall.sql";
		if ( file_exists( $sql_file ) )
		{
				$fd = fopen( $sql_file, "r" );
				$sql = fread( $fd, filesize( $sql_file ) );
				fclose( $fd );
		}
		else
		{
				echo "1002";
				exit( );
		}
		if ( strstr( $sql, "dev_" ) || !strstr( $sql, "{P}_" ) || !strstr( $sql, ";" ) )
		{
				echo "1003";
				exit( );
		}
		$sql = remove_remarks( trim( $sql ) );
		$pieces = split_sql_file( $sql, ";" );
		$pieces_count = count( $pieces );
		
		for ( $i = 0;	$i < $pieces_count;	$i++	)
		{
				$a_sql_query = trim( $pieces[$i] );
				if ( 10 < strlen( $a_sql_query ) && substr( $a_sql_query, 0, 1 ) != "#" )
				{
						$msql->query( $a_sql_query );
				}
		}
		$bak = time( );
		if ( $coltype != "member" && $coltype != "comment" )
		{
				@rename( ROOTPATH.$coltype, ROOTPATH.$coltype."_backup_".$bak );
		}
		echo "OK";
		exit( );
		break;
case "colinstall" :
		needauth( 9 );
		$coltype = $_POST['coltype'];
		
		if ( strlen( $coltype ) < 1 )
		{
				echo "1000";
				exit( );
		}
		
		$msql->query( "select id from {P}_base_coltype where coltype='{$coltype}'" );
		if ( $msql->next_record( ) )
		{
				echo "1001";
				exit( );
		}
		$modversionfile = ROOTPATH.$coltype."/version.txt";
		if ( file_exists( $modversionfile ) )
		{
				$fn = fopen( $modversionfile, "r" );
				$modversion = fread( $fn, filesize( $modversionfile ) );
				fclose( $fn );
				if ( PHPWEB_RELEASE < $modversion )
				{
						echo "1009";
						exit( );
				}
		}
		$sql_file = ROOTPATH.$coltype."/install/install.sql";
		if ( file_exists( $sql_file ) )
		{
				$fd = fopen( $sql_file, "r" );
				$sql = fread( $fd, filesize( $sql_file ) );
				fclose( $fd );
		}
		else
		{
				echo "1002";
				exit( );
		}
		if ( strstr( $sql, "dev_" ) || !strstr( $sql, "{P}_" ) || !strstr( $sql, ";" ) )
		{
				echo "1003";
				exit( );
		}
		$sql = remove_remarks( trim( $sql ) );
		$pieces = split_sql_file( $sql, ";" );
		$pieces_count = count( $pieces );
		for ( $i = 0;	$i < $pieces_count;	$i++	)
		{
				$a_sql_query = trim( $pieces[$i] );
				if ( 10 < strlen( $a_sql_query ) && substr( $a_sql_query, 0, 1 ) != "#" )
				{
						$msql->query( $a_sql_query );
				}
		}
		echo "OK";
		exit( );
		break;
case "coluninstallcheck" :
				echo "OK";
				exit( );
		break;
case "pchkModule" :
		include( ROOTPATH."base/nusoap/nusoap.php" );
		$server = "http://www.wayhunt.com/webservice/soapserver.php";
		
		$customer = new soapclientx( $server );
		$r_params = array(
				"siteurl" => $SiteUrl,
				"domain" => $_SERVER['HTTP_HOST']
		);
		$lic = $customer->call( "pchkModule", $r_params );
		if ( $err = $customer->geterror( ) )
		{
				exit( );
		}
		if ( $lic == "1" )
		{
				@unlink( "../catch/temp" );
		}
		else
		{
				$fp = @fopen( "../catch/temp", "r" );
				$xnums = @fread( $fp, 10 );
				@fclose( $fp );
				$str = $xnums + 1;
				@mkdir( "../catch", 511 );
				$fd = @fopen( "../catch/temp", "w" );
				@fwrite( $fd, $str );
				@fclose( $fd );
				@chmod( "../catch/temp", 438 );
		}
		break;
}
?>