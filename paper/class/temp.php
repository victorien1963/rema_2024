<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/common.inc.php" );
include( "../language/".$sLan.".php" );
include( "../includes/paper.inc.php" );
pageset( "paper", "TEMP" );
printpage( );
?>