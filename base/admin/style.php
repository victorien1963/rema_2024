<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include_once( ROOTPATH."includes/data.inc.php" );
include( "language/".$sLan.".php" );
needauth( 2 );
$sourcefold = ROOTPATH.'/cache/modsql/';
$delsql = $_GET[delsql];
$insertsql = $_GET[insertsql];
if($delsql){
@unlink($sourcefold.$delsql);
sayok( $strStyleBackDel, "", "" );
}
if($insertsql){
	$sql_file = $sourcefold.$insertsql;
	$tablepre = $TablePre;
	if ( file_exists( $sql_file ) ) {
					$sql_query = fread( fopen( $sql_file, "r" ), filesize( $sql_file ) );
					if ( get_magic_quotes_runtime( ) == 1 )
					{
						$sql_query = stripslashes( $sql_query );
					}
					$sql_query = trim( $sql_query );
					$sql_query = remove_remarks( $sql_query );
					$pieces = split_sql_file( $sql_query, ";" );
					$pieces_count = count( $pieces );
					$i = 0;
					for ( ;	$i < $pieces_count;	++$i	)
					{
						$a_sql_query = trim( $pieces[$i] );
						if ( !empty( $a_sql_query ) && $a_sql_query[0] != "#" )
							{
								//$a_sql_query = str_replace( "dev_", $tablepre."_", $a_sql_query );
								$result = mysql_query( $a_sql_query );
					}
					}

	}else{err( $strPlusNotice5, "", "" );}


sayok( $strStyleUseOk, "", "" );
}

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head >
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<link  href=\"css/style.css\" type=\"text/css\" rel=\"stylesheet\">
<title>".$strAdminTitle."</title>
<SCRIPT>
function cm(nn){
	qus=confirm(\"".$strDeleteConfirm."\")
	if(qus!=0){
	window.location='style.php?delsql='+nn;
	}
}function cmstyle(ss){
	qus=confirm(\"".$strStyleConfirm."\")
	if(qus!=0){
	window.location='style.php?insertsql='+ss;
	}
}

</SCRIPT>
</head>

<body>
";

$sourcefold = ROOTPATH.'/cache/modsql/';
$style_backup = scandir( $sourcefold );
array_shift($style_backup);array_shift($style_backup);

				echo "<div class=\"formzone\">
<div class=\"namezone\" style=\"float:left\">".$strStyleBackup."</div><div class=\"addnew\" onClick=\"window.location='style_modbackup.php'\" id=\"addsubbutton\">".$strStyleBackUp."</div>
<div class=\"tablezone\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" >
  <tr> 
    <td class=\"innerbiaoti\" align=\"center\" height=\"28\" width=\"15%\" >".$strNumber."</td><td class=\"innerbiaoti\" align=\"center\" height=\"28\" width=\"20%\" >".$strPlustempname."</td><td class=\"innerbiaoti\" align=\"center\" height=\"28\" width=\"30%\" >".$strFbtime."</td><td class=\"innerbiaoti\" align=\"center\" height=\"28\" width=\"20%\" >".$strStyleUse."</td><td class=\"innerbiaoti\" align=\"center\" height=\"28\" width=\"15%\" >".$strDelete."</td>";
				if($style_backup){
				foreach($style_backup as $key=>$s){
					$key = $key+1;
					$sname[$key] = substr($s,11,8);
					//$sname[$key] .= " : ".$styledb[$sname[$key]];
					$stime[$key] =  date('Y/m/d H:i:s',substr($s,0,10));
	echo "<tr class=\"list\"><td  height=\"26\" width=\"15%\" align=\"center\">".$key."</td><td  height=\"26\"  width=\"20%\" align=\"center\"><img src=\"images/image.gif\" align=\"absmiddle\" />&nbsp;".$sname[$key]."</td><td  height=\"26\" width=\"30%\" align=\"center\">".$stime[$key]."</td><td  height=\"26\" width=\"20%\" align=\"center\"><img id='insert_sql' class='pdv_enter' src=\"images/update.png\"  style=\"cursor:pointer\"  border=\"0\"  onClick=\"cmstyle('".$s."')\"/></td><td  height=\"26\" width=\"15%\" align=\"center\"><img src=\"images/delete.png\"  style=\"cursor:pointer\" onClick=\"cm('".$s."')\" /> 
<td></tr>";
}}
echo "</table>
</div>
</div>
</body>
</html>
";
?>