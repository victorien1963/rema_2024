<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 311 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle;?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="../../base/js/form.js"></script>
<script type="text/javascript" src="../../base/js/blockui.js"></script>
<script type="text/javascript" src="js/yun.js"></script>
</head>
<body >

<?php
$step = $_REQUEST['step'];
$yunname = $_REQUEST['yunname'];
$zonestr = $_REQUEST['zonestr'];
$spec = $_REQUEST['spec'];
$dinge = $_REQUEST['dinge'];
$yunfei = $_REQUEST['yunfei'];
$baojia = $_REQUEST['baojia'];
$baofei = $_REQUEST['baofei'];
$baodi = $_REQUEST['baodi'];
$memo = $_REQUEST['memo'];
$sgs = $_REQUEST['sgs'];
if ( $step == "new" )
{
		$a1 = $_REQUEST['a1'];
		$b1 = $_REQUEST['b1'];
		$b2 = $_REQUEST['b2'];
		$c1 = $_REQUEST['c1'];
		$c2 = $_REQUEST['c2'];
		$c3 = $_REQUEST['c3'];
		$c4 = $_REQUEST['c4'];
		$d1 = $_REQUEST['d1'];
		$d2 = $_REQUEST['d2'];
		$d3 = $_REQUEST['d3'];
		$d4 = $_REQUEST['d4'];
		$e1 = $_REQUEST['e1'];
		$e2 = $_REQUEST['e2'];
		$f1 = $_REQUEST['f1'];
		$f2 = $_REQUEST['f2'];
		$gs = $a1."|".$b1."|".$b2."|".$c1."|".$c2."|".$c3."|".$c4."|".$d1."|".$d2."|".$d3."|".$d4."|".$e1."|".$e2."|".$f1."|".$f2;
		$m1 = $_REQUEST['m1'];
		$m2 = $_REQUEST['m2'];
		$m3 = $_REQUEST['m3'];
		$n1 = $_REQUEST['n1'];
		$n2 = $_REQUEST['n2'];
		$n3 = $_REQUEST['n3'];
		$p1 = $_REQUEST['p1'];
		$p2 = $_REQUEST['p2'];
		$p3 = $_REQUEST['p3'];
		$dgs = $m1."|".$m2."|".$m3."|".$n1."|".$n2."|".$n3."|".$p1."|".$p2."|".$p3;
		$msql->query( "select max(xuhao) from {P}_shop_yun" );
		if ( $msql->next_record( ) )
		{
				$maxxuhao = $msql->f( "max(xuhao)" );
		}
		$nowxuhao = $maxxuhao + 1;
		$msql->query( "insert into {P}_shop_yun set
 	yunname='{$yunname}',
 	spec='{$spec}',
  	dinge='{$dinge}',
   	yunfei='{$yunfei}',
 	gs='{$gs}',
 	dgs='{$dgs}',
  	sgs='{$sgs}',
 	baojia='{$baojia}',
  	baofei='{$baofei}',
   	baodi='{$baodi}',
 	zonestr='{$zonestr}',
 	memo='{$memo}',
	xuhao='{$nowxuhao}'

	" );
		echo "<script>window.location='yun_method.php'</script>";
		exit( );
}
?>
 
<div class="formzone">

<div class="namezone">
<?php echo $strYunMethodAdd;?></div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
   <form action="yun_add.php" method="post" enctype="multipart/form-data">
      <tr>
       <td width="75" align="center"><?php echo $strYunMethod;?></td>
       <td><input name="yunname" type="text"  class="input" id="yunname" style="width:220px"> 
       &nbsp; <?php echo $strYunSpec1;?></td>
     </tr>
	 <tr>
       <td width="75" align="center"><?php echo $strYunSpec;?></td>
       <td><input name="spec" type="text"  class="input" id="spec" style="width:220px" /> 
       &nbsp; <?php echo $strYunSpec2;?></td>
     </tr>
	 <tr>
       <td align="center"><?php echo $strYunMethodZone;?></td>
       <td><textarea name="showzonestr" style="width:220px" rows="5" class="textarea" id="showzonestr" readonly></textarea>
	   <input type="button" id="showzonebutton" class="button" value="<?php echo $strYunSelZones;?>" />
	   </td>
     </tr>
     <tr>
       <td width="75" align="center"><?php echo $strYunGs;?></td>
       <td><input type="radio" name="dinge" class="seldinge" value="1" checked />
           <?php echo $strYunGs1;?>         
		   <input name="dinge" type="radio" class="seldinge" value="0" />
           <?php echo $strYunGs2;?>           <input type="radio" name="dinge" class="seldinge" value="2" />
           <?php echo $strYunGs3;?> 
		   </td>
     </tr>
     <tr id='tryunfei' >
       <td width="75" align="center"><?php echo $strYunfei;?></td>
       <td><input name="yunfei" type="text"  class=input id="yunfei" value="0" size="10"> </td>
     </tr>
     <tr  id='trgs' style="display:none">
       <td width="75" align="center">&nbsp;</td>
       <td><table width="100%"  border="0" cellspacing="1" cellpadding="3">
         <tr>
           <td><?php echo $strYunC1;?>             <input name="a1" type="text"  class=input id="a1" value="<?php echo $a1;?>" size="10">
      <?php echo $strYunC2;?></td>
         </tr>
         <tr>
           <td><?php echo $strYunC3;?>             <input name="b1" type="text"  class=input id="b1" value="<?php echo $b1;?>" size="10">
      <?php echo $strZlDanwei.$strYunC4;?>, <?php echo $strYunC7;?>      <input name="b2" type="text"  class=input id="b2" value="<?php echo $b2;?>" size="10">
        <?php echo $strHbDanwei;?></td>
         </tr>
         <tr>
           <td><?php echo $strYunC3;?>             <input name="c1" type="text"  class=input id="c1" value="<?php echo $c1;?>" size="10">
      <?php echo $strZlDanwei.$strYunC4;?>, <?php echo $strYunC8;?>      <input name="c2" type="text"  class=input id="c2" value="<?php echo $c2;?>" size="10">
       <?php echo $strZlDanwei;?>       <input name="c3" type="text"  class=input id="c3" value="<?php echo $c3;?>" size="10">
      <?php echo $strHbDanwei;?>      <input name="c4" type="hidden" id="c4" value="1"></td>
         </tr>
         <tr>
           <td><?php echo $strYunC3;?>             <input name="d1" type="text"  class=input id="d1" value="<?php echo $d1;?>" size="10">
      <?php echo $strZlDanwei.$strYunC5;?>, <?php echo $strYunC8;?>      <input name="d2" type="text"  class=input id="d2" value="<?php echo $d2;?>" size="10">
      <?php echo $strZlDanwei;?>      <input name="d3" type="text"  class=input id="d3" value="<?php echo $d3;?>" size="10">
      <?php echo $strHbDanwei;?>      <input name="d4" type="hidden" id="d4" value="1"></td>
         </tr>
         <tr>
           <td><?php echo $strYunC6;?>             <input name="e1" type="text"  class=input id="e1" value="<?php echo $e1;?>" size="10">
             <?php echo $strHbDanwei.$strYunC5;?>, <?php echo $strYunC9;?>             <input name="e2" type="text"  class=input id="e2" value="<?php echo $e2;?>" size="10">
      % </td>
         </tr>
         <tr>
           <td><?php echo $strYunC6;?>             <input name="f1" type="text"  class=input id="f1" value="<?php echo $f1;?>" size="10">
             <?php echo $strHbDanwei.$strYunC5;?>, <?php echo $strYunC9;?>             <input name="f2" type="text"  class=input id="f2" value="<?php echo $f2;?>" size="10">
      %</td>
         </tr>
       </table></td>
     </tr>
     <tr  id='trdd' style="display:none">
       <td align="center">&nbsp;</td>
       <td><table width="100%"  border="0" cellspacing="1" cellpadding="3">
         <tr>
           <td><?php echo $strYunC6;?>             <input name="m1" type="text"  class=input id="m1" value="<?php echo $m1;?>" size="10"> 
             <?php echo $strHbDanwei.$strYunC4;?> &nbsp; &nbsp; 
      		 <input name="m2" type="text"  class=input id="m2" value="<?php echo $m2;?>" size="5"> 
      		 <?php echo $strHbDanwei;?>,<?php echo $strYunC10;?>      		 <input name="m3" type="text"  class=input id="m3" value="<?php echo $m3;?>" size="2">
      		 % </td>
         </tr>
         <tr>
           <td><?php echo $strYunC6;?>             <input name="n1" type="text"  class=input id="n1" value="<?php echo $n1;?>" size="10">
             <?php echo $strHbDanwei.$strYunC5;?> &nbsp; &nbsp; 
<input name="n2" type="text"  class=input id="n2" value="<?php echo $n2;?>" size="5">
<?php echo $strHbDanwei;?>,<?php echo $strYunC10;?> 
<input name="n3" type="text"  class=input id="n3" value="<?php echo $n3;?>" size="2">
% </td>
         </tr>
         <tr>
           <td><?php echo $strYunC6;?>             <input name="p1" type="text"  class=input id="p1" value="<?php echo $p1;?>" size="10" />
             <?php echo $strHbDanwei.$strYunC5;?> &nbsp; &nbsp; 
<input name="p2" type="text"  class=input id="p2" value="<?php echo $p2;?>" size="5" />
<?php echo $strHbDanwei;?>,<?php echo $strYunC10;?> 
<input name="p3" type="text"  class=input id="p3" value="<?php echo $p3;?>" size="2" />
% </td>
         </tr>
       </table></td>
     </tr>     
     <tr>
       <td width="75" align="center"><?php echo $strYunBaojia;?></td>
       <td><input type="radio" name="baojia" class="selbaojia" value="1" />
           <?php echo $strYes;?>           <input name="baojia" type="radio" class="selbaojia"  value="0" checked  />
           <?php echo $strNo;?> </td>
     </tr>
     <tr>
       <td align="center">&nbsp;</td>
       <td><?php echo $strYunNTC3;?></td>
     </tr>
     <tr id='trbaofei' style="display:none">
       <td width="75" align="center"><?php echo $strYunBaofei;?></td>
       <td><input name="baofei" type="text"  class=input id="baofei" value="0" size="10"> 
       %
         <?php echo $strYunC11;?>         <input name="baodi" type="text"  class=input id="baodi" value="1" size="10">
       <?php echo $strHbDanwei;?></td>
     </tr>     
     <tr>
       <td width="75" align="center"><?php echo $strYunIntro;?></td>
       <td><textarea name="memo" cols="60" rows="5" class="input1" id="memo"></textarea></td>
     </tr>
    <tr> 
      <td width="75" align="center">&nbsp;</td>
      <td height="36"> 
        <input type="submit" name="Submit" value="<?php echo $strYunMethodAdd;?>" class="button">
        <input type="hidden" name="step" value="new">
        <input name="zonestr" type="hidden" id="zonestr" /></td>
    </tr></form>
</table>
</div>
</div>
</body>
</html>