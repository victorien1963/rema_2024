<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
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
		$i=1;
		$msql->query("select * from {P}_page_group order by id");
		while($msql->next_record()){
			$groupid=$msql->f('id');
			$groupname=$msql->f('groupname');
			$substr .= "<li><a id='gm".$i."' class='menulist' href='".ROOTPATH.$pathcoltype."/admin/index.php?groupid=".$groupid."' target='mainframe'><i class='fa fa-angle-double-right'></i> ".$groupname."</a></li>";
			$i++;
		}
		if($substr){
			$str .= "<li><h4>分組列表</h4></li>";
		}
		echo $str.$substr;
		exit( );
		break;
case "addgroup" :
		$groupname = htmlspecialchars( $_POST['groupname'] );
		$folder = htmlspecialchars( $_POST['folder'] );
		if ( $groupname == "" )
		{
				echo $strGroupAddNTC1;
				exit( );
		}
		if ( strlen( $folder ) < 2 || 16 < strlen( $folder ) )
		{
				echo $strGroupAddNTC2;
				exit( );
		}
		if ( !eregi( "^[0-9a-z]{1,16}\$", $folder ) )
		{
				echo $strGroupAddNTC3;
				exit( );
		}
		if ( strstr( $folder, "/" ) || strstr( $folder, "." ) )
		{
				echo $strGroupAddNTC3;
				exit( );
		}
		trylimit( "_page_group", 5, "id" );
		$arr = array( "main", "html", "htm", "detail", "index", "admin", "images", "includes", "language", "module", "pics", "templates", "js", "css" );
		if ( in_array( $folder, $arr ) == true )
		{
				echo $strGroupAddNTC4;
				exit( );
		}
		if ( file_exists( "../".$folder ) )
		{
				echo $strGroupAddNTC4;
				exit( );
		}
		$msql->query( "select id from {P}_page_group where folder='{$folder}'" );
		if ( $msql->next_record( ) )
		{
				echo $strGroupAddNTC4;
				exit( );
		}
		@mkdir( "../".$folder, 511 );
		$fd = fopen( "../temp.php", "r" );
		$str = fread( $fd, "2000" );
		$str_html = str_replace( "TEMP", $folder, $str );
		$str_main = str_replace( "TEMP", $folder."_main", $str );
		fclose( $fd );
		$filename = "../".$folder."/index.php";
		$fp = fopen( $filename, "w" );
		fwrite( $fp, $str_html );
		fclose( $fp );
		@chmod( $filename, 493 );
		$filename_main = "../".$folder."/main.php";
		$fp = fopen( $filename_main, "w" );
		fwrite( $fp, $str_main );
		fclose( $fp );
		@chmod( $filename_main, 493 );
		$msql->query( "insert into {P}_page_group set 
			`groupname`='{$groupname}',
			`xuhao`='1',
			`moveable`='1',
			`folder`='{$folder}'
		" );
		$msql->query( "insert into {P}_base_pageset set 
			`name`='{$groupname}',
			`coltype`='page',
			`pagename`='{$folder}',
			`buildhtml`='id'
		" );
		$mainpagename = $folder."_main";
		$msql->query( "insert into {P}_base_pageset set 
			`name`='{$groupname}',
			`coltype`='page',
			`pagename`='{$mainpagename}',
			`buildhtml`='0'
		" );
		echo "OK";
		exit( );
		break;
}
?>
