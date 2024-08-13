<?php
function PageToUrl(){

	global $fsql,$SiteUrl,$tsql;
	
	if(strstr($_SERVER["QUERY_STRING"],".html")){
		$idArr=explode(".html",$_SERVER["QUERY_STRING"]);
		$id=$idArr[0];
	}elseif(isset($_GET["id"]) && $_GET["id"]!=""){
		$id=$_GET["id"];
	}
	$tourl="";
	$fsql->query("select url from {P}_page where id='$id' limit 0,1");
	if($fsql->next_record()){
		$tourl=$fsql->f('url');
	}else{
			$id=basename($_SERVER['SCRIPT_NAME'],".php");
		$id && $tsql->query("select url from {P}_page where pagefolder='$id' limit 0,1");
		if($tsql->next_record()){
			$tourl=$tsql->f('url');
		}
	}
	if( $tourl!="http://" $tourl!="" &&  strlen($tourl)>1){
		if(substr($tourl,0,7)=="http://"){
			header("location:".$tourl);
		}elseif(substr($tourl,0,8)=="https://"){
			header("location:".$tourl);
		}elseif(substr($tourl,0,1)=="/"){
			$tourl=substr($tourl,1);
			header("location:".$SiteUrl.$tourl);
		}else{
			header("location:".$SiteUrl.$tourl);
		}
	}else{
		return false;
	}
	return false;
}
///////////////翻頁類

class pages {

    /**
     * 頁面輸出結果
     *
     * @var string
     */
	var $output;

    /**
     * 使用該類的文件,預設為 PHP_SELF
     *
     * @var string
     */
	var $file;

    /**
     * 頁數傳遞變量，預設為 'p'
     *
     * @var string
     */
	var $pvar = "p";

    /**
     * 頁面大小
     *
     * @var integer
     */
	var $psize;

    /**
     * 目前頁面
     *
     * @var ingeger
     */
	var $curr;

    /**
     * 要傳遞的變量陣列
     *
     * @var array
     */

	var $varstr;

    /**
     * 總頁數
     *
     * @var integer
     */
    var $tpage;

    /**
     * 分頁設置
     *
     * @access public
     * @param int $pagesize 頁面大小
     * @param int $total    總記錄數
     * @param int $current  目前頁數，預設會自動讀取
     * @return void
     */
    function set($pagesize=20,$total,$parr,$current=false) {

		global $strPagesUp,$strPagesDown,$strPagesStart,$strPagesEnd,$strPagesDi,$strPagesYe;

		$this->total = $total;
		$this->tpage = ceil($total/$pagesize);
		

		if (!$current) {$current = $_GET[$this->pvar];}
		if ($current>$this->tpage) {$current = $this->tpage;}
		if ($current<1) {$current = 1;}

		$this->curr  = $current;
		$this->psize = $pagesize;

		if (!$this->file) {$this->file = $_SERVER["PHP_SELF"];}


		for($n=1;$n<=$this->tpage;$n++){
			if($current==$n){
				$optstr.='<option value="./?'.$parr[$n].'.html" selected>'.$strPagesDi.$n.$strPagesYe.'</option>';
			}else{
				$optstr.='<option value="./?'.$parr[$n].'.html">'.$strPagesDi.$n.$strPagesYe.'</option>';
			}
		}


		
		if ($this->tpage == 0) {
			$this->tpage=1;
		}
			if ($this->tpage > 0) {
            	
				$this->output.='<ul><li class="pbutton"><a href="./?'.$parr[1].'.html">'.$strPagesStart.'</a></li>';
			
				if ($current>1) {
				$this->output.='<li class="pbutton"><a href="./?'.$parr[$current-1].'.html" >'.$strPagesUp.'</a></li>';
				}else{
				$this->output.='<li class="pbuttonnow">'.$strPagesUp.'</li>';
			
				}


				if($this->tpage>10 && $current>6){
					if($current+4>$this->tpage){
						$start=$this->tpage-9;
					}else{
						$start=$current-5;
					}
					
				}else{
					$start=1;
				}

				
				if ($start<1){$start=1;}
				$end = $start+9;
				
				if ($end>$this->tpage)	{$end=$this->tpage;}



            for ($i=$start; $i<=$end; $i++) {
                if ($current==$i) {
                    $this->output.='<li class="pagesnow">'.$i.'</li>';    
                } else {
                    $this->output.='<li><a href="./?'.$parr[$i].'.html">'.$i.'</a></li>';    
                }
            }

            if ($current<$this->tpage) {
				$this->output.='<li class="pbutton"><a  href="./?'.$parr[$current+1].'.html" >'.$strPagesDown.'</a></li>';
			}else{
				$this->output.='<li class="pbuttonnow">'.$strPagesDown.'</li>';
			
			}
           
		$this->output.='<li class="opt"><select onChange="window.location=this.options[this.selectedIndex].value">'.$optstr.'</select></li>';
		$this->output.='<li class="pbutton"><a href="./?'.$parr[$this->tpage].'.html">'.$strPagesEnd.'</a></li>';

	    $this->output.="</ul>";
	    }
	}

    /**
     * 要傳遞的變量設置
     *
     * @access public
     * @param array $data   要傳遞的變量，用陣列來表示，參見上面的例子
     * @return void
     */	
	function setvar($data) {
		foreach ($data as $k=>$v) {
			$this->varstr.='&amp;'.$k.'='.urlencode($v);
		}
	}

    /**
     * 分頁結果輸出
     *
     * @access public
     * @param bool $return 為真時返回一個字元串，否則直接輸出，預設直接輸出
     * @return string
     */
	function output($return = false) {
		if ($return) {
			return $this->output;
		} else {
			echo $this->output;
		}
	}

    /**
     * 產生Limit語句
     *
     * @access public
     * @return string
     */
    function limit() {
		return (($this->curr-1)*$this->psize).','.$this->psize;
	}
    function ShowNow() {

		$pagesinfo["total"]=$this->tpage;
		$pagesinfo["now"]=$this->curr;
		$pagesinfo["shownum"]=$this->psize;

		if($this->total>0){
			if($this->total<=($this->curr-1)*$this->psize+$this->psize){
				$pagesinfo["from"]=($this->curr-1)*$this->psize+1;
				$pagesinfo["to"]=$this->total;
			}else{
				$pagesinfo["from"]=($this->curr-1)*$this->psize+1;
				$pagesinfo["to"]=($this->curr-1)*$this->psize+$this->psize;
			}
		}else{
			$pagesinfo["from"]=1;
			$pagesinfo["to"]=1;
		}



		return $pagesinfo;

	}
} 
?>