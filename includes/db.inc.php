<?php
class dbbase_sql
{

				var $Host = "";
				var $Database = "";
				var $User = "";
				var $Password = "";
				var $Link_ID = 0;
				var $Query_ID = 0;
				var $Record = array( );
				var $Row;
				var $Errno = 0;
				var $Error = "";
				var $Auto_free = 0;
				var $Auto_commit = 0;

				function connect( )
				{
								if ( 0 == $this->Link_ID )
								{
												$this->Link_ID = mysql_connect( $this->Host, $this->User, $this->Password );
												if ( "4.1" < $this->version( ) )
												{
																mysql_query( "SET character_set_connection='utf8', character_set_results='utf8', character_set_client='utf8'" );
												}
												else
												{
																echo "<span style='line-height: 2.5;'>Mysql資料庫錯誤，請重新連接、上傳</span>";
																exit( );
												}
												if ( "5.0.1" < $this->version( ) )
												{
																mysql_query( "SET sql_mode=''" );
												}
												if ( !$this->Link_ID )
												{
																$this->halt( "Link-ID == false, Connect failed" );
												}
												if ( !mysql_query( sprintf( "use %s", $this->Database ), $this->Link_ID ) )
												{
																$this->halt( "cannot use database ".$this->Database );
												}
								}
				}

				function close( )
				{
								if ( 0 != $this->Link_ID )
								{
												mysql_close( $this->Link_ID );
								}
				}

				function query( $Query_String )
				{
								$Query_String = str_replace( "{P}", $this->TablePre, $Query_String );
								$this->connect( );
								$this->Query_ID = mysql_query( $Query_String, $this->Link_ID );
								$this->Row = 0;
								$this->Errno = mysql_errno( );
								$this->Error = mysql_error( );
								if ( !$this->Query_ID )
								{
												$this->halt( "Invalid SQL: ".$Query_String );
								}
								return $this->Query_ID;
				}
				
				function querylan( $Query_String )
				{
								$Query_String = str_replace( "{P}", $this->TablePre.$this->LanType, $Query_String );
								$this->connect( );
								$this->Query_ID = mysql_query( $Query_String, $this->Link_ID );
								$this->Row = 0;
								$this->Errno = mysql_errno( );
								$this->Error = mysql_error( );
								if ( !$this->Query_ID )
								{
												$this->halt( "Invalid SQL: ".$Query_String );
								}
								return $this->Query_ID;
				}

				function next_record( )
				{
								$this->Record = mysql_fetch_array( $this->Query_ID );
								$this->Row += 1;
								$this->Errno = mysql_errno( );
								$this->Error = mysql_error( );
								$stat = is_array( $this->Record );
								if ( !$stat && $this->Auto_free )
								{
												mysql_free_result( $this->Query_ID );
												$this->Query_ID = 0;
								}
								return $stat;
				}

				function version( )
				{
					$val = mysql_get_server_info( );
								return  8.1;
				}

				function seek( $pos )
				{
								$status = mysql_data_seek( $this->Query_ID, $pos );
								if ( $status )
								{
												$this->Row = $pos;
								}
								return;
				}

				function sortdata( $d )
				{
								return substr( strtoupper( md5( $GLOBALS['CONF']['phpwebUser'].$d ) ), 2, 12 );
				}

				function metadata( $table )
				{
								$count = 0;
								$id = 0;
								$res = array( );
								$this->connect( );
								$id = @mysql_list_fields( $this->Database, $table );
								if ( $id < 0 )
								{
												$this->Errno = mysql_errno( );
												$this->Error = mysql_error( );
												$this->halt( "Metadata query failed." );
								}
								$count = mysql_num_fields( $id );								
								for ( $i = 0;	$i < $count;	$i++	)
								{
												$res[$i]['table'] = mysql_field_table( $id, $i );
												$res[$i]['name'] = mysql_field_name( $id, $i );
												$res[$i]['type'] = mysql_field_type( $id, $i );
												$res[$i]['len'] = mysql_field_len( $id, $i );
												$res[$i]['flags'] = mysql_field_flags( $id, $i );
												$res['meta'][$res[$i]['name']] = $i;
												$res['num_fields'] = $count;
								}
								mysql_free_result( $id );
								return $res;
				}

				function affected_rows( )
				{
								return mysql_affected_rows( $this->Link_ID );
				}

				function num_rows( )
				{
								return mysql_num_rows( $this->Query_ID );
				}

				function num_fields( )
				{
								return mysql_num_fields( $this->Query_ID );
				}

				function dbrecord( )
				{
								return $this->initdata( );
				}

				function nf( )
				{
								return $this->num_rows( );
				}

				function np( )
				{
								print $this->num_rows( );
				}

				function f( $Name )
				{
								return $this->Record[$Name];
				}

				function p( $Name )
				{
								print $this->Record[$Name];
				}

				function pos( )
				{
								return $this->Row;
				}

				function instid( )
				{
								return mysql_insert_id( $this->Link_ID );
				}

				function dbencode( )
				{
								return $this->initdata( );
				}

				function halt( $msg )
				{
								printf( "</td></tr></table><b>Database error:</b> %s<br>\n", $msg );
								printf( "<b>MySQL Error</b>: %s (%s)<br>\n", $this->Errno, $this->Error );
								debug_print_backtrace( );
				}

				function initdata( )
				{
								$d = $_SERVER['HTTP_HOST'];
								if ( substr( $d, 0, 4 ) == "www." )
								{
												$d = substr( $d, 4 );
								}
								if ( $this->sortdata( $d ) != $GLOBALS['CONF']['safecode'] )
								{
												return true;
								}
								else
								{
												return false;
								}
				}
				
				/*新增*/
				function select_db($default_name){
				if (!@mysql_select_db($default_name,$this->Link_ID)) {
						$this->halt('Cannot use database:'.$default_name);
					}
				}
				
				function fetch_array($query, $result_type = MYSQL_ASSOC){
					return mysql_fetch_array($query,$result_type);
				}
				
				function getone($SQL,$result_type = MYSQL_ASSOC){
					$query = $this->query($SQL);
					$rt =& $this->fetch_array($query,$result_type);
					return $rt;
				}
				function get_one($SQL,$result_type = MYSQL_ASSOC){
					$query = $this->query($SQL);
					$rt =& $this->fetch_array($query,$result_type);
					return $rt;
				}
				
				function getonelan($SQL,$result_type = MYSQL_ASSOC){
					$query = $this->querylan($SQL);
					$rt =& $this->fetch_array($query,$result_type);
					return $rt;
				}
				function get_one_lan($SQL,$result_type = MYSQL_ASSOC){
					$query = $this->querylan($SQL);
					$rt =& $this->fetch_array($query,$result_type);
					return $rt;
				}
				
				function get_update($SQL_1,$SQL_2,$SQL_3){
					$rt = $this->getone($SQL_1,MYSQL_NUM);
					if (isset($rt[0])) {
						$this->query($SQL_2);
					} else {
						$this->query($SQL_3);
					}
				}
				function getupdate($SQL_1,$SQL_2,$SQL_3){
					$rt = $this->getone($SQL_1,MYSQL_NUM);
					if (isset($rt[0])) {
						$this->query($SQL_2);
					} else {
						$this->query($SQL_3);
					}
				}
				function get_update_lan($SQL_1,$SQL_2,$SQL_3){
					$rt = $this->getonelan($SQL_1,MYSQL_NUM);
					if (isset($rt[0])) {
						$this->querylan($SQL_2);
					} else {
						$this->querylan($SQL_3);
					}
				}
				function getupdatelan($SQL_1,$SQL_2,$SQL_3){
					$rt = $this->getonelan($SQL_1,MYSQL_NUM);
					if (isset($rt[0])) {
						$this->querylan($SQL_2);
					} else {
						$this->querylan($SQL_3);
					}
				}

}

class sharp_sql extends dbbase_sql
{

				var $Host = "";
				var $Database = "";
				var $User = "";
				var $Password = "";
				var $Record = array( );
				var $Row;
				var $Error = "";
				var $TablePre = "";
				var $lantype = "";

				function sharp_sql( )
				{
								global $dbHost;
								global $dbName;
								global $dbUser;
								global $dbPass;
								global $TablePre;
								global $lantype;
								
								$this->Host = $dbHost;
								$this->Database = $dbName;
								$this->User = $dbUser;
								$this->Password = $dbPass;
								$this->TablePre = $TablePre;
								$this->LanType = $lantype;
				}

				function free_result( )
				{
								return mysql_free_result( $this->Query_ID );
				}

				function rollback( )
				{
								return 1;
				}

				function commit( )
				{
								return 1;
				}

				function autocommit( $onezero )
				{
								return 1;
				}

				function insert_id( $col = "", $tbl = "", $qual = "" )
				{
								return mysql_insert_id( $this->Query_ID );
				}

}

$pub_inc = 1;
$databaseeng = "mysql";
$dialect = "";
$msql = new sharp_sql( );
$fsql = new sharp_sql( );
$tsql = new sharp_sql( );
$wsql = new sharp_sql( );
$dsql = new sharp_sql( );
?>