<?php
define("ROOTPATH", "");
include(ROOTPATH."includes/common.inc.php");


//檢測ftp是否開啟
$msql->query("SELECT * FROM {P}_base_config WHERE `variable`='ftpConnect'");
if($msql->next_record()){
	if($msql->f("value") == "0"){
		exit("FTP關閉中...");
	}
}

### PhpExcel
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
require_once dirname(__FILE__) . '/Classes/PHPExcel/Writer/Excel2007.php';
require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';
	
//$remote_file = 'SQ'.date('Ymd').'00005.xls';   ### 遠端檔案
$local_file = 'localfile.xls';   ### 本機儲存檔案名稱
 
$handle = fopen($local_file, 'w');
 
### 連接的 FTP 伺服器是 localhost
$conn_id = ftp_connect('rema.hopto.org');
 
### 登入 FTP, 帳號是 USERNAME, 密碼是 PASSWORD
$login_result = ftp_login($conn_id, 'rema', 'rema2016');

### 切換目錄
ftp_chdir($conn_id,"ExportData");

### 輸出當前目錄
/*echo "Dir: ".ftp_pwd($conn_id);
echo "<br />";*/

### 輸出文件
$xlslist = ftp_nlist($conn_id, ".");
$nums = count($xlslist);
$remote_file = $xlslist[$nums-1];
foreach($xlslist AS $kk=>$files){
	if($files !=  $remote_file){
		@ftp_delete($conn_id, $files);
	}
}

//*檢測最後一次檔案是否已經載入過*//
$msql->query("SELECT * FROM {P}_shop_update_log WHERE `loadname`='{$remote_file}'");
if($msql->next_record()){
	exit($remote_file."此檔已經更新過！");
}

 
if (ftp_fget($conn_id, $handle, $remote_file, FTP_BINARY, 0)) {
    //echo "下載成功, 並儲存到 $local_file\n";
    ### 讀取檔案 
    $reader= PHPExcel_IOFactory::createReaderForFile($local_file);
	$reader->setReadDataOnly(true);
	$PHPExcel = $reader->load($local_file); // 檔案名稱 需已經上傳到主機上
	$sheet = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
	$highestRow = $sheet->getHighestRow(); // 取得總列數
	//echo '總共 '.$highestRow.' 列';
	// 一次讀取一列
	for ($row = 1; $row <= $highestRow; $row++) {
	    /*for ($column = 0; $column <= 2; $column++) {//看你有幾個欄位 此範例為 13 個位
	        $val = $sheet->getCellByColumnAndRow($column, $row)->getValue();
	        echo $val.' ';
	    }*/
	    $getall[] = array($sheet->getCellByColumnAndRow(0, $row)->getValue()=>$sheet->getCellByColumnAndRow(1, $row)->getValue());
	    //echo "<br />";
	}
	
		//更新庫存
		$snum = $enum = $lnum = 0;
	    foreach($getall AS $kk=>$vvs){
	    	if($kk>0){
	    		$keys = key($vvs);
	    		$stocks = $vvs[$keys];
	    		$poskeyarray[] = $keys;
	    		$msql->query("SELECT * FROM {P}_shop_conspec WHERE `posproid`='{$keys}'");
	    		if($msql->next_record()){
	    			$success .= $success? ",".$keys."(".$stocks.")":$keys."(".$stocks.")";
	    			$msql->query("UPDATE {P}_shop_conspec SET `stocks`='{$stocks}' WHERE `posproid`='{$keys}'");
	    			//更新總庫存
	    			$gid = $msql->f("gid");
	    			$totals = $fsql->getone("SELECT SUM(stocks) FROM {P}_shop_conspec WHERE `gid`='{$gid}'");
			    	$alltotal = $totals['SUM(stocks)']==""? "0":$totals['SUM(stocks)'];
			    	$tsql->query("UPDATE {P}_shop_con SET `kucun`='{$alltotal}' WHERE `id`='{$gid}'");
	    			$snum++;
	    		}else{
	    			//POS有，資料庫無記錄
	    			$gid = "";
	    			$error .= $error? ",".$keys:$keys;
	    			$enum++;
	    		}
	    	}
	    }
	    //資料庫有，但POS記錄
	    $msql->query("SELECT posproid FROM {P}_shop_conspec");
	    while($msql->next_record()){
	    	$posproid = $msql->f("posproid");
	    	if(in_array($posproid, $poskeyarray)){
	    		//
	    	}else{
	    		//應該是 POS 0庫存不匯出
	    		$poslost .= $poslost? ",".$posproid:$posproid;
	    		$lnum++;
	    	}
	    }
	    
	    //庫存更新紀錄
	    $nowtime = time();
	    //先清空
	    $msql->query("TRUNCATE TABLE `{P}_shop_update_log`");
	    //再寫入
	    $msql->query("INSERT INTO {P}_shop_update_log SET `success`='{$success}',`error`='{$error}',`poslost`='{$poslost}',`uptime`='{$nowtime}',`snum`='{$snum}',`enum`='{$enum}',`lnum`='{$lnum}',`loadname`='{$remote_file}' ");
	    
	    //更新總庫存
	    /*$msql->query("SELECT id FROM {P}_shop_con WHERE `ifpic`='0'");
	    while($msql->next_record()){
	    	$gid = $msql->f("id");
	    	$totals = $fsql->getone("SELECT SUM(stocks) FROM {P}_shop_conspec WHERE `gid`='{$gid}'");
	    	$alltotal = $totals['SUM(stocks)']==""? "0":$totals['SUM(stocks)'];
	    	$tsql->query("UPDATE {P}_shop_con SET `kucun`='{$alltotal}' WHERE `id`='{$gid}'");
	    }*/
	    
	    
	echo "<pre>";
		echo $remote_file."庫存更新完畢！";
		//var_dump($getall);
	echo "</pre>";
} else {
    echo "下載 $remote_file 到 $local_file 失敗\n";
}
 
ftp_close($conn_id);
fclose($handle);
?>