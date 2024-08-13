<?php

define("ROOTPATH", "../");
include(ROOTPATH."config.inc.php");
include_once(ROOTPATH."includes/db.inc.php");
include_once(ROOTPATH."member/includes/member.inc.php");

define('UC_CONNECT', 'mysql');
define('UC_DBHOST', $GLOBALS["MEMBERCONF"]["UC_DBHOST"]);
define('UC_DBUSER', $GLOBALS["MEMBERCONF"]["UC_DBUSER"]);
define('UC_DBPW', $GLOBALS["MEMBERCONF"]["UC_DBPW"]);
define('UC_DBNAME', $GLOBALS["MEMBERCONF"]["UC_DBNAME"]);
define('UC_DBCHARSET', $GLOBALS["MEMBERCONF"]["UC_DBCHARSET"]);
define('UC_DBTABLEPRE', $GLOBALS["MEMBERCONF"]["UC_DBNAME"].".".$GLOBALS["MEMBERCONF"]["UC_DBTABLEPRE"]);
define('UC_KEY', $GLOBALS["MEMBERCONF"]["UC_KEY"]);
define('UC_API', $GLOBALS["MEMBERCONF"]["UC_API"]);
define('UC_CHARSET', $GLOBALS["MEMBERCONF"]["UC_CHARSET"]);
define('UC_IP', $GLOBALS["MEMBERCONF"]["UC_IP"]);
define('UC_APPID', $GLOBALS["MEMBERCONF"]["UC_APPID"]);
define('UC_PPP', '20');

$dbhost = $dbHost;
$dbuser = $dbUser;
$dbpw = $dbPass;
$dbname = $dbName;
$pconnect = 0;
$tablepre = $TablePre;
$dbcharset = 'utf8';
$cookiedomain = '';
$cookiepath = '/';