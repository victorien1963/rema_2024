<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include(ROOTPATH."includes/pages.inc.php");
include("language/".$sLan.".php");
include("func/adminlog.inc.php");

NeedAuth(10);

$key = $_REQUEST['key'];
$fromY= $_REQUEST['fromY'];
$fromM= $_REQUEST['fromM'];
$fromD= $_REQUEST['fromD'];
$toY= $_REQUEST['toY'];
$toM= $_REQUEST['toM'];
$toD= $_REQUEST['toD'];
$step= $_REQUEST['step'];

if ( $step == "delall" )
{	
		$dall = $_POST['dall'];
		$nums = sizeof( $dall );
		for ( $i = 0;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "delete from {P}_base_adminlog where id='{$ids}'" );
		}
}elseif( $step == "delallform" ){	$msql->query( "TRUNCATE TABLE {P}_base_adminlog " );}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script  language="javascript" src="<?php echo ROOTPATH; ?>base/js/base132.js"></script>
<script type="text/javascript" src="js/fancybox/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	
<SCRIPT>
function SelAll(theForm){
		for ( i = 0 ; i < theForm.elements.length ; i ++ )
		{
			if ( theForm.elements[i].type == "checkbox" && theForm.elements[i].name != "SELALL" )
			{
				theForm.elements[i].checked = ! theForm.elements[i].checked ;
			}
		}
}
</SCRIPT>
<script type="text/javascript">
$(document).ready(function()
{
			$(".showmore").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
});
</script>
</head>

<body>
<div class="formzone">
<div class="namezone">
<?php echo $strSetMenu15; ?>
</div>
<div class="tablezone">
<form method="get" action="adminlog.php">
<table width="100%" border="0" cellspacing="0" cellpadding="6"  height="29">
    <tr> 
      
        <td class=pages colspan="2"> <?php echo DayList("fromY","fromM","fromD",$fromY,$fromM,$fromD); ?> 
          - <?php echo DayList("toY","toM","toD",$toY,$toM,$toD); ?> 
          <input type="hidden" name="tp" value="search">
          <input type="text" name="key" size="30" value="<?php echo $key; ?>" class="input" />
          <input type="submit" name="Submit" value="<?php echo $strQuery; ?>" class="button" />
        </td>
      

    </tr>
  </table>
 </form>
</div>

<?php

	if(!isset($fromM) || !isset($toM)){
		$fromY=date("Y",time());
		$fromM=date("n",time());
		$fromD=date("j",time());
		$toY=date("Y",time());
		$toM=date("n",time());
		$toD=date("j",time());		
	
	}
	$fromtime=mktime(0,0,0,$fromM,$fromD,$fromY);
	$totime=mktime(23,59,59,$toM,$toD,$toY);




		
	$scl=" logtime>=$fromtime and logtime<=$totime ";
	
	if($key!=""){
		$scl.=" and (postlog  regexp '$key' or getlog  regexp '$key') ";
	}

	$totalnums=TblCount("_base_adminlog","id",$scl);

	$pages = new pages;		
	$pages->setvar(array("key" => $key,"fromY" => $fromY,"fromM" => $fromM,"fromD" => $fromD,"toY" => $toY,"toM" => $toM,"toD" => $toD));

	$pages->set(20,$totalnums);		                          
		
	$pagelimit=$pages->limit();	  

?>
<div class="tablezone">
<form name="delfm" method="post" action="adminlog.php">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td  class="innerbiaoti" width="60" height="25"><?php echo $strSel; ?></td>
      <td  class="innerbiaoti" width="100" height="25"><?php echo $strAuthUser; ?></td>
      <td  class="innerbiaoti" width="160" height="25"><?php echo $strFbtime; ?></td>
      <td  class="innerbiaoti" width="100" height="25"><?php echo $strAuthGroup; ?></td>
      <td  class="innerbiaoti" height="25">$_POST <?php echo $strPlusbody; ?></td>
      <td  class="innerbiaoti" height="25">$_GET <?php echo $strPlusbody; ?></td>
      <td  class="innerbiaoti" width="100" height="25">IP</td>
      </tr>
    <?php
	
	$msql -> query ("select * from {P}_base_adminlog  where $scl order by id desc limit $pagelimit");
	while ($msql -> next_record ()) {
		$id= $msql -> f ('id');
		$time = $msql -> f ('time');
		$ip = $msql -> f ('ip');
		$logtime = $msql -> f ('logtime');
		$coltype = $msql -> f ('coltype');
		$postlog = $msql -> f ('postlog');
		$cutpostlog = csubstr($postlog,0,30);
		$getlog = $msql -> f ('getlog');
		$cutgetlog = csubstr($getlog,0,30);
		$sysuser = $msql -> f ('sysuser');
	?> 
    <tr class="list"> 
      <td width="60"><input type="checkbox" name="dall[]" value="<?php echo $id;?>" /></td>
      <td width="100"><?php echo $sysuser;?></td>
      <td width="160"><?php echo $time;?></td>
      <td width="100"><?php echo $coltype;?></td>
      <td ><?php echo $cutpostlog;?> 
        <div style="display:none;">
        	<div id="inline_p_<?php echo $id;?>" style="font:20px/1.5 'Arial', 'Helvetica', 'sans-serif';width:600px;height:500px;overflow:auto;">
        		<?php echo $postlog;?>
        	</div>
        </div>
        <a href="#inline_p_<?php echo $id;?>" class="showmore"><img src="images/str.gif" alt="more..." style="cursor:pointer;" /></a></td>
      <td ><?php echo $cutgetlog;?> 
        <div style="display:none;">
        	<div id="inline_g_<?php echo $id;?>" style="font:20px/1.5 'Arial', 'Helvetica', 'sans-serif';width:600px;height:500px;overflow:auto;">
        		<?php echo $getlog;?>
        	</div>
        </div>
        <a href="#inline_g_<?php echo $id;?>" class="showmore"><img src="images/str.gif" alt="more..." style="cursor:pointer;" /></a></td>
      <td width="100"><?php echo $ip;?></td>
      </tr>
    <?php
	}
	?> 
  </table>
  
 </div>
 </div> 
<div class="piliang"> 
        <input type="checkbox" name="SELALL" value="1" onClick="SelAll(this.form)">
        <?php echo $strSelAll; ?>&nbsp; 
        <input type="radio" name="step" value="delall">
        <?php echo $strDelete; ?>&nbsp; 
        <input type="radio" name="step" value="delallform">
        <?php echo $strDelAll; ?>&nbsp;
        <input class="button" type="button" value="<?php echo $strSubmit; ?>" onClick="delfm.submit()">
        <input type="hidden" name="page" size="3" value="<?php echo $page; ?>" />
        <input type="hidden" name="key" size="3" value="<?php echo $key; ?>" />
        <input type="hidden" name="fromY" size="3" value="<?php echo $fromY; ?>" />
        	<input type="hidden" name="fromM" size="3" value="<?php echo $fromM; ?>" />
        	<input type="hidden" name="fromD" size="3" value="<?php echo $fromD; ?>" />
        	<input type="hidden" name="toY" size="3" value="<?php echo $toY; ?>" />
        	<input type="hidden" name="toM" size="3" value="<?php echo $toM; ?>" />
        	<input type="hidden" name="toD" size="3" value="<?php echo $toD; ?>" />
 </div> 
</form>	
  <?php
$pagesinfo=$pages->ShowNow();
?>
<div id="showpages">
	  <div id="pagesinfo"><?php echo $strPagesTotalStart.$totalnums.$strPagesTotalEnd; ?> <?php echo $strPagesMeiye.$pagesinfo["shownum"].$strPagesTotalEnd; ?> <?php echo $strPagesYeci; ?> <?php echo $pagesinfo["now"]."/".$pagesinfo["total"]; ?></div>
	  <div id="pages"><?php echo $pages->output(1); ?></div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
