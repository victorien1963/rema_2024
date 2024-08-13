<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( ROOTPATH."includes/pages.inc.php" );
include( "language/".$sLan.".php" );
needauth( 182 );
$pid = $_REQUEST['pid'];
$page = $_REQUEST['page'];
$step = $_REQUEST['step'];
$id = $_REQUEST['id'];
$title = $_REQUEST['title'];
$xuhao = $_REQUEST['xuhao'];
$tj = $_REQUEST['tj'];
$iffb = $_REQUEST['iffb'];
$ifbold = $_REQUEST['ifbold'];
$ifred = $_REQUEST['ifred'];
$key = $_REQUEST['key'];
$secure = $_REQUEST['secure'];
$showtj = $_REQUEST['showtj'];
$showfb = $_REQUEST['showfb'];
$shownum = $_REQUEST['shownum'];
$sc = $_REQUEST['sc'];
$ord = $_REQUEST['ord'];
$bg = $_REQUEST['bg'];
if ( !isset( $pid ) || $pid == "" )
{
		$pid = "all";
}
if ( !isset( $shownum ) || $shownum < 10 )
{
		$shownum = 10;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="../../base/js/form.js"></script>
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script type="text/javascript" src="js/product.js"></script>
	 
<SCRIPT>
function Dpop(url,w,h){
	res = showModalDialog(url, null, 'dialogWidth: '+w+'px; dialogHeight: '+h+'px; center: yes; resizable: no; scroll: no; status: no;');
 	if(res=="ok"){window.location.reload();}
 
}
function ordsc(nn,sc){
if(nn!='<?php echo $ord; ?>'){
	window.location='product_con.php?page=<?php echo $page; ?>&sc=<?php echo $sc; ?>&pid=<?php echo $pid; ?>&showtj=<?php echo $showtj; ?>&showfb=<?php echo $showfb; ?>&shownum=<?php echo $shownum; ?>&ord='+nn;
}else{
	if(sc=='asc' || sc==''){
	window.location='product_con.php?page=<?php echo $page; ?>&sc=desc&pid=<?php echo $pid; ?>&showtj=<?php echo $showtj; ?>&showfb=<?php echo $showfb; ?>&shownum=<?php echo $shownum; ?>&ord='+nn;
	}else{
	window.location='product_con.php?page=<?php echo $page; ?>&sc=asc&pid=<?php echo $pid; ?>&showtj=<?php echo $showtj; ?>&showfb=<?php echo $showfb; ?>&shownum=<?php echo $shownum; ?>&ord='+nn;
	}

}
}

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
</head>
<body >

<?php
if ( $step == "setfb" )
{
		trylimit( "_product_con", 30, "id" );
		$dall = $_POST['dall'];
		$nums = sizeof( $dall );
		$iffb = $_POST['iffb'];
		$i = 0;
		for ( ;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_product_con set iffb='{$iffb}' where id='{$ids}'" );
		}
}
if ( $step == "settj" )
{
		trylimit( "_product_con", 30, "id" );
		$dall = $_POST['dall'];
		$tj = $_POST['tj'];
		$nums = sizeof( $dall );
		$i = 0;
		for ( ;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_product_con set tj='{$tj}' where id='{$ids}'" );
		}
}
if ( $step == "setsecure" )
{
		trylimit( "_product_con", 30, "id" );
		$dall = $_POST['dall'];
		$secure = $_POST['secure'];
		$nums = sizeof( $dall );
		$i = 0;
		for ( ;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_product_con set secure='{$secure}' where id='{$ids}'" );
		}
}
if ( $step == "setbold" )
{
		trylimit( "_product_con", 30, "id" );
		$dall = $_POST['dall'];
		$bold = $_POST['bold'];
		$nums = sizeof( $dall );
		$i = 0;
		for ( ;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_product_con set ifbold='{$bold}' where id='{$ids}'" );
		}
}
if ( $step == "setcolor" )
{
		trylimit( "_product_con", 30, "id" );
		$dall = $_POST['dall'];
		$nums = sizeof( $dall );
		$nowcolor = $_POST['nowcolor'];
		$i = 0;
		for ( ;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "update {P}_product_con set ifred='{$nowcolor}' where id='{$ids}'" );
		}
}
if ( $step == "delall" )
{
		trylimit( "_product_con", 30, "id" );
		$dall = $_POST['dall'];
		$nums = sizeof( $dall );
		$i = 0;
		for ( ;	$i < $nums;	$i++	)
		{
				$ids = $dall[$i];
				$msql->query( "select src from {P}_product_con where id='{$ids}'" );
				if ( $msql->next_record( ) )
				{
						$src = $msql->f( "src" );
						if ( file_exists( ROOTPATH.$src ) && $src != "" )
						{
								unlink( ROOTPATH.$src );
						}
				}
				$msql->query( "select src from {P}_product_pages where productid='{$ids}'" );
				while ( $msql->next_record( ) )
				{
						$src = $msql->f( "src" );
						if ( file_exists( ROOTPATH.$src ) && $src != "" )
						{
								unlink( ROOTPATH.$src );
						}
				}
				$msql->query( "delete from {P}_product_pages where productid='{$ids}'" );
				$msql->query( "delete from {P}_comment where catid='4' and rid='{$ids}'" );
				$msql->query( "delete from {P}_product_con where id='{$ids}'" );
		}
}
if ( $step == "refresh" )
{
		$newtime = time( );
		$msql->query( "update {P}_product_con set uptime='{$newtime}' where id='{$id}'" );
}

if ( !isset( $ord ) || $ord == "" )
{
		//$ord = "uptime";
		$ord = "id";
}
if ( !isset( $sc ) || $sc == "" )
{
		//$sc = "desc";
		$sc = "asc";
}
$scl = "  id!='0' ";
if ( $key != "" )
{
		$scl .= " and (title regexp '{$key}' or body regexp '{$key}') ";
}
if ( $showtj != "" && $showtj != "all" )
{
		$scl .= " and tj='{$showtj}' ";
}
if ( $showfb != "" && $showfb != "all" )
{
		$scl .= " and iffb='{$showfb}' ";
}
if ( $pid != "" && $pid != "all" )
{
		if ( $pid == "0" )
		{
				$scl .= " and catid='0' ";
		}
		else
		{
				$fmdpath = fmpath( $pid );
				$scl .= " and catpath regexp '{$fmdpath}' ";
		}
}
$totalnums = tblcount( "_product_con", "id", $scl );
$pages = new pages( );
$pages->setvar( array(
		"shownum" => $shownum,
		"pid" => $pid,
		"sc" => $sc,
		"ord" => $ord,
		"showtj" => $showtj,
		"showfb" => $showfb,
		"key" => $key
) );
$pages->set( $shownum, $totalnums );
$pagelimit = $pages->limit( );
?>
 
<div class="searchzone">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="30">
  <tr> 
    <form method="get" action="product_con.php" >                  
      <td  height="30">         
<select name="pid">
          <option value='all'><?php echo $strProductSelCat; ?></option>
		    <option value='0' <?php echo seld( $pid, "0" ); ?>><?php echo $strPersonPic; ?></option>
          
<?php
$fsql->query( "select * from {P}_product_cat order by catpath" );
while ( $fsql->next_record( ) )
{
		$lpid = $fsql->f( "pid" );
		$lcatid = $fsql->f( "catid" );
		$cat = $fsql->f( "cat" );
		$catpath = $fsql->f( "catpath" );
		$lcatpath = explode( ":", $catpath );
		$i = 0;
		for ( ;	$i < sizeof( $lcatpath ) - 2;	$i++	)
		{
				$tsql->query( "select catid,cat from {P}_product_cat where catid='{$lcatpath[$i]}'" );
				if ( $tsql->next_record( ) )
				{
						$ncatid = $tsql->f( "cat" );
						$ncat = $tsql->f( "cat" );
						$ppcat .= $ncat."/";
				}
		}
		if ( $pid == $lcatid )
		{
				echo "<option value='".$lcatid."' selected>".$ppcat.$cat."</option>";
		}
		else
		{
				echo "<option value='".$lcatid."'>".$ppcat.$cat."</option>";
		}
		$ppcat = "";
}
?>
        </select>
        
<select name="showtj">
          <option value="all" ><?php echo $strProductSelTj; ?></option>
          <option value="1"  <?php echo seld( $showtj, "1" ); ?>><?php echo $strProductSelTjYes; ?></option>
          <option value="0" <?php echo seld( $showtj, "0" ); ?>><?php echo $strProductSelTjNo; ?></option>
        </select>
<select name="showfb">
          <option value="all" ><?php echo $strProductSelFb; ?></option>
          <option value="1"  <?php echo seld( $showfb, "1" ); ?>><?php echo $strProductSelFbYes; ?></option>
          <option value="0" <?php echo seld( $showfb, "0" ); ?>><?php echo $strProductSelFbNo; ?></option>
        </select>
<select name="shownum">
          <option value="10"  <?php echo seld( $shownum, "10" ); ?>><?php echo $strProductSelNum10; ?></option>
          <option value="20" <?php echo seld( $shownum, "20" ); ?>><?php echo $strProductSelNum20; ?></option>
          <option value="30" <?php echo seld( $shownum, "30" ); ?>><?php echo $strProductSelNum30; ?></option>
          <option value="50" <?php echo seld( $shownum, "50" ); ?>><?php echo $strProductSelNum50; ?></option>
        </select>
<input type="text" name="key" size="23" class="input" value="<?php echo $key; ?>" />       
        <input type="submit" name="Submit" value="<?php echo $strSearchTitle; ?>" class=button>                    
      </td>
    </form>
             
    <td  colspan="2" align="right"> 
	<form  method="get" action="product_conadd.php">
      <input type="Submit" name="Button" value="<?php echo $strProductAddButton; ?>" class="button" >
	  </form>
    </td>
  </tr>
</table>
</div>

<form name="delfm" method="post" action="product_con.php">
<div class="listzone">

<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center" >
  <tr class="list"> 
    <td width="30" align="center"  class="biaoti"  style="cursor:pointer" onClick="ord('id','<?php echo $sc; ?>')"><?php echo $strSel; ?></td>
    <td width="39"  class="biaoti"  style="cursor:pointer" onClick="ordsc('id','<?php echo $sc; ?>')"><?php echo $strProductList2; ordsc( $ord, "id", $sc ); ?></td>
    <td  class="biaoti" width="30"><?php echo $strProductList3; ?> 
    </td>
    <td height="28" class="biaoti" style="cursor:pointer" onClick="ordsc('title','<?php echo $sc; ?>')"><?php echo $strProductList4; ordsc( $ord, "title", $sc );?></td>
    <td width="75"  class="biaoti"  ><?php echo $strProductCat; ?></td>
    <td height="28" width="80"  class="biaoti"  ><?php echo $strProductFBR; ?></td>
    <td height="28" width="75"  class="biaoti"  style="cursor:pointer" onClick="ordsc('uptime','<?php echo $sc; ?>')"><?php echo $strUptime; ordsc( $ord, "uptime", $sc );?></td>
    <td width="35" height="28"  class="biaoti"><?php echo $strProductList14; ?></td>
    <td width="35" height="28"  class="biaoti"><?php echo $strProductList6; ?> 
    </td>
    <td width="35" height="28"  class="biaoti"><?php echo $strProductList7; ?></td>
    <td width="35"  class="biaoti"  ><?php echo $strSecure; ?></td>
    <td width="35"  class="biaoti"><div align="center"><?php echo $strReflesh; ?></div></td>
    <td width="35" height="28"  class="biaoti"> 
      <div align="center"><?php echo $strProductList9; ?></div>
    </td>
    </tr>
    
<?php
$msql->query( "select * from {P}_product_con where {$scl}  order by {$ord} {$sc}  limit {$pagelimit}" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$catid = $msql->f( "catid" );
		$memberid = $msql->f( "memberid" );
		$title = $msql->f( "title" );
		$xuhao = $msql->f( "xuhao" );
		$cl = $msql->f( "cl" );
		$tj = $msql->f( "tj" );
		$ifbold = $msql->f( "ifbold" );
		$ifred = $msql->f( "ifred" );
		$iffb = $msql->f( "iffb" );
		$author = $msql->f( "author" );
		$src = $msql->f( "src" );
		$type = $msql->f( "type" );
		$secure = $msql->f( "secure" );
		$uptime = $msql->f( "uptime" );
		$uptime = date( "y/m/d", $uptime );
		if ( $ifred == "0" )
		{
				$tcolor = "#555";
		}
		else
		{
				$tcolor = $ifred;
		}
		if ( $ifbold == "0" )
		{
				$tbold = "nomal";
		}
		else
		{
				$tbold = "bold";
		}
		if ( $catid == "0" )
		{
				$cat = $strPersonPic;
		}
		else
		{
				$fsql->query( "select cat from {P}_product_cat where catid='{$catid}'" );
				if ( $fsql->next_record( ) )
				{
						$cat = $fsql->f( "cat" );
				}
		}
		$browseurl = ROOTPATH."product/html/?".$id.".html";
		echo " 
    <tr class=\"list\"> 
      <td width=\"30\" align=\"center\" height=\"26\"> 
        <input type=\"checkbox\" name=\"dall[]\" value=\"".$id."\" />
      </td>
      <td width=\"39\" height=\"26\"> ".$id." </td>
      <td width=\"30\">";
		if ( $src == "" )
		{
				echo "<img id='preview_".$id."' class='preview' src='images/noimage.gif' >";
		}
		else
		{
				echo "<img id='preview_".$id."' class='preview' src='images/image.gif' >";
		}
		echo " <input type=\"hidden\" id=\"previewsrc_".$id."\"  value=\"".$src."\">
      </td>
      <td><a href=\"".$browseurl."\" target=\"_blank\" style=\"color:".$tcolor.";font-weight:".$tbold."\">".$title."</a></td>
      <td width=\"75\" >".$cat."</td>
      <td width=\"75\" >".$author."</td>
      <td width=\"75\">".$uptime."</td>
      <td width=\"35\"> ";
		showyn( $iffb );
		echo "</td>
      <td width=\"35\"> ";
		showyn( $tj );
		echo " </td>
      <td width=\"35\"> ";
		showyn( $ifbold );
		echo " </td>
      <td width=\"35\"> ".$secure."</td>
      <td width=\"35\"><img src=\"images/update.png\"  style=\"cursor:pointer\" onclick=\"self.location='product_con.php?step=refresh&id=".$id."'\" /> </td>
      <td width=\"35\"> 
        <div align=\"center\"> <img src=\"images/edit.png\" style=\"cursor:pointer\" onClick=\"window.location='product_conmod.php?id=".$id."&pid=".$pid."&page=".$page."'\"> 
        </div>
      </td>
      </tr>
    ";
}
?>
 
   </table>
  </div>
      <div class="piliang"> 
        <input type="checkbox" name="SELALL" value="1" onClick="SelAll(this.form)">
        <?php echo $strSelAll; ?>&nbsp; 
        <input type="radio" name="step" value="delall">
        <?php echo $strDelete; ?> 
      <input type="radio" name="step" value="setfb" checked>
		
<select name="iffb" id="iffb">
          <option value="1"><?php echo $strProductFb; ?></option>
           <option value="0"><?php echo $strProductNotFb; ?></option>
        </select>
		
        <input type="radio" name="step" value="settj">
        
<select name="tj" id="tj">
          <option value="1"><?php echo $strProductTj; ?></option>
           <option value="0"><?php echo $strProductNotTj; ?></option>
        </select>
        <input type="radio" name="step" value="setsecure">
        
<select name="secure" id="secure">
          <option value="0"><?php echo $strSecure1; ?></option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
        </select>
        <input type="radio" name="step" value="setbold">
        
<select name="bold" id="bold">
          <option value="1"><?php echo $strProductBold; ?></option>
          <option value="0"><?php echo $strProductNotBold; ?></option>
        </select>
       
        <input type="radio" name="step" value="setcolor">
		
<select name="nowcolor" id="nowcolor">
          <option value="0"><?php echo $strDefColor; ?></option>
          <option value="#ff0000" style="background:#ff0000">&nbsp;</option>
		   <option value="#ff6600" style="background:#ff6600">&nbsp;</option>
		   <option value="#0080c0" style="background:#0080c0">&nbsp;</option>
		    <option value="#008000" style="background:#008000">&nbsp;</option>
			<option value="#ffcc00" style="background:#ffcc00">&nbsp;</option>
			<option value="#800080" style="background:#800080">&nbsp;</option>
			<option value="#804040" style="background:#804040">&nbsp;</option>
			<option value="#ff00ff" style="background:#ff00ff">&nbsp;</option>
			<option value="#80ffff" style="background:#80ffff">&nbsp;</option>
			<option value="#000000" style="background:#000000">&nbsp;</option>
		</select>
		<input class="button" type="button" value="<?php echo $strSubmit; ?>" onClick="delfm.submit()">
        <input type="hidden" name="page" size="3" value="<?php echo $page; ?>" />
        <input type="hidden" name="ord" size="3" value="<?php echo $ord; ?>" />
        <input type="hidden" name="sc" size="3" value="<?php echo $sc; ?>" />
        <input type="hidden" name="key" size="3" value="<?php echo $key; ?>" />
       
        <input type="hidden" name="showtj" value="<?php echo $showtj; ?>" />
        <input type="hidden" name="showfb" value="<?php echo $showfb; ?>" />
        <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
        <input type="hidden" name="shownum" value="<?php echo $shownum; ?>" />       
      </div>
  </form>

<?php
$pagesinfo = $pages->shownow( );
?>
<div id="showpages">
	  <div id="pagesinfo"><?php echo $strPagesTotalStart.$totalnums.$strPagesTotalEnd; ?> <?php echo $strPagesMeiye.$pagesinfo['shownum'].$strPagesTotalEnd; ?> <?php echo $strPagesYeci; ?> <?php echo $pagesinfo['now']."/".$pagesinfo['total']; ?></div>
	  <div id="pages"><?php echo $pages->output( 1 ); ?></div>
</div>
</body>
</html>