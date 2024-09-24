<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
include("func/upload.inc.php");
NeedAuth(310);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script type="text/javascript" src="js/Date/WdatePicker.js"></script>
<script>
	function chgselect(gid){
		if(gid == 1){
			document.getElementById('pricerate').style.display='inline-block';
			document.getElementById('num').style.display='none';
			document.getElementById('multiprice').style.display='none';
		}else{
			document.getElementById('pricerate').style.display='none';
			document.getElementById('num').style.display='inline-block';
			document.getElementById('multiprice').style.display='inline-block';
		}
	}
</script>
</head>

<body>
<?php
$step=$_REQUEST["step"];
$id=$_REQUEST["id"];


if ($step == "add") { 

$groupid = $_POST["groupid"];
$name = $_POST["name"];
$num = $_POST["num"];
$multiprice = $_POST["multiprice"];
$pricerate = $_POST["pricerate"];
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];
$starttime = $_POST["starttime"];
$endtime = $_POST["endtime"];
$tag1 =  $_FILES["tag1"];
$tag2 =  $_FILES["tag2"];
$tag3 =  $_FILES["tag3"];
$aboutspec = $_POST["aboutspec"];

if($groupid == 1){
	$num = $multiprice = 0;
}else{
	$pricerate = 0;
}

if($name==""){
	err($strPromoteNotice1,"","");
}
if($groupid == 2 && $num==""){
	err($strPromoteNotice2,"","");
}
if($groupid == 2 && $multiprice==""){
	err($strPromoteNotice3,"","");
}
if($groupid == 1 && $pricerate==""){
	err($strPromoteNotice4,"","");
}
if($startdate==""){
	err($strPromoteNotice5,"","");
}
if($starttime==""){
	err($strPromoteNotice6,"","");
}
if($enddate==""){
	err($strPromoteNotice7,"","");
}
if($endtime==""){
	err($strPromoteNotice8,"","");
}

foreach((array)$aboutspec AS $speccat){
$aboutspecs .= $aboutspecs? ",".$speccat:$speccat;
}
	$msql -> query ("insert into {P}_shop_promote set
		`groupid` = '$groupid',
		`name` = '$name',
		`num` = '$num',
		`multiprice` = '$multiprice',
		`pricerate` = '$pricerate',
		`startdate` = '$startdate',
		`enddate` = '$enddate',
		`starttime` = '$starttime',
		`endtime` = '$endtime',
		`tag1` = '$src1',
		`tag2` = '$src2',
		`tag3` = '$src3',
		`aboutspec` = '$aboutspecs' 
	");

	Sayok($strAddOk,"shoppromote.php","");


	
}


if ($step == "modify") { 
$groupid = $_POST["groupid"];
$name = $_POST["name"];
$num = $_POST["num"];
$multiprice = $_POST["multiprice"];
$pricerate = $_POST["pricerate"];
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];
$starttime = $_POST["starttime"];
$endtime = $_POST["endtime"];
$tag1 =  $_FILES["tag1"];
$tag2 =  $_FILES["tag2"];
$tag3 =  $_FILES["tag3"];
$aboutspec = $_POST["aboutspec"];

if($groupid == 1){
	$num = $multiprice = 0;
}else{
	$pricerate = 0;
}

if($name==""){
	err($strPromoteNotice1,"","");
}
if($groupid == 2 && $num==""){
	err($strPromoteNotice2,"","");
}
if($groupid == 2 && $multiprice==""){
	err($strPromoteNotice3,"","");
}
if($groupid == 1 && $pricerate==""){
	err($strPromoteNotice4,"","");
}
if($startdate==""){
	err($strPromoteNotice5,"","");
}
if($starttime==""){
	err($strPromoteNotice6,"","");
}
if($enddate==""){
	err($strPromoteNotice7,"","");
}
if($endtime==""){
	err($strPromoteNotice8,"","");
}


foreach((array)$aboutspec AS $speccat){
$aboutspecs .= $aboutspecs? ",".$speccat:$speccat;
}

	$msql -> query ("update {P}_shop_promote set
		`groupid` = '$groupid',
		`name` = '$name',
		`num` = '$num',
		`multiprice` = '$multiprice',
		`pricerate` = '$pricerate',
		`startdate` = '$startdate',
		`enddate` = '$enddate',
		`starttime` = '$starttime',
		`endtime` = '$endtime',
		`aboutspec` = '$aboutspecs' 
		where id = '$id'
	");

	Sayok($strAddOk,"shoppromote.php","");
	
}

//NEW ADVS
if($id=="0" || $id==""){
$nowstep="add";
$name = "";
$num = "";
$multiprice = "";
$pricerate = "";
$startdate = "";
$enddate = "";
$starttime = "";
$endtime = "";
$chgMethod = "<script>chgselect(1);</script>";
$disnone = "style='display:none;'";

	}else{

		$nowstep="modify";

		$msql -> query ("select * from {P}_shop_promocode where id='$id'");
		if ($msql -> next_record ()) {
			$id = $msql -> f ('id');
			$type = $msql -> f ('type');
			$type_value = $msql -> f ('type_value');
			$code = $msql -> f ('code');
			$times = $msql -> f ('times');
			$shopcat = $msql -> f ('shopcat');
			$shopid = $msql -> f ('shopid');
			$memberid = $msql -> f ('memberid');
			$starttime = $msql -> f ('starttime');
			$endtime = $msql -> f ('endtime');
		}	
	}


?> 
<form name="promocode.php" action="" method="post" enctype="multipart/form-data">
<div class="formzone">
<div class="namezone"><?php echo $strSetMenu21; ?></div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr> 
    <td align="right"  width="90" height="26"><?php echo $strPromoteCate; ?></td>
    	<td > 
    		<select name="groupid">
				<option value="1">折價金</option>
				<option value="2">折扣%</option>
    		</select>
    	</td>
    </tr>
  <tr>
    <td width="90" height="26" align="right"><?php echo $strPromoCode; ?></td>
    <td >
      <input name="name" type="text"  value="<?php echo $name; ?>" size="50" class="input" />
    <font color="#FF3300"> * </font> </td>
  </tr>
 
    <tr id="num"> 
      <td align="right"  width="90" height="26"><?php echo $strProNum; ?></td>
      <td > 
        <input name="num" type="text"  value="<?php echo $num; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    <tr id="multiprice"> 
      <td align="right"  width="90" height="26"><?php echo $strProPrice; ?></td>
      <td > 
        <input name="multiprice" type="text"  value="<?php echo $multiprice; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    <tr id="pricerate"> 
      <td align="right"  width="90" height="26"><?php echo $strProRate; ?></td>
      <td > 
        <input name="pricerate" type="text"  value="<?php echo $pricerate; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    	
    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strProStarDate; ?></td>
      <td > 
        <input name="startdate" type="text" onClick="WdatePicker()" value="<?php echo $startdate; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strProStarTime; ?></td>
      <td > 
        <input name="starttime" type="text" onClick="WdatePicker({dateFmt:'HH:mm:ss'})" value="<?php echo $starttime; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strProEndDate; ?></td>
      <td > 
        <input name="enddate" type="text" onClick="WdatePicker()" value="<?php echo $enddate; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strProEndTime; ?></td>
      <td > 
        <input name="endtime" type="text" onClick="WdatePicker({dateFmt:'HH:mm:ss'})" value="<?php echo $endtime; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>

    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strPromoteTag1; ?></td>
      <td > 
        <input name="tag1" type="file" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    <tr <?php echo $disnone; ?>> 
      <td align="right"  width="90" height="26"></td>
      <td > 
        <img src="<?php echo $protag1;?>" />
      </td>
    </tr>
    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strPromoteTag2; ?></td>
      <td > 
        <input name="tag2" type="file" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    <tr <?php echo $disnone; ?>>  
      <td align="right"  width="90" height="26"></td>
      <td > 
        <img src="<?php echo $protag2;?>" />
      </td>
    </tr>
    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strPromoteTag3; ?></td>
      <td > 
        <input name="tag3" type="file" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    <tr <?php echo $disnone; ?>> 
      <td align="right"  width="90" height="26"></td>
      <td > 
        <img src="<?php echo $protag3;?>" />
      </td>
    </tr>
</table>
</div>
<div class="adminsubmit">
        <input type="submit" name="Submit" value="<?php echo $strSubmit; ?>" class="button" />
        <input type="button" name="Submit2" value="<?php echo $strBack; ?>" class="button" onClick="self.location='shoppromote.php'" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input name="step" type="hidden" id="submit" value="<?php echo $nowstep; ?>" />

</div>

</div>
</form>
	<?php echo $chgMethod; ?>	
</body>
</html>