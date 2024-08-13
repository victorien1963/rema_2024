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
<script type="text/javascript" src="../../base/js/base.js"></script>
<script type="text/javascript" src="../../base/js/form.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<title><?php echo $strAdminTitle; ?></title>
</head>
<body>

<?php
$step = $_REQUEST['step'];
$membertypeid = $_REQUEST['membertypeid'];
if ( $step == "mod" )
{
		$a = $_POST['a'];
		$s = $_POST['s'];
		$msql->query( "delete from {P}_member_defaultrights where membertypeid='{$membertypeid}'" );
		$msql->query( "select * from {P}_member_secure" );
		while ( $msql->next_record( ) )
		{
				$secureid = $msql->f( "id" );
				$securetype = $msql->f( "securetype" );
				$sArr = $s[$secureid];
				if ( is_array( $sArr ) )
				{
						$sStr = ":".implode( ":", $sArr ).":";
				}
				else
				{
						$sStr = $sArr;
				}
				if ( $a[$secureid] == "1" )
				{
						$fsql->query( "insert into {P}_member_defaultrights set
				membertypeid='{$membertypeid}',
				secureid='{$secureid}',
				securetype='{$securetype}',
				secureset='{$sStr}'				
			" );
				}
		}
		sayok( $strMemberTypeNotice19, "member_type_rights.php?membertypeid={$membertypeid}", "" );
}
$msql->query( "select * from {P}_member_type where membertypeid='{$membertypeid}'" );
if ( $msql->next_record( ) )
{
		$membertypeid = $msql->f( "membertypeid" );
		$membertype = $msql->f( "membertype" );
}
$msql->query( "select * from {P}_member_defaultrights where membertypeid='{$membertypeid}'" );
$i = 0;
while ( $msql->next_record( ) )
{
		$SecureArr[$i] = $msql->f( "secureid" );
		$SecureSetArr[$i] = $msql->f( "secureset" );
		$i++;
}
$nums = $i - 1;
?>
<div class="formzone">
<form method="post" action="member_type_rights.php">
<div class="namezone" ><?php echo $strMemberTypeRightSet; ?> - <?php echo membertypeid2membertype( $membertypeid ); ?></div>

<div class="tablezone">
<table width="100%" border="0" cellspacing="0" cellpadding="6" >  
    <tr>
      <td  class="innerbiaoti" width="50"><?php echo $strMemberAuthId; ?></td> 
      <td  class="innerbiaoti" width="80"><?php echo $strColType; ?></td>
      <td  class="innerbiaoti" width="180"><?php echo $strMemberTypeRD; ?> 
      </td>
      <td  class="innerbiaoti" height="28" width="110"><?php echo $strMemberTypeR; ?> 
       &nbsp; <input id="selAll" type="checkbox" name="" value="1" /><?php echo $strSelAll; ?></td>
      <td  class="innerbiaoti" height="28"><?php echo $strMemberTypeRSet; ?> </td>
    </tr>
    
<?php
$msql->query( "select * from {P}_member_secure order by id" );
while ( $msql->next_record( ) )
{
		$secureid = $msql->f( "id" );
		$coltype = $msql->f( "coltype" );
		$securetype = $msql->f( "securetype" );
		$securename = $msql->f( "securename" );
		$ifcheck = "";
		$nowset = "0";
		$n = 0;
		for ( ;	$n <= $nums;	$n++	)
		{
				if ( $SecureArr[$n] == $secureid )
				{
						$ifcheck = " checked ";
						$nowset = $SecureSetArr[$n];
						break;
				}
				else
				{
						$ifcheck = "";
						$nowset = "0";
				}
		}
		echo " 
    <tr class=\"list\">
      <td   width=\"50\">".$secureid."</td> 
      
      <td   width=\"80\">".coltype2sname( $coltype )."</td>
      <td   width=\"180\">".$securename." </td>

      <td   height=\"26\" width=\"110\"> 
        <input type=\"checkbox\" name=\"a[".$secureid."]\" value=\"1\" ".$ifcheck." class=\"authcheckbox\" />        
      </td>
      <td  height=\"26\">";
		if ( $securetype == "con" )
		{
				echo "<select name=\"s[".$secureid."]\" >
          ";
				$u = 0;
				for ( ;	$u <= 9;	$u++	)
				{
						if ( $u == $nowset )
						{
								echo "<option value='".$u."' selected>".$u."</option>";
						}
						else
						{
								echo "<option value='".$u."'>".$u."</option>";
						}
				}
				echo "        </select> &nbsp;";
				echo $strMemberTypeRRank;
		}
		else if ( $securetype == "class" )
		{
				$tsql->query( "select classtbl from {P}_base_coltype where coltype='{$coltype}'" );
				if ( $tsql->next_record( ) )
				{
						$classtbl = $tsql->f( "classtbl" );
				}
				$tsql->query( "select * from {P}".$classtbl." where pid='0'" );
				while ( $tsql->next_record( ) )
				{
						$cat = $tsql->f( "cat" );
						$catid = $tsql->f( "catid" );
						if ( strstr( $nowset, ":".$catid.":" ) )
						{
								echo "<li style='list-style-type:none;float:left;margin:3px;white-space:nowrap'><input type='checkbox' name='s[".$secureid."][]' value='".$catid."' checked /> ".$cat." &nbsp;</li>";
						}
						else
						{
								echo "<li style='list-style-type:none;float:left;margin:3px;white-space:nowrap'><input type='checkbox' name='s[".$secureid."][]' value='".$catid."' /> ".$cat." &nbsp;</li>";
						}
				}
		}
		else if ( $securetype == "banzhu" )
		{
				$tsql->query( "select classtbl from {P}_base_coltype where coltype='{$coltype}'" );
				if ( $tsql->next_record( ) )
				{
						$classtbl = $tsql->f( "classtbl" );
				}
				$tsql->query( "select * from {P}".$classtbl." where pid='0'" );
				while ( $tsql->next_record( ) )
				{
						$cat = $tsql->f( "cat" );
						$catid = $tsql->f( "catid" );
						if ( strstr( $nowset, ":".$catid.":" ) )
						{
								echo "<li style='list-style-type:none;float:left;margin:3px;white-space:nowrap'><input type='checkbox' name='s[".$secureid."][]' value='".$catid."' checked /> ".$cat." &nbsp;</li>";
						}
						else
						{
								echo "<li style='list-style-type:none;float:left;margin:3px;white-space:nowrap'><input type='checkbox' name='s[".$secureid."][]' value='".$catid."' /> ".$cat." &nbsp;</li>";
						}
				}
				if ( strstr( $nowset, ":PERSON:" ) )
				{
						echo "<li style='list-style-type:none;float:left;margin:3px;white-space:nowrap'><input type='checkbox' name='s[".$secureid."][]' value='PERSON' checked /> ".$strPersonZone." &nbsp;</li>";
				}
				else
				{
						echo "<li style='list-style-type:none;float:left;margin:3px;white-space:nowrap'><input type='checkbox' name='s[".$secureid."][]' value='PERSON' /> ".$strPersonZone." &nbsp;</li>";
				}
		}
		else
		{
				echo "<input type=\"hidden\" name=\"s[".$secureid."]\"  value=\"".$nowset."\" /> &nbsp;-";
		}
		echo "</td></tr>";
}
?>
 
</table>
</div>

<div class="adminsubmit">
<input type="submit" name="cc" value="<?php echo $strModify; ?>" class="button" />
<input type="hidden" name="step" value="mod" />
<input type="hidden" name="membertypeid" value="<?php echo $membertypeid; ?>" />
</div>

</form>
</div>
</body>
</html>