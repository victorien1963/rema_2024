<?php

define( "ROOTPATH", "../../" );

include( ROOTPATH."includes/admin.inc.php" );

include( "language/".$sLan.".php" );

include( "func/member.inc.php" );

needauth( 53 );

$step = $_REQUEST['step'];

$memberid = $_REQUEST['memberid'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head >

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link  href="css/style.css" type="text/css" rel="stylesheet">

<script type="text/javascript" src="../../base/js/base132.js"></script>

<title><?php echo $strAdminTitle; ?></title>



<script>

function checkexp(exp){

	if(exp==0){

	ttt.style.visibility="hidden";	

	}else{

	ttt.style.visibility="visible";		

	}

}



</script>

</head>



<body>



<?php

if ( $step == "modify" )

{

		trylimit( "_member", 300, "memberid" );

		needauth( 54 );

		$user = $_POST['user'];

		$name = $_POST['name'];

		$pname = $_POST['pname'];

		$company = $_POST['company'];

		$sex = $_POST['sex'];

		$birth0 = $_POST['birth0'];

		$birth1 = $_POST['birth1'];

		$birth2 = $_POST['birth2'];

		$addr = $_POST['addr'];

		$tel = $_POST['tel'];

		$mov = $_POST['mov'];

		$postcode = $_POST['postcode'];

		$email = $_POST['email'];

		$url = $_POST['url'];

		$zoneid = $_POST['zoneid'];

		$Province = $_POST['Province'];

		$passtype = $_POST['passtype'];

		$passcode = $_POST['passcode'];

		$qq = $_POST['qq'];

		$msn = $_POST['msn'];

		$bz = $_POST['bz'];

		$sayexp = $_POST['sayexp'];

		$tags = $_POST['tags'];

		$salesname = $_POST['salesname'];

		$memberid = $_POST['memberid'];

		$rz = $_POST['rz'];

		$oldrz = $_POST['oldrz'];

		$yy = $_POST['yy'];

		$dd = $_POST['dd'];

		$mm = $_POST['mm'];

		$se = $_POST['se'];

		$mi = $_POST['mi'];

		$ho = $_POST['ho'];

		$ResetPass = $_POST['ResetPass'];

		$password = $_POST['password'];

		

		$mtall = $_POST['mtall'];

		$mweight = $_POST['mweight'];

		$mchest = $_POST['mchest'];

		$mwaist = $_POST['mwaist'];

		$mhips = $_POST['mhips'];

		

		$membertype = $_POST['membertype']? $_POST['membertype']:"1";

		

		$mdpass = md5( $password );

		if ( $oldrz != $rz )

		{

				needauth( 59 );

		}

		if ( $ResetPass == "yes" )

		{

				needauth( 65 );

		}

		$birthday = $birth0.$birth1.$birth2;

		if ( $sayexp == "0" )

		{

				$exptime = 0;

		}

		else

		{

				$exptime = mktime( $ho, $mi, $se, $mm, $dd, $yy );

		}

		

		for ( $t = 0;	$t < sizeof( $tags );	$t++	)

		{

				if ( $tags[$t] != "" )

				{

						$tagstr .= $tags[$t].",";

				}

		}

		$msql->query( "update {P}_member set

			user='{$user}',

			name='{$name}',

			company='{$company}',

			pname='{$pname}',

			sex='{$sex}',

			birthday='{$birthday}',

			zoneid='{$zoneid}',

			addr='{$addr}',

			tel='{$tel}',

			mov='{$mov}',

			postcode='{$postcode}',

			email='{$email}',

			url='{$url}',

			passtype='{$passtype}',

			passcode='{$passcode}',

			qq='{$qq}',

			msn='{$msn}',

			maillist='{$maillist}',

			bz='{$bz}',

			rz='{$rz}',

			tags='{$tagstr}',

			salesname='{$salesname}',

			exptime='{$exptime}',

			tall = '{$mtall}',

			weight = '{$mweight}',

			chest = '{$mchest}',

			waist = '{$mwaist}',

			hips = '{$mhips}'



			where memberid='{$memberid}'" );

		if ( $ResetPass == "yes" )

		{

				$msql->query( "update {P}_member set password='{$mdpass}' where memberid='{$memberid}'" );

		}

		

		//寫入電子報信箱

		$fsql->query("SELECT member_id FROM {P}_paper_order WHERE member_id='{$memberid}'");

		if ( $fsql->next_record( ) )

		{

			$fsql->query("UPDATE {P}_paper_order SET email='{$email}',member_type='{$membertype}' WHERE member_id='{$memberid}'");

		}else{

			$regtime = time();

			$fsql->query("insert into {P}_paper_order set is_member='1',member_id='{$memberid}',member_type='{$membertype}',is_order='1',email='{$email}',dtime='{$regtime}'");

		}

		

		//echo "<script>parent.\$.unblockUI()</script>";

		//sayok("修改完成","javascript:parent.\$.unblockUI();");

		

		

		//更改訂單

		$msql->query( "update {P}_shop_order set

			email='{$email}' 

			where memberid='{$memberid}' and ifreceipt='0'" );

		

		sayok("修改完成");

		exit( );

}

//$msql->query( "select * from {P}_member where memberid='{$memberid}'" );
$msql->query( 
	"SELECT *
	FROM (
		SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member 
		UNION ALL 
		SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member_offline
	) AS U
	where memberid='{$memberid}'" );

if ( $msql->next_record( ) )

{

		$user = $msql->f( "user" );

		$password = $msql->f( "password" );

		$name = $msql->f( "name" );

		$company = $msql->f( "company" );

		$sex = $msql->f( "sex" );

		$birthday = $msql->f( "birthday" );

		$zoneid = $msql->f( "zoneid" );

		$addr = $msql->f( "addr" );

		$tel = $msql->f( "tel" );

		$mov = $msql->f( "mov" );

		$postcode = $msql->f( "postcode" );

		$email = $msql->f( "email" );

		$url = $msql->f( "url" );

		$passtype = $msql->f( "passtype" );

		$passcode = $msql->f( "passcode" );

		$qq = $msql->f( "qq" );

		$msn = $msql->f( "msn" );

		$maillist = $msql->f( "maillist" );

		$bz = $msql->f( "bz" );

		$checked = $msql->f( "checked" );

		$regtime = $msql->f( "regtime" );

		$exptime = $msql->f( "exptime" );

		$account = $msql->f( "account" );

		$paytotal = $msql->f( "paytotal" );

		$buytotal = $msql->f( "buytotal" );

		$pname = $msql->f( "pname" );

		$ip = $msql->f( "ip" );

		$checked = $msql->f( "checked" );

		$salesname = $msql->f( "salesname" );

		$rz = $msql->f( "rz" );

		$logincount = $msql->f( "logincount" );

		$logintime = $msql->f( "logintime" );

		$loginip = $msql->f( "loginip" );

		$tags = $msql->f( "tags" );

		$tags = explode( ",", $tags );

		$regtime = date( "Y-n-j H:i:s", $regtime );

		$logintime = date( "Y-n-j H:i:s", $logintime );

		$birth0 = substr( $birthday, 0, 4 );

		$birth1 = substr( $birthday, 4, 2 );

		$birth2 = substr( $birthday, 6, 2 );

		$date = getdate( $exptime );

		$yy = $date['year'];

		$dd = $date['mday'];

		$mm = $date['mon'];

		$ho = $date['hours'];

		$mi = $date['minutes'];

		$se = $date['seconds'];

		$tall = $msql->f( "tall" );

		$weight = $msql->f( "weight" );

		$chest = $msql->f( "chest" );

		$waist = $msql->f( "waist" );

		$hips = $msql->f( "hips" );

		

		$membertype = $msql->f( "membertypeid" );

		

		if ( $exptime == "0" )

		{

				$sayexp = 0;

		}

		else

		{

				$sayexp = 1;

		}

}

?>



<div class="formzone">

<form method="post" name='regform' action="member_modify.php">



<div class="tablezone">



<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" >

 

   <tr>

     <td height="12" colspan="4"  ></td>

    </tr>

   <tr>

   <td width="85"  align=center ><?php echo $strMemberUser1; ?></td>

   <td width="300"  >

   

   <table border="0" cellspacing="1" cellpadding="1" width="100%">

     <tr>

       <td><input class="input" type="text" size=13 name="user" value='<?php echo $user; ?>' /></td>

       <td><?php echo $strMemberFrom21; ?></td>

       <td><input name='pname' type="text" class="input" id="pname" value='<?php echo $pname; ?>' size=15 /></td>

     </tr>

   </table>

   </td>

   <td width="90"  align=center ><?php echo $strMemberFrom2; ?></td>

   <td  ><input class="input" type="text" size=18 name='password' value='******' readonly />

     <label><input type="checkbox" name="ResetPass" value='yes' onClick="if(regform.password.value==''){regform.password.value='******';regform.password.readOnly = true;}else{regform.password.value='';regform.password.focus();regform.password.readOnly = false;}" />

     <?php echo $strMemberResetPass; ?>請先勾選</label></td>

   </tr>    

   

   <tr>

     <td width="85"  align=center ><?php echo $strMemberFrom22; ?></td>

     <td  ><input name='company' type="text" class="input" id="company" value='<?php echo $company; ?>' size="50" /></td>

     <td width="90"  align=center ><?php echo $strMemberFrom4; ?></td>

     <td  ><input name='name' type="text" class="input" id="name" value='<?php echo $name; ?>' size=12 />

      &nbsp;

	   <input name="sex" type="radio" value="1" <?php echo checked( $sex, "1" ); ?> />

       <?php echo $strMan; ?>       <input type="radio" name="sex" value="2" <?php echo checked( $sex, "2" ); ?> />

       <?php echo $strWoman; ?></td>

   </tr>

   <tr>

     <td width="85"  align=center ><?php echo $strMemberFrom8; ?></td>

     <td  ><input name='addr' type="text" class="input" id="addr" value='<?php echo $addr; ?>' size=50 /></td>

     <td width="90"  align=center ><?php echo $strMemberFrom60; ?></td>

     <td  >

	 

<!--SCRIPT language=javascript src='js/zone.js'></SCRIPT>

	

<script language=javascript>

	

<?php

$fsql->query( "select * from {P}_member_zone where pid = '0' order by xuhao" );

$i = 0;

while ( $fsql->next_record( ) )

{

		$zone_id = $fsql->f( "catid" );

		$zone = $fsql->f( "cat" );

		echo "pList.add(new province('".$zone."','".$zone_id."'));\n";

		$tsql->query( "select * from {P}_member_zone where pid = '{$zone_id}'  order by xuhao " );

		$e = 0;

		while ( $tsql->next_record( ) )

		{

				$szoneid = $tsql->f( "catid" );

				$szone = $tsql->f( "cat" );

				echo "pList.addAt('".$i."',new area('".$szone."','".$szoneid."'));\n";

				if ( $szoneid == $zoneid )

				{

						$Province = $i;

				}

				$e++;

		}

		if ( $e < 1 )

		{

				echo "pList.addAt('".$i."',new area('ALL','".$zone_id."'));\n";

				if ( $zone_id == $zoneid )

				{

						$Province = $i;

				}

		}

		$i++;

}

?>

			</script-->

				

				

			

<!--select onKeyUp='if(window.event.keyCode==13) document.regform.zoneid.focus();'  onChange=provinceSelChange(regform.zoneid,regform.Province.value,'<?php echo $zoneid; ?>') name=Province>

			

<script language=javascript>

			

			document.write(pList.getOptionString('<?php echo $Province; ?>'));

			</script>

			

			</select>

			

			<div id='zonediv' style='position:absolute; width:150px; height:26px; z-index:1'>

			

			

<select onKeyUp='if(window.event.keyCode==13) document.regform.regCardNum.focus();'  name='zoneid'>

			

			

<script language=javascript>

			document.write(pList.getOptionAreasString(regform.Province.value,regform.zoneid,'<?php echo $zoneid; ?>',1));

			</script>

			</select>

			

			</div-->

	 </td>

   </tr> 

   

   <tr>

     <td width="85" height="26" align="center" ><?php echo $strMemberFrom9; ?></td>

     <td ><input name='tel' type="text" class="input" id="tel" value='<?php echo $tel; ?>' size=50 />

	 

	

	  </td>

     <td width="90" align="center" ><?php echo $strMemberFrom12; ?></td>

     <td ><input name='postcode' type="text" class="input" id="postcode" value='<?php echo $postcode; ?>' size=12 /></td>

   </tr>

   <tr>

     <td width="85"  align=center ><?php echo $strMemberFrom11; ?></td>

     <td  ><input name='mov' type="text" class="input" id="mov" value='<?php echo $mov; ?>' size=50 /></td>

     <td width="90"  align=center ><?php echo $strMemberFrom14; ?></td>

     <td  ><input name='url' type="text" class="input" id="url" value='<?php echo $url; ?>' size=39 /></td>

   </tr>

   <tr>

     <td width="85"  align=center ><?php echo $strMemberFrom13; ?></td>

     <td  ><input name='email' type="text" class="input" id="email" value='<?php echo $email; ?>' size=50></td>

     <td width="90"  align=center ><?php echo $strMemberFrom19; ?></td>

     <td  ><input class="input" type="text" size=4 name=birth0 value='<?php echo $birth0; ?>' />

       <?php echo $strYear; ?>       <input class="input" type="text" size=2 name=birth1 value='<?php echo $birth1; ?>' />

       <?php echo $strMonth; ?>       <input class="input" type="text" size=2 name=birth2 value='<?php echo $birth2; ?>' />

       <?php echo $strDay; ?></td>

   </tr>

   <tr>

     <td width="85"  align=center ><?php echo $strMemberFrom17; ?></td>

     <td  >

<span class="title">

       <input name='qq' type="text" class="input" id="qq" value='<?php echo $qq; ?>' size=50 />

      </span></td>

     <td width="90"  align=center ><?php echo $strMemberFrom18; ?></td>

     <td  ><input name='msn' type="text" class="input" id="msn" value='<?php echo $msn; ?>' size=39 /></td>

   </tr>

   <tr>

     <td width="85"  align=center ><?php echo $strMemberFrom15; ?></td>

     <td  ><input name='passtype' type="text" class="input" id="passtype" value='<?php echo $passtype; ?>' size=10 />

		<span class="title">

       <input name='passcode' type="text" class="input" id="passcode" value='<?php echo $passcode; ?>' size=32 />

       </span></td>

     <td width="90"  align=center ><?php echo $strMemberTags; ?></td>

     <td  ><input name="tags[]" type="text" class="input" id="tags"  value="<?php echo $tags[0]; ?>" size="7" />

       <input name="tags[]" type="text" class="input" id="tags"  value="<?php echo $tags[1]; ?>" size="7" />

       <input name="tags[]" type="text" class="input" id="tags"  value="<?php echo $tags[2]; ?>" size="7" /></td>

   </tr>

    <tr>

      <td width="85" align="center"><?php echo $strMemberFrom20; ?></td>

      <td valign="top" > 

      

      <textarea class="textarea" name="bz" cols=37 rows=8><?php echo $bz; ?></textarea> 

      </td>

      <td colspan="2" valign="top"><table width="100%"  border="0" cellspacing="1" cellpadding="5">

        <tr>

          <td width="78" align="center"><?php echo $strMemberRzStat; ?></td>

          <td>

<select name="rz">

            <option value="0" <?php echo seld( $rz, 0 ); ?>><?php echo $strMemberRz0; ?></option>

            <option value="1" <?php echo seld( $rz, 1 ); ?>><?php echo $strMemberRz1; ?></option>

          </select>

            

<span class="adminsubmit">

            <input name="oldrz" type="hidden" id="oldrz" value="<?php echo $rz; ?>" />

            &nbsp; <?php echo $strSalesname; ?> 

            

<select name="salesname" id="salesname" >

              <option value="" <?php echo seld( $salesname, "" ); ?>><?php echo $strSalesNo; ?></option>

              

<?php

$msql->query( "select * from {P}_base_admin order by id" );

while ( $msql->next_record( ) )

{

		$ssname = $msql->f( "name" );

		if ( $salesname == $ssname )

		{

				echo "<option value='".$ssname."' selected>".$ssname."</option>";

		}

		else

		{

				echo "<option value='".$ssname."'>".$ssname."</option>";

		}

}

?>

            </select>

            </span></td>

        </tr>

        <tr>

          <td width="78" align="center"><?php echo $strMemberExpTime; ?></td>

          <td>

<select name="sayexp" onChange="checkexp(this.form.sayexp.options[this.form.sayexp.selectedIndex].value)">

        <option value="0" <?php echo seld( $sayexp, 0 ); ?>><?php echo $strNolimit; ?></option>

        <option value="1" <?php echo seld( $sayexp, 1 ); ?>><?php echo $strlimit; ?></option>

      </select>

        <div id="ttt" style="position:absolute; width:200px; height:26px; z-index:1; visibility: visible">

          <?php echo explist( $ho, $mi, $se, $mm, $dd, $yy ); ?>        </div>

      

<script>checkexp('<?php echo $sayexp; ?>')</script></td>

        </tr>

        <tr>

          <td width="78" align="center"><?php echo $strMemberRegTime; ?></td>

          <td>

<span class="adminsubmit"><?php echo $regtime; ?> [<?php echo $ip; ?>] </span></td>

        </tr>

        <tr>

          <td width="78" align="center"><?php echo $strMemberLastLogin; ?></td>

          <td>

<span class="adminsubmit"><?php echo $logintime; ?> [<?php echo $loginip; ?>] </span></td>

        </tr>

      </table>

    

    </td>

      </tr>



        <tr>

          <td width="78" align="center">尺寸記錄</td>

          <td>

			身高：<input type="text" class="input" name="mtall" value="<?php echo $tall; ?>" />公分<br>

			體重：<input type="text" class="input" name="mweight" value="<?php echo $weight; ?>" />公斤 <br>

			胸圍：<input type="text" class="input" name="mchest" value="<?php echo $chest; ?>" />公分 <br>

			腰圍：<input type="text" class="input" name="mwaist" value="<?php echo $waist; ?>" />公分 <br>

			臀圍：<input type="text" class="input" name="mhips" value="<?php echo $hips; ?>" />公分

		</td>

        </tr>

	

	

  

</table>

</div>

<div class="adminsubmit"> 

<input type="submit" name="Submit" value="<?php echo $strModify; ?>" class="button" />

<input type="hidden" name="memberid" value="<?php echo $memberid; ?>" />

<input type="hidden" name="step" value="modify" />

<input type="hidden" name="membertype" value="<?php echo $membertype;?>" />

</div>

</form>

</div>

</body>

</html>