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
	
$nft = array(
    "(", ")", "[", "]", "{", "}", ".", ",", ";", ":",
    "-", "?", "!", "@", "#", "$", "%", "&", "|", "\\",
    "/", "+", "=", "*", "~", "`", "'", "\"", "<", ">",
    "^", "_", "[", "]"
);
$wft = array(
    "（", "）", "〔", "〕", "｛", "｝", "﹒", "，", "；", "：",
    "－", "？", "！", "＠", "＃", "＄", "％", "＆", "｜", "＼",
    "／", "＋", "＝", "＊", "～", "、", "、", "＂", "＜", "＞",
    "︿", "＿", "【", "】"
);
	
$step=$_REQUEST["step"];
$id=$_REQUEST["id"];


if ($step == "add") { 

$type = $_POST["type"];
$type_value = $_POST["type_value"];
$code = str_replace($nft, $wft, $_POST["code"]);
$times = $_POST["times"];

$membertypeid = $_POST["membertypeid"];
$memberid = $_POST["memberid"];
$memberreg = $_POST["memberreg"];
$pertimes = $_POST["pertimes"];

$starttime = strtotime($_POST["starttime"]);
$endtime = strtotime($_POST["endtime"]);
$mail_temp = $_POST["mail_temp"];

$pricelimit = $_POST["pricelimit"];


if($code==""){
	err($strPromoNotice1,"","");
}
if($type_value==""){
	err($strPromoNotice2,"","");
}

/**/
if($memberreg){
	$msql -> query ("update {P}_shop_promocode set memberreg='0' where memberreg='1'");
}
/*
foreach((array)$aboutspec AS $speccat){
$aboutspecs .= $aboutspecs? ",".$speccat:$speccat;
}*/

	$msql -> query ("insert into {P}_shop_promocode set
		`type` = '$type',
		`type_value` = '$type_value',
		`code` = '$code',
		`times` = '$times',
		`pertimes` = '$pertimes',
		`pricelimit` = '$pricelimit',
		`membertypeid` = '$membertypeid',
		`memberid` = '$memberid',
		`memberreg` = '$memberreg',
		`starttime` = '$starttime',
		`endtime` = '$endtime',
		`mail_temp` = '$mail_temp' 
	");

	Sayok($strAddOk,"promocode.php","");


	
}


if ($step == "modify") { 
$type = $_POST["type"];
$type_value = $_POST["type_value"];
$code = $_POST["code"];
$times = $_POST["times"];

$membertypeid = $_POST["membertypeid"];
$memberid = $_POST["memberid"];
$memberreg = $_POST["memberreg"];
$pertimes = $_POST["pertimes"];

$starttime = strtotime($_POST["starttime"]);
$endtime = strtotime($_POST["endtime"]);

$mail_temp = $_POST["mail_temp"];

if($code==""){
	err($strPromoNotice1,"","");
}
if($type_value==""){
	err($strPromoNotice2,"","");
}

if($memberreg){
	$msql -> query ("update {P}_shop_promocode set memberreg='0' where memberreg='1'");
}
/*
foreach((array)$aboutspec AS $speccat){
$aboutspecs .= $aboutspecs? ",".$speccat:$speccat;
}
*/

	$msql -> query ("update {P}_shop_promocode set
		`type` = '$type',
		`type_value` = '$type_value',
		`code` = '$code',
		`times` = '$times',
		`pertimes` = '$pertimes',
		`membertypeid` = '$membertypeid',
		`memberid` = '$memberid',
		`memberreg` = '$memberreg',
		`starttime` = '$starttime',
		`endtime` = '$endtime',
		`mail_temp` = '$mail_temp' 
		where id = '$id'
	");

	Sayok($strModifyOk,"promocode.php","");
	
}

//NEW ADVS
if($id=="0" || $id==""){
$nowstep="add";
$type = "";
$type_value = "";
$code = "";
$times = "";
$membertypeid = "";
$memberid = "";
$starttime = "";
$endtime = "";


	}else{

		$nowstep="modify";

		$msql -> query ("select * from {P}_shop_promocode where id='$id'");
		if ($msql -> next_record ()) {
			$id = $msql -> f ('id');
			$type = $msql -> f ('type');
			if($type==1){
				$TypeChk1="selected";
			}else{
				$TypeChk2="selected";
			}
			$type_value = $msql -> f ('type_value');
			$code = $msql -> f ('code');
			$times = $msql -> f ('times');
			$pertimes = $msql -> f ('pertimes');
			$shopcat = $msql -> f ('shopcat');
			$shopid = $msql -> f ('shopid');
			$membertypeid = $msql -> f ('membertypeid');
			$memberid = $msql -> f ('memberid');
			$starttime = $msql -> f ('starttime')? date("Y-m-d",$msql -> f ('starttime')):"";
			$endtime = $msql -> f ('endtime')? date("Y-m-d",$msql -> f ('endtime')):"";
			$mail_temp = $msql -> f ('mail_temp');
			$PromoRegChk_a = $msql -> f ('memberreg') == 1? "checked":"";
			$PromoRegChk_b = $msql -> f ('memberreg') == 0? "checked":"";
			$plimit = $msql -> f ('pricelimit');
		}	
	}

if($mail_temp == ""){
$mail_temp='親愛的會員您好：

'.$GLOBALS['CONF'][SiteName].' 促銷活動開始囉！
在此送上專屬於您的電子優惠券碼：「XXXXXXXX」。
歡迎您至網站上消費選購。

以下為本優惠碼優惠內容：
1. 優惠方式：直接折價
2. 折價金額：OOO元
3. 使用期限：OOOO年OO月OO日~OOOO年OO月OO日 止

歡迎再次光臨「'.$GLOBALS['CONF'][SiteName].'」，網址：'.$SiteUrl;
}

?> 
<form name="promocode.php" action="" method="post" enctype="multipart/form-data">
<div class="formzone">
<div class="namezone"><?php echo $strSetMenu21; ?></div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="90" height="26" align="right"><?php echo $strPromoCode; ?></td>
    <td >
      <input name="code" type="text"  value="<?php echo $code; ?>" size="50" class="input" />
    <font color="#FF3300"> * </font> </td>
  </tr>
  <tr> 
    <td align="right"  width="90" height="26"><?php echo $strPromoType; ?></td>
    	<td > 
    		<select name="type">
				<option value="1" <?php echo $TypeChk1; ?>>折價金</option>
				<option value="2" <?php echo $TypeChk2; ?>>折扣%</option>
    		</select>
    	</td>
    </tr>
    <tr id="type_value"> 
      <td align="right"  width="90" height="26"><?php echo $strPromoValue; ?></td>
      <td > 
        <input name="type_value" type="text"  value="<?php echo $type_value; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> <?php echo $strPromoNotice3; ?>
      </td>
    </tr>
    <tr id="times"> 
      <td align="right"  width="90" height="26"><?php echo $strPromoTimes; ?></td>
      <td > 
        <input name="times" type="text"  value="<?php echo $times; ?>" size="50" class="input" />
        <font color="#FF3300"> </font> 
      </td>
    </tr>
    <tr id="pertimes"> 
      <td align="right"  width="90" height="26"><?php echo $strPromoPerTimes; ?></td>
      <td > 
        <input name="pertimes" type="text"  value="<?php echo $pertimes; ?>" size="50" class="input" />
        <font color="#FF3300"> </font> <?php echo $strPromoNotice6; ?>
      </td>
    </tr>
    <tr> 
      <td align="right"  width="90" height="26">使用金額限制</td>
      <td > 
        <input name="pricelimit" type="text"  value="<?php echo $plimit; ?>" size="50" class="input" />
        <font color="#FF3300"> </font> 購物需滿該金額，才能使用優惠碼，輸入 0或維持空白，則不限制
      </td>
    </tr>
    

    <tr id="membertypeid"> 
      <td align="right"  width="90" height="26"><?php echo $strPromoMemberTypeId; ?></td>
      <td > 
<select name="membertypeid" >
                <option value='0'><?php echo $strMemberTypeSel; ?></option>
                
<?php
$fsql->query( "select * from {P}_member_type  order by membertypeid" );
while ( $fsql->next_record( ) )
{
		$lmembertypeid = $fsql->f( "membertypeid" );
		$lmembertype = $fsql->f( "membertype" );
		if ( $membertypeid == $lmembertypeid )
		{
				echo "<option value='".$lmembertypeid."' selected>".$lmembertype."</option>";
		}
		else
		{
				echo "<option value='".$lmembertypeid."'>".$lmembertype."</option>";
		}
}
?>
              </select>
        <font color="#FF3300"> </font> 
      </td>
    </tr>
    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strPromoMemberId; ?></td>
      <td > 
        <input name="memberid" type="text" value="<?php echo $memberid; ?>" size="50" class="input" />
        <font color="#FF3300"> </font> <?php echo $strPromoNotice4; ?>
      </td>
    </tr>
    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strPromoMemberReg; ?></td>
      <td > 
        <input name="memberreg" type="radio" value="1" class="input" <?php echo $PromoRegChk_a; ?> /> <?php echo $strYes; ?>
    	<input name="memberreg" type="radio" value="0" class="input" <?php echo $PromoRegChk_b; ?> /> <?php echo $strNo; ?>
        <font color="#FF3300"> </font> <?php echo $strPromoNotice5; ?>
      </td>
    </tr>
    	
    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strPromoStart; ?></td>
      <td > 
        <input name="starttime" type="text" onClick="WdatePicker()" value="<?php echo $starttime; ?>" size="50" class="input" />
        <font color="#FF3300"> </font> 
      </td>
    </tr>
    <!--<tr> 
      <td align="right"  width="90" height="26"><?php echo $strProStarTime; ?></td>
      <td > 
        <input name="starttime" type="text" onClick="WdatePicker({dateFmt:'HH:mm:ss'})" value="<?php echo $starttime; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>-->
    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strPromoEnd; ?></td>
      <td > 
        <input name="endtime" type="text" onClick="WdatePicker()" value="<?php echo $endtime; ?>" size="50" class="input" />
        <font color="#FF3300"> </font> 
      </td>
    </tr>
    <!--<tr> 
      <td align="right"  width="90" height="26"><?php echo $strProEndTime; ?></td>
      <td > 
        <input name="endtime" type="text" onClick="WdatePicker({dateFmt:'HH:mm:ss'})" value="<?php echo $endtime; ?>" size="50" class="input" />
        <font color="#FF3300"> * </font> 
      </td>
    </tr>-->
    <tr> 
      <td align="right"  width="90" height="26"><?php echo $strPromoMailtemp; ?></td>
      <td > 
    <textarea id="text_body" name="mail_temp" style="width:680px;height:400px;visibility:hidden;"><?php echo $mail_temp; ?></textarea>
<script type="text/javascript" src="../../kedit/kindeditor-min.js"></script>
<script charset="utf-8" src="../../kedit/lang/zh_TW.js"></script>
<script>
		KindEditor.ready(function(K) {
			var editor = K.create('textarea[name="mail_temp"]', {
				uploadJson : '../../kedit/php/upload_json.php?attachPath=shop/pics/',
				fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=shop/pics/',
				allowFlashUpload : false,
				allowMediaUpload : false,
				allowFileManager : true,
				langType : 'zh_TW',
				syncType: '',
				afterBlur: function () { editor.sync(); },
				designMode: false

			});
});
</script>
</td>
    </tr>

</table>
</div>
<div class="adminsubmit">
        <input type="submit" name="Submit" value="<?php echo $strSubmit; ?>" class="button" />
        <input type="button" name="Submit2" value="<?php echo $strBack; ?>" class="button" onClick="self.location='promocode.php'" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input name="step" type="hidden" id="submit" value="<?php echo $nowstep; ?>" />

</div>

</div>
</form>

</body>
</html>