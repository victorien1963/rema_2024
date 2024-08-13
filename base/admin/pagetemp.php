<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/pages.inc.php" );
include( "language/".$sLan.".php" );
NeedAuth(6);
$step = $_REQUEST['step'];
$id = $_REQUEST['id'];

if($step == "edit"){
$pagename = $_POST[''.$id.'_pagename'];
$pagetitle = $_POST[''.$id.'_pagetitle'];
$metakey = $_POST[''.$id.'_metakey'];
$metacon = $_POST[''.$id.'_metacon'];

$diypagename = $_POST[''.$id.'_diypagename'];
$addpage = $_POST[''.$id.'_addpage'];
$ismobi = $_POST[''.$id.'_ismobi']? "1":"0";
$istb = $_POST[''.$id.'_istb']? "1":"0";
$ismobi_add = $_POST[''.$id.'_ismobi_add']? "1":"0";
$diypage = $diypagename.",".$istb.",".$ismobi.",".$ismobi_add.",".$addpage;

if($ismobi_add){
	$coltypes = $_GET['coltypes'];
	$pagenames = $_GET['pagenames'];
	$msql->query( "select * from {P}_base_pageset where coltype='{$coltypes}' and pagename='{$pagenames}_m'" );
	if( !$msql->next_record( ) ){
		err( "請先產生手機頁面！","","" );
	}
}

$msql->query( "UPDATE {P}_base_pageset SET name='{$pagename}',pagetitle='{$pagetitle}',metakey='{$metakey}',metacon='{$metacon}',diypage='{$diypage}' WHERE id='{$id}'" );

}elseif($step == "delpage"){
	
$msql->query( "DELETE FROM {P}_base_pageset WHERE id='{$id}'" );

}elseif($step == "addmobitemp"){
				$coltype= $_GET['coltype'];
				$pagename= $_GET['pagename'];
				$msql->query( "select * from {P}_base_pageset where coltype='{$coltype}' and pagename='{$pagename}'" );
				if ( $msql->next_record( ) )
				{
					$fsql->query( "insert into {P}_base_pageset (`id`, `name`, `coltype`, `pagename`, `th`, `ch`, `bh`, `pagetitle`, `metakey`, `metacon`, `bgcolor`, `bgimage`, `bgposition`, `bgrepeat`, `bgatt`, `containwidth`, `containbg`, `containimg`, `containmargin`, `containpadding`, `containcenter`, `topbg`, `topwidth`, `contentbg`, `contentwidth`, `contentmargin`, `bottombg`, `bottomwidth`, `buildhtml`, `xuhao`, `diypage`) VALUES (NULL,'{$msql->f('name')}','{$msql->f('coltype')}','{$pagename}_m','{$msql->f('th')}','{$msql->f('ch')}','{$msql->f('bh')}','{$msql->f('pagetitle')}','{$msql->f('metakey')}','{$msql->f('metacon')}','{$msql->f('bgcolor')}','{$msql->f('bgimage')}','{$msql->f('bgposition')}','{$msql->f('bgrepeat')}','{$msql->f('bgatt')}','{$msql->f('containwidth')}','{$msql->f('containbg')}','{$msql->f('containimg')}','{$msql->f('containmargin')}','{$msql->f('containpadding')}','{$msql->f('containcenter')}','{$msql->f('topbg')}','{$msql->f('topwidth')}','{$msql->f('contentbg')}','{$msql->f('contentwidth')}','{$msql->f('contentmargin')}','{$msql->f('bottombg')}','{$msql->f('bottomwidth')}','{$msql->f('buildhtml')}','{$msql->f('xuhao')}','{$msql->f('diypage')}') " );
				}
				else
				{
								echo $strZlNTC2;
								exit( );
				}
				
				$msql->query( "select * from {P}_base_plusdefault where coltype='{$coltype}' and pluslocat='{$pagename}'" );
				while ( $msql->next_record( ) )
				{
					$fsql->query( "INSERT INTO {P}_base_plusdefault (`id`, `coltype`, `pluslable`, `plusname`, `plustype`, `pluslocat`, `tempname`, `tempcolor`, `showborder`, `bordercolor`, `borderwidth`, `borderstyle`, `borderlable`, `borderroll`, `showbar`, `barbg`, `barcolor`, `backgroundcolor`, `morelink`, `width`, `height`, `top`, `left`, `zindex`, `padding`, `shownums`, `ord`, `sc`, `showtj`, `cutword`, `target`, `catid`, `cutbody`, `picw`, `pich`, `fittype`, `title`, `body`, `pic`, `piclink`, `attach`, `movi`, `sourceurl`, `word`, `word1`, `word2`, `word3`, `word4`, `text`, `text1`, `code`, `link`, `link1`, `link2`, `link3`, `link4`, `tags`, `groupid`, `projid`, `moveable`, `classtbl`, `grouptbl`, `projtbl`, `setglobal`, `overflow`, `bodyzone`, `display`, `ifmul`, `ifrefresh`) VALUES (NULL, '{$msql->f('coltype')}', '{$msql->f('pluslable')}', '{$msql->f('plusname')}', '{$msql->f('plustype')}', '{$pagename}_m', '{$msql->f('tempname')}', '{$msql->f('tempcolor')}', '{$msql->f('showborder')}', '{$msql->f('bordercolor')}', '{$msql->f('borderwidth')}', '{$msql->f('borderstyle')}', '{$msql->f('borderlable')}', '{$msql->f('borderroll')}', '{$msql->f('showbar')}', '{$msql->f('barbg')}', '{$msql->f('barcolor')}', '{$msql->f('backgroundcolor')}', '{$msql->f('morelink')}', '{$msql->f('width')}', '{$msql->f('height')}', '{$msql->f('top')}', '{$msql->f('left')}', '{$msql->f('zindex')}', '{$msql->f('padding')}', '{$msql->f('shownums')}', '{$msql->f('ord')}', '{$msql->f('sc')}', '{$msql->f('showtj')}', '{$msql->f('cutword')}', '{$msql->f('target')}', '{$msql->f('catid')}', '{$msql->f('cutbody')}', '{$msql->f('picw')}', '{$msql->f('pich')}', '{$msql->f('fittype')}', '{$msql->f('title')}', '{$msql->f('body')}', '{$msql->f('pic')}', '{$msql->f('piclink')}', '{$msql->f('attach')}', '{$msql->f('movi')}', '{$msql->f('sourceurl')}', '{$msql->f('word')}', '{$msql->f('word1')}', '{$msql->f('word2')}', '{$msql->f('word3')}', '{$msql->f('word4')}', '{$msql->f('text')}', '{$msql->f('text1')}', '{$msql->f('code')}', '{$msql->f('link')}', '{$msql->f('link1')}', '{$msql->f('link2')}', '{$msql->f('link3')}', '{$msql->f('link4')}', '{$msql->f('tags')}', '{$msql->f('groupid')}', '{$msql->f('projid')}', '{$msql->f('moveable')}', '{$msql->f('classtbl')}', '{$msql->f('grouptbl')}', '{$msql->f('projtbl')}', '{$msql->f('setglobal')}', '{$msql->f('overflow')}', '{$msql->f('bodyzone')}', '{$msql->f('display')}', '{$msql->f('ifmul')}', '{$msql->f('ifrefresh')}')" );
				}
/**/
}

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head >
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<link  href=\"css/style.css\" type=\"text/css\" rel=\"stylesheet\">
<title>".$strAdminTitle."</title>
	<script type=\"text/javascript\" src=\"../../base/js/base.js\"></script>
	<script type=\"text/javascript\" src=\"../../base/js/blockui.js\"></script>
</head>
<body>
<script>
$(document).ready(function() {	
	$(\".pdv_enter\").click(function () { 
		var getget = this.id.split(\"/\");
		var coltypes=getget[0];
		var pagenames=getget[1];
		$.ajax({
			type: \"POST\",
			url: \"../../post.php\",
			data: \"act=plusenter\",
			success: function(msg){
				if(msg==\"OK\"){
					window.open('../tempedit.php?coltype='+coltypes+'&pagename='+pagenames+'','_blank');
				}else{
					alert(\"目前的管理帳戶沒有排版權限\");
					return false;
				}
			}
		});
	 });
});
</script>
<style>
.list td{
 border-bottom:1px solid #ccc;
}	
</style>
";

$key=$_GET["key"];
$search = $_GET["search"];
$isdiy = $_GET["isdiy"];

$scl = " id!='0' ";
if($search && $key){
	$scl .= "and name regexp '{$key}' or pagetitle regexp '{$key}' or coltype regexp '{$key}' or pagename regexp '{$key}' or diypage regexp '{$key}'";
}

if($isdiy){
	$scl .= "and diypage != '' and diypage != ',0,0,0,' ";
}

$totalnums = tblcount( "_base_pageset", "id", $scl );
$pages = new pages( );

$pages->setvar(array("search" => $search, "key" => $key, "isdiy" => $isdiy));

$pages->set( 16, $totalnums );
$pagelimit = $pages->limit( );





echo "
<div class=\"searchzone\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" align=\"center\" height=\"28\">
<tr> 
<td>
<form method=\"get\" action=\"pagetemp.php\" style=\"float:left\">
<input type=\"text\" name=\"key\" size=\"23\" class=input value=\"".$key."\" />
<input type=\"submit\" name=\"Submit\" value=\"搜索\" class=button />
<input type=\"hidden\" name=\"search\" value=\"1\" />
<input type=\"hidden\" name=\"page\" value=\"".$pagesinfo[now]."\" />
	&nbsp;&nbsp;
</form>
<form method=\"get\" action=\"pagetemp.php\" style=\"float:left\">
<input type=\"submit\" name=\"Submit\" value=\"列出所有自訂網頁\" class=button />
<input type=\"hidden\" name=\"isdiy\" value=\"1\" />
<input type=\"hidden\" name=\"page\" value=\"".$pagesinfo[now]."\" />
</form>
</td>
<td class=title colspan=\"2\" align=\"right\">&nbsp;&nbsp;&nbsp;&nbsp;
<a class=button href=\"".ROOTPATH."editpro/ref.php?mode=../base/&indir=templates\" target=\"_blank\">模版FTP</a></td>
</tr>
</table>
</div>
<div class=\"formzone\">
<div class=\"tablecapzone\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
    <tr>
      <td width=\"200\"></td>
      <td></td>
    </tr>
  </table>
  </div>
<div class=\"tablezone\">
 <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" >
  <tr> 
    <td class=\"innerbiaoti\" align=\"center\" height=\"28\" width=\"50\" >".$strNumber."</td>
    <td width=\"120\" height=\"28\" class=\"innerbiaoti\" >".$strPageName."</td>
    <td width=\"120\" height=\"28\" class=\"innerbiaoti\" >自訂網頁</td>
    <td width=\"120\" height=\"28\" class=\"innerbiaoti\" >".$strPageTitle."</td>
    <td width=\"120\" height=\"28\" class=\"innerbiaoti\" >".$strPageKey."</td>
    <td class=\"innerbiaoti\" >".$strPageCon."</td>
    <td class=\"innerbiaoti\" width=\"39\" >".$strModify."</td>
    <td width=\"39\" class=\"innerbiaoti\" >
	<span class=\"biaoti\">".$strTempEdit."</span></td>
	<td class=\"innerbiaoti\" width=\"39\" >".$strDelete."</td></tr>";
$pagesinfo = $pages->shownow( );
$msql->query( "select * from {P}_base_pageset where {$scl} order by id  limit {$pagelimit}" );
while ( $msql->next_record( ) )
{
				$id = $msql->f( "id" );
				$name = $msql->f( "name" );
				$pagetitle = $msql->f( "pagetitle" );
				$metakey = $msql->f( "metakey" );
				$metacon = $msql->f( "metacon" );
				$coltype = $msql->f( "coltype" );
				$pagename = $msql->f( "pagename" );
				list($diypagename,$istb,$ismobi,$ismobi_add,$addpage) = explode(",",$msql->f( "diypage" ));
				$ismobi = $ismobi? "checked":"";
				$istb = $istb? "checked":"";
				$ismobi_add = $ismobi_add? "checked":"";
				echo " 
<form name=\"form_".$id."\" action=\"pagetemp.php?step=edit&id=".$id."&page=".$pagesinfo['now']."&coltypes=".$coltype."&pagenames=".$pagename."&search=".$search."&key=".$key."\" method=\"post\">
<tr class=\"list\"> 
<td  align=\"center\" height=\"28\" width=\"50\" >".$id."</td>
    <td width=\"120\" ><input type=\"input\" name=\"".$id."_pagename\" value=\"".$name."\">";
				$mobi = explode("_",$pagename);
				$mcon = count($mobi)-1;
				if($mobi[$mcon] == "m"){
					//echo "~ 手機專用";
				}else{
					echo "<br /><a href=\"pagetemp.php?step=addmobitemp&coltype=".$coltype."&pagename=".$pagename."&key=".$key."&search=".$search."&page=".$pagesinfo['now']."\" class='button'>產生手機專用頁</a>";
				}
				echo "<br/>(".$coltype."/".$pagename.")</td>
    <td width=\"120\" >";
    			if($mobi[$mcon] == "m"){
    				echo "~ 手機版專用頁面";
    				/*echo "
    			<input type=\"input\" name=\"".$id."_diypagename\" value=\"".$diypagename."\"> 模版名|布景名<br />
    			<label><input type=\"checkbox\" name=\"".$id."_istb\" value=\"1\" ".$istb." />含頂/底部</label>
    			<label><input type=\"checkbox\" name=\"".$id."_ismobi\" value=\"1\" ".$ismobi." />純手機版</label><br /><label><input type=\"checkbox\" name=\"".$id."_ismobi_add\" value=\"1\" ".$ismobi_add." />附加手機版(自訂模填寫下欄，無則留空)</label><br /><input type=\"input\" name=\"".$id."_addpage\" value=\"".$addpage."\"> 模版名|布景名";*/
    			}else{
    				echo "
    			<input type=\"input\" name=\"".$id."_diypagename\" value=\"".$diypagename."\"> 模版名|布景名<br />
    			<label><input type=\"checkbox\" name=\"".$id."_istb\" value=\"1\" ".$istb." />含頂/底部</label>
    			<label><input type=\"checkbox\" name=\"".$id."_ismobi\" value=\"1\" ".$ismobi." />純手機版</label><br /><label><input type=\"checkbox\" name=\"".$id."_ismobi_add\" value=\"1\" ".$ismobi_add." />附加手機版(自訂模板填寫下欄，無則留空)</label><br /><input type=\"input\" name=\"".$id."_addpage\" value=\"".$addpage."\"> 模版名|布景名";
    			}
    			echo "
    				</td>
    <td width=\"120\" >
    			<input type=\"input\" name=\"".$id."_pagetitle\" value=\"".$pagetitle."\"></td>
    <td width=\"120\" >
    			<textarea name=\"".$id."_metakey\" cols=\"20\" rows=\"5\">".$metakey."</textarea></td>
    <td width=\"120\" >
    			<textarea name=\"".$id."_metacon\" cols=\"20\" rows=\"5\">".$metacon."</textarea></td>
    <td width=\"39\" ><input type=\"image\" src=\"images/modi.png\" width=\"24\" height=\"24\"  style=\"cursor:pointer\" /></td>
    <td width=\"39\"  ><img id='".$coltype."/".$pagename."' class='pdv_enter' src=\"images/edit.png\"  style=\"cursor:pointer\"  border=\"0\" />
    				<td height=\"28\" width=\"39\" > <img src=\"images/delete.png\"  style=\"cursor:pointer\" onClick=\"window.location='pagetemp.php?step=delpage&id=".$id."&page=".$pagesinfo['now']."&key=".$key."'\"></td></tr></form>";
}
echo "</table></div></div>
	<div id=\"showpages\">
	  <div id=\"pagesinfo\">".$strPagesTotalStart.$totalnums.$strPagesTotalEnd." ".$strPagesMeiye.$pagesinfo['shownum'].$strPagesTotalEnd." ".$strPagesYeci." ".$pagesinfo['now']."/".$pagesinfo['total']."</div>
	  <div id=\"pages\">".$pages->output( 1 )."</div>
<br/></div>
</div>
</body>
</html>";
?>