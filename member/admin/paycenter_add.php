<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/member.inc.php" );
needauth( 69 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="js/paycenter.js"></script>
</head>
<body >

<?php
$step = $_REQUEST['step'];
$pcenter = $_REQUEST['pcenter'];
$pcentertype = $_REQUEST['pcentertype'];
$pcenteruser = $_REQUEST['pcenteruser'];
$pcenterkey = $_REQUEST['pcenterkey'];
$key1 = $_REQUEST['key1'];
$key2 = $_REQUEST['key2'];
$postfile = $_REQUEST['postfile'];
$recfile = $_REQUEST['recfile'];
$ifuse = $_REQUEST['ifuse'];
$intro = $_POST['intro'];
$xuhao = $_POST['xuhao'];
$hbtype = $_POST['hbtype'];
if ( $step == "new" )
{
		$pcenterusers = $pcenteruser[0]."-".$pcenteruser[1];
	
		if ( $pcenter == "" )
		{
				err( $strPayTypeNTC4, "", "" );
				exit( );
		}
		if ( $pcentertype == "0" )
		{
				$hbtype = "";
		}
		$msql->query( "insert into {P}_member_paycenter set
	`pcenter`='{$pcenter}',
 	`pcentertype`='{$pcentertype}',
  	`pcenteruser`='{$pcenterusers}',
  	`pcenterkey`='{$pcenterkey}',
  	`key1`='{$key1}',
  	`key2`='{$key2}',
   	`postfile`='{$postfile}',
  	`recfile`='{$recfile}',
   	`hbtype`='{$hbtype}',
 	`ifuse`='{$ifuse}',
  	`ifback`='1',
   	`xuhao`='{$xuhao}',
	`intro`='{$intro}'

	" );
		echo "<script>window.location='paycenter.php'</script>";
		exit( );
}
?>
<div class="formzone">
<div class="namezone"><?php echo $strPayTypeAdd; ?></div>
<div class="tablezone">
     <form action="paycenter_add.php" method="post" enctype="multipart/form-data">
 <table width="100%" border="0" cellspacing="1" cellpadding="3" align="center" id="tablePayCenter">
      <tr>
        <td height="8" colspan="3" ></td>
      </tr>
      <tr>
        <td width="100" height="38" align="right">
<span class="title"><?php echo $strPaycenterType; ?></span></td>
        <td width="5" align="right">&nbsp;</td>
        <td height="38"><input name="pcentertype" class="pcentertype" type="radio" value="0" checked="checked"  />
            <?php echo $strPayType0; ?>			<input type="radio" name="pcentertype"  class="pcentertype"  value="1" />
            <?php echo $strPayType1; ?></td>
      </tr>
      <tr>
        <td width="100" align="right">
<span class="title"><?php echo $strPaycenterName; ?></span></td>
        <td width="5" align="right">&nbsp;</td>
        <td><input name="pcenter" type="text"  class="input" id="pcenter" size="51" />
            <font color="#FF3300">* </font></td>
      </tr>
      <tr>
        <td width="100" align="right">
<span class="title"><?php echo $strPaycenterIntro; ?></span></td>
        <td width="5" align="right">&nbsp;</td>
        <td><textarea name="intro" cols="50" rows="5" class="textarea" id="intro"></textarea>
        </td>
      </tr>
      <tr class="tronline" style="display:none">
        <td align="right">
<span class="title"><?php echo $strPayOnlinePort; ?></span></td>
        <td width="5" align="right">&nbsp;</td>
        <td>
<select name="hbtype" id="hbtype">
    	  <option value="chinatrust_card">中國信託線上刷卡(Card)交易接口</option>
    		<option value="tcbbank_card">合作金庫線上刷卡(Card)交易接口</option>
    		<option value="tcbbank_card_2">合作金庫線上刷卡(Card)交易接口(2)</option>
          <option value="alipay_db">大陸支付寶擔保交易接口</option>
        </select></td>
      </tr>
      
       </table>
		 <table width="100%" border="0" cellspacing="1" cellpadding="3" align="center" >

        <tr><td width="100" align="right">
<span class="title"><?php echo $strIdx; ?></span></td>
        <td width="5" align="right">&nbsp;</td>
          <td><input name="xuhao" type="text"  class="input" id="xuhao" value="0" size="6" /></td>
      </tr>
      <tr>
        <td width="100" align="right"><?php echo $strPaycenterIfUse; ?></td>
        <td width="5" align="right">&nbsp;</td>
        <td><input name="ifuse" type="checkbox" id="ifuse" value="1" checked="checked" />
            <?php echo $strPaycenterUse; ?></td>
      </tr>
      <tr>
        <td width="100" align="right">&nbsp;</td>
        <td width="5" align="right">&nbsp;</td>
        <td height="36"><input type="submit" name="Submit" value="<?php echo $strConfirm; ?>" class="button" />
            <input type="hidden" name="step" id="step" value="new" />
        </td>
      </tr>
    
  </table>
</form>
  
</div>
</div>
</body>
</html>