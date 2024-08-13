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
if ( $step == "add" )
{
		trylimit( "_member_type", 3, "membertypeid" );
		$msql->query( "insert into {P}_member_type values(
	0,
	'{$membertype}',
	'{$membergroupid}',
	'{$ifcanreg}',
	'{$ifchecked}',
	'{$regxy}',
	'{$regmail}',
	'{$expday}',
	'{$startcent}',
	'{$endcent}',
	'{$menugroupid}'
	)" );
		$membertypeid = $msql->instid( );
		$regstep = $_POST['regstep'];
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
		sayok( $strMemberTypeNotice4, "member_type.php", "" );
}
?>
<div class="formzone">
<form method="post" action="member_type_add.php">
<div class="namezone" ><?php echo $strMemberTypeAdd; ?></div>
<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="6"> 
    <tr> 
      <td width="127" align="right" > <?php echo $strMemberType; ?> : </td>
      <td  > 
        <input type="text" name="membertype" size="22"  class=input>
      </td>
    </tr>
    <tr>
      <td width="127" align="right" ><?php echo $strMemberGroup; ?> : </td>
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
      <td width="127" align="right" ><?php echo $strMemberTypeRegAllow; ?> : </td>
      <td  >         
<select name="ifcanreg">
          <option value="1" selected ><?php echo $strMemberTypeNotice5; ?></option>
          <option value="0"  ><?php echo $strMemberTypeNotice6; ?></option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="127" align="right" ><?php echo $strMemberRegStep; ?> : </td>
      <td >
	  
<?php
$msql->query( "select * from {P}_member_regstep where membertypeid='0' order by xuhao" );
while ( $msql->next_record( ) )
{
		$regstep = $msql->f( "regstep" );
		$stepname = $msql->f( "stepname" );
		echo "<input name=\"regstep[]\" type=\"checkbox\" id=\"regstep\" value=\"".$regstep."\" checked=\"checked\" /> ".$stepname;
}
?>
	  </td>
    </tr>
    <tr> 
      <td width="127" align="right" > 
        <?php echo $strMemberTypeRegDays; ?> : </td>
      <td  > 
        <input type="text" name="expday" size="3" value="0"  class=input>
        <?php echo $strMemberTypeRegDay; ?> [<?php echo $strMemberTypeNotice9; ?>] </td>
    </tr>
    <tr> 
      <td width="127" align="right" > 
        <?php echo $strMemberTypeRegxy; ?> : </td>
      <td > 
        <textarea name="regxy" cols="60" rows="8"  class="textarea"></textarea>
      </td>
    </tr>
    <tr> 
      <td width="127" align="right" > 
        <?php echo $strMemberTypeRegMail; ?> : </td>
      <td > 
        <textarea name="regmail" cols="60" rows="8"  class="textarea"><?php echo $strMemberTypeRegTemp; ?></textarea>
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
		if ( $menugroup == "4" )
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
    <tr align="center"> 
      <td colspan="2"  height="28"> 
       
      </td>
    </tr>
 
</table>
</div>
<div class="adminsubmit">
<input type="submit" name="Submit" value="<?php echo $strConfirm; ?>"  class="button">
<input type="hidden" name="step" value="add">
<input name="ifchecked" type="hidden" id="ifchecked" value="1" />
</div> 
</form>
</div>
</body>
</html>