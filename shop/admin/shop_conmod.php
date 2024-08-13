<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "../module/ShopTemperature.php" );
include( "language/".$sLan.".php" );
needauth( 320 );

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
<script type="text/javascript" src="js/shop.js?5"></script>
<script type="text/javascript" src="js/ajaxfileupload.js"></script>
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
	<script type="text/javascript">
	
	function showtable(showid, hideid, nowbid, backid){
		$("#"+hideid).hide();
		$("#"+showid).show();
		$("#"+nowbid).addClass('lablenow').removeClass('lable');
		$("#"+backid).addClass('lable').removeClass('lablenow');
	}
	
	
	function ajaxFileUpload(specid)
	{
		$("#loading_"+specid).ajaxStart(function(){
			$(this).show();
		})
		$("#loading_"+specid).ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'post.php?specact=upspecicon&specid='+specid,
				secureuri:false,
				fileElementId:'itempic_'+specid,
				dataType: 'json',
				data:{name:'logan', id:'id'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);

						}else
						{
							alert("小圖上傳成功!");
							$("#specicon_"+specid).attr("src",data.msg);
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);

				}
			}
		)
		
		return false;

	}
	</script>
</head>
<body >

<?php
$id = $_REQUEST['id'];
$pid = $_REQUEST['pid'];
$msql->query( "select * from {P}_shop_config" );
while ( $msql->next_record( ) )
{
		$variable = $msql->f( "variable" );
		$value = $msql->f( "value" );
		$GLOBALS['GLOBALS']['SHOPCONF'][$variable] = $value;
}
$centopen = $GLOBALS['SHOPCONF']['CentOpen'];
$centmodle = $GLOBALS['SHOPCONF']['CentModle'];
$msql->query( "select * from {P}_shop_con where  id='{$id}'" );
if ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$catid = $msql->f( "catid" );
		$subcatid = $msql->f( "subcatid" );
		$thirdcatid = $msql->f( "thirdcatid" );
		$fourcatid = $msql->f( "fourcatid" );
		$title = $msql->f( "title" );
		$memo = $msql->f( "memo" );
		$memotext = $msql->f( "memotext" );
		$afterSalesService = $msql->f( "after_sales_service" );
		$body = $msql->f( "body" );
		$mbody = $msql->f( "mbody" );
		$canshu = $msql->f( "canshu" );
		$xuhao = $msql->f( "xuhao" );
		$temperature = $msql->f( "temperature" );
		$ambience = $msql->f( "ambience" );
		$cl = $msql->f( "cl" );
		$tj = $msql->f( "tj" );
		$ifnew = $msql->f( "ifnew" );
		$ifred = $msql->f( "ifred" );
		$iffb = $msql->f( "iffb" );
		$src = $msql->f( "src" );
		$type = $msql->f( "type" );
		$author = $msql->f( "author" );
		$source = $msql->f( "source" );
		$secure = $msql->f( "secure" );
		$oldcatid = $msql->f( "catid" );
		$oldcatpath = $msql->f( "catpath" );
		$tags = $msql->f( "tags" );
		$bn = $msql->f( "bn" );
		$posbn = $msql->f( "posbn" );
		$weight = $msql->f( "weight" );
		$kucun = $msql->f( "kucun" );
		$cent = $msql->f( "cent" );
		$price = $msql->f( "price" );
		$price0 = $msql->f( "price0" );
		$brandid = $msql->f( "brandid" );
		$danwei = $msql->f( "danwei" );
		$body = htmlspecialchars( $body );
		$body = path2url( $body );
		//$mbody = htmlspecialchars( $mbody );
		$mbody = path2url( $mbody );
		$canshu = htmlspecialchars( $canshu );
		$canshu = path2url( $canshu );
		$dtime = date( "Y-m-d H:i:s", $msql->f( "dtime" ) );
		$uptime = date( "Y-m-d H:i:s", $msql->f( "uptime" ) );
		$tags = explode( ",", $tags );
		$oldproj = $msql->f( "proj" );
		
		list($sizeitem_a,$sizeitem_b,$sizeitem_c) = explode("|",$msql->f( "sizeitem" ));
		$mainsizetype = explode("|",$msql->f( "mainsizetype" ));
		$sizetype = explode("|",$msql->f( "sizetype" ));
		$usepicsize = $msql->f( "usepicsize" );
		
			$prop1=$msql->f('prop1');
			$prop2=$msql->f('prop2');
			$prop3=$msql->f('prop3');
			$prop4=$msql->f('prop4');
			$prop5=$msql->f('prop5');
			$prop6=$msql->f('prop6');
			$prop7=$msql->f('prop7');
			$prop8=$msql->f('prop8');
			$prop9=$msql->f('prop9');
			$prop10=$msql->f('prop10');
			$prop11=$msql->f('prop11');
			$prop12=$msql->f('prop12');
			$prop13=$msql->f('prop13');
			$prop14=$msql->f('prop14');
			$prop15=$msql->f('prop15');
			$prop16=$msql->f('prop16');
			$prop17=$msql->f('prop17');
			$prop18=$msql->f('prop18');
			$prop19=$msql->f('prop19');
			$prop20=$msql->f('prop20');
			$a_body=$msql->f('a_body');
			$b_body=$msql->f('b_body');
			$c_body=$msql->f('c_body');
			$d_body=$msql->f('d_body');
		
		$colorname = $msql->f( "colorname" );
		$colorcode = $msql->f( "colorcode" );
		$colorpic = ROOTPATH.$msql->f( "colorpic" );
		$ifsub = $msql->f( "ifsub" );
		$subid = $msql->f( "subid" );
		
		$sizechart = $msql->f( "sizechart" );
		
		$getsub = $tsql->getone(" SELECT id,title,bn,colorname,catid FROM {P}_shop_con WHERE id='$subid' ");		
		$subidlist = "<option value='".$getsub[id]."'>".$getsub[bn]." ".$getsub[title]."(".$getsub[colorname].")</option>";
		$ifsubcatid = $getsub[catid];
		
		$ifpic = $msql->f( "ifpic" );
		$subpicid = $msql->f( "subpicid" );
		
		$getsubpic = $tsql->getone(" SELECT id,title,bn,colorname,catid FROM {P}_shop_con WHERE id='$subpicid' ");		
		$subpicidlist = "<option value='".$getsubpic[id]."'>".$getsubpic[bn]." ".$getsubpic[title]."(".$getsubpic[colorname].")</option>";
		$piccatid = $getsubpic[catid];
		
		if($msql->f( "starttime" )){
			$starttime = date( "Y-m-d", $msql->f( "starttime" ) );
		}else{
			$starttime = "";
		}
		if($msql->f( "endtime" )){
			$endtime = date( "Y-m-d", $msql->f( "endtime" ) );
		}else{
			$endtime = "";
		}
		
		$spectb = '<tbody id="spcate">';
		
		if($msql->f( "isadd" ) == 1){ $isaddcheck2="checked";}else{$isaddcheck1="checked";}
		
		$fsql->query( "select * from {P}_shop_conspec where gid='{$id}' order by id" );
		while ( $fsql->next_record( ) )
		{
			$spectb .= '<tr id="spid_'.$fsql->f('id').'"><td height="30" align="right" >&nbsp;</td>
			<td >&nbsp;</td>
			<td height="30">';
			$spectb .='
			<input id="size_'.$fsql->f('id').'" value="'.$fsql->f('size').'" class="input" style="width:60px" /> 
			<input id="stocks_'.$fsql->f('id').'" value="'.$fsql->f('stocks').'" class="input" style="width:60px" /> 
			';
			$spectb .= '&nbsp;[<a style="cursor:pointer;" id="delsp_'.$fsql->f('id').'" class="delspec">-刪除</a>]
			&nbsp;[<a style="cursor:pointer;" id="fixsp_'.$fsql->f('id').'" class="fixspec">-修改</a>]
			</td></tr>';
		}
		$spectb .= '</tbody>';
		$desciption = $msql->f( "desciption" );
		$desciption = json_decode($msql->f( "desciption" ), true);
		$desciptionLimts = "";
		$indexKey = 0;
		foreach($desciption as $key => $d) {
			if(array_key_exists('img', $d)) {
				$desciptionLimts .= '
				<li draggable="true" class="upload-block" onclick="fileClick(event)">
					<div class="close" onclick="handleClose(event)">x</div>
					<input class="upload-input" name="desciption[' . $indexKey . ']" multiple type="file" style="display:none" onChange="onFileChange(event)">
					<input data-method="img" name="desciption[' . $indexKey . '][img]" value="' . $d['img'] . '" style="display:none">
					<img src="' . ROOTPATH.$d['img'] . '">
				</li>
				';
			} else {
				$jsonString = str_replace('#SPACE#', ' ', $d);
				$jsonString = preg_replace('/<br\s*\/?>/i', "\n", $jsonString);
				$desciptionLimts .= '
				<li draggable="true">
					<div class="close" onclick="handleClose(event)">x</div>
					<textarea name="desciption[' . $indexKey . ']">' . $jsonString . '</textarea>
				</li>
				';
			}
			$indexKey++;
		}

}
    
    $msql->query( "select * from cpp_shop_product_size where id='{$id}'" );
    if ( $msql->next_record( ) )
    {
            $size = $msql->f( "size" );
    } else {
        $size = "";
    }
//$spectb = '';

/**
 * 溫度範圍＆環境條件
 */
$shop = new ShopTemperature;

$temperatureList = $shop->getTemperatureList();
$temperatureOptions = "<option value=''>請選擇</option>";			
foreach($temperatureList as $key => $val) {
	$temperatureOptions .=  "<option value=\"$key\" . " . ($temperature == $key ? 'selected' : '') . ">" . $val['title'] . "</option>";
}

$ambienceListList = $shop->getAmbienceList();
$ambienceListOptions = "<option value=''>請選擇</option>";

foreach($ambienceListList as $key => $val) {
	$ambienceListOptions .=  "<option value=\"$key\" . " . ($ambience == $key ? 'selected' : '') . ">" . $val['title'] . "</option>";
}

?>
 
<div class="lablenow" id="laba"><a style="display:block;padding:4px 10px;" href="javascipt:;" onclick="showtable('tablea','tableb','laba','labb');"><?php echo $strShopModify;?></a></div>
<div class="lable" id="labb"><a style="display:block;padding:4px 10px;" href="javascipt:;" onclick="showtable('tableb','tablea','labb','laba');">多國語言</a></div>

<div class="formzone" style="clear:both;">
<form id="shopForm" name="form" action="" method="post" enctype="multipart/form-data">
<!--div class="namezone"><?php echo $strShopModify;?></div-->
<div class="tablezone" id="tablea">
<div  id="notice" class="noticediv"></div>

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
		if ( $catid == $lcatid )
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
		if ( $ifsubcatid == $lcatid )
		{
				$ifsubcatlist .= "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
		}
		else
		{
				$ifsubcatlist .= "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
		}
		$ppcat = "";
}
?>
	
      <table class="shopmodizone" width="100%" cellpadding="2" align="center"  border="0" cellspacing="0">
	 <tr> 
      <td height="30" width="100" align="right" >配圖商品</td>
      <td width="5" >&nbsp;</td>
      <td height="30" >
    	<label><input type="radio" id="showpic" name="ifpic" value="0" class="input" <?php echo checked($ifpic,"0");?> /> 否</label>
        <label><input type="radio" id="hidepic" name="ifpic" value="1" class="input" <?php echo checked($ifpic,"1");?> /> 是</label>
    		<select id="seltothpic">
				<option value='0'>請選擇原商品</option>
				<?php
				echo $piccatlist;
				?>
              </select>
    	<span id="showselothpic"><select name="subpicid">
    				<?php
				echo $subpicidlist;
				?></select></span>
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
            <td width="100" height="30" align="right" ><?php echo $strBrand;?></td>
            <td >&nbsp;</td>
            <td height="30" >			 
<select id="brandid" name="brandid" >
              </select>
            </td>
	    </tr>
		<tr>
            <td width="100" height="30" align="right" ><?php echo $temperatureSetting;?></td>
            <td >&nbsp;</td>
            <td height="30" >
				<select id="temperature" name="temperature" value="<?php echo $temperature;?>">
					<?php echo $temperatureOptions;?>
				</select>
			</td>
	    </tr>
		<tr>
            <td width="100" height="30" align="right" ><?php echo $ambienceSetting;?></td>
            <td >&nbsp;</td>
            <td height="30" >
				<select id="ambience" name="ambience" value="<?php echo $ambience;?>">
					<?php echo $ambienceListOptions; ?>
				</select>
			</td>
	    </tr>
	    <tr>
            <td width="100" height="30" align="right" ><?php echo $strXuhao;?></td>
            <td >&nbsp;</td>
            <td height="30" ><input id="xuhao" name="xuhao" class="input" value="<?php echo $xuhao;?>" /></td>
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
            <td width="100" height="30" align="right" ><?php echo $strGoodsBn;?></td>
            <td >&nbsp;</td>
            <td height="30" ><input name="bn" type="text" class="input" id="bn" value="<?php echo $bn;?>" size="35" maxlength="30" />
<span class="style1">*</span></td>
	    </tr>
		<tr class="hidepic"> 
	      <td height="30" width="100" align="right" >POS系統商品編號</td>
	      <td width="5" >&nbsp;</td>
	      <td height="30" ><input name="posbn" type="text" class="input" id="posbn" value="<?php echo $posbn;?>" size="35" maxlength="30" />        
	<span class="style1">*</span></td>
	    </tr>
		   <tr class="hidepic"> 
            <td height="30" width="100" align="right" ><?php echo $strShopAddTitle;?></td>
            <td width="5" >&nbsp;</td>
            <td height="30" > 
              <input type="text" id="title" name="title" style='WIDTH: 499px;' maxlength="200" class="input" value="<?php echo $title;?>" />
              <font color="#FF0000">*</font> </td>
          </tr>
      </table>
	  <div id="proplist" class="shopmodizone">
	  </div>

	<!--隱藏欄位-->
	<input type="hidden" name="weight" class="input" id="weight" value="<?php echo $weight;?>" />
	<input type="hidden" name="kucun" class="input" id="kucun" value="<?php echo $kucun;?>" />
	<input type="hidden" name="danwei" class="input" id="danwei" value="<?php echo $danwei;?>" />
	  		  
	   <table class="shopmodizone" width="100%" cellpadding="2" align="center"  border="0" cellspacing="0">
		  <tr id="tr_price" class="hidepic">
	  <td width="100" height="30" align="right" ><?php echo $strGoodsPrice;?></td>
	  <td width="5" >&nbsp;</td>
	  <td height="30" ><input name="price" type="text" class="input" id="modiprice" value="<?php echo (INT)$price;?>" size="12" maxlength="12" />
	    <input name="oldprice" type="hidden" id="oldprice" value="<?php echo $price;?>"  />  
	  <?php echo $strHbDanwei;?><span class="style1">*</span></td>
	  </tr>
	<tr class="hidepic">
      <td width="100" height="30" align="right" ><?php echo $strGoodsPrice0;?></td>
      <td >&nbsp;</td>
      <td height="30" ><input name="price0" type="text" class="input" id="price0" value="<?php echo (INT)$price0;?>" size="12" maxlength="12" />
          <?php echo $strHbDanwei;?><span class="style1"></span></td>
	  </tr>
<?php
if ( $centopen == "1" && $centmodle == "1" )
{
		echo "<tr class=\"hidepic\">
      <td width=\"100\" height=\"30\" align=\"right\" >".$strGoodsCent."</td>
      <td >&nbsp;</td>
      <td height=\"30\" ><input name=\"cent\" type=\"text\" class=\"input\" id=\"cent\" value=\"".$cent."\" size=\"12\" maxlength=\"12\" /></td>
	  </tr>";
}
?>
		 <tr class="hidepic">
            <td width="100" height="30" align="right" ><?php echo $strShopMemo;?></td>
            <td width="5" >&nbsp;</td>
            <td height="30" ><textarea name="memo" style="WIDTH: 499px;" class="textarea" rows="5"><?php echo $memo;?></textarea>
            </td>
          </tr>
		 <tr class="hidepic">
            <td width="100" height="30" align="right" >詳細說明</td>
            <td width="5" >&nbsp;</td>
            <td height="30" ><textarea name="memotext" style="WIDTH: 499px;" class="textarea" rows="8"><?php echo $memotext;?></textarea>
            </td>
          </tr>
		  <tr class="hidepic">
            <td width="100" height="30" align="right" >產品說明</td>
            <td width="5" >&nbsp;</td>
            <td height="30" ><textarea name="c_body" style="WIDTH: 499px;" class="textarea" rows="8"><?php echo $c_body;?></textarea>
            </td>
          </tr>
		  <tr class="hidepic">
            <td width="100" height="30" align="right" >配送&換貨/退貨<br>說明</td>
            <td width="5" >&nbsp;</td>
            <td height="30" ><textarea name="afterSalesService" style="WIDTH: 499px;" class="textarea" rows="8"><?php echo $afterSalesService;?></textarea>
            </td>
          </tr>
		  <tr style="display:none">
	  <td width="100" height="30" align="right" >統一更改尺寸價格</td>
	  <td width="5" >&nbsp;</td>
	  <td height="30" >
	  		  <label><input type="radio" name="chgallprice" value="0" checked />否</label>
			<label><input type="radio" name="chgallprice" value="1" />是</label>
		</td>
	  </tr>
	<!--多規格STR-->
	 <tr class="hidepic"> 
      <td height="30" width="100" align="right" >顏色名稱</td>
      <td width="5" >&nbsp;</td>
      <td height="30" > 
        <input type="text" name="colorname" style='font-size:12px;' value="<?php echo $colorname;?>" maxlength="200" class="input" />
		<span class="style1">* </span> </td>
    </tr>
    <tr class="hidepic"> 
      <td height="30" width="100" align="right" >色碼</td>
      <td width="5" >&nbsp;</td>
      <td height="30" > 
        <input type="text" id="color" name="colorcode" style='font-size:12px;' maxlength="7" class="input" value="<?php echo $colorcode;?>" />
		<span class="style1"> </span> </td>
    </tr>
	 <tr> 
      <td height="30" width="100" align="right" >顏色代表圖</td>
      <td width="5" >&nbsp;</td>
      <td height="30" ><input type="file" name="colorpic" class="input" style="WIDTH: 499px;" />        
		<span class="style1">* </span> <br /></td>
    </tr>

	 <tr> 
      <td height="30" width="100" align="right" >&nbsp;</td>
      <td width="5" >&nbsp;</td>
      <td height="30" > <img src="<?php echo $colorpic;?>" style="WIDTH: 499px;"></td>
    </tr>
			<tr class="hidepic"><td height="30" align="right" >規格名稱：</td><td >&nbsp;</td><td height="30">
			<input type="text" value="尺寸" class="input" style="width:60px" disabled="disabled" /> 
			<input type="text" value="庫存量" class="input" style="width:60px" disabled="disabled" />
		</td></tr>
		<?php echo $spectb; ?>
		<tr class="hidepic"><td height="30" align="right" >[<a style="cursor:pointer;" onclick="return addinput(this);">+增加</a>]</td>
			<td >&nbsp;</td>
			<td height="30"> 請點選左側按鈕增加新尺寸
			<!--input name="spec[name][]" type="text" id="spec[]" value="S" class="input" style="width:60px" /> 
			<input name="spec[stocks][]" type="text" id="stocks[]" maxlength="5" value="0" class="input" style="width:60px" /-->
			<span class="style1">*</span>
		</td></tr>
		<tbody id="cate"></tbody>
			</td></tr>
	 <!--多規格END-->
      </table>
		  
		   <table width="100%"   border="0" align="center"  cellpadding="2" cellspacing="0">
		  <tr> 
            <td height="30" width="100" align="right" ><?php echo $strShopAddImg;?></td>
            <td width="5" >&nbsp;</td>
            <td height="30" > 
              <input id="uppic" type="file" name="jpg" class="input" style='WIDTH: 499px;' />
			  <input  type='submit' name='modi' value='<?php echo $strShopUpload;?>' class='savebutton' style="display:none;" />
		    </td>
          </tr>
		<tr>
		     <td align="right" ></td>
		     <td width="5" >&nbsp;</td>
		     <td ><img id="picpriview" src="images/loading.gif" /></td>
		</tr>
		<tr>
		     <td width="100" height="30" align="right" >&nbsp;</td>
		     <td width="5" >&nbsp;</td>
		     <td height="30" ><div id="shoppages"></div>
		       <input  type='submit' name='modi' value='<?php echo $strShopUpload;?>' class='savebutton' style="display:none;" />
		       </td>
        </tr>
      </table>
      		   
		 <!--附圖上傳 STR-->
		 <!--table width="100%"   border="0" align="center"  cellpadding="2" cellspacing="0"  class="shopmodizone">
	  <tr>
      <td width="100" height="30" align="right" ><?php echo $strShopAddImg_Main;?></td>
      <td width="5" >&nbsp;</td>
      <td height="30" ><input type="file" name="jpg_body" class="input" style="WIDTH: 499px;" />          
<span class="style1"> </span> </td>
	  </tr>
	  	<tr>
		     <td align="right" ></td>
		     <td width="5" >&nbsp;</td>
		     <td ><img id="picpriview_body" src="images/loading.gif" style="max-width:160px;"/></td>
		</tr>
</table-->
<script src="../../kedit/kindeditor_up.js?2"></script>
<script charset="utf-8" src="../../kedit/lang/zh_TW_SHOP.js"></script>
         <table class="shopmodizone" width="100%"   border="0" align="center"  cellpadding="2" cellspacing="0" >
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
		<?php echo $desciptionLimts; ?>
		</ul>
       </td>
    </tr>



      </table>
<table width="100%"   border="0" align="center"  cellpadding="2" cellspacing="0" class="shopmodizone">
	<tr>
		<td width="100" height="30" align="right" ><?php echo $strShopAddImg_Shape;?></td>
		<td width="5" >&nbsp;</td>
		<td height="30" ><input type="file" name="jpg_shape" class="input" style="WIDTH: 499px;" />          
				<span class="style1"> </span> 
		</td>
	</tr>
	<tr>
		<td align="right" ></td>
		<td width="5" >&nbsp;</td>
		<td ><img id="picpriview_shape" src="images/loading.gif" /></td>
	</tr>
	  <tr>
      <td width="100" height="30" align="right" ><?php echo $strShopAddImg_Features;?></td>
      <td width="5" >&nbsp;</td>
      <td height="30" ><input type="file" name="jpg_canshu" class="input" style="WIDTH: 499px;" />          
<span class="style1"> </span> </td>
	  </tr>
	   	<tr>
		     <td align="right" ></td>
		     <td width="5" >&nbsp;</td>
		     <td ><img id="picpriview_canshu" src="images/loading.gif" /></td>
		</tr>
    <tr style="display:none">
    <td align="right" >版型選擇</td>
    <td width="5" >&nbsp;</td>
    <td >
	<label><input type="radio" name="sizechoice" value="1" <?php if($size == 1) echo "checked"?>/>緊身版型(男)</label>
	<label><input type="radio" name="sizechoice" value="2" <?php if($size == 2) echo "checked"?>/>修身版型(男)</label>
	<label><input type="radio" name="sizechoice" value="3" <?php if($size == 3) echo "checked"?>/>寬鬆版型(男)</label>
	<label><input type="radio" name="sizechoice" value="4" <?php if($size == 4) echo "checked"?>/>緊身版型(女)</label>
	<label><input type="radio" name="sizechoice" value="5" <?php if($size == 5) echo "checked"?>/>修身版型(女)</label>
	<label><input type="radio" name="sizechoice" value="6" <?php if($size == 6) echo "checked"?>/>寬鬆版型(女)</label>
    </td>
    </tr>
	 <tr> 
      <td height="30" width="100" align="right" >商品屬性</td>
      <td width="5" >&nbsp;</td>
      <td height="30" >
    	<label><input type="radio" name="ifsub" value="0" class="input" <?php echo checked($ifsub,0);?> /> 主商品</label>
        <label><input type="radio" name="ifsub" value="1" class="input" <?php echo checked($ifsub,1);?> /> 附屬規格商品</label>
    		<select data-selsub="<?php if($ifpic=='0'){echo 'seltosub';}else{echo 'seltosubpic';}?>" class="selsub">
				<option value='0'>請選擇歸附的商品</option>
				<?php
				echo $ifsubcatlist;
				?>
              </select>
    	<span id="showselsub"><select name="subid"><?php echo $subidlist;?></select></span>
		<span class="style1">* </span> </td>
    </tr>
		<tr>
			<td colspan="3"><hr></td>
		</tr>
		<tr>
			<td width="100" height="30" align="right" >尺寸圖片顯示</td>
			<td width="5" >&nbsp;</td>
			<td height="30" >
				<label><input type="radio" name="usepicsize" value="0" <?php echo checked($usepicsize,'0'); ?> />否，使用建議尺寸程式 </label>
				<label><input type="radio" name="usepicsize" value="1" <?php echo checked($usepicsize,'1'); ?> />是，使用商品尺寸圖 </label>
			</td>
		</tr>
		<tr>
			<td width="100" height="30" align="right" >尺寸欄位</td>
			<td width="5" >&nbsp;</td>
			<td height="30" >
				<label><input type="checkbox" name="sizeitem_A" value="1" <?php echo checked($sizeitem_a,1);?> />胸圍(C) </label>
				<label><input type="checkbox" name="sizeitem_B" value="1" <?php echo checked($sizeitem_b,1);?> />腰圍(W) </label>
				<label><input type="checkbox" name="sizeitem_C" value="1" <?php echo checked($sizeitem_c,1);?> />臀圍(H) </label>
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
	if(in_array($vvs,$mainsizetype) && $bname_a!= "none"){
		echo '<label><input type="checkbox" name="mainsizetype[]" value="'.$vvs.'" checked/>'.$bname_a.'/'.$bname_b.'</label>&nbsp;&nbsp;&nbsp;';
	}elseif($bname_a!= "none"){
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
	if(in_array($vvs,$sizetype) && $bname_a!= "none"){
		echo '<label><input type="checkbox" name="sizetype[]" value="'.$vvs.'" checked/>'.$bname_a.'/'.$bname_b.'</label>&nbsp;&nbsp;&nbsp;';
	}elseif($bname_a!= "none"){
		echo '<label><input type="checkbox" name="sizetype[]" value="'.$vvs.'" />'.$bname_a.'/'.$bname_b.'</label>&nbsp;&nbsp;&nbsp;';
	}
	if($k%8==0){
		echo '<br>';
	}
	$k++;
}
?> (非必要選項)
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
							echo "<option value='".$fsql->f('id')."' ".seld($sizechart,$fsql->f('id')).">".$fsql->f('groupname')."</option>";
						}
					?>
				</select>
				若不選擇，則 男性/女性 商品自動使用 男性/女性 尺寸表
			</td>
		</tr>
		 </table>

  <!--附圖上傳 END-->
		 	   
         <table class="shopmodizone hidepic" width="100%"   border="0" align="center"  cellpadding="2" cellspacing="0" >
          <tr> 
            <td height="30" width="100" align="right" ><?php echo $strFbtime;?></td>
            <td width="5" >&nbsp;</td>
            <td height="30" ><?php echo $dtime;?></td>
          </tr>
          <tr> 
            <td height="30" width="100" align="right" ><?php echo $strUptime;?></td>
            <td width="5" >&nbsp;</td>
            <td height="30" ><?php echo $uptime;?> </td>
          </tr>
      </table>
	 
</div>  
	<!--多-->
	<div class="tablezone" id="tableb" style="display:none">
	<!-- 擷取語言表 -->
<?php
	$langlist = "";
	$msql->query( "SELECT * FROM {P}_base_language WHERE ifshow='1' AND ifdefault='0' ORDER BY xuhao asc" );
	while ( $msql->next_record( ) )
	{
		$lid = $msql->f( "id" );
		$ltitle = $msql->f( "title" );
		$langcode = $msql->f( "langcode" );
		$src = ROOTPATH.$msql->f( "src" );
		$langlist .= $langlist? ",".$langcode:$langcode;
		
		//依表擷取語言檔內容
		$langs = $fsql->getone( "SELECT * FROM {P}_shop_con_translate WHERE pid='{$id}' AND langcode='{$langcode}'" );
?>
	<!-- 依表列出語言檔內容 -->
		<div class="namezone"><img src="<?php echo $src; ?>" height="20"/> <?php echo $ltitle; ?></div>
		<hr style="border: none; height: 1px; background:#ccc;">
	<table class="shopmodizone" width="100%" cellpadding="2" align="center"  border="0" cellspacing="0">
		<tr class="hidepic"> 
			<td height="30" width="100" align="right" ><?php echo $strShopAddTitle;?></td>
			<td width="5" >&nbsp;</td>
			<td height="30" > 
				<input type="text" name="stitle[<?php echo $langcode; ?>]" style='WIDTH: 499px;' maxlength="200" class="input" value="<?php echo $langs['title']; ?>" />
				<font color="#FF0000"></font>
			</td>
		</tr>
		<tr class="hidepic"> 
			<td height="30" width="100" align="right" ><?php echo $strShopMemo;?></td>
			<td width="5" >&nbsp;</td>
			<td height="30" > 
				<textarea name="smemo[<?php echo $langcode; ?>]" style="WIDTH: 499px;" class="textarea" rows="5"><?php echo $langs['memo'];?></textarea>
				<font color="#FF0000"></font>
			</td>
		</tr>
		<tr class="hidepic"> 
			<td height="30" width="100" align="right" >詳細說明</td>
			<td width="5" >&nbsp;</td>
			<td height="30" > 
				<textarea name="smemotext[<?php echo $langcode; ?>]" style="WIDTH: 499px;" class="textarea" rows="8"><?php echo stripslashes($langs['memotext']);?></textarea>
				<font color="#FF0000"></font>
			</td>
		</tr>
		<tr class="hidepic"> 
			<td height="30" width="100" align="right" >產品說明</td>
			<td width="5" >&nbsp;</td>
			<td height="30" > 
				<textarea name="sc_body[<?php echo $langcode; ?>]" style="WIDTH: 499px;" class="textarea" rows="8"><?php echo $langs['c_body']; ?></textarea>
				<font color="#FF0000"></font>
			</td>
		</tr>
		<tr class="hidepic"> 
			<td height="30" width="100" align="right" >配送&換貨/退貨<br>說明</td>
			<td width="5" >&nbsp;</td>
			<td height="30" > 
				<textarea name="safterSalesService[<?php echo $langcode; ?>]" style="WIDTH: 499px;" class="textarea" rows="8"><?php echo stripslashes($langs['after_sales_service']);?></textarea>
				<font color="#FF0000"></font>
			</td>
		</tr>
		<tr class="hidepic"> 
			<td height="30" width="100" align="right" >顏色名稱</td>
			<td width="5" >&nbsp;</td>
			<td height="30" > 
				<input type="text" name="scolorname[<?php echo $langcode; ?>]" style='WIDTH: 499px;' maxlength="200" class="input" value="<?php echo $langs['colorname']; ?>" />
				<font color="#FF0000"></font>
			</td>
		</tr>
		<!--tr>
			<td width="100" height="30" align="right" ><?php echo $strShopAddImg_Main;?></td>
			<td width="5" >&nbsp;</td>
			<td height="30" >
				<input type="file" name="sjpg_body[<?php echo $langcode; ?>]" class="input" style="WIDTH: 499px;" />
				<input type="hidden" name="oldbody[<?php echo $langcode; ?>]" value="<?php echo $langs[body]; ?>">
				<span class="style1"> </span>
			</td>
		</tr-->
		<!--tr>
		     <td align="right" ></td>
		     <td width="5" >&nbsp;</td>
		     <td ><img src="<?php echo ROOTPATH.$langs[body];?>" style="max-width:160px;"/></td>
		</tr-->
		<tr class="hidepic" style="display:none;"> 
			<td height="30" width="100" align="right" >手機版商品說明</td>
			<td >&nbsp;</td>
			<td height="30" >
				<textarea name="smbody[<?php echo $langcode; ?>]" id="smbody_<?php echo $langcode; ?>" style="width:680px;height:400px;visibility:hidden;"><?php echo $langs['mbody']; ?></textarea>
<script>
		KindEditor.ready(function(K) {
			var editor<?php echo $langcode; ?> = K.create('#smbody_<?php echo $langcode; ?>', {
				uploadJson : '../../kedit/php/upload_json.php?attachPath=shop/pics/',
				fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=shop/pics/',
				allowFlashUpload : false,
				allowMediaUpload : false,
				allowFileManager : true,
				langType : 'zh_TW',
				syncType: '',
				filterMode: false,
				afterBlur: function () { editor<?php echo $langcode; ?>.sync(); }

			});
});
</script>
			</td>
		</tr>
		<tr class="hidepic"> 
			<td height="30" width="100" align="right" >商品頂部輪播圖</td>
			<td >&nbsp;</td>
			<td height="30" >
				<textarea name="sa_body[<?php echo $langcode; ?>]" id="sa_body_<?php echo $langcode; ?>" style="width:680px;height:400px;visibility:hidden;"><?php echo $langs['a_body']; ?></textarea>
<script>
		KindEditor.ready(function(K) {
			var editor<?php echo $langcode; ?> = K.create('#sa_body_<?php echo $langcode; ?>', {
				uploadJson : '../../kedit/php/upload_json.php?attachPath=shop/pics/',
				fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=shop/pics/',
				allowFlashUpload : false,
				allowMediaUpload : false,
				allowFileManager : true,
				langType : 'zh_TW',
				syncType: '',
				filterMode: false,
				afterBlur: function () { editor<?php echo $langcode; ?>.sync(); }

			});
});
</script>
			</td>
		</tr>
		<tr class="hidepic"> 
			<td height="30" width="100" align="right" >商品中間輪圖文<br>(1150*767)</td>
			<td >&nbsp;</td>
			<td height="30" >
				<textarea name="sb_body[<?php echo $langcode; ?>]" id="sb_body_<?php echo $langcode; ?>" style="width:680px;height:400px;visibility:hidden;"><?php echo $langs['b_body']; ?></textarea>
<script>
		KindEditor.ready(function(K) {
			var editor<?php echo $langcode; ?> = K.create('#sb_body_<?php echo $langcode; ?>', {
				uploadJson : '../../kedit/php/upload_json.php?attachPath=shop/pics/',
				fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=shop/pics/',
				allowFlashUpload : false,
				allowMediaUpload : false,
				allowFileManager : true,
				langType : 'zh_TW',
				syncType: '',
				filterMode: false,
				afterBlur: function () { editor<?php echo $langcode; ?>.sync(); }

			});
});
</script>
			</td>
		</tr>
		
		<!--<tr class="hidepic"> 
			<td height="30" width="100" align="right" >商品說明<br />(右：保養)</td>
			<td >&nbsp;</td>
			<td height="30" >
				<textarea name="sd_body[<?php echo $langcode; ?>]" id="sd_body_<?php echo $langcode; ?>" style="width:680px;height:400px;visibility:hidden;"><?php echo $langs['d_body']; ?></textarea>
<script>
		KindEditor.ready(function(K) {
			var editor<?php echo $langcode; ?> = K.create('#sd_body_<?php echo $langcode; ?>', {
				uploadJson : '../../kedit/php/upload_json.php?attachPath=shop/pics/',
				fileManagerJson : '../../kedit/php/file_manager_json.php?attachPath=shop/pics/',
				allowFlashUpload : false,
				allowMediaUpload : false,
				allowFileManager : true,
				langType : 'zh_TW',
				syncType: '',
				filterMode: false,
				afterBlur: function () { editor<?php echo $langcode; ?>.sync(); }

			});
});
</script>
			</td>
		</tr>-->
		<!--tr>
			<td width="100" height="30" align="right" ><?php echo $strShopAddImg_Features;?></td>
			<td width="5" >&nbsp;</td>
			<td height="30" >
				<input type="file" name="sjpg_canshu[<?php echo $langcode; ?>]" class="input" style="WIDTH: 499px;" />
				<input type="hidden" name="oldcanshu[<?php echo $langcode; ?>]" value="<?php echo $langs[canshu]; ?>">
				<span class="style1"> </span>
			</td>
		</tr>
		<tr>
		     <td align="right" ></td>
		     <td width="5" >&nbsp;</td>
		     <td ><img src="<?php echo ROOTPATH.$langs[canshu];?>" style="max-width:160px;"/></td>
		</tr-->
	</table>
	
<?php
	}
?>
	
	</div> 
		
		
<div class="adminsubmit">
<input id="adminsubmit" type="submit" name="modi"  value="<?php echo $strSave;?>" class="button" />
<input type="hidden" id="act" name="act" value="shopmodify" />
<input type="hidden" id="nowid" name="id" value="<?php echo $id;?>" />
<input type="hidden" name="oldcatid" value="<?php echo $oldcatid;?>" />
<input type="hidden" name="oldcatpath" value="<?php echo $oldcatpath;?>" />
<input type="hidden" name="pid" value="<?php echo $pid;?>" />
<input type="hidden" name="page" value="<?php echo $page;?>" />
<input type="hidden" name="source" value="<?php echo $source;?>" />
<input type="hidden" name="author"  value="<?php echo $author;?>" />
<input type="hidden" name="sizeBefore"  value="<?=$size?>" />
<input type="hidden" id="langlist" name="langlist" value="<?php echo $langlist; ?>" />
</div> 
</div>
</form>
<div style="height:1000px;"></div>
<script>
$(document).ready(function() {
	$().getShopPages(0);
	$().getContent(0);
	$().getPropList();
	$().getCatRelBrand();
	$().getPriceList();
	<?php
	if($ifpic == "1"){
	?>
		$(".hidepic").hide();
	<?php
	}	
?>
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
			// console.log(li);
			$(this).find('input').attr("name", `desciption[${index}]`);
			$(this).find('textarea').attr("name", `desciption[${index}]`);
			$(this).find('input[data-method="img"]').attr(`name`, `desciption[${index}][img]`);
			
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
<script src="../../base/admin/assets/js/plugins/iframeautoheight/iframeResizer.contentWindow.min.js"></script>
</body>
</html>
