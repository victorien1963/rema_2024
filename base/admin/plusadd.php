<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/upload.inc.php" );
include( "func/plus.inc.php" );
needauth( 5 );
$plustype = $_REQUEST['plustype'];
$pluslocat = $_REQUEST['pluslocat'];
$pluslable = $_REQUEST['pluslable'];
$step = $_REQUEST['step'];
$modno = $_REQUEST['modno'];
if ( !isset( $modno ) || $modno == "" )
{
		$modno = 1;
}
if ( $step == "add" )
{
		//trylimit( "_base_plus", 800, "id" );
		$display = plusvalnone( $_POST['display'] );
		$showborder = $_POST['showborders'];
		$catid = $_POST['catid'];
		$plusname = $_POST['plusname'];
		$coltype = $_POST['coltype'];
		$width = $_POST['width'];
		$height = $_POST['height'];
		$top = $_POST['top'];
		$left = $_POST['left'];
		$zindex = $_POST['zindex'];
		$padding = $_POST['padding'];
		$tempname = $_POST['tempname'];
		$tempcolor = $_POST['tempcolor'];
		$title = htmlspecialchars( $_POST['title'] );
		$cutbody = $_POST['cutbody'];
		$shownums = $_POST['shownums'];
		$ord = $_POST['ord'];
		$sc = $_POST['sc'];
		$showtj = $_POST['showtj'];
		$cutword = $_POST['cutword'];
		$target = $_POST['target'];
		$body = $_POST['body'];
		$code = $_POST['code'];
		$movi = htmlspecialchars( $_POST['movi'] );
		$text = htmlspecialchars( $_POST['text'] );
		$link = htmlspecialchars( $_POST['link'] );
		$piclink = htmlspecialchars( $_POST['piclink'] );
		$word = htmlspecialchars( $_POST['word'] );
		$word1 = htmlspecialchars( $_POST['word1'] );
		$word2 = htmlspecialchars( $_POST['word2'] );
		$word3 = htmlspecialchars( $_POST['word3'] );
		$word4 = htmlspecialchars( $_POST['word4'] );
		$text1 = htmlspecialchars( $_POST['text1'] );
		$link1 = htmlspecialchars( $_POST['link1'] );
		$link2 = htmlspecialchars( $_POST['link2'] );
		$link3 = htmlspecialchars( $_POST['link3'] );
		$link4 = htmlspecialchars( $_POST['link4'] );
		$tags = htmlspecialchars( $_POST['tags'] );
		$sourceurl = htmlspecialchars( $_POST['sourceurl'] );
		$borderlable = htmlspecialchars( $_POST['borderlable'] );
		$borderroll = $_POST['borderroll'];
		$picw = $_POST['picw'];
		$pich = $_POST['pich'];
		$fittype = $_POST['fittype'];
		$groupid = $_POST['groupid'];
		$projid = $_POST['projid'];
		$overflow = $_POST['overflow'];
		$bodyzone = $_POST['bodyzone'];
		$bordercolor = $_POST['bordercolor'];
		$backgroundcolor = $_POST['backgroundcolor'];
		$borderwidth = $_POST['borderwidth'];
		$borderstyle = $_POST['borderstyle'];
		$showbar = $_POST['showbar'];
		$barbg = $_POST['barbg'];
		$barcolor = $_POST['barcolor'];
		$morelink = htmlspecialchars( $_POST['morelink'] );
		$body = url2path( $body );
		$uppic = $_FILES['jpg'];
		$upatt = $_FILES['att'];
		if ( 0 < $uppic['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$picpath = "../../diy/pics/".$nowdate;
				@mkdir( $picpath, 511 );
				$uppath = "diy/pics/".$nowdate;
				$arr = newuploadimage( $uppic['tmp_name'], $uppic['type'], $uppic['size'], $uppath );
				$pic = $arr[3];
				$oldsrc = plusvalsel( $_POST['pic'] );
				if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && $oldsrc != "0" && !strstr( $oldsrc, "../" ) && !strstr( $oldsrc, "http://" ) )
				{
						@unlink( ROOTPATH.$oldsrc );
				}
		}
		else
		{
				$pic = $_POST['pic'];
		}
		if ( 0 < $upatt['size'] )
		{
				$nowdate = date( "Ymd", time( ) );
				$attpath = "../../diy/attach/".$nowdate;
				@mkdir( $attpath, 511 );
				$uppath = "diy/attach/".$nowdate;
				$arr = newuploadfile( $upatt['tmp_name'], $upatt['type'], $upatt['name'], $upatt['size'], $uppath );
				$attach = $arr[3];
				$oldsrc = plusvalsel( $_POST['attach'] );
				if ( file_exists( ROOTPATH.$oldsrc ) && $oldsrc != "" && $oldsrc != "0" && !strstr( $oldsrc, "../" ) && !strstr( $oldsrc, "http://" ) )
				{
						@unlink( ROOTPATH.$oldsrc );
				}
		}
		else
		{
				$attach = $_POST['attach'];
		}
		if ( !isset( $_POST['setglobal'] ) || $_POST['setglobal'] == "" || $_POST['setglobal'] == "0" )
		{
				$fsql->query( "insert into {P}_base_plus set 
	`coltype`='{$coltype}',
	`plusname`='{$plusname}',
	`display`='{$display}',
	`pluslable`='{$pluslable}',
	`pluslocat`='{$pluslocat}',
	`plustype`='{$plustype}',
	`tempname`='{$tempname}',
	`tempcolor`='{$tempcolor}',
	`title`='{$title}',
	`showborder`='{$showborder}',
	`bordercolor`='{$bordercolor}',
	`backgroundcolor`='{$backgroundcolor}',
	`borderwidth`='{$borderwidth}',
	`borderstyle`='{$borderstyle}',
	`borderlable`='{$borderlable}',
	`borderroll`='{$borderroll}',
	`showbar`='{$showbar}',
	`barbg`='{$barbg}',
	`barcolor`='{$barcolor}',
	`morelink`='{$morelink}',
	`width`='{$width}',
	`height`='{$height}',
	`top`='{$top}',
	`left`='{$left}',
	`zindex`='{$zindex}',
	`padding`='{$padding}',
	`cutbody`='{$cutbody}',
	`picw`='{$picw}',
	`pich`='{$pich}',
	`fittype`='{$fittype}',
	`shownums`='{$shownums}',
	`ord`='{$ord}',
	`sc`='{$sc}',
	`showtj`='{$showtj}',
	`cutword`='{$cutword}',
	`target`='{$target}',
	`catid`='{$catid}',
	`body`='{$body}',
	`pic`='{$pic}',
	`attach`='{$attach}',
	`movi`='{$movi}',
	`sourceurl`='{$sourceurl}',
	`text`='{$text}',
	`link`='{$link}',
	`piclink`='{$piclink}',
	`word`='{$word}',
	`word1`='{$word1}',
	`word2`='{$word2}',
	`word3`='{$word3}',
	`word4`='{$word4}',
	`text1`='{$text1}',
	`code`='{$code}',
	`link1`='{$link1}',
	`link2`='{$link2}',
	`link3`='{$link3}',
	`link4`='{$link4}',
	`tags`='{$tags}',
	`groupid`='{$groupid}',
	`projid`='{$projid}',
	`overflow`='{$overflow}',
	`bodyzone`='{$bodyzone}',
	`modno`='{$modno}'


	" );
				$plusid = $fsql->instid( );
		}
		if ( $_POST['setglobal'] == "1" )
		{
				$msql->query( "delete from {P}_base_plus where pluslable='{$pluslable}'" );
				$msql->query( "select * from {P}_base_pageset" );
				while ( $msql->next_record( ) )
				{
						$plustype = $msql->f( "coltype" );
						$pluslocat = $msql->f( "pagename" );
						$fsql->query( "insert into {P}_base_plus set 
		`coltype`='{$coltype}',
		`plusname`='{$plusname}',
		`display`='{$display}',
		`pluslable`='{$pluslable}',
		`pluslocat`='{$pluslocat}',
		`plustype`='{$plustype}',
		`tempname`='{$tempname}',
		`tempcolor`='{$tempcolor}',
		`title`='{$title}',
		`showborder`='{$showborder}',
		`bordercolor`='{$bordercolor}',
		`backgroundcolor`='{$backgroundcolor}',
		`borderwidth`='{$borderwidth}',
		`borderstyle`='{$borderstyle}',
		`borderlable`='{$borderlable}',
		`borderroll`='{$borderroll}',
		`showbar`='{$showbar}',
		`barbg`='{$barbg}',
		`barcolor`='{$barcolor}',
		`morelink`='{$morelink}',
		`width`='{$width}',
		`height`='{$height}',
		`top`='{$top}',
		`left`='{$left}',
		`zindex`='{$zindex}',
		`padding`='{$padding}',
		`cutbody`='{$cutbody}',
		`picw`='{$picw}',
		`pich`='{$pich}',
		`fittype`='{$fittype}',
		`shownums`='{$shownums}',
		`ord`='{$ord}',
		`sc`='{$sc}',
		`showtj`='{$showtj}',
		`cutword`='{$cutword}',
		`target`='{$target}',
		`catid`='{$catid}',
		`body`='{$body}',
		`pic`='{$pic}',
		`attach`='{$attach}',
		`movi`='{$movi}',
		`sourceurl`='{$sourceurl}',
		`text`='{$text}',
		`link`='{$link}',
		`piclink`='{$piclink}',
		`word`='{$word}',
		`word1`='{$word1}',
		`word2`='{$word2}',
		`word3`='{$word3}',
		`word4`='{$word4}',
		`text1`='{$text1}',
		`code`='{$code}',
		`link1`='{$link1}',
		`link2`='{$link2}',
		`link3`='{$link3}',
		`link4`='{$link4}',
		`tags`='{$tags}',
		`groupid`='{$groupid}',
		`projid`='{$projid}',
		`overflow`='{$overflow}',
		`bodyzone`='{$bodyzone}',
		`modno`='{$modno}'
		" );
						if ( $plustype == $_REQUEST['plustype'] && $pluslocat == $_REQUEST['pluslocat'] )
						{
								$plusid = $fsql->instid( );
						}
				}
		}
		if ( $_POST['ifrefresh'] == "1" )
		{
				echo "<script>parent.location.reload()</script>";
				exit( );
		}
		else
		{
				echo "<script>parent.\$().plusAddBack('pdv_".$plusid."','".$bodyzone."');parent.\$.unblockUI()</script>";
				exit( );
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
<script type="text/javascript" src="js/plus.js"></script>
</head>
<body >

<?php
$msql->query( "select * from {P}_base_plusdefault where  pluslable='{$pluslable}'" );
if ( $msql->next_record( ) )
{
		$set_plusname = $msql->f( "plusname" );
		$set_tempname = $msql->f( "tempname" );
		$set_tempcolor = $msql->f( "tempcolor" );
		$set_showborder = $msql->f( "showborder" );
		$set_width = $msql->f( "width" );
		$set_height = $msql->f( "height" );
		$set_top = $msql->f( "top" );
		$set_left = $msql->f( "left" );
		$set_zindex = $msql->f( "zindex" );
		$set_padding = $msql->f( "padding" );
		$set_shownums = $msql->f( "shownums" );
		$set_ord = $msql->f( "ord" );
		$set_sc = $msql->f( "sc" );
		$set_showtj = $msql->f( "showtj" );
		$set_cutword = $msql->f( "cutword" );
		$set_target = $msql->f( "target" );
		$set_catid = $msql->f( "catid" );
		$set_cutbody = $msql->f( "cutbody" );
		$set_picw = $msql->f( "picw" );
		$set_pich = $msql->f( "pich" );
		$set_fittype = $msql->f( "fittype" );
		$set_title = $msql->f( "title" );
		$set_body = $msql->f( "body" );
		$set_pic = $msql->f( "pic" );
		$set_attach = $msql->f( "attach" );
		$set_movi = $msql->f( "movi" );
		$set_text = $msql->f( "text" );
		$set_link = $msql->f( "link" );
		$set_piclink = $msql->f( "piclink" );
		$set_word = $msql->f( "word" );
		$set_word1 = $msql->f( "word1" );
		$set_word2 = $msql->f( "word2" );
		$set_word3 = $msql->f( "word3" );
		$set_word4 = $msql->f( "word4" );
		$set_text1 = $msql->f( "text1" );
		$set_code = $msql->f( "code" );
		$set_link1 = $msql->f( "link1" );
		$set_link2 = $msql->f( "link2" );
		$set_link3 = $msql->f( "link3" );
		$set_link4 = $msql->f( "link4" );
		$set_tags = $msql->f( "tags" );
		$set_sourceurl = $msql->f( "sourceurl" );
		$set_groupid = $msql->f( "groupid" );
		$set_projid = $msql->f( "projid" );
		$set_setglobal = $msql->f( "setglobal" );
		$set_display = $msql->f( "display" );
		$set_overflow = $msql->f( "overflow" );
		$set_bodyzone = $msql->f( "bodyzone" );
		$set_bordercolor = $msql->f( "bordercolor" );
		$set_backgroundcolor = $msql->f( "backgroundcolor" );
		$set_borderwidth = $msql->f( "borderwidth" );
		$set_borderstyle = $msql->f( "borderstyle" );
		$set_borderlable = $msql->f( "borderlable" );
		$set_borderroll = $msql->f( "borderroll" );
		$set_showbar = $msql->f( "showbar" );
		$set_barbg = $msql->f( "barbg" );
		$set_barcolor = $msql->f( "barcolor" );
		$set_morelink = $msql->f( "morelink" );
		$classtbl = $msql->f( "classtbl" );
		$grouptbl = $msql->f( "grouptbl" );
		$projtbl = $msql->f( "projtbl" );
		$ifrefresh = $msql->f( "ifrefresh" );
		$coltype = $msql->f( "coltype" );
}
$plusname = $set_plusname;
$tempname = $set_tempname;
$tempcolor = $set_tempcolor;
$title = $set_title;
$shownums = $set_shownums;
$ord = $set_ord;
$sc = $set_sc;
$showtj = $set_showtj;
$showborder = $set_showborder;
$width = $set_width;
$height = $set_height;
$top = $set_top;
$left = $set_left;
$zindex = $set_zindex;
$padding = $set_padding;
$cutbody = $set_cutbody;
$picw = $set_picw;
$pich = $set_pich;
$fittype = $set_fittype;
$cutword = $set_cutword;
$target = $set_target;
$catid = $set_catid;
$body = $set_body;
$pic = $set_pic;
$attach = $set_attach;
$text = $set_text;
$movi = $set_movi;
$link = $set_link;
$sourceurl = $set_sourceurl;
$piclink = $set_piclink;
$word = $set_word;
$word1 = $set_word1;
$word2 = $set_word2;
$word3 = $set_word3;
$word4 = $set_word4;
$text1 = $set_text1;
$code = $set_code;
$link1 = $set_link1;
$link2 = $set_link2;
$link3 = $set_link3;
$link4 = $set_link4;
$tags = $set_tags;
$groupid = $set_groupid;
$projid = $set_projid;
$display = $set_display;
$overflow = $set_overflow;
$bodyzone = $set_bodyzone;
$bordercolor = $set_bordercolor;
$backgroundcolor = $set_backgroundcolor;
$borderwidth = $set_borderwidth;
$borderstyle = $set_borderstyle;
$borderlable = $set_borderlable;
$borderroll = $set_borderroll;
$showbar = $set_showbar;
$barbg = $set_barbg;
$barcolor = $set_barcolor;
$morelink = $set_morelink;
$body = htmlspecialchars( $body );
?>
 
<form action="plusadd.php" method="post" enctype="multipart/form-data" name="form" style="margin:0px">
<div class="scrollex">
<div class="adminnav" >
<div style="float:right;display:inline;color:#666;font:12px/18px Arial"><?php echo $strPlusLable." - ".$pluslable; ?></div>
	
<?php
$msql->query( "select * from {P}_base_pageset where coltype='{$plustype}' and  pagename='{$pluslocat}'" );
if ( $msql->next_record( ) )
{
		$pagename = $msql->f( "name" );
}
echo $strPlusSetup." &gt; ".$pagename." &gt; ".$set_plusname;
?>
</div>
<div class="scrollzone">
<div id="setborder" class="pluszone"><?php echo $strPlusZone2; ?></div>
	<div id="s_setborder"  class="pluszonex">
<div class="setupborder">
		<div class="bordersettype">
		<input name="usetemp" type="checkbox" id="usetemp" value="1" /><?php echo $strBorderType1; ?>&nbsp;
		<input name="usediy" type="checkbox" id="usediy" value="1" /><?php echo $strBorderType2; ?>&nbsp; &nbsp;
			<span id="hiddenpborder"><?php echo $strPlusBarHidden; ?></span>
	  </div>	
	<div id="bordtempzone" class="bordtempzone"></div>	
    <table border="0" cellspacing="0" cellpadding="2" id="diyborder">
            <tr > 
              <td width="70"><?php echo $strPlusBP; ?></td>
              <td width="70" >			  
<select name="borderwidth" id="borderwidth" >
			 <option value="0" <?php echo seld( $borderwidth, "0" ); ?>>0px</option>
			 <option value="1" <?php echo seld( $borderwidth, "1" ); ?>>1px</option>
			 <option value="2" <?php echo seld( $borderwidth, "2" ); ?>>2px</option>
			 <option value="3" <?php echo seld( $borderwidth, "3" ); ?>>3px</option>
			 <option value="4" <?php echo seld( $borderwidth, "4" ); ?>>4px</option>
			 <option value="5" <?php echo seld( $borderwidth, "5" ); ?>>5px</option>
			 <option value="6" <?php echo seld( $borderwidth, "6" ); ?>>6px</option>
			 <option value="7" <?php echo seld( $borderwidth, "7" ); ?>>7px</option>
			 <option value="8" <?php echo seld( $borderwidth, "8" ); ?>>8px</option>
			 <option value="9" <?php echo seld( $borderwidth, "9" ); ?>>9px</option>
			 <option value="10" <?php echo seld( $borderwidth, "10" ); ?>>10px</option>
		</select>
		</td>
            <td width="70" ><?php echo $strPlusBorderColor; ?></td>
              <td width="60" ><input  type="text" id="bordercolor" class="selcolor" style="background:<?php echo $bordercolor; ?>" name="bordercolor" size="7"   maxlength="7" value="<?php echo $bordercolor; ?>" /></td>
            </tr>
            <tr >
              <td width="70"><?php echo $strPlusBorderStyle; ?></td>
              <td width="70" >			  	
<select name="borderstyle" id="borderstyle" >
                  <option value="solid" <?php echo seld( $borderstyle, "solid" ); ?>><?php echo $strPlusBs1; ?></option>
                  <option value="dashed" <?php echo seld( $borderstyle, "dashed" ); ?>><?php echo $strPlusBs2; ?></option>
                  <option value="dotted" <?php echo seld( $borderstyle, "dotted" ); ?>><?php echo $strPlusBs3; ?></option>
                  <option value="double" <?php echo seld( $borderstyle, "double" ); ?>><?php echo $strPlusBs4; ?></option>
                </select></td>
              <td width="70" ><?php echo $strPlusBG; ?></td>
              <td width="60" ><input id="backgroundcolor" class="selcolor" name="backgroundcolor"  style="background:<?php echo $backgroundcolor; ?>
" type="text" value="<?php echo $backgroundcolor; ?>" size="7"  maxlength="7" /></td>
            </tr>
            <tr >
              <td width="70"><?php echo $strPlusBar; ?></td>
              <td width="70" ><select name="showbar" id="showbar" >
                <option value="block" <?php echo seld( $showbar, "block" ); ?>><?php echo $strShow; ?></option>
                <option value="none" <?php echo seld( $showbar, "none" ); ?>><?php echo $strHidden; ?></option>
              </select></td>
              <td width="70" ><?php echo $strPlusBarGg; ?></td>
              <td width="60" ><input  id="barbg" class="selcolor" style="background:<?php echo $barbg; ?>" type="text" name="barbg" size="7"  maxlength="7" value="<?php echo $barbg; ?>" /></td>
            </tr>
            <tr >
              <td width="70">&nbsp;</td>
              <td width="70" >&nbsp;</td>
              <td width="70" ><?php echo $strPlusBarColor; ?></td>
              <td width="60" ><input  id="barcolor" class="selcolor" style="background:<?php echo $barcolor; ?>" type="text" name="barcolor" size="7"  maxlength="7" value="<?php echo $barcolor; ?>" /></td>
            </tr>
		</table>
		
		<div id="bordertempcoloropt" class="bordertempcoloropt">
	<li id="btsel_A" class="tempcoloropt" style="background:#2266aa"></li>
	<li id="btsel_B" class="tempcoloropt" style="background:#0099cc"></li>
	<li id="btsel_C" class="tempcoloropt" style="background:#20b747"></li>
	<li id="btsel_D" class="tempcoloropt" style="background:#009999"></li>
	<li id="btsel_E" class="tempcoloropt" style="background:#bbbbbb"></li>
	<li id="btsel_F" class="tempcoloropt" style="background:#666666"></li>
	<li id="btsel_G" class="tempcoloropt" style="background:#ff6600"></li>
	<li id="btsel_H" class="tempcoloropt" style="background:#ff9900"></li>
	<li id="btsel_I" class="tempcoloropt" style="background:#ffcc00"></li>
	<li id="btsel_J" class="tempcoloropt" style="background:#886640"></li>
	<li id="btsel_K" class="tempcoloropt" style="background:#EE0000"></li>
	<li id="btsel_L" class="tempcoloropt" style="background:#ff77cc"></li>
	<li id="btsel_M" class="tempcoloropt" style="background:#E10055"></li>
	<li id="btsel_N" class="tempcoloropt" style="background:#446d8c"></li>
	<li id="btsel_O" class="tempcoloropt" style="background:#c677ee"></li>
	<li id="btsel_P" class="tempcoloropt" style="background:#92c300"></li>
	</div>	
		<div id="colorSelector"></div>
		<div id="borderlablezone"><?php echo $strPlusLableNo; ?>
		<input name="borderlable"  type="text" class="input" id="borderlable" style="width:150px"  value="<?php echo $borderlable; ?>" maxlength="150" />		
<select name="borderroll" id="borderroll" >
                   <option value="click" <?php echo seld( $borderroll, "click" ); ?>><?php echo $strPlusLablerolll; ?></option>
                   <option value="over"  <?php echo seld( $borderroll, "over" ); ?>><?php echo $strPlusLableroll2; ?></option>
				   <option value="auto"  <?php echo seld( $borderroll, "auto" ); ?>><?php echo $strPlusLableroll3; ?></option>
         </select>
		</div>			
	</div>
		<div class="previewout">
		<div id="previewborder" class="previewborder"></div>
		</div>
	    <input  type="hidden" id="showborders" name="showborders" value="<?php echo $showborder; ?>" />
		<input  type="hidden" id="seledbordertemp" name="seledbordertemp" value="<?php echo $showborder; ?>" />				
	</div>
	
	<div id="settemplate" class="pluszone"><?php echo $strPlusZone1; ?></div>
	<div id="s_settemplate"  class="pluszonex">
	<div class="setupplustemp">
		<div id="plustempzone" class="plustempzone"></div>
	</div>
		
		<div id="plustempcoloropt" class="plustempcoloropt">
		<li id="ptsel_A" class="ptempcoloropt" style="background:#2266aa"></li>
		<li id="ptsel_B" class="ptempcoloropt" style="background:#0099cc"></li>
		<li id="ptsel_C" class="ptempcoloropt" style="background:#20b747"></li>
		<li id="ptsel_D" class="ptempcoloropt" style="background:#009999"></li>
		<li id="ptsel_E" class="ptempcoloropt" style="background:#bbbbbb"></li>
		<li id="ptsel_F" class="ptempcoloropt" style="background:#666666"></li>
		<li id="ptsel_G" class="ptempcoloropt" style="background:#ff6600"></li>
		<li id="ptsel_H" class="ptempcoloropt" style="background:#ff9900"></li>
		<li id="ptsel_I" class="ptempcoloropt" style="background:#ffcc00"></li>
		<li id="ptsel_J" class="ptempcoloropt" style="background:#886640"></li>
		<li id="ptsel_K" class="ptempcoloropt" style="background:#EE0000"></li>
		<li id="ptsel_L" class="ptempcoloropt" style="background:#ff77cc"></li>
		<li id="ptsel_M" class="ptempcoloropt" style="background:#E10055"></li>
		<li id="ptsel_N" class="ptempcoloropt" style="background:#446d8c"></li>
		<li id="ptsel_O" class="ptempcoloropt" style="background:#c677ee"></li>
		<li id="ptsel_P" class="ptempcoloropt" style="background:#92c300"></li>
		</div>
	
	
			<input type="hidden" id="tempname" name="tempname"  value="<?php echo $tempname; ?>" class="input" />
			<input type="hidden" id="set_tempname" name="stn" value="<?php echo $set_tempname; ?>" />
            <input type="hidden" id="tempcolor" name="tempcolor"  value="<?php echo $tempcolor; ?>" class="input" />	
	</div>
	
	
	
	<div id="setcanshu" class="pluszone"><?php echo $strPlusZone3; ?></div>
	<div id="s_setcanshu"  class="pluszonex">	
		<table width="600" border="0" cellspacing="0" cellpadding="5">			
			 <tr >
                 <td><?php echo $strPlusTitle; ?></td>
                 <td ><input type="text" id="coltitle"  name="title" size="30"  maxlength="30" value="<?php echo $title; ?>" class="input" /></td>
		       </tr>
			   <tr <?php echo plustrdis( $set_morelink ); ?>>
                 <td><?php echo $strPlusMoreLink; ?></td>
                 <td ><input type="text" name="morelink" size="39" value="<?php echo $morelink; ?>" class="input" /></td>
		       </tr>
            <tr >
              <td><?php echo $strPlusPadding; ?></td>
              <td >
<select name="padding" id="padding" >
                <option value="0"  <?php echo seld( $padding, "0" ); ?>>0px</option>
                <option value="1"  <?php echo seld( $padding, "1" ); ?>>1px</option>
                <option value="2"  <?php echo seld( $padding, "2" ); ?>>2px</option>
                <option value="3"  <?php echo seld( $padding, "3" ); ?>>3px</option>
                <option value="4"  <?php echo seld( $padding, "4" ); ?>>4px</option>
                <option value="5"  <?php echo seld( $padding, "5" ); ?>>5px</option>
                <option value="6"  <?php echo seld( $padding, "6" ); ?>>6px</option>
                <option value="7"  <?php echo seld( $padding, "7" ); ?>>7px</option>
                <option value="8"  <?php echo seld( $padding, "8" ); ?>>8px</option>
                <option value="9"  <?php echo seld( $padding, "9" ); ?>>9px</option>
                <option value="10"  <?php echo seld( $padding, "10" ); ?>>10px</option>
                <option value="12"  <?php echo seld( $padding, "12" ); ?>>12px</option>
                <option value="15"  <?php echo seld( $padding, "15" ); ?>>15px</option>
                <option value="20"  <?php echo seld( $padding, "20" ); ?>>20px</option>
                <option value="25"  <?php echo seld( $padding, "25" ); ?>>25px</option>
                <option value="30"  <?php echo seld( $padding, "30" ); ?>>30px</option>
                <option value="35"  <?php echo seld( $padding, "35" ); ?>>35px</option>
                <option value="50"  <?php echo seld( $padding, "50" ); ?>>50px</option>
              </select></td>
            </tr>			
			
			<tr >
			   <td><?php echo $strPlusFlow; ?></td>
			   <td >
<select name="overflow" id="overflow"  style="">
                   <option value="hidden" <?php echo seld( $overflow, "hidden" ); ?>><?php echo $strPlusFlow1; ?></option>
                   <option value="visible"  <?php echo seld( $overflow, "visible" ); ?>><?php echo $strPlusFlow2; ?></option>
                 </select>
	           </td>
			 </tr>

			<tr  <?php echo plustrdis( $set_showtj ); ?>>
			  <td><?php echo $strPlusShowTj; ?></td>
			  <td >			  
<select name="showtj" >
                <option value="0" <?php echo seld( $showtj, "0" ); ?>><?php echo $strPlusShowTj0; ?></option>
                <option value="1" <?php echo seld( $showtj, "1" ); ?>><?php echo $strPlusShowTj1; ?></option>
              </select>
			  </td>
		  </tr>
		  <tr  <?php echo plustrdis( $set_ord ); ?>>
			  <td><?php echo $strPlusord; ?></td>
			  <td >			  
<select name="ord" >			  	 
<?php
if ( strstr( $set_ord, "|" ) )
{
		$ordArr = explode( "|", $set_ord );
		
		for ( $r = 0;	$r < sizeof( $ordArr );	$r++	)
		{
				echo "<option value='".$ordArr[$r]."'>".$ordArr[$r]."</option>";
		}
}
else
{
		echo "<option value='id'>id</option>";
}
?>
			  <option value="RAND()">rand</option>
              </select>
			  </td>
		  </tr>
		  <tr  <?php echo plustrdis( $set_sc ); ?>>
			  <td><?php echo $strPlussc; ?></td>
			  <td >			  
<select name="sc" >
                <option value="desc" <?php echo seld( $sc, "desc" ); ?>><?php echo $strPlussc1; ?></option>
				 <option value="asc" <?php echo seld( $sc, "asc" ); ?>><?php echo $strPlussc2; ?></option>
              </select>
			  </td>
		  </tr>
			<tr <?php echo plustrdis( $set_shownums ); ?>> 
              <td width="90"><?php echo $strPlusshownums; ?></td>
              <td >                 
                <input  type="text" name="shownums" size="3"  maxlength="3" value="<?php echo $shownums; ?>" class="input" />
              </td>
            </tr>			
			
			<tr  <?php echo plustrdis( $set_picw ); ?>> 
              <td width="90"><?php echo $strPlusPicW; ?></td>
              <td >                 
                <input  type="text" name="picw" size="3"  maxlength="3" value="<?php echo $picw; ?>">PX
              </td>
            </tr>			
			<tr  <?php echo plustrdis( $set_pich ); ?>> 
              <td width="90"><?php echo $strPlusPicH; ?></td>
              <td >                 
                <input  type="text" name="pich" size="3"  maxlength="3" value="<?php echo $pich; ?>">PX
              </td>
            </tr>			
			<tr  <?php echo plustrdis( $set_fittype ); ?>> 
              <td width="90"><?php echo $strPlusFitType; ?></td>
              <td >               
<select name="fittype" >
                  <option value="fill" <?php echo seld( $fittype, "fill" ); ?>><?php echo $strPlusFitType1; ?></option>
                  <option value="auto" <?php echo seld( $fittype, "auto" ); ?>><?php echo $strPlusFitType2; ?></option>
				  <option value="exp" <?php echo seld( $fittype, "exp" ); ?>><?php echo $strPlusFitType3; ?></option>
                </select> &nbsp; <?php echo $strPlusFitNtc; ?>
              </td>
            </tr>
            
           
           
            <tr  <?php echo plustrdis( $set_cutword ); ?>> 
              <td width="90"><?php echo $strPluscutword; ?></td>
              <td >                 
                <input type="text" name="cutword" size="3"  maxlength="3" value="<?php echo $cutword; ?>" class="input" /> 
              </td>
            </tr>
			 <tr  <?php echo plustrdis( $set_cutbody ); ?>> 
              <td width="90"><?php echo $strPlusCutBody; ?></td>
              <td >                 
                <input type="text" name="cutbody" size="3"  maxlength="3" value="<?php echo $cutbody; ?>" class="input" /> 
              </td>
            </tr>
			
			<tr  <?php echo plustrdis( $set_tags ); ?>> 
              <td width="90"><?php echo $strPlusTag; ?></td>
              <td >                 
                <input type="text" name="tags" size="10"  maxlength="20" value="<?php echo $tags; ?>" class="input" /> 
              </td>
            </tr>
            
            <tr  <?php echo plustrdis( $set_target ); ?>> 
              <td width="90"><?php echo $strPlustarget; ?></td>
              <td >                 
<select name="target"  style='WIDTH: 247px;'>
                  <option value="_self" <?php echo seld( $target, "_self" ); ?>><?php echo $strSelf; ?></option>
                  <option value="_blank" <?php echo seld( $target, "_blank" ); ?>><?php echo $strBlank; ?></option>
                </select>
              </td>
            </tr>
			
			<tr  <?php echo plustrdis( $set_pic ); ?>> 
              <td width="90"><?php echo $strPlusPic; ?></td>
              <td >
			   <input name="jpg" type="file" id="jpg" style='WIDTH:300px;' class="input" />
			   <input name="pic" type="hidden" id="pic" value="<?php echo $pic; ?>">
              </td>
            </tr>			
			<tr  <?php echo plustrdis( $set_attach ); ?>> 
              <td width="90"><?php echo $strPlusAttach; ?></td>
              <td >
			   <input name="att" type="file" id="att" style='WIDTH:300px;' class="input" />
			   <input name="attach" type="hidden" id="attach" value="<?php echo $attach; ?>">
              </td>
            </tr>			
			<tr  <?php echo plustrdis( $set_piclink ); ?>> 
              <td width="90"><?php echo $strPlusPicLink; ?></td>
              <td>
			   <input name="piclink" type="input" class="input" id="piclink" style='WIDTH: 320px;' value="<?php echo $piclink; ?>" >
              </td>
            </tr>			
			<tr  <?php echo plustrdis( $set_movi ); ?>> 
              <td width="90"><?php echo $strPlusMovi; ?></td>
              <td >
			   <textarea name="movi" rows="5" class="textarea" id="movi" style="WIDTH: 320px;" ><?php echo $movi; ?></textarea>
              </td>
            </tr>			
			<tr  <?php echo plustrdis( $set_word ); ?>> 
              <td width="90"><?php echo $strPlusWord; ?></td>
              <td >
			   <input name="word" type="text" class="input" id="word" style='WIDTH: 320px;' value="<?php echo $word; ?>" >
              </td>
            </tr>			
			<tr  <?php echo plustrdis( $set_link ); ?>> 
              <td width="90"><?php echo $strPlusLink; ?></td>
              <td>
			   <input name="link" type="text" class="input" id="link" style='WIDTH: 320px;' value="<?php echo $link; ?>" >
              </td>
            </tr>			
			<tr  <?php echo plustrdis( $set_text ); ?>> 
              <td width="90"><?php echo $strPlusText; ?></td>
              <td >
			    <textarea name="text" rows="5" class="textarea" id="text" style="WIDTH: 320px;" ><?php echo $text; ?></textarea>
              </td>
            </tr>
			
			
			
			<tr  <?php echo plustrdis( $set_word1 ); ?>> 
              <td width="90"><?php echo $strPlusWord; ?></td>
              <td >
			   <input name="word1" type="text" class="input" id="word1" style='WIDTH: 320px;' value="<?php echo $word1; ?>" >
              </td>
            </tr>
			
			<tr  <?php echo plustrdis( $set_link1 ); ?>> 
              <td width="90"><?php echo $strPlusLink; ?></td>
              <td>
			   <input name="link1" type="text" class="input" id="link1" style='WIDTH: 320px;' value="<?php echo $link1; ?>" >
              </td>
            </tr>
			
			<tr  <?php echo plustrdis( $set_text1 ); ?>> 
              <td width="90"><?php echo $strPlusText; ?></td>
              <td >
			    <textarea name="text1" rows="5" class="textarea" id="text1" style="WIDTH: 320px;" ><?php echo $text1; ?></textarea>
              </td>
            </tr>
			
			
			
			<tr  <?php echo plustrdis( $set_word2 ); ?>> 
              <td width="90"><?php echo $strPlusWord; ?></td>
              <td >
			   <input name="word2" type="text" class="input" id="word2" style='WIDTH: 320px;' value="<?php echo $word2; ?>" >
              </td>
            </tr>
			
			<tr  <?php echo plustrdis( $set_link2 ); ?>> 
              <td width="90"><?php echo $strPlusLink; ?></td>
              <td>
			   <input name="link2" type="text" class="input" id="link2" style='WIDTH: 320px;' value="<?php echo $link2; ?>" >
              </td>
            </tr>

			
			
			
			<tr  <?php echo plustrdis( $set_word3 ); ?>> 
              <td width="90"><?php echo $strPlusWord; ?></td>
              <td >
			   <input name="word3" type="text" class="input" id="word3" style='WIDTH: 320px;' value="<?php echo $word3; ?>" >
              </td>
            </tr>
			
			<tr  <?php echo plustrdis( $set_link3 ); ?>> 
              <td width="90"><?php echo $strPlusLink; ?></td>
              <td>
			   <input name="link3" type="text" class="input" id="link3" style='WIDTH: 320px;' value="<?php echo $link3; ?>" >
              </td>
            </tr>
			
			<tr  <?php echo plustrdis( $set_word4 ); ?>> 
              <td width="90"><?php echo $strPlusWord; ?></td>
              <td >
			   <input name="word4" type="text" class="input" id="word4" style='WIDTH: 320px;' value="<?php echo $word4; ?>" >
              </td>
            </tr>
			
			<tr  <?php echo plustrdis( $set_link4 ); ?>> 
              <td width="90"><?php echo $strPlusLink; ?></td>
              <td>
			   <input name="link4" type="text" class="input" id="link4" style='WIDTH: 320px;' value="<?php echo $link4; ?>" >
              </td>
            </tr>
			
			<tr  <?php echo plustrdis( $set_code ); ?>> 
              <td width="90"><?php echo $strPlusCode; ?></td>
              <td >
			    <textarea name="code" rows="6" class="textarea" id="code" style="WIDTH: 500px;" ><?php echo $code; ?></textarea>
              </td>
            </tr>
						
            <tr  <?php echo plustrdis( $set_catid ); ?>> 
              <td width="90"><?php echo $strPluscatid; ?></td>
              <td> 


<?php
if ( $set_catid != "-1" )
{

		echo "<select name='catid' style='WIDTH:247px;' >
                  <option value=\"0\" ".seld( $catid, "0" ).">".$strPluscatidDef."</option>
                  ";
		$fsql->query( "select * from {P}".$classtbl." order by catpath" );
		while ( $fsql->next_record( ) )
		{
				$lpid = $fsql->f( "pid" );
				$lcatid = $fsql->f( "catid" );
				$cat = $fsql->f( "cat" );
				$catpath = $fsql->f( "catpath" );
				$lcatpath = explode( ":", $catpath );
				
				for ( $i = 0;	$i < sizeof( $lcatpath ) - 2;	$i++	)
				{
						$tsql->query( "select catid,cat from {P}".$classtbl." where catid='{$lcatpath[$i]}'" );
						if ( $tsql->next_record( ) )
						{
								$ncatid = $tsql->f( "cat" );
								$ncat = $tsql->f( "cat" );
								$ppcat .= $ncat."/";
						}
				}
				if ( $catid == $lcatid )
				{
						echo "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
				}
				else
				{
						echo "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
				}
				$ppcat = "";
		}
		echo " 
                </select>
";
}
?>
              </td>
            </tr>
			
			
<tr  <?php echo plustrdis( $set_groupid ); ?>> 
              <td width="90"><?php echo $strPlusGroup; ?></td>
              <td> 

<?php
if ( $set_groupid != "-1" )
{

		echo "<select name='groupid' style='WIDTH:247px;' >";
		$fsql->query( "select * from {P}".$grouptbl );
		while ( $fsql->next_record( ) )
		{
				$lgroupid = $fsql->f( "id" );
				$groupname = $fsql->f( "groupname" );
				if ( $groupid == $lgroupid )
				{
						echo "<option value='".$lgroupid."' selected>".$groupname."</option>";
				}
				else
				{
						echo "<option value='".$lgroupid."'>".$groupname."</option>";
				}
		}
		echo " 
                </select>
";
}
?>
              </td>
</tr>        
			
			
<tr  <?php echo plustrdis( $set_projid ); ?>> 
              <td width="90"><?php echo $strPlusProjid; ?></td>
              <td> 

<?php
if ( $set_projid != "-1" )
{

		echo "<select name='projid' style='WIDTH:247px;' >
				  <option value=\"0\" ".seld( $projid, "0" ).">".$strPlusProjDef."</option>";
		$fsql->query( "select * from {P}".$projtbl );
		while ( $fsql->next_record( ) )
		{
				$lprojid = $fsql->f( "id" );
				$project = $fsql->f( "project" );
				if ( $projid == $lprojid )
				{
						echo "<option value='".$lprojid."' selected>".$project."</option>";
				}
				else
				{
						echo "<option value='".$lprojid."'>".$project."</option>";
				}
		}
		echo " 
                </select>
";
}
?>
              </td>
</tr>   			
			<tr >
			  <td><?php echo $strPlusWei; ?></td>
			  <td >			  
<select name="bodyzone" id="bodyzone" >
                   <option value="top" <?php echo seld( $bodyzone, "top" ); ?>><?php echo $strPlusAddTo.$strPlusBodyZone1; ?></option>
                   <option value="content"  <?php echo seld( $bodyzone, "content" ); ?>><?php echo $strPlusAddTo.$strPlusBodyZone2; ?></option>
                   <option value="bottom"  <?php echo seld( $bodyzone, "bottom" ); ?>><?php echo $strPlusAddTo.$strPlusBodyZone3; ?></option>
                   <option value="bodyex"  <?php echo seld( $bodyzone, "bodyex" ); ?>><?php echo $strPlusAddTo.$strPlusBodyZone0; ?></option>
                 </select>
			  </td>
		  </tr>
			<tr >
			     <td><?php echo $strPlusSize; ?></td>
			     <td >
				<input name="width" size="3" maxlength="4" type="text" id="width"  class="input" value="<?php echo $width; ?>"  /> X 
				<input name="height"  size="3" maxlength="4" type="text" id="height"  class="input" value="<?php echo $height; ?>"  /> PX 
				 </td>
		       </tr>
			   <tr >
			     <td><?php echo $strPlusTop; ?></td>
				 <td>
				<input name="top"  size="3" maxlength="4" type="text" id="top"  class="input" value="<?php echo $top; ?>"  /> - 
				<input name="left"  size="3" maxlength="4" type="text" id="left"  class="input" value="<?php echo $left; ?>"  /> PX 
				 </td>
		       </tr>			   
</table>
       
	<div class="editzone" <?php echo plustrdis( $set_body ); ?>>
   
		<input type="hidden" name="body" value="<?php echo $body; ?>" />
		<div id="kedit" style="position:relative">		 
<script type="text/javascript" src="../../kedit/memberEditor.js"></script>		
<script type="text/javascript">
		var editor = new KindEditor("editor");
		editor.hiddenName = "body";
		editor.editorWidth = "580px";
		editor.editorHeight = "200px";
		editor.skinPath = "../../kedit/skins/default/";
		editor.uploadPath = "../../kedit/upload_cgi/upload.php";
		editor.imageAttachPath="<?php echo $plustype; ?>/pics/";
		editor.iconPath = "../../kedit/icons/";
		editor.show();
		function KindSubmit() {
		  editor.data();
		}
		 </script>
		</div>
		</div>
	</div>
	
	
<?php
if ( $sourceurl != "-1" && $sourceurl != "" && $sourceurl != "0" && strstr( $sourceurl, "/" ) )
{
		$SourceArr = explode( "/", $sourceurl );
		$sourcename = $SourceArr[1];
		$sourcefolder = $SourceArr[0];
		echo "	<div id=\"setsource\" class=\"pluszone\">".$strPlusZone4."</div>
	<div id=\"s_setsource\"  class=\"pluszonex\">
	<div style=\"float:right;margin-top:-20px;\"><a href=\"../../editpro/ref.php?mode=../effect/source/&indir=".$sourcefolder."\" target=\"_blank\" style=\"line-height:32px;color:#3c6da8;font-weight:bold;\">".$strPlusUpDel."</a></div>
	<div id=\"sourcezone\"></div>
	</div>
	";
		echo "<script>
	\$(document).ready(function(){
		\$().getPicSource();
	});
	</script>
	";
}
?>
	<input name="sourcename" type="hidden" id="sourcename" value="<?php echo $sourcename; ?>" size="35" />
	<input name="sourcefolder" type="hidden" id="sourcefolder" value="<?php echo $sourcefolder; ?>" size="35" />
	<input name="sourceurl" type="hidden" id="sourceurl" value="<?php echo $sourceurl; ?>" size="35" />    
</div>


<div class="adminsubmit" style="text-align:center">
<div style="float:right;margin-right:20px">
<input type="submit" name="submit"   value="<?php echo $strConfirm; ?>"  class="button"  onClick="KindSubmit();" />
<input onClick="parent.$.unblockUI()" type="button" value="<?php echo $strWindowClose; ?>" class="button"  name="button2" >
<input type="hidden" name="step" value="add">
<input type="hidden" name="pluslable" id="pluslable" value="<?php echo $pluslable; ?>">
<input name="plusname" type="hidden" id="plusname" value="<?php echo $plusname; ?>">
<input type="hidden" name="pluslocat" value="<?php echo $pluslocat; ?>">
<input type="hidden" name="plustype" value="<?php echo $plustype; ?>">
<input type="hidden" name="modno" value="<?php echo $modno; ?>">
<input name="zindex"  type="hidden" id="zindex"  value="<?php echo $zindex; ?>"  />
<input name="coltype"  type="hidden" id="coltype"  value="<?php echo $coltype; ?>"  />
<input name="display"  type="hidden" id="display" value="block"  />     
<input name="ifrefresh"  type="hidden" id="ifrefresh"  value="<?php echo $ifrefresh; ?>"  />
</div>


<div class="plusglobal">
<table  border="0" cellspacing="1" cellpadding="1">
             <tr >
			   
			   <td <?php echo plustrdis( $set_setglobal ); ?>>
			   <input name="setglobal" type="checkbox" id="setglobal" value="1" /> 
			  </td>
			 
			   <td <?php echo plustrdis( $set_setglobal ); ?>><?php echo $strPlusAddGlobal1; ?></td>
		    </tr>
		</table>
</div>
</div>
</div>
</form>
</body>
</html>