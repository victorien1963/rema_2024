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
        <td width="100" align="right" class="title">PayNow帳號(WebNo)</td>
        <td width="5" align="right" class="title">&nbsp;</td>
        <td><input name="pcenteruser" type="text"  class="input" id="pcenteruser" value="<?php echo $pcenteruser; ?>" size="35" /> (公司為統編；個人為身分證字號)
        </td>
      </tr>
      <tr >
        <td width="100" align="right">
<span class="title">商家交易碼</span></td>
        <td width="5" align="right">&nbsp;</td>
        <td><input name="pcenterkey" type="text"  class="input" id="pcenterkey" value="<?php echo $pcenterkey; ?>" size="35" /> 
          (交易碼為PayNow會員登入密碼) </td>
      </tr>
      <tr>
        <td align="right">程式交易連結</td>
        <td width="5" align="right">&nbsp;</td>
        <td><input name="key1" type="text"  class="input" id="key1" value="<?php echo $key1; ?>" size="35" />
		(請確認網址正確，否則將導致交易失敗)
		  <input name="postfile" type="hidden" id="postfile" value="paynow_atm_post.php" />
          <input name="recfile" type="hidden" id="recfile" value="paynow_atm_rec.php" />
	    </td>
      </tr>
</table>