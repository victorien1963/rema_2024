<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 6 );
$modid = $_GET['modid'];
$act = $_POST['act'];

if($act == "config"){
		$msql->query( "UPDATE {P}_base_plusdefault SET 
coltype='$_POST[coltype]',
pluslable='$_POST[pluslable]',
plusname='$_POST[plusname]',
plustype='$_POST[plustype]',
pluslocat='$_POST[pluslocat]',
tempname='$_POST[tempname]',
tempcolor='$_POST[tempcolor]',
showborder='$_POST[showborder]',
bordercolor='$_POST[bordercolor]',
borderwidth='$_POST[borderwidth]',
borderstyle='$_POST[borderstyle]',
borderlable='$_POST[borderlable]',
borderroll='$_POST[borderroll]',
showbar='$_POST[showbar]',
barbg='$_POST[barbg]',
barcolor='$_POST[barcolor]',
backgroundcolor='$_POST[backgroundcolor]',
morelink='$_POST[morelink]',
width='$_POST[width]',
height='$_POST[height]',
top='$_POST[top]',
`left`='$_POST[left]',
zindex='$_POST[zindex]',
padding='$_POST[padding]',
shownums='$_POST[shownums]',
ord='$_POST[ord]',
sc='$_POST[sc]',
showtj='$_POST[showtj]',
cutword='$_POST[cutword]',
target='$_POST[target]',
catid='$_POST[catid]',
cutbody ='$_POST[cutbody]',
picw='$_POST[picw]',
pich='$_POST[pich]',
fittype='$_POST[fittype]',
title='$_POST[title]',
body='$_POST[body]',
pic='$_POST[pic]',
piclink='$_POST[piclink]',
attach='$_POST[attach]',
movi='$_POST[movi]',
sourceurl='$_POST[sourceurl]',
word='$_POST[word]',
word1='$_POST[word1]',
word2='$_POST[word2]',
word3='$_POST[word3]',
word4='$_POST[word4]',
text='$_POST[text]',
text1='$_POST[text1]',
link='$_POST[link]',
link1='$_POST[link1]',
link2='$_POST[link2]',
link3='$_POST[link3]',
link4='$_POST[link4]',
code='$_POST[code]',
tags='$_POST[tags]',
groupid='$_POST[groupid]',
projid='$_POST[projid]',
moveable='$_POST[moveable]',
classtbl='$_POST[classtbl]',
grouptbl='$_POST[grouptbl]',
projtbl='$_POST[projtbl]',
setglobal='$_POST[setglobal]',
overflow='$_POST[overflow]',
bodyzone='$_POST[bodyzone]',
display='$_POST[display]',
ifmul='$_POST[ifmul]',
ifrefresh='$_POST[ifrefresh]' 
WHERE id='$_POST[id]'");

$modid = $_POST[id];

}
$STRid="自增量ＩＤ，新增元件記錄時自動產生，無需特別指定";
$STRcoltype="元件的來源模組原始碼(如：news)，根據此值尋找元件程序和模板文件的位置";
$STRpluslable="唯一的元件標籤名，不可重名，和元件程序文件名稱對應，如modNewsList";
$STRplusname="元件的中文名，考慮到排版時在元件管理面板顯示完整，一般不要超過16個字元";
$STRplustype="允許在哪些模組使用該元件，all表示該元件可以在全站所有模組使用";
$STRpluslocat="允許在哪些頁面使用該元件，all表示全部頁面；和plustype配合用以規定元件的可用範圍";
$STRtempname="元件的預設模板文件名(擴展模板則記錄在_base_plustemp表中)";
$STRtempcolor="元件的預設顏色方案編號。除了導航選單可選配色方案，其他元件均填-1，即不可選配色方案；程序支持所有元件均可選配色方案，但是這樣做將使元件模板開發增加15倍工作量，故暫時只有導航選單使用了這一機制";
$STRshowborder="元件預設選用的邊框編號。A001代表001號邊框模板，配色代號為A(配色編號從A-P共１６種顏色，可以填寫B001、P001等，但不推薦)；1000表示自訂邊框，如果元件預設不顯示邊框，可在此填寫1000，並將borderwidth填為0。";
$STRbordercolor="自訂邊框的顏色，僅在showborder為1000自訂邊框時有效";
$STRborderwidth="自訂邊框的寬度，僅在showborder為1000自訂邊框時有效";
$STRborderstyle="邊框的樣式，solid表示實線，dotted表示點狀，dashed表示虛線...";
$STRborderlable="用於標籤式邊框填寫被控元件編號，預設記錄不要填任何內容";
$STRborderroll="用於標籤式邊框的切換方式，預設記錄不要填任何內容";
$STRshowbar="自訂邊框是否顯示元件標題欄，僅在showborder為1000自訂邊框時有效";
$STRbarbg="自訂邊框的標題欄背景色，僅在showborder為1000自訂邊框時有效";
$STRbarcolor="自訂邊框的標題欄文字色，僅在showborder為1000自訂邊框時有效";
$STRbackgroundcolor="自訂邊框的背景色，僅在showborder為1000自訂邊框時有效";
$STRmorelink="預設的更多連結，填-1表示不可設置更多連結";
$STRwidth="元件預設的寬度，根據元件的理想顯示尺寸填寫";
$STRheight="元件的預設高度，根據元件的理想顯示尺寸填寫";
$STRtop="元件的頂邊距，是相對於容器的頂邊距，一般填0，方便用戶在同一位置找到新插入的元件";
$STRleft="元件的左邊距，是相對於容器的左邊距，一般填0，";
$STRzindex="元件的Z軸位置，一般填寫99，使元件插入時位於其他元件的前方";
$STRpadding="元件邊框的內邊距，即邊框和內容之間的距離";
$STRshownums="內容預設顯示條數，如不可控制內容條數，填-1";
$STRord="內容的排序參數，根據元件來源資料表可提供排序的參數，以「|」分割，如不允許設置，填-1";
$STRsc="內容的排序方法，asc或desc，如不允許設置，填-1";
$STRshowtj="是否只顯示推薦內容，1表示預設選中「只顯示推薦內容」，0表示不規定是否顯示推薦內容，如果不可設置是否顯示推薦內容，填-1";
$STRcutword="內容標題截取文字，填數字，不可設置時填-1";
$STRtarget="連結打開方式，_self或_blank，不可設置時填-1";
$STRcatid="預設選擇的分類id，用於選擇內容的顯示分類。當該值不是-1時，必須在classtbl欄位中填如對應的資料表名，該資料表的結構必須符合WayHunt系統的catpath分類方法，如文章、下載分類等均按此標準規劃分類。";
$STRcutbody ="內容截取字數，一般配合程序截取body,memo等欄位，不可設置時填-1";
$STRpicw="縮圖寬度，一般用於圖片展示等元件，不可設置時填-1";
$STRpich=" 縮圖高度，一般用於圖片展示等元件，不可設置時填-1";
$STRfittype="縮圖的預設自適應方法，填fill或不可設置時填-1";
$STRtitle="預設的元件標題";
$STRbody="在元件設置時可直接輸入html編輯內容，-1為不可填";
$STRpic="在元件設置時可直接上傳圖片，-1為不可上傳圖片";
$STRpiclink="在元件設置時可直接上傳圖片的配套連結，-1為不可填";
$STRattach="在元件設置時可直接上傳文件，-1為不可上傳文件";
$STRmovi="在元件設置時可填寫影片來源網址，-1為不可填";
$STRsourceurl="在元件設置時可填寫其他來源網址，-1為不可填";
$STRword="這些欄位用於自訂內容模組中的組合內容元件，一般不使用，填-1";
$STRword1="這些欄位用於自訂內容模組中的組合內容元件，一般不使用，填-1";
$STRword2="這些欄位用於自訂內容模組中的組合內容元件，一般不使用，填-1";
$STRword3="這些欄位用於自訂內容模組中的組合內容元件，一般不使用，填-1";
$STRword4="這些欄位用於自訂內容模組中的組合內容元件，一般不使用，填-1";
$STRtext="這些欄位用於自訂內容模組中的組合內容元件，一般不使用，填-1";
$STRtext1="這些欄位用於自訂內容模組中的組合內容元件，一般不使用，填-1";
$STRlink="這些欄位用於自訂內容模組中的組合內容元件，一般不使用，填-1";
$STRlink1="這些欄位用於自訂內容模組中的組合內容元件，一般不使用，填-1";
$STRlink2="這些欄位用於自訂內容模組中的組合內容元件，一般不使用，填-1";
$STRlink3="這些欄位用於自訂內容模組中的組合內容元件，一般不使用，填-1";
$STRlink4="這些欄位用於自訂內容模組中的組合內容元件，一般不使用，填-1";
$STRcode="用於輸入原始碼，不可輸入填-1";
$STRtags="為空時可設置符合標籤，-1時不可設置";
$STRgroupid="用於選擇分組，如友站連結、廣告組等元件，填-1時不可選擇分組";
$STRprojid="用於選擇專題，如文章列表元件，填-1時不可選擇專題";
$STRmoveable="預留欄位，全部填1";
$STRclasstbl="對應catid的分類資料表名";
$STRgrouptbl="對應groupid的分組資料表名";
$STRprojtbl="對應projid的專題資料表名";
$STRsetglobal="是否允許全站同時插入元件，1為可同時插入，0為不可同時插入。注意事項：一般只能允許每頁只可插入一個的元件進行全站同時插入，否則會弄亂頁面";
$STRoverflow="內容溢出是是否自動增加高度，對於可預知高度的應設為hidden，不可預知高度得設為visible";
$STRbodyzone="元件預設插入的容器，可選填top、content、bottom";
$STRdisplay="預留欄位，填1";
$STRifmul="一個頁面中是否允許多次插入本元件，注意插入多個會產生互相衝突的一般應設為0";
$STRifrefresh="插入元件後是否更新頁面，一般帶js的元件應設為1，需要更新後才能看到效果，普通元件設為0";
$msql->query( "select * from {P}_base_plusdefault where id='{$modid}'");
if ( $msql->next_record( ) )
{
$id=$msql->f("id");
$coltype=$msql->f("coltype");
$pluslable=$msql->f("pluslable");
$plusname=$msql->f("plusname");
$plustype=$msql->f("plustype");
$pluslocat=$msql->f("pluslocat");
$tempname=$msql->f("tempname");
$tempcolor=$msql->f("tempcolor");
$showborder=$msql->f("showborder");
$bordercolor=$msql->f("bordercolor");
$borderwidth=$msql->f("borderwidth");
$borderstyle=$msql->f("borderstyle");
$borderlable=$msql->f("borderlable");
$borderroll=$msql->f("borderroll");
$showbar=$msql->f("showbar");
$barbg=$msql->f("barbg");
$barcolor=$msql->f("barcolor");
$backgroundcolor=$msql->f("backgroundcolor");
$morelink=$msql->f("morelink");
$width=$msql->f("width");
$height=$msql->f("height");
$top=$msql->f("top");
$left=$msql->f("left");
$zindex=$msql->f("zindex");
$padding=$msql->f("padding");
$shownums=$msql->f("shownums");
$ord=$msql->f("ord");
$sc=$msql->f("sc");
$showtj=$msql->f("showtj");
$cutword=$msql->f("cutword");
$target=$msql->f("target");
$catid=$msql->f("catid");
$cutbody =$msql->f("cutbody");
$picw=$msql->f("picw");
$pich=$msql->f("pich");
$fittype=$msql->f("fittype");
$title=$msql->f("title");
$body=$msql->f("body");
$pic=$msql->f("pic");
$piclink=$msql->f("piclink");
$attach=$msql->f("attach");
$movi=$msql->f("movi");
$sourceurl=$msql->f("sourceurl");
$word=$msql->f("word");
$word1=$msql->f("word1");
$word2=$msql->f("word2");
$word3=$msql->f("word3");
$word4=$msql->f("word4");
$text=$msql->f("text");
$text1=$msql->f("text1");
$link=$msql->f("link");
$link1=$msql->f("link1");
$link2=$msql->f("link2");
$link3=$msql->f("link3");
$link4=$msql->f("link4");
$code=$msql->f("code");
$tags=$msql->f("tags");
$groupid=$msql->f("groupid");
$projid=$msql->f("projid");
$moveable=$msql->f("moveable");
$classtbl=$msql->f("classtbl");
$grouptbl=$msql->f("grouptbl");
$projtbl=$msql->f("projtbl");
$setglobal=$msql->f("setglobal");
$overflow=$msql->f("overflow");
$bodyzone=$msql->f("bodyzone");
$display=$msql->f("display");
$ifmul=$msql->f("ifmul");
$ifrefresh=$msql->f("ifrefresh");
}

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head >
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<link  href=\"css/style.css\" type=\"text/css\" rel=\"stylesheet\">
<title>";
echo $strAdminTitle;
echo "</title>";
echo "<script type=\"text/javascript\" src=\"../../base/js/base.js\"></script>";
echo "<script type=\"text/javascript\" src=\"../../base/js/form.js\"></script>";
echo "<script type=\"text/javascript\" src=\"../../base/js/blockui.js\"></script>
<script type=\"text/javascript\" src=\"js/module.js\"></script></head><body>
<div class=\"formzone\">
<div class=\"rightzone\">
<div id=\"notice\" style=\"display:none\"></div>

</div>

<div class=\"namezone\">";
echo $strColPlusGl;
echo " - <font color=red>警告！非程式設計人員請勿擅自修改！</font></div><div class=\"tablezone\"><form name=\"form\" method=\"post\" action=\"plus_config.php\"> 
      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"6\" >
        <tr > 
          <td width=\"15%\" class=\"innerbiaoti\">參數名稱</td>
          <td width=\"25%\" class=\"innerbiaoti\">數值</td>
          <td width=\"60%\" class=\"innerbiaoti\" >說明</td>
        </tr>
        <tr > 
          <td class=\"innerbiaoti\">id</td>
          <td class=\"innerbiaoti\"><input type=\"hidden\" size=\"10\" name=\"id\" value=\"".$id."\" />".$id."</td>
          <td class=\"innerbiaoti\">".$STRid."</td>
        </tr>
        <tr > 
          <td class=\"innerbiaoti\">coltype</td>
          <td class=\"innerbiaoti\"><input type=\"hidden\" size=\"10\" name=\"coltype\" value=\"".$coltype."\" />".$coltype."</td>
          <td class=\"innerbiaoti\">".$STRcoltype."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">pluslable</td>
          <td class=\"innerbiaoti\"><input type=\"hidden\" size=\"10\" name=\"pluslable\" value=\"".$pluslable."\" />".$pluslable."</td>
          <td class=\"innerbiaoti\">".$STRpluslable."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">plusname</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"plusname\" value=\"".$plusname."\" /></td>
          <td class=\"innerbiaoti\">".$STRplusname."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">plustype</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"plustype\" value=\"".$plustype."\" /></td>
          <td class=\"innerbiaoti\">".$STRplustype."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">pluslocat</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"pluslocat\" value=\"".$pluslocat."\" /></td>
          <td class=\"innerbiaoti\">".$STRpluslocat."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">tempname</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"tempname\" value=\"".$tempname."\" /></td>
          <td class=\"innerbiaoti\">".$STRtempname."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">tempcolor</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"tempcolor\" value=\"".$tempcolor."\" /></td>
          <td class=\"innerbiaoti\">".$STRtempcolor."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">showborder</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"showborder\" value=\"".$showborder."\" /></td>
          <td class=\"innerbiaoti\">".$STRshowborder."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">bordercolor</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"bordercolor\" value=\"".$bordercolor."\" /></td>
          <td class=\"innerbiaoti\">".$STRbordercolor."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">borderwidth</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"borderwidth\" value=\"".$borderwidth."\" /></td>
          <td class=\"innerbiaoti\">".$STRborderwidth."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">borderstyle</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"borderstyle\" value=\"".$borderstyle."\" /></td>
          <td class=\"innerbiaoti\">".$STRborderstyle."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">borderlable</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"borderlable\" value=\"".$borderlable."\" /></td>
          <td class=\"innerbiaoti\">".$STRborderlable."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">borderroll</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"borderroll\" value=\"".$borderroll."\" /></td>
          <td class=\"innerbiaoti\">".$STRborderroll."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">showbar</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"showbar\" value=\"".$showbar."\" /></td>
          <td class=\"innerbiaoti\">".$STRshowbar."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">barbg</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"barbg\" value=\"".$barbg."\" /></td>
          <td class=\"innerbiaoti\">".$STRbarbg."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">barcolor</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"barcolor\" value=\"".$barcolor."\" /></td>
          <td class=\"innerbiaoti\">".$STRbarcolor."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">backgroundcolor</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"backgroundcolor\" value=\"".$backgroundcolor."\" /></td>
          <td class=\"innerbiaoti\">".$STRbackgroundcolor."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">morelink</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"morelink\" value=\"".$morelink."\" /></td>
          <td class=\"innerbiaoti\">".$STRmorelink."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">width</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"width\" value=\"".$width."\" /></td>
          <td class=\"innerbiaoti\">".$STRwidth."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">height</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"height\" value=\"".$height."\" /></td>
          <td class=\"innerbiaoti\">".$STRheight."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">top</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"top\" value=\"".$top."\" /></td>
          <td class=\"innerbiaoti\">".$STRtop."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">left</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"left\" value=\"".$left."\" /></td>
          <td class=\"innerbiaoti\">".$STRleft."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">zindex</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"zindex\" value=\"".$zindex."\" /></td>
          <td class=\"innerbiaoti\">".$STRzindex."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">padding</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"padding\" value=\"".$padding."\" /></td>
          <td class=\"innerbiaoti\">".$STRpadding."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">shownums</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"shownums\" value=\"".$shownums."\" /></td>
          <td class=\"innerbiaoti\">".$STRshownums."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">ord</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"ord\" value=\"".$ord."\" /></td>
          <td class=\"innerbiaoti\">".$STRord."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">sc</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"sc\" value=\"".$sc."\" /></td>
          <td class=\"innerbiaoti\">".$STRsc."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">showtj</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"showtj\" value=\"".$showtj."\" /></td>
          <td class=\"innerbiaoti\">".$STRshowtj."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">cutword</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"cutword\" value=\"".$cutword."\" /></td>
          <td class=\"innerbiaoti\">".$STRcutword."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">target</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"target\" value=\"".$target."\" /></td>
          <td class=\"innerbiaoti\">".$STRtarget."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">catid</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"catid\" value=\"".$catid."\" /></td>
          <td class=\"innerbiaoti\">".$STRcatid."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">cutbody</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"cutbody\" value=\"".$cutbody."\" /></td>
          <td class=\"innerbiaoti\">".$STRcutbody."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">picw</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"picw\" value=\"".$picw."\" /></td>
          <td class=\"innerbiaoti\">".$STRpicw."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">pich</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"pich\" value=\"".$pich."\" /></td>
          <td class=\"innerbiaoti\">".$STRpich."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">fittype</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"fittype\" value=\"".$fittype."\" /></td>
          <td class=\"innerbiaoti\">".$STRfittype."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">title</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"title\" value=\"".$title."\" /></td>
          <td class=\"innerbiaoti\">".$STRtitle."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">body</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"body\" value=\"".$body."\" /></td>
          <td class=\"innerbiaoti\">".$STRbody."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">pic</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"pic\" value=\"".$pic."\" /></td>
          <td class=\"innerbiaoti\">".$STRpic."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">piclink</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"piclink\" value=\"".$piclink."\" /></td>
          <td class=\"innerbiaoti\">".$STRpiclink."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">attach</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"attach\" value=\"".$attach."\" /></td>
          <td class=\"innerbiaoti\">".$STRattach."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">movi</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"movi\" value=\"".$movi."\" /></td>
          <td class=\"innerbiaoti\">".$STRmovi."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">sourceurl</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"sourceurl\" value=\"".$sourceurl."\" /></td>
          <td class=\"innerbiaoti\">".$STRsourceurl."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">word</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"word\" value=\"".$word."\" /></td>
          <td class=\"innerbiaoti\">".$STRword."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">word1</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"word1\" value=\"".$word1."\" /></td>
          <td class=\"innerbiaoti\">".$STRword1."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">word2</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"word2\" value=\"".$word2."\" /></td>
          <td class=\"innerbiaoti\">".$STRword2."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">word3</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"word3\" value=\"".$word3."\" /></td>
          <td class=\"innerbiaoti\">".$STRword3."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">word4</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"word4\" value=\"".$word4."\" /></td>
          <td class=\"innerbiaoti\">".$STRword4."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">text</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"text\" value=\"".$text."\" /></td>
          <td class=\"innerbiaoti\">".$STRtext."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">text1</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"text1\" value=\"".$text1."\" /></td>
          <td class=\"innerbiaoti\">".$STRtext1."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">link</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"link\" value=\"".$link."\" /></td>
          <td class=\"innerbiaoti\">".$STRlink."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">link1</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"link1\" value=\"".$link1."\" /></td>
          <td class=\"innerbiaoti\">".$STRlink1."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">link2</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"link2\" value=\"".$link2."\" /></td>
          <td class=\"innerbiaoti\">".$STRlink2."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">link3</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"link3\" value=\"".$link3."\" /></td>
          <td class=\"innerbiaoti\">".$STRlink3."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">link4</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"link4\" value=\"".$link4."\" /></td>
          <td class=\"innerbiaoti\">".$STRlink4."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">code</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"code\" value=\"".$code."\" /></td>
          <td class=\"innerbiaoti\">".$STRcode."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">tags</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"tags\" value=\"".$tags."\" /></td>
          <td class=\"innerbiaoti\">".$STRtags."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">groupid</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"groupid\" value=\"".$groupid."\" /></td>
          <td class=\"innerbiaoti\">".$STRgroupid."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">projid</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"projid\" value=\"".$projid."\" /></td>
          <td class=\"innerbiaoti\">".$STRprojid."</td>
        </tr>
            <tr > 
          <td class=\"innerbiaoti\">moveable</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"moveable\" value=\"".$moveable."\" /></td>
          <td class=\"innerbiaoti\">".$STRmoveable."</td>
        </tr>
        <tr >
          <td class=\"innerbiaoti\">classtbl</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"classtbl\" value=\"".$classtbl."\" /></td>
          <td class=\"innerbiaoti\">".$STRclasstbl."</td>
        </tr>
    	<tr >
          <td class=\"innerbiaoti\">grouptbl</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"grouptbl\" value=\"".$grouptbl."\" /></td>
          <td class=\"innerbiaoti\">".$STRgrouptbl."</td>
        </tr>
        <tr >
          <td class=\"innerbiaoti\">projtbl</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"projtbl\" value=\"".$projtbl."\" /></td>
          <td class=\"innerbiaoti\">".$STRprojtbl."</td>
        </tr>
        <tr >
          <td class=\"innerbiaoti\">setglobal</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"setglobal\" value=\"".$setglobal."\" /></td>
          <td class=\"innerbiaoti\">".$STRsetglobal."</td>
        </tr>
        <tr >
          <td class=\"innerbiaoti\">overflow</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"overflow\" value=\"".$overflow."\" /></td>
          <td class=\"innerbiaoti\">".$STRoverflow."</td>
        </tr>
        <tr >
          <td class=\"innerbiaoti\">bodyzone</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"bodyzone\" value=\"".$bodyzone."\" /></td>
          <td class=\"innerbiaoti\">".$STRbodyzone."</td>
        </tr>
        <tr >
          <td class=\"innerbiaoti\">display</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"display\" value=\"".$display."\" /></td>
          <td class=\"innerbiaoti\">".$STRdisplay."</td>
        </tr>
        <tr >
          <td class=\"innerbiaoti\">ifmul</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"ifmul\" value=\"".$ifmul."\" /></td>
          <td class=\"innerbiaoti\">".$STRifmul."</td>
        </tr>
        <tr >
          <td class=\"innerbiaoti\">ifrefresh</td>
          <td class=\"innerbiaoti\"><input type=\"input\" size=\"10\" name=\"ifrefresh\" value=\"".$ifrefresh."\" /></td>
          <td class=\"innerbiaoti\">".$STRifrefresh."</td>
        </tr>
        <tr >
          <td class=\"innerbiaoti\" colspan=\"3\"><input type=\"submit\" value=\"".$strSubmit."\" class=\"button\" /></td>
        </tr>
    </table>
    	<input type=\"hidden\" name=\"act\" value=\"config\" />
     </form>
     
</div>
</div>
</body>
</html>
";
?>