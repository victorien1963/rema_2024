<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
include( ROOTPATH."includes/pages.inc.php" );
include( "func/member.inc.php" );
needauth( 52 );
$step = $_REQUEST['step'];
$memberid = $_REQUEST['memberid'];
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
if ( $step == "addcent" )
{
		needauth( 66 );
		$cent1 = $_POST['cent1'];
		$cent2 = $_POST['cent2'];
		$cent3 = $_POST['cent3'];
		$cent4 = $_POST['cent4'];
		$cent5 = $_POST['cent5'];
		$memo = $_POST['memo'];
		$tsql->query( "update {P}_member set
	`cent1`=cent1+{$cent1},
	`cent2`=cent2+{$cent2},
	`cent3`=cent3+{$cent3},
	`cent4`=cent4+{$cent4},
	`cent5`=cent5+{$cent5}
	where memberid='{$memberid}'" );
		$now = time( );
		$tsql->query( "insert into {P}_member_centlog set
	`memberid`='{$memberid}',
	`dtime`='{$now}',
	`event`='0',
	`memo`='{$memo}',
	`cent1`='{$cent1}',
	`cent2`='{$cent2}',
	`cent3`='{$cent3}',
	`cent4`='{$cent4}',
	`cent5`='{$cent5}'
	 " );
		echo "<script>parent.\$.unblockUI()</script>";
		exit( );
}
$msql->query( "select * from {P}_member_centset" );
if ( $msql->next_record( ) )
{
		$centname1 = $msql->f( "centname1" );
		$centname2 = $msql->f( "centname2" );
		$centname3 = $msql->f( "centname3" );
		$centname4 = $msql->f( "centname4" );
		$centname5 = $msql->f( "centname5" );
}
?>

<div class="formzone">
<div class="namezone" ><?php echo $strCentAdd; ?></div>

<div class="tablezone">
<form method="post" name='regform' action="member_centlog.php">
<table  border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><?php echo $centname1; ?></td>
    <td><input name="cent1" type="text" id="cent1" value="0" size="3" class="input" /></td>
    <td><?php echo $centname2; ?></td>
    <td><input name="cent2" type="text" id="cent2" value="0" size="3" class="input" /></td>
    <td><?php echo $centname3; ?></td>
    <td><input name="cent3" type="text" id="cent3" value="0" size="3" class="input" /></td>
    <td><?php echo $centname4; ?></td>
    <td><input name="cent4" type="text" id="cent4" value="0" size="3" class="input" /></td>
    <td><?php echo $centname5; ?></td>
    <td><input name="cent5" type="text" id="cent5" value="0" size="3" class="input" /></td>
    <td><input name="memo" type="text" id="memo" value="<?php echo $strCentFormAdmin; ?>" size="25" class="input" /></td>
    <td><input type="submit" name="Submit" value="<?php echo $strCentAdd; ?>" class="button" /></td>
    <td><input type="hidden" name="memberid" value="<?php echo $memberid; ?>" />
      <input type="hidden" name="step" value="addcent" /></td>
  </tr>
</table>
</form>
</div>
<div class="namezone" ><?php echo $strCentList; ?></div>

<div class="tablezone">

<?php
$scl = " memberid='{$memberid}' ";
$totalnums = tblcount( "_member_centlog", "id", $scl );
$pages = new pages( );
$pages->setvar( array(
		"memberid" => $memberid
) );
$pages->set( 20, $totalnums );
$pagelimit = $pages->limit( );
?>
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr>
    <td width="160" height="28"  class="innerbiaoti"><?php echo $strCentL3; ?></td>
    <td  class="innerbiaoti"><?php echo $strCentEvent; ?></td>
    <td  class="innerbiaoti" width="50"><?php echo $centname1; ?></td>
    <td  class="innerbiaoti" width="50"><?php echo $centname2; ?></td>
    <td  class="innerbiaoti" width="50"><?php echo $centname3; ?></td>
    <td  class="innerbiaoti" width="50"><?php echo $centname4; ?></td>
    <td  class="innerbiaoti" width="50"><?php echo $centname5; ?></td>
    </tr>
  
<?php
$msql->query( "select * from {P}_member_centlog where {$scl} order by dtime desc limit {$pagelimit}" );
while ( $msql->next_record( ) )
{
		$id = $msql->f( "id" );
		$event = $msql->f( "event" );
		$dtime = $msql->f( "dtime" );
		$cent1 = $msql->f( "cent1" );
		$cent2 = $msql->f( "cent2" );
		$cent3 = $msql->f( "cent3" );
		$cent4 = $msql->f( "cent4" );
		$cent5 = $msql->f( "cent5" );
		$memo = $msql->f( "memo" );
		if ( $event == "0" )
		{
				$eventname = $memo;
		}
		else
		{
				$fsql->query( "select name from {P}_member_centrule where event='{$event}' " );
				if ( $fsql->next_record( ) )
				{
						$eventname = $fsql->f( "name" );
				}
		}
		$dtime = date( "Y/m/d H:i:s", $dtime );
		echo "  <tr class=\"list\">
    <td width=\"160\" height=\"26\"  >".$dtime." </td>
    <td  >".$eventname." </td>
    <td width=\"50\">".$cent1."</td>
    <td width=\"50\">".$cent2."</td>
    <td width=\"50\">".$cent3."</td>
    <td width=\"50\">".$cent4."</td>
    <td width=\"50\">".$cent5."</td>
    </tr>
  ";
}
?>
</table>
</div>

<?php $pagesinfo = $pages->shownow( ); ?>
<div id="showpages">
	  <div id="pagesinfo"><?php echo $strPagesTotalStart.$totalnums.$strPagesTotalEnd; ?> <?php echo $strPagesMeiye.$pagesinfo['shownum'].$strPagesTotalEnd; ?> <?php echo $strPagesYeci; ?> <?php echo $pagesinfo['now']."/".$pagesinfo['total']; ?></div>
	  <div id="pages"><?php echo $pages->output( 1 ); ?></div>
</div>
</div>
</body>
</html>