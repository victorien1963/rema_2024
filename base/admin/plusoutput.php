<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 6 );
$pluslable = $_GET['pluslable'];
if ( $pluslable == "" )
{
				exit( );
}

$client = getenv( "HTTP_USER_AGENT" );
if ( preg_match( "/[^(]*\\((.*)\\)[^)]*/i", $client, $regs ) )
{
				$os = $regs[1];
				if ( preg_match( "/Win/i", $os ) )
				{
								$crlf = "\r\n";
				}
}
$str = "";
$msql->query( "select * from {P}_base_plusdefault where pluslable='{$pluslable}' limit 0,1" );
if ( $msql->next_record( ) )
{
		$num = count($msql->Record);
				while ( list( $key, $val ) = each($msql->Record) )
				{
						if($co < $num-1){$n[$co] = ",\n";}
								if ( !is_int( $key ) )
								{									
												if ( $key != "id" )
												{
																$val = str_replace( "'", "", $val );
																$str .= "".$key."=".$val.$n[$co];
												}											
								}
								$co++;
				}
		$coltype = $msql->f('coltype');
		$tempname = $msql->f('tempname');
}

/*檢測PHP內建壓縮類*/
if (class_exists('ZipArchive')) {

$zip = new ZipArchive(); 
$filename = "./plusInstall_".$pluslable.".zip"; 

if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) { 
exit("cannot open <$filename>\n"); 
} 

$zip->addFromString("plusInstall_".$pluslable.".dat", $str); 
$zip->addFile("../../".$coltype."/module/".substr($pluslable,3).".php",$coltype."/module/".substr($pluslable,3).".php");
$zip->addFile("../../".$coltype."/templates/".$tempname,$coltype."/templates/".$tempname);

$zip->close();

$isclass = TRUE;

}else{
/*外掛壓縮類*/
include(ROOTPATH."includes/pclzip.lib.php");
$filename = "./plusInstall_".$pluslable.".zip"; 
$zip = new PclZip($filename);
filesave("plusInstall_".$pluslable.".dat",$str);
$filelist = ROOTPATH.$coltype."/module/".substr($pluslable,3).".php,".ROOTPATH.$coltype."/templates/".$tempname.",plusInstall_".$pluslable.".dat";
$iszip = $zip->create( $filelist,PCLZIP_OPT_REMOVE_PATH, ROOTPATH );
unlink("plusInstall_".$pluslable.".dat");
	if ($iszip == 0) {
		exit("Error : ".$zip->errorInfo(true));
	}

}

header( "Content-disposition: filename=plusInstall_".$pluslable.".zip" );
header( "Content-type: application/x-zip-compressed" );
header( "Pragma: no-cache" );
header( "Expires: 0" );

echo file_get_contents($filename);
unlink($filename);

exit( );
?>