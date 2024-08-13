<?php
define( "ROOTPATH", "../" );
include( ROOTPATH."includes/common.inc.php" );
include( "language/".$sLan.".php" );
include( ROOTPATH."member/includes/member.inc.php" );

$coltype = $_REQUEST['coltype']?$_REQUEST['coltype']:"index";
$pagename = $_REQUEST['pagename']?$_REQUEST['pagename']:"index";

pageset( $coltype, $pagename );

printpage( );
?>