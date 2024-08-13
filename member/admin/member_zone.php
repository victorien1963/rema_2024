<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 61 );

$step = $_REQUEST['step'];
$pid = $_REQUEST['pid'];
$cat = $_REQUEST['cat'];
$catid = $_REQUEST['catid'];
$xuhao = $_REQUEST['xuhao'];
$postcode = $_REQUEST['postcode'];

	/*$msql->query( "SELECT * FROM {P}_member_zone" );
	while($msql->next_record()){
		$strs[] = array($msql->f('id'),$msql->f('pid'),$msql->f('cat'),$msql->f('xuhao'),$msql->f('catpath'),$msql->f('postcode'));
	}
	$msql->query( "TRUNCATE TABLE {P}_member_zone" );
	$msql->query( "insert into {P}_member_zone values ('1','0','臺灣','1','0001:','')" );
	$msql->query( "insert into {P}_member_zone values ('2','0','中國','2','0002:','')" );
	$msql->query( "insert into {P}_member_zone values ('3','0','香港','3','0003:','')" );
	$msql->query( "insert into {P}_member_zone values ('4','0','新加坡','4','0004:','')" );
	
	foreach($strs AS $kk=>$vv){
		$oripid = $vv[1];
		if($oripid == "0"){
			$pid = 1;
			$getpath = fmpath( $kk+5 ).":";
		}else{
			$pid = $oripid+4;
			$getpath = fmpath( $pid ).":".fmpath( $kk+5 ).":";
		}
		$cat = $vv[2];
		$xuhao = $vv[3];
		$catpath = "0001:".$getpath;
		$postcode = $vv[5];
		$msql->query( "insert into {P}_member_zone values (NULL,'$pid','$cat','$xuhao','$catpath','$postcode')" );
	}*/
	/*$msql->query( "SELECT * FROM {P}_member_zone WHERE catid>='392' AND catid<='395'" );
	while($msql->next_record()){
		$thisid = $msql->f('catid');
		$newcatpath = str_replace("0029","0026",$msql->f('catpath'));
		$newpid = 26;
		$fsql->query( "UPDATE {P}_member_zone SET pid='$newpid',catpath='$newcatpath' WHERE catid='$thisid'" );
	}*/
/*多國語言設置-STR*/
//複製資料表結構
if($_GET["addLanSQL"]){
	$msql->query("CREATE TABLE {P}_".$_GET["addLanSQL"]."_member_zone LIKE {P}_member_zone");
}
//複製資料
if($_GET["adminlan"] && $_GET["lancopy"]){
	
	$msql->query("SELECT * FROM {P}_member_zone");
	while($msql->next_record()){
		$thisid = $msql->f("catid");
		$fsql->query("SELECT * FROM {P}_".$_GET["adminlan"]."_member_zone WHERE `catid`='$thisid'");
		if(!$fsql->next_record()){
			$tsql->query( "INSERT {P}_".$_GET["adminlan"]."_member_zone SELECT * FROM {P}_member_zone WHERE catid='$thisid'" );
		}
	}
}
$orilans = $GLOBALS['GLOBALS']['CONF']['LANTYPE'];
$getlans = $GLOBALS['GLOBALS']['CONF']['OTHLANTYPE'];
$lanlist .= '<input type="button" class="button" onclick="window.location=\''.$_SERVER['PHP_SELF'].'?adminlan='.$orilans.'\'" value="修改預設語言資料" style="cursor:pointer;margin-left:5px;">';
	$lanslist = explode(",",$getlans);
	foreach($lanslist AS $lans){
		$msql->query("SHOW TABLES LIKE '{P}_".$lans."_member_zone'");
		if($msql->num_rows()){
			if($lantype == "_".$lans){
				$chkthis = "color:#fff;background-color:#ff6600";
				$noedit = "style='display:none;'";
			}else{
				$chkthis = "";
			}
			$lanlist .= '<input type="button" class="button" onclick="window.location=\''.$_SERVER['PHP_SELF'].'?adminlan='.$lans.'\'" value="修改 '.$lans.'資料" style="cursor:pointer;margin-left:5px;'.$chkthis.'">';
			$lanlist .= '<input type="button" class="button" onclick="window.location=\''.$_SERVER['REQUEST_URI'].'?&adminlan='.$lans.'&lancopy=1\'" value="複製到 '.$lans.'語言" style="cursor:pointer;margin-left:5px;">';
		}else{
			$lanlist .= '<input type="button" class="button" onclick="window.location=\''.$_SERVER['PHP_SELF'].'?&addLanSQL='.$lans.'\'" value="新增 '.$lans.'資料結構" style="cursor:pointer;margin-left:5px;">';
		}
	}
/*多國語言設置-END*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script>
function checkform(theform){

  if(theform.cat.value.length < 1 || theform.cat.value=='<?php echo $strSetZonentc; ?>'){
    alert("<?php echo $strSetZonentc; ?>");
    theform.cat.focus();
    return false;
}  
	return true;
}  
</script>
</head>
<body>

<?php

if ( !isset( $pid ) || $pid == "" )
{
		$pid = 0;
}
if ( $step == "add" && $cat != "" && $cat != " " )
{
		$cat = htmlspecialchars( $cat );
		if ( $pid != "0" )
		{
				$msql->querylan( "select catpath from {P}_member_zone where catid='{$pid}' " );
				if ( $msql->next_record( ) )
				{
						$pcatpath = $msql->f( "catpath" );
				}
		}
		if ( 10 < strlen( $pcatpath ) )
		{
				err( $strSetZoneNotice1, "", "" );
		}
		$msql->querylan( "select max(xuhao) from {P}_member_zone where pid='{$pid}' " );
		if ( $msql->next_record( ) )
		{
				$maxxuhao = $msql->f( "max(xuhao)" );
				$nowxuhao = $maxxuhao + 1;
		}
		$msql->querylan( "insert into {P}_member_zone values (0,'{$pid}','{$cat}','{$nowxuhao}','{$catpath}','{$postcode}')" );
		$nowcatid = $msql->instid( );
		$nowpath = fmpath( $nowcatid );
		$catpath = $pcatpath.$nowpath.":";
		$msql->querylan( "update {P}_member_zone set catpath='{$catpath}' where catid='{$nowcatid}' " );
		echo "<script>self.location='member_zone.php?pid={$pid}'</script>";
}
if ( $step == "del" )
{
		$msql->query( "select memberid from {P}_member where zoneid='{$catid}'  " );
		if ( $msql->next_record( ) )
		{
				err( $strSetZoneNotice2, "", "" );
		}
		$msql->querylan( "select catid from {P}_member_zone where pid='{$catid}' " );
		if ( $msql->next_record( ) )
		{
				err( $strSetZoneNotice3, "", "" );
		}
		$msql->querylan( "delete from {P}_member_zone where catid='{$catid}'" );
		echo "<script>self.location='member_zone.php?pid={$pid}'</script>";
}
if ( $step == "modify" && $cat != "" && $cat != " " )
{
		$cat = htmlspecialchars( $cat );
		$msql->querylan( "update {P}_member_zone set cat='{$cat}',xuhao='{$xuhao}',postcode='{$postcode}' where catid='{$catid}'  " );
		echo "<script>self.location='member_zone.php?pid={$pid}'</script>";
}
?>
<div class="formzone">
	<div class="tablezone">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		    <tr>
		      <td><?php echo $lanlist;?></td>
		    </tr>
		</table>
	</div>
</div>
<div class="searchzone">
 
 <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center" height="30">
  <tr > 
   <td >   
<select name="pid" onChange="self.location=this.options[this.selectedIndex].value">
	  <option value='member_zone.php'><?php echo $strSetZoneSel; ?></option>
         
<?php
$fsql->querylan( "select * from {P}_member_zone order by catpath" );
while ( $fsql->next_record( ) )
{
		$lpid = $fsql->f( "pid" );
		$lcatid = $fsql->f( "catid" );
		$cat = $fsql->f( "cat" );
		$catpath = $fsql->f( "catpath" );
		$lcatpath = explode( ":", $catpath );		
		for ( $i = 0;	$i < sizeof( $lcatpath ) - 2;	$i++	)
		{
				$tsql->querylan( "select catid,cat from {P}_member_zone where catid='{$lcatpath[$i]}'" );
				if ( $tsql->next_record( ) )
				{
						$ncatid = $tsql->f( "cat" );
						$ncat = $tsql->f( "cat" );
						$ppcat .= $ncat."/";
				}
		}
		if ( $pid == $lcatid )
		{
				echo "<option value='member_zone.php?pid=".$lcatid."' selected>".$ppcat.$cat."</option>";
		}
		else
		{
				echo "<option value='member_zone.php?pid=".$lcatid."'>".$ppcat.$cat."</option>";
		}
		$ppcat = "";
}
?>
        </select>    </td> 
      <td align="right"> 
        <form method="get" action="member_zone.php" onSubmit="return checkform(this)" />
		<input type="hidden" name="step" value="add"  /> 
<select name="pid" id="pid" >
          <option value='0'><?php echo $strSetZoneAdd1; ?></option>
          
<?php
$fsql->querylan( "select * from {P}_member_zone order by catpath" );
while ( $fsql->next_record( ) )
{
		$lpid = $fsql->f( "pid" );
		$lcatid = $fsql->f( "catid" );
		$cat = $fsql->f( "cat" );
		$catpath = $fsql->f( "catpath" );
		$lcatpath = explode( ":", $catpath );
		for ( $i = 0;	$i < sizeof( $lcatpath ) - 2;	$i++	)
		{
				$tsql->querylan( "select catid,cat from {P}_member_zone where catid='{$lcatpath[$i]}'" );
				if ( $tsql->next_record( ) )
				{
						$ncatid = $tsql->f( "cat" );
						$ncat = $tsql->f( "cat" );
						$ppcat .= $ncat."&gt;";
				}
		}
		if ( $pid == $lcatid )
		{
				echo "<option value='".$lcatid."' selected>".$strZoneLocat1.$ppcat.$cat."</option>";
		}
		else
		{
				echo "<option value='".$lcatid."'>".$strZoneLocat1.$ppcat.$cat."</option>";
		}
		$ppcat = "";
}
?>
        </select>
        <input name="cat" type="text" class="input" value="<?php echo $strSetZonentc; ?>" onFocus="this.value=''" size="18" />
        <input type="submit" name="Submit" value="<?php echo $strSetZoneAdd; ?>" class="button" />
		</form>
    </td> 
  </tr>
</table>

</div>
<div class="listzone">
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr> 
    <td width="60" align="center" class="biaoti"><?php echo $strSetZoneId; ?></td>
    <td width="120" class="biaoti"><?php echo $strSetZoneXuhao; ?></td>
    <td width="80" class="biaoti"><?php echo $strSetPostCode; ?>/國碼</td>
    <td  class="biaoti"><?php echo $strSetZoneName; ?></td>
    <td width="38"  class="biaoti" align="center"><?php echo $strModify; ?></td>
    <td width="38" align="center"  class="biaoti"><?php echo $strDelete; ?></td>
  </tr>
  
<?php
$msql->querylan( "select * from {P}_member_zone where   pid='{$pid}' order by xuhao" );
while ( $msql->next_record( ) )
{
		$catid = $msql->f( "catid" );
		$cat = $msql->f( "cat" );
		$xuhao = $msql->f( "xuhao" );
		$pid = $msql->f( "pid" );
		$catpath = $msql->f( "catpath" );
		$postcode = $msql->f( "postcode" );
		echo " 
  <tr class=\"list\"> 
    <td width=\"60\" align=\"center\" >".$catid."</td>
    <form method=\"get\" action=\"member_zone.php\">
      <td width=\"120\" > 
        <input type=\"text\" name=\"xuhao\" size=\"4\" value=\"".$xuhao."\" class=input>
      </td>
      <td width=\"120\" > 
        <input type=\"text\" name=\"postcode\" size=\"6\" value=\"".$postcode."\" class=input>
      </td>
      <td> 
        <input type=\"text\" name=\"cat\" size=\"30\" value=\"".$cat."\" class=input>
        <input type=\"hidden\" name=\"catid\" value=\"".$catid."\">
        <input type=\"hidden\" name=\"pid\" value=\"".$pid."\">
        <input type=\"hidden\" name=\"step\" value=\"modify\">
      </td>
      <td width=\"38\"  > 
          <input type=\"image\" border=\"0\" name=\"imageField\" src=\"images/modi.png\" >
      </td>
      <td width=\"38\" align=\"center\"  ><img src=\"images/delete.png\"  style=\"cursor:pointer\"  border=0 onClick=\"self.location='member_zone.php?step=del&catid=".$catid."&pid=".$pid."'\"> 
      </td>
    </form>
  </tr>
  ";
}
?>
 
</table>
</div>
</body>
</html>