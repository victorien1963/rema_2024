<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
needauth( 0 );
$act = $_POST['act'];
$act = $act? $act:$_GET['specact'];

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
}
?>