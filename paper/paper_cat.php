<?php
define( "ROOTPATH", "../" );
include( ROOTPATH."includes/common.inc.php" );
include( ROOTPATH."member/includes/member.inc.php" );
include( "language/".$sLan.".php" );
include( "includes/paper.inc.php" );
securemember( );
pageset( "member", "papercat" );
printpage( );
?>