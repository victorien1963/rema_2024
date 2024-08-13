<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "../module/ShopTemperature.php" );
include( "language/".$sLan.".php" );
needauth( 319 );


#---------------------------------------------#
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle;?></title>
<script type="text/javascript" src="../../base/js/base132.js"></script>
<script type="text/javascript" src="../../base/js/form.js"></script>
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script type="text/javascript" src="js/shop.js?50111"></script>
<script type="text/javascript" src="js/jquery.simple-color.min.js"></script>
<script type="text/javascript" src="js/Date/WdatePicker.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#color').simpleColor({
		cellWidth: 20,
    	cellHeight: 20,
    	border: '1px solid #660033',
    	buttonClass: 'button',
    	displayColorCode: true,
    	livePreview: true
	});
});
</script>
<style type="text/css">
<!--
	.simpleColorDisplay {
		float: left;
		font-family: Helvetica;
		width:60px;
	}
	
	.button {
		clear: right;
		margin-left:10px;
	}
.style1 {color: #FF3300}
-->
.desciption {
	list-style-type: none;
	padding: 0;
	border-radius: 16px;
    border: 1px dashed #bbbdc6;
	min-height: 200px;
}
.desciption li {
	margin-bottom: 20px;
	position: relative;
	width: fit-content;
}

.desciption textarea{
	width: 600px;
	height: 200px;
}

.desciption .upload-block {
	/* background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
	background-image: url('./images/cloud-arrow-up.svg'); */
	cursor: pointer;
	border-radius: 16px;
    border: 1px dashed #bbbdc6;
    background-color: #f4f5f9;
	width: fit-content;
	overflow: hidden;
}

.desciption img {
	width: 200px;
	pointer-events: none;
}

.desciption img.default {
	
	width: 64px;
	height: 64px;
	margin: 100px
}
.desciption .close {
	cursor: pointer;
	position: absolute;
	right: 10px;
	top: 10px;
	width: 20px;
	height: 20px;
	background-color: red;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
</head>
<body >
<form id="shopAddForm" name="form" action="" method="post" enctype="multipart/form-data">
<div class="formzone">
<div class="namezone">
<?php echo $strShopFabu;?></div>
<div class="tablezone">
<div  id="notice" class="noticediv"></div>

<?php
$pid = $_REQUEST['pid'];
if ( !isset( $pid ) || $pid == "" )
{
		$pid = 0;
}
$msql->query( "select * from {P}_shop_config" );
while ( $msql->next_record( ) )
{
		$variable = $msql->f( "variable" );
		$value = $msql->f( "value" );
		$GLOBALS['GLOBALS']['SHOPCONF'][$variable] = $value;
}
$danwei = $GLOBALS['SHOPCONF']['DefaultDanwei'];
$centopen = $GLOBALS['SHOPCONF']['CentOpen'];
$centmodle = $GLOBALS['SHOPCONF']['CentModle'];
?>



<?php
$fsql->query( "select * from {P}_shop_cat  order by catpath" );
while ( $fsql->next_record( ) )
{
		$lpid = $fsql->f( "pid" );
		$lcatid = $fsql->f( "catid" );
		$cat = $fsql->f( "cat" );
		$catpath = $fsql->f( "catpath" );
		$lcatpath = explode( ":", $catpath );		
		for ( $i = 0;	$i < sizeof( $lcatpath ) - 2;	$i++	)
		{
				$tsql->query( "select catid,cat from {P}_shop_cat where catid='{$lcatpath[$i]}'" );
				if ( $tsql->next_record( ) )
				{
						$ncatid = $tsql->f( "cat" );
						$ncat = $tsql->f( "cat" );
						$ppcat .= $ncat."/";
				}
		}
		if ( $pid == $lcatid )
		{
				$catlist .= "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
		}
		else
		{
				$catlist .= "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
		}
		if ( $subcatid == $lcatid )
		{
				$subcatlist .= "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
		}
		else
		{
				$subcatlist .= "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
		}
		if ( $thirdcatid == $lcatid )
		{
				$thirdcatlist .= "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
		}
		else
		{
				$thirdcatlist .= "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
		}
		if ( $fourcatid == $lcatid )
		{
				$fourcatlist .= "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
		}
		else
		{
				$fourcatlist .= "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
		}
		if ( $piccatid == $lcatid )
		{
				$piccatlist .= "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
		}
		else
		{
				$piccatlist .= "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
		}
		$ppcat = "";
}

/**
 * 溫度範圍＆環境條件
 */
$shop = new ShopTemperature;

$temperatureList = $shop->getTemperatureList();

$temperatureOptions = "<option value=''>請選擇</option>";

					
foreach($temperatureList as $key => $val) {
	$temperatureOptions .= "<option value=\"$key\">" . $val['title'] . "</option>";
}

$ambienceListList = $shop->getAmbienceList();

$ambienceListOptions = "<option value=''>請選擇</option>";

					
foreach($ambienceListList as $key => $val) {
	$ambienceListOptions .= "<option value=\"$key\">" . $val['title'] . "</option>";
}
?>
 
<table width="100%"   border="0" align="center"  cellpadding="2" cellspacing="0" >
	 <tr> 
      <td height="30" width="100" align="right" >配圖商品</td>
      <td width="5" >&nbsp;</td>
      <td height="30" >
    	<label><input type="radio" id="showpic" name="ifpic" value="0" class="input" checked /> 否</label>
        <label><input type="radio" id="hidepic" name="ifpic" value="1" class="input" /> 是</label>
    		<select id="seltothpic">
				<option value='0'>請選擇原商品</option>
				<?php
				echo $piccatlist;
				?>
              </select>
    	<span id="showselothpic"></span>
		<span class="style1">此商品作為男女共用型商品之(男或女)配圖* </span> </td>
    </tr>
    <tr> 
      <td height="30" width="100" align="right" ><?php echo $strShopCat;?></td>
      <td width="5" >&nbsp;</td>
      <td height="30" >
<select id="selcatid" name="catid" >
					<?php
				echo $catlist;
				?>
		</select>
		</td>
    </tr>
		  <tr> 
            <td height="30" width="100" align="right" >第二分類</td>
            <td width="5" >&nbsp;</td>
            <td height="30" >
				<select name="subcatid" >
				<option value=''>請選擇</option>
				<?php
				echo $subcatlist;
				?>
              </select>
            </td>
          </tr>
		  <tr> 
            <td height="30" width="100" align="right" >第三分類</td>
            <td width="5" >&nbsp;</td>
            <td height="30" >
				<select name="thirdcatid" >
				<option value=''>請選擇</option>
				<?php
				echo $thirdcatlist;
				?>
              </select>
            </td>
          </tr>
		  <tr> 
            <td height="30" width="100" align="right" >第四分類</td>
            <td width="5" >&nbsp;</td>
            <td height="30" >
				<select name="fourcatid" >
				<option value=''>請選擇</option>
				<?php
				echo $fourcatlist;
				?>
              </select>
            </td>
          </tr>
	<tr> 	
      <td height="30" width="100" align="right" ><?php echo $strBrand;?></td>
      <td width="5" >&nbsp;</td>
      <td height="30" >         
		<select id="brandid" name="brandid" >
		</select>
		</td>
    </tr>
		<tr>
            <td width="100" height="30" align="right" ><?php echo $temperatureSetting;?></td>
            <td >&nbsp;</td>
            <td height="30" >
				<select id="temperature" name="temperature">
					<?php echo $temperatureOptions; ?>
				</select>
			</td>
	    </tr>
		<tr>
            <td width="100" height="30" align="right" ><?php echo $ambience;?></td>
            <td >&nbsp;</td>
            <td height="30" >
				<select id="ambience" name="ambience">
					<?php echo $ambienceListOptions; ?>
				</select>
			</td>
	    </tr>
   		 <tr>
            <td width="100" height="30" align="right" ><?php echo $strXuhao;?></td>
            <td >&nbsp;</td>
            <td height="30" ><input id="xuhao" name="xuhao" class="input" value="0" /></td>
	    </tr>
		<tr class="hidepic">
            <td width="100" height="30" align="right" >上架時間</td>
            <td >&nbsp;</td>
            <td height="30" ><input id="starttime" name="starttime" class="input" style="cursor:pointer" onClick="WdatePicker()" value="<?php echo $starttime;?>" /></td>
	    </tr>
	    <tr class="hidepic">
            <td width="100" height="30" align="right" >下架時間</td>
            <td >&nbsp;</td>
            <td height="30" ><input id="endtime" name="endtime" class="input" style="cursor:pointer" onClick="WdatePicker()" value="<?php echo $endtime;?>" /></td>
	    </tr>
    <tr class="hidepic">
      <td height="30" align="right" ><?php echo $strGoodsBn;?></td>
      <td >&nbsp;</td>
      <td height="30" ><input name="bn" type="text" class="input" id="bn" size="35" maxlength="30" />        
<span class="style1">*</span></td>
    </tr>
	<tr class="hidepic"> 
      <td height="30" width="100" align="right" >POS系統商品編號</td>
      <td width="5" >&nbsp;</td>
      <td height="30" ><input name="posbn" type="text" class="input" id="posbn" size="35" maxlength="30" />        
<span class="style1">*</span></td>
    </tr>
	 <tr class="hidepic"> 
      <td height="30" width="100" align="right" ><?php echo $strShopAddTitle;?></td>
      <td width="5" >&nbsp;</td>
      <td height="30" > 
        <input type="text" name="title" style='WIDTH: 499px;font-size:12px;' maxlength="200" class="input" />        
<span class="style1">* </span> </td>
    </tr>
	</table>
	<div id="proplist" class="hidepic">	
	</div>
	<!--隱藏欄位-->
	<input type="hidden" name="weight" class="input" id="weight" value="0" />
	<input type="hidden" name="kucun" class="input" id="kucun" value="0" />
	<input type="hidden" name="danwei" class="input" id="danwei" value="<?php echo $danwei;?>" />

<table width="100%"   border="0" align="center"  cellpadding="2" cellspacing="0" >
		  <tr id="tr_price" class="hidepic">
            <td height="30" width="100" align="right" ><?php echo $strGoodsPrice;?></td>
            <td width="5" >&nbsp;</td>
            <td height="30" >
				<input name="price" type="text" class="input" id="newprice" value="0" size="12" maxlength="12" />  <?php echo $strHbDanwei;?><span class="style1">*</span>
            </td>
          </tr>
	<tr class="hidepic">
      <td height="30" align="right" ><?php echo $strGoodsPrice0;?></td>
      <td >&nbsp;</td>
      <td height="30" ><input name="price0" type="text" class="input" value="0" size="12" maxlength="12" />
          <?php echo $strHbDanwei;?><span class="style1"></span></td>
	  </tr>

<?php
if ( $centopen == "1" && $centmodle == "1" )
{
		echo "	<tr class=\"hidepic\">
      <td height=\"30\" align=\"right\" >".$strGoodsCent."</td>
      <td >&nbsp;</td>
      <td height=\"30\" ><input name=\"cent\" type=\"text\" class=\"input\" id=\"cent\" value=\"0\" size=\"12\" maxlength=\"12\" />     </td>
	  </tr>
	  ";
}
?>
	<tr class="hidepic">
		<td height="30" align="right" ><?php echo $strShopMemo;?></td>
		<td >&nbsp;</td>
		<td height="30" >
			<textarea name="memo" style="WIDTH: 499px;font-size:12px;" class="textarea" rows="5"></textarea>
		</td>
	</tr>
	<tr class="hidepic">
		<td height="30" align="right" >詳細說明</td>
		<td >&nbsp;</td>
		<td height="30" >
			<textarea name="memotext" style="WIDTH: 499px;font-size:12px;" class="textarea" rows="8"></textarea>
		</td>
	</tr>
	<tr class="hidepic">
		<td height="30" align="right" >產品說明</td>
		<td >&nbsp;</td>
		<td height="30" >
			<textarea name="c_body" style="WIDTH: 499px;font-size:12px;" class="textarea" rows="8"></textarea>
		</td>
	</tr>
	<tr class="hidepic">
		<td width="100" height="30" align="right" >配送&換貨/退貨<br>說明</td>
		<td width="5" >&nbsp;</td>
		<td height="30" ><textarea name="afterSalesService" style="WIDTH: 499px;" class="textarea" rows="8"></textarea>
		</td>
	</tr>
	<!--多規格STR-->
	 <tr class="hidepic"> 
      <td height="30" width="100" align="right" >顏色名稱</td>
      <td width="5" >&nbsp;</td>
      <td height="30" > 
        <input type="text" name="colorname" style='font-size:12px;' maxlength="200" class="input" />
		<span class="style1">* </span> </td>
    </tr>
    <tr class="hidepic"> 
      <td height="30" width="100" align="right" >色碼</td>
      <td width="5" >&nbsp;</td>
      <td height="30" > 
        <input type="text" id="color" name="colorcode" style='font-size:12px;' maxlength="7" class="input" value="#" />
		<span class="style1"> </span> </td>
    </tr>
	 <tr> 
      <td height="30" width="100" align="right" >顏色代表圖</td>
      <td width="5" >&nbsp;</td>
      <td height="30" > 
        <input type="file" name="colorpic" class="input" style="WIDTH: 499px;" />        
		<span class="style1">* </span> </td>
    </tr>
		<tr class="hidepic"><td height="30" align="right" >規格名稱</td><td >&nbsp;</td><td height="30">
			<input type="text" value="尺寸" class="input" style="width:60px" disabled="disabled" /> 
			<input type="text" value="庫存量" class="input" style="width:60px" disabled="disabled" />
		</td></tr>
		<tr class="hidepic"><td height="30" align="right" >[<a style="cursor:pointer;" onclick="return addinput(this);">+增加</a>]</td>
			<td >&nbsp;</td>
			<td height="30"> 請點選左側按鈕增加新尺寸
			<!--input name="spec[name][]" type="text" id="spec[]" value="S" class="input" style="width:60px" /> 
			<input name="spec[stocks][]" type="text" id="stocks[]" maxlength="5" value="0" class="input" style="width:60px" /-->
			 <span class="style1">*</span>
		</td></tr>
		<tbody id="cate" class="hidepic"></tbody>
	   		<!--多規格 / 加購商品 END-->
	  <!--附圖上傳 STR-->
	<tr>
      <td height="30" align="right" ><?php echo $strShopAddImg;?></td>
      <td >&nbsp;</td>
      <td height="30" ><input type="file" name="jpg" class="input" style="WIDTH: 499px;" />          
<span class="style1">請上傳 ZIP壓縮檔 </span> </td>
	  </tr>
	<tr>
      <td height="30" align="right" >&nbsp;</td>
      <td >&nbsp;</td>
      <td height="30" >壓縮檔中直接放置需要上傳之圖片，請勿將圖片放置於資料夾中！圖檔請依照先後用1234命名。</td>
	  </tr>
<script src="../../kedit/kindeditor_up.js"></script>
<script charset="utf-8" src="../../kedit/lang/zh_TW_SHOP.js"></script>
	  <!--tr>
      <td height="30" align="right" ><?php echo $strShopAddImg_Main;?></td>
      <td >&nbsp;</td>
      <td height="30" ><input type="file" name="jpg_body" class="input" style="WIDTH: 499px;" />          
<span class="style1"> </span> </td>
	  </tr>
	<tr class="hidepic">
      <td height="30" width="100" align="right" >手機版商品說明</td>
      <td >&nbsp;</td>
      <td height="30" >
		<div id="mod_intro">
			<textarea name="mbody" style="width:680px;height:400px;visibility:hidden;"><?php echo $mbody; ?></textarea>
		</div>

<script>
		KindEditor.ready(function(K) {
			var editor = K.create('textarea[name="mbody"]', {
				uploadJson : '../../kedit/php/upload_json.php?attachPath=shop/pics/',
				fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=shop/pics/',
				allowFlashUpload : false,
				allowMediaUpload : false,
				allowFileManager : true,
				langType : 'zh_TW',
				syncType: '',
				afterBlur: function () { editor.sync(); }

			});
});
</script>
       </td>
    </tr-->

	<tr class="hidepic"> 
      <td height="30" width="100" align="right" >商品頂部輪播圖</td>
      <td >&nbsp;</td>
      <td height="30" >
		<div>
			<textarea name="a_body" style="width:680px;height:400px;visibility:hidden;"><?php echo $a_body; ?></textarea>
		</div>
<script>
		KindEditor.ready(function(K) {
			var editor = K.create('textarea[name="a_body"]', {
				uploadJson : '../../kedit/php/upload_json.php?attachPath=shop/pics/',
				fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=shop/pics/',
				allowFlashUpload : false,
				allowMediaUpload : false,
				allowFileManager : true,
				langType : 'zh_TW',
				syncType: '',
				afterBlur: function () { editor.sync(); }

			});
});
</script>
       </td>
    </tr>
<tr class="hidepic"> 
      <td height="30" width="100" align="right" >商品中間輪圖文<br>(1150*767)</td>
      <td >&nbsp;</td>
      <td>
	  	<div>
			<button type="button" class="addTest">新增文字區塊</button>
			<button type="button" class="addImg">新增圖片區塊</button>
		</div>
		<ul class="desciption">
		
		</ul>
       </td>
    </tr>

<!--<tr class="hidepic"> 
      <td height="30" width="100" align="right" >商品說明<br />(右：保養)</td>
      <td >&nbsp;</td>
      <td height="30" >
		<div>
			<textarea name="d_body" style="width:680px;height:400px;visibility:hidden;"><?php echo $d_body; ?></textarea>
		</div>
<script>
		KindEditor.ready(function(K) {
			var editor = K.create('textarea[name="d_body"]', {
				uploadJson : '../../kedit/php/upload_json.php?attachPath=shop/pics/',
				fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=shop/pics/',
				allowFlashUpload : false,
				allowMediaUpload : false,
				allowFileManager : true,
				langType : 'zh_TW',
				syncType: '',
				afterBlur: function () { editor.sync(); }

			});
});
</script>
       </td>
    </tr>-->
	<tr>
		<td height="30" align="right" ><?php echo $strShopAddImg_Shape;?></td>
		<td >&nbsp;</td>
		<td height="30" ><input type="file" name="jpg_shape" class="input" style="WIDTH: 499px;" />          
		<span class="style1"> </span> </td>
	  </tr>
	  <tr>
      <td height="30" align="right" ><?php echo $strShopAddImg_Features;?></td>
      <td >&nbsp;</td>
      <td height="30" ><input type="file" name="jpg_canshu" class="input" style="WIDTH: 499px;" />          
<span class="style1"> </span> </td>
	  </tr>
	  <!--附圖上傳 END-->
	 <tr> 
      <td height="30" width="100" align="right" >商品屬性</td>
      <td width="5" >&nbsp;</td>
      <td height="30" >
    	<label><input type="radio" name="ifsub" value="0" class="input" checked /> 主商品</label>
        <label><input type="radio" name="ifsub" value="1" class="input" /> 附屬規格商品</label>
    		<select data-selsub="seltosub" class="selsub">
				<option value='0'>請選擇歸附的商品</option>
				<?php
				echo $subcatlist;
				?>
              </select>
    	<span id="showselsub"></span>
		<span class="style1">* </span> </td>
    </tr>
		<tr>
			<td colspan="3"><hr></td>
		</tr>
		<tr>
			<td width="100" height="30" align="right" >尺寸圖片顯示</td>
			<td width="5" >&nbsp;</td>
			<td height="30" >
				<label><input type="radio" name="usepicsize" value="0" checked />否，使用建議尺寸程式 </label>
				<label><input type="radio" name="usepicsize" value="1"  />是，使用商品尺寸圖 </label>
			</td>
		</tr>
		<tr>
			<td width="100" height="30" align="right" >尺寸欄位</td>
			<td width="5" >&nbsp;</td>
			<td height="30" >
				<label><input type="checkbox" name="sizeitem_A" value="1"  />胸圍(C) </label>
				<label><input type="checkbox" name="sizeitem_B" value="1"  />腰圍(W) </label>
				<label><input type="checkbox" name="sizeitem_C" value="1"  />臀圍(H) </label>
			</td>
		</tr>


		<tr>
			<td width="100" height="30" align="right" >主要SIZE型態</td>
			<td width="5" >&nbsp;</td>
			<td height="30" >
<?php
$sourcefold = ROOTPATH.'/base/templates/themes/default/css/IMG/man/';
$style_backup = scandir( $sourcefold );
array_shift($style_backup);array_shift($style_backup);
$k=1;
foreach($style_backup AS $vvs){
	list($bname) = explode(".png",$vvs);
	list($bname_a,$bname_b,$bname_c) = explode("-",$bname);
	if($bname_c==""){
		$bname_b = "";
	}
	if( $bname_a!= "none"){
		echo '<label><input type="checkbox" name="mainsizetype[]" value="'.$vvs.'" />'.$bname_a.'/'.$bname_b.'</label>&nbsp;&nbsp;&nbsp;';
	}
	if($k%8==0){
		echo '<br>';
	}
	$k++;
}
?>
			</td>
		</tr>
		<tr>
			<td width="100" height="30" align="right" >次要SIZE型態</td>
			<td width="5" >&nbsp;</td>
			<td height="30" >
<?php
$sourcefold = ROOTPATH.'/base/templates/themes/default/css/IMG/man/';
$style_backup = scandir( $sourcefold );
array_shift($style_backup);array_shift($style_backup);
$k=1;
foreach($style_backup AS $vvs){
	list($bname) = explode(".png",$vvs);
	list($bname_a,$bname_b,$bname_c) = explode("-",$bname);
	if($bname_c==""){
		$bname_b = "";
	}
	if( $bname_a!= "none"){
		echo '<label><input type="checkbox" name="sizetype[]" value="'.$vvs.'" />'.$bname_a.'/'.$bname_b.'</label>&nbsp;&nbsp;&nbsp;';
	}
	if($k%8==0){
		echo '<br>';
	}
	$k++;
}
?>(非必要選項)
			</td>
		</tr>
		<tr>
			<td width="100" height="30" align="right" >特殊尺寸表</td>
			<td width="5" >&nbsp;</td>
			<td height="30" >
				<select name="sizechart" class="input select">
					<option value='0'>請選擇特殊尺寸表</option>
					<?php
						$fsql->query( "select * from {P}_shop_sizegroup where id>2 order by id asc" );
						while ( $fsql->next_record( ) )
						{
							echo "<option value='".$fsql->f('id')."'>".$fsql->f('groupname')."</option>";
						}
					?>
				</select>
				若不選擇，則 男性/女性 商品自動使用 男性/女性 尺寸表
			</td>
		</tr>
</table>
</div>
<div class="adminsubmit">
<input type="submit" name="cc"  value="<?php echo $strSubmit;?>" class="button" />
<input type="hidden" name="act" value="shopadd">
<input type="hidden" name="pid" value="<?php echo $pid;?>">
<input type="hidden" id="nowid"  value="" />
<input type="hidden" name="author"  value="<?php echo $_COOKIE['SYSNAME'];?>" />
<input type="hidden" name="source"  value="" />
</div>
</div>
</form>
<div style="height:200px;"></div>



</body>
<script>
$(document).ready(function() {
	$().getPropList();
	$().getCatRelBrand();
	$('.addTest').click(function() {
		let childCount = $('.desciption').children().length;
		let html = `
			<li draggable="true">
				<div class="close" onclick="handleClose(event)">x</div>
				<textarea name="desciption[${childCount}]"></textarea>
			</li>
		`;
		$('.desciption').append(html);
	});
	$('.addImg').click(function() {
		let childCount = $('.desciption').children().length;
		let html = `
			<li draggable="true" class="upload-block" onclick="fileClick(event)">
				<div class="close" onclick="handleClose(event)">x</div>
				<input class="upload-input" name="desciption[${childCount}]" multiple type="file" style="display:none" onChange="onFileChange(event)">
				<img class="default" src="./images/cloud-arrow-up.svg">
			</li>
		`;
		$('.desciption').append(html);
	});
	

	let list = document.querySelector('.desciption');
    let currentLi;
	list.addEventListener('dragstart',(e)=>{
		e.dataTransfer.effectAllowed = 'move';
		currentLi = e.target;
		currentLi.classList.add('moving');
	});
	list.addEventListener('dragstart',(e)=>{
		e.dataTransfer.effectAllowed = 'move';
		currentLi = e.target;
		setTimeout(()=>{
			currentLi.classList.add('moving');
		})
	});
	list.addEventListener('dragenter',(e)=>{
		e.preventDefault();  // 阻止默认事件
		let li = e.target.closest('li');
		if(e.target === currentLi||e.target === list || !li) {
			return;
		}
		
		let liArray = Array.from(list.childNodes);
		let currentIndex = liArray.indexOf(currentLi);
		
		let targetIndex = liArray.indexOf(li); // 使用 closest 方法找到最近的 li 元素
		if (currentIndex < targetIndex) {
			console.log(li);
			list.insertBefore(currentLi, li.nextElementSibling);
		} else {
			list.insertBefore(currentLi, li);
		}
		// let targetindex = liArray.indexOf(e.target);
		// console.log(e.target);
		// if(currentIndex<targetindex){
		// 	list.insertBefore(currentLi,e.target.nextElementSibling);
		// }else{
		// 	list.insertBefore(currentLi,e.target);
		// }
	});
	list.addEventListener('dragover',(e)=>{
		e.preventDefault()
	});
	list.addEventListener('dragend',(e)=>{
		currentLi.classList.remove('moving')
		$("ul li").each(function(index){
			$(this).find('input').attr("name", `desciption[${index}]`);
			$(this).find('textarea').attr("name", `desciption[${index}]`);
		});
	});
});
function handleClose(event) {
	event.stopPropagation();
	event.target.parentNode.remove();
}
function fileClick(event) {
	event.currentTarget.querySelector('.upload-input').click();
};
async function onFileChange(event) {
	var file = event.target.files[0];
    var imgUrl = await fileAdd(file);
	if(!imgUrl) {
		alert('圖片格式錯誤!!!');
		return false;
	}
    var imgElement = event.target.parentNode.querySelector('img');
    imgElement.src = imgUrl;
	imgElement.classList.remove('default');
}
function fileAdd(file) {
  return new Promise((resolve, reject) => {
    if (
      file.type.indexOf("png") > -1 ||
      file.type.indexOf("jpeg") > -1 ||
      file.type.indexOf("jpg") > -1 ||
      file.type.indexOf("svg") > -1 ||
      file.type.indexOf("webp") > -1
    ) {
      const reader = new FileReader();
      reader.onload = () => {
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function () {
          let result = this.result;
          resolve(result);
        };
      };
      reader.readAsDataURL(file);
    } else {
		resolve(false);
    }
  });
};
</script>
</html>