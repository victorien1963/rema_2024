<?php
include_once('geoip.inc.php');

class SecurityWEB{


	/*
	*	�פJ�ܼư��]  $_GET[123] �� $_POST[123]  ��   $123 ����ܼ�
	*	$arraydata  ���\�q�L�ܼ�
	*	$methoddata 
	*	�M�w�O�u�� $_GET �פJ�N��J GET 
	*	�M�w�O�u�� $_POST �פJ�N��J POST 
	*	�S���@�w���O�N����J,�w�] ALL  ����
	*
	* 	�d�C  SecurityWEB::GlobalsImport(array('abc','werf'),'POST');
	*       �N�i�H��  $abc  $werf �ܼ�
	*/

	function GlobalsImport($arraydata,$methoddata=ALL){

		if(!is_array($arraydata)){
			$arraydata = array($arraydata);
		}


		foreach ($arraydata as $key) {
			if ($key == 'GLOBALS'){
			 	continue;
			}

			$GLOBALS[$key] = NULL;

			if ($methoddata == 'GET' && isset($_GET[$key])) {

				$GLOBALS[$key] = $_GET[$key];

			} elseif ($methoddata == 'POST' && isset($_POST[$key])) {

				$GLOBALS[$key] = $_POST[$key];
			} 

			if($methoddata == 'ALL'){
				if (isset($_POST[$key])) {
					$GLOBALS[$key] = $_POST[$key];
				}
				if (isset($_GET[$key])) {
					$GLOBALS[$key] = $_GET[$key];
				}
			}
		}

	}


	/*
	*
	*  �ˬd���\�q�L�ܼ�,�_�h�@�߳��R��
	*
	*/

	function Getglobal(){
		// array('GLOBALS' => 1,'_GET' => 1,'_POST' => 1,'_REQUEST' => 1,'_COOKIE' => 1,'_SERVER' => 1,'_ENV' => 1,'_FILES' => 1);

		$Val = array('GLOBALS' => 1,'_GET' => 1,'_POST' => 1,'_COOKIE' => 1,'_SERVER' => 1,'_FILES' => 1,'_REQUEST' => 1);
		foreach ($GLOBALS as $key => $value) {
			if (!isset($Val[$key])) {
				$GLOBALS[$key] = null;
				unset($GLOBALS[$key]);
			}
		}
	}




	/*  
	 *  �� fsockopen  ����ǰe���
	 *  
	 *  $host = ���}�t http:// ��  https://
	 *  $data = �}�C  $q[data] = 1;
	 *  $method  �]�w  GET   ��  POST ,�w�]  GET �ǰe
	 *  $showagent = �^�ǧ���L�o�U�@��
	 *  $port  =   �ۭq port
	 *  $timeout  ���ݳ̪��ɶ��^��  �w�] 60 ��
	 */

	function webhost($host,$data='',$method='GET',$showagent=null,$port=null,$timeout=60){

		$parse = @parse_url($host);

		if (empty($parse)) return false;

		if ((int)$port>0) {

			$parse['port'] = $port;

		} elseif (!$parse['port']) {

			$parse['port'] = '80';
		}

		$parse['host'] = str_replace(array('http://','https://'),array('','ssl://'),"$parse[scheme]://").$parse['host'];

		if (!$fp=@fsockopen($parse['host'],$parse['port'],$errnum,$errstr,$timeout)) {
			return false;
		}

		$method = strtoupper($method);

		$wlength = $wdata = $responseText = '';

		$parse['path'] = str_replace(array('\\','//'),'/',$parse['path'])."?$parse[query]";

		if ($method=='GET') {

			$separator = $parse['query'] ? '&' : '';

			substr($data,0,1)=='&' && $data = substr($data,1);

			$parse['path'] .= $separator.$data;

		} elseif ($method=='POST') {

			$wlength = "Content-length: ".strlen($data)."\r\n";

			$wdata = $data;
		}

		$write = "$method $parse[path] HTTP/1.0\r\n";
		$write.= "Host: $parse[host]\r\n";
		$write.= "User-Agent: Mozilla/5.0 (MSIE 11.0; Windows NT 6.3; Trident/7.0)\r\n";
		$write.= "Accept: text/html,application/xhtml+xml,application/xml;q=0.9;q=0.8\r\n";
		$write.= "Accept-Charset: Big5\r\n"; 
		$write.= "Accept-Language: zh-tw\r\n"; 
		//$write.= "Accept-Encoding: gzip, deflate\r\n"; 
		//$write.= "Connection: keep-alive\r\n"; 
		$write.= "Referer: http://".$_SERVER['HTTP_HOST']."\r\n";
		$write.= "Content-type: application/x-www-form-urlencoded\r\n";
		$write.= "{$wlength}\r\n";
		$write.= "Connection: close\r\n";
		$write.= "$wdata";

		@fwrite($fp,$write);
		while ($data = @fread($fp, 4096)) {
			$responseText.= $data;
		}
		@fclose($fp);

		if(empty($showagent)){
			$responseText = trim(stristr($responseText,"\r\n\r\n"),"\r\n");
		}

		return $responseText;
	}


	/*
	* ���|�ഫ�L�o
	*/

	function escapePath($fileName, $ifCheck = true) {
		if (!SecurityWEB::PescapePath($fileName, $ifCheck)) {
			exit('Forbidden');
		}
		return $fileName;
	}


	function PescapePath($fileName, $ifCheck = true) {
		$tmpname = strtolower($fileName);
		$tmparray = array('://',"\0");
		$ifCheck && $tmparray[] = '..';
		if (str_replace($tmparray, '', $tmpname) != $tmpname) {
			return false;
		}
		return true;
	}

	/*
	*	�ؿ��ഫ�L�o
	*/
	function escapeDir($dir) {
		$dir = str_replace(array("'",'#','=','`','$','%','&',';'), '', $dir);
		return rtrim(preg_replace('/(\/){2,}|(\\\){1,}/', '/', $dir), '/');
	}


	/*
	* �����L�o $_GET $_POST �ө�����X����~(�`�J����)
	*
	*/
	function GlobalsFilter(){
		global $_GET,$_POST;
		
		foreach ($_POST as $_key => $_value) {
			$_POST[$_key] = SecurityWEB::Filterinput($_POST[$_key]);
		}		
		
		foreach ($_GET as $_key => $_value) {
			$_GET[$_key] = SecurityWEB::Filterinput($_GET[$_key]);
		}	

	}


	/*
	*	���X(�`�J) �������
	*	�� sql �� xss  ���X����
	*	�̫��ܼƳ��L�o�����͵L��
	*/	

	function Filterinput($val, $xss = 0, $charset = 'UTF-8'){
		
		
		if (is_array($val)){
			$output = array();
			foreach ($val as $key => $data){
				$output[$key] = SecurityWEB::Filterinput($data, $xss, $charset);
			}
			return $output;
	
		}else{
			
   			if ($xss > 0){ 


				// code by nicolaspar 
				$val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);
				$search = 'abcdefghijklmnopqrstuvwxyz';
				$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';   
				$search .= '1234567890!@#$%^&*()';   
				$search .= '~`";:?+/={}[]-_|\'\\';

				//�L�o�Ʀr�Ÿ� �S��Ÿ� �� �첾 �Ÿ� Unicode �Ÿ�
      				for ($i = 0; $i < strlen($search); $i++){  
						$val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);
						$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);
				}

				//�L�o xss JavaScript VBscript

				$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script',
					'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');

				$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut',
					'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate',
					'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut',
					'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend',
					'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange',
					'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete',
					'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover',
					'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange',
					'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted',
					'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');

      				$ra = array_merge($ra1, $ra2);
					$found = true; 
					
      				while ($found == true){      
					$val_before = $val;  
					for ($i = 0; $i < sizeof($ra); $i++){
						$pattern = '/';
						for ($j = 0; $j < strlen($ra[$i]); $j++){
							if ($j > 0){
								$pattern .= '(';  
								$pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
								$pattern .= '|(&#0{0,8}([9][10][13]);?)?';
								$pattern .= ')?';
								$pattern .= $ra[$i][$j];
							} 
						}
						$pattern .= '/i';
						$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
						$val = preg_replace($pattern, $replacement, $val);
						if ($val_before == $val){
							$found = false;
						}
					}
				}



			}

			//�ܼƧt�� sql ��  php �L�o
			$sqlf = array(
					'UPDATE','SHOW TABLE','INSERT INTO','SELECT',
					'fopen','file','copy','move_uploaded_file','file_put_contents','fwrite','fputs','passthru','shell_exec','exec','system',
					'mysql_query','mysql_unbuffered_query','mysql_select_db','mysql_drop_db','mysql_db_query','sqlite_query','sqlite_exec','sqlite_array_query','sqlite_unbuffered_query'
			);
			
			//���B�L�o�|�v�T��r�j�p�g
			$orival = $val;
			$sval = strtolower($orival);
			$vals = str_replace($sqlf,'', $sval);
			if($vals != $sval){
				$val = $vals;
			}

			// Encode special chars
			$val = htmlentities($val, ENT_QUOTES, $charset);
			if(get_magic_quotes_gpc()){
				return @mysql_real_escape_string(stripslashes($val));
			} else{
				return @mysql_real_escape_string($val);
			}
		}
	}


	/*
	* �[�������
	*/
	function import($file) {
		if (!is_file($file)) return false;
		require_once $file;
	}


	/*
	* html�ഫ��X
	*/

	function htmlEscape($param) {
		return trim(htmlspecialchars($param, ENT_QUOTES));
	}


	/*
	* �L�o HTML ��ñ
	*/

	function stripTags($param) {
		return trim(strip_tags($param));
	}

	/*
	*	�㫬�ƹL�o
	*/

	function int($param) {
		return intval($param);
	}

	/*	
	*	�r�ŹL�o�e��ť�
	*/
	function str($param) {
		return trim($param);
	}


	/*
	*	�P�_�O�_�}�C�Ʋ�
	*/
	function isArray($params) {
		return (!is_array($params) || !count($params)) ? false : true;
	}


	/*
	*	�P�_�ܼƬO�_�b�}�C�Ʋդ��s�b
	*/

	function inArray($param, $params) {
		return (!in_array((string)$param, (array)$params)) ? false : true;
	}



	/*
	*	�P�_�O�_ object
	*/
	function isObj($param) {
		return is_object($param) ? true : false;
	}


	/*	
	*	�P�_�O�_�O������
	*/
	function isBool($param) {
		return is_bool($param) ? true : false;
	}


	/*
	*	�P�_�O�_�O�Ʀr��
	*/
	function isNum($param) {
		return is_numeric($param) ? true : false;
	}

	/*
	*
	*	//�O�_�̻٥N�z�� Porxy  IP �X�ݥ���
	*/

	function BarrierProxy($proxyopen=false){


		if($proxyopen == true && ($_SERVER['HTTP_X_FORWARDED_FOR'] || $_SERVER['HTTP_VIA'] || $_SERVER['HTTP_PROXY_CONNECTION'] || $_SERVER['HTTP_USER_AGENT_VIA'] || $_SERVER['HTTP_CACHE_INFO'] || $_SERVER['HTTP_PROXY_CONNECTION'])){
			header("HTTP/1.1: 404 Not Found");
			exit;

		}
	}

	/*
	*	Ū���X�ݯu��� IP
	*	�˴�IP��}�]�t���æb�N�z�� Porxy �X�ݯu�ꪺIP
	*
	*/

	function GetShowIP(){

		if ($_SERVER['HTTP_X_FORWARDED_FOR'] && $_SERVER['REMOTE_ADDR']) {
				if (strstr($_SERVER['HTTP_X_FORWARDED_FOR'], ',')) {
					$x = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
					$_SERVER['HTTP_X_FORWARDED_FOR'] = trim(end($x));
				}
				if (preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_FORWARDED_FOR'])) {
					$onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				}
		} elseif ($_SERVER['HTTP_CLIENT_IP'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
			$onlineip = $_SERVER['HTTP_CLIENT_IP'];
		}

		if(!$onlineip && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',$_SERVER['REMOTE_ADDR'])){
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}

		!$onlineip && $onlineip = "No IP";

		return $onlineip;
	}

	/*
	*
	*      ����s��z����
	*      ����:���W�L�W�w�������s��z�P�_  cc   ����
	*
	*/

	function AntiCC(){
		global $UserIP,$begin_time;

		//�ٰ̻Ϻ� cc ���s��z����
		
		if(strpos($UserIP,'192.168') == 0){
			return false;
		}
		

		$REQUEST_URI = $_SERVER['PHP_SELF'].($_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '');
		$begin_time =time();
		

		if($_COOKIE['lastview']){

			list($lastvisit,$lastpath) = explode("\t",$_COOKIE['lastview']);

			$t = (int)($begin_time - $lastvisit);


			if($lastpath && $REQUEST_URI==$lastpath && $begin_time - $lastvisit < 1) {


				//ĵ�i:�t�ΰ�����ϥΪ̲��`�D�k���s��z!
				//�ثe�w�g�O���z��IP ��� ��a,�N���ư��l�s�k�߳d��

				$UserIPcountry = SecurityWEB::GeoipCheck('2');


				echo "Warning: the system detects user exception illegal rearranged!<BR />";

				echo "Now records your IP '".$UserIP."' is located in ".$UserIPcountry." country, would not preclude legal";

				exit;


				exit();

			} else {
				setcookie('lastview',$begin_time."\t".$REQUEST_URI);
			}

		} else {
				setcookie('lastview',$begin_time."\t".$REQUEST_URI);
		}


	}

	/*
	*   ���~������  IP  �ӧP�_�ӭ���a
	*
	*   @INT geoiptype ����
	*
	*
	*  	echo SecurityWEB::GeoipCheck('2');
	*
	*/
	function GeoipCheck($geoiptype='1'){
		global $UserIP;

		$Stringreturn = "";

		//$UserIP='36.234.40.27';

		if(!$UserIP){
			return false;
		}

		if(strpos($UserIP,'192.168') == 0){
			return false;
		}

		// ���}�U��IP�G�i��w
		$gi = geoip_open(MVMMALL_ROOT."include/GeoIP.dat",GEOIP_STANDARD);


		// �����a�N�X
		if($geoiptype == '1'){

			$Stringreturn = geoip_country_code_by_addr($gi, $UserIP);

		} else if($geoiptype == '2'){

			// �����a�W��
			$Stringreturn = geoip_country_name_by_addr($gi, $UserIP);

			// �����a�W��/�N�X
		} else if($geoiptype == '3'){

			$countrycode = geoip_country_code_by_addr($gi, $UserIP);
			$countryname = geoip_country_name_by_addr($gi, $UserIP);
			$Stringreturn = array($countrycode,$countryname);
		}

		// �������
		geoip_close($gi);

		return $Stringreturn;
	}

	/*
	*
	*  �R���ɮױM��
	*
	*   string $fileName
	*/

	function Fileunlink($fileName) {
		return @unlink(SecurityWEB::escapePath($fileName));
	}



	/*
	* string $fileName ��󵴹���|
	* string $data ���e���
	* string $method Ū�g�Ҧ�
	* bool $ifLock �O�_����
	* bool $ifCheckPath �O�_�ˬd���W������..��
	* bool $ifChmod �O�_�N����ݩʧאּ�iŪ�g
	* bool �O�_�g�J���\:�`�Nrb+�Ыطs��󧡪�^��false,�Х�wb+ 
	*/

	function Filewriter($fileName, $data, $method = 'rb+', $ifLock = true, $ifCheckPath = true, $ifChmod = true) {
		$fileName = SecurityWEB::escapePath($fileName, $ifCheckPath);
		touch($fileName);
		$handle = fopen($fileName, $method);
		$ifLock && flock($handle, LOCK_EX);
		$writeCheck = fwrite($handle, $data);
		$method == 'rb+' && ftruncate($handle, strlen($data));
		fclose($handle);
		$ifChmod && @chmod($fileName, 0777);
		return $writeCheck;
	}


	/*
	*	��Y�@�ӥؿ��R��
	*
	*
	*	�]�t�̭��ɮ�
	*
	*/


	function deldir($path,$Spath=true,$NoFile=""){

		if ($NoFile && !is_array($NoFile)) {
			$NoFile = array($NoFile);
		}

		if (file_exists($path)) {
			if (is_file($path)) {
				@unlink($path);
			} else {
				$handle = opendir($path);
				while ($file = readdir($handle)) {
					if ($file!='' && !in_array($file,array('.','..'))) {

						if($NoFile && in_array($file,$NoFile)){
							continue;
						} 
						
						if (is_dir(SecurityWEB::escapeDir("$path/$file"))) {

							deldir(SecurityWEB::escapeDir("$path/$file"));

						} else {

							@unlink(SecurityWEB::escapePath("$path/$file"));
						}
						rmdir(SecurityWEB::escapeDir("$path/$file"));
					}
				}
				closedir($handle);
				if($Spath){
					rmdir(SecurityWEB::escapeDir($path));
				}
			}
		}
	}




}



//SecurityWEB::Getglobal();

$UserIP = SecurityWEB::GetShowIP();

SecurityWEB::AntiCC();

SecurityWEB::GlobalsFilter();



?>