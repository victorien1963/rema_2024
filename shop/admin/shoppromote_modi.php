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
$promo_amount =  $_POST["promo_amount"];
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];
$starttime = $_POST["starttime"];
$endtime = $_POST["endtime"];
$promo_codeid =  $_POST["promo_codeid"];
$promo_productid =  $_POST["promo_productid"];
$promo_money =  $_POST["promo_money"];
$range_add = $_POST["range_add"];

$probg1 =  $_FILES["probg1"];
$probg2 =  $_FILES["probg2"];
$probg3 =  $_FILES["probg3"];

list($SY,$SM,$SD) = explode("-",$startdate);
list($SH,$SI,$SS) = explode(":",$starttime);
$sdt = mktime ($SH,$SI,$SS,$SM,$SD,$SY);
list($EY,$EM,$ED) = explode("-",$enddate);
list($EH,$EI,$ES) = explode(":",$endtime);
$ndt = mktime ($EH,$EI,$ES,$EM,$ED,$EY);


if($name==""){
	err($strPromoteNotice1,"","");
}
if($promo_amount==""){
	err($strPromoteNotice9,"","");
}
if($groupid == 1 && $promo_productid==""){
	err($strPromoteNotice2,"","");
}
if($groupid == 2 && $promo_money==""){
	err($strPromoteNotice4,"","");
}
if($groupid == 3 && $promo_codeid==""){
	err($strPromoteNotice3,"","");
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

		if ( 0 < $probg1['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 0777 );
				$uppath = "shop/pics/".$nowdate;
				$arr = newuploadimage( $probg1['tmp_name'], $probg1['type'], $probg1['size'], $uppath );
				if ( $arr[0] != "err" )
				{
						$src1 = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
		}
		if ( 0 < $probg2['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 0777 );
				$uppath = "shop/pics/".$nowdate;
				$arr = newuploadimage( $probg2['tmp_name'], $probg2['type'], $probg2['size'], $uppath );
				if ( $arr[0] != "err" )
				{
						$src2 = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
		}
		if ( 0 < $probg3['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 0777 );
				$uppath = "shop/pics/".$nowdate;
				$arr = newuploadimage( $probg3['tmp_name'], $probg3['type'], $probg3['size'], $uppath );
				if ( $arr[0] != "err" )
				{
						$src3 = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
		}

	$msql -> query ("insert into {P}_shop_promote set
		`groupid` = '$groupid',
		`name` = '$name',
		`promo_amount` = '$promo_amount',
		`startdate` = '$startdate',
		`enddate` = '$enddate',
		`starttime` = '$starttime',
		`endtime` = '$endtime',
		`promo_codeid` = '$promo_codeid',
		`promo_productid` = '$promo_productid',
		`promo_money` = '$promo_money',
		`range_add` = '$range_add',
		`sdt` = '$sdt',
		`ndt` = '$ndt',
		`probg1` = '$src1',
		`probg2` = '$src2',
		`probg3` = '$src3'
	");

	Sayok($strAddOk,"shoppromote.php","");


	
}


if ($step == "modify") { 
$groupid = $_POST["groupid"];
$name = $_POST["name"];
$promo_amount =  $_POST["promo_amount"];
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];
$starttime = $_POST["starttime"];
$endtime = $_POST["endtime"];
$promo_codeid =  $_POST["promo_codeid"];
$promo_productid =  $_POST["promo_productid"];
$promo_money =  $_POST["promo_money"];
$range_add = $_POST["range_add"];

$probg1 =  $_FILES["probg1"];
$probg2 =  $_FILES["probg2"];
$probg3 =  $_FILES["probg3"];
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

if($promo_amount==""){
	err($strPromoteNotice9,"","");
}
if($groupid == 1 && $promo_productid==""){
	err($strPromoteNotice2,"","");
}
if($groupid == 2 && $promo_money==""){
	err($strPromoteNotice4,"","");
}
if($groupid == 3 && $promo_codeid==""){
	err($strPromoteNotice3,"","");
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

		if ( 0 < $probg1['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 0777 );
				$uppath = "shop/pics/".$nowdate;
				$arr = newuploadimage( $probg1['tmp_name'], $probg1['type'], $probg1['size'], $uppath );
				if ( $arr[0] != "err" )
				{
						$src1 = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
				$msql->query( "select probg1 from {P}_shop_promote where id='{$id}'" );
				if ( $msql->next_record( ) )
				{
						$oldsrc = $msql->f( "probg1" );
				}
				if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )
				{
						unlink( ROOTPATH.$oldsrc );
				}
				$msql->query( "update {P}_shop_promote set probg1='{$src1}' where id='{$id}'" );
		}
		if ( 0 < $probg2['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 0777 );
				$uppath = "shop/pics/".$nowdate;
				$arr = newuploadimage( $probg2['tmp_name'], $probg2['type'], $probg2['size'], $uppath );
				if ( $arr[0] != "err" )
				{
						$src2 = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
				$msql->query( "select probg2 from {P}_shop_promote where id='{$id}'" );
				if ( $msql->next_record( ) )
				{
						$oldsrc = $msql->f( "probg2" );
				}
				if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )
				{
						unlink( ROOTPATH.$oldsrc );
				}
				$msql->query( "update {P}_shop_promote set probg2='{$src2}' where id='{$id}'" );
		}
		if ( 0 < $probg3['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../pics/".$nowdate;
				@mkdir( $picpath, 0777 );
				$uppath = "shop/pics/".$nowdate;
				$arr = newuploadimage( $probg3['tmp_name'], $probg3['type'], $probg3['size'], $uppath );
				if ( $arr[0] != "err" )
				{
						$src3 = $arr[3];
				}
				else
				{
						echo $Meta.$arr[1];
						exit( );
				}
				$msql->query( "select probg3 from {P}_shop_promote where id='{$id}'" );
				if ( $msql->next_record( ) )
				{
						$oldsrc = $msql->f( "probg3" );
				}
				if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && !strstr( $oldsrc, "../" ) )
				{
						unlink( ROOTPATH.$oldsrc );
				}
				$msql->query( "update {P}_shop_promote set probg3='{$src3}' where id='{$id}'" );
		}

	$msql -> query ("update {P}_shop_promote set
		`groupid` = '$groupid',
		`name` = '$name',
		`promo_amount` = '$promo_amount',
		`startdate` = '$startdate',
		`enddate` = '$enddate',
		`starttime` = '$starttime',
		`endtime` = '$endtime',
		`promo_codeid` = '$promo_codeid',
		`promo_productid` = '$promo_productid',
		`promo_money` = '$promo_money',
		`range_add` = '$range_add',
		`sdt` = '$sdt',
		`ndt` = '$ndt',
		`probg1` = '$src1',
		`probg2` = '$src2',
		`probg3` = '$src3' 
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
$starttime = "00:00:00";
$endtime = "23:59:59";
$chgMethod = "<script>chgselect(1);</script>";
$disnone = "style='display:none;'";

	}else{

		$nowstep="modify";

		$msql -> query ("select * from {P}_shop_promote where id='$id'");
		if ($msql -> next_record ()) {
			$id = $msql -> f ('id');
			$groupid = $msql -> f ('groupid');
			$name = $msql -> f ('name');
			$promo_amount =  $msql -> f ('promo_amount');
			$startdate = $msql -> f ('startdate');
			$enddate = $msql -> f ('enddate');
			$starttime = $msql -> f ('starttime');
			$endtime = $msql -> f ('endtime');
			$promo_codeid = $msql -> f ('promo_codeid');
			$promo_productid = $msql -> f ('promo_productid');
			$promo_money = $msql -> f ('promo_money');
			$range_add = $msql -> f ('range_add');
			$probg1 = ROOTPATH.$msql -> f ('probg1');
			$probg2 = ROOTPATH.$msql -> f ('probg2');
			$probg3 = ROOTPATH.$msql -> f ('probg3');
			
			$rangechk_a = $range_add == 1? "checked":"";
			$rangechk_b = $range_add == 0? "checked":"";
		}	
		$chgMethod = "<script>chgselect(".$groupid.");</script>";
	}


?> 
<form name="shoppromote.php" action="" method="post" enctype="multipart/form-data">
<div class="formzone">
<div class="namezone"><?php echo $strSetMenu3; ?></div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr> 
    <td align="right"  width="90" height="26"><?php echo $strPromoteCate; ?></td>
    	<td > 
    		<select name="groupid" onchange="chgselect(this.value);">
<?php
		$msql -> query ("select * from {P}_shop_promotegroup");
		while ($msql -> next_record ()) {
			$gid = $msql -> f ('id');
			$groupname = $msql -> f ('groupname');
			$chkselect ="";
			if($gid == $groupid){$chkselect = "selected";}
			echo '
    			<option value="'.$gid.'" '.$chkselect.'>'.$groupname.'</option>
    			';
    	}
    				
?>
    		</select>
    	</td>
    </tr>
  <tr>
    <td width="90" height="26" align="right"><?php echo $strPromoteName; ?></td>
    <td >
      <input name="name" type="text"  value="<?php echo $name; ?>" size="50" class="input" />
    <font color="#FF3300"> * </font> </td>
  </tr>
  <tr>
    <td width="90" height="26" align="right"><?php echo $strPromoteAmount; ?></td>
    <td >
      <input name="promo_amount" type="text"  value="<?php echo $promo_amount; ?>" size="50" class="input" />
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
      <td align="right"  width="90" height="26"><?php echo $strProNum; ?></td>
      <td > 
        <input name="promo_productid" type="text"  value="<?php echo $promo_productid; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> <?php echo $strProNumAddNote; ?>
      </td>
    </tr>
    <tr id="promo_money"> 
      <td align="right"  width="90" height="26"><?php echo $strProPrice; ?></td>
      <td > 
        <input name="promo_money" type="text"  value="<?php echo $promo_money; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    <tr id="range_add"> 
      <td align="right"  width="90" height="26"><?php echo $strProRangeAdd; ?></td>
      <td > 
        <input name="range_add" type="radio" value="1" size="50" class="input" <?php echo $rangechk_a; ?> /> <?php echo $strYes; ?> <input name="range_add" type="radio" value="0" size="50" class="input" <?php echo $rangechk_b; ?> /> <?php echo $strNo; ?> <?php echo $strProRangeAddNote; ?>
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    <tr id="promo_codeid"> 
      <td align="right"  width="90" height="26"><?php echo $strProRate; ?></td>
      <td > 
        <input name="promo_codeid" type="text"  value="<?php echo $promo_codeid; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>

    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strPromoteTag1; ?></td>
      <td > 
        <input name="probg1" type="file" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    <tr> 
      <td align="right"  width="90" height="26"></td>
      <td > 
        <img height="300" src="<?php echo $probg1;?>" />
      </td>
    </tr>
    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strPromoteTag2; ?></td>
      <td > 
        <input name="probg2" type="file" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    <tr>  
      <td align="right"  width="90" height="26"></td>
      <td > 
        <img height="300" src="<?php echo $probg2;?>" />
      </td>
    </tr>
    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strPromoteTag3; ?></td>
      <td > 
        <input name="probg3" type="file" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>
    <tr> 
      <td align="right"  width="90" height="26"></td>
      <td > 
        <img height="300" src="<?php echo $probg3;?>" />
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