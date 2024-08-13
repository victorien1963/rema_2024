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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="js/paycenter.js"></script>
</head>
<body >

<?php
$id = $_REQUEST['id'];
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
if ( $step == "modify" )
{
		if(is_array($pcenteruser)){
			$pcenterusers = $pcenteruser[0]."-".$pcenteruser[1];
		}else{
			$pcenterusers = $pcenteruser;
		}
		
		if ( $pcenter == "" )
		{
				err( $strPayTypeNTC4, "", "" );
				exit( );
		}
		if ( $pcentertype == "0" )
		{
				$hbtype = "";
		}
		$msql->query( "update {P}_member_paycenter set
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
	`intro`='{$intro}' where id='{$id}'	" );
		echo "<script>window.location='paycenter.php'</script>";
		exit( );
}
?>
<div class="formzone">
<div class="namezone"><?php echo $strPayTypeSet; ?></div>
<div class="tablezone">

<?php
$msql->query( "select * from {P}_member_paycenter where id='{$id}'" );
if ( $msql->next_record( ) )
{
		$pcenter = $msql->f( "pcenter" );
		$pcentertype = $msql->f( "pcentertype" );
		$pcenteruser = $msql->f( "pcenteruser" );
		$pcenterkey = $msql->f( "pcenterkey" );
		$postfile = $msql->f( "postfile" );
		$recfile = $msql->f( "recfile" );
		$key1 = $msql->f( "key1" );
		$key2 = $msql->f( "key2" );
		$ifuse = $msql->f( "ifuse" );
		$ifback = $msql->f( "ifback" );
		$hbtype = $msql->f( "hbtype" );
		$intro = $msql->f( "intro" );
		$xuhao = $msql->f( "xuhao" );
}
?>
 <form action="paycenter_modify.php" method="post" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" align="center"  id="tablePayCenter">
   
      <tr>
        <td height="8" colspan="3" ></td>
      </tr>
      <tr>
        <td width="100" height="38" align="right">
<span class="title"><?php echo $strPaycenterType; ?></span></td>
        <td width="5" align="right">&nbsp;</td>
        <td height="38"><input name="pcentertype" class="pcentertype" type="radio" value="0" <?php echo checked( $pcentertype, "0" ); ?>  />
            <?php echo $strPayType0; ?>			<input type="radio" name="pcentertype"  class="pcentertype"  value="1" <?php echo checked( $pcentertype, "1" ); ?>  />
            <?php echo $strPayType1; ?></td>
      </tr>
      <tr>
        <td width="100" align="right">
<span class="title"><?php echo $strPaycenterName; ?></span></td>
        <td width="5" align="right">&nbsp;</td>
        <td><input name="pcenter" type="text"  class="input" id="pcenter" value="<?php echo $pcenter; ?>" size="51" />
            <font color="#FF3300">* </font></td>
      </tr>
      <tr>
        <td width="100" align="right">
<span class="title"><?php echo $strPaycenterIntro; ?></span></td>
        <td width="5" align="right">&nbsp;</td>
        <td><textarea name="intro" cols="50" rows="5" class="textarea" id="intro"><?php echo $intro; ?></textarea>
        </td>
      </tr>
      <tr class="tronline" style="display:none">
        <td width="100" align="right">
<span class="title"><?php echo $strPayOnlinePort; ?></span></td>
        <td width="5" align="right">&nbsp;</td>
        <td>
<select name="hbtype" id="hbtype">		  
		  <option value="chinatrust_card" <?php echo seld( "chinatrust_card", $hbtype ); ?>>中國信託線上刷卡(Card)交易接口</option>
			<option value="tcbbank_card" <?php echo seld( "tcbbank_card", $hbtype ); ?>>合作金庫線上刷卡(Card)交易接口</option>
			<option value="tcbbank_card_2" <?php echo seld( "tcbbank_card_2", $hbtype ); ?>>合作金庫線上刷卡(Card)交易接口(2)</option>
          <option value="alipay_db" <?php echo seld( "alipay_db", $hbtype ); ?>>大陸支付寶擔保交易接口</option>          
        </select></td>
      </tr>
	  </table>
	  <table width="100%" border="0" cellspacing="1" cellpadding="3" align="center" >
      <tr>
        <td width="100" align="right">
<span class="title"><?php echo $strIdx; ?></span></td>
        <td width="5" align="right">&nbsp;</td>
        <td><input name="xuhao" type="text"  class="input" id="xuhao" value="<?php echo $xuhao; ?>" size="6" /></td>
      </tr>
      <tr>
        <td width="100" align="right"><?php echo $strPaycenterIfUse; ?></td>
        <td width="5" align="right">&nbsp;</td>
        <td><input name="ifuse" type="checkbox" id="ifuse" value="1" <?php echo checked( $ifuse, "1" ); ?> />
            <?php echo $strPaycenterUse; ?></td>
      </tr>
      <tr>
        <td width="100" align="right">&nbsp;</td>
        <td width="5" align="right">&nbsp;</td>
        <td height="36"><input type="submit" name="Submit" value="<?php echo $strConfirm; ?>" class="button" />
            <input type="hidden" name="step" id="step" value="modify" />
            <input name="id" type="hidden" id="id" value="<?php echo $id; ?>" />
        </td>
      </tr>
    
  </table>
</form>
  
</div>
</div>
</body>
</html>