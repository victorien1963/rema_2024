<?php
include_once('geoip.inc.php');

class SecurityWEB{


	/*
	*	匯入變數假設  $_GET[123] 及 $_POST[123]  轉   $123 實際變數
	*	$arraydata  允許通過變數
	*	$methoddata 
	*	決定是只有 $_GET 匯入就輸入 GET 
	*	決定是只有 $_POST 匯入就輸入 POST 
	*	沒有一定分別就不輸入,預設 ALL  全部
	*
	* 	範列  SecurityWEB::GlobalsImport(array('abc','werf'),'POST');
	*       就可以用  $abc  $werf 變數
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
	*  檢查允許通過變數,否則一律都刪除
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
	 *  用 fsockopen  跨網傳送資料
	 *  
	 *  $host = 網址含 http:// 及  https://
	 *  $data = 陣列  $q[data] = 1;
	 *  $method  設定  GET   及  POST ,預設  GET 傳送
	 *  $showagent = 回傳完整過濾下一行
	 *  $port  =   自訂 port
	 *  $timeout  等待最長時間回傳  預設 60 秒
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
	* 路徑轉換過濾
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
	*	目錄轉換過濾
	*/
	function escapeDir($dir) {
		$dir = str_replace(array("'",'#','=','`','$','%','&',';'), '', $dir);
		return rtrim(preg_replace('/(\/){2,}|(\\\){1,}/', '/', $dir), '/');
	}


	/*
	* 全面過濾 $_GET $_POST 來抵擋隱碼攻擊~(注入攻擊)
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
	*	隱碼(注入) 策略資料
	*	防 sql 及 xss  隱碼攻擊
	*	最後變數都過濾掉產生無效
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

				//過濾數字符號 特殊符號 及 位移 符號 Unicode 符號
      				for ($i = 0; $i < strlen($search); $i++){  
						$val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);
						$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);
				}

				//過濾 xss JavaScript VBscript

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

			//變數含有 sql 及  php 過濾
			$sqlf = array(
					'UPDATE','SHOW TABLE','INSERT INTO','SELECT',
					'fopen','file','copy','move_uploaded_file','file_put_contents','fwrite','fputs','passthru','shell_exec','exec','system',
					'mysql_query','mysql_unbuffered_query','mysql_select_db','mysql_drop_db','mysql_db_query','sqlite_query','sqlite_exec','sqlite_array_query','sqlite_unbuffered_query'
			);
			
			//此處過濾會影響文字大小寫
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
	* 加載類文件
	*/
	function import($file) {
		if (!is_file($file)) return false;
		require_once $file;
	}


	/*
	* html轉換輸出
	*/

	function htmlEscape($param) {
		return trim(htmlspecialchars($param, ENT_QUOTES));
	}


	/*
	* 過濾 HTML 標簽
	*/

	function stripTags($param) {
		return trim(strip_tags($param));
	}

	/*
	*	整型數過濾
	*/

	function int($param) {
		return intval($param);
	}

	/*	
	*	字符過濾前後空白
	*/
	function str($param) {
		return trim($param);
	}


	/*
	*	判斷是否陣列數組
	*/
	function isArray($params) {
		return (!is_array($params) || !count($params)) ? false : true;
	}


	/*
	*	判斷變數是否在陣列數組中存在
	*/

	function inArray($param, $params) {
		return (!in_array((string)$param, (array)$params)) ? false : true;
	}



	/*
	*	判斷是否 object
	*/
	function isObj($param) {
		return is_object($param) ? true : false;
	}


	/*	
	*	判斷是否是布爾型
	*/
	function isBool($param) {
		return is_bool($param) ? true : false;
	}


	/*
	*	判斷是否是數字型
	*/
	function isNum($param) {
		return is_numeric($param) ? true : false;
	}

	/*
	*
	*	//是否屏障代理性 Porxy  IP 訪問本站
	*/

	function BarrierProxy($proxyopen=false){


		if($proxyopen == true && ($_SERVER['HTTP_X_FORWARDED_FOR'] || $_SERVER['HTTP_VIA'] || $_SERVER['HTTP_PROXY_CONNECTION'] || $_SERVER['HTTP_USER_AGENT_VIA'] || $_SERVER['HTTP_CACHE_INFO'] || $_SERVER['HTTP_PROXY_CONNECTION'])){
			header("HTTP/1.1: 404 Not Found");
			exit;

		}
	}

	/*
	*	讀取訪問真實性 IP
	*	檢測IP位址包含隱藏在代理性 Porxy 訪問真實的IP
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
	*      防止重新整理攻擊
	*      說明:未超過規定之內重新整理判斷  cc   攻擊
	*
	*/

	function AntiCC(){
		global $UserIP,$begin_time;

		//屏障區網 cc 重新整理攻擊
		
		if(strpos($UserIP,'192.168') == 0){
			return false;
		}
		

		$REQUEST_URI = $_SERVER['PHP_SELF'].($_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '');
		$begin_time =time();
		

		if($_COOKIE['lastview']){

			list($lastvisit,$lastpath) = explode("\t",$_COOKIE['lastview']);

			$t = (int)($begin_time - $lastvisit);


			if($lastpath && $REQUEST_URI==$lastpath && $begin_time - $lastvisit < 1) {


				//警告:系統偵測到使用者異常非法重新整理!
				//目前已經記錄您的IP 位於 國家,將不排除追究法律責任

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
	*   跟具外網公用  IP  來判斷來哪國家
	*
	*   @INT geoiptype 類型
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

		// 打開各國IP二進位庫
		$gi = geoip_open(MVMMALL_ROOT."include/GeoIP.dat",GEOIP_STANDARD);


		// 獲取國家代碼
		if($geoiptype == '1'){

			$Stringreturn = geoip_country_code_by_addr($gi, $UserIP);

		} else if($geoiptype == '2'){

			// 獲取國家名稱
			$Stringreturn = geoip_country_name_by_addr($gi, $UserIP);

			// 獲取國家名稱/代碼
		} else if($geoiptype == '3'){

			$countrycode = geoip_country_code_by_addr($gi, $UserIP);
			$countryname = geoip_country_name_by_addr($gi, $UserIP);
			$Stringreturn = array($countrycode,$countryname);
		}

		// 關閉文件
		geoip_close($gi);

		return $Stringreturn;
	}

	/*
	*
	*  刪除檔案專用
	*
	*   string $fileName
	*/

	function Fileunlink($fileName) {
		return @unlink(SecurityWEB::escapePath($fileName));
	}



	/*
	* string $fileName 文件絕對路徑
	* string $data 內容資料
	* string $method 讀寫模式
	* bool $ifLock 是否鎖文件
	* bool $ifCheckPath 是否檢查文件名中的“..”
	* bool $ifChmod 是否將文件屬性改為可讀寫
	* bool 是否寫入成功:注意rb+創建新文件均返回的false,請用wb+ 
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
	*	對某一個目錄刪除
	*
	*
	*	包含裡面檔案
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