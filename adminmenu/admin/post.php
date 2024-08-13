<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
NeedAuth(0);

$act=$_POST["act"];

switch($act){
	
	
	//讀取左側選單組
	case "menugrouplist" :
		$gid = $_POST["groupid"];
		$str="<li><h4>功能目錄</h4></li>";
		$i=1;
		$msql->query("select * from {P}_adminmenu_group order by id");
		while($msql->next_record()){
			$groupid=$msql->f('id');
			$groupname=$msql->f('groupname');
			$aclass = $gid == $groupid? "active":"menulist";
			$str.="<li><a id='m".$i."' class='".$aclass."' href='".ROOTPATH."adminmenu/admin/index.php?groupid=".$groupid."' target='mainframe'><i class='fa fa-dashboard'></i> ".$groupname."</a></li>";
			$i++;
		}
		echo $str;
		exit();

	break;



	//添加選單組
	case "addgroup" :
		
		
		$groupname=$_REQUEST["groupname"];
		$coltypename=$_REQUEST["coltypename"];

		if($groupname=="" || $groupname==$strGroupAddName){
			echo $strGroupAddName;
			exit;
		}

		$msql->query("insert into {P}_adminmenu_group set
			`groupname`='$groupname',
			`coltype`='$coltypename',
			`xuhao`='1',
			`moveable`='1'
		");
		echo "OK";
		exit();

	break;


	//刪除選單組
	case "delgroup" :
		
		
		$groupid=$_POST["groupid"];
		

		$msql->query("select moveable from {P}_adminmenu_group where id='$groupid' ");
		if($msql->next_record()){
			$moveable=$msql->f('moveable');
			if($moveable!='1'){
				echo $strGroupNTC1;
				exit;
			}
		}
		
		$fsql->query("delete from {P}_adminmenu where groupid='$groupid' ");
		$msql->query ("delete from {P}_adminmenu_group where id='$groupid' ");
	
		echo "OK";
		exit();

	break;


}
?>