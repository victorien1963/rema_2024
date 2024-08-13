<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 6 );
header("Content-type: text/html; charset=utf-8"); 
$col = $_POST[col]? $_POST[col]:$_GET[col];
$gfile = $_POST[gfile]? $_POST[gfile]:$_GET[gfile];
$copy = str_ireplace("<?php","",$_POST[copy]);
$copy = str_replace("?>","",$copy);
$copy = "<?php\r\n".$copy."\r\n?>";
$cfile=ROOTPATH.$col."/module/".$gfile.".php"; 

//送出修改 
if(isset($_POST[edit])) { 
$cfilehandle=fopen($cfile,"wb"); 
flock($cfilehandle, 2);
fputs($cfilehandle,stripslashes(str_replace("\x0d\x0a", "\x0a", $copy)));
//fwrite($cfilehandle,stripslashes(str_replace("\x0d\x0a", "\x0a", $copy)));
$editfile = $cfilehandle;
fclose($cfilehandle); 
echo "<font color=red>修改成功！</font>"; 
exit();
}else{

//修改界面 
$cfilehandle=fopen($cfile,"r"); 
$editfile=@fread($cfilehandle,filesize($cfile)); 
fclose($cfilehandle); 

}
echo "<form active=".$_SERVER[PHP_SELF]." method=post>"; 
echo "<textarea cols=89 rows=23 name=copy id=code>"; 
echo $editfile; 
echo "</textarea>"; 
echo "<input type=hidden value=".$gfile." name=gfile><input type=hidden value=".$col." name=col>
<p><input type=submit value=送出 name=edit><input type=reset value=重填></form>"; 
?>