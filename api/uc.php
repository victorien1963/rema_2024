<?php

define('IN_DISCUZ', TRUE);

define('UC_CLIENT_VERSION', '1.5.0');	//note UCenter 版本標識
define('UC_CLIENT_RELEASE', '20081031');

define('API_DELETEUSER', 0);		//note 用戶刪除 API 接口開關
define('API_RENAMEUSER', 0);		//note 用戶改名 API 接口開關
define('API_GETTAG', 0);		//note 獲取標籤 API 接口開關
define('API_SYNLOGIN', 1);		//note 同步登入 API 接口開關
define('API_SYNLOGOUT', 1);		//note 同步登出 API 接口開關
define('API_UPDATEPW', 1);		//note 更改用戶密碼 開關
define('API_UPDATEBADWORDS', 0);	//note 更新關鍵字列表 開關
define('API_UPDATEHOSTS', 0);		//note 更新域名解析緩存 開關
define('API_UPDATEAPPS', 1);		//note 更新應用列表 開關
define('API_UPDATECLIENT', 0);		//note 更新客戶端緩存 開關
define('API_UPDATECREDIT', 0);		//note 更新用戶積分 開關
define('API_GETCREDITSETTINGS', 0);	//note 向 UCenter 提供積分設置 開關
define('API_GETCREDIT', 0);		//note 獲取用戶的某項積分 開關
define('API_UPDATECREDITSETTINGS', 0);	//note 更新應用積分設置 開關

define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');


if(!defined('IN_UC')) {

	error_reporting(0);
	set_magic_quotes_runtime(0);

	define('DISCUZ_ROOT', './uc_api');
	defined('MAGIC_QUOTES_GPC') || define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	
	require_once DISCUZ_ROOT.'./config.inc.php';

	$_DCACHE = $get = $post = array();

	$code = @$_GET['code'];
	parse_str(_authcode($code, 'DECODE', UC_KEY), $get);

	if(MAGIC_QUOTES_GPC) {
		$get = _stripslashes($get);
	}

	$timestamp = time();

	if($timestamp - $get['time'] > 3600) {
		exit('Authracation has expiried');
	}

	if(empty($get)) {
		exit('Invalid Request');
	}
	$action = $get['action'];

	require_once DISCUZ_ROOT.'./uc_client/lib/xml.class.php';
	$post = xml_unserialize(file_get_contents('php://input'));

	if(in_array($get['action'], array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcreditsettings', 'updatecreditsettings'))) {

		$uc_note = new uc_note();
		exit($uc_note->$get['action']($get, $post));
		
	} else {
		exit(API_RETURN_FAILED);
	}

} else {
	define('DISCUZ_ROOT', './uc_api');
	require_once DISCUZ_ROOT.'./config.inc.php';
}

class uc_note {

	var $dbconfig = '';
	var $db = '';
	var $tablepre = '';
	var $appdir = '';
	

	function _serialize($arr, $htmlon = 0) {
		if(!function_exists('xml_serialize')) {
			include_once DISCUZ_ROOT.'./uc_client/lib/xml.class.php';
		}
		return xml_serialize($arr, $htmlon);
	}

	function uc_note() {
		global $msql,$fsql;
		$this->appdir = './uc_api';
		$this->dbconfig = $this->appdir.'./config.inc.php';
		$this->db = $GLOBALS['db'];
		$this->tablepre = $GLOBALS['tablepre'];
	}

	//通信測試
	function test($get, $post) {
		return API_RETURN_SUCCEED;
	}

	//刪除用戶(無法根據UID刪除用戶)
	function deleteuser($get, $post) {
		$uids = $get['ids'];
		!API_DELETEUSER && exit(API_RETURN_FORBIDDEN);
		//note 用戶刪除 API 接口
		$threads = array();
		return API_RETURN_SUCCEED;
	}

	//改名(不支持改用戶名)
	function renameuser($get, $post) {
		$uid = $get['uid'];
		$usernameold = $get['oldusername'];
		$usernamenew = $get['newusername'];
		if(!API_RENAMEUSER) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	//獲取標籤，不支持
	function gettag($get, $post) {
		$name = $get['id'];
		if(!API_GETTAG) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}
	
	//登入
	function synlogin($get, $post) {
		
		global $msql,$fsql;

		$uid = $get['uid'];
		$username = $get['username'];
		if(!API_SYNLOGIN) {
			return API_RETURN_FORBIDDEN;
		}

		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');

		$msql->query("SELECT * FROM {P}_member WHERE user='$username' limit 0,1");
		if($msql->next_record()) {
			//error_log($msql->f('memberid'),3,"e:/php_fopen.txt");

			$membertypeid=$msql->f('membertypeid');
			$memberid=$msql->f('memberid');
			$user=$msql->f('user');
			$pname=$msql->f('pname');

			$ip=$_SERVER["REMOTE_ADDR"];
			$nowtime=time();

			$fsql->query("update {P}_member set logincount=logincount+1,logintime='$nowtime',loginip='$ip' where memberid='$memberid'");
			$fsql->query("select membertype from {P}_member_type where membertypeid='$membertypeid'");
			if($fsql->next_record()){
				$membertype=$fsql->f('membertype');
			}
			$fsql->query("select * from {P}_member_rights where memberid='$memberid' and securetype='con'");
			if($fsql->next_record()){
				$consecure=$fsql->f('secureset');
			}

			$md5=md5($user."76|01|14".$memberid.$membertype.$consecure);
			setCookie("MUSER",$user,time()+2592000,"/");
			setCookie("MEMBERPNAME",$pname,time()+2592000,"/");
			setCookie("MEMBERID",$memberid,time()+2592000,"/");
			setCookie("MEMBERTYPE",$membertype,time()+2592000,"/");
			setCookie("MEMBERTYPEID",$membertypeid,time()+2592000,"/");
			setCookie("ZC",$md5,time()+2592000,"/");
			setCookie("SE",$consecure,time()+2592000,"/");
		} else {
			setCookie("MUSER","",-31536000,"/");
			setCookie("MEMBERID","",-31536000,"/");
			setCookie("MEMBERPNAME","",-31536000,"/");
			setCookie("MEMBERTYPE","",-31536000,"/");
			setCookie("MEMBERTYPEID","",-31536000,"/");
			setCookie("SE","",-31536000,"/");
			setCookie("ZC","",-31536000,"/");
		}
	}

	//退出登入
	function synlogout($get, $post) {
		if(!API_SYNLOGOUT) {
			return API_RETURN_FORBIDDEN;
		}
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		setCookie("MUSER","",-31536000,"/");
		setCookie("MEMBERID","",-31536000,"/");
		setCookie("MEMBERPNAME","",-31536000,"/");
		setCookie("MEMBERTYPE","",-31536000,"/");
		setCookie("MEMBERTYPEID","",-31536000,"/");
		setCookie("SE","",-31536000,"/");
		setCookie("ZC","",-31536000,"/");
	}

	//更新密碼
	function updatepw($get, $post) {
		global $msql,$fsql;
		if(!API_UPDATEPW) {
			return API_RETURN_FORBIDDEN;
		}
		
		$username = $get['username'];
		$password = $get['password'];
		if($password!=""){
			$mdpass=md5($password);
			$msql->query("update {P}_member set password='$mdpass' WHERE user='$username'");
		}
		return API_RETURN_SUCCEED;
	}

	//更新關鍵詞列表，不支持
	function updatebadwords($get, $post) {
		if(!API_UPDATEBADWORDS) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	//域名解析設置，不支持
	function updatehosts($get, $post) {
		if(!API_UPDATEHOSTS) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	//更新應用列表
	function updateapps($get, $post) {
		if(!API_UPDATEAPPS) {
			return API_RETURN_FORBIDDEN;
		}
		$UC_API = $post['UC_API'];
		$cachefile = $this->appdir.'./uc_client/data/cache/apps.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'apps\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		
		return API_RETURN_SUCCEED;
	}

	//更新客戶端緩存，不支持
	function updateclient($get, $post) {
		if(!API_UPDATECLIENT) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}
	
	//更新積分，不支持
	function updatecredit($get, $post) {
		if(!API_UPDATECREDIT) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function getcredit($get, $post) {
		if(!API_GETCREDIT) {
			return API_RETURN_FORBIDDEN;
		}
	}

	function getcreditsettings($get, $post) {
		if(!API_GETCREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
	}

	function updatecreditsettings($get, $post) {
		if(!API_UPDATECREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;

	}
}

//note 使用該函數前需要 require_once $this->appdir.'./config.inc.php';
function _setcookie($var, $value, $life = 0, $prefix = 1) {
	global $cookiepre, $cookiedomain, $cookiepath, $timestamp, $_SERVER;
	setcookie(($prefix ? $cookiepre : '').$var, $value,
		$life ? $timestamp + $life : 0, $cookiepath,
		$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}

function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;

	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
				return '';
			}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}

function _stripslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = _stripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}