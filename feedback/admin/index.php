<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include_once(ROOTPATH."includes/pages.inc.php");
include("language/".$sLan.".php");
NeedAuth(212);

$step=$_REQUEST["step"];
$page=$_REQUEST["page"];
$key=$_REQUEST["key"];
$groupid=$_REQUEST["groupid"];

$searchtime = $_REQUEST["searchtime"];
$selstat = $_REQUEST["selstat"];


if($step=="delall"){
	$dall=$_POST["dall"];
	$nums=sizeof($dall);
	for($i=0;$i<$nums;$i++){
		$ids=$dall[$i];
		$msql->query("delete from {P}_feedback_info where id='$ids'");

	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="../../base/js/form.js"></script>
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script src="js/frame.js"></script>
<script>

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
	<script>
		$(document).ready(function(){
			//載入時隱藏選單
			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');
			//頁面麵包屑
			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>申請表單</li>');
			$('#pagetitle', window.parent.document).html('申請表單 <span class="sub-title" id="subtitle">申請表單管理</span>');
			//呼叫左側功能選單
			$().getMenuGroup('feedback');
		});
	</script>
</head>

<body>

<div class="searchzone">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="30">
  <tr> 
   
                  
      <td  height="30">  <form method="get" action="index.php" >
	
        <select name="groupid">
         <option value='0' selected><?php echo $strFormGroupSel1; ?></option>
          <?php
				
			$msql->query("select * from {P}_feedback_group order by xuhao");
			while($msql->next_record()){
				$lgroupid=$msql->f('id');
				$groupname=$msql->f('groupname');
					
				if($groupid==$lgroupid){
					echo "<option value='".$lgroupid."' selected>".$groupname."</option>";
				}else{
					echo "<option value='".$lgroupid."'>".$groupname."</option>";
				}
						
			}
					
				
		 ?>
        </select>
        <select name="selstat">
          <option value="">目前狀態</option>
          <option value="0" <?php echo seld($selstat,"no"); ?>>未處理</option>
          <option value="1" <?php echo seld($selstat,"ok"); ?>>已處理</option>
        </select>
        <select name="shownum">
          <option value="10"  <?php echo seld($shownum,"10"); ?>><?php echo $strSelNum10; ?></option>
          <option value="20" <?php echo seld($shownum,"20"); ?>><?php echo $strSelNum20; ?></option>
          <option value="30" <?php echo seld($shownum,"30"); ?>><?php echo $strSelNum30; ?></option>
          <option value="50" <?php echo seld($shownum,"50"); ?>><?php echo $strSelNum50; ?></option>
        </select>
        <input name="key" type="text" id="key" class="input" value="<?php echo $key; ?>" />
        <input type="submit" name="Submit" value="<?php echo $strSearchTitle; ?>" class="button" />       
      </form>           
      </td>

             
    
  </tr>
</table>
</div>

<?php

if(!isset($shownum) || $shownum<10){
$shownum=10;
}


$scl=" id!='0' ";

if($groupid!="" && $groupid!="0"){
    $scl .= " and groupid='$groupid' ";
}

if($key!=""){
$scl.=" and (title regexp '$key' or name regexp '$key' or email regexp '$key') ";
}

if($selstat != ""){
	$sts = $selstat=="ok" || $selstat=="1"? "1":"0";
	$scl.=" and stat='$sts' ";
}

if($searchtime){
	
$getdate = explode("-",$searchtime);
$fromY = $getdate[0];
$fromM = $getdate[1];
$fromD = $getdate[2];
$starttime = mktime (0,0,0,$fromM,$fromD,$fromY);
$endtime = mktime (23,59,59,$fromM,$fromD,$fromY);

	$scl.=" and time>='{$starttime}' and time<='{$endtime}' ";
}


	$totalnums=TblCount("_feedback_info","id",$scl);

	$pages = new pages;		
	$pages->setvar(array("groupid" => $groupid,"shownum" => $shownum,"key" => $key));

	$pages->set($shownum,$totalnums);		                          
	
	$pagelimit=$pages->limit();	  
?> 

<form name="delfm" action="feedback.php" method="post">
<div class="listzone">
<table width="100%" border="0" cellpadding="3" cellspacing="0" align="center">
    <tr>
      <td width="30" align="center"  class="biaoti" ><?php echo $strSel; ?></td> 
      <td width="50" height="26" class="biaoti"><?php echo $strNumber; ?></td>
      <td class="biaoti" width="90"><?php echo $strGroupNow; ?></td>
     <td class="biaoti" width="90">目前狀態</td>
      <td class="biaoti" height="26"><?php echo $strFormTitle; ?></td>
      <td class="biaoti" width="150"><?php echo $strFormTime; ?></td>
      <td width="39" height="26" class="biaoti"><?php echo $strLook; ?></td>
      </tr>
    <?php
  $fsql -> query ("select * from {P}_feedback_info where $scl order by id desc limit $pagelimit");

  while ($fsql -> next_record ()) {
	  $id=$fsql->f('id');
	  $groupid=$fsql->f('groupid');
  	  $title=$fsql->f('title');
	  $name=$fsql->f('name');
	  $email=$fsql->f('email');
	  $adminid=$fsql->f('adminid'); 
	  $time=$fsql->f('time'); 
	  $uptime=$fsql->f('uptime'); 
	  $stat=$fsql->f('stat');
	  $memberid=$fsql->f('memberid');
	 
	
	$tsql->query("select groupname from {P}_feedback_group where id='$groupid' ");
	if($tsql->next_record()){
		$groupname=$tsql->f('groupname');
	}
	
	
  ?> 
    <tr class="list">
      <td width="30" align="center"><input type="checkbox" name="dall[]" value="<?php echo $id; ?>" />
      </td> 
      <td  width="50"><?php echo $id;?> </td>
      <td  width="90"><?php echo $groupname; ?></td>
      <td width="90"><?php if($stat == "1"){echo "<span style=\"color:green;\">已處理</span>"; }else{ echo "<span style=\"color:red;\">未處理</span>";};?></td>
      <td ><?php echo $title;?></td>
      <td  width="150" ><?php echo date("y/m/d H:i",$time); ?></td>
      <td  width="39"><a href="look.php?id=<?php echo $id;?>"><img src="images/look.png"  border="0"></a></td>
      </tr>
    <?php

  }
  ?> 
  
</table>
</div>

<div class="piliang"> 
        <input type="checkbox" name="SELALL" value="1" onClick="SelAll(this.form)">
        <?php echo $strSelAll; ?>&nbsp; 
        <input name="step" type="radio" value="delall" checked="checked">
        <?php echo $strDelete ?>        &nbsp;<a style="cursor:pointer;font-weight:bold" onClick="delfm.submit()">
		[<?php echo $strSubmit; ?>]</a> 
        <input type="hidden" name="page" size="3" value="<?php echo $page; ?>" />
        <input type="hidden" name="groupid" value="<?php echo $groupid; ?>" />
        <input type="hidden" name="shownum" value="<?php echo $shownum; ?>" />
       
  </div>
	  </form>
<?php
$pagesinfo=$pages->ShowNow();
?>
<div id="showpages">
	  <div id="pagesinfo"><?php echo $strPagesTotalStart.$totalnums.$strPagesTotalEnd; ?> <?php echo $strPagesMeiye.$pagesinfo["shownum"].$strPagesTotalEnd; ?> <?php echo $strPagesYeci; ?> <?php echo $pagesinfo["now"]."/".$pagesinfo["total"]; ?></div>
	  <div id="pages"><?php echo $pages->output(1); ?></div>
</div>
</body>
</html>
