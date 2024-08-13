<?php 
$wd = 88;
$hd	= 34;
if(isset($_GET["wh"])){
	list($wd,$hd) = explode("-",$_GET["wh"]);
}
//getCode(4,$wd,$hd); 

$_vc = new ValidateCode();      //实例化一个对象
//$_vc->setWH($wd,$hd);
$_vc->doimg();

function getCode($num,$w,$h) { 
    $code = ""; 
    for ($i = 0; $i < $num; $i++) { 
        $code .= rand(0, 9); 
    } 
    //4位驗證碼也可以用rand(1000,9999)直接生成 
    //將生成的驗證碼寫入cookie，備驗證時用 
    for ( $i = 0;	$i <= 3;	$i++	)
	{
				$zz = rand( 1, 9 );
				$code .= $zz;
	}
	setcookie( "CODEIMG", $code, time( ) + 3600, "/" );
	$code = strrev( $code ) + 5 * 2 - 9;
	$code = substr( $code, 0, 4 );
    //創建圖片，定義顏色值 
	header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
	header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )."GMT" );
	header( "Cache-Control: no-cache, must-revalidate" );
	header( "Pragma: no-cache" );
    header("Content-type: image/PNG"); 
    $im = imagecreate($w, $h); 
    $black = imagecolorallocate($im, 0, 0, 0); 
    $gray = imagecolorallocate($im, 200, 200, 200); 
    $bgcolor = imagecolorallocate($im, 255, 255, 255); 
    //填充背景 
    imagefill($im, 0, 0, $gray); 
 
    //畫邊框 
    imagerectangle($im, 0, 0, $w-1, $h-1, $black); 
 
    //隨機繪制兩條虛線，起幹擾作用 
    $style = array ($black,$black,$black,$black,$black, 
        $gray,$gray,$gray,$gray,$gray 
    ); 
    imagesetstyle($im, $style); 
    $y1 = rand(0, $h); 
    $y2 = rand(0, $h); 
    $y3 = rand(0, $h); 
    $y4 = rand(0, $h); 
    imageline($im, 0, $y1, $w, $y3, IMG_COLOR_STYLED); 
    imageline($im, 0, $y2, $w, $y4, IMG_COLOR_STYLED); 
 
    //在畫布上隨機生成大量雜訊，起干擾作用; 
    for ($i = 0; $i < 200; $i++) { 
    	$randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
        imagesetpixel($im, rand(0, $w), rand(0, $h), $randcolor); 
    } 
    //將數字隨機顯示在畫布上,字元的水平間距和位置都按一定波動範圍隨機生成 
    $strx = rand(3, 8); 
    for ($i = 0; $i < $num; $i++) { 
        $strpos = rand(1, 6); 
        imagestring($im, 5, $strx, $strpos, substr($code, $i, 1), $black); 
        $strx += rand(8, 12); 
    } 
    imagepng($im);//輸出圖片 
    imagedestroy($im);//釋放圖片所占記憶體 
}

//验证码类
       class ValidateCode {
              //private $charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789'; //随机因子
              private $charset = '123456789'; //随机因子
              private $code;       //验证码
              private $codelen = 4;     //验证码长度
              public $width = 113;     //宽度
              public $height = 42;     //高度
              private $img;        //图形资源句柄
              private $font;        //指定的字体
              private $fontsize = 20;    //指定字体大小
              private $fontcolor;      //指定字体颜色  
 
              //构造方法初始化
              public function __construct() {
                 $this->font = ROOTPATH.'includes/font/elephant.ttf';
              }  
 
            //生成随机码
              private function createCode() {
                 $_len = strlen($this->charset)-1;
                 for ($i=0;$i<$this->codelen;$i++) {
                        $this->code .= $this->charset[mt_rand(0,$_len)];
                 }
                 setcookie( "CODEIMG", $this->code, time( ) + 3600, "/" );
                 $this->code = strrev( $this->code ) + 5 * 2 - 9;
				 $this->code = substr( $this->code, 0, 4 );
              } 
              
              //指定寬高
              public function setWH($ww, $hh) {
                 $this->width = $ww;
                 $this->height = $hh;
              }
 
              //生成背景
              private function createBg() {
                 $this->img = imagecreatetruecolor($this->width, $this->height);
                 $color = imagecolorallocate($this->img, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
                 imagefilledrectangle($this->img,0,$this->height,$this->width,0,$color);
              }  
 
              //生成文字
              private function createFont() {
                 $_x = ($this->width-10) / $this->codelen;
                 for ($i=0;$i<$this->codelen;$i++) {
                        $this->fontcolor = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
                        imagettftext($this->img,$this->fontsize,mt_rand(-30,30),$_x*$i+mt_rand(1,5),$this->height / 1.4,$this->fontcolor,$this->font,$this->code[$i]);
                 }
              }  
 
              //生成线条、雪花
              private function createLine() {
                 for ($i=0;$i<6;$i++) {
                        $color = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
                        imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
                 }
                 for ($i=0;$i<100;$i++) {
                        $color = imagecolorallocate($this->img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
                        imagestring($this->img,mt_rand(1,5),mt_rand(0,$this->width),mt_rand(0,$this->height),'*',$color);
                 }
              }  
 
              //输出
              private function outPut() {
                 header('Content-type:image/png');
                 imagepng($this->img);
                 imagedestroy($this->img);
              }  
 
              //对外生成
              public function doimg() {
                 $this->createBg();
                 $this->createCode();
                 $this->createLine();
                 $this->createFont();
                 $this->outPut();
              }  
 
              //获取验证码
              public function getCode() {
                 return strtolower($this->code);
              }  
              
 
     }
     
?>