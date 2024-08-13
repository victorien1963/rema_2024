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
								list($pcenteruser_a, $pcenteruser_b) = explode("-",$msql->f( "pcenteruser" ));
								$pcenterkey = $msql->f( "pcenterkey" );
								$key1 = $msql->f( "key1" );
								$key2 = $msql->f( "key2" );
				}
}
?>
<table cellpadding="3" cellspacing="1" id="onlineTemp">
<tr >
        <td width="100" align="right" class="title">特店編號</td>
        <td width="5" align="right" class="title">&nbsp;</td>
        <td><input name="pcenteruser[]" type="text"  class="input" id="pcenteruser" value="<?php echo $pcenteruser_a; ?>" size="35" /> (merID)
        </td>
      </tr>
<tr >
        <td width="100" align="right" class="title">特店代碼</td>
        <td width="5" align="right" class="title">&nbsp;</td>
        <td><input name="pcenteruser[]" type="text"  class="input" id="pcenteruser" value="<?php echo $pcenteruser_b; ?>" size="35" /> (MerchantID)
        </td>
      </tr>
      <tr >
        <td width="100" align="right">
<span class="title">端末機代號</span></td>
        <td width="5" align="right">&nbsp;</td>
        <td><input name="pcenterkey" type="text"  class="input" id="pcenterkey" value="<?php echo $pcenterkey; ?>" size="35" /> (TerminalID)
          </td>
      </tr>
      <tr>
        <td align="right">網路刷卡網址</td>
        <td width="5" align="right">&nbsp;</td>
        <td><input name="key1" type="text"  class="input" id="key1" value="<?php echo $key1; ?>" size="35" />
		(請確認網址正確，否則將導致交易失敗)
	    </td>
      </tr>
<tr>
        <td align="right">系統回傳網址</td>
        <td width="5" align="right">&nbsp;</td>
        <td><input name="key2" type="text"  class="input" id="key2" value="<?php echo $key2; ?>" size="35" />
		(請確認網址正確，否則將導致判別是否付款失敗)
		  <input name="postfile" type="hidden" id="postfile" value="tcbbank_card_post.php" />
          <input name="recfile" type="hidden" id="recfile" value="tcbbank_card_rec.php" />
	    </td>
      </tr>
</table>