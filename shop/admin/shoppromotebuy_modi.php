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
</head>

<body>
<?php
$step=$_REQUEST["step"];
$id=$_REQUEST["id"];


if ($step == "add") { 

$name = $_POST["name"];
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];
$starttime = $_POST["starttime"];
$endtime = $_POST["endtime"];
$promo_productid =  $_POST["promo_productid"];
$promo_productaddid =  $_POST["promo_productaddid"];
$promo_money =  $_POST["promo_money"];

list($SY,$SM,$SD) = explode("-",$startdate);
list($SH,$SI,$SS) = explode(":",$starttime);
$sdt = mktime ($SH,$SI,$SS,$SM,$SD,$SY);
list($EY,$EM,$ED) = explode("-",$enddate);
list($EH,$EI,$ES) = explode(":",$endtime);
$ndt = mktime ($EH,$EI,$ES,$EM,$ED,$EY);


if($name==""){
	err($strPromoteNotice1,"","");
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


	$msql -> query ("insert into {P}_shop_promotebuy set
		`name` = '$name',
		`startdate` = '$startdate',
		`enddate` = '$enddate',
		`starttime` = '$starttime',
		`endtime` = '$endtime',
		`promo_productid` = '$promo_productid',
		`promo_productaddid` = '$promo_productaddid',
		`promo_money` = '$promo_money',
		`sdt` = '$sdt',
		`ndt` = '$ndt' 
	");
		
		/*寫入加購列表*/
		$inid = $msql->instid();
		/*先處理$promo_productid*/
		$plist = explode(",",$promo_productid);
		foreach($plist AS $value){
			$msql -> query ("insert into {P}_shop_promotebuylist set
				`bid` = '$inid',
				`gid` = '$value',
				`mid` = '$promo_productaddid',
				`promo_price` = '0',
				`sdt` = '$sdt',
				`ndt` = '$ndt',
				`isadd` = '0'
			");
		}
		/*再處理$promo_productaddid*/
		$qlist = explode(",",$promo_productaddid);
		foreach($qlist AS $values){
			$msql -> query ("insert into {P}_shop_promotebuylist set
				`bid` = '$inid',
				`gid` = '$values',
				`mid` = '$promo_productid',
				`promo_price` = '$promo_money',
				`sdt` = '$sdt',
				`ndt` = '$ndt',
				`isadd` = '1'
			");
		}
	Sayok($strAddOk,"shoppromotebuy.php","");


	
}


if ($step == "modify") { 
$name = $_POST["name"];
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];
$starttime = $_POST["starttime"];
$endtime = $_POST["endtime"];
$promo_productid =  $_POST["promo_productid"];
$promo_productaddid =  $_POST["promo_productaddid"];
$promo_money =  $_POST["promo_money"];

list($SY,$SM,$SD) = explode("-",$startdate);
list($SH,$SI,$SS) = explode(":",$starttime);
$SH = $SH - 0;
$SI = $SI - 0;
$SS = $SS - 0;
$sdt = mktime ($SH,$SI,$SS,$SM,$SD,$SY);
list($EY,$EM,$ED) = explode("-",$enddate);
list($EH,$EI,$ES) = explode(":",$endtime);
$EH = $EH - 0;
$EI = $EI - 0;
$ES = $ES - 0;
$ndt = mktime ($EH,$EI,$ES,$EM,$ED,$EY);

if($name==""){
	err($strPromoteNotice1,"","");
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


	$msql -> query ("update {P}_shop_promotebuy set
		`name` = '$name',
		`startdate` = '$startdate',
		`enddate` = '$enddate',
		`starttime` = '$starttime',
		`endtime` = '$endtime',
		`promo_productid` = '$promo_productid',
		`promo_productaddid` = '$promo_productaddid',
		`promo_money` = '$promo_money',
		`sdt` = '$sdt',
		`ndt` = '$ndt' 
		where id = '$id'
	");
		
	/*寫入加購列表*/
		$inid = $id;
		/*清空LIST*/
		$msql -> query ("DELETE FROM {P}_shop_promotebuylist WHERE bid='$inid'");
		/*先處理$promo_productid*/
		$plist = explode(",",$promo_productid);
		foreach($plist AS $value){
			$msql -> query ("insert into {P}_shop_promotebuylist set
				`bid` = '$inid',
				`gid` = '$value',
				`mid` = '$promo_productaddid',
				`promo_price` = '0',
				`sdt` = '$sdt',
				`ndt` = '$ndt',
				`isadd` = '0'
			");
		}
		/*再處理$promo_productaddid*/
		$qlist = explode(",",$promo_productaddid);
		foreach($qlist AS $values){
			$msql -> query ("insert into {P}_shop_promotebuylist set
				`bid` = '$inid',
				`gid` = '$values',
				`mid` = '$promo_productid',
				`promo_price` = '$promo_money',
				`sdt` = '$sdt',
				`ndt` = '$ndt',
				`isadd` = '1'
			");
		}

	Sayok($strAddOk,"shoppromotebuy.php","");
	
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
$starttime = "00:00:00";
$endtime = "23:59:59";
$chgMethod = "<script>chgselect(1);</script>";
$disnone = "style='display:none;'";

	}else{

		$nowstep="modify";

		$msql -> query ("select * from {P}_shop_promotebuy where id='$id'");
		if ($msql -> next_record ()) {
			$id = $msql -> f ('id');
			$name = $msql -> f ('name');
			$startdate = $msql -> f ('startdate');
			$enddate = $msql -> f ('enddate');
			$starttime = $msql -> f ('starttime');
			$endtime = $msql -> f ('endtime');
			$promo_productid = $msql -> f ('promo_productid');
			$promo_productaddid = $msql -> f ('promo_productaddid');
			$promo_money = $msql -> f ('promo_money');
		}
	}


?> 
<form name="shoppromotebuy.php" action="" method="post" enctype="multipart/form-data">
<div class="formzone">
<div class="namezone"><?php echo $strSetMenu3; ?></div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="90" height="26" align="right"><?php echo $strPromoteName; ?></td>
    <td >
      <input name="name" type="text"  value="<?php echo $name; ?>" size="50" class="input" />
    <font color="#FF3300"> * </font> </td>
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

    <tr id="promo_productid"> 
      <td align="right"  width="90" height="26">主商品ID</td>
      <td > 
        <input name="promo_productid" type="text"  value="<?php echo $promo_productid; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> (請用逗號「,」區隔)
      </td>
    </tr>
    <tr id="promo_productaddid"> 
      <td align="right"  width="90" height="26">加購商品ID</td>
      <td > 
        <input name="promo_productaddid" type="text"  value="<?php echo $promo_productaddid; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> (請用逗號「,」區隔)
      </td>
    </tr>
    <tr id="promo_money"> 
      <td align="right"  width="90" height="26">折扣價格</td>
      <td > 
        <input name="promo_money" type="text"  value="<?php echo $promo_money; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>

</table>
</div>
<div class="adminsubmit">
        <input type="submit" name="Submit" value="<?php echo $strSubmit; ?>" class="button" />
        <input type="button" name="Submit2" value="<?php echo $strBack; ?>" class="button" onClick="self.location='shoppromotebuy.php'" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input name="step" type="hidden" id="submit" value="<?php echo $nowstep; ?>" />

</div>

</div>
</form>
	<?php echo $chgMethod; ?>	
</body>
</html>