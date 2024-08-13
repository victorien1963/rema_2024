<?php
define("ROOTPATH", "../../");
include(ROOTPATH."includes/admin.inc.php");
include("language/".$sLan.".php");
NeedAuth(181);
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
<script type="text/javascript">
function cm(nn){
	qus=confirm("<?php echo $strDelAll;?>")
	if(qus!=0){
	window.location='shop_cat.php?step=delall';
	}
}
function abgne(c, o){
	o.style.display = c.checked?"block":"none";
}
</script>
</head>

<body >
<?php
$pid=$_REQUEST["pid"];
$step=$_REQUEST["step"];
$cc = $_REQUEST['cc'];
$catid = $_GET['id'];
$chgcat = $_GET['chgcat'];

if ( $step == "delall" )
{
				$msql->query( "SELECT * FROM {P}_product_con" );
				if($msql->next_record()){
				echo "<SCRIPT>alert(\"".$strDelAllMust."\");</SCRIPT>";
				}else{
				$msql->query( "TRUNCATE TABLE {P}_product_cat" );
				$msql->query( "TRUNCATE TABLE {P}_product_prop" );
				}

}

if ( $catid !="" && $chgcat !="" )
{
	if($chgcat == "0"){
								$msql->query( "select catpath from {P}_product_cat where catid='{$catid}'" );
								if ( $msql->next_record( ) )
								{
												$pcatpath = $msql->f( "catpath" );
								}
	$nowpath = fmpath( $catid );
	$catpath = $nowpath.":";
	$msql->query( "update {P}_product_cat set pid='0',catpath='{$catpath}' where catid='{$catid}'" );
	$msql->query( "UPDATE {P}_product_con SET catpath='{$catpath}' WHERE catid='{$catid}'" );
								$msql->query( "select catid,catpath from {P}_product_cat where pid>='{$catid}' AND catpath regexp '^{$pcatpath}.*' " );
								while ( $msql->next_record( ) )
								{
										$subcatpath = $msql->f( "catpath" );
										$subid = $msql->f( "catid" );
										$subcatpath = str_replace($pcatpath,$catpath,$subcatpath);
										$fsql->query( "update {P}_product_cat set catpath='{$subcatpath}' where catid='{$subid}'" );
										$fsql->query( "UPDATE {P}_product_con SET catpath='{$subcatpath}' WHERE catid='{$subid}'" );
								}
	}else{
								$msql->query( "select catpath from {P}_product_cat where catid='{$catid}'" );
								if ( $msql->next_record( ) )
								{
												$gcatpath = $msql->f( "catpath" );
								}
	$nowpath = fmpath( $catid );
								$msql->query( "select catpath from {P}_product_cat where catid='{$chgcat}'" );
								if ( $msql->next_record( ) )
								{
												$pcatpath = $msql->f( "catpath" );
												if(strpos($pcatpath,$nowpath) !== FALSE){
													err($strProductNotice10,"","");
													exit();
												}
								}
	$catpath = $pcatpath.$nowpath.":";
	$msql->query( "update {P}_product_cat set pid='{$chgcat}',catpath='{$catpath}' where catid='{$catid}'" );
	$msql->query( "UPDATE {P}_product_con SET catpath='{$catpath}' WHERE catid='{$catid}'" );
	
								$msql->query( "select catid,catpath from {P}_product_cat where catpath regexp '^{$gcatpath}.*' " );
								while ( $msql->next_record( ) )
								{
										$subcatpath = $msql->f( "catpath" );
										$subid = $msql->f( "catid" );
										$subcatpath = str_replace($gcatpath,$catpath,$subcatpath);
										$fsql->query( "update {P}_product_cat set catpath='{$subcatpath}' where catid='{$subid}'" );
										$fsql->query( "UPDATE {P}_product_con SET catpath='{$subcatpath}' WHERE catid='{$subid}'" );
								}
	}
}

if(!isset($pid) || $pid==""){
$pid=0;
}


if($step=="add" && $_REQUEST["cat"]!="" && $_REQUEST["cat"]!=" "){
	$cat= $_REQUEST["cat"];
	$cat=htmlspecialchars($cat);
	

	if($pid!="0"){
		$msql->query("select catpath from {P}_product_cat where catid='$pid'");
		if($msql->next_record()){
			$pcatpath=$msql->f('catpath');
		}
	}

	$msql->query("select max(xuhao) from {P}_product_cat where pid='$pid'");
		if($msql->next_record()){
			$maxxuhao=$msql->f('max(xuhao)');
			$nowxuhao=$maxxuhao+1;
		}

	$msql->query("insert into {P}_product_cat set
	`pid`='$pid',
	`cat`='$cat',
	`xuhao`='$nowxuhao',
	`catpath`='$catpath',
	`nums`='0',
	`tj`='0',
	`ifchannel`='0'
	");

    $nowcatid=$msql->instid();
	$nowpath=fmpath($nowcatid);
	$catpath=$pcatpath.$nowpath.":";

	$msql->query("update {P}_product_cat set catpath='$catpath' where catid='$nowcatid'");

}
if($step=="del"){

	$catid=$_GET["catid"];
	$pid=$_GET["pid"];
	

	$msql->query("select id from {P}_product_con where catid='$catid' ");
	if($msql->next_record()){
		err($strProductNotice1,"","");
		exit;
	}
	$msql->query("select catid from {P}_product_cat where pid='$catid'");
	if($msql->next_record()){
		err($strProductNotice2,"","");
		exit;
	}

	$msql->query("select ifchannel from {P}_product_cat where catid='$catid'");
	if($msql->next_record()){
		$ifchannel=$msql->f('ifchannel');
	}
	if($ifchannel!=0){
		err($strProductNotice9,"","");
		exit;
	}
	
	$msql->query("delete from {P}_product_cat where catid='$catid'");


}


if($step=="modi"){
	
	$cat=$_GET["cat"];
	$catid=$_GET["catid"];
	$pid=$_GET["pid"];
	$xuhao=$_GET["xuhao"];
	
	$tj=$_GET["tj"];
	$cat=htmlspecialchars($cat);

	$msql->query("update {P}_product_cat set cat='$cat',xuhao='$xuhao' where catid='$catid' ");

	$msql->query("update {P}_product_cat set tj='$tj' where catpath regexp '".fmpath($catid)."' ");


}

?> 
<div class="searchzone">
<table width="100%" border="0" cellspacing="0" cellpadding="2" height="30">
  <tr> 
   
                  
      <td width="80"  height="30"> 
	  <select name="pid" onChange="self.location=this.options[this.selectedIndex].value">
	  <option value='product_cat.php'><?php echo $strProductSelCat; ?></option>
         <?php
				$fsql -> query ("select * from {P}_product_cat order by catpath");
				while ($fsql -> next_record ()) {
					$lpid = $fsql -> f ("pid");
					$lcatid = $fsql -> f ("catid");
					$cat = $fsql -> f ("cat");
					$catpath = $fsql -> f ("catpath");
					$lcatpath = explode (":", $catpath);

					
					
						for ($i = 0; $i < sizeof ($lcatpath)-2; $i ++) {
							$tsql->query("select catid,cat from {P}_product_cat where catid='$lcatpath[$i]'");
							if($tsql->next_record()){
								$ncatid=$tsql->f('cat');
								$ncat=$tsql->f('cat');
								$ppcat.=$ncat."/";
							}
						}
						
						if($pid==$lcatid){
							echo "<option value='product_cat.php?pid=".$lcatid."' selected>".$ppcat.$cat."</option>";
						}else{
							echo "<option value='product_cat.php?pid=".$lcatid."'>".$ppcat.$cat."</option>";
						}
						$ppcat="";
					
					
				}
		 ?>
        </select>
        
                    
      </td>
    
             
  
      <td align="right" > <form name="addcat" method="get" action="product_cat.php"  onSubmit="return catCheckform(this)">
        <input type="hidden" name="step" value="add" />
        <select name="pid" id="pid" >
          <option value='0'><?php echo $strCatTopAdd; ?></option>
          <?php
				$fsql -> query ("select * from {P}_product_cat order by catpath");
				while ($fsql -> next_record ()) {
					$lpid = $fsql -> f ("pid");
					$lcatid = $fsql -> f ("catid");
					$cat = $fsql -> f ("cat");
					$catpath = $fsql -> f ("catpath");
					$lcatpath = explode (":", $catpath);

					
					
						for ($i = 0; $i < sizeof ($lcatpath)-2; $i ++) {
							$tsql->query("select catid,cat from {P}_product_cat where catid='$lcatpath[$i]'");
							if($tsql->next_record()){
								$ncatid=$tsql->f('cat');
								$ncat=$tsql->f('cat');
								$ppcat.=$ncat."&gt;";
							}
						}
						
						if($pid==$lcatid){
							echo "<option value='".$lcatid."' selected>".$strCatLocat1.$ppcat.$cat."</option>";
						}else{
							echo "<option value='".$lcatid."'>".$strCatLocat1.$ppcat.$cat."</option>";
						}
						$ppcat="";
					
					
				}
		 ?>
        </select>
        <input name="cat" type="text" class="input" value="<?php echo $strProductCatName; ?>" size="15" onFocus="this.value=''" />
        <input type="Submit" name="Submit" value="<?php echo $strCatAdd;?>" class="button" />
      </form>
	</td> 
  </tr>
</table>

</div>

<div class="listzone">

<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr>
    <td width="38"  class="biaoti"><?php echo $strNumber; ?></td>
    <td width="38"  class="biaoti"><?php echo $strCatTrn;?></td>
    <td width="38"  class="biaoti"><?php echo $strXuhao; ?></td>
    <td width="135"  class="biaoti"><?php echo $strCat; ?> </td>
    <td width="38"  class="biaoti"><?php echo $strProductList6; ?></td>
    <td width="100"  class="biaoti"><?php echo $strModify; ?></td>
    <td width="50"  class="biaoti"><?php echo $strCatTemp; ?></td>
    <td width="36"  class="biaoti"><?php echo $strZl; ?></td>
    <td  class="biaoti"><?php echo $strZlUrl; ?></td>
    <td width="38"  class="biaoti"><?php echo $strZlEdit; ?></td>
    <td width="38"  class="biaoti"><?php echo $strColProp; ?></td>
    <td width="38"  class="biaoti"><?php echo $strDelete; ?></td>
  </tr>
  <?php
$msql->query("select * from {P}_product_cat where  pid='$pid' order by xuhao");

while($msql->next_record()){
$catid=$msql->f("catid");
$cat=$msql->f("cat");
$xuhao=$msql->f("xuhao");
$pid=$msql->f("pid");
$tj=$msql->f("tj");
$catpath=$msql->f("catpath");
$ifchannel=$msql->f("ifchannel");
$ifcattemp = $msql->f( "cattemp" );

if($ifchannel=="1"){
	$href="../class/".$catid."/";
	$url="product/class/".$catid."/";
}else{
	$href="../class/?".$catid.".html";;
	$url="product/class/?".$catid.".html";
}

?> 
  <tr class="list">
    <td width="38"  ><?php echo $catid; ?>
    </td> 
    <form method="get" action="product_cat.php">
<?php
	echo "<td width=\"38\"><input type=\"checkbox\" id=\"setcat_".$catid."\" name=\"setcat\" class=\"setcat\" onclick=\"abgne(this, chgcat_".$catid.");\" />
		<div id=\"chgcat_".$catid."\" name=\"chgcat\" style=\"display:none\"><select name=\"pid\" onChange=\"self.location=this.options[this.selectedIndex].value\">
	  <option value='0'>".$strProductSelCat."</option>
 <option value='product_cat.php?chgcat=0&id=".$catid."'>".$strMainCat."</option>";
$fsql->query( "select * from {P}_product_cat order by catpath" );
while ( $fsql->next_record( ) )
{
				$lpid = $fsql->f( "pid" );
				$lcatid = $fsql->f( "catid" );
				$cats = $fsql->f( "cat" );
				$catpath = $fsql->f( "catpath" );
				$lcatpath = explode( ":", $catpath );
				for ( $i = 0;	$i < sizeof( $lcatpath ) - 2;	$i++	)
				{
								$tsql->query( "select catid,cat from {P}_product_cat where catid='{$lcatpath[$i]}'" );
								if ( $tsql->next_record( ) )
								{
												$ncatid = $tsql->f( "cat" );
												$ncat = $tsql->f( "cat" );
												$ppcat .= $ncat."/";
								}
				}

								echo "<option value='?chgcat=".$lcatid."&id=".$catid."'>".$ppcat.$cats."</option>";
				$ppcat = "";
}
echo "</select>
</div></td>";
	?>
      <td width="38"  > 
        <input type="text" name="xuhao" size="3" value="<?php echo $xuhao; ?>" class="input" />
      </td>
      <td width="135"  > 
        <input type="text" name="cat" size="16" value="<?php echo $cat; ?>" class="input" />
          <input type="hidden" name="catid" value="<?php echo $catid; ?>" />
        <input type="hidden" name="step" value="modi" />
        <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
        
      </td>
      <td width="38"  ><input type="checkbox" name="tj" value="1" <?php echo checked($tj,"1"); ?> /></td>
      <td width="100"><input type="image"  name="imageField" src="images/modi.png"  />
      </td>
      <td width="50">
	  <input type="checkbox" id="setcattemp_<?php echo $catid; ?>" name="setcattemp" value="<?php echo $catid; ?>" <?php echo checked( $ifcattemp, "1" ); ?> class="setcattemp" /></td>
      <td width="36"  ><input type="checkbox" id="setchannel_<?php echo $catid; ?>" name="setchannel" value="<?php echo $cat; ?>" <?php echo checked($ifchannel,"1"); ?> class="setchannel" />
        <input id="href_<?php echo $catid; ?>" type="hidden" name="href" value="<?php echo $href; ?>"  /></td>
      <td  id="url_<?php echo $catid; ?>"><A onclick="if(window.clipboardData.setData('text', '<?php echo $url;?>'))alert('<?php echo $strCopyOk;?>')" href="javascript:;"><button class="button"><?php echo $strCopyUrl;?></button></A>&nbsp;&nbsp;<a href='<?php echo $href; ?>' target='_blank'><?php echo $url; ?></a> </td>
      <td width="38"  ><img id='pr_<?php echo $catid; ?>' class='pr_enter' src="images/edit.png"  style="cursor:pointer"  border="0" /> </td>
      <td width="38"  ><img src="images/prop.png" border=0 style="cursor:pointer;display:<?php echo $listdis; ?>" onClick="Dpop('prop_frame.php?catid=<?php echo $catid; ?>&pid=<?php echo $pid; ?>','600','520')"  ></td>
      <td width="38"  > <img src="images/delete.png"  style="cursor:pointer"   border=0 onClick="self.location='product_cat.php?step=del&catid=<?php echo $catid; ?>&pid=<?php echo $pid; ?>'"></td>
    </form>
  </tr>
  <?php
}
?> 
</table>
</div>

</body>
</html>