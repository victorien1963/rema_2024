<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( "func/member.inc.php" );
needauth( 50 );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/style.css" type="text/css" rel="stylesheet">
<title><?php echo $strAdminTitle; ?></title>
</head>
<body>

<?php
$step = $_REQUEST['step'];
$membertypeid = $_REQUEST['membertypeid'];
$membertype = $_REQUEST['membertype'];
$membergroupid = $_REQUEST['membergroupid'];
$ifcanreg = $_REQUEST['ifcanreg'];
$ifchecked = $_REQUEST['ifchecked'];
$regxy = $_REQUEST['regxy'];
$regmail = $_REQUEST['regmail'];
$expday = $_REQUEST['expday'];
$startcent = $_REQUEST['startcent'];
$endcent = $_REQUEST['endcent'];
$menugroupid = $_REQUEST['menugroupid'];
if ( $step == "mod" )
{
		$membertype = htmlspecialchars( $membertype );
		$regxy = htmlspecialchars( $regxy );
		$regmail = htmlspecialchars( $regmail );
		if ( $membertype == "" )
		{
				err( $strMemberTypeNotice10, "", "" );
		}
		$msql->query( "update {P}_member_type set
	membertype='{$membertype}',
	regxy='{$regxy}',
	regmail='{$regmail}',
	membergroupid='{$membergroupid}',
	ifcanreg='{$ifcanreg}',
	expday='{$expday}',
	startcent='{$startcent}',
	endcent='{$endcent}',
	menugroupid='{$menugroupid}',
	ifchecked='{$ifchecked}'
 	where membertypeid='{$membertypeid}'" );
		$regstep = $_POST['regstep'];
		$msql->query( "delete from {P}_member_regstep where membertypeid='{$membertypeid}'" );
		$i = 0;
		for ( ;	$i < sizeof( $regstep );	$i++	)
		{
				$xuhao = $i + 1;
				$msql->query( "select stepname from {P}_member_regstep where regstep='".$regstep[$i]."' and membertypeid='0'" );
				if ( $msql->next_record( ) )
				{
						$stepname = $msql->f( "stepname" );
				}
				$msql->query( "insert into {P}_member_regstep set 
		membertypeid='{$membertypeid}',
		regstep='".$regstep[$i]."',
		stepname='{$stepname}',
		xuhao='{$xuhao}'
		" );
		}
		sayok( $strMemberTypeNotice11, "member_type.php", "" );
}
$msql->query( "select * from {P}_member_type where membertypeid='{$membertypeid}'" );
if ( $msql->next_record( ) )
{
		$membertypeid = $msql->f( "membertypeid" );
		$membertype = $msql->f( "membertype" );
		$membergroupid = $msql->f( "membergroupid" );
		$ifcanreg = $msql->f( "ifcanreg" );
		$ifchecked = $msql->f( "ifchecked" );
		$regxy = $msql->f( "regxy" );
		$regmail = $msql->f( "regmail" );
		$expday = $msql->f( "expday" );
		$startcent = $msql->f( "startcent" );
		$endcent = $msql->f( "endcent" );
		$menugroupid = $msql->f( "menugroupid" );
}
?>
<div class="formzone">
<form method="post" action="">
<div class="namezone" ><?php echo $strMemberTypeCsSet; ?> - <?php echo $membertype; ?></div>

<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="6" align="center">
  <tr> 
    <td width="127" > 
      <div align="right"><?php echo $strMemberTypeId; ?> :</div>
    </td>
    <td  ><?php echo $membertypeid; ?></td>
  </tr> 
    <tr> 
      <td width="127" > 
        <div align="right"><?php echo $strMemberType; ?> :</div>
      </td>
      <td  > 
        <input type="text" name="membertype" size="22" value="<?php echo $membertype; ?>"  class=input>
      </td>
    </tr>
    <tr>
      <td width="127" align="right" ><?php echo $strMemberGroup; ?> :</td>
      <td >
<select name="membergroupid">
          
<?php
$fsql->query( "select * from {P}_member_group order by id" );
while ( $fsql->next_record( ) )
{
		$lmembergroupid = $fsql->f( "id" );
		$membergroup = $fsql->f( "membergroup" );
		if ( $lmembergroupid == $membergroupid )
		{
				echo "<option value='".$lmembergroupid."'  selected>".$membergroup."</option>";
		}
		else
		{
				echo "<option value='".$lmembergroupid."'  >".$membergroup."</option>";
		}
}
?>
          
      </select></td>
    </tr>
    <tr> 
      <td width="127" > 
        <div align="right"><?php echo $strMemberTypeRegAllow; ?> :</div>
      </td>
      <td>
<select name="ifcanreg">
          <option value="1" <?php echo seld( $ifcanreg, "1" ); ?>><?php echo $strMemberTypeNotice5; ?></option>
          <option value="0" <?php echo seld( $ifcanreg, "0" ); ?>><?php echo $strMemberTypeNotice6; ?></option>
        </select>
      </td>
    </tr>
    <tr>
      <td align="right" ><?php echo $strMemberRegStep; ?> : </td>
      <td >
<?php
$exist = array( "" );
$msql->query( "select * from {P}_member_regstep where membertypeid='{$membertypeid}' order by xuhao" );
while ( $msql->next_record( ) )
{
		$regstep = $msql->f( "regstep" );
		$stepname = $msql->f( "stepname" );
		$exist[] = $regstep;
		echo "<input name=\"regstep[]\" type=\"checkbox\" id=\"regstep\" value=\"".$regstep."\" checked=\"checked\" /> ".$stepname;
}
$fsql->query( "select * from {P}_member_regstep where membertypeid='0' order by xuhao" );
while ( $fsql->next_record( ) )
{
		$regstep = $fsql->f( "regstep" );
		$stepname = $fsql->f( "stepname" );
		if ( in_array( $regstep, $exist ) == false )
		{
				echo "<input name=\"regstep[]\" type=\"checkbox\" id=\"regstep\" value=\"".$regstep."\"  /> ".$stepname;
		}
}
?>
      </td>
    </tr>
    <tr> 
      <td width="127" > 
        <div align="right"><?php echo $strMemberTypeRegDays; ?> :</div>
      </td>
      <td  > 
        <input type="text" name="expday" size="3" value="<?php echo $expday; ?>"  class=input><?php echo $strMemberTypeRegDay; ?>        [<?php echo $strMemberTypeNotice9; ?>] </td>
    </tr>
    <!--tr> 
      <td width="127" > 
        <div align="right"><?php echo $strMemberTypeRegxy; ?> :</div>
      </td>
      <td  > 
        <textarea name="regxy" cols="60" rows="8"  class="textarea"><?php echo $regxy; ?></textarea>
      </td>
    </tr-->
    <tr> 
      <td width="127" > 
        <div align="right"><?php echo $strMemberTypeRegMail; ?> :</div>
      </td>
      <td  > 
        <textarea name="regmail" cols="60" rows="8"  class="textarea"><?php echo $regmail; ?></textarea>
      </td>
    </tr>
    <tr> 
      <td width="127" > 
        <div align="right">新增會員密碼信 :</div>
      </td>
      <td  > 
        <textarea name="regxy" cols="60" rows="8"  class="textarea"><?php echo $regxy; ?></textarea>
      </td>
    </tr>
	<tr>
      <td align="right" ><?php echo $strMenuGroupSel; ?> : </td>
      <td >
<select name="menugroupid">
	  	
<?php
$fsql->query( "select * from {P}_menu_group order by id" );
while ( $fsql->next_record( ) )
{
		$menugroup = $fsql->f( "id" );
		$menugroupname = $fsql->f( "groupname" );
		if ( $menugroup == $menugroupid )
		{
				echo "<option value='".$menugroup."'  selected>".$menugroupname."</option>";
		}
		else
		{
				echo "<option value='".$menugroup."'  >".$menugroupname."</option>";
		}
}
?>
        
      </select></td>
    </tr>
</table>
</div> 
<div class="adminsubmit">
<input type="submit" name="Submit" value="<?php echo $strModify; ?>"  class="button" />
<input type="hidden" name="step" value="mod" />
<input type="hidden" name="membertypeid" value="<?php echo $membertypeid; ?>" />
<input name="ifchecked" type="hidden" id="ifchecked" value="1" />
</div>
</form>
</div>
</body>
</html>