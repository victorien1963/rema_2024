<?phpdefine( "ROOTPATH", "../../" );include( ROOTPATH."includes/admin.inc.php" );include( "language/".$sLan.".php" );needauth( 310 );$step = $_REQUEST['step'];?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head ><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><link  href="css/style.css" type="text/css" rel="stylesheet"><title><?php echo $strAdminTitle;?></title><script type="text/javascript" src="../../base/js/base.js"></script><script type="text/javascript" src="../../base/js/form.js"></script><script type="text/javascript" src="../../base/js/blockui.js"></script><script type="text/javascript" src="js/conf.js"></script></head><body><?phpif ( $step == "modify" ){		$var = $_POST['var'];		while ( list( $key, $val ) = each($var) )		{				$msql->query( "update {P}_shop_config set value='{$val}' where variable='{$key}'" );		}		$priceset = $_POST['priceset'];		if ( $priceset != "" && is_array( $priceset ) )		{				while ( list( $key, $val ) = each($priceset) )				{						$msql->query( "update {P}_shop_pricerule set `pr`='{$val}' where membertypeid='{$key}'" );				}		}		sayok( $strConfigOk, "config.php", "" );}?><div class="formzone"><form name="form1" method="post" action="config.php"><div class="tablezone">          <table width="100%" border="0" align="center" cellpadding="8" cellspacing="0">            <tr>               <td class="innerbiaoti"><strong><?php echo $strConfigName;?></strong></td>              <td class="innerbiaoti"  width="300" height="28"><strong><?php echo $strConfigSet;?></strong></td>            </tr><?php	// 	if( $_COOKIE['SYSUSER'] != 'wayhunt'){// 		$scl = "WHERE variable='noReturnCode' ";// 	}$msql->query( "select * from {P}_shop_config $scl order by xuhao" );while ( $msql->next_record( ) ){		$variable = $msql->f( "variable" );		$value = $msql->f( "value" );		$vname = $msql->f( "vname" );		$settype = $msql->f( "settype" );		$colwidth = $msql->f( "colwidth" );		$intro = $msql->f( "intro" );		$intro = str_replace( "\n", "<br>", $intro );		echo "<tr class=\"list\" id=\"tr_".$variable."\">              <td style=\"line-height:20px;padding-right:30px\">            <strong>".$vname." : </strong><br>".$intro."</td>              <td   width=\"300\" height=\"20\">";		if ( $settype == "YN" )		{				echo "<input type=\"radio\" name=\"var[".$variable."]\" value=\"1\" ".checked( $value, "1" ).">".$strYes."<input type=\"radio\" name=\"var[".$variable."]\" value=\"0\" ".checked( $value, "0" ).">".$strNo;		}		else if ( $settype == "pricerule" )		{				echo "<select name=\"var[".$variable."]\" >                  <option value=\"1\" ".seld( $value, 1 )." >".$strPriceRule1."</option>				  <option value=\"2\" ".seld( $value, 2 )." >".$strPriceRule2."</option>                </select>";		}		else if ( $settype == "centmodle" )		{				echo "<select name=\"var[".$variable."]\" >                  <option value=\"1\" ".seld( $value, 1 )." >".$strShopCentModle1."</option>				  <option value=\"2\" ".seld( $value, 2 )." >".$strShopCentModle2."</option>                </select>                ";		}		else if ( $settype == "centlist" )		{				$fsql->query( "select * from {P}_member_centset" );				if ( $fsql->next_record( ) )				{						$centname1 = $fsql->f( "centname1" );						$centname2 = $fsql->f( "centname2" );						$centname3 = $fsql->f( "centname3" );						$centname4 = $fsql->f( "centname4" );						$centname5 = $fsql->f( "centname5" );				}				echo "<select name=\"var[".$variable."]\" >				  <option value=\"1\" ".seld( $value, 1 )." >".$centname1."</option>                  <option value=\"2\" ".seld( $value, 2 ).">".$centname2."</option>				  <option value=\"3\" ".seld( $value, 3 ).">".$centname3."</option>				  <option value=\"4\" ".seld( $value, 4 ).">".$centname4."</option>				  <option value=\"5\" ".seld( $value, 5 ).">".$centname5."</option>                </select>";		}		elseif ( $settype == "text" )		{				echo " <textarea name=\"var[".$variable."]\" cols=\"".$colwidth."\" rows=\"5\" class=\"textarea\"/>".$value."</textarea>";		}		else		{				echo "<input  type=\"text\" name=\"var[".$variable."]\"   value=\"".$value."\" size=\"".$colwidth."\" class=\"input\" />";		}		echo "</td></tr>";}?>    </table></div><div class="adminsubmit">  <input name="cc2" type="submit" id="cc" value="<?php echo $strSubmit;?>" class="button" />  <input type="hidden" name="step" value="modify" /></div></form></div><br><br><br><br></body></html>