<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
$act = $_POST['act'];
$payid = $_POST['payid'];
if ( $act == "modify" )
{
		$msql->query( "select * from {P}_member_paycenter where id='{$payid}'" );
		if ( $msql->next_record( ) )
		{
				$pcenteruser = $msql->f( "pcenteruser" );
				$pcenterkey = $msql->f( "pcenterkey" );
				$key1 = $msql->f( "key1" );
				$key2 = $msql->f( "key2" );
		}
}
?>

<table cellpadding="3" cellspacing="1" id="onlineTemp">
<tr >
        <td width="100" align="right" class="title">合作者身份</td>
        <td width="5" align="right" class="title">&nbsp;</td>
        <td><input name="pcenteruser" type="text"  class="input" id="pcenteruser" value="<?php echo $pcenteruser; ?>" size="35" /> 
          (partnerID ) </td>
      </tr>
      <tr >
        <td width="100" align="right">
<span class="title">安全校驗碼</span></td>
        <td width="5" align="right">&nbsp;</td>
        <td><input name="pcenterkey" type="text"  class="input" id="pcenterkey" value="<?php echo $pcenterkey; ?>" size="35" /> 
          (Key) </td>
      </tr>
      <tr>
        <td align="right">商家帳號</td>
        <td width="5" align="right">&nbsp;</td>
        <td><input name="key1" type="text"  class="input" id="key1" value="<?php echo $key1; ?>" size="35" />
		(支付寶帳號郵箱)
		  <input name="postfile" type="hidden" id="postfile" value="alipay_db_post.php" />
          <input name="recfile" type="hidden" id="recfile" value="alipay_db_rec.php" />
	    </td>
      </tr>
</table>
